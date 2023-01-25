<?php
/**
 * 2007-2023 ETS-Soft
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
 *  @author ETS-Soft <contact@etssoft.net>
 *  @copyright  2007-2023 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;

class AdminEtsAmAffiliateController extends ModuleAdminController
{
    public function init()
    {
        $context = Context::getContext();
        if(Tools::isSubmit('ajax_search_customer'))
        {
            if(($q = (string)strip_tags(Tools::getValue('q'))) && Validate::isCleanHtml($q))
            {
                $customers = Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'customer` WHERE
                active=1 AND id_shop="'.(int)Context::getContext()->shop->id.'" AND ( 
                 firstname like "%'.pSQL($q).'%" 
                OR lastname like "%'.pSQL($q).'%" 
                OR CONCAT(firstname," ",lastname) like "%'.pSQL($q).'%" 
                OR email like "%'.pSQL($q).'%"
                '.(Validate::isInt($q) ? ' OR id_customer= '.(int)$q : '').'
                )');
                if($customers)
                {
                    foreach($customers as $customer)
                        echo $customer['id_customer'].'|'.$customer['email'].'|'.$customer['firstname'].' '.$customer['lastname']."\n";
                }
            }
            exit();
        }
        $redirectUrl = $context->link->getAdminLink('AdminModules') . '&configure=ets_affiliatemarketing&tabActive=affiliate_conditions';
        Tools::redirectAdmin($redirectUrl);
        exit();
    }
}
