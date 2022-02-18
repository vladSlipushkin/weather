<?php

declare(strict_types=1);

namespace Slipushkin\Weather\Cron;

use Slipushkin\Weather\Api\WeatherRepositoryInterface;
use Slipushkin\Weather\Model\Config\Config;
use Psr\Log\LoggerInterface;
use Slipushkin\Weather\Model\WeatherApi;

class Update
{
    /**
     * @var WeatherApi
     */
    private WeatherApi $weatherApi;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @param WeatherApi $weatherApi
     * @param LoggerInterface $logger
     * @param WeatherRepositoryInterface $weatherRepository
     * @param Config $config
     */
    public function __construct(
        WeatherApi $weatherApi,
        LoggerInterface $logger,
        WeatherRepositoryInterface $weatherRepository,
        Config $config
    ) {
        $this->weatherApi = $weatherApi;
        $this->logger = $logger;
        $this->weatherRepository = $weatherRepository;
        $this->config = $config;
    }

    /**
     * @return $this
     */
    public function execute(): self
    {
        $cities = $this->config->getCities();
        foreach ($cities as $item) {
            $weather = $this->weatherApi->getWeatherByCity($item['city'], $item['country']);

            if (null === $weather) {
                continue;
            }

            try {
                $this->weatherRepository->save($weather);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }

        return $this;
    }
}
