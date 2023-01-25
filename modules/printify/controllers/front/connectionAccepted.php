<?php

use Invertus\Printify\Api\TokenApi;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Service\Logger;
use Invertus\Printify\Service\PrintifyLink;
use Invertus\Printify\Service\WebHookRegisterer;

class PrintifyConnectionAcceptedModuleFrontController extends ModuleFrontController
{
    CONST CONNECTION_CODE_SUCCESS = '1000';
    CONST CONNECTION_FAILED_ALREADY_CONNECTED = '2001';
    CONST CONNECTION_FAILED_EXCEPTION = '2002';
    CONST CONNECTION_FAILED_INVALID_DATA = '2003';

    /**
     * @throws Exception
     */
    public function postProcess()
    {
        /** @var Logger $logger */
        /** @var PrintifyLink $router */
        $logger = $this->module->getModuleContainer()->get('printify_logger');
        $router = $this->module->getModuleContainer()->get('printify_router');

        if (!Tools::getValue('shop_id')) {
            $data = file_get_contents("php://input");
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_CONNECTION,
                sprintf('Connection failed. Request content: %s', $data)
            );

            $this->setTemplate('module:printify/views/templates/admin/connect-failed.tpl');

            $this->context->smarty->assign(
                [
                    'message' => $this->module->l('Printify shop id is invalid or missing')
                ]
            );

            return;
        }

        $connected = false;
        if (
            Configuration::get(Config::ID_SHOP) &&
            Configuration::get(Config::REFRESH_TOKEN) &&
            Configuration::get(Config::ACCESS_TOKEN)
        ) {
            try {
                /**
                 * @var $connectionManager \Invertus\Printify\Service\PrintifyConnectionManager;
                 */
                $connectionManager = $this->module->getModuleContainer()->get('printify_connection_manager');

                $connected = $connectionManager->checkConnection();
            } catch (Exception $e) {
                $logger->log(Config::PRINTIFY_LOG_TYPE_CONNECTION_CHECK, $e->getMessage());
            }
        }

        if ($connected) {
            $logger->log(Config::PRINTIFY_LOG_TYPE_CONNECTION, 'Connection failed, already connected');
            Tools::redirectLink($router->buildPrintifyAcceptConnectionUrl(self::CONNECTION_FAILED_ALREADY_CONNECTED, Configuration::get(Config::ID_SHOP)));

            return;
        }

        if (Tools::getValue('app_id') === Printify::PRESTASHOP_APP_ID
            && Tools::getValue('code')
            && Tools::getValue('shop_id')
            && Tools::getValue('state') === Configuration::get(Config::STATE_TOKEN)
        ) {
            try {
                $this->connect();
            } catch (Exception $e) {
                $logger->log(Config::PRINTIFY_LOG_TYPE_CONNECTION, 'Connection failed');
                Tools::redirectLink($router->buildPrintifyAcceptConnectionUrl(self::CONNECTION_FAILED_EXCEPTION, Configuration::get(Config::ID_SHOP)));

                return;
            }

            $logger->log(
                Config::PRINTIFY_LOG_TYPE_CONNECTION,
                'Connection succeeded',
                null,
                Config::PRINTIFY_LOG_STATUS_SUCCESS
            );

            Tools::redirectLink($router->buildPrintifyAcceptConnectionUrl(self::CONNECTION_CODE_SUCCESS, Configuration::get(Config::ID_SHOP)));

            return;
        }

        $logger->log(Config::PRINTIFY_LOG_TYPE_CONNECTION, 'Connection failed');

        Tools::redirectLink($router->buildPrintifyAcceptConnectionUrl(self::CONNECTION_FAILED_INVALID_DATA, Configuration::get(Config::ID_SHOP)));
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->registerStylesheet('modules-printify_connect', 'modules/printify/views/css/connect.css');
    }

    /**
     * @throws Exception
     */
    public function connect()
    {
        parent::init();

        /** @var TokenApi $tokenApi */
        $tokenApi = $this->module->getModuleContainer()->get('invertus.printify.api.token_api');
        $tokenApi->refreshTokens(Tools::getValue('code'));
        Configuration::updateValue(Config::ID_SHOP, Tools::getValue('shop_id'));

        /** @var WebHookRegisterer $webHookRegisterer */
        $webHookRegisterer = $this->module->getModuleContainer()->get('printify_web_hook_registerer');
        $webHookRegisterer->setModuleName($this->module->name);
        $webHookRegisterer->registerHooks();
    }
}
