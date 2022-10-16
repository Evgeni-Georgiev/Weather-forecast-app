<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "id",
        "name",
        "forecast",
        "temperature",
        "feels_like",
        "temp_min",
        "temp_max",
        "pressure",
        "humidity"
    ];

    public function updateCityByNameOrCreate($array_with_city_and_weather_data)
    {

        foreach ($array_with_city_and_weather_data as $key => $value) {
            $return_city_record = City::firstOrCreate(
                ['name' => $key]
            );

            $return_city_record->forecast = $value->weather[0]->description;
            $return_city_record->temperature = $value->main->temp;
            $return_city_record->feels_like = $value->main->feels_like;
            $return_city_record->temp_min = $value->main->temp_min;
            $return_city_record->temp_max = $value->main->temp_max;
            $return_city_record->pressure = $value->main->pressure;
            $return_city_record->humidity = $value->main->humidity;

            $return_city_record->save();

        }

    }
}
