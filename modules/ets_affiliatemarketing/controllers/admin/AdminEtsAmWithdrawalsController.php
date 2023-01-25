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

class AdminEtsAmWithdrawalsController extends ModuleAdminController
{
    public function init()
    {
        parent::init();
        $context = Context::getContext();
        if(Tools::isSubmit('downloadInvoice') && ($id_withdraw = (int)Tools::getValue('id_withdraw')) && ($withdraw = new Ets_Withdraw($id_withdraw)) && Validate::isLoadedObject($withdraw))
        {
            $withdraw->downloadInvoice();
        }
        $redirectUrl = $context->link->getAdminLink('AdminModules') . '&configure=ets_affiliatemarketing&tabActive=withdraw_list';
        Tools::redirectAdmin($redirectUrl);
        exit();
    }
}