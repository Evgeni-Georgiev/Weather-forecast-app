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

    private $cityName;

    public function __construct() {
        $citiesHolder = [];
        $this->cityName = $this->getCityName($this->getCityJsonFile()->cities, $citiesHolder);
    }

    public function getWeatherApi($cityName)
    {
        return self::API_BASE_URL . self::API_ENDPOINT . $cityName . self::API_GET_REQUEST_PARAMS;
    }

    public function fetchDataFromApi($cityName) {
        return json_decode(file_get_contents($this->getWeatherApi($cityName)));
    }

    public function getCityJsonFile()
    {
        return json_decode(file_get_contents(storage_path(self::STORAGE_DATA_PATH)));
    }

    /*
     * Recursively get all cities.
     * @param $cities
     * @return array
     */
    public function getCityName($cities, $citiesHolder)
    {
        foreach ($cities as $city) {
            $cityName = $city->name;
            $citiesHolder[] = $cityName;
            if (isset($city->children)) {
                $citiesHolder = CityService::getCityName($city->children, $citiesHolder);
            }
        }
        return $citiesHolder;
    }

    /**
     * Get data for city from API.
     * @param $cityNames
     * @return mixed
     */
    public function getCityWeather()
    {
        $weatherHolder = [];
        foreach ($this->cityName as $cityName) {
            $weatherHolder[$cityName] = $this->fetchDataFromApi($cityName);
        }

        return $weatherHolder;
    }

}
