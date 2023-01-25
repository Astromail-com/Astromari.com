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
 *  @author ETS-Soft <contact@etssoft.net>
 *  @copyright  2007-2023 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;
function upgrade_module_1_1_3($object)
{
    $sqls= array();
    if(!$object->checkCreatedColumn('ets_am_withdrawal','fee'))
        $sqls[]="ALTER TABLE `"._DB_PREFIX_."ets_am_withdrawal` ADD COLUMN `fee` float(10,2)";
    if(!$object->checkCreatedColumn('ets_am_withdrawal','fee_type'))
        $sqls[]="ALTER TABLE `"._DB_PREFIX_."ets_am_withdrawal` ADD COLUMN `fee_type` VARCHAR(222)";
    if($sqls)
    {
        foreach($sqls as $sql)
            Db::getInstance()->execute($sql);
    }
    return true;
}