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

class TfPrimeMembershipProPrimeListModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $idCustomer = $this->context->customer->id;
        if (Configuration::get('TF_PRIME_PRO_PLAN_GUEST') || $idCustomer) {
            $objPlan = new TfPrimeMembershipPlan();
            $plans = $objPlan->getPrimePlan(
                $this->context->language->id,
                $this->context->shop->id,
                true
            );
            if ($plans) {
                foreach ($plans as &$plan) {
                    if ($plan['id_currency'] != $this->context->currency->id) {
                        $plan['price'] = Tools::displayPrice(
                            Tools::convertPriceFull(
                                $plan['price'],
                                new Currency($plan['id_currency']),
                                new Currency($this->context->currency->id)
                            )
                        );
                    } else {
                        $plan['price'] = Tools::displayPrice($plan['price'], new Currency($plan['id_currency']));
                    }
                    $plan['type'] = $this->checkPlanType($plan['type']);

                    $imgName = $plan['img_name'];
                    $m = $this->module->name;
                    if ($imgName) {
                        $id = $plan['id_tf_prime_membership_plan'];
                        $img = _PS_MODULE_DIR_.$m.'/views/img/'.$id.'/'.$imgName;
                        if (@getimagesize($img)) {
                            $plan['img_name'] = _MODULE_DIR_.$m.'/views/img/'.$id.'/'.$imgName;
                        } else {
                            $plan['img_name'] = _MODULE_DIR_.$m.'/views/img/default/card.png';
                        }
                    } else {
                        $plan['img_name'] = _MODULE_DIR_.$m.'/views/img/default/card.png';
                    }
                    $obj = new Product($plan['id_product'], false, $this->context->language->id);
                    $plan['link'] = $this->context->link->getProductLink(
                        $obj->id,
                        $obj->link_rewrite,
                        $obj->category,
                        $obj->ean13
                    );
                }
            }
            $this->context->smarty->assign(
                array(
                    'plans' => $plans
                )
            );
            $this->setTemplate('module:'.$this->module->name.'/views/templates/front/primelist.tpl');
        } else {
            Tools::redirect($this->context->link->getPageLink('my-account'));
        }
    }

    public function checkPlanType($val)
    {
        if ($val == 'days') {
            return $this->module->l('Day', 'primelist');
        } elseif ($val == 'months') {
            return $this->module->l('Month', 'primelist');
        } elseif ($val == 'years') {
            return $this->module->l('Year', 'primelist');
        }
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->context->controller->registerStyleSheet(
            'modules-primelist-css',
            'modules/'.$this->module->name.'/views/css/front/primelist.css'
        );
        $this->context->controller->registerJavascript(
            'modules-primepro-js',
            'modules/'.$this->module->name.'/views/js/front/primelist.js'
        );
    }
}
