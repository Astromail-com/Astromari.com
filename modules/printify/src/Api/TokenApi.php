<?php

namespace Invertus\Printify\Api;

use Configuration;
use Exception;
use Invertus\Printify\Config\Config;
use DateTime;
use Printify;

class TokenApi extends PrintifyApi
{
    /**
     * @param $accessCode
     * @return string
     */
    public function getTokensFromApiByAccessCode($accessCode)
    {
        $response = $this->client->post(
            '/v1/app/oauth/tokens',
            array(
                'query' => array(
                    'app_id' => Printify::PRESTASHOP_APP_ID,
                    'code' => $accessCode
                )
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getToken()
    {
        $currentDate = new DateTime();
        $expirationDate = new DateTime(Configuration::get(Config::TOKEN_EXPIRE_DATE));
        if ($expirationDate <= $currentDate) {
            $this->refreshTokens();
        }

        return Configuration::get(Config::ACCESS_TOKEN);
    }

    /**
     * @param bool $accessCode
     * @return bool
     */
    public function refreshTokens($accessCode = false)
    {
        if ($accessCode) {
            $tokens = json_decode($this->getTokensFromApiByAccessCode($accessCode));
        } else {
            $tokens = json_decode($this->getTokensFromApiByRefresh());
        }

        Configuration::updateValue(Config::ACCESS_TOKEN, $tokens->access_token);
        Configuration::updateValue(Config::REFRESH_TOKEN, $tokens->refresh_token);
        Configuration::updateValue(Config::TOKEN_EXPIRE_DATE, $tokens->expire_at);

        return true;
    }

    /**
     * @return string
     */
    private function getTokensFromApiByRefresh()
    {
        $response = $this->client->post(
            '/v1/app/oauth/tokens/refresh',
            array(
                'headers' => array(
                    'Content-Type' => 'application/json',
                ),
                'query' => array(
                    'app_id' => Printify::PRESTASHOP_APP_ID,
                    'refresh_token' => Configuration::get(Config::REFRESH_TOKEN)
                )
            )
        );

        return $response->getBody()->getContents();
    }
}
