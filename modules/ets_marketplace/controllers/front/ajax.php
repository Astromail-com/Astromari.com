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

if (!defined('_PS_VERSION_'))
	exit;
class Ets_MarketPlaceAjaxModuleFrontController extends ModuleFrontController
{
    public function __construct()
	{
		parent::__construct();
	}
    public function postProcess()
    {
        parent::postProcess();
        if(!$this->context->customer->isLogged() || (!$this->module->_getSeller() && Configuration::get('ETS_MP_REQUIRE_REGISTRATION')))
        {
            die(
                json_encode(
                    array(
                        'errors' => $this->module->l('Not login','ajax'),
                    )
                )
            );
        }
        if(Tools::isSubmit('ajaxSearchProduct'))
        {
            $this->displayAjaxProductsList();
        }
        if(Tools::isSubmit('ajaxSearchCustomer'))
        {
            $this->displayAjaxCustomersList();
        }
    }
    public function displayAjaxCustomersList()
    {
        $query = trim(Tools::getValue('q', false));
        if(empty($query) || !Validate::isCleanHtml($query))
            die();
        $customers = Ets_mp_defines::searchCustomerByQuery($query);
        if($customers)
        {
            foreach($customers as $customer)
            {
                echo $customer['id_customer'].'|'.$customer['firstname'].' '.$customer['lastname'].'|'.$customer['email']."\n";
            }
        }
        die();
    }
    public function displayAjaxProductsList()
    {
        $query = trim(Tools::getValue('q', false));
        if (empty($query) || !Validate::isCleanHtml($query)) {
            die();
        }
        if ($pos = Tools::strpos($query, ' (ref:')) {
            $query = Tools::substr($query, 0, $pos);
        }
        $excludeIds = Tools::getValue('excludeIds', false);
        if ($excludeIds && $excludeIds != 'NaN') {
            $excludeIds = implode(',', array_map('intval', explode(',', $excludeIds)));
        } else {
            $excludeIds = '';
        }
        $disableCombination = (bool)Tools::getValue('disableCombination', false);
        $excludeVirtuals = (bool) Tools::getValue('excludeVirtuals', false);
        $exclude_packs = (bool) Tools::getValue('exclude_packs', false);
        $active = (int)Tools::getValue('active') ? 1 :0;
        $id_customer_seller = $this->module->_getSeller()->id_customer;
        Ets_mp_product::ajaxSearchProductByQuery($query,$id_customer_seller,$active,$excludeVirtuals,$exclude_packs,$disableCombination,$excludeIds);
        die();
    }
 }