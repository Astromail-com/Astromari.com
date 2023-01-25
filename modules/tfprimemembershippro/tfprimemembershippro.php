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

if (!defined('_PS_VERSION_')) {
    exit;
}
include_once 'classes/TfPrimeMembershipClasses.php';

class TfPrimeMembershipPro extends Module
{
    public function __construct()
    {
        $this->name = 'tfprimemembershippro';
        $this->tab = 'front_office_features';
        $this->version = '10.0.0';
        $this->author = 'Techno Flock';
        $this->bootstrap = true;
        $this->secure_key = Tools::encrypt($this->name);
        $this->module_key = '9e4126ef40fab6b01e8812136e5ce396';
        $this->confirmUninstall = $this->l('Do you want to uninstall this module?');
        parent::__construct();
        $this->displayName = $this->l('Become Prime Member');
        $this->description = $this->l('Allow customers to become prime member');
        $this->ps_versions_compliancy = array(
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_
        );
    }

    public function hookDisplayProductPriceBlock($params)
    {
        if ($params['type'] == 'weight' && Tools::getValue('controller') == 'product') {
            $idCustomer = $this->context->customer->id;
            $primeCustomer = new TfPrimeMembershipCustomer();
            $isCustomerHasActivePlan = $primeCustomer->getPrimeUserDetails(
                $idCustomer,
                $this->context->language->id,
                $this->context->shop->id
            );
            if ($isCustomerHasActivePlan) {
                foreach ($isCustomerHasActivePlan as $customerPlan) {
                    if ($customerPlan['active']) {
                        return;
                    }
                }
            }
            $comparePlan = new TfPrimeMembershipPlanCompare();
            $isExist = $comparePlan->getPlanDetail(true);
            if ($isExist) {
                $comparePlan = new TfPrimeMembershipPlanCompare($isExist);
                $originalProductPrice = $params['product']['price_amount'];
                $primeProductPrice = $params['product']['price_amount'];
                $idCustomerGroup = TfPrimeMembershipPlan::getCustomerGroup($comparePlan->id_tf_prime_membership_plan);
                if ($idCustomerGroup) {
                    $group = new Group($idCustomerGroup, $this->context->language->id);
                    if ($group->reduction) {
                        $primeDiscount = (float) ($originalProductPrice * $group->reduction) / 100;
                        $primeProductPrice = $originalProductPrice - $primeDiscount;
                    }
                }

                $originalProductPrice = Tools::displayPrice($originalProductPrice);
                $primeProductPrice = Tools::displayPrice($primeProductPrice);
                $primelistUrl = $this->context->link->getModuleLink($this->name, 'primelist');
                $action_button = '<a href="'.$primelistUrl.'" class="">Join Now</a>';

                $primeMsg = $comparePlan->message[$this->context->language->id];
                $primeMsg = str_replace('{product_price}', $originalProductPrice, $primeMsg);
                $primeMsg = str_replace('{membership_price}', $primeProductPrice, $primeMsg);
                $primeMsg = str_replace('{action_button}', $action_button, $primeMsg);

                $this->context->smarty->assign(
                    array(
                        'prime_plan_url' => $this->context->link->getModuleLink($this->name, 'primelist'),
                        'originalProductPrice' => Tools::displayPrice($originalProductPrice),
                        'primeProductPrice' => Tools::displayPrice($primeProductPrice),
                        'primeMsg' => $primeMsg
                    )
                );
                return $this->display(__FILE__, 'tf_product_price_comparison.tpl');
            }
        }
    }

    public function hookDisplayNav1()
    {
        if (Configuration::get('TF_PRIME_PRO_ADVERTISEMENT')) {
            if (Configuration::get('TF_PRIME_PRO_REDIRECT_LIST')) {
                $link = $this->context->link->getModuleLink($this->name, 'primelist');
            } else {
                $link = $this->context->link->getCMSLink(new CMS(Configuration::get('TF_PRIME_PRO_CMS_PAGE')));
            }
            $this->context->smarty->assign(
                array(
                    'mylink' => $link,
                )
            );
            return $this->display(__FILE__, 'tf_prime_pro_advertisement.tpl');
        }
    }

