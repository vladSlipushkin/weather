<?php

declare(strict_types=1);

namespace Slipushkin\Weather\Model;

use Slipushkin\Weather\Api\Data\WeatherInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Slipushkin\Weather\Api\Data\WeatherExtensionInterface;

class Weather extends AbstractExtensibleModel implements WeatherInterface
{
    const CACHE_TAG = 'slipushkin_weather_weather';

    /**
     * @var string
     */
    protected $_cacheTag = 'slipushkin_weather_weather';

    /**
     * @var string
     */
    protected $_eventPrefix = 'slipushkin_weather_weather';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Weather::class);
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues(): array
    {
        $values = [];

        return $values;
    }

    /**
     * @return mixed|string|null
     */
    public function getCity()
    {
        return $this->_getData(self::CITY);
    }

    /**
     * @param $city
     * @return void
     */
    public function setCity($city)
    {
        $this->setData(self::CITY, $city);
    }

    /**
     * @return mixed|string|null
     */
    public function getCountry()
    {
        return $this->_getData(self::COUNTRY);
    }

    /**
     * @param $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->setData(self::COUNTRY, $country);
    }

    /**
     * @return mixed|string|null
     */
    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @param $date
     * @return void
     */
    public function setCreatedAt($date)
    {
        $this->setData(self::CREATED_AT, $date);
    }

    /**
     * @return mixed|null
     */
    public function getTemperature()
    {
        return $this->_getData(self::TEMPERATURE);
    }

    /**
     * @param $date
     * @return mixed|void
     */
    public function setTemperature($date)
    {
        $this->setData(self::TEMPERATURE, $date);
    }

    /**
     * @return mixed|null
     */
    public function getPressure()
    {
        return $this->_getData(self::PRESSURE);
    }

    /**
     * @param $date
     * @return mixed|void
     */
    public function setPressure($date)
    {
        $this->setData(self::PRESSURE, $date);
    }

    /**
     * @return mixed|null
     */
    public function getHumidity()
    {
        return $this->_getData(self::HUMIDITY);
    }

    /**
     * @param $date
     * @return mixed|void
     */
    public function setHumidity($date)
    {
        $this->setData(self::HUMIDITY, $date);
    }

    /**
     * @return ExtensionAttributesInterface|null
     */
    public function getExtensionAttributes(): ?ExtensionAttributesInterface
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @param WeatherExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(WeatherExtensionInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
