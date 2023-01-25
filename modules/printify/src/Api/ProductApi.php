<?php

namespace Invertus\Printify\Api;

use Exception;
use Invertus\Printify\Factory\HttpClientFactory;

class ProductApi extends PrintifyApi
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
     * @param $idProduct
     * @return string
     * @throws Exception
     */
    public function getProduct($idProduct)
    {
        $response = $this->client->get(
            '/v1/shops/' . $this->idShop . '/products/' . $idProduct .'.json',
            array(
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                )
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param $idProduct
     * @param $idProductPs
     * @param $handle
     * @return string
     * @throws Exception
     */
    public function publishSuccess($idProduct, $idProductPs, $handle)
    {
        $response = $this->client->post(
            '/v1/shops/' . $this->idShop . '/products/' . $idProduct .'/publishing_succeeded.json',
            array(
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                ),
                'body' => json_encode(
                    array(
                        'external' => array(
                            'id' => (string) $idProductPs,
                            'handle' => $handle
                        )
                    )
                )
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param $idProduct
     * @param $reason
     * @return string
     * @throws Exception
     */
    public function publishFailure($idProduct, $reason)
    {
        $response = $this->client->post(
            '/v1/shops/' . $this->idShop . '/products/' . $idProduct .'/publishing_failed.json',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                ),
                'query' => array(
                    'reason' => $reason
                )
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param $idProduct
     * @param $reason
     * @return string
     * @throws Exception
     */
    public function unpublish($idProduct)
    {
        $response = $this->client->post(
            '/v1/shops/' . $this->idShop . '/products/' . $idProduct .'/unpublish.json',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                ),
            )
        );

        return $response->getBody()->getContents();
    }
}
