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
 
class CustomerThread extends CustomerThreadCore
{
    public static function getCustomerMessagesOrder($id_customer, $id_order)
    {
        if(Module::getInstanceByName('ets_marketplace'))
        {
            return Ets_mp_contact_message::getCustomerMessagesOrder($id_customer, $id_order);
        }
        return parent::getCustomerMessagesOrder($id_customer,$id_order);
    }
}