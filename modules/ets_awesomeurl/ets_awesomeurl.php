<?php
/**
 * 2007-2022 ETS-Soft
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
 * @copyright  2007-2022 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once(dirname(__FILE__) . '/classes/EtsAwuDefine.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuRedirect.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuUpdating.php');
require_once(dirname(__FILE__) . '/classes/Ets_Awu_Sitemap.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuCategory.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuProduct.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuSetting.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuManufacturer.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuSupplier.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuCms.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuCmsCategory.php');
require_once(dirname(__FILE__) . '/classes/EtsAwuMeta.php');

class Ets_awesomeurl extends Module
{
    public $is17;
    public $is176;
    public $is175;
    public $is178;
    public $is15 = false;
    public function __construct()
    {
        $this->name = 'ets_awesomeurl';
        $this->tab = 'front_office_features';
        $this->version = '1.1.5';
        $this->author = 'ETS-Soft';
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Awesome URL');
        $this->description = $this->l('Create SEO-friendly URLs for better SEO & customer experience');
        $this->ps_versions_compliancy = array('min' => '1.6.0.0', 'max' => _PS_VERSION_);
        $this->module_key = 'e0a0c4eaa28f502117106a5f4a465f51';
        $this->is17 = version_compare('1.7.0.0', _PS_VERSION_, '<=');
        $this->is176 = version_compare(_PS_VERSION_, '1.7.6.0', '>=');
        $this->is175 = version_compare(_PS_VERSION_, '1.7.5.0', '>=');
        $this->is178 = version_compare(_PS_VERSION_, '1.7.8.0', '>=');
        $this->is16 = false;
        if (version_compare(_PS_VERSION_, '1.7', '<'))
            $this->is16 = true;
    }

    public function install()
    {
        if(self::isInstalled('ets_seo')){
            throw new PrestaShopException($this->l('The module ets_seo has been installed'));
        }
        else if(self::isInstalled('etsdynamicsitemap')){
            throw new PrestaShopException($this->l("The module etsdynamicsitemap has been installed"));
        }
        $etsDef = EtsAwuDefine::getInstance();
        return parent::install()
            && $this->registerHook('displayBackOfficeHeader')
            && $this->registerHook('actionObjectUpdateBefore')
            && $this->registerHook('actionDispatcherBefore')
            && $this->registerHook('displayHeader')
            && $this->registerHook('actionObjectUpdateAfter')
            && $this->registerHook('actionAdminMetaControllerUpdate_optionsBefore')
            && $this->registerHook('actionAdminMetaControllerUpdate_optionsAfter')
            && $this->registerHook('actionAdminEtsAwuUrlRedirectsFormModifier')
            && $this->registerHook('actionObjectAddAfter')
            && $this->registerHook('actionProductSave')
            && $this->registerHook('displayAdminProductsSeoStepBottom')
            && $this->registerHook('actionMetaFormBuilderModifier')
            && $this->registerHook('actionBeforeCreateMetaFormHandler')
            && $this->registerHook('actionBeforeUpdateMetaFormHandler')
            && $this->registerHook('actionCmsPageCategoryFormBuilderModifier')
            && $this->registerHook('actionBeforeCreateCmsPageCategoryFormHandler')
            && $this->registerHook('actionBeforeUpdateCmsPageCategoryFormHandler')
            && $this->registerHook('actionCmsPageFormBuilderModifier')
            && $this->registerHook('actionBeforeCreateCmsPageFormHandler')
            && $this->registerHook('actionBeforeUpdateCmsPageFormHandler')
            && $this->registerHook('actionRootCategoryFormBuilderModifier')
            && $this->registerHook('actionBeforeCreateRootCategoryFormHandler')
            && $this->registerHook('actionBeforeUpdateRootCategoryFormHandler')
            && $this->registerHook('actionCategoryFormBuilderModifier')
            && $this->registerHook('actionBeforeCreateCategoryFormHandler')
            && $this->registerHook('actionBeforeUpdateCategoryFormHandler')
            && $this->registerHook('actionObjectAddBefore')
            && ($this->is178 ? $this->registerHook('actionAdminShopParametersMetaControllerPostProcessUrlSchemaBefore') : true)
            && $this->__installTabs()
            && $etsDef->installDb()
            && $this->setDefaultConfig()
            && $this->setRootSeoUrlConfig()
            && $this->_installOverried()
            && $this->setSitemap() ;
    }
    public function _installOverried()
    {

        $this->copy_directory(dirname(__FILE__) . '/views/templates/admin/_configure/templates', _PS_OVERRIDE_DIR_ . 'controllers/admin/templates');
        return true;
    }

    /**
     * _unInstallOverried
     *
     * @return bool
     */
    public function _uninstallOverried()
    {
        $this->delete_directory(_PS_OVERRIDE_DIR_ . 'controllers/admin/templates');
        return true;
    }

    /**
     * copy_directory
     *
     * @param  string $src
     * @param  string $dst
     *
     * @return void
     */
    public function copy_directory($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->copy_directory($src . '/' . $file, $dst . '/' . $file);
                } else {
                    if (file_exists($dst . '/' . $file) && $file != 'index.php' && ($content = Tools::file_get_contents($dst . '/' . $file)) && Tools::strpos($content, 'overried_by_hinh_ets') === false)
                        copy($dst . '/' . $file, $dst . '/backup_' . $file);
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     * delete_directory
     *
     * @param  string $directory
     *
     * @return void
     */
    public function delete_directory($directory)
    {
        $dir = opendir($directory);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($directory . '/' . $file)) {
                    $this->delete_directory($directory . '/' . $file);
                } else {
                    if (file_exists($directory . '/' . $file) && $file != 'index.php' && ($content = Tools::file_get_contents($directory . '/' . $file)) && Tools::strpos($content, 'overried_by_hinh_ets') !== false) {
                        @unlink($directory . '/' . $file);
                        if (file_exists($directory . '/backup_' . $file))
                            copy($directory . '/backup_' . $file, $directory . '/' . $file);
                    }

                }
            }
        }
        closedir($dir);
    }
    public function uninstall()
    {
        $etsDef = EtsAwuDefine::getInstance();
        return parent::uninstall()
            && $this->__uninstallTabs()
            && $etsDef->uninstallDb()
            && $this->_uninstallOverried()
            && $this->restoreSeoUrlConfig()
            && $this->removeSitemap()
            && $this->deleteConfigKey();
    }
    public function disable($force_all = false)
    {
        return parent::disable($force_all)
            && $this->restoreSeoUrlConfig()
            && $this->removeSitemap();
    }
    public function enable($force_all = false)
    {

        return parent::enable($force_all)
            && $this->setSitemap();
    }
    public function __installTabs()
    {
        $tabMetaId = Tab::getIdFromClassName('AdminParentMeta');
        $isOldVersion = false;
        if(!$tabMetaId){
            $isOldVersion = true;
            $tabMetaId = Tab::getIdFromClassName('AdminParentPreferences');
        }
        if(!$tabMetaId){
            return true;
        }
        
        $etsDef = EtsAwuDefine::getInstance();
        $tabs = $etsDef->adminControllers();
        
        $languages = Language::getLanguages(true);
        if($isOldVersion && ($metaTabId = Tab::getIdFromClassName('AdminMeta'))){
            $metaTab = new Tab($metaTabId);
            $position = (int)$metaTab->position;
        }
        foreach ($tabs as $key=>$item){
            if(!Tab::getIdFromClassName($key))
            {
                $tab = new Tab();
                $tab->module = $this->name;
                $tab->class_name = $key;
                $tab->id_parent = $tabMetaId;
                $tab->icon = $item['icon'];
                if(isset($position)){
                    $tab->position = (int)$position+1;
                }
                foreach ($languages as $lang){
                    $tab->name[$lang['id_lang']] = ($textTrans = EtsAwuDefine::getTextLang($item['title_text'], $lang, 'etsawudefine')) ? $textTrans : $item['title_text'];
                }
                $tab->save();
            }
            
        }
        if(isset($position))
            Db::getInstance()->execute("UPDATE `"._DB_PREFIX_."tab` SET `position`=".((int)$position+1)." 
                                            WHERE `class_name`='AdminEtsAwuUrlRedirects' OR `class_name`='AdminEtsAwuDuplicateUrls' OR `class_name`='AdminEtsAwuSearchAppearanceRSS' OR `class_name`='AdminEtsAwuSearchAppearanceSitemap'");
        return true;
    }

    public function __uninstallTabs()
    {
        $etsDef = EtsAwuDefine::getInstance();
        $tabs = $etsDef->adminControllers();
        foreach ($tabs as $key=> $item){
            if($item){
                $tabId = Tab::getIdFromClassName($key);
                if((int)$tabId){
                    $tab = new Tab((int)$tabId);
                    $tab->delete();
                }
            }
        }
        return true;
    }
    public function setRootSeoUrlConfig()
    {
        $etsDef = EtsAwuDefine::getInstance();
        $urlSchemaConfigs = $etsDef->seo_url_schema_configs();
        foreach ($urlSchemaConfigs as $k => $config) {
            Configuration::updateGlobalValue($config['root_name'], Configuration::get('PS_ROUTE_' . $k));
        }
        return true;
    }

    public function setDefaultConfig()
    {
        $etsDef = EtsAwuDefine::getInstance();
        $groups = $etsDef->getFieldConfig();
        $languages = Language::getLanguages(false);
        foreach ($groups as $configs) {
            foreach ($configs as $key => $config) {
                if(!Configuration::hasKey($key))
                {
                    if (isset($config['default']) && $config['default'] !== '') {
                        Configuration::updateGlobalValue($key, $config['default']);
                    } else {
                        if (isset($config['type']) && ($config['type'] == 'textLang' || $config['type'] == 'textareaLang' || $config['type'] == 'selectLang')) {
                            $value = array();
                            foreach ($languages as $lang) {
                                $value[$lang['id_lang']] = '';
                            }
                            Configuration::updateGlobalValue($key, $value);
                        } else {
                            Configuration::updateGlobalValue($key, '');
                        }
                    }
                }
                
            }
        }
        return true;
    }

    public function deleteConfigKey()
    {
        $configs = Db::getInstance()->executeS("SELECT `name` FROM `"._DB_PREFIX_."configuration` WHERE `name` LIKE 'ETS_AWU_%'");
        if($configs){
            foreach ($configs as $config){
                Configuration::deleteByName($config['name']);
            }
        }
        return true;
    }

    public function restoreSeoUrlConfig()
    {
        Configuration::updateValue('ETS_AWU_ENABLE_REMOVE_ID_IN_URL', 0);
        Configuration::updateValue('ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS', 0);
        Configuration::updateValue('ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL', 0);
        Configuration::updateValue('ETS_AWU_UPDATE_DUPLICATE_REWRITE', 0);
        Configuration::updateValue('ETS_AWU_SET_REMOVE_ID', 0);
        $etsDef = EtsAwuDefine::getInstance();
        foreach ($etsDef->seo_url_schema_configs() as $rule => $name) {
            foreach (Shop::getShops() as $shop) {
                if ($configRule = Configuration::get($name['root_name'], null, null, $shop['id_shop'])) {
                    if ($rule !== 'module' && strpos($configRule, '{id}') !== false)
                        Configuration::updateValue('PS_ROUTE_' . $rule, $configRule, false, null, $shop['id_shop']);
                    else
                        Configuration::updateValue('PS_ROUTE_' . $rule, $name['default'], false, null, $shop['id_shop']);
                } else {
                    Configuration::updateValue('PS_ROUTE_' . $rule, $name['default'], false, null, $shop['id_shop']);
                }
            }

        }
        return true;
    }

    public function processAfterSaveConfig()
    {
        Tools::clearCache();
        /*Update product has duplicate link_rewrite*/
        $ETS_AWU_ENABLE_REMOVE_ID_IN_URL = (int)Tools::getValue('ETS_AWU_ENABLE_REMOVE_ID_IN_URL');
        if ((int)$ETS_AWU_ENABLE_REMOVE_ID_IN_URL) {
            if (!(int)Configuration::get('ETS_AWU_UPDATE_DUPLICATE_REWRITE')) {
                $seoUpdating = new EtsAwuUpdating();
                $seoUpdating->updateDuplicateProduct();
                $seoUpdating->updateDuplicateCategory();
                $seoUpdating->updateDuplicateCMS();
                $seoUpdating->updateDuplicateCMSCategory();
                $seoUpdating->updateDuplicateMeta();
                Configuration::updateValue('ETS_AWU_UPDATE_DUPLICATE_REWRITE', 1);
            }
        }

        /*Delete cache in others module to accept new configurations*/
        if ((int)Configuration::get('ETS_SPEED_ENABLE_PAGE_CACHE') && Module::isInstalled('ets_superspeed') && Module::isEnabled('ets_superspeed') && class_exists('Ets_ss_class_cache')) {
            $cacheObjSuperSpeed = new Ets_ss_class_cache();
            if (method_exists($cacheObjSuperSpeed, 'deleteCache'))
                $cacheObjSuperSpeed->deleteCache('index');
        }
        if ((int)Configuration::get('ETS_SPEED_ENABLE_PAGE_CACHE') && Module::isInstalled('ets_pagecache') && Module::isEnabled('ets_pagecache') && class_exists('Ets_pagecache_class_cache')) {
            $cacheObjPageCache = new Ets_ss_class_cache();
            if (method_exists($cacheObjPageCache, 'deleteCache'))
                $cacheObjPageCache->deleteCache('index');
        }
    }

    public function hookDisplayBackOfficeHeader()
    {
        //die(var_dump(Configuration::get('PS_ROUTE_category_rule')));
        $controller = Tools::getValue('controller');
        $etsDef = EtsAwuDefine::getInstance();
        if($controller == 'AdminMeta')
        {
            $linkRewriteRules = $etsDef->urlRules();
            $this->smarty->assign(array(
                'ETS_AWU_ENABLE_REMOVE_ID_IN_URL' => (int)Configuration::get('ETS_AWU_ENABLE_REMOVE_ID_IN_URL'),
                'ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL' => (int)Configuration::get('ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL'),
                'ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS' => (int)Configuration::get('ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS'),
                'ETS_AWU_ENABLE_REDIRECT_NOTFOUND' => (int)Configuration::get('ETS_AWU_ENABLE_REDIRECT_NOTFOUND'),
                'ETS_AWU_REDIRECT_STATUS_CODE' => Configuration::get('ETS_AWU_REDIRECT_STATUS_CODE'),
                'linkRewriteRules' => $linkRewriteRules,
            ));
            if($this->getRequestContainer())
            {
                $this->addTwigVar('etsAwuRemoveIdField', $this->display(__FILE__, 'remove_id_field.tpl'));
                $this->addTwigVar('etsAwuRedirectUrl', $this->display(__FILE__, 'redirect_url_field.tpl'));
            }
        }
        if($this->getRequestContainer()) {
            $this->addTwigVar('ETS_AWU_IS_178', $this->is178);
        }
        $languages = Language::getLanguages(false);
        $ets_languages = array();
        foreach ($languages as $lang) {
            $ets_languages[$lang['iso_code']] = $lang['id_lang'];
        }
        $this->context->controller->addCSS($this->_path.'views/css/admin.css');
        $this->smarty->assign(array(
            'ets_awu_defined' => array(
                    'is176' => (int)$this->is176,
                    'is175' => (int)$this->is175,
                    'isSf' => $this->getRequestContainer(),
                    'seo_analysis_rules' => '',
                    'readability_rules' =>'',
                    'transition_words' => '',
                    'id_current_page' => '',
                    'meta_tamplate_configured' => '',
                    'placeholder_meta' => ''
            ),
            'is16' => !$this->is17,
            'linkAdminJs' => $this->_path.'views/js/admin.js',
            'link_analysis_js' => $this->_path . 'views/js/analysis.js',
            'link_select2_js' => $this->_path . 'views/js/select2.min.js',
            'isSf' => $this->getRequestContainer() ? 1 : 0,
            'current_lang_selected' => $controller == 'AdminProducts' ? $languages[0]['id_lang'] : Configuration::get('PS_LANG_DEFAULT'),
            'controller' => $controller,
            'ets_languages' => $ets_languages,
        ));
        if ($controller == 'AdminCmsContent') {
            if ($this->isCmsCategoryPage()) {
                $this->seo_cms_category_html();
            } else {
                $this->seo_cms_html();
            }

        }
        if ($controller == 'AdminMeta') {
            $this->seo_meta_html();
        } elseif ($controller == 'AdminCategories') {
            $this->seo_category_html();
        } elseif ($controller == 'AdminManufacturers') {
            $this->seo_manufacturer_html();
        } elseif ($controller == 'AdminSuppliers') {
            $this->seo_supplier_html();
        }
        if ($errorLinkRewrite = $this->context->cookie->__get('ets_awu_error_link_rewrite')) {
            $this->context->controller->errors = array($errorLinkRewrite);
            $this->context->cookie->__unset('ets_awu_error_link_rewrite');
        }
        return $this->display(__FILE__, 'admin_head.tpl');
    }
    public function isCmsCategoryPage()
    {
        $request = $this->getRequestContainer();
        if ($request) {
            if ($request->get('_route') == 'admin_cms_pages_category_edit' || $request->get('_route') == 'admin_cms_pages_category_create') {
                return true;
            }
        } else {
            if (Tools::getIsset('addcms_category') || Tools::getIsset('updatecms_category') || Tools::isSubmit('submitAddcms_category')) {
                return true;
            }
        }
        return false;

    }
    public function hookActionObjectUpdateBefore($params)
    {
        if (!defined('_PS_ADMIN_DIR_')) {
            return;
        }
        if(!Tools::getIsset('PS_ROUTE_category_rule') && !$this->is178)
            $this->updateConfigSeoNoid();
        if(!defined('_PS_ADMIN_DIR_'))
        {
            return;
        }
        if ($this->getRequestContainer() ) {
            if (isset($params['object']) && $params['object'] instanceof Product && preg_match('/sell\/catalog\/products/', $_SERVER['REQUEST_URI'])) {
                $error = null;
                $seoAdvanced = ($seoAdvanced = Tools::getValue('ets_awu_advanced')) && is_array($seoAdvanced) ? $seoAdvanced : array();
                if (isset($seoAdvanced['canonical_url']) && !$error) {
                    foreach ($seoAdvanced['canonical_url'] as $id_lang => $url) {
                        if ($url && !Validate::isAbsoluteUrl($url)) {
                            $error = sprintf($this->l('[%s] The Canonical url must start with http:// or https:// '),Language::getIsoById($id_lang));
                            break;
                        }
                    }
                }
                if ($error) {
                    throw new PrestaShopException($error);
                }
            }
        } else {
            $this->validateLinkRewrite($params);
        }
    }

    public function hookActionAdminMetaControllerUpdate_optionsBefore()
    {
        if(Tools::getIsset('PS_ROUTE_category_rule') && !$this->is178)
            $this->updateConfigSeoNoid();
    }
    public function hookActionAdminMetaControllerUpdate_optionsAfter()
    {
        if (Tools::getIsset('PS_ROUTE_category_rule') && Tools::getIsset('ETS_AWU_ENABLE_REMOVE_ID_IN_URL')){
            $etsDef = EtsAwuDefine::getInstance();
            $urlSchemaConfigs = $etsDef->seo_url_schema_configs();
            foreach ($urlSchemaConfigs as $k => $config){
                if($config){
                    $val = Tools::getValue('PS_ROUTE_' . $k);
                    if(Validate::isCleanHtml($val))
                        Configuration::updateValue('PS_ROUTE_' . $k, $val);
                }
            }
        }
    }

    public function hookActionDispatcherBefore()
    {
        if (defined('_PS_ADMIN_DIR_')) {
            return;
        }

        //Redirect
        if (!(int)Configuration::get('ETS_AWU_ENABLE_URL_REDIRECT')) {
            return;
        }
        EtsAwuRedirect::doRedirect($this->context);
    }

    public function hookActionAdminEtsAwuUrlRedirectsFormModifier($params)
    {
        if (isset($this->context->cookie->ets_awu_redirect_values)) {
            $params['fields_value'] = array_merge($params['fields_value'], Tools::jsonDecode($this->context->cookie->__get('ets_awu_redirect_values'), true));
            $this->context->cookie->__unset('ets_awu_redirect_values');
        }

    }
    public function hookDisplayHeader()
    {
        $this->context->controller->addCss(array(
                $this->_path . 'views/css/front.css',
        ), 'all');
        $this->getSeoMetaData();
        if(!$this->is17)
        {
            return $this->display(__FILE__,'head.tpl');
        }
    }
    
    public function hookActionObjectUpdateAfter($params)
    {
        $seoSetting = EtsAwuSetting ::getInstance();
        $seoSetting->updateSeoCms($params);
        $seoSetting->updateSeoMeta($params);
        $seoSetting->updateSeoCategory($params);
        $seoSetting->updateSeoCmsCategory($params);
        $seoSetting->updateSeoManufacturer($params);
        $seoSetting->updateSeoSupplier($params);
        $ETS_AWU_ENABLE_REMOVE_ID_IN_URL = (int)Tools::getValue('ETS_AWU_ENABLE_REMOVE_ID_IN_URL');
        if ((int)$ETS_AWU_ENABLE_REMOVE_ID_IN_URL) {
            $this->processAfterSaveConfig();
        }
    }
    /**
     * hookActionObjectAddAfter
     *
     * @param  array $params
     *
     * @return void
     */
    public function hookActionObjectAddAfter($params)
    {
        $seoSetting = EtsAwuSetting::getInstance();
        $seoSetting->updateSeoCms($params);
        $seoSetting->updateSeoMeta($params);
        $seoSetting->updateSeoCategory($params);
        $seoSetting->updateSeoCmsCategory($params);
        $seoSetting->updateSeoManufacturer($params);
        $seoSetting->updateSeoSupplier($params);
    }
    public function updateConfigSeoNoid()
    {
        if (Tools::getIsset('ETS_AWU_ENABLE_REMOVE_ID_IN_URL')) {
            $ETS_AWU_ENABLE_REMOVE_ID_IN_URL = (int)Tools::getValue('ETS_AWU_ENABLE_REMOVE_ID_IN_URL');
            $params = null;
            if ($this->getRequestContainer()) {
                if ($metaData = Tools::getValue('meta_settings_form'))
                    $params = $metaData;
                elseif($metaData = Tools::getValue('meta_settings_url_schema_form')){
                    $params = array();
                    $params['url_schema'] = $metaData;
                }
            }

            $etsDef = EtsAwuDefine::getInstance();
            $urlSchemaConfigs = $etsDef->seo_url_schema_configs();
            /* UPDATE schema configs */

            if (!(int)Configuration::get('ETS_AWU_ENABLE_REMOVE_ID_IN_URL') && (int)$ETS_AWU_ENABLE_REMOVE_ID_IN_URL) {
                if (!(int)Configuration::get('ETS_AWU_SET_REMOVE_ID')) {
                    Configuration::updateValue('ETS_AWU_SET_REMOVE_ID', 1);
                }
                foreach ($urlSchemaConfigs as $k => $config) {
                    if ($params && isset($params['url_schema'][$k])) {
                        $dataConfig = $params['url_schema'][$k];
                    } else {
                        $dataConfig = Tools::getValue('PS_ROUTE_' . $k);
                    }
                    if ($dataConfig && Validate::isCleanHtml($dataConfig)) {
                        $prevConfig = Configuration::get('PS_ROUTE_' . $k);
                        if (!$prevConfig && isset($config['default']) && $config['default']){
                            $prevConfig = $config['default'];
                        }
                        Configuration::updateValue($config['no_id'], $dataConfig);
                        Configuration::updateValue($config['name'], $prevConfig);
                        $oldConfig = Configuration::get($config['old_name']);
                        $rootConfig = Configuration::get($config['root_name']);
                        if (!$oldConfig || ($oldConfig && $k != 'module' && !preg_match('/\{id\}/', $oldConfig))) {
                            Configuration::updateValue($config['old_name'], $prevConfig);
                        }
                        if (!$rootConfig || ($rootConfig && $k != 'module' && !preg_match('/\{id\}/', $rootConfig))) {
                            Configuration::updateValue($config['root_name'], $prevConfig);
                        }
                    }

                }
            }
            
            $ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL = (int)Tools::getValue('ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL');
            $ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS = (int)Tools::getValue('ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS');
            $ETS_AWU_ENABLE_REDIRECT_NOTFOUND = (int)Tools::getValue('ETS_AWU_ENABLE_REDIRECT_NOTFOUND');
            Configuration::updateValue('ETS_AWU_ENABLE_REMOVE_ID_IN_URL', (int)$ETS_AWU_ENABLE_REMOVE_ID_IN_URL);
            Configuration::updateValue('ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL', (int)$ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL);
            Configuration::updateValue('ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS', (int)$ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS);
            Configuration::updateValue('ETS_AWU_ENABLE_REDIRECT_NOTFOUND', (int)$ETS_AWU_ENABLE_REDIRECT_NOTFOUND);
            $ETS_AWU_REDIRECT_STATUS_CODE = (int)Tools::getValue('ETS_AWU_REDIRECT_STATUS_CODE');
            if ($ETS_AWU_REDIRECT_STATUS_CODE) {
                Configuration::updateValue('ETS_AWU_REDIRECT_STATUS_CODE', (int)$ETS_AWU_REDIRECT_STATUS_CODE);
            }
        }

    }

    public function getContent()
    {
        try {
            $urlRedirect = $this->context->link->getAdminLink('AdminMeta', true, array('route'=> 'admin_metas_index'));
        }
        catch (Exception $ex){
            if($ex){
                //
            }
            $urlRedirect = $this->context->link->getAdminLink('AdminMeta', true);
        }
        return Tools::redirectAdmin($urlRedirect);
    }

    public function hookActionAdminShopParametersMetaControllerPostProcessUrlSchemaBefore($params)
    {
        if ($this->is178){
            $this->updateConfigSeoNoid();
        }
    }

    public function getLinkDuplicate($type, $params)
    {
        $duplicate_link = '';
        $duplicate_title = '';
        if ($type == 'product') {
            $sfP = array('route' => 'admin_product_form', 'id' => $params['id']);
            $p = array('id_product' => $params['id'], 'updateproduct' => true);
            $duplicate_link = $this->getPageLink('AdminProducts', $sfP, $p);
            $duplicate_title = $params['title'];
        }
        elseif ($type == 'category') {
            $sfP = array('route' => 'admin_categories_edit', 'categoryId' => $params['id']);
            $p = array('id_category' => $params['id'], 'updatecategory' => true);
            $duplicate_link = $this->getPageLink('AdminCategories', $sfP, $p);
            $duplicate_title = $params['title'];
        } elseif ($type == 'cms') {
            $sfP = array('route' => 'admin_cms_pages_edit', 'cmsPageId' => $params['id']);
            $p = array('id_cms' => $params['id'], 'updatecms' => true);
            $duplicate_link = $this->getPageLink('AdminCmsContent', $sfP, $p);
            $duplicate_title = $params['title'];
        } elseif ($type == 'cms_category') {
            $sfP = array('route' => 'admin_cms_pages_category_edit', 'cmsCategoryId' => $params['id']);
            $p = array('id_cms_category' => $params['id'], 'updatecms_category' => true);
            $duplicate_link = $this->getPageLink('AdminCmsContent', $sfP, $p);
            $duplicate_title = $params['title'];
        } elseif ($type == 'meta') {
            $sfP = array('route' => 'admin_metas_edit', 'metaId' => $params['id']);
            $p = array('id_meta' => $params['id'], 'updatemeta' => true);
            $duplicate_link = $this->getPageLink('AdminMeta', $sfP, $p);
            $duplicate_title = $params['title'];
        }
        if(!$this->is17 && isset($p)){
            $duplicate_link .= '&'.http_build_query($p);
        }
        $this->smarty->assign(array(
            'duplicate_link' => $duplicate_link,
            'duplicate_title' => $duplicate_title,
        ));
        return $this->display(__FILE__, 'duplicate_link.tpl');
    }

    public function getPageLink($controller, $sfParams, $params)
    {
        if($this->is17){
            try{
                return $this->context->link->getAdminLink($controller, true, $sfParams, $params);
            }
            catch(Exception $ex){
                if($ex){
                    //
                }
                return $this->context->link->getAdminLink($controller, true, array(), $params);
            }
        }
        else{
            return $this->context->link->getAdminLink($controller).($params ? '&'.http_build_query($params):'');
        }
        return null;
    }

    public function getSfContainer()
    {
        if(!class_exists('\PrestaShop\PrestaShop\Adapter\SymfonyContainer'))
        {
            $kernel = null;
            try{
                if(!class_exists('AppKernel')){
                    return null;
                }
                $kernel = new AppKernel('prod', false);
                $kernel->boot();
                return $kernel->getContainer();
            }
            catch (Exception $ex){
                return null;
            }
        }
        $sfContainer = call_user_func(array('\PrestaShop\PrestaShop\Adapter\SymfonyContainer', 'getInstance'));
        return $sfContainer;
    }

    public function addTwigVar($key, $value)
    {
        if($sfContainer = $this->getSfContainer())
        {
            $sfContainer->get('twig')->addGlobal($key, $value);
        }

    }
    public function getRequestContainer()
    {
        if($sfContainer = $this->getSfContainer())
        {
            return $sfContainer->get('request_stack')->getCurrentRequest();
        }
        return null;
    }

    public function getLinkUrlRedirect($item, $type = 'target')
    {
        if ($type == 'url') {
            $this->smarty->assign(array(
                'ets_target' => $item['url'],
                'ets_link' => $item['url'],
            ));
        } else {
            $this->smarty->assign(array(
                'ets_target' => $item['target'],
                'ets_link' => strpos($item['target'], 'https://') === false && strpos($item['target'], 'http://') === false ? 'http://' . $item['target'] : $item['target'],
            ));
        }

        return $this->display(__FILE__, 'url_redirect_link.tpl');
    }

    public function getPsExtraOption()
    {
        $etsDef = EtsAwuDefine::getInstance();
        return $etsDef->getFieldConfig()['ps_extra'];
    }
     public function setSitemap()
    {
        if ((int)Configuration::get('ETS_AWU_ENABLE_XML_SITEMAP') && (int)Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')) {
            if (@file_exists(_PS_ROOT_DIR_ . '/robots.txt'))
                @rename(_PS_ROOT_DIR_ . '/robots.txt', _PS_ROOT_DIR_ . '/_robots.txt');
            $path = _PS_ROOT_DIR_ . '/_robots.txt';
        } else
            $path = _PS_ROOT_DIR_ . '/robots.txt';
        if (@file_exists($path) && @is_writable($path))
            $robots = trim(Tools::file_get_contents($path));
        else
            $robots = '';
        $robots = str_replace("\r\n", "\n", $robots);
        $robots = preg_replace('/^(Sitemap: .+index_sitemap.xml)$/im', '#$1', $robots);
        if ($shops = Shop::getShops(false)) {
            foreach ($shops as $shop) {
                $s = new Shop($shop['id_shop']);
                $shopUrl = $s->getBaseURL(true, true);
                if (!preg_match('/^Sitemap: ' . str_replace("/", "\/", $shopUrl) . 'sitemap.xml$/im', $robots))
                    $robots .= "\nSitemap: " . $shopUrl . "sitemap.xml";
            }
        }
        @file_put_contents($path, $robots);
        return true;
    }

    public function removeSitemap()
    {
        if (@file_exists(_PS_ROOT_DIR_ . '/_robots.txt'))
            @rename(_PS_ROOT_DIR_ . '/_robots.txt', _PS_ROOT_DIR_ . '/robots.txt');
        $path = _PS_ROOT_DIR_ . '/robots.txt';
        if (@file_exists($path) && @is_writable($path) && ($robots = Tools::file_get_contents($path))) {
            $robots = str_replace("\r\n", "\n", $robots);
            $robots = preg_replace('/^Sitemap: .+\/sitemap.xml$/im', '', $robots);
            $robots = preg_replace('/^#(Sitemap: .+index_sitemap.xml)$/im', '$1', $robots);
            @file_put_contents($path, $robots);
        }
        return true;
    }
    public function getTotalProduct($active = false, $id_lang = null)
    {
        $sql = "SELECT COUNT(*) as total_product FROM `" . _DB_PREFIX_ . "product` p
                    INNER JOIN `" . _DB_PREFIX_ . "product_shop` product_shop ON (product_shop.id_product = p.id_product AND product_shop.id_shop = " . (int)$this->context->shop->id . ")
                    LEFT JOIN `" . _DB_PREFIX_ . "product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.id_shop = " . (int)$this->context->shop->id . ")
                    WHERE 1 " . ($active ? " AND p.`active` = 1 " : '') . ($id_lang ? " AND pl.`id_lang` = " . (int)$id_lang : '');
        return (int)Db::getInstance()->getValue($sql);
    }
    /**
     * hookDisplayAdminProductsSeoStepBottom
     *
     * @param  mixed $params
     *
     * @return void
     */
    public function hookDisplayAdminProductsSeoStepBottom($params)
    {
        $id_product = isset($params['id_product']) ? (int)$params['id_product'] : '';
        $languages = Language::getLanguages(true);
        $current_lang = array(
            'id' => $this->context->language->id,
            'iso_code' => $this->context->language->iso_code
        );

        $awuDef = EtsAwuDefine::getInstance();

        $this->smarty->assign(array(
            'ets_awu_languages' => $languages,
            'languages' => $languages,
            'current_lang' => $current_lang,
            'seo_advanced' => $awuDef->seo_advanced('product', $id_product, $this->context),
            'is_new_theme' => $this->getRequestContainer() ? true : false,
            'seo_enabled' => 1,
            'is16' => $this->is16
        ));
        return $this->display(__FILE__, 'page/seo_setting.tpl');
    }
    public function hookActionProductSave($params)
    {
        EtsAwuSetting::getInstance()->updateSeoProduct($params);
    }
    public function assignPageParams($type)
    {
        $metaTitleConfigName = '';
        $metaDescConfigName = '';
        switch ($type) {
            case 'cms':
                $idKey = 'id_cms';
                $idKey176 = 'cmsPageId';
                $objPage = 'CMS';
                $metaTitleConfigName = 'ETS_AWU_CMS_META_TILE';
                $metaDescConfigName = 'ETS_AWU_CMS_META_DESC';
                break;

            case 'cms_category':
                $idKey = 'id_cms_category';
                $idKey176 = 'cmsCategoryId';
                $objPage = 'CMSCategory';
                $metaTitleConfigName = 'ETS_AWU_CMS_CATE_META_TILE';
                $metaDescConfigName = 'ETS_AWU_CMS_CATE_META_DESC';
                break;

            case 'meta':
                $idKey = 'id_meta';
                $idKey176 = 'metaId';
                $objPage = 'Meta';
                break;

            case 'category':
                $idKey = 'id_category';
                $idKey176 = 'categoryId';
                $objPage = 'Category';
                $metaTitleConfigName = 'ETS_AWU_CATEGORY_META_TILE';
                $metaDescConfigName = 'ETS_AWU_CATEGORY_META_DESC';
                break;
            case 'manufacturer':
                $idKey = 'id_manufacturer';
                $idKey176 = 'manufacturerId';
                $objPage = 'Manufacturer';
                $metaTitleConfigName = 'ETS_AWU_MANUFACTURER_META_TITLE';
                $metaDescConfigName = 'ETS_AWU_MANUFACTURER_META_DESC';
                break;
            case 'supplier':
                $idKey = 'id_supplier';
                $idKey176 = 'supplierId';
                $objPage = 'Supplier';
                $metaTitleConfigName = 'ETS_AWU_SUPPLIER_META_TILE';
                $metaDescConfigName = 'ETS_AWU_SUPPLIER_META_DESC';
                break;

        }

        $languages = Language::getLanguages(false);
        $metaConfig = array();
        foreach ($languages as $lang) {
            $metaConfig[$lang['id_lang']] = array(
                'title' => $metaTitleConfigName ? (string)Configuration::get($metaTitleConfigName, $lang['id_lang']) : '',
                'desc' => $metaDescConfigName ? (string)Configuration::get($metaDescConfigName, $lang['id_lang']) : '',
            );
        }

        $current_lang = array(
            'id' => $this->context->language->id,
            'iso_code' => $this->context->language->iso_code
        );
        if(count($languages)){
            $langDefault = Language::getLanguage((int)Configuration::get('PS_LANG_DEFAULT'));
            $current_lang = array(
                'id' => $langDefault ? $langDefault['id_lang'] : $languages[0]['id_lang'],
                'iso_code' => $langDefault ? $langDefault['iso_code'] : $languages[0]['iso_code']
            );
        }
        $seoDef = EtsAwuDefine::getInstance();

        $seo_cms = array(
            'link' => array(),
            'link_rewrite' => array(),
            'meta_description' => array(),
            'meta_title' => array(),
            'key_phrase' => array()
        );
        $id = (int)Tools::getValue($idKey, null);
        if ($request = $this->getRequestContainer()) {
            $id = (int)$request->get($idKey176);
        }

        if ($id) {
            foreach ($languages as $lang) {
                $page = new $objPage($id, $lang['id_lang']);
                if ($type == 'meta') {
                    $link = $page->url_rewrite ? $this->getPageLink($page->page,null,null)  : '';
                } elseif ($type == 'cms') {
                    $link = $this->context->link->getCMSLink($page, null, null, (int)$lang['id_lang']);
                } elseif ($type == 'cms_category') {
                    $link =  $this->context->link->getCMSCategoryLink($page, null, null, (int)$lang['id_lang']);
                } elseif ($type == 'category') {
                    $link = $this->context->link->getCategoryLink($page, $page->link_rewrite,$lang['id_lang']);
                } elseif ($type == 'manufacturer') {
                    $link = $this->context->link->getManufacturerLink($page, null, (int)$lang['id_lang'], $this->context->shop->id);
                } elseif ($type == 'supplier') {
                    $link = $this->context->link->getSupplierLink($page, null, (int)$lang['id_lang'], $this->context->shop->id);
                }
                $seo_cms['link'][$lang['id_lang']] = $link ? (is_array($link) ? $link[0]['link'] : $link) : '';
                $seo_cms['link_rewrite'][$lang['id_lang']] = isset($page->link_rewrite) ? $page->link_rewrite : (isset($page->url_rewrite) ? $page->url_rewrite :'');
                $seo_cms['meta_title'][$lang['id_lang']] = isset($page->meta_title) && $page->meta_title ? $page->meta_title : (isset($page->title) ? $page->title : '');
                $seo_cms['meta_description'][$lang['id_lang']] = isset($page->meta_description) && $page->meta_description ? $page->meta_description : (isset($page->description) ? $page->description : '');
                if (!$seo_cms['meta_title'][$lang['id_lang']] && isset($page->name) && $page->name) {
                    $seo_cms['meta_title'][$lang['id_lang']] = $page->name;
                }
                if ($type == 'manufacturer' && !$page->meta_description) {
                    $seo_cms['meta_description'][$lang['id_lang']] = $page->short_description;
                }
            }
        }
        $this->smarty->assign(array(
            'ets_awu_languages' => $languages,
            'tmp_dir' => dirname(__FILE__) . '/views/templates',
            'seo_data' => '',
            'current_lang' => $current_lang,
            'seo_cms' =>'',// $seo_cms,
            'seo_advanced' => $seoDef->seo_advanced($type, $id, $this->context),
            'analysis_types' => '',
            'seo_enabled' => 1,
            'enable_force_rating' => false,
            'readability_enabled' => 1,
            'is_new_theme' => $this->getRequestContainer() ? true : false,
            'enable_rating' =>false,
            'rating_config' => '',
            'rating_setting' => '',
            'meta_config' => $metaConfig,
            
        ));
    }   
    public function seo_category_html()
    {
        $this->assignPageParams('category');
        $enableSeo = 1;
        if ($this->getRequestContainer()) {
            $controller = Tools::getValue('controller');
            if ($controller == 'AdminCategories') {
                $this->addTwigVar('ets_category_seo_setting_html', $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '');
            }

        } else {
            $this->context->smarty->assign(array(
                'ets_category_seo_setting_html' => $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '',
            ));
        }
    }
    public function seo_manufacturer_html()
    {
        $this->assignPageParams('manufacturer');
        $enableSeo = 1;
        if ($this->getRequestContainer()) {
            $controller = Tools::getValue('controller');
            if ($controller == 'AdminManufacturers') {
                $this->addTwigVar('ets_manufacturer_seo_setting_html', $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '');
            }

        } else {
            $this->context->smarty->assign(array(
                'ets_manufacturer_seo_setting_html' => $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '',
            ));
        }
    }
    public function seo_supplier_html()
    {
        $this->assignPageParams('supplier');
        $enableSeo = 1;
        if($this->getRequestContainer()){
            $controller = Tools::getValue('controller');
            if ($controller == 'AdminSuppliers') {
                $this->addTwigVar('ets_supplier_seo_setting_html', $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '');
            }
        }
        else{
            $this->context->smarty->assign(array(
                'ets_supplier_seo_setting_html' => $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '',
            ));
        }

    }
    /**
     * seo_cms_html
     *
     * @return void
     */
    public function seo_cms_html()
    {
        $this->assignPageParams('cms');
        $enableSeo = 1;
        if ($this->getRequestContainer()) {
            $controller = Tools::getValue('controller');
            if ($controller == 'AdminCmsContent') {
                $this->addTwigVar('ets_cms_seo_setting_html', $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '');
            }

        } else {
            $this->context->smarty->assign(array(
                'ets_cms_seo_setting_html' => $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '',
            ));
        }

    }
    public function seo_cms_category_html()
    {
        $this->assignPageParams('cms_category');
        $enableSeo = 1;
        if ($this->getRequestContainer()) {
            $controller = Tools::getValue('controller');
            if ($controller == 'AdminCmsContent') {
                $this->addTwigVar('ets_cms_category_seo_setting_html', $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '');
            }
        } else {
            $this->context->smarty->assign(array(
                'ets_cms_category_seo_setting_html' => $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '',
            ));
        }
    }
    /**
     * seo_cms_html
     *
     * @return void
     */
    public function seo_meta_html()
    {
        $this->assignPageParams('meta');
        $enableSeo = 1;
        if ($this->getRequestContainer()) {
            $controller = Tools::getValue('controller');
            if ($controller == 'AdminMeta') {
                $this->addTwigVar('ets_meta_seo_setting_html', $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '');
                //$this->addTwigVar('ets_meta_seo_analysis_html', $enableSeo ? $this->display(__FILE__, 'page/seo_analysis.tpl') : '');
               // $this->addTwigVar('ets_meta_seo_meta_title', $enableSeo ? $this->display(__FILE__, 'page/meta_title.tpl') : '');
               // $this->addTwigVar('ets_awu_preview_analysis', $this->display(__FILE__, 'parts/_preview_seo_analysis.tpl'));
                $this->addTwigVar('ETS_AWU_ENABLE_REMOVE_ID_IN_URL', (int)Configuration::get('ETS_AWU_ENABLE_REMOVE_ID_IN_URL'));
                $this->addTwigVar('ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS', (int)Configuration::get('ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS'));
                $this->addTwigVar('ETS_AWU_ENABLE_REDRECT_NOTFOUND', (int)Configuration::get('ETS_AWU_ENABLE_REDRECT_NOTFOUND'));
                $this->addTwigVar('ETS_AWU_REDIRECT_STATUS_CODE', (int)Configuration::get('ETS_AWU_REDIRECT_STATUS_CODE'));
                $this->addTwigVar('ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL', (int)Configuration::get('ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL'));
                $this->addTwigVar('titleRemoveLangCode', $this->l('Remove ISO code in URL for default language'));
                $this->addTwigVar('titleRemoveAttrAlias', $this->l('Remove attribute alias in URL'));
            }

        } else {
            $this->context->smarty->assign(array(
                'ets_meta_seo_setting_html' => $enableSeo ? $this->display(__FILE__, 'page/seo_setting.tpl') : '',
                //'ets_meta_seo_analysis_html' => $enableSeo ? $this->display(__FILE__, 'page/seo_analysis.tpl') : '',
                //'ets_meta_seo_meta_title' => $enableSeo ? $this->display(__FILE__, 'page/meta_title_b3.tpl') : '',
                //'ets_awu_preview_analysis' => $enableSeo ? $this->display(__FILE__, 'parts/_preview_seo_analysis.tpl') : '',
            ));
        }

    }
    public function getSeoMetaData()
    {
        $page = $this->is17 ? $this->context->controller->getTemplateVarPage():array();
        if (($controller = Tools::getValue('controller', null)) && Validate::isControllerName($controller)) {
            $id_lang = $this->context->language->id;
            $dataSeo = array();
            if (($id_product = (int)Tools::getValue('id_product')) && $controller == 'product') {
                $dataSeo = EtsAwuProduct::getSeoProduct($id_product, $this->context, $id_lang);
            } elseif (($id_category = (int)Tools::getValue('id_category'))  && $controller == 'category') {
                $dataSeo = EtsAwuCategory::getSeoCategory($id_category, $this->context, $id_lang);
            }
            elseif (($id_cms = (int)Tools::getValue('id_cms'))  && $controller == 'cms') {
                $dataSeo = EtsAwuCms::getSeoCms($id_cms, $this->context, $id_lang);
            }
            elseif (($id_cms = (int)Tools::getValue('id_cms_category'))  && in_array($controller, array('cms', 'cms_category'))) {
                $dataSeo = EtsAwuCmsCategory::getSeoCmsCategory($id_cms, $this->context, $id_lang);
            } elseif (($id_manufaturer = (int)Tools::getValue('id_manufacturer')) && $controller == 'manufacturer') {
                $dataSeo = EtsAwuManufacturer::getSeoManufacturer($id_manufaturer, $this->context, $id_lang);
            } elseif (($id_supplier = (int)Tools::getValue('id_supplier')) && $controller == 'supplier') {
                $dataSeo = EtsAwuSupplier::getSeoSupplier($id_supplier, $this->context, $id_lang);
            } else {
                $meta = Meta::getMetaByPage($this->context->controller->php_self, $id_lang);
                if ($meta) {
                    $dataSeo = EtsAwuMeta::getSeoMeta((int)$meta['id_meta'], $this->context, $id_lang);
                }
            }
            if(!$dataSeo)
                return '';
            //

            $meta_robot_default = isset($page['meta']['robots']) && $page['meta']['robots'] ? explode(',', $page['meta']['robots']) : array();
            $allow_search = $dataSeo ? (int)$dataSeo['allow_search'] : 1;
            $allow_flw_link = $dataSeo ? (int)$dataSeo['allow_flw_link'] : 1;
            $canonical_url = $dataSeo && $dataSeo['canonical_url'] ? $dataSeo['canonical_url'] : '';

            $meta_robot = $dataSeo ? $dataSeo['meta_robots_adv'] : '';
            $meta_robot = explode(',', $meta_robot);
            if (in_array('default', $meta_robot)) {
                if ($controller == 'product') {
                    $meta_robot_default[] = 'index';
                }
            } elseif (in_array('none', $meta_robot)) {
                $meta_robot_default = array();
            } else {
                $meta_robot_default = array();
                if (in_array('noarchive', $meta_robot)) {
                    $meta_robot_default[] = 'noarchive';
                }
                if (in_array('nosnippet', $meta_robot)) {
                    $meta_robot_default[] = 'nosnippet';
                }
                if (in_array('noimageindex', $meta_robot)) {
                    $meta_robot_default[] = 'noimageindex';
                }
            }


            if (!$allow_search) {
                $meta_robot_default[] = 'noindex';
                foreach ($meta_robot_default as $k=>$rb){
                    if($rb == 'index')
                        unset($meta_robot_default[$k]);
                }
                if(!$this->is17)
                    $this->context->smarty->assign('nobots',true);
            }
            elseif(!$this->is17)
                $this->context->smarty->clearAssign('nobots');
            if (!$allow_flw_link) {
                $meta_robot_default[] = 'nofollow';
                foreach ($meta_robot_default as $k=>$rb){
                    if($rb == 'follow')
                        unset($meta_robot_default[$k]);
                }
                if(!$this->is17)
                {
                    $this->context->smarty->assign('nofollow',true);
                }
            }elseif(!$this->is17)
                $this->context->smarty->clearAssign('nofollow'); 
            $page['meta']['robots'] = implode(',', $meta_robot_default);
            if (trim($canonical_url)) {
                $page['canonical'] = $canonical_url;
                if(!$this->is17)
                    $this->context->smarty->assign('canonical',$canonical_url);
            }
        }

        if($this->is17)
        {
            $this->context->smarty->assign(array(
                'page' => $page
            ));
        }

    }
    public static function validateArray($array,$validate='isCleanHtml')
    {
        if(!is_array($array))
            return true;
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
    public function validateLinkRewrite($params)
    {
        if (isset($params['object'])) {
            $type = null;
            $obj = $params['object'];
            $idCol = '';
            if ($obj instanceof Product) {
                $type = 'product';
                $idCol = 'id_product';
            } elseif ($obj instanceof Category) {
                $type = 'category';
                $idCol = 'id_category';
            } elseif ($obj instanceof CMS) {
                $type = 'cms';
                $idCol = 'id_cms';
            } elseif ($obj instanceof CMSCategory) {
                $type = 'cms_category';
                $idCol = 'id_cms_category';
            } elseif ($obj instanceof Meta) {
                $type = 'meta';
                $idCol = 'id_meta';
            }
            if (!$type) {
                return;
            }
            $error = null;
            $seoAdvanced = Tools::getValue('ets_awu_advanced');
            if (isset($seoAdvanced['canonical_url']) && !$error) {
                foreach ($seoAdvanced['canonical_url'] as $id_lang => $url) {
                    if ($url && !Validate::isAbsoluteUrl($url)) {
                        $error = sprintf($this->l('[%s] The Canonical url must start with http:// or https:// '),Language::getIsoById($id_lang));
                        break;
                    }
                }
            }
            if ($error) {
                if($this->is17)
                {
                    if ($type !== 'cms') {
                        throw new PrestaShopException($error);
                    } else {
                        $controller = ($controller = Tools::getValue('controller')) && Validate::isCleanHtml($controller) ? $controller : '';
                        $this->context->cookie->__set('ets_awu_error_link_rewrite', $error);
                        if ($obj->id) {
                            $redirectUrl = $this->context->link->getAdminLink($controller, true, array(), array(
                                $idCol => $obj->id,
                                'updatecms' => true
                            )).'&'.$idCol.'='.$obj->id.'&update'.$type;
                        } else {
                            $redirectUrl = $this->context->link->getAdminLink($controller, true, array(), array(
                                $idCol => $obj->id,
                                'id_cms_category' => $obj->id_cms_category,
                                'addcms' => true
                            ));
    
                        }
                        Tools::redirectAdmin($redirectUrl);
                    }
                }
                else
                {
                    $controller = ($controller = Tools::getValue('controller')) && Validate::isCleanHtml($controller) ? $controller : '';
                    $this->context->cookie->__set('ets_awu_error_link_rewrite', $error);
                    if($obj->id)
                        $redirectUrl = $this->context->link->getAdminLink($controller, true).'&'.$idCol.'='.$obj->id.'&update'.$type;
                    else
                        $redirectUrl = $this->context->link->getAdminLink($controller, true).'&add'.$type;
                    Tools::redirectAdmin($redirectUrl);
                }
            }
        }

    }
    public function formHandleLinkRewrite($params, $type)
    {
        $id = isset($params['id']) ? (int)$params['id'] : null;
        $redirectUrl = null;
        switch ($type) {
            case 'category':
                if ($id) {
                    $redirectUrl = $this->context->link->getAdminLink('AdminCategories', true,
                        array('route' => 'admin_categories_edit', 'categoryId' => $id),
                        array('id_category' => $id, 'updatecategory' => true));
                } else {
                    $idParent = (int)$params['form_data']['id_parent'];
                    $redirectUrl = $this->context->link->getAdminLink('AdminCategories', true,
                        array('route' => 'admin_categories_create', 'id_parent' => $idParent),
                        array('addcategory' => true));
                }
                break;
            case 'cms':
                if ($id) {
                    $redirectUrl = $this->context->link->getAdminLink('AdminCms', true,
                        array('route' => 'admin_cms_pages_edit', 'cmsPageId' => $id),
                        array('id_cms' => $id, 'updatecms' => true));
                } else {
                    $idParent = (int)$params['form_data']['id_cms_category'];
                    $redirectUrl = $this->context->link->getAdminLink('AdminCms', true,
                        array('route' => 'admin_cms_pages_create', 'id_cms_category' => $idParent),
                        array('addcms' => true, 'id_cms_category' => $idParent));
                }
                break;
            case 'cms_category':
                if ($id) {
                    $redirectUrl = $this->context->link->getAdminLink('AdminCmsCategories', true,
                        array('route' => 'admin_cms_pages_category_edit', 'cmsCategoryId' => $id),
                        array('id_cms_category' => $id, 'updatecms_category' => true));
                } else {
                    $redirectUrl = $this->context->link->getAdminLink('AdminCmsCategories', true,
                        array('route' => 'admin_cms_pages_category_create'),
                        array('addcms_category' => true));
                }
                break;
            case 'meta':
                if ($id) {
                    $redirectUrl = $this->context->link->getAdminLink('AdminMeta', true,
                        array('route' => 'admin_metas_edit', 'metaId' => $id),
                        array('id_meta' => $id, 'updatemeta' => true));
                } else {
                    $redirectUrl = $this->context->link->getAdminLink('AdminMeta', true,
                        array('route' => 'admin_metas_create'),
                        array('addmeta' => true));
                }
                break;
        }
        $error = null;
        $seoAdvanced = Tools::getValue('ets_awu_advanced');
        if (isset($seoAdvanced['canonical_url']) && !$error) {
            foreach ($seoAdvanced['canonical_url'] as $id_lang => $url) {
                if ($url && !Validate::isAbsoluteUrl($url)) {
                    $error = sprintf($this->l('[%s] The Canonical url must start with http:// or https:// '),Language::getIsoById($id_lang));
                    break;
                }
            }
        }
        if ($error) {
            $params['form_data']['ets_awu_error'] = $error;
            $fileName = time() . rand(1111, 99999) . '.json';
            file_put_contents(dirname(__FILE__) . '/cache/' . $fileName, Tools::jsonEncode($params['form_data']));
            $this->context->cookie->ets_awu_form_validate_data = $fileName;
            $this->context->cookie->write();
            Tools::redirectAdmin($redirectUrl);
        }

    }

    public function setFormBuilderModifier(&$params)
    {
        if ($fileData = $this->context->cookie->__get('ets_awu_form_validate_data')) {
            $data = array();
            if (file_exists(dirname(__FILE__) . '/cache/' . $fileData)) {
                $json = Tools::file_get_contents(dirname(__FILE__) . '/cache/' . $fileData);
                $data = Tools::jsonDecode($json, true);
                unlink(dirname(__FILE__) . '/cache/' . $fileData);
            }
            $error = '';
            if (isset($data['ets_awu_error'])) {
                $error = $data['ets_awu_error'];
                unset($data['ets_awu_error']);
            }
            $params['data'] = array_merge($params['data'], $data);
            $params['form_builder']->setData($params['data']);
            $this->context->cookie->__unset('ets_awu_form_validate_data');
            $this->context->cookie->__set('ets_awu_error_link_rewrite', $error);

        }
    }
    public function hookActionObjectAddBefore($params)
    {
        if(!defined('_PS_ADMIN_DIR_'))
        {
            return;
        }
        if ($this->getRequestContainer()) {
            //Removed
        } else {
            $this->validateLinkRewrite($params);
        }

    }
    /* == Category ===*/
    public function hookActionBeforeUpdateCategoryFormHandler($params)
    {
        $this->formHandleLinkRewrite($params, 'category');
    }

    public function hookActionBeforeCreateCategoryFormHandler($params)
    {
        //fom_data
        $this->formHandleLinkRewrite($params, 'category');
    }

    public function hookActionCategoryFormBuilderModifier($params)
    {
        $this->setFormBuilderModifier($params);
    }

    //Root category
    public function hookActionBeforeUpdateRootCategoryFormHandler($params)
    {
        $this->formHandleLinkRewrite($params, 'category');
    }

    public function hookActionBeforeCreateRootCategoryFormHandler($params)
    {
        //fom_data
        $this->formHandleLinkRewrite($params, 'category');
    }

    public function hookActionRootCategoryFormBuilderModifier($params)
    {
        $this->setFormBuilderModifier($params);
    }

    /* = CMS ==*/
    public function hookActionBeforeUpdateCmsPageFormHandler($params)
    {
        $this->formHandleLinkRewrite($params, 'cms');
    }

    public function hookActionBeforeCreateCmsPageFormHandler($params)
    {
        //fom_data
        $this->formHandleLinkRewrite($params, 'cms');
    }

    public function hookActionCmsPageFormBuilderModifier($params)
    {
        $this->setFormBuilderModifier($params);
    }

    /* = CMS Category ==*/
    public function hookActionBeforeUpdateCmsPageCategoryFormHandler($params)
    {
        $this->formHandleLinkRewrite($params, 'cms_category');
    }

    public function hookActionBeforeCreateCmsPageCategoryFormHandler($params)
    {
        //fom_data
        $this->formHandleLinkRewrite($params, 'cms_category');
    }

    public function hookActionCmsPageCategoryFormBuilderModifier($params)
    {
        $this->setFormBuilderModifier($params);
    }

    /* = Meta ==*/
    public function hookActionBeforeUpdateMetaFormHandler($params)
    {
        $this->formHandleLinkRewrite($params, 'meta');
    }

    public function hookActionBeforeCreateMetaFormHandler($params)
    {
        //fom_data
        $this->formHandleLinkRewrite($params, 'meta');
    }

    public function hookActionMetaFormBuilderModifier($params)
    {
        $this->setFormBuilderModifier($params);
    }
}