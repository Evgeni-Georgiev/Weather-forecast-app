<?php

namespace App\Services;

use InvalidArgumentException;

/**
 * Service class for retrieving and parsing API data.
 */
class CityService implements ICityService
{
    private const API_BASE_URL = 'https://api.openweathermap.org/data/2.5/';
    private const API_ENDPOINT = 'weather?q=';
    private const API_GET_REQUEST_PARAMS = '&units=imperial&appid=895284fb2d2c50a520ea537456963d9c';
    private const STORAGE_DATA_PATH = 'app/public/city_data.json'; // file is not committed

    private array $cityNames;

    public function __construct()
    {
        $citiesJsonFileData = $this->parseJsonLocalFileData();

        $citiesHolder = [];
        $this->cityNames = $this->getCityNames($citiesJsonFileData, $citiesHolder);
    }


    private function getWeatherApiUrl($cityName): string
    {
        return self::API_BASE_URL . self::API_ENDPOINT . $cityName . self::API_GET_REQUEST_PARAMS;
    }

    /**
     * Parse JSON Data from local file.
     * @return mixed
     */
    private function parseJsonLocalFileData(): mixed
    {
        $file_path = storage_path(self::STORAGE_DATA_PATH);
        return json_decode(file_get_contents($file_path));
    }

    /**
     * @param $cityName string city name to fetch data from API
     * @return mixed
     */
    private function sendRestCallAndFetchData(string $cityName): mixed
    {
        return json_decode(file_get_contents($this->getWeatherApiUrl($cityName)));
    }

    /**
     * Recursively parse all city names from the local JSON file.
     * @param $cities array cities from the json file
     * @param $citiesHolder array holding parsed cities, used for recursion calls
     * @return array containing all parsed city names
     */
    private function getCityNames(array $cities, array $citiesHolder): array
    {
        foreach ($cities as $city) {
            $cityName = $city->name;
            $citiesHolder[] = $cityName;
            if (isset($city->children)) {
                $citiesHolder = CityService::getCityNames($city->children, $citiesHolder);
            }
        }
        return $citiesHolder;
    }

    /**
     * Get whether data for all cities from API.
     * @return array
     */
    public function getAllCitiesWeatherStatuses(): array
    {
        $weatherHolder = [];

        foreach ($this->cityNames as $cityName) {
            $weatherHolder[$cityName] = $this->getCityWeatherStatus($cityName);
        }

        return $weatherHolder;
    }

    /**
     * Fetches data from the API for a city.
     * @param $cityName string name of city to fetch data
     * @return mixed resulting data from API
     */
    public function getCityWeatherStatus($cityName): mixed
    {
        if (!in_array($cityName, $this->cityNames)) {
            throw new InvalidArgumentException("City is not in the list");
        }

        return $this->sendRestCallAndFetchData($cityName);
    }

}
