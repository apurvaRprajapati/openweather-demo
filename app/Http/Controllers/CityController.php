<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use App\Models\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        return response()->json([
            'data' => City::all()
        ], 200);
    }

    /**
     * Store default data into the database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse
    {
        //'london','mumbai','ahmedabad','chennai','pune'
        $cityIds = [2643743,1275339,1279233,1264527,1259229];
        $finalData = [];
        City::truncate();
        $response = Http::get('https://api.openweathermap.org/data/2.5/group', [
            'id' => '2643743,1275339,1279233,1264527,1259229', 
            'appid' => env('OPENWEATHER_APPID'),
        ]);

        if ($response->successful()) {
            $result = $response->json();
            foreach($result['list'] as $key => $value) {
                   
                $data = [
                        'name' => $value['name'],
                        'openweather_id' => $value['id'],
                        'main' => $value['weather'][0]['main'],
                        'description' => $value['weather'][0]['description'],
                        'visibility' => $value['visibility'],
                        'temp' => $value['main']['temp'],
                        'pressure' => $value['main']['pressure'],
                        'humidity' => $value['main']['humidity']
                ];

                $finalData[] = $data;
            }
        } 
        
        City::insert($finalData);

        return response()->json([
            'message' => 'Data inserted into database successfully',
            'data' => $finalData
        ], 200);
    }

    /**
     * fetch todays weather of city
     *
     * @param  string  $city
     * @return JsonResponse
     */
    public function show($city): JsonResponse
    {
        
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city, 
            'appid' => env('OPENWEATHER_APPID'),
        ]);
        
        if ($response->successful()) {
            $result = $response->json($key = null);
            $data = [
                'name' => $result['name'],
                'openweather_id' => $result['id'],
                'main' => $result['weather'][0]['main'],
                'description' => $result['weather'][0]['description'],
                'visibility' => $result['visibility'],
                'temp' => $result['main']['temp'],
                'pressure' => $result['main']['pressure'],
                'humidity' => $result['main']['humidity']
            ];
            return response()->json([
                'message' => 'success',
                'data' => array($data)
            ], 200);
        
        } else {

            return response()->json([
                'message' => 'error',
                'data' => []
            ], 200);
            
        }

    }

    /**
     * Fetch five dat forecast of city
     *
     * @param  string  $city
     * @return JsonResponse
     */
    public function fetchForecast($city):JsonResponse
    {   
        $finalData = [];
        
        $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
            'q' => $city, 
            'appid' => env('OPENWEATHER_APPID'),
        ]);
        
        if ($response->successful()) {
            $result = $response->json($key = null);
            
            $city = $result['city']['name'];
            $openweather_id = $result['city']['id'];
           
            foreach($result['list'] as $key => $value) {
                $data = [
                        'name' => $city,
                        'openweather_id' => $openweather_id,
                        'datetime' => date("Y-m-d g:i a",$value['dt']),
                        'main' => $value['weather'][0]['main'],
                        'description' => $value['weather'][0]['description'],
                        'visibility' => $value['visibility'],
                        'temp' => $value['main']['temp'],
                        'pressure' => $value['main']['pressure'],
                        'humidity' => $value['main']['humidity']
                ];

                $finalData[] = $data;
            }
            
            return response()->json([
                'message' => 'success',
                'data' => $finalData
            ], 200);
        
        } else {

            return response()->json([
                'message' => 'error',
                'data' => []
            ], 200);
            
        }
    }

    
}
