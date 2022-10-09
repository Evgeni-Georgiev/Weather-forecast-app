<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\CityService;
use App\Services\UpdateWeatherService;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // 1.TODO: return data from json as array only name of cities -- asses to name of the method
        $getNamesOfCitiesFromJson = CityService::getCityName(CityService::parseJsonData(CityService::getCityDataPath())->cities, []);

        // 2.TODO: having the cities -- get the weather data for every of the cities ,result :array with the city and weather data -- send to the view
        $getWeatherForACityFromApi = CityService::getCityWeather();
        $array_with_city_and_weather_data = array_combine($getNamesOfCitiesFromJson, $getWeatherForACityFromApi);

        // 3.TODO: having all data fetched, send to service to update them in the db
        UpdateWeatherService::getCityByNameOrCreate($array_with_city_and_weather_data);

        // 4.TODO: send for rendering to the view
        // reformat

        // will not need
        $all_cities = City::all();

        return view('cities', compact('all_cities'));

    }
}
