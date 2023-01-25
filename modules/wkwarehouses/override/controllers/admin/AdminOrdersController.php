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

class AdminOrdersController extends AdminOrdersControllerCore
{
    protected function reinjectQuantity($order_detail, $qty_cancel_product, $delete = false)
    {
        $id_lang = (int)$this->context->language->id;
        $id_shop = (int)$order_detail->id_shop;
        $id_product = (int)$order_detail->product_id;
        $product = new Product($id_product, false, $id_lang, $id_shop);

        if (!Module::isEnabled('wkwarehouses') || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') ||
            !class_exists('WorkshopAsm') || !$product->advanced_stock_management) {
            return parent::reinjectQuantity($order_detail, $qty_cancel_product, $delete);
        }

        $reinjectable_quantity = (int)$order_detail->product_quantity - (int)$order_detail->product_quantity_reinjected;
        $quantity_to_reinject = $qty_cancel_product > $reinjectable_quantity ? $reinjectable_quantity : $qty_cancel_product;

        if ($order_detail->id_warehouse != 0) {
            $id_product_attribute = (int)$order_detail->product_attribute_id;
            // Update shop quantities
            StockAvailable::updateQuantity(
                $id_product,
                $id_product_attribute,
                $quantity_to_reinject,
                $id_shop,
                true,
                array(
                    'id_order' => $order_detail->id_order,
                    'id_stock_mvt_reason' => Configuration::get('PS_STOCK_CUSTOMER_RETURN_REASON')
                )
            );
            if (class_exists('PrestaShop\PrestaShop\Adapter\StockManager')) {
                (new PrestaShop\PrestaShop\Adapter\StockManager())->updatePhysicalProductQuantity(
                    $id_shop,
                    (int)Configuration::get('PS_OS_ERROR'),
                    (int)Configuration::get('PS_OS_CANCELED'),
                    null,
                    (int)$order_detail->id_order
                );
            }
            if ($delete) {
                $order_detail->delete();
                /* Very important to sync product to update correct quantities in stock_available table */
                if (class_exists('PrestaShop\PrestaShop\Adapter\StockManager')) {
                    (new PrestaShop\PrestaShop\Adapter\StockManager())->updatePhysicalProductQuantity(
                        (int)$id_shop,
                        (int)Configuration::get('PS_OS_ERROR'),
                        (int)Configuration::get('PS_OS_CANCELED'),
                        $id_product
                    );
                }
                (new WorkshopAsm())->synchronize(
                    (int)$order_detail->product_id,
                    (int)$order_detail->product_attribute_id,
                    null,
                    array(),
                    false,
                    $order_detail->id_warehouse
                );
            }
        } else {
            $this->errors[] = $this->trans('This product cannot be re-stocked.', array(), 'Admin.Orderscustomers.Notification');
        }
    }
}
