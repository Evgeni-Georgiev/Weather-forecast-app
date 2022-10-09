<?php

namespace App\Services;

/**
 * Service class for retrieving and parsing API data.
 */
class CityService
{

    public static function getWeatherApi($cityName) {
        return "https://api.openweathermap.org/data/2.5/weather?q=$cityName&units=imperial&appid=895284fb2d2c50a520ea537456963d9c";
    }

    public static function getCityDataPath() {
        return storage_path('app/public/city_data.json');
    }

    /**
     * parse JSON Data from local file.
     * @return mixed
     */
    public static function parseJsonData($response_data)
    {
        $jsonData = json_decode(file_get_contents($response_data));
        return $jsonData;
    }

    /*
     * Recursively get all cities.
     * @param $cities
     * @return array
     */
    public static function getCityName($cities, $citiesHolder)
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
    public static function getCityWeather()
    {
        $cities = CityService::getCityName(CityService::parseJsonData(CityService::getCityDataPath())->cities, []);
        $weatherHolder = [];
        foreach($cities as $cityName) {
            $weatherHolder[] = self::parseJsonData(self::getWeatherApi($cityName));
        }

        return $weatherHolder;
    }

}
