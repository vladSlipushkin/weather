<?php

namespace Slipushkin\Weather\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface WeatherInterface extends ExtensibleDataInterface
{
    const CITY       = 'city';
    const COUNTRY       = 'country';
    const CREATED_AT = 'created_at';
    const TEMPERATURE = 'temperature';
    const PRESSURE = 'pressure';
    const HUMIDITY = 'humidity';

    /**
     * @return string
     */
    public function getCity();

    /**
     * @param string $city
     * @return void
     */
    public function setCity($city);

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @param string $country
     * @return void
     */
    public function setCountry($country);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $date
     * @return void
     */
    public function setCreatedAt($date);

    /**
     * @return mixed
     */
    public function getTemperature();

    /**
     * @param $date
     * @return mixed
     */
    public function setTemperature($date);

    /**
     * @return mixed
     */
    public function getPressure();

    /**
     * @param $date
     * @return mixed
     */
    public function setPressure($date);

    /**
     * @return mixed
     */
    public function getHumidity();

    /**
     * @param $date
     * @return mixed
     */
    public function setHumidity($date);
}