    public function hookActionOrderStatusPostUpdate($params)
    {
        if (!Configuration::get('TF_PRIME_PRO_MEMBERSHIP_APPROVAL')) {
            $idOrder = $params['id_order'];
            $currentOrderStatus = $params['newOrderStatus']->id;
            $objPrimeMember = new TfPrimeMembershipCustomer();
            $isPrimeUserExist = $objPrimeMember->getPrimeUserByIdOrder($idOrder);
            if ($isPrimeUserExist) {
                $validOrderStatus = Configuration::get('TF_PRIME_PRO_MEMBERSHIP_ORDER_STATUSES');
                if ($validOrderStatus) {
                    $validOrderStatus = json_decode($validOrderStatus);
                    if ($validOrderStatus) {
                        $activatedDate = strtotime($isPrimeUserExist['activated_date']);
                        if (($activatedDate == 0 || $activatedDate === false || $activatedDate < 0) &&
                            in_array($currentOrderStatus, $validOrderStatus)
                        ) {
                            $duration = $isPrimeUserExist['duration'];
                            if (Validate::isDate($activatedDate)) {
                                $endDate = date(
                                    "Y-m-d H:i:s",
                                    strtotime("+".$duration.' '.$isPrimeUserExist['type'], $activatedDate)
                                );
                            } else {
                                $endDate = date(
                                    "Y-m-d H:i:s",
                                    strtotime("+".$duration.' '.$isPrimeUserExist['type'])
                                );
                            }

                            if ($isPrimeUserExist['is_extended'] == 1) {
                                $expiryDate = date(
                                    "Y-m-d H:i:s",
                                    strtotime(
                                        "+".$isPrimeUserExist['duration'].' '.$isPrimeUserExist['type'],
                                        strtotime(date('Y-m-d H:i:s'))
                                    )
                                );
                                $oldPrimeUser = new TfPrimeMembershipCustomer($isPrimeUserExist['id_reference']);
                                if (Validate::isLoadedObject($oldPrimeUser)) {
                                    // Calculate remaining days
                                    $endDate = date(
                                        "Y-m-d H:i:s",
                                        strtotime($oldPrimeUser->expiry_date)
                                    );
                                    $date2 = date_create($endDate);
                                    $date1 = date_create(date('Y-m-d'));
                                    $diff = date_diff($date1, $date2);
                                    $remainingDay = $diff->format("%R%a");
                                    if ($remainingDay > 0) {
                                        $remainingDay = $diff->format("%a");
                                        $endDate = date(
                                            "Y-m-d H:i:s",
                                            strtotime("+".$remainingDay.' days', strtotime($expiryDate))
                                        );
                                    }
                                    $oldPrimeUser->active = 2;
                                    $oldPrimeUser->update();
                                    // End of code
                                }
                            }

                            $id = $isPrimeUserExist['id_tf_prime_membership_customer'];
                            $objPrimeMember = new TfPrimeMembershipCustomer($id);

                            $idCustomer = $objPrimeMember->id_customer;
                            $idCustomerGroup = $objPrimeMember->id_customer_group;

                            $objPrimeMember->activated_date = date('Y-m-d H:i:s');
                            $objPrimeMember->expiry_date = $endDate;
                            $objPrimeMember->active = 1;
                            $objPrimeMember->update();

                            $objPrimeMember = new TfPrimeMembershipCustomer();
                            $objPrimeMember->addCustomerIntoPrimeGroup($idCustomer, $idCustomerGroup);
                        }
                    }
                }
            }
        }
    }

    public function hookActionValidateOrder($params)
    {
        if ($params['order']->getProducts()) {
            foreach ($params['order']->getProducts() as $product) {
                $plan = TfPrimeMembershipPlan::getPlanByIdProduct((int) $product['product_id']);
                if ($plan) {
                    $idCustomer = $params['order']->id_customer;
                    $objPrimeMember = new TfPrimeMembershipCustomer();
                    $isExistingPrimeUser = $objPrimeMember->getPrimeUser(
                        $idCustomer,
                        $plan['id_tf_prime_membership_plan']
                    );
                    $extended = 0;
                    $renewed = 0;
                    if ($isExistingPrimeUser) {
                        $endDate = date(
                            "Y-m-d",
                            strtotime($isExistingPrimeUser['expiry_date'])
                        );
                        $currentDate = date("Y-m-d");
                        if ($currentDate > $endDate) {
                            $renewed = 1;
                        } else {
                            $extended = 1;
                        }
                        $objPrimeMember->id_reference = $isExistingPrimeUser['id_tf_prime_membership_customer'];
                    } else {
                        // Is customer renewing its plan ?
                        $isExistingPrimeUser = $objPrimeMember->getExpiredPrimeUserByIdCustomer(
                            $idCustomer,
                            $plan['id_tf_prime_membership_plan']
                        );
                        if ($isExistingPrimeUser) {
                            $renewed = 1;
                            $objPrimeMember->id_reference = $isExistingPrimeUser['id_tf_prime_membership_customer'];
                        }
                    }
                    $objPrimeMember->id_shop = $this->context->shop->id;
                    $objPrimeMember->id_shop_default = $this->context->shop->id_shop_group;
                    $objPrimeMember->id_customer = $idCustomer;
                    $objPrimeMember->id_customer_group = $plan['id_customer_group'];
                    $objPrimeMember->id_plan = $plan['id_tf_prime_membership_plan'];
                    $objPrimeMember->type = $plan['type'];
                    $objPrimeMember->duration = $plan['duration'];
                    $objPrimeMember->id_product = $product['product_id'];
                    $objPrimeMember->id_order = $params['order']->id;
                    $objPrimeMember->price = $product['total_price_tax_incl'];
                    $objPrimeMember->id_currency = $params['order']->id_currency;
                    $objPrimeMember->is_renew = $renewed;
                    $objPrimeMember->is_extended = $extended;
                    $objPrimeMember->activated_date = '0000-00-00 00:00:00';
                    $objPrimeMember->expiry_date = '0000-00-00 00:00:00';
                    $objPrimeMember->active = 0;
                    if ($objPrimeMember->save() && Configuration::get('TF_PRIME_PRO_EMAIL_ADMIN')) {
                        $this->sendEmailToAdminForPrimeRegistration(
                            $params,
                            $plan
                        );
                    }
                }
            }
        }
    }

    public function sendEmailToAdminForPrimeRegistration($params, $plan)
    {
        $adminEmails = Configuration::get('TF_PRIME_PRO_EMAIL_ADMIN_ADDRESS');
        if ($adminEmails) {
            $adminEmails = explode(',', $adminEmails);
            if ($adminEmails) {
                $customer = new Customer((int) $params['order']->id_customer);
                $objPrimeMember = new TfPrimeMembershipCustomer();
                $primeInfo = $objPrimeMember->getPrimeUserByIdOrder($params['order']->id);
                if ($primeInfo) {
                    $customer_vars = array(
                        '{name}' => $customer->firstname.' '.$customer->lastname,
                        '{email}' => $customer->email,
                        '{order_reference}' => $params['order']->reference,
                        '{plan_name}' => $plan['name'],
                        '{plan_price}' => Tools::displayPrice(
                            $plan['price'],
                            new Currency($plan['id_currency'])
                        ),
                        '{plan_type}' => $primeInfo['type']
                    );
                    foreach ($adminEmails as $email) {
                        if ($email && Validate::isEmail($email)) {
                            Mail::Send(
                                (int) $this->context->language->id,
                                'presta_prime_registration',
                                Mail::l('New User Prime Membership', (int) $this->context->language->id),
                                $customer_vars,
                                $email,
                                null,
                                null,
                                null,
                                null,
                                null,
                                _PS_MODULE_DIR_.$this->name.'/mails/',
                                false,
                                null,
                                null
                            );
                        }
                    }
                }
            }
        }
    }

