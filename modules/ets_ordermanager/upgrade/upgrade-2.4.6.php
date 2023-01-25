<?php
/**
 * 2007-2023 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2023 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;
function upgrade_module_2_4_6($object)
{
    $sqls = array();
    if(!Ode_dbbase::checkCreatedColumn('ets_export_order_rule','convert_in_currency'))
    {
        $sqls[]='ALTER TABLE `'._DB_PREFIX_.'ets_export_order_rule` ADD `convert_in_currency` INT(11)';
    }
    if($sqls)
    {
        foreach($sqls as $sql)
        {
            Db::getInstance()->execute($sql);
        }
    }
    return true;    
}