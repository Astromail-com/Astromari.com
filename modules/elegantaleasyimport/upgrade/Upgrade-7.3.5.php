<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_3_5($module)
{
    unset($module);

    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport_export` ADD `export_products_updated_within_minute` int(11) AFTER `exclude_product_ids`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }
    return true;
}
