<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\CityService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        // Get names of cities from json.
        $cities = CityService::getCityName(CityService::parseJsonData(CityService::getCityDataPath())->cities, []);

        // Get the weather data for every of the cities.
        $cityWeather = CityService::getCityWeather($cities);

        $citiesAndWeatherData = array_combine($cities, $cityWeather);

        // Update data in the database.
        City::updateCityByNameOrCreate($citiesAndWeatherData);

        // Send for rendering to the view.
        return view('cities', ['cities' => City::all()]);

    }
}
