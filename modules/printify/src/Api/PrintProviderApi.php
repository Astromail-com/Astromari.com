<?php
/**
 * 2007-2019 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author INVERTUS UAB www.invertus.eu <support@invertus.eu>
 * @copyright printify.com Limited
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace Invertus\Printify\Api;

use Exception;
use Invertus\Printify\Factory\HttpClientFactory;

/**
 * Class handles printify print provider api endpoint connections
 */
class PrintProviderApi extends PrintifyApi
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
     * @param $idPrintProvider
     * @return string
     * @throws Exception
     */
    public function getPrintProvider($idPrintProvider)
    {
        $response = $this->client->get(
            '/v1/catalog/print_providers/' . $idPrintProvider .'.json',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                )
            )
        );

        return $response->getBody()->getContents();
    }

    /**
     * @param $idBlueprint
     * @return string
     * @throws Exception
     */
    public function getBlueprint($idBlueprint)
    {
        $response = $this->client->get(
            '/v1/catalog/blueprints/' . $idBlueprint .'.json',
            array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->tokenApi->getToken()
                )
            )
        );

        return $response->getBody()->getContents();
    }
}
