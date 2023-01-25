<?php
/**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace Invertus\Printify\Service;

use Configuration;
use Context;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Exception\InvalidPrintifyRoutingConfiguration;
use Invertus\Printify\Exception\RouteDefinitionNotFoundException;
use Link;
use PrestaShopException;
use Printify;

class PrintifyLink
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var Printify
     */
    private $module;

    /**
     * @param $configuration
     *
     * @throws InvalidPrintifyRoutingConfiguration
     */
    public function __construct($configuration, Printify $module)
    {
        $this->assertConfigurationIsValid($configuration);
        $this->configuration = $configuration;
        $this->prefix = $configuration['prefix'];
        $this->module = $module;
    }

    /**
     * @param $statusCode
     * @param $shopId
     * @return string
     * @throws InvalidPrintifyRoutingConfiguration
     * @throws RouteDefinitionNotFoundException
     */
    public function buildPrintifyAcceptConnectionUrl($statusCode, $shopId)
    {
        return $this->generateUrl('printify_connection_accepted', array(
            'code' => $statusCode,
            'shop_id' => $shopId
        ));
    }

    /**
     * @param $state
     * @return string
     * @throws InvalidPrintifyRoutingConfiguration
     * @throws RouteDefinitionNotFoundException
     * @throws PrestaShopException
     */
    public function buildPrintifyAuthorizeUrl($state)
    {
        /** @var Link $link */
        $link = Context::getContext()->link;

        $acceptUrl = $link->getModuleLink($this->module->name, Printify::CONNECTION_ACCEPTED_CONTROLLER);
        $declineUrl = $link->getModuleLink($this->module->name, Printify::CONNECTION_ACCEPTED_CONTROLLER);
        $params = [
            'domain' => $link->getBaseLink()
        ];

        $params = urlencode(json_encode($params));

//        if (defined('_PS_ADMIN_DIR_')) {
//            $acceptUrl = $link->getAdminBaseLink() . basename(_PS_ADMIN_DIR_) . '/printifyConnectionSucceed/';
//            $declineUrl = $link->getAdminBaseLink() . basename(_PS_ADMIN_DIR_) .  '/printifyConnectionFailed/';
//        }
//
//        if (!defined('_PS_ADMIN_DIR_') && $adminDir = Configuration::get(Config::ADMIN_DIR)) {
//
//            $acceptUrl = $link->getAdminBaseLink() . $adminDir . '/printifyConnectionSucceed/';
//            $declineUrl = $link->getAdminBaseLink() . $adminDir .  '/printifyConnectionFailed/';
//        }

        /**
         * try httb_build_url or http_build_query.
         */

        return $this->generateUrl('printify_authorize', array(
            'appId' => Printify::PRESTASHOP_APP_ID,
            'acceptUrl' => $acceptUrl,
            'declineUrl' => $declineUrl,
            'state' => $state,
            'extra_data' => $params
        ));
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return string
     * @throws InvalidPrintifyRoutingConfiguration
     * @throws RouteDefinitionNotFoundException
     */
    public function generateUrl($name, $parameters = [])
    {
        $path = $this->findPathByName($name);

        return $this->resolvePathWithParameters($path, $parameters);
    }

    /**
     * @param $path
     * @param $parameters
     * @return mixed|string
     * @throws InvalidPrintifyRoutingConfiguration
     */
    private function resolvePathWithParameters($path, $parameters)
    {
        $matches = [];

        if (!preg_match_all('/{\w*}/', $path, $matches)) {
            $this->assertUrlIsValid($this->prefix . $path);

            return $this->prefix . $path;
        }

        foreach ($matches[0] as $match) {
            if (!array_key_exists(trim($match, '{}'), $parameters)) {
                throw new InvalidPrintifyRoutingConfiguration(
                    sprintf('Mandatory parameter "%s" is missing', trim($match, '{}'))
                );
            }

            $path = str_replace($match, $parameters[trim($match, '{}')], $path);
        }

        $this->assertUrlIsValid($this->prefix . $path);

        return $this->prefix . $path;
    }

    /**
     * @param $name
     * @return mixed
     * @throws InvalidPrintifyRoutingConfiguration
     * @throws RouteDefinitionNotFoundException
     */
    private function findPathByName($name)
    {
        if (!array_key_exists($name, $this->configuration['routes'])) {
            throw new RouteDefinitionNotFoundException(sprintf('Definition not found for "%s" route', $name));
        }

        if (!array_key_exists('path', $this->configuration['routes'][$name])) {
            throw new InvalidPrintifyRoutingConfiguration(sprintf('Path must be defined for "%s" route', $name));
        }

        return $this->configuration['routes'][$name]['path'];
    }

    /**
     * @param $path
     * @throws InvalidPrintifyRoutingConfiguration
     */
    private function assertUrlIsValid($path)
    {
        if (!filter_var($path, FILTER_VALIDATE_URL)) {
            throw new InvalidPrintifyRoutingConfiguration(
                sprintf('Base url and given path does not provide a valid url %s', $this->prefix . $path)
            );
        }
    }

    /**
     * @param $configuration
     * @throws InvalidPrintifyRoutingConfiguration
     */
    private function assertConfigurationIsValid($configuration)
    {
        $hasRoutes = array_key_exists('routes', $configuration) && !empty($configuration['routes']);
        if (!$hasRoutes || !array_key_exists('prefix', $configuration)) {
            throw new InvalidPrintifyRoutingConfiguration('Printify routing configuration is invalid');
        }
    }
}
