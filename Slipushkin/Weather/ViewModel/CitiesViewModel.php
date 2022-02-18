<?php

namespace Slipushkin\Weather\ViewModel;

use Slipushkin\Weather\Model\Config\Config;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CitiesViewModel implements ArgumentInterface
{
    /**
     * @var Config
     */
    private Config $config;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @param Config $config
     * @param Json $json
     */
    public function __construct(
        Config $config,
        Json $json
    ) {
        $this->config = $config;
        $this->json = $json;
    }

    /**
     * @return bool|string
     */
    public function getCitiesAsJson()
    {
        $data = $this->config->getCities();
        $cities = [];
        foreach ($data as $item) {
            $cities[] = ['city' => $item['city'], 'country' => $item['country']];
        }
        return $this->json->serialize($cities);
    }
}
