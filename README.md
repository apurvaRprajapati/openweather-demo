# openweather-demo

Note:-
- Please refer docker-compose.yml for database cred

# Installation steps
- Download this repo in your local
- docker build -t openweather-app/app .
- docker-compose up
- docker-compose exec app composer install
- docker-compose exec app npm install
- docker-compose exec app php artisan migrate
- docker-compose exec app npm run dev

# To run unit test cases
docker-compose exec app vendor/bin/phpunit
- textcase file tests/CityTest.php

# Default data load in database after application is running
- http://localhost/api/addWeatherDataInDatabase
  Hit this url to dump data into the database from openweathermap

Small description regarding application 
- Once your environment will be setup application will be run on http://localhost
- I have used opensource code to build this app 
- Please create user by register module - http://localhost/register
- then login into the system
- first page will have default data loaded into the list (http://localhost/api/addWeatherDataInDatabase if not run before please hit this url in browser)
- there is two button one for city's todays weather and other is for five day forecast of city
- on click of it you will get result in the list
