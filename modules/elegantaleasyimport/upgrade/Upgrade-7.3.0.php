<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_3_0($module)
{
    unset($module);

    $sql = "ALTER TABLE " . _DB_PREFIX_ . "elegantaleasyimport DROP COLUMN `error_log`; ";
    $sql .= "ALTER TABLE " . _DB_PREFIX_ . "elegantaleasyimport DROP COLUMN `last_import_date`;";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }
    $sql = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport_history` (
        `id_elegantaleasyimport_history` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `id_elegantaleasyimport` int(11) unsigned NOT NULL,
        `total_number_of_products` int(11) unsigned,
        `number_of_products_processed` int(11) unsigned,
        `number_of_products_created` int(11) unsigned,
        `number_of_products_updated` int(11) unsigned,
        `number_of_products_deleted` int(11) unsigned,
        `date_started` DATETIME,
        `date_ended` DATETIME,
        PRIMARY KEY (`id_elegantaleasyimport_history`), 
        FOREIGN KEY (`id_elegantaleasyimport`) REFERENCES `" . _DB_PREFIX_ . "elegantaleasyimport` (`id_elegantaleasyimport`) ON DELETE CASCADE 
    ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=UTF8;";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }
    $sql = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport_error` (
        `id_elegantaleasyimport_error` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `id_elegantaleasyimport_history` int(11) unsigned NOT NULL,
        `product_id_reference` varchar(255),
        `error` varchar(255),
        `date_created` DATETIME,
        PRIMARY KEY (`id_elegantaleasyimport_error`),
        FOREIGN KEY (`id_elegantaleasyimport_history`) REFERENCES `" . _DB_PREFIX_ . "elegantaleasyimport_history` (`id_elegantaleasyimport_history`) ON DELETE CASCADE 
    ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=UTF8;";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }

    try {
        $sql = "SELECT t.* FROM `" . _DB_PREFIX_ . "elegantaleasyimport` t
            WHERE t.`is_cron` = 1 AND t.`id_elegantaleasyimport` IN (SELECT d.`id_elegantaleasyimport` FROM `" . _DB_PREFIX_ . "elegantaleasyimport_data` d GROUP BY d.`id_elegantaleasyimport`)";
        $rules = Db::getInstance()->executeS($sql);
        if ($rules) {
            foreach ($rules as $rule) {
                $model = new ElegantalEasyImportClass($rule['id_elegantaleasyimport']);
                if (Validate::isLoadedObject($model)) {
                    $model->saveCsvRows();
                }
            }
        }
    } catch (Exception $e) {
        // Nothing
    }

    return true;
}
