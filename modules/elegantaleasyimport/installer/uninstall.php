<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This file returns array of SQL queries that are required to be executed during module uninstallation.
 */
$sql = array();

// Drop tables that are created during module installation. Note: order of queries is important here.
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport_export_shop`";
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport_export`";
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport_error`";
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport_history`";
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport_category_map`";
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport_data`";
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport_shop`";
$sql[] = "DROP TABLE IF EXISTS `" . _DB_PREFIX_ . "elegantaleasyimport`";

return $sql;
