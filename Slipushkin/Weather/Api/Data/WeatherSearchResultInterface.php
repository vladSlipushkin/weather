<?php

namespace Slipushkin\Weather\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface WeatherSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return WeatherInterface[]
     */
    public function getItems();

    /**
     * @param WeatherInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
