<?php

use Invertus\Printify\Config\Config;

class AdminPrintifySettingsController extends \Invertus\Printify\Controller\AdminController
{
    /**
     * @var
     */
    private $moduleContainer;

    /**
     *
     * @throws PrestaShopException
     */
    public function __construct()
    {
        parent::__construct();

        $this->moduleContainer = $this->module->getModuleContainer();
    }

    public function init()
    {
        parent::init();
        $this->initOptions();
    }

    private function initOptions()
    {
        $this->fields_options =  $this->fields_options = array(
            'access' => array(
                'title' => $this->module->l('Settings'),
                'icon' => 'icon-cogs',
                'fields' => array(
                    Config::SEND_ORDER_ON_PAID => array(
                        'title' => $this->module->l('Send orders on paid'),
                        'type' => 'bool',
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'desc' => $this->module->l('Send orders to Printify only when their status have been changed to paid. If this setting is off orders will be sent when customer completes order in shop.'),

                    ),
                    Config::LOG_STORAGE_DURATION => array(
                        'title' => $this->module->l('Store logs for'),
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'text',
                        'hint' => $this->module->l('How long should logs be stored'),
                        'suffix' => $this->module->l('days'),
                        'class' => 'fixed-width-xl',
                    ),

                ),
                'submit' => array(
                    'title' => $this->module->l('Save'),
                ),
            ),
        );
    }
}
