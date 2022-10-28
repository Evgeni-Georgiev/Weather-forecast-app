<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

/**
 * Service class for retrieving and parsing API data.
 */
class CityService
{
    private const API_ENDPOINT = 'weather?q=';
    private const API_GET_REQUEST_PARAMS = '&units=imperial&appid=895284fb2d2c50a520ea537456963d9c';

    private function getWeatherApi($cityName)
    {
        return Config::get('app.api_base_url') . self::API_ENDPOINT . $cityName . self::API_GET_REQUEST_PARAMS;
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
