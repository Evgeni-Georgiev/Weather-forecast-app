<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\CityService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CityController extends Controller
{

    private CityService $cityService;
    private City $cityModel;

    public function __construct(CityService $cityService, City $cityModel) {
        $this->cityService = $cityService;
        $this->cityModel = $cityModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        // Get the weather data for every of the cities.
        $cityWeather = $this->cityService->getCityWeather();

        // Update data in the database.
        $this->cityModel->updateCityByNameOrCreate($cityWeather);

        // Send for rendering to the view.
        return view('cities', ['cities' => City::all()]);

    }
}
