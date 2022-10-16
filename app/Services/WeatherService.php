<?php

namespace App\Services;

class WeatherService extends CityService {

    private $cityName;

    public function __construct() {
        $citiesHolder = [];
        $this->cityName = $this->getCityName($this->getCityJsonFile()->cities, $citiesHolder);
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
                $citiesHolder = self::getCityName($city->children, $citiesHolder);
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
