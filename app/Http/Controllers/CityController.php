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
        // Return data from json as array only name of cities -- asses to name of the method.
        $cities = CityService::getCityName(CityService::parseJsonData(CityService::getCityDataPath())->cities, []);

        // Having the cities -- get the weather data for every of the cities ,result :array with the city and weather data -- send to the view.
        $cityWeather = CityService::getCityWeather();

        //  CamelCase or snakeCase -- Laravel convention is CamelCase.
        $citiesAndWeatherData = array_combine($cities, $cityWeather);

        // having all data fetched, send to service to update them in the db.
        City::updateCityByNameOrCreate($citiesAndWeatherData);

        // Send for rendering to the view.
        return view('cities', ['cities' => City::all()]);

    }
}
