<?php

declare(strict_types=1);

namespace Slipushkin\Weather\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Weather extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('slipushkin_weather', 'id');
    }
}
