<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_2_6($module)
{
    // Save for each shop
    if (Shop::isFeatureActive()) {
        $shop_groups = Shop::getTree();
        foreach ($shop_groups as $shop_group) {
            foreach ($shop_group['shops'] as $shop) {
                $settings = $module->getSettings($shop['id_shop_group'], $shop['id_shop']);

                if (isset($settings['employee_id_for_logging_product_events']) && $settings['employee_id_for_logging_product_events']) {
                    $module->setSetting('employee_id_for_events_log', $settings['employee_id_for_logging_product_events'], $shop['id_shop_group'], $shop['id_shop']);
                }

                $column_value_dictionary = "";
                if (isset($settings['text_quantity_dictionary']) && $settings['text_quantity_dictionary']) {
                    $column_value_dictionary .= '[QUANTITY]' . PHP_EOL . $settings['text_quantity_dictionary'] . PHP_EOL . PHP_EOL;
                }
                if (isset($settings['text_categories_dictionary']) && $settings['text_categories_dictionary']) {
                    $column_value_dictionary .= '[CATEGORY]' . PHP_EOL . $settings['text_categories_dictionary'] . PHP_EOL . PHP_EOL;
                }
                if (isset($settings['text_features_dictionary']) && $settings['text_features_dictionary']) {
                    $column_value_dictionary .= '[FEATURE_NAME]' . PHP_EOL . $settings['text_features_dictionary'] . PHP_EOL . PHP_EOL;
                }
                if (isset($settings['text_feature_values_dictionary']) && $settings['text_feature_values_dictionary']) {
                    $column_value_dictionary .= '[FEATURE_VALUE]' . PHP_EOL . $settings['text_feature_values_dictionary'] . PHP_EOL . PHP_EOL;
                }
                $module->setSetting('text_column_value_dictionary', $column_value_dictionary, $shop['id_shop_group'], $shop['id_shop']);

                $module->deleteSetting('employee_id_for_logging_product_events', $shop['id_shop_group'], $shop['id_shop']);
                $module->deleteSetting('text_quantity_dictionary', $shop['id_shop_group'], $shop['id_shop']);
                $module->deleteSetting('text_categories_dictionary', $shop['id_shop_group'], $shop['id_shop']);
                $module->deleteSetting('text_features_dictionary', $shop['id_shop_group'], $shop['id_shop']);
                $module->deleteSetting('text_feature_values_dictionary', $shop['id_shop_group'], $shop['id_shop']);
            }
        }
    }

    // Save for all shops
    $settings = $module->getSettings("", "");

    if (isset($settings['employee_id_for_logging_product_events']) && $settings['employee_id_for_logging_product_events']) {
        $module->setSetting('employee_id_for_events_log', $settings['employee_id_for_logging_product_events'], "", "");
    }

    $column_value_dictionary = "";
    if (isset($settings['text_quantity_dictionary']) && $settings['text_quantity_dictionary']) {
        $column_value_dictionary .= '[QUANTITY]' . PHP_EOL . $settings['text_quantity_dictionary'] . PHP_EOL . PHP_EOL;
    }
    if (isset($settings['text_categories_dictionary']) && $settings['text_categories_dictionary']) {
        $column_value_dictionary .= '[CATEGORY]' . PHP_EOL . $settings['text_categories_dictionary'] . PHP_EOL . PHP_EOL;
    }
    if (isset($settings['text_features_dictionary']) && $settings['text_features_dictionary']) {
        $column_value_dictionary .= '[FEATURE_NAME]' . PHP_EOL . $settings['text_features_dictionary'] . PHP_EOL . PHP_EOL;
    }
    if (isset($settings['text_feature_values_dictionary']) && $settings['text_feature_values_dictionary']) {
        $column_value_dictionary .= '[FEATURE_VALUE]' . PHP_EOL . $settings['text_feature_values_dictionary'] . PHP_EOL . PHP_EOL;
    }
    $module->setSetting('text_column_value_dictionary', $column_value_dictionary, "", "");

    $module->deleteSetting('employee_id_for_logging_product_events', "", "");
    $module->deleteSetting('text_quantity_dictionary', "", "");
    $module->deleteSetting('text_categories_dictionary', "", "");
    $module->deleteSetting('text_features_dictionary', "", "");
    $module->deleteSetting('text_feature_values_dictionary', "", "");

    return true;
}
