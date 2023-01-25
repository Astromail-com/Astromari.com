<?php

namespace Invertus\Printify\Api;

use Configuration;
use GuzzleHttp\Client;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Factory\HttpClientFactory;

/**
 * Class PrintifyApiInterface
 * @package Invertus\Printify\Api
 */
abstract class PrintifyApi
{
    /**
     * @var Client
     */
    public $client;

    public $idShop;

    /**
     * WebHookApi constructor.
     * @param HttpClientFactory $httpClientFactory
     */
    public function __construct(HttpClientFactory $httpClientFactory)
    {
        /**
         * @todo move to yaml and avoid "interface"
         */
        $this->client = $httpClientFactory->getHttpClient();
        $this->idShop = Configuration::get(Config::ID_SHOP);
    }
}
