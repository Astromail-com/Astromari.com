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

class AdminPrimeMembershipProCustomersController extends ModuleAdminController
{
    public function __construct()
    {
        $this->identifier = 'id_tf_prime_membership_customer';
        parent::__construct();
        $this->table = 'tf_prime_membership_customer';
        $this->className = 'TfPrimeMembershipCustomer';
        $this->bootstrap = true;
        $this->list_no_link = true;
        $this->_select = '
            a.`id_plan` as temp_id_plan,
            CONCAT(c.firstname, \' \', c.lastname) customer_name,
            o.reference as reference,
            pl.name';
        $this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'tf_prime_membership_plan_lang` pl ON
            (pl.`id_tf_prime_membership_plan` = a.`id_plan`)';
        $this->_where .= ' AND
            a.`id_shop` = '.(int) $this->context->shop->id.' AND
            pl.`id_lang` = '.(int) $this->context->language->id;
        $this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = a.`id_customer`)';
        $this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'orders` o ON (o.`id_order` = a.`id_order`)';

        $this->_orderWay = 'DESC';
        
        $this->fields_list = array(
            'id_tf_prime_membership_customer' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ),
            'id_customer' => array(
                'title' => $this->l('ID Cust.'),
                'align' => 'center',
                'havingFilter' => true,
                'class' => 'fixed-width-xs',
            ),
            'customer_name' => array(
                'title' => $this->l('Name'),
                'align' => 'center',
                'havingFilter' => true,
            ),
            'reference' => array(
                'title' => $this->l('Reference'),
                'align' => 'center',
                'havingFilter' => true,
            ),
            'name' => array(
                'title' => $this->l('Plan Name'),
                'align' => 'center',
                'havingFilter' => true,
            ),
            'temp_id_plan' => array(
                'title' => $this->l('Image'),
                'align' => 'center',
                'callback' => 'displayPlanImage',
                'search' => false,
            ),
            'price' => array(
                'title' => $this->l('Plan Price'),
                'align' => 'center',
                'type' => 'price',
                'havingFilter' => true,
            ),
            'type' => array(
                'title' => $this->l('Type'),
                'align' => 'center',
                'callback' => 'checkPlanType',
                'havingFilter' => true,
            ),
            'duration' => array(
                'title' => $this->l('Duration'),
                'align' => 'center',
                'callback' => 'setDuration',
                'havingFilter' => true,
            ),
            'is_renew' => array(
                'title' => $this->l('Renewed'),
                'align' => 'center',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
            ),
            'is_extended' => array(
                'title' => $this->l('Extended'),
                'align' => 'center',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
            ),
            'activated_date' => array(
                'title' => $this->l('Activated Date'),
                'align' => 'center',
                'type' => 'date',
                'callback' => 'checkActivationDate'
            ),
            'date_add' => array(
                'title' => $this->l('Add Date'),
                'align' => 'center',
                'type' => 'date',
            ),
            'date_upd' => array(
                'title' => $this->l('Update Date'),
                'align' => 'center',
                'type' => 'date',
            ),
            'active' => array(
                'title' => $this->l('Status'),
                'align' => 'center',
                //'active' => 'status',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
                'callback' => 'checkCurrentStatus'
            ),
        );

