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
class Address extends AddressCore
{
    /*
    * When we load shipping method, avoid to select a delivery address that don't exist
    * in the delivery addresses collection of the products in cart
    */
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:35
    * version: 1.69.76
    */
    public static function getFirstCustomerAddressId($id_customer, $active = true)
    {
        $context = Context::getContext();
        if (!Module::isEnabled('wkwarehouses') || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') ||
            !Configuration::get('WKWAREHOUSE_ALLOW_MULTIWH_CART') || !$context->cookie->exists() ||
            !Configuration::get('WKWAREHOUSE_ALLOW_MULTICARRIER_CART')) {
            return parent::getFirstCustomerAddressId($id_customer, $active);
        }
        $id_first_address = parent::getFirstCustomerAddressId($id_customer, $active);
        if (!Configuration::get('WKWAREHOUSE_ALLOW_MULTI_ADDRESSES')) {
            return $id_first_address;
        }
        $cart = new Cart($context->cookie->id_cart);
        if (Validate::isLoadedObject($cart) && count($cart->getWsCartRows()) > 1) {
            if ($cart->isMultiAddressDelivery()) {
                $addresses_ids = array();
                foreach ($cart->getAddressCollection() as $address) {
                    $addresses_ids[] = (int)$address->id;
                }
                if (count($addresses_ids) > 0) {
                    $addresses_ids = array_unique(array_filter($addresses_ids));
                    if (!in_array($id_first_address, $addresses_ids)) {
                        $id_first_address = current($addresses_ids);
                    }
                }
            } else {
                $id_first_address = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue(
                    'SELECT DISTINCT(id_address_delivery)
                     FROM `'._DB_PREFIX_.'cart_product`
                     WHERE `id_cart` = '.(int)$cart->id
                );
            }
        }
        return $id_first_address;
    }
}
