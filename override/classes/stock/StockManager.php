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
class StockManager extends StockManagerCore implements StockManagerInterface
{
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:35
    * version: 1.69.76
    */
    public function getProductRealQuantities($id_product, $id_product_attribute, $ids_warehouse = null, $usable = false)
    {
        if (!Module::isEnabled('wkwarehouses') || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return parent::getProductRealQuantities($id_product, $id_product_attribute, $ids_warehouse, $usable);
        }
        if (!class_exists('WorkshopAsm')) {
            require_once(dirname(__FILE__).'/../../../modules/wkwarehouses/classes/WorkshopAsm.php');
        }
        return WorkshopAsm::getProductPhysicalQuantities($id_product, $id_product_attribute, $ids_warehouse);
    }
}
