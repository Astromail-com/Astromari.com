<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_2_4($module)
{
    unset($module);

    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport_csv` RENAME TO `" . _DB_PREFIX_ . "elegantaleasyimport_data`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }

    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport_data` CHANGE `id_elegantaleasyimport_csv` `id_elegantaleasyimport_data` int(11) unsigned NOT NULL AUTO_INCREMENT";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }

    return true;
}
