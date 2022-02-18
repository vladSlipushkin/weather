<?php

declare(strict_types=1);

namespace Slipushkin\Weather\Model\ResourceModel\Weather;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'slipushkin_weather_weather_collection';

    /**
     * @var string
     */
    protected $_eventObject = 'weather_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Slipushkin\Weather\Model\Weather::class,
            \Slipushkin\Weather\Model\ResourceModel\Weather::class
        );
    }
}
