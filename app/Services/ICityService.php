<?php

namespace App\Services;

interface ICityService
{
    function getAllCitiesWeatherStatuses(): array;

    function getCityWeatherStatus($cityName);
}
