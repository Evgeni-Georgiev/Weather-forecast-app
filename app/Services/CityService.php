<?php

namespace App\Services;

use App\Models\City;

/**
 * Service class for holding all the loading for fetching, rendering and saving data to the database.
 */
class CityService
{
    /**
     * parse JSON Data from lacal file
     * @return mixed
     */
    private static function getJsonData()
    {
        $path = storage_path('app/public/city_data.json');
        $json_data = json_decode(file_get_contents($path));
        return $json_data;
    }

    /**
     * Get data for current city from API and decode it as an object
     * @param $cityName
     * @return mixed
     */
    private static function getCityWeather($cityName)
    {
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$cityName&units=imperial&appid=895284fb2d2c50a520ea537456963d9c";
        $weatherData = json_decode(file_get_contents($apiUrl));
        return $weatherData->weather[0]->description;
    }

    /**
     * Iterate the retrieved data from the object, save all city names in an array
     * Children cities solution: Recursive function for fetching the city names and children
     * @param $cities
     * @return void
     */
    private static function getCityName($cities)
    {
        foreach ($cities as $city) {
            $cityName = $city->name;
            HelperGlobal::$towns[] = $cityName;
            if (isset($city->children)) {
                CityService::getCityName($city->children);
            }
        }
    }

    /**
     *
     * @return void
     */
    public static function fetchCityData()
    {
        // CityService::getJsonData() -> cities -- returns an object "cities"
        // CityService::getCityName() -> iterates the object recursively and populates and outer array with the results(names of the cities)
        CityService::getCityName(CityService::getJsonData()->cities);
        // if data exists(old data) in db, delete ir from the db
        if (City::where('id', '>', 0)->get('id')) {
            City::where('id', '>', 0)->delete();
        }

        // then fill the db with the newest data from the API
        foreach (HelperGlobal::$towns as $town) {
            $WeatherForecast = City::create(['name' => $town, 'forecast' => CityService::getCityWeather($town)]);
            $WeatherForecast->save();
        }
    }

}
