<?php

namespace  Slipushkin\Weather\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ListUnits implements OptionSourceInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'imperial', 'label' => __('Imperial')],
            ['value' => 'metric', 'label' => __('Metric')]
        ];
    }
}
