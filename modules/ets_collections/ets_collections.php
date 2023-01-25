<?php
/**
 * 2007-2021 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2021 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;
require_once(dirname(__FILE__) . '/classes/ets_collection_class.php');
require_once(dirname(__FILE__) . '/classes/Ets_col_paggination_class.php');
require_once(dirname(__FILE__) . '/classes/ets_col_defines.php');
if (!defined('_ETS_COLLECTION_CACHE_DIR_')) 
    define('_ETS_COLLECTION_CACHE_DIR_',_PS_CACHE_DIR_.'ets_collection_cache/');
class Ets_collections extends Module
{
    public $_errors = array();
    public $is17 = false;
    public $hooks_display = array();
    public function __construct()
    {
        $this->name = 'ets_collections';
        $this->tab = 'front_office_features';
        $this->version = '1.0.4';
        $this->author = 'ETS-Soft';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        parent::__construct();
		$this->module_key = '7a77b0a666933ff72256b7e373193511';
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->module_dir = $this->_path;
        $this->displayName = $this->l('Product Collections');
        $this->description = $this->l('Product Collections is a product showcase module for PrestaShop that makes it easier for your customers to discover, browse and purchase products in a visual and diverse way.');
        if(version_compare(_PS_VERSION_, '1.7', '>='))
            $this->is17 = true;
        $this->hooks_display = array('home_page','product_page','right_column','left_column','custom_hook');
    }
    public function install()
    {
        return parent::install() && Ets_col_defines::getInstance()->_installDb() && $this->_installTabs()&&$this->_installHooks() && $this->_installDefaultConfig();
    }
    public function unInstall()
    {
        return parent::unInstall() && Ets_col_defines::getInstance()->_uninstallDb() && $this->_uninstallTabs() && $this->_unInstallHooks()&& $this->_unInstallDefaultConfig()&& $this->deleteDir(_PS_IMG_DIR_.'col_collection/');
    }
    public function _installDefaultConfig()
    {
        $inputs = $this->getConfigInputs();
        $languages = Language::getLanguages(false);
        if($inputs)
        {
            foreach($inputs as $input)
            {
                if(isset($input['default']) && $input['default'])
                {
                    if(isset($input['lang']) && $input['lang'])
                    {
                        $values = array();
                        foreach($languages as $language)
                        {
                            $values[$language['id_lang']] = isset($input['default_lang']) && $input['default_lang'] ? $this->getTextLang($input['default_lang'],$language) : $input['default'];
                        }
                        Configuration::updateGlobalValue($input['name'],$values);
                    }
                    else
                        Configuration::updateGlobalValue($input['name'],$input['default']);
                }
            }
        }
        return true;
    }
    public function _unInstallDefaultConfig()
    {
        $inputs = $this->getConfigInputs();
        if($inputs)
        {
            foreach($inputs as $input)
            {
                Configuration::deleteByName($input['name']);
            }
        }
        Configuration::deleteByName('PS_ROUTE_ets_col_collections');
        Configuration::deleteByName('PS_ROUTE_ets_col_collection');
        return true;          
    }
    public function _installTabs()
    {
        if ($parentId = Tab::getIdFromClassName('AdminCatalog')) {
            $languages = Language::getLanguages(false);
            $tab = new Tab();
            $tab->id_parent = (int)$parentId;
            $tab->class_name = 'AdminProductCollections';
            $tab->icon = 'icon-collecions';
            $tab->module = $this->name;
            foreach ($languages as $l) {
                $tab->name[$l['id_lang']] = $this->getTextLang('Product collections',$l) ?: $this->l('Product collections');
            }
            if (!Tab::getIdFromClassName($tab->class_name))
                return $tab->add();
        }
        return true;
    }
    public function _uninstallTabs()
    {
        if ($id = Tab::getIdFromClassName('AdminProductCollections')) {
            $tab = new Tab((int)$id);
            if ($tab->delete()) {
                return true;
            }
        }
        return true;
    }
    public function _installHooks()
    {
        return $this->registerHook('displayBackOfficeHeader')
        && $this->registerHook('moduleRoutes')
        && $this->registerHook('displayHeader')
        && $this->registerHook('displayHome')
        && $this->registerHook('displayFooterProduct') 
        && $this->registerHook('displayLeftColumn')
        && $this->registerHook('displayRightColumn')
        && $this->registerHook('etsColCustomListProduct')
        && $this->registerHook('actionValidateOrder');
    }
    public function _unInstallHooks()
    {
        return $this->unregisterHook('displayBackOfficeHeader')
        && $this->unregisterHook('moduleRoutes')
        && $this->unregisterHook('displayHeader')
        && $this->unregisterHook('displayHome')
        && $this->unregisterHook('displayFooterProduct') 
        && $this->unregisterHook('displayLeftColumn') 
        && $this->unregisterHook('displayRightColumn')
        && $this->unregisterHook('etsColCustomListProduct')
        && $this->unregisterHook('actionValidateOrder');
    }
    public function hookModuleRoutes()
    {
        $id_lang = $this->context->language->id;
        $subfix = Configuration::get('ETS_COL_URL_SUBFIX') ? '.html': '';
        $collectionAlias = Configuration::get('ETS_COL_ALIAS',$id_lang) ? : 'collections';
        $routes = array(
            'ets_col_collections' => array(
                'controller' => 'collection',
                'rule' => $collectionAlias.$subfix,
                'keywords' => array(),
                'params' => array(
                    'fc' => 'module',
                    'module' => $this->name,
                ),
            ),
            'ets_col_collection' => array(
                'controller' => 'collection',
                'rule' => $collectionAlias.'/{id_collection}-{url_alias}'.$subfix,
                'keywords' => array(
                    'url_alias'       =>   array('regexp' => '[_a-zA-Z0-9-\pL]+','param' => 'url_alias'),
                    'id_collection' =>    array('regexp' => '[0-9]+', 'param' => 'id_collection'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => $this->name,
                ),
            ),
        );
        return $routes;
    }
    public function hookActionValidateOrder($params)
    {
        if(!isset($params['cart']) || !isset($params['order']) || !$params['cart'] || !($order = $params['order']))
            return;
        $products = $order->getProductsDetail();
        if($products)
        {
            foreach($products as $product)
            {
                if(Ets_collection_class::checkProductViewd($product['product_id']))
                    Ets_collection_class::addProductOrder($product,$order->id);
            }
        }
    }
    public function hookDisplayHeader()
    {
        $controller = Tools::getValue('controller');
        if($this->checkAddCss())
        {
            $this->context->controller->addCSS($this->_path . 'views/css/product-list.css', 'all');
            $this->context->controller->addCSS($this->_path.'views/css/collection.css'); 
            if($this->checkCarouselslide())
            {
                $this->context->controller->addCSS($this->_path . 'views/css/slick.css', 'all');
                $this->context->controller->addJS($this->_path . 'views/js/slick.min.js');
                $this->context->controller->addJS($this->_path . 'views/js/product-list.js');
            }
            if(!$this->is17)
                $this->context->controller->addCSS($this->_path . 'views/css/product-list-16.css', 'all');
            $this->context->controller->addJS($this->_path.'views/js/collection.js'); 
        }
        if($controller=='product' && ($id_product= (int)Tools::getValue('id_product')) && ($product = new Product($id_product)) && Validate::isLoadedObject($product) &&  ($id_collection = (int)Tools::getValue('id_collection')) && ($collection = new Ets_collection_class($id_collection)) && Validate::isLoadedObject($collection))
        {
            $collection->addProductView($id_product);
        }
        if(!$this->is17)
            $this->context->controller->addCSS($this->_path . 'views/css/product-list-16.css', 'all');
    }
    public function checkAddCss()
    {
        if(Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product>0 AND cd.hook_display IN ("left_column","right_column","product_page","custom_hook")',false,0,false,'',true))
            return true;
        else{
            $fc = Tools::getValue('fc');
            $module = Tools::getValue('module');
            $controller = Tools::getValue('controller');
            if($controller=='index' && (Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product>0 AND cd.hook_display ="home_page"',false,0,false,'',true) || (Configuration::get('ETS_COL_DISPLAY_LIST_HOME_PAGE') && Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product>0',false,0,false,'c.position asc',true))))
                return true;
            elseif($fc=='module' && $module==$this->name && $controller=='collection')
                return true;
        }
        return false;
        
    }
    public function checkCarouselslide()
    {
        if(Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product>0 AND cd.list_layout="slide" AND cd.hook_display IN ("left_column","right_column","product_page","custom_hook")',false,0,false,'',true)){
            return true;
        }
        else{
            $fc = Tools::getValue('fc');
            $module = Tools::getValue('module');
            $controller = Tools::getValue('controller');
            if($controller=='index' && Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product>0 AND cd.list_layout="slide" AND cd.hook_display = "home_page"',false,0,false,'',true) ||(Configuration::get('ETS_COL_DISPLAY_LIST_HOME_PAGE') && Configuration::get('ETS_COL_MODE_LIST_HOME_PAGE')!='grid' && Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product>0',false,0,false,'c.position asc',true) ))
                return true;
            elseif($fc=='module' && $module==$this->name && $controller=='collection')
                return true;
        }
        return false;
    }
    public function _execHook($hook,$params=array())
    {
        $params['hook'] = $hook;
        if($html = $this->getCache($params))
            return $html;
        $collections = Ets_collection_class::getCollectionsByHook($hook,isset($params['id_collection']) ? (int)$params['id_collection']:0,true);
        $html = '';
        if($collections)
        {
            foreach($collections as $collection)
            {
                $html .= $this->displayProductList($collection);
            }
        }
        $this->createCache($html,$params);
        return $html;
    }
    public function displayProductList($collection)
    {
        $products =  Ets_collection_class::getListProducts(' AND colp.id_ets_col_collection="'.(int)$collection['id_ets_col_collection'].'"',0,false,$collection['sort_order']=='random' ? ' RAND()':'colp.position ASC',false,true);
        $this->smarty->assign(array(
            'products' => $products,
            'position'=>'',
            'tab' => 'collection-'.$collection['id_ets_col_collection'],
            'name_page'=>$collection['hook_display'],
            'ets_col_per_row_desktop' =>(int)$collection['per_row_desktop'], //$collection['hook_display']=='right_column' || $collection['hook_display']=='left_column' ? 1: 
            'ets_col_per_row_tablet' => (int)$collection['per_row_tablet'], //$collection['hook_display']=='right_column' || $collection['hook_display']=='left_column' ? 1:
            'ets_col_per_row_mobile' => (int)$collection['per_row_mobile'], //$collection['hook_display']=='right_column' || $collection['hook_display']=='left_column' ? 1:
            'layout_mode' =>  $collection['list_layout'], //$collection['hook_display']=='right_column' || $collection['hook_display']=='left_column' ? 'slide':
            'id_product_page' => (int)Tools::getValue('id_product'),
            'sort_by' => '',
            'sort_options' =>false,
            'collection_name' => $collection['name'],
            'collection_link' => $this->getCollectionLink(array('id_collection'=>$collection['id_ets_col_collection']))
        ));
        if($this->is17)
        {
            $controller = Tools::getValue('controller');
            $this->smarty->assign('page_name',Validate::isControllerName($controller) ? $controller:'');
        }
        $html = $this->display(__FILE__, 'product_list' . ($this->is17 ? '_17' : '') . '.tpl');
        $html = preg_replace('/(<a[^>]+href=\")(http(?:|s):\/\/[^\"]+)\?([^\"\#]+)/','$1$2?$3&id_collection='.$collection['id_ets_col_collection'],$html);
        $html = preg_replace('/(<a[^>]+href=\")(http(?:|s):\/\/[^\"\?\#]+)(\#[^\"]+)?"/','$1$2?id_collection='.$collection['id_ets_col_collection'].'$3"',$html);
        
        return  $html;
    }
    public function displayListCollections()
    {
        $limit = (int)Configuration::get('ETS_COL_NUMBER_COL_HOME_PAGE') ? :false;
        $collections = Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product>0',false,0,$limit,'c.position asc',false);
        if($collections)
        {
            foreach($collections as &$col)
            {
                $col['link_view'] = $this->getCollectionLink(array('id_collection'=>$col['id_ets_col_collection']));
            }
        }
        $this->context->smarty->assign(
            array(
                'collections' => $collections,
                'link_base' => $this->getBaseLink(),
                'paggination' => '',
                'ETS_COL_PAGE_TITLE' => Configuration::get('ETS_COL_PAGE_TITLE',$this->context->language->id),
                'ETS_COL_PAGE_DESCRIPTION' => Configuration::get('ETS_COL_PAGE_DESCRIPTION',$this->context->language->id),
                'collection_mode' => Configuration::get('ETS_COL_MODE_LIST_HOME_PAGE') ? :'slide',
                'row_desktop' => (int)Configuration::get('ETS_COL_NUMBER_COLLECTION_DESKTOP') ? : 4,
                'row_tablet' => (int)Configuration::get('ETS_COL_NUMBER_COLLECTION_TABLET') ? :3,
                'row_mobile' => (int)Configuration::get('ETS_COL_NUMBER_COLLECTION_MOBILE') ? : 1,
                'collection_title' => Configuration::get('ETS_COL_TITLE_LIST_HOME_PAGE',$this->context->language->id) ?: $this->l('Collections'),
            )
        );
        return $this->display(__FILE__,'home_collections.tpl');

    }
    public function hookDisplayHome()
    {
        return $this->_execHook('home_page').(Configuration::get('ETS_COL_DISPLAY_LIST_HOME_PAGE') ? $this->displayListCollections():'');
    }
    public function hookDisplayLeftColumn()
    {
        return $this->_execHook('left_column');
    }
    public function hookDisplayRightColumn()
    {
        return $this->_execHook('right_column');
    }
    public function hookDisplayFooterProduct()
    {
        return $this->_execHook('product_page');
    }
    public function hookEtsColCustomListProduct($params)
    {
        return $this->_execHook('custom_hook',$params);
    }
    public function addJquery()
    {
        if (version_compare(_PS_VERSION_, '1.7.6.0', '>=') && version_compare(_PS_VERSION_, '1.7.7.0', '<'))
            $this->context->controller->addJS(_PS_JS_DIR_ . 'jquery/jquery-'._PS_JQUERY_VERSION_.'.min.js');
        else
            $this->context->controller->addJquery();
    }
    public function hookDisplayBackOfficeHeader()
    {
        $controller = Tools::getValue('controller');
        $configure = Tools::getValue('configure'); 
        if($controller=='AdminProductCollections' || ($controller=='AdminModules' && $configure== $this->name))
        {
            $this->context->controller->addCSS($this->_path.'views/css/admin.css');
            $this->context->controller->addCSS($this->_path.'views/css/popup.css');
            $this->context->controller->addCSS($this->_path.'views/css/admin_module.css');
            $this->addJquery();
            $this->context->controller->addJqueryUI('ui.sortable');
            $this->context->controller->addJqueryPlugin('fancybox');
        }
        $this->context->smarty->assign(
            array(
                 'ets_ol_module_dir' => $this->_path,
            )
        );
    }
    public function getTextLang($text, $lang,$file_name='')
    {
        if(is_array($lang))
            $iso_code = $lang['iso_code'];
        elseif(is_object($lang))
            $iso_code = $lang->iso_code;
        else
        {
            $language = new Language($lang);
            $iso_code = $language->iso_code;
        }
		$modulePath = rtrim(_PS_MODULE_DIR_, '/').'/'.$this->name;
        $fileTransDir = $modulePath.'/translations/'.$iso_code.'.'.'php';
        if(!@file_exists($fileTransDir)){
            return $text;
        }
        $fileContent = Tools::file_get_contents($fileTransDir);
        $text_tras = preg_replace("/\\\*'/", "\'", $text);
        $strMd5 = md5($text_tras);
        $keyMd5 = '<{' . $this->name . '}prestashop>' . ($file_name ? : $this->name) . '_' . $strMd5;
        preg_match('/(\$_MODULE\[\'' . preg_quote($keyMd5) . '\'\]\s*=\s*\')(.*)(\';)/', $fileContent, $matches);
        if($matches && isset($matches[2])){
           return  $matches[2];
        }
        return $text;
    }
    public function getContent()
    {
        $this->_html = '';
        if(Tools::isSubmit('btnclearCache'))
        {
            $this->clearCache();
            $this->_html .= $this->displayConfirmation($this->l('Clear cache successfully'));
        }
        if (Tools::isSubmit('btnSubmit') && !Tools::isSubmit('btnclearCache')) {
            $this->_postValidation();
            if (!count($this->_errors)) {
                $inputs = $this->getConfigInputs();
                $languages = Language::getLanguages(false);
                $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
                foreach($inputs as $input)
                {
                    if(isset($input['lang']) && $input['lang'])
                    {
                        $values = array();
                        foreach($languages as $language)
                        {
                            $value_default = Tools::getValue($input['name'].'_'.$id_lang_default);
                            $value = Tools::getValue($input['name'].'_'.$language['id_lang']);
                            $values[$language['id_lang']] = ($value && Validate::isCleanHtml($value)) || !isset($input['required']) ? $value : (Validate::isCleanHtml($value_default) ? $value_default :'');
                        }
                        Configuration::updateValue($input['name'],$values);
                    }
                    else
                    {
                        $val = Tools::getValue($input['name']);
                        if(Validate::isCleanHtml($val))
                            Configuration::updateValue($input['name'],$val);
                    }
                }
                Configuration::deleteByName('PS_ROUTE_ets_col_collections');
                Configuration::deleteByName('PS_ROUTE_ets_col_collection');
                $this->_html .= $this->displayConfirmation($this->l('Settings updated'));
            } else {
                $this->_html .= $this->displayError($this->_errors);
            }
        }
        $this->_html .= $this->renderForm();
        $this->context->smarty->assign(
            array(
                 'ets_ol_module_dir' => $this->_path,
            )
        );
        return $this->display(__FILE__,'admin_header.tpl'). $this->_html;
    }
    public function _postValidation()
    {
        $languages = Language::getLanguages(false);
        $inputs = $this->getConfigInputs();
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        $ETS_COL_NUMBER_COL_HOME_PAGE = Tools::getValue('ETS_COL_NUMBER_COL_HOME_PAGE');
        if($ETS_COL_NUMBER_COL_HOME_PAGE!=='' && (!Validate::isUnsignedInt($ETS_COL_NUMBER_COL_HOME_PAGE) || $ETS_COL_NUMBER_COL_HOME_PAGE <=0))
            $this->_errors[] = $this->l('Number of collections to display is not valid');
        foreach($inputs as $input)
        {
            if(isset($input['lang']) && $input['lang'])
            {
                if(isset($input['required']) && $input['required'])
                {
                    $val_default = Tools::getValue($input['name'].'_'.$id_lang_default);
                    if(!$val_default)
                    {
                        $this->_errors[] = sprintf($this->l('%s is required'),$input['label']);
                    }
                    elseif($val_default && isset($input['validate']) && ($validate = $input['validate']) && method_exists('Validate',$validate) && !Validate::{$validate}($val_default))
                        $this->_errors[] = sprintf($this->l('%s is not valid'),$input['label']);
                    elseif($val_default && !Validate::isCleanHtml($val_default))
                        $this->_errors[] = sprintf($this->l('%s is not valid'),$input['label']);
                    else
                    {
                        foreach($languages as $language)
                        {
                            if(($value = Tools::getValue($input['name'].'_'.$language['id_lang'])) && isset($input['validate']) && ($validate = $input['validate']) && method_exists('Validate',$validate)  && !Validate::{$validate}($value))
                                $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                            elseif($value && !Validate::isCleanHtml($value))
                                $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                        }
                    }
                }
                else
                {
                    foreach($languages as $language)
                    {
                        if(($value = Tools::getValue($input['name'].'_'.$language['id_lang'])) && isset($input['validate']) && ($validate = $input['validate']) && method_exists('Validate',$validate)  && !Validate::{$validate}($value))
                            $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                        elseif($value && !Validate::isCleanHtml($value))
                            $this->_errors[] = sprintf($this->l('%s is not valid in %s'),$input['label'],$language['iso_code']);
                    }
                }
            }
            else
            {
                $val = Tools::getValue($input['name']);
                if($val===''&& isset($input['required']))
                {
                    $this->_errors[] = sprintf($this->l('%s is required'),$input['label']);
                }
                if($val!=='' && isset($input['validate']) && ($validate = $input['validate']) && method_exists('Validate',$validate) && !Validate::{$validate}($val))
                {
                    $this->_errors[] = sprintf($this->l('%s is not valid'),$input['label']);
                }
                elseif($val!==''&& !Validate::isCleanHtml($val))
                    $this->_errors[] = sprintf($this->l('%s is not valid'),$input['label']);
            }
        }
    }
    public function getConfigInputs()
    {
        return array(
            array(
                'type' => 'text',
                'label' => $this->l('Title'),
                'lang' => true,
                'name' => 'ETS_COL_PAGE_TITLE',
                'default' => $this->l('Collections'),
                'default_lang' => 'Collections',
                'validate' => 'isCleanHtml'
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Description'),
                'lang' => true,
                'name' => 'ETS_COL_PAGE_DESCRIPTION',
                'validate' => 'isCleanHtml'
            ),
            array(
                'type' => 'switch',
                'name' => 'ETS_COL_FRIENDLY_URL',
                'label' => $this->l('Enable friendly URL for product collection'),
                'values' => array(
    				array(
    					'id' => 'active_on',
    					'value' => 1,
    					'label' => $this->l('Yes')
    				),
    				array(
    					'id' => 'active_off',
    					'value' => 0,
    					'label' => $this->l('No')
    				)
    			),
                'default' => 1,
                'validate' => 'isUnsignedInt',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Collection alias'),
                'desc' => $this->l('Your collection main page:').$this->displayText($this->getCollectionLink(),'a',null,null,$this->getCollectionLink(),true). $this->displayText('','br').$this->l('Copy this link and paste it to your top menu or somewhere in order to link the collection area with your website'),
                'lang' => true,
                'required' => true,
                'name' => 'ETS_COL_ALIAS',
                'default' => $this->l('collections'),
                'default_lang' => 'collections',
                'validate' => 'isLinkRewrite',
            ),
            array(
                'type' => 'switch',
                'name' => 'ETS_COL_URL_SUBFIX',
                'label' => $this->l('Use URL suffix'),
                'values' => array(
    				array(
    					'id' => 'active_on',
    					'value' => 1,
    					'label' => $this->l('Yes')
    				),
    				array(
    					'id' => 'active_off',
    					'value' => 0,
    					'label' => $this->l('No')
    				)
    			),
                'default' => 0,
                'validate' => 'isUnsignedInt',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Collection meta title'),
                'lang' => true,
                'name' => 'ETS_COL_META_TITLE',
                'required' => true,
                'default' => $this->l('Collections'),
                'default_lang' => 'Collections',
                'validate' => 'isCleanHtml'
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Collection meta description'),
                'lang' => true,
                'name' => 'ETS_COL_META_DESCRIPTION',
                'validate' => 'isCleanHtml'
            ),
            array(
                'type' => 'switch',
                'name' => 'ETS_COL_DISPLAY_LIST_HOME_PAGE',
                'label' => $this->l('Display collection list on home page'),
                'values' => array(
    				array(
    					'id' => 'active_on',
    					'value' => 1,
    					'label' => $this->l('Yes')
    				),
    				array(
    					'id' => 'active_off',
    					'value' => 0,
    					'label' => $this->l('No')
    				)
    			),
                'default' => 1,
                'validate' => 'isUnsignedInt',
            ),
            array(
                'type' => 'text',
                'name' => 'ETS_COL_TITLE_LIST_HOME_PAGE',
                'label' => $this->l('Collection list on home page title'),
                'lang' => true,
                'default' => $this->l('Collections'),
                'default_lang' => 'Collections',
                'form_group_class' => 'col_display_home_page',
                'validate' => 'isCleanHtml'
            ),
            array(
                'type' => 'radio',
                'name' => 'ETS_COL_MODE_LIST_HOME_PAGE',
                'label' => $this->l('Collection mode'),
                'values' => array(
                    array(
                        'label' => $this->l('Grid'),
                        'value' => 'grid',
                        'id' => 'ETS_COL_MODE_LIST_HOME_PAGE_grid',
                    ),
                    array(
                        'label' => $this->l('Carousel slide'),
                        'value' => 'slide',
                        'id' => 'ETS_COL_MODE_LIST_HOME_PAGE_slide',
                    )
                ),
                'default' => 'slide',
                'form_group_class' => 'col_display_home_page',
                'validate' => 'isCleanHtml'
            ),
            array(
                'type' => 'select',
                'name' => 'ETS_COL_NUMBER_COLLECTION_DESKTOP',
                'label' => $this->l('Number of displayed collections per row on desktop'),
                'options' => array(
                    'query' => array(
                        array(
                            'id' => 6,
                            'name' =>6
                        ),
                        array(
                            'id' => 5,
                            'name' =>5
                        ),
                        array(
                            'id' => 4,
                            'name' =>4
                        ),
                        array(
                            'id' => 3,
                            'name' =>3
                        ),
                        array(
                            'id' => 2,
                            'name' =>2
                        ),
                        array(
                            'id' => 1,
                            'name' =>1
                        ),
                    ),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'default' => 4,
                'form_group_class' => 'col_display_home_page',
                'validate' => 'isUnsignedInt',
            ),
            array(
                'type' => 'select',
                'name' => 'ETS_COL_NUMBER_COLLECTION_TABLET',
                'label' => $this->l('Number of displayed collections per row on tablet'),
                'options' => array(
                    'query' => array(
                        array(
                            'id' => 6,
                            'name' =>6
                        ),
                        array(
                            'id' => 5,
                            'name' =>5
                        ),
                        array(
                            'id' => 4,
                            'name' =>4
                        ),
                        array(
                            'id' => 3,
                            'name' =>3
                        ),
                        array(
                            'id' => 2,
                            'name' =>2
                        ),
                        array(
                            'id' => 1,
                            'name' =>1
                        ),
                    ),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'default' => 3,
                'form_group_class' => 'col_display_home_page',
                'validate' => 'isUnsignedInt',
            ),
            array(
                'type' => 'select',
                'name' => 'ETS_COL_NUMBER_COLLECTION_MOBILE',
                'label' => $this->l('Number of displayed collections per row on mobile'),
                'options' => array(
                    'query' => array(
                        array(
                            'id' => 6,
                            'name' =>6
                        ),
                        array(
                            'id' => 5,
                            'name' =>5
                        ),
                        array(
                            'id' => 4,
                            'name' =>4
                        ),
                        array(
                            'id' => 3,
                            'name' =>3
                        ),
                        array(
                            'id' => 2,
                            'name' =>2
                        ),
                        array(
                            'id' => 1,
                            'name' =>1
                        ),
                    ),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'default' => 1,
                'form_group_class' => 'col_display_home_page',
                'validate' => 'isUnsignedInt',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Number of collections to display'),
                'desc' => $this->l('Leave blank to display all collections'),
                'name' => 'ETS_COL_NUMBER_COL_HOME_PAGE',
                'default' => 12,
                'col'=>4,
                'validate' => 'isUnsignedInt',
                'form_group_class' => 'col_display_home_page',
            ),
            array(
                'type'=>'switch',
                'name' => 'ETS_COL_ENABLE_CACHE',
                'label' => $this->l('Enable cache'),
                'values' => array(
    				array(
    					'id' => 'active_on',
    					'value' => 1,
    					'label' => $this->l('Yes')
    				),
    				array(
    					'id' => 'active_off',
    					'value' => 0,
    					'label' => $this->l('No')
    				)
    			),
                'default' => 0,
                'validate' => 'isUnsignedInt',
            ),
            array(
                'type'=>'text',
                'name' =>'ETS_COL_CACHE_LIFETIME',
                'suffix'=> $this->l('Hour(s)'),
                'label' => $this->l('Cache lifetime'),
                'col'=>2,
                'default' => 24,
                'validate' => 'isUnsignedInt',
            ),
        );
    }
    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuration'),
                    'icon' => 'icon-cog'
                ),
                'input' => $this->getConfigInputs(),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->id = $this->id;
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $language->id;
        $helper->override_folder ='/';
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
            'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
            'link' => $this->context->link,
            'ps1780' => version_compare(_PS_VERSION_, '1.7.8.0', '>=') ? true : false,
        );
        $this->fields_form = array();
        return $helper->generateForm(array($fields_form));
    }
    public function getConfigFieldsValues()
    {
        $languages = Language::getLanguages(false);
        $fields = array();
        $inputs = $this->getConfigInputs();
        if($inputs)
        {
            foreach($inputs as $input)
            {
                if(!isset($input['lang']))
                {
                    $fields[$input['name']] = Tools::getValue($input['name'],Configuration::get($input['name']));
                }
                else
                {
                    foreach($languages as $language)
                    {
                        $fields[$input['name']][$language['id_lang']] = Tools::getValue($input['name'].'_'.$language['id_lang'],Configuration::get($input['name'],$language['id_lang']));
                    }
                }
            }
        }
        return $fields;
    }
    public function renderList($listData)
    { 
        if(isset($listData['fields_list']) && $listData['fields_list'])
        {
            foreach($listData['fields_list'] as $key => &$val)
            {
                if(isset($val['filter']) && $val['filter'] && ($val['type']=='int' || $val['type']=='date'))
                {
                    if(Tools::isSubmit('ets_col_submit_'.$listData['name']))
                    {
                        $value_max = trim(Tools::getValue($key.'_max'));
                        $value_min = trim(Tools::getValue($key.'_min'));
                        $val['active']['max'] =  Validate::isCleanHtml($value_max) ? $value_max :'';   
                        $val['active']['min'] =  Validate::isCleanHtml($value_min) ? $value_min :''; 
                    }
                    else
                    {
                        $val['active']['max']='';
                        $val['active']['min']='';
                    }  
                }  
                elseif(!Tools::isSubmit('del') && Tools::isSubmit('ets_col_submit_'.$listData['name']))               
                {
                    $value = trim(Tools::getValue($key));
                    $val['active'] = Validate::isCleanHtml($value) ? $value :'';
                }
                else
                    $val['active']='';
            }
        }    
        $this->smarty->assign($listData);
        return $this->display(__FILE__, 'list_helper.tpl');
    }
    public function getFilterParams($field_list,$table='')
    {
        $params = '';        
        if($field_list)
        {
            if(Tools::isSubmit('ets_col_submit_'.$table))
                $params .='&ets_col_submit_'.$table.='=1';
            foreach($field_list as $key => $val)
            {
                $value = Tools::getValue($key);
                $value_min = Tools::getValue($key.'_min');
                $value_max = Tools::getValue($key.'_max');
                if($value!='' && Validate::isCleanHtml($value))
                {
                    $params .= '&'.$key.'='.urlencode($value);
                }
                if($value_max!='' && Validate::isCleanHtml($value_max))
                {
                    $params .= '&'.$key.'_max='.urlencode($value_max);
                }
                if($value_min !='' && Validate::isCleanHtml($value_min))
                {
                    $params .= '&'.$key.'_min='.urlencode($value_min);
                } 
            }
            unset($val);
        }
        return $params;
    }
    public function validateFile($file_name,$file_size,&$errors,$file_types=array(),$max_file_size= false)
    {
        $file_name = str_replace(array(' ','(',')','!','@','#','+'),'_',$file_name);
        if($file_name)
        {
            if(!Validate::isFileName($file_name))
            {
                $errors[] = sprintf($this->l('The file name "%s" is invalid'),$file_name);
            }
            else
            {
                $type = Tools::strtolower(Tools::substr(strrchr($file_name, '.'), 1));
                if(!$file_types)
                    $file_types = array('jpg','png','gif','jpeg','webp');
                if(!in_array($type,$file_types))
                    $errors[] = sprintf($this->l('The file name "%s" is not in the correct format, accepted formats: %s'),$file_name,'.'.trim(implode(', .',$file_types),', .'));
                $max_file_size = $max_file_size ? : Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')*1024*1024;
                if($file_size > $max_file_size)
                    $errors[] = sprintf($this->l('The file name "%s" is too large. Limit: %s'),$file_name,Tools::ps_round($max_file_size/1048576,2).'Mb');
            }
        }
        
    }
    public function uploadFile($name,&$errors,$dirimg = '')
    {
        if(!$dirimg)
            $dirimg = _PS_IMG_DIR_.'col_collection/';
        if(!is_dir($dirimg))
        {
            @mkdir($dirimg,0777,true);
            @copy(dirname(__FILE__).'/index.php', $dirimg.'index.php');
        }
        if(isset($_FILES[$name]['tmp_name']) && isset($_FILES[$name]['name']) && $_FILES[$name]['name'])
        {
            $type = Tools::strtolower(Tools::substr(strrchr($_FILES[$name]['name'], '.'), 1));
            $file_name = str_replace(array(' ','(',')','!','@','#','+'),'_',$_FILES[$name]['name']);
            if($type=='webp')
                $file_name = str_replace('.webp','.jpg',$file_name);
            while(file_exists($dirimg.$file_name))
            {
                $file_name = Tools::strtolower(Tools::passwdGen(4,'NO_NUMERIC')).$file_name;
            }
			if (isset($_FILES[$name]) &&				
				!empty($_FILES[$name]['tmp_name']) &&
				in_array($type, array('jpg', 'gif', 'jpeg', 'png','webp'))
			)
			{
                $max_file_size = Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')*1024*1024;				
				if ($_FILES[$name]['size'] > $max_file_size)
					$errors[] = sprintf($this->l('Image is too large (%s Mb). Maximum size allowed: %s Mb'),Tools::ps_round((float)$_FILES[$name]['size']/1048576,2), Tools::ps_round(Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE'),2));
				elseif ( !move_uploaded_file($_FILES[$name]['tmp_name'], $dirimg.$file_name))
					$errors[] = $this->l('Cannot upload the file');
                if(!$errors)
                    return $file_name;		
			}  
        }
    }
    public function setMetas()
    {
        $meta = array();
        $module = Tools::getValue('module');
        $controller = Tools::getValue('controller');
        if($module== $this->name && $controller=='collection')
        {
            if(($id_collection=(int)Tools::getValue('id_collection')) && ($collection = new Ets_collection_class($id_collection,$this->context->language->id)) && Validate::isLoadedObject($collection))
            {
                $meta['meta_title'] = $collection->meta_title ? : $collection->name;
                $meta['description'] = $collection->meta_description ? strip_tags($collection->meta_description) : (Tools::strlen(strip_tags($collection->description)) <=256 ? strip_tags($collection->description) : Tools::substr(strip_tags($collection->description),0,Tools::strpos(strip_tags($collection->description)," ",255)));
            }
            else
            {
                $meta['meta_title'] = Configuration::get('ETS_COL_META_TITLE',$this->context->language->id) ? : $this->l('Collections');

                $meta['description'] = Configuration::get('ETS_COL_META_DESCRIPTION',$this->context->language->id) ? :'';
            }
            if($this->is17)
            {
                $body_classes = array(
                    'lang-'.$this->context->language->iso_code => true,
                    'lang-rtl' => (bool) $this->context->language->is_rtl,
                    'country-'.$this->context->country->iso_code => true,                              
                );
                $page = array(
                    'title' => '',
                    'canonical' => '',
                    'meta' => array(
                        'title' => isset($meta['meta_title'])? $meta['meta_title'] :'',
                        'description' => isset($meta['description']) ? $meta['description'] :'',
                        'keywords' => isset($meta['keywords']) ? $meta['keywords'] :'',
                        'robots' => 'index',
                    ),
                    'page_name' => '',
                    'body_classes' => $body_classes,
                    'admin_notifications' => array(),
                ); 
                $this->context->smarty->assign(array('page' => $page)); 
            }    
            else
            {
                $this->context->smarty->assign($meta);
            }   
        }        
    }
    public function getLangLinkFriendly($id_lang = null, Context $context = null, $id_shop = null)
	{
		if (!$context)
			$context = Context::getContext();

		if ((!Configuration::get('PS_REWRITING_SETTINGS') && in_array($id_shop, array($context->shop->id,  null))) || !Language::isMultiLanguageActivated($id_shop) || !(int)Configuration::get('PS_REWRITING_SETTINGS', null, null, $id_shop))
			return '';

		if (!$id_lang)
			$id_lang = $context->language->id;

		return Language::getIsoById($id_lang).'/';
	}
    public function getBaseLinkFriendly($id_shop = null, $ssl = null)
	{
		static $force_ssl = null;
		
		if ($ssl === null)
		{
			if ($force_ssl === null)
				$force_ssl = (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE'));
			$ssl = $force_ssl;
		}

		if (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') && $id_shop !== null)
			$shop = new Shop($id_shop);
		else
			$shop = Context::getContext()->shop;

		$base = ($ssl ? 'https://'.$shop->domain_ssl : 'http://'.$shop->domain);

		return $base.$shop->getBaseURI();
	}
    public function getBaseLink()
    {
        $url =(Configuration::get('PS_SSL_ENABLED_EVERYWHERE')?'https://':'http://').$this->context->shop->domain.$this->context->shop->getBaseURI();
        return trim($url,'/');
    }
    public function getCollectionLink($params = array())
    {
        $context = Context::getContext();      
        $id_lang =  $context->language->id;
        $subfix = Configuration::get('ETS_COL_URL_SUBFIX') ? '.html': '';
        $alias = Configuration::get('ETS_COL_ALIAS',$id_lang) ? : 'collections';
        $friendly = Configuration::get('PS_REWRITING_SETTINGS') && Configuration::get('ETS_COL_FRIENDLY_URL');        
        if($friendly && $alias)
        {    
            $url = $this->getBaseLinkFriendly(null, null).$this->getLangLinkFriendly($id_lang, null, null).$alias; 
            if(isset($params['id_collection']) && $params['id_collection'])
            {
                
                $collection = new Ets_collection_class($params['id_collection'],$id_lang);

                $url .= '/'.$collection->id.'-'.$collection->link_rewrite.$subfix;
                unset($params['id_collection']);
            }
            else
                $url .=$subfix;
            if($params)
            {
                $extra='';
                foreach($params as $key=> $param)
                    $extra .='&'.$key.'='.$param;
                $url .= '?'.ltrim($extra,'&');
            }
            return $url;       
        }
        else
            return $this->context->link->getModuleLink($this->name,'collection',$params);
    }
    public function getBreadCrumb()
    {
        $nodes = array();
        $nodes[] = array(
            'title' => $this->l('Home'),
            'url' => $this->context->link->getPageLink('index', true),
        );
        $id_collection = (int)Tools::getValue('id_collection');
        $controller = Tools::getValue('controller');
        if($controller=='collection')
        {
            $nodes[] = array(
                'title' => $this->l('Collections'),
                'url' => $this->getCollectionLink(),
                'last' => $id_collection ? false:true,
            );
            if($id_collection)
            {
                $collection = new Ets_collection_class($id_collection,$this->context->language->id);
                $nodes[] = array(
                    'title' => $collection->name,
                    'url' => $this->getCollectionLink(array('id_collection'=>$id_collection)),
                    'last' => true,
                );
            }
        }
        if($this->is17)
            return array('links' => $nodes,'count' => count($nodes));
        return $this->displayBreadcrumb($nodes);
    }
    public function displayBreadcrumb($nodes)
    {
        $this->smarty->assign(array('nodes' => $nodes));
        return  $this->display(__FILE__, 'nodes.tpl');
    }
    public static function productsForTemplate($products, Context $context = null)
    {
        if (!$products || !is_array($products))
            return array();
        if (!$context)
            $context = Context::getContext();
        $assembler = new ProductAssembler($context);
        $presenterFactory = new ProductPresenterFactory($context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new PrestaShop\PrestaShop\Core\Product\ProductListingPresenter(
            new PrestaShop\PrestaShop\Adapter\Image\ImageRetriever(
                $context->link
            ),
            $context->link,
            new PrestaShop\PrestaShop\Adapter\Product\PriceFormatter(),
            new PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever(),
            $context->getTranslator()
        );

        $products_for_template = array();

        foreach ($products as $rawProduct) {
            $product = $assembler->assembleProduct($rawProduct);
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $product,
                $context->language
            );
        }
        return $products_for_template;
    }
    public function deleteDir($dir)
    {
        $dir = rtrim($dir,'/');
        $files = glob($dir.'/*'); 
        foreach($files as $file){ 
            if(is_dir($file))
                $this->deleteDir($file);
            elseif(is_file($file))
                @unlink($file); 
        }
        @rmdir($dir);
        return true;
    }
    public static function validateArray($array,$validate='isCleanHtml')
    {
        if(!is_array($array))
            return false;
        if(method_exists('Validate',$validate))
        {
            if($array && is_array($array))
            {
                $ok= true;
                foreach($array as $val)
                {
                    if(!is_array($val))
                    {
                        if($val && !Validate::$validate($val))
                        {
                            $ok= false;
                            break;
                        }
                    }
                    else
                        $ok = self::validateArray($val,$validate);
                }
                return $ok;
            }
        }
        return true;
    }
    public function displayText($content=null,$tag,$class=null,$id=null,$href=null,$blank=false,$src = null,$name = null,$value = null,$type = null,$data_id_product = null,$rel = null,$attr_datas=null)
    {
        $this->smarty->assign(
            array(
                'content' =>$content,
                'tag' => $tag,
                'text_class'=> $class,
                'id' => $id,
                'href' => $href,
                'blank' => $blank,
                'src' => $src,
                'name' => $name,
                'value' => $value,
                'type' => $type,
                'data_id_product' => $data_id_product,
                'attr_datas' => $attr_datas,
                'rel' => $rel,
            )
        );
        return $this->display(__FILE__,'html.tpl');
    }
    public function getCacheSubfix($params)
    {
        $str = '';
        if($params)
        {
            foreach($params as $key=>$value)
            {
                if(!is_array($value) && !is_object($value))
                    $str .='&'.$key.'='.$value;
            }
        }
        $str .= '&id_lang='.$this->context->language->id;
        $str .= '&ets_currency='.($this->context->cookie->id_currency ? $this->context->cookie->id_currency : Configuration::get('PS_CURRENCY_DEFAULT'));
        $id_customer = (isset($this->context->customer->id)) ? (int)($this->context->customer->id) : 0;
        $id_group = null;
        if ($id_customer) {
            $id_group = Customer::getDefaultGroupId((int)$id_customer);
        }
        if (!$id_group) {
            $id_group = (int)Group::getCurrent()->id;
        } 
        $str .= '&ets_group='.(int)$id_group; 
        $id_country =isset($this->context->cookie->iso_code_country) && $this->context->cookie->iso_code_country && Validate::isLanguageIsoCode($this->context->cookie->iso_code_country) ?
                    (int) Country::getByIso(Tools::strtoupper($this->context->cookie->iso_code_country)) : (int) Tools::getCountry();
        $str .='&ets_country='.($id_country ? $id_country : (int)$this->context->country->id);
        return md5($str);
    }
    public function createCache($html,$params)
    {
        if(!Configuration::get('ETS_COL_ENABLE_CACHE'))
            return false;
        if(!is_dir(_ETS_COLLECTION_CACHE_DIR_))
        {
            @mkdir(_ETS_COLLECTION_CACHE_DIR_,0777,true);
            if ( @file_exists(dirname(__file__).'/index.php')){
                @copy(dirname(__file__).'/index.php', _ETS_COLLECTION_CACHE_DIR_.'index.php');
            }
        }
        file_put_contents(_ETS_COLLECTION_CACHE_DIR_.md5($this->getCacheSubfix($params)).'.'.time(),$html);    
    }
    public function clearCache()
    {
        if(is_dir(_ETS_COLLECTION_CACHE_DIR_) && ($files = glob(_ETS_COLLECTION_CACHE_DIR_.'*')))
        {
            foreach ($files as $filename) {
                if($filename!=_ETS_COLLECTION_CACHE_DIR_.'index.php')
                    @unlink($filename);
                }
        }
        if((int)Configuration::get('ETS_SPEED_ENABLE_PAGE_CACHE') && Module::isInstalled('ets_superspeed') && Module::isEnabled('ets_superspeed') && class_exists('Ets_ss_class_cache'))
        {
            $cacheObjSuperSpeed = new Ets_ss_class_cache();
            if(method_exists($cacheObjSuperSpeed,'deleteCache'))
                $cacheObjSuperSpeed->deleteCache('index');
        }
        if((int)Configuration::get('ETS_SPEED_ENABLE_PAGE_CACHE') && Module::isInstalled('ets_pagecache') && Module::isEnabled('ets_pagecache') && class_exists('Ets_pagecache_class_cache'))
        {
            $cacheObjPageCache = new Ets_pagecache_class_cache();
            if(method_exists($cacheObjPageCache,'deleteCache'))
                $cacheObjPageCache->deleteCache('index');
        }
        return true;
    }
    public function getCache($params){
	    if(!Configuration::get('ETS_COL_ENABLE_CACHE'))
            return false;
        if ( !$params )
            return false;
        $url_file = _ETS_COLLECTION_CACHE_DIR_.$this->getCacheSubfix($params);
        $cacheLifeTime = (float)Configuration::get('ETS_COL_CACHE_LIFETIME');
        if($files = @glob($url_file.'.*'))
            foreach ($files as $file) {
                if(file_exists($file)){
                    $file_extends = Tools::substr(strrchr($file, '.'), 1);
                    if ( is_numeric( $file_extends )){
                        if ( (time() - (int)$file_extends <= $cacheLifeTime*60*60) || !$cacheLifeTime){
                            return Tools::file_get_contents($file);
                        }else{
                            unlink($file);
                        }
                    }
                }
        }
        return false;
    }
}