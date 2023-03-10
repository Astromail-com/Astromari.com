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
use PrestaShopException;
use Tools;

/**
 * Class Uninstaller - responsible for module installation process
 * @package Invertus\Printify\Install
 */
class Uninstaller extends AbstractInstaller
{
    /**
     * @var \Printify
     */
    private $module;
    /**
     * @var array
     */
    private $configuration;

    /**
     * Installer constructor.
     *
     * @param \Printify $module
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
        $container = $this->module->getModuleContainer();
        $connectionManager = $container->get('printify_connection_manager');
        
        try {
            $connectionManager->disconnectFromPrintify();
        } catch (PrestaShopException $e) {
        }

        $this->uninstallConfiguration();


        if (!$this->uninstallDb()) {
            return false;
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

    private function uninstallConfiguration()
    {
        $configuration = $this->configuration['configuration'];

        if (null === $configuration || empty($configuration)) {
            return;
        }

        $configurationNames = array_keys($configuration);

        if (empty($configurationNames) || null === $configurationNames) {
            return;
        }

        foreach ($configurationNames as $name) {
            if (!Configuration::deleteByName($name)) {
                continue;
            }
        }
    }

    /**
     * Executes sql in uninstall.sql file which is used for uninstalling
     *
     * @return bool
     *
     * @throws \Exception
     */
    private function uninstallDb()
    {
        $uninstallSqlFileName = $this->module->getLocalPath().'sql/uninstall/uninstall.sql';
        if (!file_exists($uninstallSqlFileName)) {
            return true;
        }

        $database = \Db::getInstance();
        $sqlStatements = $this->getSqlStatements($uninstallSqlFileName);
        return (bool) $this->execute($database, $sqlStatements);
    }
}
