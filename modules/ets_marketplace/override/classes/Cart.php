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

class Cart extends CartCore
{
    public function getPackageShippingCost($id_carrier = null, $use_tax = true, Country $default_country = null, $product_list = null, $id_zone = null,bool $keepOrderPrices=false)
    {
        if (null === $product_list) {
            $products = $this->getProducts(false, false, null, true);
        } else {
            $products = $product_list;
        }
        $marketplace = Module::getInstanceByName('ets_marketplace');
        if($sellers = $marketplace->checkMultiSellerProductList($products))
        {
            $shipping_cost = 0;
            foreach($sellers as $seller)
            {
                $is_virtual= true;
                if($seller)
                {
                    foreach($seller as $p)
                    {
                        if(!$p['is_virtual'])
                        {
                            $is_virtual = false;
                        }
                    }
                }
                if(($price=parent::getPackageShippingCost($id_carrier,$use_tax,$default_country,$seller,$id_zone,$keepOrderPrices))===false && !$is_virtual)
                    return false;
                $shipping_cost += $is_virtual ? 0 : ( $price? :0);
            }
            return $shipping_cost;
        }
        return parent::getPackageShippingCost($id_carrier,$use_tax,$default_country,$products,$id_zone,$keepOrderPrices);
    }
    public function getPackageList($flush = false)
    {
        $final_package_list = parent::getPackageList($flush);
        if($final_package_list)
        {
            foreach($final_package_list as $final_packages)
            {
                foreach($final_packages as $final_package)
                {
                    if(!$final_package['carrier_list'] || ($final_package['carrier_list'] && isset($final_package['carrier_list'][0]) && $final_package['carrier_list'][0]===0))
                    {  
                        return array();
                    }
                }
                
            }
        }
        return $final_package_list;
    }
    public function getDeliveryOptionList(Country $default_country = null, $flush = false)
    {
        $products = $this->getProducts(false, false, null, true);
        $marketplace = Module::getInstanceByName('ets_marketplace');
        if($marketplace->checkMultiSellerProductList($products) && $marketplace->is17 && Configuration::get('ETS_MP_ENABLE_MULTI_SHIPPING'))
        {
            $delivery_option_list = $marketplace->getDeliveryOptionList($default_country,$flush);
            return $delivery_option_list;
        }
        else
        {
            $delivery_option_list = parent::getDeliveryOptionList($default_country,$flush);
        
            return $marketplace->changeDeliveryOptionList($delivery_option_list);
        }
    }
}