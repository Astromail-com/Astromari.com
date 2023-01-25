<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_3_6($module)
{
    unset($module);

    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport` CHANGE `put_zero_qty_for_products_not_found_in_csv` `delete_stock_for_products_not_found_in_csv` tinyint(1) unsigned NOT NULL DEFAULT '0'";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }

    return true;
}
