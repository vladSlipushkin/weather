<?php

namespace Slipushkin\Weather\Api;

use Slipushkin\Weather\Api\Data\WeatherInterface;

/**
* @api
*/
interface WeatherManagementInterface
{
    /**
     * @param string $city
     * @param string $country
     * @return WeatherInterface
     */
    public function getWeather(string $city, string $country): ?WeatherInterface;
}
