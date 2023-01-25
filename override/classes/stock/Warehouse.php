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
class Warehouse extends WarehouseCore
{
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:35
    * version: 1.69.76
    */
    public function __construct($id = null, $idLang = null, $idShop = null)
    {
        self::$definition['multilang'] = true;
        self::$definition['fields']['name'] = array(
            'type' => self::TYPE_STRING,
            'lang' => true,
            'validate' => 'isGenericName',
            'required' => true,
            'size' => 255
        );
        self::$definition['fields']['active'] = array(
            'type' => self::TYPE_BOOL,
        );
        if (is_null($idLang)) {
            $idLang = Context::getContext()->language->id;
        }
        parent::__construct($id, $idLang, $idShop);
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:35
    * version: 1.69.76
    */
    public static function getProductWarehouseList($id_product, $id_product_attribute = 0, $id_shop = null)
    {
        $share_stock = false;
        if ($id_shop === null) {
            if (Shop::getContext() == Shop::CONTEXT_GROUP) {
                $shop_group = Shop::getContextShopGroup();
            } else {
                $shop_group = Context::getContext()->shop->getGroup();
                $id_shop = (int) Context::getContext()->shop->id;
            }
            $share_stock = $shop_group->share_stock;
        } else {
            $shop_group = Shop::getGroupFromShop($id_shop);
            $share_stock = $shop_group['share_stock'];
        }
        if ($share_stock) {
            $ids_shop = Shop::getShops(true, (int) $shop_group->id, true);
        } else {
            $ids_shop = array((int) $id_shop);
        }
        $query = new DbQuery();
        $query->select('wpl.id_warehouse, CONCAT(w.reference, " - ", wl.name) as name');
        $query->from('warehouse_product_location', 'wpl');
        $query->innerJoin(
            'warehouse_shop',
            'ws',
            'ws.id_warehouse = wpl.id_warehouse AND id_shop IN (' . implode(',', array_map('intval', $ids_shop)) . ')'
        );
        $query->innerJoin('warehouse', 'w', 'ws.id_warehouse = w.id_warehouse');
        $query->leftJoin(
            'warehouse_lang',
            'wl',
            'w.`id_warehouse` = wl.`id_warehouse` AND `id_lang` = '.(int)Context::getContext()->language->id
        );
        $query->where('id_product = ' . (int) $id_product);
        $query->where('id_product_attribute = ' . (int) $id_product_attribute);
        $query->where('w.deleted = 0');
        if (!defined('_PS_ADMIN_DIR_')) {
        	$query->where('w.active = 1');
		}
        $query->groupBy('wpl.id_warehouse');
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:35
    * version: 1.69.76
    */
    public static function getWarehouses($ignore_shop = false, $id_shop = null)
    {
        if (!$ignore_shop) {
            if (null === $id_shop) {
                $id_shop = Context::getContext()->shop->id;
            }
        }
        $query = new DbQuery();
        $query->select('w.id_warehouse, CONCAT(reference, \' - \', wl.name) as name');
        $query->from('warehouse', 'w');
        $query->leftJoin(
            'warehouse_lang',
            'wl',
            'w.`id_warehouse` = wl.`id_warehouse` AND `id_lang` = '.(int)Context::getContext()->language->id
        );
        $query->where('deleted = 0');
        if (!defined('_PS_ADMIN_DIR_')) {
            $query->where('active', '=', 1);
        }
        $query->orderBy('reference ASC');
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:35
    * version: 1.69.76
    */
    public static function getWarehousesByProductId($id_product, $id_product_attribute = 0)
    {
        if (!$id_product && !$id_product_attribute) {
            return array();
        }
        $query = new DbQuery();
        $query->select('DISTINCT w.id_warehouse, CONCAT(w.reference, " - ", wl.name) as name');
        $query->from('warehouse', 'w');
        $query->leftJoin(
            'warehouse_lang',
            'wl',
            'w.`id_warehouse` = wl.`id_warehouse` AND `id_lang` = '.(int)Context::getContext()->language->id
        );
        $query->leftJoin('warehouse_product_location', 'wpl', 'wpl.id_warehouse = w.id_warehouse');
        if ($id_product) {
            $query->where('wpl.id_product = ' . (int) $id_product);
        }
        if ($id_product_attribute) {
            $query->where('wpl.id_product_attribute = ' . (int) $id_product_attribute);
        }
        $query->orderBy('w.reference ASC');
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
    }
}
