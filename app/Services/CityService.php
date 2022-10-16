<?php

namespace App\Services;

/**
 * Service class for retrieving and parsing API data.
 */
class CityService
{

    private const API_BASE_URL = 'https://api.openweathermap.org/data/2.5/';
    private const API_ENDPOINT = 'weather?q=';
    private const API_GET_REQUEST_PARAMS = '&units=imperial&appid=895284fb2d2c50a520ea537456963d9c';
    private const STORAGE_DATA_PATH = 'app/public/city_data.json';

    private function getWeatherApi($cityName)
    {
        return self::API_BASE_URL . self::API_ENDPOINT . $cityName . self::API_GET_REQUEST_PARAMS;
    }

    protected function fetchDataFromApi($cityName) {
        return json_decode(file_get_contents($this->getWeatherApi($cityName)));
    }

    protected function getCityJsonFile()
    {
        return json_decode(file_get_contents(storage_path(self::STORAGE_DATA_PATH)));
    }

}
