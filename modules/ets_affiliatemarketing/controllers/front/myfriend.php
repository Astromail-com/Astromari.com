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
 * needs please, contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <contact@etssoft.net>
 * @copyright  2007-2023 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

class Ets_affiliatemarketingMyfriendModuleFrontController extends Ets_affiliatemarketingAllModuleFrontController
{

    public $auth = true;
    public $guestAllowed = false;
    public $authRedirection = URL_REF_PROGRAM;

    public function init()
    {
        parent::init();

        if (!$this->module->is17) {
            $this->display_column_left = false;
            $this->display_column_right = false;
        }
    }

    /**
     * @throws PrestaShopException
     */
    public function initContent()
    {
        parent::initContent();
        if(!$this->context->customer->isLogged())
            Tools::redirect($this->context->link->getPageLink('my-account'));
        $friendly_url = (int)Configuration::get('PS_REWRITING_SETTINGS');
        $link_tab = array(
            'my_friends' =>  Ets_AM::getBaseUrlDefault('myfriend'),
            'ref_friends' => Ets_AM::getBaseUrlDefault('refer_friends'),
        );
        //Set meta
        $page= 'module-'.$this->module->name.'-sponsorship';
        $meta = Meta::getMetaByPage($page,$this->context->language->id);
        $this->setMetas(array(
            'title' => isset($meta['title']) && $meta['title'] ? $meta['title'] : $this->module->l('My friends','myfriend'),
            'keywords' => isset($meta['keywords']) && $meta['keywords'] ? $meta['keywords'] : $this->module->l('My friends','myfriend'),
            'description' => isset($meta['description']) && $meta['description'] ? $meta['description'] : $this->module->l('My friends','myfriend'),
        ));

        $this->context->smarty->assign(array(
            'link_tab' => $link_tab,
        ));
        if(Ets_Sponsor::isRefferalProgramReady()){
            $template ='sponsorship_reward_history.tpl';
            $customer = $this->context->customer;

            /* == Check state program ======*/
            $alert_type = '';
            $userExists = Ets_User::getUserByCustomerId($this->context->customer->id);

            if($userExists){
                if( $userExists['status'] == -1){
                    $alert_type = 'account_banned';
                }
                elseif($userExists['status'] > 0 && $userExists['ref'] == 1 ){
                    $alert_type = 'registered';
                }
                elseif($userExists['status'] > 0 && $userExists['ref'] == -1 ){
                    $alert_type = 'program_suspened';
                }
                elseif($userExists['status'] > 0 && $userExists['ref'] == -2 ){
                    $alert_type = 'program_declined';
                } 
                else {
                    $p = Ets_Participation::getProgramRegistered($this->context->customer->id, 'ref');
                    if($p){
                        if($p['status'] == 0){
                            $alert_type = 'register_success';
                        }
                        elseif($p['status'] == 1){
                            $alert_type = 'registered';
                        }
                        elseif($p['status'] < 0){
                            $alert_type = 'program_declined';
                        }
                    }
                    else{

                        if(Configuration::get('ETS_AM_REF_REGISTER_REQUIRED')){
                            $url_register = Ets_AM::getBaseUrlDefault('register',array('p'=>'ref'));
                            Tools::redirect($url_register);
                        }
                    }
                }
            } else{
                $p = Ets_Participation::getProgramRegistered($this->context->customer->id, 'ref');
                if($p){
                    if($p['status'] == 0){
                        $alert_type = 'register_success';
                    }
                    elseif($p['status'] == 1){
                        $alert_type = 'registered';
                    }
                    elseif($p['status'] < 0){
                        $alert_type = 'program_declined';
                    }
                }
                else{

                    if(Configuration::get('ETS_AM_REF_REGISTER_REQUIRED')){
                        $url_register = Ets_AM::getBaseUrlDefault('register',array('p'=>'ref'));
                        Tools::redirect($url_register);
                    }
                }
            }

            $message = '';
            if(!$alert_type){
                $res_data = Ets_Sponsor::canUseRefferalProgramReturn(Context::getContext()->customer->id);
                if(!$res_data['success']){
                    $alert_type = 'need_condition';
                    $message = Configuration::get('ETS_AM_REF_MSG_CONDITION', $this->context->language->id) ? strip_tags(Configuration::get('ETS_AM_REF_MSG_CONDITION', $this->context->language->id)) : '';
                    if(isset($res_data['min_order']) && isset($res_data['total_order'])){
                        $message  = str_replace('[min_order_total]', Ets_affiliatemarketing::displayPrice(Tools::convertPrice($res_data['min_order'], $this->context->currency->id, true), $this->context->currency->id), $message);
                        $message  = str_replace('[total_past_order]', Ets_affiliatemarketing::displayPrice(Tools::convertPrice($res_data['total_order'], $this->context->currency->id, true), $this->context->currency->id), $message);
                        $message  = str_replace('[amount_left]', Ets_affiliatemarketing::displayPrice(Tools::convertPrice((float)$res_data['min_order'] - (float)$res_data['total_order'], $this->context->currency->id, true), $this->context->currency->id), $message);
                    }
                    elseif(isset($res_data['not_in_group'])){
                        $message = '';
                    }
                    if(!$message){
                        Tools::redirect($this->context->link->getPageLink('my-account', true));
                    }
                }
            }
            $this->context->smarty->assign(array(
                'alert_type' => $alert_type,
                'message' => $message
            ));
            /* == End Check state program ======*/
                
            if (Ets_Sponsor::isJoinedRef($customer->id)  && (!$alert_type || $alert_type == 'registered')) {
                $tab_active = 'my-friends';
                if($id_customer = (int)Tools::getValue('id_customer'))
                {
                    if(!Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'ets_am_sponsor` WHERE id_customer="'.(int)$id_customer.'" AND id_parent='.(int)$customer->id))
                        Tools::redirect($this->context->link->getPageLink('index'));
                    $template = 'sponsorship_customer.tpl';
                    $customer_info = Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'customer` WHERE id_customer='.(int)$id_customer);
                    $customer_info['orders'] = Db::getInstance()->getValue('SELECT COUNT(DISTINCT o.id_order) FROM `'._DB_PREFIX_.'orders` o,'._DB_PREFIX_.'ets_am_reward r WHERE o.id_order=r.id_order AND o.id_customer='.(int)$id_customer.' AND program="ref" AND sub_program!="REG"');
                    $customer_info['level'] = Db::getInstance()->getValue('SELECT level FROM `'._DB_PREFIX_.'ets_am_sponsor` WHERE id_customer='.(int)$id_customer.' AND id_parent='.(int)$this->context->customer->id);
                    $customer_info['approved'] = Db::getInstance()->getValue('SELECT COUNT(DISTINCT o.id_order) FROM `'._DB_PREFIX_.'orders` o,'._DB_PREFIX_.'ets_am_reward r WHERE o.id_order=r.id_order AND o.id_customer='.(int)$id_customer.' AND r.status=1');
                    $customer_info['friends'] = Db::getInstance()->getValue('SELECT COUNT(DISTINCT id_customer) FROM `'._DB_PREFIX_.'ets_am_sponsor` WHERE id_parent='.(int)$id_customer);
                    $sql = 'SELECT *,o.id_currency as currency FROM `'._DB_PREFIX_.'orders` o,'._DB_PREFIX_.'ets_am_reward r WHERE o.id_order=r.id_order AND o.id_customer='.(int)$id_customer.' AND r.id_friend='.(int)$id_customer.' AND r.id_customer='.(int)$this->context->customer->id.' AND program="ref" AND sub_program!="REG"';
                    if(($order_sale_status = Tools::getValue('order_sale_status')) || ($order_sale_status!=='' && $order_sale_status!== false && $order_sale_status!== null))
                        $sql .= ' AND r.status='.(int)$order_sale_status;
                    if($type_date_filter = Tools::getValue('order_sale_filter'))
                    {
                        if ($type_date_filter == 'this_month') {
                            $sql .= " AND r.datetime_added >= '" . date('Y-m-01 00:00:00') . "' AND r.datetime_added <= '" . date('Y-m-t 23:59:59') . "'";
                        } else if ($type_date_filter == 'this_year') {
                            $sql .= " AND r.datetime_added >= '" . date('Y-01-01 00:00:00') . "' AND r.datetime_added <= '" . date('Y-12-31 23:59:59') . "'";
                        }
                    }
                    $sql .=' ORDER BY o.id_order DESC';
                    if($customer_info['level']==1)
                    {
                        $customer_info['price_register'] = (float)Db::getInstance()->getValue('SELECT amount FROM `'._DB_PREFIX_.'ets_am_reward` WHERE id_friend="'.(int)$id_customer.'" AND id_customer="'.(int)$this->context->customer->id.'" AND sub_program="REG" AND status=1');
                        if($customer_info['price_register'])
                            $customer_info['price_register'] = Ets_AM::displayReward($customer_info['price_register'],true);
                    }

                    $customer_info['list_orders'] = Db::getInstance()->executeS($sql);
                    if($customer_info['list_orders'])
                    {
                        foreach($customer_info['list_orders'] as &$order)
                        {
                            $order['total_paid_tax_incl'] = Ets_affiliatemarketing::displayPrice($order['total_paid_tax_incl'],(int)$order['currency']);
                            $order['amount'] = Ets_AM::displayReward($order['amount']);
                        }
                    }
                    $this->context->smarty->assign(
                        array(
                            'customer_info' => $customer_info,
                            'ETS_AM_DISPLAY_ID_ORDER' => Configuration::get('ETS_AM_DISPLAY_ID_ORDER'),
                            'link_back' => Ets_AM::getBaseUrlDefault('myfriend')
                        )
                    );
                }
                else
                {
                    $template ='sponsorship_myfriend.tpl';

                    $this->setMetas(array(
                        'title' => $this->module->l('My friends','myfriend'),
                        'keywords' => $this->module->l('My friends','myfriend'),
                        'description' => $this->module->l('My friends','myfriend'),
                    ));
                    $friends = Ets_Sponsor::getDetailSponsors($customer->id, array(
                        'orderby' => Tools::getValue('orderBy'),
                        'orderway' => Tools::getValue('orderWay'),
                        'page' => Tools::getValue('page'),
                        'limit' => Tools::getValue('limit'),
                        'customer_sale_filter' => Tools::getValue('customer_sale_filter'),
                    ), true);
                    $this->context->smarty->assign(array(
                        'friends' => $friends,
                        'query' => Tools::getAllValues(),
                        'display_email' => (int)Configuration::get('ETS_AM_REF_DISPLAY_EMAIL_SPONSOR'),
                        'display_name' => (int)Configuration::get('ETS_AM_REF_DISPLAY_NAME_SPONSOR'),
                    ));
                }
                $this->context->smarty->assign(array(
                    'template' => $template,
                    'tab_active' => $tab_active,
                    'query' => Tools::getAllValues()
                ));
            }
            else{
                if(!$alert_type){
                    $alert_type = 'register_success';
                }
                
                $template = 'my_friends.tpl';
                $this->context->smarty->assign(array(
                    'alert_type' => $alert_type,
                    'template' => $template,
                ));
            }
        }
        else{
            $this->context->smarty->assign(array(
                'alert_type' => 'disabled',
            ));
        };
        
        if ($this->module->is17) {
            $this->setTemplate('module:ets_affiliatemarketing/views/templates/front/sponsorship.tpl');
        } else {
            $this->setTemplate('sponsorship16.tpl');
        }
    }
    public function setMedia(){
        parent::setMedia();
        $this->addJs(_PS_MODULE_DIR_ . 'ets_affiliatemarketing/views/js/share_social.js');
    }
}