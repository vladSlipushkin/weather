<?php

namespace Slipushkin\Weather\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const API_KEY_PATH = 'weather/general/api_key';
    const UNIT_PATH = 'weather/general/unit';
    const CITIES_PATH = 'weather/general/cities';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $config;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @param ScopeConfigInterface $config
     */
    public function __construct(
        ScopeConfigInterface $config,
        Json $json
    ) {
        $this->config = $config;
        $this->json = $json;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->config->getValue(self::API_KEY_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->config->getValue(self::UNIT_PATH, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return array
     */
    public function getCities(): array
    {
        $data = $this->config->getValue(self::CITIES_PATH, ScopeInterface::SCOPE_STORE);
        if (!$data) {
            return [];
        }
        return $this->json->unserialize($data);
    }
}
