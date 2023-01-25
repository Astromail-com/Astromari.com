<?php
/**
 * 2007-2022 ETS-Soft
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
 *  @copyright  2007-2022 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
	exit;
function upgrade_module_3_2_5($module)
{
    $sqls = array();
    if(!$module->checkCreatedColumn('ets_mp_product','status'))
    {
        $sqls[] ='ALTER TABLE `'._DB_PREFIX_.'ets_mp_product` ADD `status` INT(1)';
    }
    if(!$module->checkCreatedColumn('ets_mp_product','decline'))
    {
        $sqls[] = 'ALTER TABLE `'._DB_PREFIX_.'ets_mp_product` ADD `decline` text';
    }
    if(!$module->checkCreatedColumn('ets_mp_seller_product','reason'))
    {
        $sqls[] = 'ALTER TABLE `'._DB_PREFIX_.'ets_mp_seller_product` ADD `reason` TEXT';
    }
    if($sqls)
    {
        foreach($sqls as $sql)
            Db::getInstance()->execute($sql);
    }
    Configuration::updateValue('ETS_MP_EMAIL_SELLER_PRODUCT_UPDATE_APPROVED_OR_DECLINED',1);
    Configuration::updateValue('ETS_MP_EMAIL_ADMIN_PRODUCT_UPDATED',1);
    $module->createTemplateMail();
    $module->registerHook('actionObjectProductUpdateBefore');
    return true;
}