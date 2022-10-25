<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

/**
 * Service class for retrieving and parsing API data.
 */
class CityService
{

    private function getWeatherApi($cityName)
    {
        return Config::get('app.api_base_url') . Config::get('app.api_endpoint') . $cityName . Config::get('app.api_get_request_params');
    }

    protected function fetchDataFromApi($cityName)
    {
        return json_decode(file_get_contents($this->getWeatherApi($cityName)));
    }

    protected function getCityJsonFile()
    {
        return json_decode(file_get_contents(storage_path(Config::get('app.cities_storage_data_path'))));
    }

}