        $this->addRowAction('delete');
    }

    public function displayPlanImage($id)
    {
        $planObject = new TfPrimeMembershipPlan($id);
        if (Validate::isLoadedObject($planObject)) {
            $imgName = $planObject->img_name;
            $m = $this->module->name;
            if ($imgName) {
                $img = _PS_MODULE_DIR_.$m.'/views/img/'.$id.'/'.$imgName;
                if (@getimagesize($img)) {
                    $imgpath = _MODULE_DIR_.$m.'/views/img/'.$id.'/'.$imgName;
                } else {
                    $imgpath = _MODULE_DIR_.$m.'/views/img/default/card.png';
                }
            } else {
                $imgpath = _MODULE_DIR_.$m.'/views/img/default/card.png';
            }
            $this->context->smarty->assign(
                array(
                'modules_dir' => _MODULE_DIR_,
                'imgpath' => $imgpath
                )
            );
            return $this->context->smarty->fetch(
                _PS_MODULE_DIR_.$this->module->name.'/views/templates/admin/plan_img.tpl'
            );
        }
    }

    public function checkPlanType($val)
    {
        if ($val == 'days') {
            return $this->l('Day Wise');
        } elseif ($val == 'months') {
            return $this->l('Montly');
        } elseif ($val == 'years') {
            return $this->l('Yearly');
        }
    }

    public function setDuration($val, $arr)
    {
        if ($val) {
            $activatedDate = strtotime($arr['activated_date']);
            if ($activatedDate == 0 || $activatedDate === false || $activatedDate < 0) {
                return $this->l('N/A');
            }
            $endDate = date(
                "M d, Y",
                strtotime($arr['expiry_date'])
            );
            $startDate = date(
                "M d, Y",
                strtotime($arr['activated_date'])
            );
            return Tools::nl2br($startDate.' <br />To<br /> '.$endDate);
        }
    }

    public function checkActivationDate($val, $arr)
    {
        if ($val) {
            $activatedDate = strtotime($arr['activated_date']);
            if ($activatedDate == 0 || $activatedDate === false || $activatedDate < 0) {
                return $this->l('N/A');
            } else {
                return date(
                    "M d, Y",
                    strtotime($arr['activated_date'])
                );
            }
        }
    }

    public function checkCurrentStatus($val, $arr)
    {
        $this->context->smarty->assign(
            array(
               'status' => $val,
               'presta_current_url' =>self::$currentIndex.
                    '&token='.
                    $this->token.
                    '&id_tf_prime_membership_customer='.
                    $arr['id_tf_prime_membership_customer'].
                    '&status'.$this->table
            )
        );
        if ($val == 2) {
            return $this->l('Expired');
        } else {
            return $this->context->smarty->fetch(
                _PS_MODULE_DIR_.$this->module->name.'/views/templates/admin/presta_status.tpl'
            );
        }
    }

    public function renderForm()
    {
        $this->fields_form = array(
            'submit' => array(
                'title' => $this->l('Save'),
            )
        );
        $objPlan = new TfPrimeMembershipPlan();
        $primePlans = $objPlan->getPrimePlan(
            $this->context->language->id,
            $this->context->shop->id,
            true
        );
        $customers = TfPrimeMembershipCustomer::getCustomers(true, 0, 100);
        if ($customers) {
            $this->context->smarty->assign(
                array(
                    'currentDate' => date('Y-m-d'),
                    'customers' => $customers,
                    'primePlans' => $primePlans,
                    'customer_count' => count($customers)
                )
            );
        }
        $this->context->smarty->assign(
            array(
                'modules_dir' => _MODULE_DIR_,
            )
        );
        Media::addJsDef(
            array(
                'currentDate' => date('Y-m-d'),
                'modules_dir' => _MODULE_DIR_,
                'tftoken' => Tools::getValue('token'),
                'selectCust' => $this->l('Select Customers'),
                'nomorecustomer' => $this->l('No more customer found'),
                'current_controller' => $this->context->link->getAdminLink('AdminPrimeMembershipProCustomers')
            )
        );
        return parent::renderForm();
    }

    public function postProcess()
    {
        if (Tools::isSubmit('tfsubmit')) {
            $customers = Tools::getValue('tf_presta_customer');
            $idPlan = Tools::getValue('tf_prime_plan');
            $startDate = Tools::getValue('tf_start_date');
            if (!$customers) {
                $this->errors[] = $this->l('Please select at least one customer');
            }
            if (!$idPlan) {
                $this->errors[] = $this->l('Please select plan');
            }
            if (empty($this->errors)) {
                $startDate = date('Y-m-d H:i:s', strtotime($startDate));
                foreach ($customers as $idCustomer) {
                    $plan = new TfPrimeMembershipPlan($idPlan);
                    if (Validate::isLoadedObject($plan)) {
                        $objPrimeMember = new TfPrimeMembershipCustomer();
                        $endDate = date(
                            'Y-m-d H:i:s',
                            strtotime("+".$plan->duration.' '.$plan->type, strtotime($startDate))
                        );
                        $objPrimeMember->id_customer = $idCustomer;
                        $objPrimeMember->id_customer_group = $plan->id_customer_group;
                        $objPrimeMember->id_plan = $plan->id;
                        $objPrimeMember->type = $plan->type;
                        $objPrimeMember->duration = $plan->duration;
                        $objPrimeMember->id_product = $plan->id_product;
                        $objPrimeMember->id_shop = $this->context->shop->id;
                        $objPrimeMember->id_shop_default = $this->context->shop->id_shop_group;
                        $objPrimeMember->id_order = 0;
                        $objPrimeMember->price = $plan->price;
                        $objPrimeMember->id_currency = $plan->id_currency;
                        $objPrimeMember->is_renew = 0;
                        $objPrimeMember->is_extended = 0;
                        $objPrimeMember->activated_date = $startDate;
                        $objPrimeMember->expiry_date = $endDate;
                        $objPrimeMember->active = 1;
                        $objPrimeMember->save();
                        $this->processCustomerGroup(
                            $objPrimeMember->id_customer,
                            0,
                            $objPrimeMember->id_customer_group
                        );
                        unset($objPrimeMember);
                    }
                }
                Tools::redirectAdmin(self::$currentIndex.'&conf=4&token='.$this->token);
            }
        }
        parent::postProcess();
    }

    public function processStatus()
    {
        $object = $this->loadObject();
        if (Validate::isLoadedObject($object)) {
            $activatedDate = strtotime($object->activated_date);
            if ($activatedDate == 0 || $activatedDate === false || $activatedDate < 0) {
                $expiryDate = date(
                    "Y-m-d H:i:s",
                    strtotime("+".$object->duration.' '.$object->type, strtotime(date('Y-m-d H:i:s')))
                );
                if ($object->is_extended == 1) {
                    $expiryDate = date(
                        "Y-m-d H:i:s",
                        strtotime("+".$object->duration.' '.$object->type, strtotime(date('Y-m-d H:i:s')))
                    );
                    $oldPrimeUser = new TfPrimeMembershipCustomer($object->id_reference);
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
                            $expiryDate = date(
                                "Y-m-d H:i:s",
                                strtotime("+".$remainingDay.' days', strtotime($expiryDate))
                            );
                        }
                        $oldPrimeUser->active = 2;
                        $oldPrimeUser->update();
                        // End of code
                    }
                } elseif ($object->is_renew == 1) {
                    $oldPrimeUser = new TfPrimeMembershipCustomer($object->id_reference);
                    $oldPrimeUser->active = 2;
                    $oldPrimeUser->update();
                }
                $object->activated_date = date('Y-m-d H:i:s');
                $object->expiry_date = $expiryDate;
                $object->update();
            }
            $this->processCustomerGroup($object->id_customer, $object->active, $object->id_customer_group);
        }
        parent::processStatus();
    }

    public function processCustomerGroup($idCustomer, $status, $idCustomerGroup)
    {
        $objPrimeMember = new TfPrimeMembershipCustomer();
        if (!$status) {
            $objPrimeMember->addCustomerIntoPrimeGroup($idCustomer, $idCustomerGroup);
        } else {
            $objPrimeMember->removeCustomerFromPrimeGroup($idCustomer, $idCustomerGroup);
        }
    }

    public function setMedia($isNewTheme = false)
    {
        if ($isNewTheme || !$isNewTheme) {
            parent::setMedia(false);
            $this->context->controller->addJs('//cdn.jsdelivr.net/npm/flatpickr');
            $this->context->controller->addJs(
                _MODULE_DIR_.$this->module->name.'/views/js/admin/jquery.multiselect.js'
            );
            $this->context->controller->addJs(
                _MODULE_DIR_.$this->module->name.'/views/js/admin/tf_prime_customer.js'
            );
            $this->context->controller->addCSS(
                _MODULE_DIR_.$this->module->name.'/views/css/admin/jquery.multiselect.css'
            );
            $this->context->controller->addcss('//cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
        }
    }

    public function ajaxProcessGetMoreCustomers()
    {
        $load = Configuration::get('TF_PRIME_PRO_LOAD_MORE');
        if (!$load) {
            $load = 50;
        }
        $lastCount = Tools::getValue('lastCount');
        if (!$lastCount) {
            $lastCount = 0;
        }
        $result = TfPrimeMembershipCustomer::getCustomers(true, $lastCount, $load);
        $customers = array(
            'currentCount' => (int) $lastCount + count($result),
            'customers' => $result
        );
        die(json_encode($customers));
    }
}
