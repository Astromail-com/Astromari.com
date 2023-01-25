<?php
/**
 * 2007-2019 PrestaShop SA and Contributors
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

use Context;
use Exception;
use Invertus\Printify\Api\WebHookApi;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Exception\InvalidJsonStringException;
use PrestaShopException;
use Printify;
use Tools;

class WebHookRegisterer
{
    const HOOK_TYPE_PRODUCT = 'product';
    const HOOK_TYPE_ORDER = 'order';
    const HOOK_TYPE_SHOP = 'shop';

    /**
     * @var string
     */
    private $moduleName;

    /**
     * @var WebHookApi
     */
    private $webHookApi;

    /**
     * @var array
     */
    private $hooks;

    /** @var Logger */
    private $logger;

    /**
     * @param WebHookApi $webHookApi
     * @param $hooks
     * @param Logger $logger
     */
    public function __construct(WebHookApi $webHookApi, $hooks, Logger $logger)
    {
        $this->hooks = $hooks;
        $this->webHookApi = $webHookApi;
        $this->logger = $logger;
    }

    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
    }

    /**
     * @throws Exception
     */
    public function registerHooks()
    {
        $context = Context::getContext();

        $productsEventsController = $context->link->getModuleLink($this->moduleName, Printify::PRODUCT_EVENTS_CONTROLLER);
        $orderEventsController = $context->link->getModuleLink($this->moduleName, Printify::ORDER_EVENTS_CONTROLLER);
        $shopEventsController = $context->link->getModuleLink($this->moduleName, Printify::SHOP_EVENTS_CONTROLLER);

        foreach ($this->hooks as $hook) {
            switch ($hook['type']) {
                case self::HOOK_TYPE_PRODUCT:
                    $controller = $productsEventsController;
                    break;
                case self::HOOK_TYPE_ORDER:
                    $controller = $orderEventsController;
                    break;
                case self::HOOK_TYPE_SHOP:
                    $controller = $shopEventsController;
                    break;
                default:
                    $controller = '';
            }

            if (!empty($controller)) {
                $this->webHookApi->registerWebHook($hook['hook'], $controller);
            }
        }
    }

    /**
     * @return bool
     * @throws InvalidJsonStringException
     */
    public function areHooksRegistered()
    {
        $registeredWebHooks = $this->webHookApi->getWebHooks();
        $hookJsonParser = new WebHookJsonParser($registeredWebHooks);

        return $hookJsonParser->areHooksRegistered($this->hooks);
    }

    /**
     * @throws InvalidJsonStringException
     * @throws PrestaShopException
     * @throws PrestaShopException
     * @throws Exception
     */
    public function unregisterHooks()
    {
        $registeredWebHooks = $this->webHookApi->getWebHooks();
        $hookJsonParser = new WebHookJsonParser($registeredWebHooks);

        foreach ($hookJsonParser->getHookIdsList() as $id) {
            try {
                $this->webHookApi->removeWebHook($id);
            } catch (Exception $e) {
                $this->logger->log(
                    Config::PRINTIFY_LOG_TYPE_WEBHOOK,
                    sprintf('Failed to delete webhook with id %s', $id),
                    $id
                );

                continue;
            }

            $this->logger->log(
                Config::PRINTIFY_LOG_TYPE_WEBHOOK,
                sprintf('Successfully deleted webhook with id %s', $id),
                $id,
                Config::PRINTIFY_LOG_STATUS_SUCCESS
            );
        }
    }
}