    public function checkPlanType($val)
    {
        if ($val == 'day') {
            return $this->l('Day Wise');
        } elseif ($val == 'month') {
            return $this->l('Montly');
        } elseif ($val == 'year') {
            return $this->l('Yearly');
        }
    }

    public function hookDisplayHeader()
    {
        if (Tools::getValue('controller') == 'product' &&
            TfPrimeMembershipPlan::getPlanByIdProduct((int) Tools::getValue('id_product')) &&
            !Configuration::get('TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD')
        ) {
            if ($this->context->cart->id) {
                Tools::redirect($this->context->link->getPageLink('order'));
            } else {
                Tools::redirect($this->context->link->getModuleLink($this->name, 'primelist'));
            }
        }

        $planList = new TfPrimeMembershipPlan();
        if (Tools::getValue('controller') == 'product' &&
            Configuration::get('PRESTA_PRIME_SHOW_AS_PRODUCT') == 0
        ) {
            $idProduct = Tools::getValue('id_product');
            if ($planList->getPlanByIdProduct($idProduct)) {
                Tools::redirect($this->context->link->getModuleLink($this->name, 'primelist'));
            }
        }
    }

    public function hookDisplayCustomerAccount()
    {
        $idCustomer = $this->context->customer->id;
        if ($idCustomer && !Configuration::get('TF_PRIME_MEMBERSHIP')) {
            $this->context->smarty->assign(
                array(
                    'mylink' => $this->context->link->getModuleLink($this->name, 'primelist'),
                )
            );
            return $this->display(__FILE__, 'prime_plans.tpl');
        }
    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->registerStyleSheet(
            'modules-primepro-css',
            'modules/'.$this->name.'/views/css/front/tf_primepro_header.css'
        );

        if (Tools::getValue('controller') == 'cart') {
            if ($this->context->cart->id) {
                $products = $this->context->cart->getProducts();
                if ($products) {
                    foreach ($products as $product) {
                        if (TfPrimeMembershipPlan::getPlanByIdProduct((int) $product['id_product'])) {
                            Media::addJsDef(
                                array(
                                    'tf_prime_pro_product_id' => $product['id_product'],
                                )
                            );
                        }
                        break;
                    }
                }
            }

            $this->context->controller->registerJavascript(
                'modules-primepro-js',
                'modules/'.$this->name.'/views/js/front/tf_primepro.js'
            );
        }
    }

    public function getContent()
    {
        $this->context->controller->addJs(
            _MODULE_DIR_.$this->name.'/views/js/admin/admin_prime_membership.js'
        );
        $this->_html = '';
        if (Tools::isSubmit('primeGeneralForm') ||
            Tools::isSubmit('primeComparisonForm') ||
            Tools::isSubmit('primeMailForm')
        ) {
            $this->postValidation();
            if (!$this->errors) {
                $this->postProcess();
            } else {
                if ($this->errors) {
                    $this->_html .= $this->displayError($this->errors);
                }
            }
        } else {
            $this->_html .= '<br />';
        }
        $cronUrl = _PS_BASE_URL_.
            _MODULE_DIR_.
            $this->name.
            '/tfcronupdate.php?token='.
            Tools::substr(Tools::encrypt($this->name.'/cron'), 0, 10);
        $this->context->smarty->assign(
            array(
                'cronurl' => $cronUrl
            )
        );
        $this->_html .= $this->context->smarty->fetch(
            _PS_MODULE_DIR_.$this->name.'/views/templates/admin/configuration.tpl'
        );
        $this->_html .= $this->generateForm($this->renderGeneralForm(), 'primeGeneralForm');
        $this->_html .= $this->generateForm($this->renderComparisonForm(), 'primeComparisonForm');
        $this->_html .= $this->generateForm($this->renderMailForm(), 'primeMailForm');

        return $this->_html;
    }

