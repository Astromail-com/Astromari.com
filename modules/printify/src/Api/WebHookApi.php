<?php

namespace Invertus\Printify\Api;

use Exception;
use Invertus\Printify\Factory\HttpClientFactory;

class WebHookApi extends PrintifyApi
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
     * @param $topic
     * @param $url
     * @return string
     * @throws Exception
     */
    public function registerWebHook($topic, $url)
    {
        $response = $this->client->post(
            '/v1/shops/' . $this->idShop . '/webhooks.json',
            array(
                'body' => json_encode(
                    array(
                        'topic' => $topic,
                        'url' => $url
                    )
                ),
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                )
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getWebHooks()
    {
        $response = $this->client->get(
            '/v1/shops/' . $this->idShop . '/webhooks.json',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                )
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param $webHookId
     * @return string
     * @throws Exception
     */
    public function removeWebHook($webHookId)
    {
        $response = $this->client->delete(
            '/v1/shops/' . $this->idShop . '/webhooks/' . $webHookId . '.json',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                )
            )
        );

        return $response->getBody()->getContents();
    }
}
