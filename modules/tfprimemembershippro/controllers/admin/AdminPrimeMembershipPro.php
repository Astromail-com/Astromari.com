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

class AdminPrimeMembershipProController extends ModuleAdminController
{
    public function __construct()
    {
        $this->identifier = 'id_tf_prime_membership_plan';
        parent::__construct();
        $this->table = 'tf_prime_membership_plan';
        $this->className = 'TfPrimeMembershipPlan';
        $this->bootstrap = true;
        $this->list_no_link = true;
        $this->_select = '
        pl.name,
        tx.name as tax_rule_name';
        $this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'tf_prime_membership_plan_lang` pl ON
            (pl.`id_tf_prime_membership_plan` = a.`id_tf_prime_membership_plan`)';
            $this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'tax_rules_group` tx ON
            (tx.`id_tax_rules_group` = a.`id_tax_rules_group`)';
        $this->_where .= ' AND
            a.`id_shop` = '.(int) $this->context->shop->id.' AND
            pl.`id_lang` = '.(int) $this->context->language->id;

        $this->_orderWay = 'DESC';
        
        $this->fields_list = array(
            'id_tf_prime_membership_plan' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ),
            'id_product' => array(
                'title' => $this->l('Product ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ),
            'name' => array(
                'title' => $this->l('Membership Name'),
                'align' => 'center',
                'havingFilter' => true,
            ),
            'price' => array(
                'title' => $this->l('Plan Price'),
                'align' => 'center',
                'type' => 'price',
                'havingFilter' => true,
            ),
            'tax_rule_name' => array(
                'title' => $this->l('Tax Rule'),
                'align' => 'center',
                'havingFilter' => true,
            ),
            'type' => array(
                'title' => $this->l('Type'),
                'align' => 'center',
                'callback' => 'setPlanType',
                'havingFilter' => true,
            ),
            'duration' => array(
                'title' => $this->l('Duration'),
                'align' => 'center',
                'havingFilter' => true,
            ),
            'allow_renew' => array(
                'title' => $this->l('Allow Renew'),
                'align' => 'center',
                'type' => 'bool',
                'active' => 'allow_renew',
                'class' => 'fixed-width-xs',
            ),
            'allow_extend' => array(
                'title' => $this->l('Allow Extend'),
                'align' => 'center',
                'type' => 'bool',
                'active' => 'allow_extend',
                'class' => 'fixed-width-xs',
            ),
            'active' => array(
                'title' => $this->l('Status'),
                'align' => 'center',
                'active' => 'status',
                'type' => 'bool',
                'class' => 'fixed-width-xs',
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
        );
        $this->addRowAction('edit');
    }

    public function setPlanType($val)
    {
        if ($val == 'days') {
            return $this->l('Day Wise');
        } elseif ($val == 'months') {
            return $this->l('Montly');
        } elseif ($val == 'years') {
            return $this->l('Yearly');
        }
    }

    public function postProcess()
    {
        if (Tools::getIsset('allow_renew'.$this->table)) {
            $id = Tools::getValue('id_tf_prime_membership_plan');
            if ($id) {
                $tfPrimeMembershipPlan = new TfPrimeMembershipPlan($id);
                $tfPrimeMembershipPlan->allow_renew = $tfPrimeMembershipPlan->allow_renew ? 0 : 1;
                $tfPrimeMembershipPlan->update();
                Tools::redirectAdmin(self::$currentIndex.'&conf=4&token='.$this->token);
            }
        } elseif (Tools::getIsset('allow_extend'.$this->table)) {
            $id = Tools::getValue('id_tf_prime_membership_plan');
            if ($id) {
                $tfPrimeMembershipPlan = new TfPrimeMembershipPlan($id);
                $tfPrimeMembershipPlan->allow_extend = $tfPrimeMembershipPlan->allow_extend ? 0 : 1;
                $tfPrimeMembershipPlan->update();
                Tools::redirectAdmin(self::$currentIndex.'&conf=4&token='.$this->token);
            }
        } elseif (Tools::getIsset('img_delete')) {
            $id = Tools::getValue('id');
            if ($id) {
                $tfPrimeMembershipPlan = new TfPrimeMembershipPlan($id);
                if (Validate::isLoadedObject($tfPrimeMembershipPlan)) {
                    $imgName = $tfPrimeMembershipPlan->img_name;
                    if ($imgName) {
                        $m = $this->module->name;
                        $id = $tfPrimeMembershipPlan->id;
                        $img = _PS_MODULE_DIR_.$m.'/views/img/'.$id.'/'.$imgName;
                        if (@getimagesize($img)) {
                            unlink($img);
                            $tfPrimeMembershipPlan->img_name = 0;
                            $tfPrimeMembershipPlan->update();
                            Tools::redirectAdmin(
                                self::$currentIndex.
                                '&id_tf_prime_membership_plan='.
                                $id.
                                '&update'.
                                $this->table.
                                '&conf=7&token='.
                                $this->token
                            );
                        }
                    }
                }
            }

            Tools::redirectAdmin(
                self::$currentIndex.
                '&token='.
                $this->token
            );
        } elseif (Tools::getIsset('submitBulkenableSelection'.$this->table)) {
            $ids = Tools::getValue($this->table.'Box');
            if ($ids) {
                foreach ($ids as $id) {
                    $object = new $this->className($id);
                    $object->active = 1;
                    $object->update();
                }
            }
        } elseif (Tools::getIsset('submitBulkdisableSelection'.$this->table)) {
            $ids = Tools::getValue($this->table.'Box');
            if ($ids) {
                foreach ($ids as $id) {
                    $object = new $this->className($id);
                    $object->active = 0;
                    $object->update();
                }
            }
        }
        parent::postProcess();
    }

    public function renderView()
    {
        $this->context->smarty->assign(
            array(
                'modules_dir' => _MODULE_DIR_
            )
        );
        return parent::renderView();
    }

    public function renderForm()
    {
        $id = Tools::getValue('id_tf_prime_membership_plan');
        if ($id) {
            $tfPrimeMembershipPlan = new TfPrimeMembershipPlan($id);
            if (Validate::isLoadedObject($tfPrimeMembershipPlan)) {
                $imgName = $tfPrimeMembershipPlan->img_name;
                if ($imgName) {
                    $m = $this->module->name;
                    $id = $tfPrimeMembershipPlan->id;
                    $img = _PS_MODULE_DIR_.$m.'/views/img/'.$id.'/'.$imgName;
                    if (@getimagesize($img)) {
                        $img = _MODULE_DIR_.$m.'/views/img/'.$id.'/'.$imgName;
                        $this->context->smarty->assign(
                            array(
                                'img' => $img,
                                'deleteLink' => $this->context->link->getAdminLink('AdminPrimeMembershipPro').
                                    '&id='.
                                    $id.
                                    '&img_delete=1'
                            )
                        );
                    }
                }
                $this->context->smarty->assign(
                    array(
                        'tfPrimeMembershipPlan' => $tfPrimeMembershipPlan
                    )
                );
            }
        }

        $taxRule = TaxRulesGroup::getTaxRulesGroups(true);

        $this->fields_form = array(
            'submit' => array(
                'title' => $this->l('Save')
            )
        );
        Media::addJsDef(
            array(
                'imgError' => $this->l('Image is not valid. Please try different')
            )
        );
        $currentLang = new Language($this->context->language->id);
        $this->context->smarty->assign(
            array(
                'languages' => Language::getLanguages(),
                'current_lang' => (array) $currentLang,
                'sign' => $this->context->currency->sign,
                'tax_rules' => $taxRule,
            )
        );
        $this->context->controller->addJs(
            _MODULE_DIR_.$this->module->name.'/views/js/admin/admin_prime_membership.js'
        );
        return parent::renderForm();
    }

    public function processSave()
    {
        if (Tools::isSubmit('submitAdd'.$this->table)) {
            $id = Tools::getValue('id');
            $price = trim(Tools::getValue('price'));
            $taxRule = trim(Tools::getValue('tax_rule'));
            $type = trim(Tools::getValue('type'));
            $duration = trim(Tools::getValue('duration'));
            $allowExtend = trim(Tools::getValue('allow_extend'));
            $allowRenew = trim(Tools::getValue('allow_renew'));
            $languages = Language::getLanguages(true);
            $psDefaultLang = Configuration::get('PS_LANG_DEFAULT');
            $objDefaultLang = Language::getLanguage((int) $psDefaultLang);
            $idShop = $this->context->shop->id;
            $idShopDefault = $this->context->shop->id_shop_group;
            $primeDefaultName = trim(Tools::getValue('name_'.$psDefaultLang));
            if (!$primeDefaultName) {
                $this->errors[] = sprintf(
                    $this->l('Prime name can not be empty in %s'),
                    $objDefaultLang['name']
                );
            }
            foreach ($languages as $language) {
                if ($primeName = Tools::getValue('name_'.$language['id_lang'])) {
                    if (!Validate::isGenericName($primeName)) {
                        $this->errors[] = sprintf(
                            $this->l('Prime name is not valid in  %s'),
                            $language['name']
                        );
                    } elseif (Tools::strlen($primeName) > 32) {
                        $this->errors[] = $this->l('Membership plan name can not be more than 32 characters.');
                    }
                }
            }

            if (!$duration) {
                $this->errors[] = $this->l('Membership plan duration can not be empty.');
            } elseif ($duration == 0) {
                $this->errors[] = $this->l('Membership plan duration must be greater than 0.');
            } elseif (!Validate::isUnsignedInt($duration)) {
                $this->errors[] = $this->l('Membership plan duration is not invalid');
            }

            if (!(float)$price) {
                $this->errors[] = $this->l('Membership plan price can not be empty.');
            } elseif (!Validate::isPrice($price)) {
                $this->errors[] = $this->l('Membership plan price is not valid.');
            }

            $features = trim(Tools::getValue('features_'.$psDefaultLang));
            if (!$features) {
                $this->errors[] = sprintf(
                    $this->l('Feature can not be empty in %s'),
                    $objDefaultLang['name']
                );
            } elseif (Tools::strlen($features) > Configuration::get('PS_PRODUCT_SHORT_DESC_LIMIT')) {
                $this->errors[] = $this->l('Membership featurs can not be exceed 800 characters.');
            }
            foreach ($languages as $language) {
                if ($features = Tools::getValue('features_'.$language['id_lang'])) {
                    if (!Validate::isCleanHtml($features)) {
                        $this->errors[] = sprintf(
                            $this->l('Feature is not valid in  %s'),
                            $language['name']
                        );
                    }
                }
            }

            $prestaDescription = trim(Tools::getValue('presta_description_'.$psDefaultLang));
            if (!$prestaDescription) {
                $this->errors[] = sprintf(
                    $this->l('Description can not be empty in %s'),
                    $objDefaultLang['name']
                );
            }
            foreach ($languages as $language) {
                if ($prestaDescription = Tools::getValue('presta_description_'.$language['id_lang'])) {
                    if (!Validate::isCleanHtml($prestaDescription)) {
                        $this->errors[] = sprintf(
                            $this->l('Description is not valid in  %s'),
                            $language['name']
                        );
                    }
                }
            }

            if ($_FILES['tf_prime_img']['tmp_name'] && $_FILES['tf_prime_img']['size']) {
                if (!ImageManager::isCorrectImageFileExt($_FILES['tf_prime_img']['name'])) {
                    $this->errors[] = $this->l('Invalid image extensions, only jpg, jpeg and png are allowed.');
                }
            }

            if (empty($this->errors)) {
                $idProduct = $idCustomerGroup = 0;
                $TfPrimeMembershipPlan = new TfPrimeMembershipPlan();
                if ($id) {
                    $TfPrimeMembershipPlan = new TfPrimeMembershipPlan($id);
                    if (!Validate::isLoadedObject($TfPrimeMembershipPlan)) {
                        $TfPrimeMembershipPlan = new TfPrimeMembershipPlan();
                    } else {
                        $idProduct = $TfPrimeMembershipPlan->id_product;
                        $product = new Product($idProduct);
                        if (!Validate::isLoadedObject($product)) {
                            $idProduct = 0;
                        }
                        $idCustomerGroup = $TfPrimeMembershipPlan->id_customer_group;
                        $group = new Group($idCustomerGroup);
                        if (!Validate::isLoadedObject($group)) {
                            $idCustomerGroup = 0;
                        }
                    }
                }
                $idProduct = $TfPrimeMembershipPlan->createMembershipProduct(
                    $price,
                    $taxRule,
                    $idProduct,
                    $idShop,
                    $idShopDefault
                );
                if (!$idProduct) {
                    $this->errors[] = $this->l('Product can not be created for this membership plan.');
                }
                $idCustomerGroup = $TfPrimeMembershipPlan->createPrimeCustomerGroup($idCustomerGroup);
                if (!$idCustomerGroup) {
                    $this->errors[] = $this->l('Customer group can not be created for this membership plan.');
                }
                if (empty($this->errors)) {
                    $TfPrimeMembershipPlan->id_product = $idProduct;
                    $TfPrimeMembershipPlan->id_shop = $idShop;
                    $TfPrimeMembershipPlan->id_shop_default = $idShopDefault;
                    $TfPrimeMembershipPlan->id_customer_group = $idCustomerGroup;

                    $primeDefaultName = trim(Tools::getValue('name_'.$psDefaultLang));
                    $primeDefaultFeatures = trim(Tools::getValue('features_'.$psDefaultLang));
                    $primeDefaulDesc = trim(Tools::getValue('presta_description_'.$psDefaultLang));
                    foreach ($languages as $language) {
                        $primeName = trim(Tools::getValue('name_'.$language['id_lang']));
                        $features = trim(Tools::getValue('features_'.$language['id_lang']));
                        $prestaDescription = trim(Tools::getValue('presta_description_'.$language['id_lang']));

                        if (!$primeName) {
                            $primeName = $primeDefaultName;
                        }
                        if (!$features) {
                            $features = $primeDefaultFeatures;
                        }
                        if (!$prestaDescription = Tools::getValue('presta_description_'.$language['id_lang'])) {
                            $prestaDescription = $primeDefaulDesc;
                        }

                        $TfPrimeMembershipPlan->name[$language['id_lang']] = $primeName;
                        $TfPrimeMembershipPlan->features[$language['id_lang']] = $features;
                        $TfPrimeMembershipPlan->description[$language['id_lang']] = $prestaDescription;
                    }

                    $TfPrimeMembershipPlan->type = $type;
                    $TfPrimeMembershipPlan->duration = $duration;
                    $TfPrimeMembershipPlan->price = $price;
                    $TfPrimeMembershipPlan->id_tax_rules_group = $taxRule;
                    $TfPrimeMembershipPlan->id_currency = Configuration::get('PS_CURRENCY_DEFAULT');
                    $TfPrimeMembershipPlan->allow_renew = $allowExtend;
                    $TfPrimeMembershipPlan->allow_extend = $allowRenew;
                    if (!$id) {
                        $TfPrimeMembershipPlan->img_name = 0;
                    }
                    $TfPrimeMembershipPlan->active = 1;
                    if ($id) {
                        $conf = 4;
                        $TfPrimeMembershipPlan->update();
                    } else {
                        $conf = 3;
                        $TfPrimeMembershipPlan->save();
                    }

                    if ($_FILES['tf_prime_img']['tmp_name'] && $_FILES['tf_prime_img']['size']) {
                        $folderPath = _PS_MODULE_DIR_.$this->module->name.'/views/img/'.$TfPrimeMembershipPlan->id.'/';
                        if (!file_exists($folderPath) && !is_dir($folderPath)) {
                            @mkdir($folderPath, 0777, true);
                            @chmod($folderPath, 0777);
                        }
                        if (ImageManager::resize(
                            $_FILES['tf_prime_img']['tmp_name'],
                            $folderPath.$_FILES['tf_prime_img']['name']
                        )) {
                            $TfPrimeMembershipPlan->img_name = $_FILES['tf_prime_img']['name'];
                            $TfPrimeMembershipPlan->update();

                            $position = Image::getHighestPosition($idProduct) + 1;
                            $image = new Image();
                            $image->id_product = $idProduct;
                            $image->position = $position;
                            $image->cover = 1;
                            $image->legend = $_FILES['tf_prime_img']['name'];
                            $image->add();

                            $new_path = $image->getPathForCreation();
                            if (!($tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS')) ||
                                !move_uploaded_file($_FILES['tf_prime_img']['tmp_name'], $tmpName)
                            ) {
                                $this->errors[] = $this->l('An error occurred while uploading the image.');
                            } elseif (!ImageManager::resize($tmpName, $new_path . '.' . $image->image_format)) {
                                $this->errors[] = $this->l('An error occurred while uploading the image.');
                            } else {
                                $imagesTypes = ImageType::getImagesTypes('products');
                                if ($imagesTypes) {
                                    foreach ($imagesTypes as $imageType) {
                                        if (!ImageManager::resize(
                                            $tmpName,
                                            $new_path.'-'.stripslashes($imageType['name']).'.'.$image->image_format,
                                            $imageType['width'],
                                            $imageType['height'],
                                            $image->image_format)
                                        ) {
                                            $this->errors[] = $this->l('An error occurred while copying this image.');
                                        }
                                    }
                                }
                            }
                        }
                        @chmod($folderPath.$_FILES['tf_prime_img'], 0777);
                    }

                    Tools::redirectAdmin(
                        self::$currentIndex.
                        '&id='.
                        $TfPrimeMembershipPlan->id.
                        '&update'.
                        $this->table.
                        '&conf='.
                        $conf.
                        '&token='.
                        $this->token
                    );
                }
            } else {
                if (!$id) {
                    $this->display = 'edit';
                } else {
                    $this->display = 'add';
                }
            }
        }
    }
}
