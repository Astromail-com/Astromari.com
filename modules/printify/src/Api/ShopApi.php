<?php

namespace Invertus\Printify\Api;

use Exception;
use Invertus\Printify\Factory\HttpClientFactory;

class ShopApi extends PrintifyApi
{
    /**
     * @var TokenApi
     */
    private $tokenApi;

    /**
     * @param HttpClientFactory $httpClientFactory
     * @param TokenApi $tokenApi
     */
    public function __construct(HttpClientFactory $httpClientFactory, TokenApi $tokenApi)
    {
        parent::__construct($httpClientFactory);
        $this->tokenApi = $tokenApi;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getShops()
    {
        $response = $this->client->get(
            '/v1/shops.json',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                )
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param int $shopId
     * @return string
     * @throws Exception
     */
    public function disconnectPritifyShop($shopId)
    {
        $response = $this->client->delete(
            '/v1/shops/' . (string) $shopId . '/connection.json',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                )
            )
        );

        return $response->getBody()->getContents();
    }
}
