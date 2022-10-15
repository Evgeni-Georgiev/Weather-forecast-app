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

    private array $cityNames;

    public function __construct()
    {
        $cityHolder = [];
        $this->cityNames = $this->getCityName($this->parseJsonData()->cities, $cityHolder);
    }

    private function getWeatherApi($cityName)
    {
        return self::API_BASE_URL . self::API_ENDPOINT . $cityName . self::API_GET_REQUEST_PARAMS;
    }

    /**
     * Parse JSON Data from local file.
     * @return mixed
     */
    private function parseJsonData()
    {
        return json_decode(file_get_contents(self::STORAGE_DATA_PATH));
    }


    /**
     * @param $cityName string city name to fetch data from API
     * @return mixed
     */
    private function fetchDataFromApi(string $cityName): mixed
    {
        return json_decode(file_get_contents($this->getWeatherApi($cityName)));
    }

    /*
     * Recursively get all cities.
     * @param $cities
     * @return array
     */
    private function getCityName($cities, $citiesHolder)
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
        foreach ($this->cityNames as $cityName) {
            $weatherHolder[$cityName] = $this->fetchDataFromApi($cityName);
        }

        return $weatherHolder;
    }

}
