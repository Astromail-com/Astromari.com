<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_2_7($module)
{
    unset($module);

    $sql = "ALTER TABLE " . _DB_PREFIX_ . "elegantaleasyimport ADD `disable_if_no_image` tinyint(1) unsigned NOT NULL DEFAULT '0' AFTER `disable_if_no_stock`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }

    return true;
}
