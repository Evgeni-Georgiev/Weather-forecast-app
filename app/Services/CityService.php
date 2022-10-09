<?php

namespace App\Services;

/**
 * Service class for holding all the loading for fetching, rendering and saving data to the database.
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
     * parse JSON Data from local file
     * @return mixed
     */
    public static function parseJsonData($response_data)
    {
//        $path = storage_path('app/public/city_data.json');
        $json_data = json_decode(file_get_contents($response_data));
        return $json_data;
    }

    /*
     * Iterate the retrieved data from the object, save all city names in an array
     * Children cities solution: Recursive function for fetching the city names and children
     * @param $cities
     * @return array
     */
    public static function getCityName($cities, array $array_holding_cities)
    {
        foreach ($cities as $city) {
            $cityName = $city->name;
            $array_holding_cities[] = $cityName;
            if (isset($city->children)) {
//                    $arr_with_cities = CityService::getCityName($city->children, array_values(array_holding_cities));
                $array_holding_cities = CityService::getCityName($city->children, $array_holding_cities);
            }
        }
        return $array_holding_cities;
    }

    /**
     * Get data for current city from API and decode it as an object
     * @param $cityNames
     * @return mixed
     */
    public static function getCityWeather()
    {
        $array_holding_city_names = CityService::getCityName(CityService::parseJsonData(CityService::getCityDataPath())->cities, []);
        $arr_hold_weather = [];
        foreach($array_holding_city_names as $cityName) {
//            $arr_hold_weather[] = self::getJsonData(self::getWeatherApi($cityName))->weather[0]->description;
            $arr_hold_weather[] = self::parseJsonData(self::getWeatherApi($cityName));
        }

        return $arr_hold_weather;
    }

}
