<?php

namespace Slipushkin\Weather\Api;

use Slipushkin\Weather\Api\Data\WeatherSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Slipushkin\Weather\Api\Data\WeatherInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface WeatherRepositoryInterface
{
    /**
     * @param int $id
     * @return WeatherInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): WeatherInterface;

    /**
     * @param WeatherInterface $weather
     * @return WeatherInterface
     */
    public function save(WeatherInterface $weather): WeatherInterface;

    /**
     * @param WeatherInterface $weather
     * @return void
     */
    public function delete(WeatherInterface $weather);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return WeatherSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): WeatherSearchResultInterface;
}
