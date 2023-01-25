<?php
/**
 * NOTICE OF LICENSE
 *
 * @author    INVERTUS, UAB www.invertus.eu <support@invertus.eu>
 * @copyright Copyright (c) permanent, INVERTUS, UAB
 * @license   MIT
 * @see       /LICENSE
 *
 *  International Registered Trademark & Property of INVERTUS, UAB
 */

use Invertus\Printify\Api\TokenApi;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Service\Logger;
use Invertus\Printify\Service\PrintifyLink;
use Invertus\Printify\Service\WebHookRegisterer;

class AdminPrintifyConnectController extends \Invertus\Printify\Controller\AdminController
{
    public function init()
    {
        parent::init();

        //Configuration::updateValue(Config::ADMIN_DIR, basename(_PS_ADMIN_DIR_));
        if (Tools::getValue('failedToConnect') || Tools::getValue('succeededToConnect')) {
            $state = Configuration::get(Config::STATE_TOKEN);
        } else {
            $state = Tools::hash(time());
            Configuration::updateValue(Config::STATE_TOKEN, $state);
        }

        /** @var PrintifyLink $printifyLink */
        $printifyLink = $this->module->getModuleContainer()->get('printify_router');
        /** @var Logger $logger */
        $logger = $this->module->getModuleContainer()->get('printify_logger');

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

        $url = $printifyLink->buildPrintifyAuthorizeUrl($state);
        $disconnectUrl = $this->context->link->getAdminLink('AdminPrintifyDisconnect', true);

        $this->context->smarty->assign(
            array(
                'connected' => $connected,
                'connectUrl' => $url,
                'disconnectUrl' => $disconnectUrl,
                'connectImgUrl' => $this->module->getPathUri() . 'views/img/Not_found_box_questionmark.png'
            )
        );

        if ($connected) {
            $template = 'disconnect.tpl';
        } else {
            $template = 'connect.tpl';
        }

        $this->content = $this->context->smarty->fetch($this->module->getLocalPath() . 'views/templates/admin/' . $template);
    }

    public function setMedia($isNewTheme = false)
    {
        $this->addCSS($this->module->getLocalPath() . 'views/css/connect.css');
        parent::setMedia($isNewTheme);
    }

    public function postProcess()
    {
        if (Tools::isSubmit('failedToConnect')) {
            $this->errors = $this->module->l('Connection failed');
        }
        if (Tools::isSubmit('succeededToConnect')) {
            $this->connectFromPrintify();
        }
        if (Tools::isSubmit('connectionSuccessMessage')) {
            $this->confirmations = $this->module->l('Connected successfully');
        }
        if (Tools::isSubmit('connectionFailMessage')) {
            $this->errors = $this->module->l('Connection failed. Check logs for more information');;
        }

        parent::postProcess();
    }

    private function redirectConnectionFailed()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink(
                $this->controller_name,
                true,
                array(),
                array(
                    'connectionFailedMessage' => '1'
                )
            )
        );
    }

    /**
     * @throws Exception
     */
    public function connectFromPrintify()
    {
        /** @var Logger $logger */
        $logger = $this->module->getModuleContainer()->get('printify_logger');

        if (!Tools::getValue('shop_id')) {
            $data = file_get_contents("php://input");
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_CONNECTION,
                sprintf('Connection failed. Request content: %s', $data)
            );

            $this->redirectConnectionFailed();
        }

        $stateTokenCheck = Tools::getValue('state') === Configuration::get(Config::STATE_TOKEN);
        if (!$stateTokenCheck) {
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_CONNECTION,
                $this->module->l('State token is no longer correct')
            );

            $this->redirectConnectionFailed();
        }

        if (
            Tools::getValue('app_id') === Printify::PRESTASHOP_APP_ID
            && Tools::getValue('code')
            && Tools::getValue('shop_id')
        ) {
            try {
                $this->connect();
            } catch (Exception $e) {
                $logger->log(Config::PRINTIFY_LOG_TYPE_CONNECTION, $e->getMessage());
                $logger->log(Config::PRINTIFY_LOG_TYPE_CONNECTION, 'Connection failed');
                $this->redirectConnectionFailed();

            }

            $logger->log(
                Config::PRINTIFY_LOG_TYPE_CONNECTION,
                'Connection succeeded',
                null,
                Config::PRINTIFY_LOG_STATUS_SUCCESS
            );

            Tools::redirectAdmin(
                $this->context->link->getAdminLink(
                    $this->controller_name,
                    true,
                    array(),
                    array(
                        'connectionSuccessMessage' => '1'
                    )
                )
            );
        }

        $logger->log(Config::PRINTIFY_LOG_TYPE_CONNECTION, 'Connection failed');

        $this->errors = $this->module->l('Connection failed. Check logs for more information');
    }

    /**
     * @throws Exception
     */
    public function connect()
    {
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
