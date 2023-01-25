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

namespace Invertus\Printify\Install;

use Configuration;
use DateTime;
use Db;
use Exception;
use Language;
use OrderState;
use Printify;
use Invertus\Printify\Config\Config;
use Tools;

/**
 * Class Installer - responsible for module installation process
 * @package Invertus\Printify\Install
 */
class Installer extends AbstractInstaller
{
    /**
     * @var Printify
     */
    private $module;

    /**
     * @var array
     */
    private $configuration;

    /**
     * Installer constructor.
     *
     * @param Printify $module
     * @param array $configuration
     */
    public function __construct(\Printify $module, array $configuration)
    {
        $this->module = $module;
        $this->configuration = $configuration;
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (!$this->registerHooks()) {
            return false;
        }

        if (!$this->installConfiguration()) {
            return false;
        }

        if (!$this->installDb()) {
            return false;
        }

        if (!$this->registerOrderStates()) {
            return false;
        }

        Configuration::updateValue(Config::PRINTIFY_LAST_LOG_DELETE_DATE, (new DateTime())->format('Y-m-d H:i:s'));

        return true;
    }

    public function registerOrderStates()
    {
        $printifyOrderStates = array(
            array(
                'id' => Config::PRINTIFY_ORDER_PENDING,
                'color' => '#2097f6',
                'name' => 'Printify Pending',
                'shipped' => 0,
                'paid' => 0
            ),
          array(
                'id' => Config::PRINTIFY_ORDER_ON_HOLD,
                'color' => '#2097f6',
                'name' => 'Printify On hold',
                'shipped' => 0,
                'paid' => 0

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_CHECKING_QUALITY,
                'color' => '#ffe400',
                'name' => 'Printify Checking quality',
                'shipped' => 0,
                'paid' => 0

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_QUALITY_DECLINED,
                'color' => '#d15564',
                'name' => 'Printify Quality declined',
                'shipped' => 0,
                'paid' => 0

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_QUALITY_APPROVED,
                'color' => '#ffe400',
                'name' => 'Printify Quality approved',
                'shipped' => 0,
                'paid' => 0

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_READY_FOR_PRODUCTION,
                'color' => '#ffe400',
                'name' => 'Printify Ready for production',
                'shipped' => 0,
                'paid' => 0

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_SENDING_TO_PRODUCTION,
                'color' => '#ffe400',
                'name' => 'Printify Sending to production',
                'shipped' => 0,
                'paid' => 1

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_IN_PRODUCTION,
                'color' => '#319e50',
                'name' => 'Printify In production',
                'shipped' => 0,
                'paid' => 1

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_CANCELLED,
                'color' => '#d15564',
                'name' => 'Printify Cancelled',
                'shipped' => 0,
                'paid' => 0

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_FULFILLED,
                'color' => '#319e50',
                'name' => 'Printify Fulfilled',
                'shipped' => 1,
                'paid' => 1

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_PARTIALLY_FULFILLED,
                'color' => '#319e50',
                'name' => 'Printify Partially fulfilled',
                'shipped' => 1,
                'paid' => 1

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_PAYMENT_NOT_RECEIVED,
                'color' => '#d15564',
                'name' => 'Printify Payment not received',
                'shipped' => 0,
                'paid' => 0

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_CALLBACK_RECEIVED,
                'color' => '#d15564',
                'name' => 'Printify Callback received',
                'shipped' => 0,
                'paid' => 0

            ),
          array(
                'id' => Config::PRINTIFY_ORDER_HAS_ISSUES,
                'color' => '#d15564',
                'name' => 'Printify Has issues',
                'shipped' => 0,
                'paid' => 0

            ),
        );

        $languages = Language::getLanguages();
        foreach ($printifyOrderStates as $printifyOrderState) {
            $nameArray = array();
            $orderArray = [];
            foreach ($languages as $language) {
                $nameArray[$language['id_lang']] = $printifyOrderState['name'];
                foreach (OrderState::getOrderStates($language['id_lang']) as $orderStateValue) {
                    $orderArray[$orderStateValue['id_order_state']] = $orderStateValue['name'];
                }
            }
            $orderState = new OrderState();
            $orderState->name = $nameArray;
            $orderState->invoice = 0;
            $orderState->send_email = 0;
            $orderState->color = $printifyOrderState['color'];
            $orderState->unremovable = 1;
            $orderState->module_name = $this->module->name;

            $orderState->shipped = $printifyOrderState['shipped'];
            $orderState->paid = $printifyOrderState['paid'];

            if (in_array($printifyOrderState['name'], $orderArray)) {
                foreach ($orderArray as $key => $name) {
                    if ($printifyOrderState['name'] === $name) {
                        Db::getInstance()->insert('printify_order_state', array(
                            'id' => pSQL($printifyOrderState['id']),
                            'id_order_state' => (int) $key,
                        ));
                        continue;
                    }
                }
                continue;
            }

            $orderState->save();
            Db::getInstance()->insert('printify_order_state', array(
                'id' => pSQL($printifyOrderState['id']),
                'id_order_state' => (int) $orderState->id
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function getSqlStatements($fileName)
    {
        $sqlStatements = Tools::file_get_contents($fileName);
        $sqlStatements = str_replace(['PREFIX_', 'ENGINE_TYPE'], [_DB_PREFIX_, _MYSQL_ENGINE_], $sqlStatements);

        return $sqlStatements;
    }

    /**
     *
     * @return bool
     *
     * @throws Exception
     */
    private function registerHooks()
    {
        $hooks = $this->configuration['hooks'];

        if (empty($hooks) || null === $hooks) {
            return true;
        }

        foreach ($hooks as $hookName) {
            if (!$this->module->registerHook($hookName)) {
                throw new Exception(
                    sprintf(
                        $this->module->l('Hook %s has not been installed.', $this->getFileName($this)),
                        $hookName
                    )
                );
            }
        }

        return true;
    }

    /**
     * Installs global settings
     *
     * @return bool
     *
     * @throws Exception
     */
    private function installConfiguration()
    {
        $configuration = $this->configuration['configuration'];

        if (empty($configuration) || null === $configuration) {
            return true;
        }

        foreach ($configuration as $name => $value) {
            if (!Configuration::updateValue($name, $value)) {
                throw new Exception(
                    sprintf(
                        $this->module->l('Configuration %s has not been installed.', $this->getFileName($this)),
                        $name
                    )
                );
            }
        }

        return true;
    }

    /**
     * Reads sql files and executes
     *
     * @return bool
     * @throws Exception
     */
    private function installDb()
    {
        $installSqlFiles = glob($this->module->getLocalPath().'sql/install/*.sql');

        if (empty($installSqlFiles)) {
            return true;
        }

        $database = Db::getInstance();

        foreach ($installSqlFiles as $sqlFile) {
            $sqlStatements = $this->getSqlStatements($sqlFile);

            try {
                $this->execute($database, $sqlStatements);
            } catch (Exception $exception) {
                throw new Exception($exception->getMessage());
            }
        }

        return true;
    }
}
