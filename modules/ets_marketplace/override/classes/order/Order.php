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
 * @author ETS-Soft <contact@etssoft.net>
 * @copyright  2007-2022 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

class Order extends OrderCore
{
    public function __construct($id = null, $id_lang = null)
    {
        parent::__construct($id, $id_lang);
        if(($controller= Tools::getValue('controller')) && Validate::isControllerName($controller) && $controller=='orderconfirmation' && ($id_cart = (int)Tools::getValue('id_cart')) && $id_cart==$this->id_cart)
        {
            $id_order_current = Order::getIdByCartId((int) ($id_cart));
            if($id_order_current==$this->id)
            {
                $orders = Db::getInstance()->executeS('SELECT id_order FROM `'._DB_PREFIX_.'orders` WHERE id_order!="'.(int)$this->id.'" AND id_cart="'.(int)$this->id_cart.'"');
                if($orders)
                {
                    
                    foreach($orders as $order)
                    {
                        $class_order = new Order($order['id_order']);
                        $this->total_paid += $class_order->total_paid;
                        $this->total_paid_real += $class_order->total_paid_real;
                        $this->total_paid_tax_incl += $class_order->total_paid_tax_incl;
                        $this->total_paid_tax_excl += $class_order->total_paid_tax_excl;
                        $this->total_discounts_tax_incl += $class_order->total_discounts_tax_incl;
                        $this->total_discounts_tax_excl += $class_order->total_discounts_tax_excl;
                        $this->total_shipping_tax_incl += $class_order->total_shipping_tax_incl;
                        $this->total_shipping_tax_excl += $class_order->total_shipping_tax_excl;
                        $this->total_wrapping_tax_incl += $class_order->total_wrapping_tax_incl;
                        $this->total_wrapping_tax_excl += $class_order->total_wrapping_tax_excl;
                        $this->total_products_wt += $class_order->total_products_wt;
                        $this->total_products += $class_order->total_products;
                    }
                }
            }
        }
    }
    public function getProductsDetail()
    {
        if(($controller = Tools::getValue('controller')) && Validate::isControllerName($controller) && $controller =='orderconfirmation' && ($id_cart = (int)Tools::getValue('id_cart')) && $id_cart==$this->id_cart)
        {
            $id_order_current = Order::getIdByCartId((int) ($id_cart));
            if($id_order_current==$this->id)
            {
               return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
               SELECT od.*,ps.id_product
               FROM `' . _DB_PREFIX_ . 'order_detail` od
               INNER JOIN `'._DB_PREFIX_.'orders` o ON (od.id_order=o.id_order)
               LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON (p.id_product = od.product_id)
               LEFT JOIN `' . _DB_PREFIX_ . 'product_shop` ps ON (ps.id_product = p.id_product AND ps.id_shop = od.id_shop)
               WHERE o.`id_cart` = ' . (int) $this->id_cart);
            } 
        }
        return parent::getProductsDetail();
    }
    public static function getIdByCartId($id_cart)
    {
        $sql = 'SELECT `id_order` 
            FROM `' . _DB_PREFIX_ . 'orders`
            WHERE `id_cart` = ' . (int) $id_cart .
            Shop::addSqlRestriction();

        $result = Db::getInstance()->getValue($sql);

        return !empty($result) ? (int) $result : false;
    }
    public function addCartRule($id_cart_rule, $name, $values, $id_order_invoice = 0, $free_shipping = null)
    {
        $order_cart_rule = new OrderCartRule();
        $order_cart_rule->id_order = $this->id;
        $order_cart_rule->id_cart_rule = $id_cart_rule;
        $order_cart_rule->id_order_invoice = $id_order_invoice;
        $order_cart_rule->name = $name;
        $order_cart_rule->value = $values['tax_incl'];
        $order_cart_rule->value_tax_excl = $values['tax_excl'];
        if ($free_shipping === null) {
            $cart_rule = new CartRule($id_cart_rule);
            $free_shipping = $cart_rule->free_shipping;
        }
        $order_cart_rule->free_shipping = (int) $free_shipping;
        $order_cart_rule->add();
        if($this->total_discounts_tax_excl!= $order_cart_rule->value_tax_excl)
        {
            $this->total_paid_tax_excl +=($this->total_discounts_tax_excl- $order_cart_rule->value_tax_excl);
            $this->total_paid_tax_incl += ($this->total_discounts_tax_incl - $order_cart_rule->value);
            $this->total_paid_tax_incl = Tools::ps_round($this->total_paid_tax_incl,_PS_PRICE_COMPUTE_PRECISION_);
            $this->total_paid_tax_excl = Tools::ps_round($this->total_paid_tax_excl,_PS_PRICE_COMPUTE_PRECISION_);
            $this->total_paid = Tools::ps_round($this->total_paid_tax_incl,_PS_PRICE_COMPUTE_PRECISION_);
            $this->total_discounts_tax_excl = Tools::ps_round($order_cart_rule->value_tax_excl,_PS_PRICE_COMPUTE_PRECISION_);
            $this->total_discounts_tax_incl = Tools::ps_round($order_cart_rule->value,_PS_PRICE_COMPUTE_PRECISION_);
            $this->total_discounts = $this->total_discounts_tax_incl;
            $this->update();
        }
        
    }
}