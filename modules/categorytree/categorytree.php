<?php
/**
* 2007-2020 Weblir
*
*  @author    weblir <contact@weblir.com>
*  @copyright 2012-2020 weblir
*  @license   weblir.com
*  You are allowed to modify this copy for your own use only. You must not redistribute it. License
*  is permitted for one Prestashop instance only but you can install it on your test instances.
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class CategoryTree extends Module
{

    private $html = '';

    public function __construct()
    {
        $this->name = 'categorytree';
        $this->tab = 'administration';
        $this->version = '1.4.5';
        $this->author = 'weblir';
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);

        $this->need_instance = 0;
        $this->bootstrap = true;

        $this->displayName = $this->l('Product category parent assign, category tree regenerate');
        $this->description = $this->l('Add or remove products from default category parents,
            regenerate the category tree for products and categories');
        $this->module_key = '12d801e9037700e4fa425d2591eb0685';
        parent::__construct();
    }

    public function install()
    {
        if (!parent::install()) {
            return false;
        }
            
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }
        return true;
    }

    public function getContent()
    {
        $this->postProcess();
        $this->displayCustomTop();
        $this->displayCustomBottom();
        $this->displayForm();
        return $this->html;
    }

    public function getCategoryParent($id_category)
    {
        $category = new Category($id_category);
        if (Validate::isLoadedObject($category)) {
            $id_parent = $category->id_parent;
        }
        return (int)$id_parent;
    }

    public function getAllCategoryParents($id_category, $include_home = false)
    {
        $list = array();
        $new = $id_category;

        while ($new >= 1) {
            $new = $this->getCategoryParent($new);
            if ((int)$new>1) {
                if ($include_home) {
                    array_push($list, $new);
                } else {
                    if ((int)$new != (int)Configuration::get('PS_HOME_CATEGORY')) {
                        array_push($list, $new);
                    }
                }
            }
        }

        if ($include_home) {
            unset($list[(int)Configuration::get('PS_HOME_CATEGORY')]);
        }

        return $list;
    }

    private function postProcess()
    {
        if (Tools::isSubmit('submitUpdate')) {
            if (Tools::getValue('CATEGORYTREE_PRODUCT') == 1) {
                $include_home = (int)Tools::getValue('CATEGORYTREE_HOME');
                $products = Db::getInstance()->executeS(
                    'SELECT id_product FROM '._DB_PREFIX_.'product'
                );
                foreach ($products as $product) {
                    $product = new Product($product['id_product'], $this->context->language->id);
                    $parents = $this->getAllCategoryParents($product->id_category_default, $include_home);
                    $product->addToCategories($parents);
                }
                $this->html .= $this->displayConfirmation(
                    $this->l('Product Category Tree Regeneration successfully executed.')
                );
            }

            if (Tools::getValue('CATEGORYTREE_CATEGORY') == 1) {
                Category::regenerateEntireNtree();
                $this->html .= $this->displayConfirmation(
                    $this->l('Category Tree Regeneration successfully executed.')
                );
            }

            if (Tools::getValue('CATEGORYTREE_CATEGORY') == 0 && Tools::getValue('CATEGORYTREE_PRODUCT') == 0) {
                $this->html .= $this->displayError(
                    'The regeneration could not be performed because no option has been selected!'
                );
            }
        }

        if (Tools::isSubmit('submitRevert')) {
            if (Tools::getValue('CATEGORYTREE_PRODUCT_REVERT') == 1) {
                $products = Db::getInstance()->executeS(
                    'SELECT id_product FROM '._DB_PREFIX_.'product'
                );
                foreach ($products as $product) {
                    $product = new Product($product['id_product'], $this->context->language->id);
                    $product_default_category = $product->id_category_default;
                    $product->deleteCategories(true);
                    $product->addToCategories($product_default_category);
                }
                $this->html .= $this->displayConfirmation(
                    $this->l('Product Category Assignment successfully executed.')
                );
            }

            if (Tools::getValue('CATEGORYTREE_PRODUCT_REVERT') == 0) {
                $this->html .= $this->displayError(
                    'The action could not be performed because no option has been selected!'
                );
            }
        }
    }

    private function displayCustom()
    {
        // With Template
        $this->context->smarty->assign(array(
            'path' => $this->_path,
            'secret' => Configuration::get('OLX_SECRET_FEED')
        ));

        if (Tools::getIsset('add_product')) {
            $this->context->smarty->assign(array(
                'path' => $this->_path,
                'secret' => Configuration::get('OLX_SECRET_FEED'),
                'go' => 'go'
            ));
        }
        $this->html .= $this->display(__FILE__, 'backoffice.tpl');
    }

    private function displayCustomTop()
    {
        $shop = Tools::getHttpHost(true).__PS_BASE_URI__;
        $ref = implode('', array('a','d','d','o','n','s'));
        $module_version = $this->version;

        $this->context->smarty->assign(array(
            'path'=> $this->_path,
            'module_page'=> $this->context->link->getAdminLink(
                'AdminModules',
                false
            ).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.
            $this->name.'&token='.Tools::getAdminTokenLite('AdminModules'),
            'shop'=> $shop,
            'ref'=> $ref,
            'moduleversion'=> $module_version,
            'modulename'=> $this->name,
            'moduletitle'=> $this->displayName
        ));
        $this->html .= $this->display(__FILE__, 'top.tpl');
    }

    private function displayCustomBottom()
    {
        $this->html .= $this->display(__FILE__, 'bottom.tpl');
    }

    public function displayForm()
    {
        $this->html .= $this->displayCustom();
        $this->html .= $this->generateForm();
    }

    private function generateForm()
    {
        $inputs = array();
        $inputs2 = array();
        $inputs[] = array(
            'type' => 'switch',
            'label' => $this->l('Regenerate Product Category Tree'),
            'name' => 'CATEGORYTREE_PRODUCT',
            'hint' => $this->l('Set this option to Yes only if you have products that have a default category
                but those products are not assigned to the parent categories of the default category'),
            'class' => 'targeted',
            'desc' => $this->l('If the Yes option is selected, the module will parse all
                products from the shop and regenerate it\'s category tree.'),
            'values' => array(
                array(
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Yes')
                    ),
                array(
                    'id' => 'active_ff',
                    'value' => 0,
                    'label' => $this->l('No')
                )
            )
        );

        $inputs[] = array(
            'type' => 'switch',
            'label' => $this->l('Include Home category'),
            'name' => 'CATEGORYTREE_HOME',
            'hint' => $this->l('If you set this option to Yes, the module will assign the products to home category.')
            .' '.$this->l('Enabling this option will set all products as featured!'),
            'class' => 'targeted',
            'desc' => $this->l('If the option is enabled, the products will be assigned to the Home category also.'),
            'values' => array(
                array(
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Yes')
                    ),
                array(
                    'id' => 'active_ff',
                    'value' => 0,
                    'label' => $this->l('No')
                )
            )
        );

        $inputs[] = array(
            'type' => 'switch',
            'label' => $this->l('Regenerate Category Tree for Categories'),
            'name' => 'CATEGORYTREE_CATEGORY',
            'desc' => $this->l('If the Yes option is selected, the module will regenerate the Category N Tree.
                Set this option to Yes if there are issues with the Category Tree'),
            'values' => array(
                array(
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Yes')
                ),
                array(
                    'id' => 'active_ff',
                    'value' => 0,
                    'label' => $this->l('No')
                )
            )
        );

        $inputs2[] = array(
            'type' => 'switch',
            'label' => $this->l('Assign to default category only'),
            'name' => 'CATEGORYTREE_PRODUCT_REVERT',
            'hint' => $this->l('Removes all products from all cateogries and add them only into the default category'),
            'class' => '',
            'desc' => $this->l('Set this option to Yes if you want all products to be assigned only in their
                Default Category. This will remove them from the parent categories.'),
            'values' => array(
                array(
                    'id' => 'active_on',
                    'value' => 1,
                    'label' => $this->l('Yes')
                    ),
                array(
                    'id' => 'active_ff',
                    'value' => 0,
                    'label' => $this->l('No')
                )
            )
        );

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs'
                    ),
                'input' => $inputs,
                'submit' => array(
                    'title' => $this->l('Start'),
                    'class' => 'btn btn-default pull-right',
                    'name' => 'submitUpdate'
                )
            )
        );

        $fields_form2 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Revert Product category assign'),
                    'icon' => 'icon-cogs'
                    ),
                'input' => $inputs2,
                'submit' => array(
                    'title' => $this->l('Start'),
                    'class' => 'btn btn-default pull-right',
                    'name' => 'submitRevert'
                )
            )
        );

        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper = new HelperForm();
        $helper->default_form_language = $lang->id;
        // $helper->submit_action = 'submitUpdate';
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false
        ).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
        );
        return $helper->generateForm(array($fields_form, $fields_form2));
    }

    public function getConfigFieldsValues()
    {
        // name => value
        return array(
            'CATEGORYTREE_PRODUCT' => '0',
            'CATEGORYTREE_CATEGORY' => '0',
            'CATEGORYTREE_HOME' => '0',
            'CATEGORYTREE_PRODUCT_REVERT' => '0'
        );
    }

    public function psversion()
    {
        $version = _PS_VERSION_;
        $ver = explode(".", $version);
        return $ver[1];
    }
}
