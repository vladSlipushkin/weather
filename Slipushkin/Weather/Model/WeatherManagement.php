<?php

namespace Slipushkin\Weather\Model;

use Slipushkin\Weather\Api\Data\WeatherInterface;
use Slipushkin\Weather\Api\WeatherManagementInterface;
use Slipushkin\Weather\Api\WeatherRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;

/**
 * @api
 */
class WeatherManagement implements WeatherManagementInterface
{
    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    private SortOrderBuilder $sortOrderBuilder;

    /**
     * @param WeatherRepositoryInterface $weatherRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        WeatherRepositoryInterface $weatherRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->weatherRepository = $weatherRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @param string $city
     * @param string $country
     * @return WeatherInterface|null
     */
    public function getWeather(string $city, string $country): ?WeatherInterface
    {
        $this->searchCriteriaBuilder->addFilter(weatherInterface::CITY, $city, 'eq');
        $this->searchCriteriaBuilder->addFilter(weatherInterface::COUNTRY, $country, 'eq');
        $this->searchCriteriaBuilder->setPageSize(1)->setCurrentPage(1);
        $sortOrder = $this->sortOrderBuilder->setField('created_at')
            ->setDirection('DESC')
            ->create();
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $items = $this->weatherRepository->getList($searchCriteria)->getItems();

        return reset($items);
    }
}
