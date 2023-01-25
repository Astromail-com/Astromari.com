<?php
/**
* 2008-2022 Prestaworld
*
* NOTICE OF LICENSE
*
* The source code of this module is under a commercial license.
* Each license is unique and can be installed and used on only one website.
* Any reproduction or representation total or partial of the module, one or more of its components,
* by any means whatsoever, without express permission from us is prohibited.
*
* DISCLAIMER
*
* Do not alter or add/update to this file if you wish to upgrade this module to newer
* versions in the future.
*
* @author    prestaworld
* @copyright 2008-2022 Prestaworld
* @license https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
* International Registered Trademark & Property of prestaworld
*/

class TfPrimeMembershipProPrimeProcessModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $idCustomer = $this->context->customer->id;
        // if ($idCustomer) {
            $id = Tools::getValue('id');
            $TfPrimeMembershipPlan = new TfPrimeMembershipPlan($id);
            if (!Validate::isLoadedObject($TfPrimeMembershipPlan)) {
                Tools::redirect($this->context->link->getPageLink('my-account'));
            }

            $idProduct = $TfPrimeMembershipPlan->id_product;
            $product = new Product($idProduct);
            if (!Validate::isLoadedObject($product)) {
                Tools::redirect($this->context->link->getPageLink('my-account'));
            }

            $idCustomerGroup = $TfPrimeMembershipPlan->id_customer_group;
            $group = new Group($idCustomerGroup);
            if (!Validate::isLoadedObject($group)) {
                Tools::redirect($this->context->link->getPageLink('my-account'));
            }
            /* Update cart */
            $cart = $this->context->cart;
            if (!isset($cart) || !$cart->id) {
                // Create new cart
                $cart = new Cart();
                $cart->id_shop_group = (int) $this->context->shop->id_shop_group;
                $cart->id_shop = $this->context->shop->id;
                if ($this->context->cookie->id_customer) {
                    $cart->id_customer = (int) $this->context->cookie->id_customer;
                    $cart->id_address_delivery = (int) Address::getFirstCustomerAddressId($cart->id_customer);
                    $cart->id_address_invoice = (int) $cart->id_address_delivery;
                } else {
                    $cart->id_address_delivery = 0;
                    $cart->id_address_invoice = 0;
                }
                $cart->id_currency = (int) $this->context->cookie->id_currency;
                $cart->id_lang = (int) $this->context->cookie->id_lang;
                $cart->secure_key = $this->context->customer->secure_key;
                // Save new cart
                $cart->add();

                // Save context (in order to apply cart rule)
                $this->context->cart = $cart;
                $this->context->customer = new Customer((int) $this->context->cookie->id_customer);
            } else {
                $this->context->cart = $cart;
            }
            if ($this->context->cart->id) {
                $this->context->cookie->id_cart = (int)$this->context->cart->id;
            }
            $products = $this->context->cart->getProducts();
            if ($products) {
                foreach ($products as $product) {
                    if (TfPrimeMembershipPlan::getPlanByIdProduct((int) $product['id_product'])) {
                        $this->context->cart->deleteProduct($product['id_product']);
                    }
                }
            }
            $this->context->cart->updateQty(
                1,
                $idProduct,
                null,
                null,
                'up',
                0,
                new Shop($this->context->shop->id)
            );
            Tools::redirect($this->context->link->getPageLink('order'));
        // } else {
        //     Tools::redirect(
        //         'index.php?controller=authentication&back='.
        //         urlencode($this->context->link->getModuleLink($this->module->name, 'primeprocess'))
        //     );
        // }
    }
}
