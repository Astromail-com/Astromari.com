<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_4_1($module)
{
    unset($module);

    Db::getInstance()->execute("ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport` ADD `product_reference_modifier` text AFTER `price_modifier`");
    Db::getInstance()->execute("ALTER TABLE " . _DB_PREFIX_ . "elegantaleasyimport DROP COLUMN `lang_id`");
    Db::getInstance()->execute("ALTER TABLE " . _DB_PREFIX_ . "elegantaleasyimport DROP COLUMN `replicate_all_languages`");

    return true;
}
