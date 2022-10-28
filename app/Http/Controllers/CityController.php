<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\CityInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CityController extends Controller
{

    private CityInterface $weatherService;
    private City $cityModel;

    public function __construct(CityInterface $weatherService, City $cityModel) {
        $this->weatherService = $weatherService;
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
        $cityWeather = $this->weatherService->getCityWeather();

        // Update data in the database.
        $this->cityModel->updateCityByNameOrCreate($cityWeather);

        // Send for rendering to the view.
        return view('cities', ['cities' => City::all()]);

    }
}
