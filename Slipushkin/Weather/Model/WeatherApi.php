<?php

declare(strict_types=1);

namespace Slipushkin\Weather\Model;

use Slipushkin\Weather\Api\Data\WeatherInterface;
use Slipushkin\Weather\Model\Config\Config;
use Psr\Log\LoggerInterface;
use Magento\Framework\HTTP\Client\Curl;
use Slipushkin\Weather\Api\Data\WeatherInterfaceFactory;
use Magento\Framework\Serialize\Serializer\Json;

class WeatherApi
{
    const URI = 'https://api.openweathermap.org/data/2.5/weather';
    const REQUEST_TIMEOUT = 5;

    /**
     * @var Curl
     */
    private Curl $curl;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var WeatherInterfaceFactory
     */
    private WeatherInterfaceFactory $weatherFactory;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @param LoggerInterface $logger
     * @param Curl $curl
     * @param WeatherInterfaceFactory $weatherFactory
     * @param Json $json
     * @param Config $config
     */
    public function __construct(
        LoggerInterface $logger,
        Curl $curl,
        WeatherInterfaceFactory $weatherFactory,
        Json $json,
        Config $config
    ) {
        $this->curl = $curl;
        $this->logger = $logger;
        $this->weatherFactory = $weatherFactory;
        $this->json = $json;
        $this->config = $config;
    }

    /**
     * @param string $city
     * @param string $country
     * @return WeatherInterface|null
     */
    public function getWeatherByCity(string $city, string $country): ?WeatherInterface
    {
        $url = $this->createUrl(
            self::URI,
            [
                'appid' => $this->config->getApiKey(),
                'units' => $this->config->getUnit(),
                'q' => sprintf('%s,%s', $city, $country)
            ]
        );
        $this->curl->setTimeout(self::REQUEST_TIMEOUT);
        $this->curl->get($url);

        if ($this->curl->getStatus() !== 200) {
            $this->logger->warning('API Status: ', [$this->curl->getStatus()]);
            return null;
        }

        $data = $this->curl->getBody();
        $data = $this->json->unserialize($data);

        /** @var WeatherInterface $weather */
        $weather = $this->weatherFactory->create();
        $weather->setCity($city);
        $weather->setCountry($country);
        $weather->setTemperature($data['main']['temp']);
        $weather->setPressure($data['main']['pressure']);

        return $weather;
    }

    /**
     * @param string $baseUrl
     * @param array $params
     * @return string
     */
    private function createUrl(string $baseUrl, array $params = []): string
    {
        $paramUrl = '';
        foreach ($params as $param => $value) {
            $paramUrl .= sprintf('%s=%s&', $param, $value);
        }
        $paramUrl = trim($paramUrl, '&');
        return sprintf('%s?%s', $baseUrl, $paramUrl);
    }
}
