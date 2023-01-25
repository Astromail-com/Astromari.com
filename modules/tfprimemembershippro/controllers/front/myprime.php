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

class TfPrimeMembershipProMyPrimeModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        if ($idCustomer = $this->context->customer->id) {
            $objPrimeMember = new TfPrimeMembershipCustomer();
            $isUserPrime = $objPrimeMember->getPrimeUserDetails(
                $idCustomer,
                $this->context->language->id,
                $this->context->shop->id
            );
            if ($isUserPrime) {
                foreach ($isUserPrime as &$prime) {
                    $prime['price'] = Tools::displayPrice(
                        $prime['price'],
                        new Currency($prime['id_currency'])
                    );
                    $activatedDate = strtotime($prime['activated_date']);
                    if ($activatedDate == 0 || $activatedDate === false || $activatedDate < 0) {
                        $prime['timeDuration'] = $this->module->l('N/A');
                        $prime['activated_date'] = $this->module->l('N/A');
                        $prime['planExpired'] = 0;
                    } else {
                        $activatedDate = strtotime($prime['activated_date']);
                        $endDate = date(
                            "M d, Y",
                            strtotime($prime['expiry_date'])
                        );
                        $startDate = date("M d, Y", strtotime($prime['activated_date']));
                        $prime['timeDuration'] = Tools::nl2br($startDate.' <br />To<br /> '.$endDate);
                        $prime['activated_date'] = date("M d, Y", strtotime($prime['activated_date']));

                        $endDate = date(
                            "Y-m-d",
                            strtotime($prime['expiry_date'])
                        );
                        $currentDate = date("Y-m-d");
                        if ($currentDate > $endDate) {
                            $prime['planExpired'] = 1;
                        } else {
                            $prime['planExpired'] = 0;
                        }

                        // Check warning display or not
                        $date2 = date_create($endDate);
                        $date1 = date_create(date('Y-m-d'));
                        $diff = date_diff($date1, $date2);
                        $days = $diff->format("%R%a");
                        if ($days > 0) {
                            $days = $diff->format("%a");
                            if ($days <= Configuration::get('PRESTA_PRIME_WARNING_DISPLAY_DAYS')) {
                                $this->context->smarty->assign(
                                    array(
                                        'presta_expire_warning' => 1
                                    )
                                );
                            }
                        }
                    }

                    $prime['type'] = $this->checkPlanType($prime['type']);
                    if ($prime['prime_customer_active'] == 1) {
                        $prime['plan_status'] = $this->module->l('Active');
                    } elseif ($prime['prime_customer_active'] == 2) {
                        $prime['plan_status'] = $this->module->l('Extended');
                    } else {
                        $activatedDate = strtotime($prime['activated_date']);
                        if ($activatedDate == 0 || $activatedDate === false || $activatedDate < 0) {
                            $prime['plan_status'] = $this->module->l('Pending');
                        } else {
                            $prime['plan_status'] = $this->module->l('Inactive');
                        }
                    }
                    if (TfPrimeMembershipCustomer::getPrimeReferenceByID($prime['id_tf_prime_membership_customer'])) {
                        $prime['prime_reference'] = 1;
                    } else {
                        $prime['prime_reference'] = 0;
                    }
                    $prime['link'] = $this->context->link->getModuleLink(
                        $this->module->name,
                        'primeprocess',
                        array(
                            'id' => $prime['id_plan']
                        )
                    );
                }
                if (Configuration::get('PRESTA_PRIME_PLAN_EXTEND') ||
                    Configuration::get('PRESTA_PRIME_PLAN_RENEW')
                ) {
                    $this->context->smarty->assign(
                        array(
                            'presta_config' => 1
                        )
                    );
                }
                // dump($isUserPrime);
                $this->context->smarty->assign(
                    array(
                        'plans' => $isUserPrime,
                        'mylink' => $this->context->link->getModuleLink($this->module->name, 'myprime'),
                        'primeprocess' => $this->context->link->getModuleLink($this->module->name, 'primeprocess'),
                    )
                );
            }
            $this->setTemplate('module:'.$this->module->name.'/views/templates/front/myprime.tpl');
        } else {
            Tools::redirect($this->context->link->getPageLink('my-account'));
        }
    }

    public function checkPlanType($val)
    {
        if ($val == 'days') {
            return $this->module->l('Day Wise');
        } elseif ($val == 'months') {
            return $this->module->l('Montly');
        } elseif ($val == 'years') {
            return $this->module->l('Yearly');
        }
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->context->controller->registerStyleSheet(
            'modules-myprime-css',
            'modules/'.$this->module->name.'/views/css/front/myprime.css'
        );
    }
}
