<?php
/**
* NOTICE OF LICENSE
*
* This file is part of the 'Wk Warehouses Management For Prestashop 1.7' module feature.
* Developped by Khoufi Wissem (2018).
* You are not allowed to use it on several site
* You are not allowed to sell or redistribute this module
* This header must not be removed
*
*  @author    KHOUFI Wissem - K.W
*  @copyright Khoufi Wissem
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

function upgrade_module_1_60_32($module)
{
    $module->registerHook('displayReassurance');
    $module->registerHook('actionGetProductPropertiesBefore');
    return true;
}
