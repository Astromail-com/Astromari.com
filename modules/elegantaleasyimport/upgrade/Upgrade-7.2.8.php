<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_2_8($module)
{
    unset($module);
    
    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport` ADD `force_id_product` tinyint(1) unsigned NOT NULL DEFAULT '0' AFTER `update_products_on_all_shops`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }

    return true;
}
