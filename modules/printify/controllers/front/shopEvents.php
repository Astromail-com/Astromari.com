<?php

use Invertus\Printify\Config\Config;
use Invertus\Printify\Service\Logger;
use Invertus\Printify\Service\PrintifyConnectionManager;
use Invertus\Printify\Service\PrintifyOrderResolver;
use Invertus\Printify\Service\WebHookRegisterer;

class PrintifyShopEventsModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $container = $this->module->getModuleContainer();
        /** @var PrintifyConnectionManager $connectionManager */
        $connectionManager = $container->get('printify_connection_manager');
        /** @var Logger $logger */
        $logger = $container->get('printify_logger');

        try {
            $connectionManager->disconnectFromPrintify();
        } catch (Exception $e) {
            $logger->log(Config::PRINTIFY_LOG_TYPE_SHOP_DISCONNECT, $e->getMessage(), Configuration::get(Config::ID_SHOP));
        }

        $this->ajaxDie('');
    }
}


