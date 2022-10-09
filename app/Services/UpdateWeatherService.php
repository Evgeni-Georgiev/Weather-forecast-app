<?php
namespace App\Services;

use App\Models\City;
use Illuminate\Support\Facades\DB;

class UpdateWeatherService {

    public static function getCityByNameOrCreate($array_with_city_and_weather_data) {

        foreach($array_with_city_and_weather_data as $key => $value) {
            City::firstOrCreate(
                ['name' => $key],
                ['forecast' => $value->weather[0]->description],
                ['temperature' => $value->main->temp],
                ['feels_like' => $value->main->feels_like],
                ['temp_min' => $value->main->temp_min],
                ['temp_max' => $value->main->temp_max],
                ['pressure' => $value->main->pressure],
                ['humidity' => $value->main->humidity]
            );
        }

    }

}
