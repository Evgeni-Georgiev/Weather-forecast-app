<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\CityService;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        CityService::fetchCityData();

        $all_cities = City::all();

        return view('cities', compact('all_cities'));

    }
}
