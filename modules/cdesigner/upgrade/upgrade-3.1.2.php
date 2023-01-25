<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
exit; 

function upgrade_module_3_1_2($object)
{
    $object->registerHook('displayAdminOrder');
    
    return Db::getInstance()->execute('
        ALTER TABLE `'._DB_PREFIX_.'cdesigner_cfields`
        ADD COLUMN  `allow_upload` tinyint(1) unsigned NOT NULL DEFAULT \'1\',
        ADD COLUMN  `allow_help` tinyint(1) unsigned NOT NULL DEFAULT \'1\',
        ADD COLUMN  `required_field` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
        ADD COLUMN  `allow_zone` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
        ADD COLUMN  `allow_comb` tinyint(1) unsigned NOT NULL DEFAULT \'0\';
    ');
}