    private function postValidation()
    {
        if (Tools::isSubmit('primeMailForm')) {
            $adminMail = Tools::getValue('TF_PRIME_PRO_EMAIL_ADMIN');
            $adminMailAddresses = trim(Tools::getValue('TF_PRIME_PRO_EMAIL_ADMIN_ADDRESS'));
            if ($adminMail) {
                if ($adminMailAddresses) {
                    $prestaMails = explode(',', $adminMailAddresses);
                    foreach ($prestaMails as $mail) {
                        if ($mail) {
                            if (!Validate::isEmail($mail)) {
                                $this->errors[] = $this->l('Email is Invalid.');
                            }
                        }
                    }
                } else {
                    $this->errors[] = $this->l('Please provide mail address');
                }
            }

            $mailWarning = Tools::getValue('TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER');
            $mailWarningDays = trim(Tools::getValue('TF_PRIME_PRO_EMAIL_WARNING_DAYS'));
            if ($mailWarning) {
                if (!Validate::isInt($mailWarningDays)) {
                    $this->errors[] = $this->l('Warning mail days are not valid!');
                } elseif ($mailWarningDays < 0) {
                    $this->errors[] = $this->l('Warning mail days are must be greater than zero!');
                }
            }

            $warningDisplay = Tools::getValue('TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER');
            $warningDisplayDays = trim(Tools::getValue('TF_PRIME_PRO_WARNING_DISPLAY_DAYS'));
            if ($warningDisplay) {
                if (!Validate::isInt($warningDisplayDays)) {
                    $this->errors[] = $this->l('Warning display days are not valid!');
                } elseif ($warningDisplayDays < 0) {
                    $this->errors[] = $this->l('Warning display days are must be greater than zero!');
                }
            }
        } elseif (Tools::isSubmit('primeGeneralForm')) {
            $primeMembershipApproval = Tools::getValue('TF_PRIME_PRO_MEMBERSHIP_APPROVAL');
            if (!$primeMembershipApproval) {
                $checked = false;
                foreach (OrderState::getOrderStates($this->context->language->id) as $status) {
                    if (Tools::getValue('TF_PRIME_PRO_ORDER_STATUS_'.$status['id_order_state'])) {
                        $checked = true;
                        break;
                    }
                }

                if (!$checked) {
                    $this->errors[] = $this->l(
                        'Please select the order status to activate prime membership plans'
                    );
                }
            }
            $loadMore = Tools::getValue('TF_PRIME_PRO_LOAD_MORE');
            if ($loadMore && !Validate::isInt($loadMore)) {
                $this->errors[] = $this->l(
                    'Set number to load more customer(s) is not valid'
                );
            }
        } elseif (Tools::isSubmit('primeComparisonForm')) {
            $primeMembershipComparison = Tools::getValue('TF_PRIME_PRODUCT_COMPARISON');
            if ($primeMembershipComparison) {
                $planComparison = Tools::getValue('TF_PRIME_PRODUCT_COMPARISON_PLAN');
                if (!$planComparison) {
                    $this->errors[] = $this->l('Please select prime plan');
                }
                $defaultLang = Configuration::get('PS_LANG_DEFAULT');
                $defaultLangObj = new Language($defaultLang);
                $planComparisonMsg = trim(Tools::getValue('TF_PRIME_PRODUCT_COMPARISON_PLAN_MSG_'.$defaultLang));
                if (!$planComparisonMsg) {
                    $this->errors[] = sprintf(
                        $this->l('Message is required in %s langauge'),
                        $defaultLangObj->name
                    );
                }
                foreach (Language::getLanguages(false) as $lang) {
                    $planComparisonMsg = trim(Tools::getValue('TF_PRIME_PRODUCT_COMPARISON_PLAN_MSG_'.$lang['id_lang']));
                    if ($planComparisonMsg && !Validate::isCleanHtml($planComparisonMsg)) {
                        $this->errors[] = sprintf(
                            $this->l('Message is not valid in %s langauge'),
                            $lang['name']
                        );
                    }
                }
            }
        }
    }

    private function postProcess()
    {
        if (Tools::isSubmit('primeGeneralForm')) {
            Configuration::updateValue(
                'TF_PRIME_PRO_PLAN_EXTEND',
                Tools::getValue('TF_PRIME_PRO_PLAN_EXTEND')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_PLAN_RENEW',
                Tools::getValue('TF_PRIME_PRO_PLAN_RENEW')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_ADVERTISEMENT',
                Tools::getValue('TF_PRIME_PRO_ADVERTISEMENT')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_REDIRECT_LIST',
                Tools::getValue('TF_PRIME_PRO_REDIRECT_LIST')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_CMS_PAGE',
                Tools::getValue('TF_PRIME_PRO_CMS_PAGE')
            );
            $checked = array();
            $primeMembershipApproval = Tools::getValue('TF_PRIME_PRO_MEMBERSHIP_APPROVAL');
            if (!$primeMembershipApproval) {
                foreach (OrderState::getOrderStates($this->context->language->id) as $status) {
                    if (Tools::getValue('TF_PRIME_PRO_ORDER_STATUS_'.$status['id_order_state'])) {
                        $checked[] = Tools::getValue('TF_PRIME_PRO_ORDER_STATUS_'.$status['id_order_state']);
                    }
                }
            }
            Configuration::updateValue(
                'TF_PRIME_PRO_MEMBERSHIP_APPROVAL',
                $primeMembershipApproval
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_MEMBERSHIP_ORDER_STATUSES',
                json_encode($checked)
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_LOAD_MORE',
                Tools::getValue('TF_PRIME_PRO_LOAD_MORE')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD',
                Tools::getValue('TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_MEMBERSHIP_BUY_BUTTON',
                Tools::getValue('TF_PRIME_PRO_MEMBERSHIP_BUY_BUTTON')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_MEMBERSHIP_PLAN_PRICE',
                Tools::getValue('TF_PRIME_PRO_MEMBERSHIP_PLAN_PRICE')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESCRIPTION',
                Tools::getValue('TF_PRIME_PRO_MEMBERSHIP_PLAN_DESCRIPTION')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESC',
                Tools::getValue('TF_PRIME_PRO_MEMBERSHIP_PLAN_DESC')
            );
            Configuration::updateValue(
                'PRESTA_PRIME_SHOW_AS_PRODUCT',
                Tools::getValue('PRESTA_PRIME_SHOW_AS_PRODUCT')
            );
            Configuration::updateValue(
                'TF_PRIME_PRO_PLAN_GUEST',
                Tools::getValue('TF_PRIME_PRO_PLAN_GUEST')
            );
            $this->redirectAdminConfiguration();
        } elseif (Tools::isSubmit('primeMailForm')) {
            if (Tools::getValue('TF_PRIME_PRO_EMAIL_ADMIN')) {
                Configuration::updateValue(
                    'TF_PRIME_PRO_EMAIL_ADMIN',
                    Tools::getValue('TF_PRIME_PRO_EMAIL_ADMIN')
                );
                Configuration::updateValue(
                    'TF_PRIME_PRO_EMAIL_ADMIN_ADDRESS',
                    Tools::getValue('TF_PRIME_PRO_EMAIL_ADMIN_ADDRESS')
                );
            }

            if (Tools::getValue('TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER')) {
                Configuration::updateValue(
                    'TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER',
                    Tools::getValue('TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER')
                );
                Configuration::updateValue(
                    'TF_PRIME_PRO_EMAIL_WARNING_DAYS',
                    Tools::getValue('TF_PRIME_PRO_EMAIL_WARNING_DAYS')
                );
            }

            if (Tools::getValue('TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER')) {
                Configuration::updateValue(
                    'TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER',
                    Tools::getValue('TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER')
                );
                Configuration::updateValue(
                    'TF_PRIME_PRO_WARNING_DISPLAY_DAYS',
                    Tools::getValue('TF_PRIME_PRO_WARNING_DISPLAY_DAYS')
                );
            }
            $this->redirectAdminConfiguration();
        } elseif (Tools::isSubmit('primeComparisonForm')) {
            $comparePlan = new TfPrimeMembershipPlanCompare();
            $isExist = $comparePlan->getPlanDetail();
            if ($isExist) {
                $comparePlan = new TfPrimeMembershipPlanCompare($isExist);
            }
            $comparePlan->id_tf_prime_membership_plan = Tools::getValue('TF_PRIME_PRODUCT_COMPARISON_PLAN');
            $comparePlan->active = Tools::getValue('TF_PRIME_PRODUCT_COMPARISON');

            $defaultLang = Configuration::get('PS_LANG_DEFAULT');
            $planComparisonDefaultMsg = trim(Tools::getValue('TF_PRIME_PRODUCT_COMPARISON_PLAN_MSG_'.$defaultLang));
            foreach (Language::getLanguages(false) as $lang) {
                $planComparisonMsg = trim(Tools::getValue('TF_PRIME_PRODUCT_COMPARISON_PLAN_MSG_'.$lang['id_lang']));
                if (!$planComparisonMsg) {
                    $planComparisonMsg = $planComparisonDefaultMsg;
                }
                $comparePlan->message[$lang['id_lang']] = $planComparisonMsg;
            }
            if ($comparePlan->save()) {
                $this->redirectAdminConfiguration();
            } else {
                $this->errors[] = $this->l('Something went wrong! Please try again.');
            }
        }
    }

    public function redirectAdminConfiguration()
    {
        $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminModules').
            '&configure='.
            $this->name.
            '&tab_module='.
            $this->tab.
            '&module_name='.
            $this->name.
            '&conf=4'
        );
    }

