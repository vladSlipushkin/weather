<?php

namespace Slipushkin\Weather\Model;

use Slipushkin\Weather\Api\WeatherRepositoryInterface;
use Slipushkin\Weather\Api\Data\WeatherInterface;
use Slipushkin\Weather\Api\Data\WeatherSearchResultInterface;
use Slipushkin\Weather\Api\Data\WeatherSearchResultInterfaceFactory;
use Slipushkin\Weather\Model\ResourceModel\Weather\CollectionFactory as WeatherCollectionFactory;
use Slipushkin\Weather\Model\ResourceModel\Weather as WeatherResource;
use Slipushkin\Weather\Model\WeatherFactory as WeatherFactory;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class WeatherRepository implements WeatherRepositoryInterface
{
    /**
     * @var \Slipushkin\Weather\Model\WeatherFactory
     */
    private \Slipushkin\Weather\Model\WeatherFactory $weatherFactory;

    /**
     * @var WeatherCollectionFactory
     */
    private WeatherCollectionFactory $weatherCollectionFactory;

    /**
     * @var WeatherSearchResultInterfaceFactory
     */
    private WeatherSearchResultInterfaceFactory $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var WeatherResource
     */
    private WeatherResource $weatherResource;

    /**
     * @param \Slipushkin\Weather\Model\WeatherFactory $weatherFactory
     * @param WeatherCollectionFactory $weatherCollectionFactory
     * @param WeatherSearchResultInterfaceFactory $weatherSearchResultInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param WeatherResource $weatherResource
     */
    public function __construct(
        WeatherFactory $weatherFactory,
        WeatherCollectionFactory $weatherCollectionFactory,
        WeatherSearchResultInterfaceFactory $weatherSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor,
        WeatherResource $weatherResource
    ) {
        $this->weatherFactory = $weatherFactory;
        $this->weatherCollectionFactory = $weatherCollectionFactory;
        $this->searchResultFactory = $weatherSearchResultInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->weatherResource = $weatherResource;
    }

    /**
     * @param int $id
     * @return WeatherInterface|mixed
     * @throws NoSuchEntityException
     */
    public function getById(int $id): WeatherInterface
    {
        if (!isset($this->instances[$id])) {
            $weather = $this->weatherFactory->create();
            $this->weatherResource->load($weather, $id);
            if (!$weather->getId()) {
                throw new NoSuchEntityException(__('Weather does not exist'));
            }
            $this->instances[$id] = $weather;
        }

        return $this->instances[$id];
    }

    /**
     * @param WeatherInterface $weather
     * @return WeatherInterface
     * @throws CouldNotSaveException
     */
    public function save(WeatherInterface $weather): WeatherInterface
    {
        try {
            $this->weatherResource->save($weather);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the weather: %1', $exception->getMessage()));
        }

        return $weather;
    }

    /**
     * @param WeatherInterface $weather
     * @return bool
     * @throws CouldNotSaveException
     */
    public function delete(WeatherInterface $weather): bool
    {
        try {
            $this->weatherResource->delete($weather);
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save the weather: %1', $e->getMessage()));
        }

        return true;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return WeatherSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): WeatherSearchResultInterface
    {
        $collection = $this->weatherCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }
}
