<?php

namespace Invertus\Printify\Factory;

use GuzzleHttp\Client;

class HttpClientFactory
{
    const MAIN_URL = 'https://api.printify.com/';

    /**
     * returns guzzle http client
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client(array ('base_url' => self::MAIN_URL));
    }
}
