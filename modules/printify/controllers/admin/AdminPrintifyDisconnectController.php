<?php

use Invertus\Printify\Api\ShopApi;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Service\Logger;
use Invertus\Printify\Service\PrintifyConnectionManager;
use Invertus\Printify\Service\WebHookRegisterer;

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

class AdminPrintifyDisconnectController extends \Invertus\Printify\Controller\AdminController
{
    public function init()
    {
        parent::init();
    }

    /**
     * @return bool|ObjectModel|void
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function postProcess()
    {
        $container = $this->module->getModuleContainer();
        /** @var PrintifyConnectionManager $connectionManager */
        $connectionManager = $container->get('printify_connection_manager');
        $connectionManager->disconnectFromPrintify();

        $this->redirect_after = $this->context->link->getAdminLink('AdminPrintifyConnect', true);

        $this->redirect();
    }
}
