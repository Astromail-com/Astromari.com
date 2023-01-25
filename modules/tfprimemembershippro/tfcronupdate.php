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

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include_once 'tfprimemembershippro.php';

class PrestaCronUpdate
{
    public function updatePrimeUserInfo()
    {
        $objPrimeMember = new TfPrimeMembershipPro();
        if (Tools::substr(Tools::encrypt($objPrimeMember->name.'/cron'), 0, 10) != Tools::getValue('token') ||
            !Module::isInstalled($objPrimeMember->name)
        ) {
            //die('Bad Token');
        }
        $objPrimeUser = new TfPrimeMembershipCustomer();
        $allPrimeUsers = $objPrimeUser->getAllPrimeUser();
        if ($allPrimeUsers) {
            foreach ($allPrimeUsers as $prime) {
                $activatedDate = strtotime($prime['activated_date']);
                if ($activatedDate == 0 || $activatedDate === false || $activatedDate < 0) {
                } else {
                    $endDate = date(
                        "Y-m-d",
                        strtotime($prime['expiry_date'])
                    );
                    $currentDate = date("Y-m-d");
                    if ($currentDate > $endDate) {
                        $oldPrimeUser = new TfPrimeMembershipCustomer($prime['id_tf_prime_membership_customer']);
                        $oldPrimeUser->active = 2;
                        if ($oldPrimeUser->update()) {
                            $oldPrimeUser->removeCustomerFromPrimeGroup(
                                $prime['id_customer'],
                                $prime['id_customer_group']
                            );
                        }
                    }

                    // Check warning display or not
                    $date2 = date_create($endDate);
                    $date1 = date_create($currentDate);
                    $diff = date_diff($date1, $date2);
                    $days = $diff->format("%R%a");
                    if ($days > 0) {
                        $days = $diff->format("%a");
                        if ($days <= Configuration::get('PRESTA_PRIME_WARNING_DISPLAY_DAYS') &&
                            !$prime['is_warning_sent']
                        ) {
                            if ($this->sendWarningMailToCustomer($prime)) {
                                $oldPrimeUser = new TfPrimeMembershipCustomer($prime['id']);
                                $oldPrimeUser->is_warning_sent = 1;
                                $oldPrimeUser->update();
                            }
                        }
                    }
                }
            }
        }
        die('DONE');
    }

    public function sendWarningMailToCustomer($prime)
    {
        $context = Context::getContext();
        $customer = new Customer((int) $prime['id_customer']);
        $customer_vars = array(
            '{name}' => $customer->firstname.' '.$customer->lastname,
            '{email}' => $customer->email,
            '{plan_name}' => Product::getProductName($prime['id_product']),
            '{plan_price}' => Tools::displayPrice(
                $prime['price'],
                new Currency($prime['id_currency'])
            ),
            '{plan_type}' => $this->checkPlanType($prime['type']),
            '{extend_url}' => $context->link->getModuleLink('prestaprimemembership', 'primeprocess'),
        );
        if ($customer->email && Validate::isEmail($customer->email)) {
            return Mail::Send(
                (int) $context->language->id,
                'presta_prime_warning',
                Mail::l('Prime Membership Warning', (int) $context->language->id),
                $customer_vars,
                $customer->email,
                null,
                null,
                null,
                null,
                null,
                _PS_MODULE_DIR_.'prestaprimemembership/mails/',
                false,
                null,
                null
            );
        }
    }

    public function checkPlanType($val)
    {
        $objPrimeMember = new PrestaPrimeMembership();
        if ($val == 'day') {
            return $objPrimeMember->l('Day Wise');
        } elseif ($val == 'month') {
            return $objPrimeMember->l('Montly');
        } elseif ($val == 'year') {
            return $objPrimeMember->l('Yearly');
        }
    }
}

$objPrestaCronUpdate = new PrestaCronUpdate();
$objPrestaCronUpdate->updatePrimeUserInfo();
