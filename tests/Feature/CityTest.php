<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\User;
use Tests\TestCase;

class CityTest extends TestCase
{
    
    /** @test */
    public function fetch_default_data()
    {
        $this->actingAs(User::factory()->create())
            ->getJson('/api/fetchDefaultData')
            ->assertSuccessful();
    }

    /** @test */
    public function fetch_city_weather()
    {
        $this->actingAs(User::factory()->create())
            ->getJson('/api/fetchWeather/london')
            ->assertSuccessful();
    }

    /** @test */
    public function fetch_city_forecast()
    {
        $this->actingAs(User::factory()->create())
            ->getJson('/api/fetchForecast/london')
            ->assertSuccessful();
    }

    
}
