<?php

namespace Invertus\Printify\Api;

use Exception;
use Invertus\Printify\Factory\HttpClientFactory;

class OrderApi extends PrintifyApi
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
     * @param $body
     * @return string
     * @throws Exception
     */
    public function submitOrder($body)
    {
        $response = $this->client->post(
            '/v1/shops/' . $this->idShop . '/orders.json',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                ),
                'body' => $body
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param $idOrder
     * @return string
     * @throws Exception
     */
    public function fulfillOrder($idOrder)
    {
        $response = $this->client->post(
            '/v1/shops/' . $this->idShop . '/orders/' . $idOrder .'/send_to_production.json',
            array(
                'headers' => array(
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                ),
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param $idOrder
     * @return string
     * @throws Exception
     */
    public function getOrder($idOrder)
    {
        $response = $this->client->get(
            '/v1/shops/' . $this->idShop . '/orders/' . $idOrder .'.json',
            array(
                'headers' => array(
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                ),
            )
        );

        return $response->getBody()->getContents();
    }
}
