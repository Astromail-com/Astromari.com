<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_4_2($module)
{
    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport` ADD `csv_header` text AFTER `map_default_values`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }
    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport` ADD `deny_orders_when_no_stock_for_products_not_found_in_file` tinyint(1) unsigned NOT NULL DEFAULT '0' AFTER `disable_all_products_not_found_in_csv`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }
    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport_export` ADD `csv_delimiter` varchar(5) AFTER `file_format`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }
    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport_export` ADD `features_in_separate_columns` tinyint(1) unsigned AFTER `quantity_range`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }
    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport_export` ADD `root_category_included` tinyint(1) unsigned AFTER `features_in_separate_columns`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }
    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport_export` ADD `disallowed_category_ids` text AFTER `category_ids`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }
    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "elegantaleasyimport_export` ADD `email_to_send_notification` varchar(255) AFTER `last_export_date`";
    if (Db::getInstance()->execute($sql) == false) {
        throw new Exception(Db::getInstance()->getMsgError());
    }

    Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "elegantaleasyimport_export` SET `root_category_included` = 1");

    $settings = $module->getSettings();
    if ((isset($settings['export_csv_delimiter']) && $settings['export_csv_delimiter'] != ',')) {
        Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "elegantaleasyimport_export` SET `csv_delimiter` = '" . pSQL($settings['export_csv_delimiter']) . "'");
    }
    if (isset($settings['export_features_in_separate_columns']) && $settings['export_features_in_separate_columns'] == 1) {
        Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "elegantaleasyimport_export` SET `features_in_separate_columns` = 1");
    }

    // Delete settings for each shop
    $shops = array(array('id_shop_group' => "", 'id_shop' => ""));
    if (Shop::isFeatureActive()) {
        $shop_groups = Shop::getTree();
        foreach ($shop_groups as $shop_group) {
            foreach ($shop_group['shops'] as $shop) {
                $shops[] = array('id_shop_group' => $shop['id_shop_group'], 'id_shop' => $shop['id_shop']);
            }
        }
    }
    foreach ($shops as $shop) {
        $module->deleteSetting('export_csv_delimiter', $shop['id_shop_group'], $shop['id_shop']);
        $module->deleteSetting('export_features_in_separate_columns', $shop['id_shop_group'], $shop['id_shop']);
    }

    // Update all existing export rule columns.
    // From now on, export columns holds column_name => column_value of only enabled columns in sorted order.
    $export_rules = Db::getInstance()->executeS("SELECT * FROM `" . _DB_PREFIX_ . "elegantaleasyimport_export`");
    if ($export_rules && is_array($export_rules)) {
        foreach ($export_rules as $rule) {
            $new_columns = array();
            $ruleObj = new ElegantalEasyImportExport($rule['id_elegantaleasyimport_export']);
            $columns_with_title = $ruleObj->getColumns();
            $columns = ElegantalEasyImportTools::unserialize($rule['columns']);
            foreach ($columns as $key => $enabled) {
                if ($enabled != 1) {
                    continue;
                }
                $new_columns[$key] = isset($columns_with_title[$key]) ? $columns_with_title[$key] : $key;
            }
            $ruleObj->columns = ElegantalEasyImportTools::serialize($new_columns);
            $ruleObj->update();
        }
    }

    return true;
}