    public function renderGeneralForm()
    {
        $orderStatus = OrderState::getOrderStates($this->context->language->id);
        if ($orderStatus) {
            foreach ($orderStatus as &$status) {
                $status['val'] = $status['id_order_state'];
            }
        }
        $result = CMS::getCMSPages($this->context->language->id);
        $cmsArray = array();
        if ($result) {
            foreach ($result as $key => $data) {
                $cmsArray[$key] = array(
                    'id' => $data['id_cms'],
                    'name' => $data['meta_title']
                );
            }
        }
        $fields_form = array();
        $fields_form[2]['form'] = array(
            'legend' => array(
                'title' => $this->l('Global Configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Allow Customer Can Extend Plan'),
                    'name' => 'TF_PRIME_PRO_PLAN_EXTEND',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'Give permission to customer for extend his/her plan.'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Allow Customer Can Renew Plan'),
                    'name' => 'TF_PRIME_PRO_PLAN_RENEW',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'Give permission to customer for renew his/her plan '
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Allow Visitor/Guest Can See Plans'),
                    'name' => 'TF_PRIME_PRO_PLAN_GUEST',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'Visitor/Guest can also see the prime membership plan'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display Advertisement For Plan'),
                    'name' => 'TF_PRIME_PRO_ADVERTISEMENT',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'Display a link at top/navigation bar as "Become Prime Member".'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Redirect On Membership List'),
                    'name' => 'TF_PRIME_PRO_REDIRECT_LIST',
                    'class' => 't',
                    'form_group_class' => 'presta_cms',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, Customer will redirect on membership list page when they link on
                        become prime membership link at top/navigation bar'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Choose CMS Page To Show Content'),
                    'name' => 'TF_PRIME_PRO_CMS_PAGE',
                    'required' => true,
                    'form_group_class' => 'presta_cms presta_cms_page',
                    'options' => array(
                        'query' => $cmsArray,
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'hint' => $this->l('Choose CMS Page to redirect after clicking "become prime member" link.'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Admin Approval Required To Activate Prime Membership'),
                    'name' => 'TF_PRIME_PRO_MEMBERSHIP_APPROVAL',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, admin will manually activate the prime memebrship bought by customers'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'checkbox',
                    'label' => $this->l('Select Order Statuses'),
                    'name' => 'TF_PRIME_PRO_ORDER_STATUS',
                    'values' => array(
                        'query' => $orderStatus,
                        'id' => 'id_order_state',
                        'name' => 'name'
                    ),
                    'form_group_class' => 'presta_prime_order_status',
                    'hint' => $this->l(
                        'Prime membership will only get activated automatically if order status will be these'
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Allow To Check Plan As Product'),
                    'name' => 'TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, customer can click on plan and it will be redirected on product detail page'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Hide Purchase Button'),
                    'name' => 'TF_PRIME_PRO_MEMBERSHIP_BUY_BUTTON',
                    'desc' => $this->l('Purchase button will be hide from plan list page'),
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, purchase button will be disabled for all customers'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Hide Plan Price'),
                    'name' => 'TF_PRIME_PRO_MEMBERSHIP_PLAN_PRICE',
                    'desc' => $this->l('Plan price will be hide from plan list page'),
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, purchase button will be disabled for all customers'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Hide Plan Description'),
                    'name' => 'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESCRIPTION',
                    'desc' => $this->l('Plan description will be hide from plan list page'),
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, plan description will be disabled for all customers'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Hide "View Feature" Button'),
                    'name' => 'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESC',
                    'desc' => $this->l('Plan "view feature" button will be hide from plan list page'),
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, "view feature" button will be disabled for all customers'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable plan as product'),
                    'name' => 'PRESTA_PRIME_SHOW_AS_PRODUCT',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, membership plan will be visible as product on product page.'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Set number to load more customer(s)'),
                    'name' => 'TF_PRIME_PRO_LOAD_MORE',
                    'col' => '3',
                    'hint' => $this->l(
                        'When you add existing customers into plan manually then you require to search or load more
                        customers then this number will be pick to load customers'
                    ),
                    'desc' => $this->l('It will help you to load more customers at once on customer detail page')
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'name' => 'primeGeneralForm'
            ),
        );

        return $fields_form;
    }

    public function renderComparisonForm()
    {
        $primeMembershipPlan = new TfPrimeMembershipPlan();
        $primePlan = $primeMembershipPlan->getPrimePlan($this->context->language->id, $this->context->shop->id);
        $fields_form = array();
        $fields_form[2]['form'] = array(
            'legend' => array(
                'title' => $this->l('Prime Plan Comparison Configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show Plan On Product Page For Comparison'),
                    'name' => 'TF_PRIME_PRODUCT_COMPARISON',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, this plan will be visible as comparison on product page where customer can see
                        price benefit if they buy membership plan.'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Choose Prime Plan(s)'),
                    'name' => 'TF_PRIME_PRODUCT_COMPARISON_PLAN',
                    'col' => '3',
                    'form_group_class' => 'presta_plan_comparison',
                    'required' => true,
                    'options' => array(
                        'query' => $primePlan,
                        'id' => 'id_tf_prime_membership_plan',
                        'name' => 'name',
                    ),
                    'hint' => $this->l(
                        'This plan benefit will be considered for comparing product price'
                    )
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Set Your Message'),
                    'name' => 'TF_PRIME_PRODUCT_COMPARISON_PLAN_MSG',
                    'autoload_rte' => true,
                    'form_group_class' => 'presta_plan_comparison',
                    'desc' => $this->l(
                        'Set your message, it will be visible on produc page. Use these three predefined variable to
                        manage your message with product price and membership price.
                        {product_price}, {membership_price}, {action_button}'
                    ),
                    'lang' => true
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            ),
        );

        return $fields_form;
    }

    public function renderMailForm()
    {
        $fields_form = array();
        $fields_form[2]['form'] = array(
            'legend' => array(
                'title' => $this->l('Mail Configuration'),
                'icon' => 'icon-cogs',
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Email Notification To Admin When Customer Buy Prime Membership'),
                    'name' => 'TF_PRIME_PRO_EMAIL_ADMIN',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'If Enabled, admin can get email When Customer Buy Prime Membership'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Email Addresses'),
                    'name' => 'TF_PRIME_PRO_EMAIL_ADMIN_ADDRESS',
                    'col' => 4,
                    'form_group_class' => 'presta_prime_admin_mail',
                    'hint' => $this->l(
                        'Enter email to get Customer Buy Prime Membership notification.'
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Send Warning Email Notification To Customer When Plan About To Expire'),
                    'name' => 'TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'Send warning mail to customer when their plan about to expire'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Set number of days to send warning mail'),
                    'name' => 'TF_PRIME_PRO_EMAIL_WARNING_DAYS',
                    'col' => 1,
                    'form_group_class' => 'presta_prime_warning_mail',
                    'hint' => $this->l(
                        'Set remaining days to send warning mail to customer'
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display Warning Notification To Customer'),
                    'name' => 'TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER',
                    'class' => 't',
                    'is_bool' => true,
                    'hint' => $this->l(
                        'Send warning mail to customer when their plan about to expire'
                    ),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled'),
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled'),
                        ),
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Set number of days to display warning'),
                    'name' => 'TF_PRIME_PRO_WARNING_DISPLAY_DAYS',
                    'col' => 1,
                    'form_group_class' => 'presta_prime_warning_display',
                    'hint' => $this->l(
                        'Set remaining days to send warning mail to customer'
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            ),
        );

        return $fields_form;
    }

    public function generateForm($fields_form, $btnSubmit)
    {
        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.
            '&configure='.
            $this->name.
            '&tab_module='.
            $this->tab.
            '&module_name='.
            $this->name;
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->submit_action = $btnSubmit;
        $helper->table = $this->table;
        $helper->identifier = $this->identifier;
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfiguationValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm($fields_form);
    }

    public function getConfiguationValues()
    {
        $configuration = array(
            'TF_PRIME_PRO_PLAN_EXTEND' => Tools::getValue(
                'TF_PRIME_PRO_PLAN_EXTEND',
                Configuration::get('TF_PRIME_PRO_PLAN_EXTEND')
            ),
            'TF_PRIME_PRO_PLAN_RENEW' => Tools::getValue(
                'TF_PRIME_PRO_PLAN_RENEW',
                Configuration::get('TF_PRIME_PRO_PLAN_RENEW')
            ),
            'TF_PRIME_PRO_ADVERTISEMENT' => Tools::getValue(
                'TF_PRIME_PRO_ADVERTISEMENT',
                Configuration::get('TF_PRIME_PRO_ADVERTISEMENT')
            ),
            'TF_PRIME_PRO_MEMBERSHIP_APPROVAL' => Tools::getValue(
                'TF_PRIME_PRO_MEMBERSHIP_APPROVAL',
                Configuration::get('TF_PRIME_PRO_MEMBERSHIP_APPROVAL')
            ),
            'TF_PRIME_PRO_EMAIL_ADMIN' => Tools::getValue(
                'TF_PRIME_PRO_EMAIL_ADMIN',
                Configuration::get('TF_PRIME_PRO_EMAIL_ADMIN')
            ),
            'TF_PRIME_PRO_EMAIL_ADMIN_ADDRESS' => Tools::getValue(
                'TF_PRIME_PRO_EMAIL_ADMIN_ADDRESS',
                Configuration::get('TF_PRIME_PRO_EMAIL_ADMIN_ADDRESS')
            ),
            'TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER' => Tools::getValue(
                'TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER',
                Configuration::get('TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER')
            ),
            'TF_PRIME_PRO_EMAIL_WARNING_DAYS' => Tools::getValue(
                'TF_PRIME_PRO_EMAIL_WARNING_DAYS',
                Configuration::get('TF_PRIME_PRO_EMAIL_WARNING_DAYS')
            ),
            'TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER' => Tools::getValue(
                'TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER',
                Configuration::get('TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER')
            ),
            'TF_PRIME_PRO_WARNING_DISPLAY_DAYS' => Tools::getValue(
                'TF_PRIME_PRO_WARNING_DISPLAY_DAYS',
                Configuration::get('TF_PRIME_PRO_WARNING_DISPLAY_DAYS')
            ),
            'TF_PRIME_PRO_REDIRECT_LIST' => Tools::getValue(
                'TF_PRIME_PRO_REDIRECT_LIST',
                Configuration::get('TF_PRIME_PRO_REDIRECT_LIST')
            ),
            'TF_PRIME_PRO_CMS_PAGE' => Tools::getValue(
                'TF_PRIME_PRO_CMS_PAGE',
                Configuration::get('TF_PRIME_PRO_CMS_PAGE')
            ),
            'TF_PRIME_PRO_LOAD_MORE' => Tools::getValue(
                'TF_PRIME_PRO_LOAD_MORE',
                Configuration::get('TF_PRIME_PRO_LOAD_MORE')
            ),
            'TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD' => Tools::getValue(
                'TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD',
                Configuration::get('TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD')
            ),
            'TF_PRIME_PRO_MEMBERSHIP_BUY_BUTTON' => Tools::getValue(
                'TF_PRIME_PRO_MEMBERSHIP_BUY_BUTTON',
                Configuration::get('TF_PRIME_PRO_MEMBERSHIP_BUY_BUTTON')
            ),
            'TF_PRIME_PRO_MEMBERSHIP_PLAN_PRICE' => Tools::getValue(
                'TF_PRIME_PRO_MEMBERSHIP_PLAN_PRICE',
                Configuration::get('TF_PRIME_PRO_MEMBERSHIP_PLAN_PRICE')
            ),
            'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESCRIPTION' => Tools::getValue(
                'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESCRIPTION',
                Configuration::get('TF_PRIME_PRO_MEMBERSHIP_PLAN_DESCRIPTION')
            ),
            'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESC' => Tools::getValue(
                'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESC',
                Configuration::get('TF_PRIME_PRO_MEMBERSHIP_PLAN_DESC')
            ),
            'PRESTA_PRIME_SHOW_AS_PRODUCT' => Tools::getValue(
                'PRESTA_PRIME_SHOW_AS_PRODUCT',
                Configuration::get('PRESTA_PRIME_SHOW_AS_PRODUCT')
            ),
            'TF_PRIME_PRO_PLAN_GUEST'=> Tools::getValue(
                'TF_PRIME_PRO_PLAN_GUEST',
                Configuration::get('TF_PRIME_PRO_PLAN_GUEST')
            )
        );
        $savedStatus = Configuration::get('TF_PRIME_PRO_MEMBERSHIP_ORDER_STATUSES');
        if ($savedStatus) {
            $savedStatus = json_decode($savedStatus);
            if ($savedStatus) {
                foreach ($savedStatus as $status) {
                    $configuration['TF_PRIME_PRO_ORDER_STATUS_'.$status] = $status;
                }
            }
        }
        $comparePlan = new TfPrimeMembershipPlanCompare();
        $isExist = $comparePlan->getPlanDetail();
        if (Tools::isSubmit('primeComparisonForm')) {
            $active = Tools::getValue('TF_PRIME_PRODUCT_COMPARISON');
            $idPlan = Tools::getValue('TF_PRIME_PRODUCT_COMPARISON_PLAN');
            foreach (Language::getLanguages(false) as $lang) {
                $msg = Tools::getValue('TF_PRIME_PRODUCT_COMPARISON_PLAN_MSG_'.$lang['id_lang']);
                $configuration['TF_PRIME_PRODUCT_COMPARISON_PLAN_MSG'][$lang['id_lang']] = $msg;
            }
        } elseif ($isExist) {
            $comparePlan = new TfPrimeMembershipPlanCompare($isExist);
            $active = $comparePlan->active;
            $idPlan = $comparePlan->id_tf_prime_membership_plan;
            foreach (Language::getLanguages(false) as $lang) {
                $msg = $comparePlan->message[$lang['id_lang']];
                $configuration['TF_PRIME_PRODUCT_COMPARISON_PLAN_MSG'][$lang['id_lang']] = $msg;
            }
        } else {
            $active = 0;
            $idPlan = 0;
            foreach (Language::getLanguages(false) as $lang) {
                $configuration['TF_PRIME_PRODUCT_COMPARISON_PLAN_MSG'][$lang['id_lang']] = false;
            }
        }
        $configuration['TF_PRIME_PRODUCT_COMPARISON'] = $active;
        $configuration['TF_PRIME_PRODUCT_COMPARISON_PLAN'] = $idPlan;

        return $configuration;
    }

    public function installTab($class_name, $tab_name, $tab_parent_name = false)
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $class_name;
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $tab_name;
        }

        if ($tab_parent_name) {
            $tab->id_parent = (int) Tab::getIdFromClassName($tab_parent_name);
        } else {
            $tab->id_parent = 0;
        }

        $tab->module = $this->name;
        return $tab->add();
    }

    public function callInstallTab()
    {
        $this->installTab('AdminTfPrimeMembership', 'Prime Membership', 'AdminParentCustomer');
        $this->installTab('AdminPrimeMembershipPro', 'Prime Membership', 'AdminTfPrimeMembership');
        $this->installTab('AdminPrimeMembershipProCustomers', 'Prime Customers', 'AdminTfPrimeMembership');

        return true;
    }

    public function tfRegisterHook()
    {
        $hooks = array(
            'displayHeader',
            'actionFrontControllerSetMedia',
            'displayCustomerAccount',
            'actionValidateOrder',
            'displayNav1',
            'actionOrderStatusPostUpdate',
            'displayProductPriceBlock'
        );
        foreach ($hooks as $hook) {
            $this->registerHook($hook);
        }
        return true;
    }

    private function createTable()
    {
        $objPlan = new TfPrimeMembershipPlan();
        return $objPlan->createTable();
    }

    private function tfUpdateKeys()
    {
        Configuration::updateValue('TF_PRIME_PRO_PLAN_EXTEND', 1);
        Configuration::updateValue('TF_PRIME_PRO_PLAN_RENEW', 1);
        Configuration::updateValue('TF_PRIME_PRO_ADVERTISEMENT', 1);
        Configuration::updateValue('TF_PRIME_PRO_REDIRECT_LIST', 1);
        Configuration::updateValue('TF_PRIME_PRO_MEMBERSHIP_APPROVAL', 1);
        Configuration::updateValue('TF_PRIME_PRO_LOAD_MORE', 100);
        Configuration::updateValue('TF_PRIME_PRO_PLAN_GUEST', 1);

        Configuration::updateValue('TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD', 1);
        Configuration::updateValue('TF_PRIME_PRO_MEMBERSHIP_BUY_BUTTON', 0);
        Configuration::updateValue('TF_PRIME_PRO_MEMBERSHIP_PLAN_PRICE', 0);
        Configuration::updateValue('TF_PRIME_PRO_MEMBERSHIP_PLAN_DESCRIPTION', 0);
        Configuration::updateValue('TF_PRIME_PRO_MEMBERSHIP_PLAN_DESC', 0);
        Configuration::updateValue('PRESTA_PRIME_SHOW_AS_PRODUCT', 1);
        return true;
    }

    public function install()
    {
        if (!parent::install()
            || !$this->createTable()
            || !$this->callInstallTab()
            || !$this->tfRegisterHook()
            || !$this->tfUpdateKeys()
        ) {
            return false;
        }

        return true;
    }

    public function dropTable()
    {
        return Db::getInstance()->execute(
            'DROP TABLE IF EXISTS
                `'._DB_PREFIX_.'tf_prime_membership_customer`,
                `'._DB_PREFIX_.'tf_prime_membership_plan_lang`,
                `'._DB_PREFIX_.'tf_prime_membership_plan`,
                `'._DB_PREFIX_.'tf_prime_membership_plan_compare`,
                `'._DB_PREFIX_.'tf_prime_membership_plan_compare_lang`'
        );
    }

    public function uninstallTab()
    {
        $moduleTabs = Tab::getCollectionFromModule($this->name);
        if (!empty($moduleTabs)) {
            foreach ($moduleTabs as $moduleTab) {
                $moduleTab->delete();
            }
        }
        return true;
    }

    private function deleteConfigValue()
    {
        $keys = array(
            'TF_PRIME_PRO_PLAN_EXTEND', 'TF_PRIME_PRO_PLAN_RENEW',
            'TF_PRIME_PRO_ADVERTISEMENT', 'TF_PRIME_PRO_EMAIL_ADMIN',
            'TF_PRIME_PRO_EMAIL_ADMIN_ADDRESS', 'TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER',
            'TF_PRIME_PRO_EMAIL_WARNING_DAYS', 'TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER',
            'TF_PRIME_PRO_WARNING_DISPLAY_DAYS', 'TF_PRIME_PRO_MEMBERSHIP_APPROVAL',
            'TF_PRIME_PRO_MEMBERSHIP_ORDER_STATUSES', 'TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD',
            'TF_PRIME_PRO_CMS_PAGE', 'TF_PRIME_PRO_REDIRECT_LIST',
            'TF_PRIME_PRO_MEMBERSHIP_BUY_BUTTON', 'TF_PRIME_PRO_MEMBERSHIP_PLAN_PRICE',
            'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESC', 'TF_PRIME_PRO_PLAN_GUEST',
            'PRESTA_PRIME_SHOW_AS_PRODUCT', 'TF_PRIME_PRO_MEMBERSHIP_PLAN_DESCRIPTION',
        );
        foreach ($keys as $value) {
            Configuration::deleteByName($value);
        }
        return true;
    }

    private function deletePrimeProduct()
    {
        $objPlan = new TfPrimeMembershipPlan();
        $plans = $objPlan->getPrimePlan(
            $this->context->language->id,
            $this->context->shop->id,
            true
        );
        if ($plans) {
            foreach ($plans as $plan) {
                $product = new Product((int) $plan['id_product']);
                if (Validate::isLoadedObject($product)) {
                    $product->delete();
                }
            }
        }
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()
            || !$this->uninstallTab()
            || !$this->deletePrimeProduct()
            || !$this->deleteConfigValue()
            || !$this->dropTable()
        ) {
            return false;
        }

        return true;
    }
}
