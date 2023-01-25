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

if (!defined('_PS_VERSION_'))
{
    exit;
}

class EtsAwuSetting
{
    public $isNewTheme = false;
    public static $instance;
    public $context = null;
    public function __construct($context = null)
    {
        if(!$this->context){
            $this->context = $context ? $context : Context::getContext();
        }
        $this->isNewTheme = $this->getRequestContainer() ? true : false;
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new EtsAwuSetting();
        }
        return self::$instance;
    }

    public function updateSeoCms($params)
    {
        $controller = Tools::getValue('controller');
        if (
            (!$this->isNewTheme && $controller == 'AdminCmsContent') ||
            ($this->isNewTheme && isset($params['object']) && $params['object'] instanceof CMS)
        ) {
            $cms = $params['object'];
            if ($cms instanceof CMS) {
                $id_cms = $cms->id;
                $languages = Language::getLanguages(false);
                if ($languages) {
                    foreach ($languages as $language) {
                        $id_lang = (int)$language['id_lang'];
                        $id_ets_awu_cms = Db::getInstance()->getValue("SELECT id_ets_awu_cms 
                                                        FROM `" . _DB_PREFIX_ . "ets_awu_cms` WHERE `id_cms` = " . (int)$id_cms . " 
                                                        AND id_shop = " . (int)$this->context->shop->id . " 
                                                        AND id_lang = " . (int)$id_lang);

                        if ((int)$id_ets_awu_cms) {
                            $seoCms = new EtsAwuCms($id_ets_awu_cms);
                        } else {
                            $seoCms = new EtsAwuCms();
                        }
                        $seoCms->id_cms = $id_cms;
                        $seoCms->id_shop = $this->context->shop->id;
                        $seoCms->id_lang = $id_lang;
                        if (($advanced = Tools::getValue('ets_awu_advanced', array())) && Ets_awesomeurl::validateArray($advanced) ) {
                            foreach ($advanced as $key => $val) {
                                if (isset($val[$id_lang])) {
                                    if (is_array($val[$id_lang])) {
                                        $val[$id_lang] = implode(',', $val[$id_lang]);
                                    }
                                    $seoCms->{$key} = $val[$id_lang];
                                }

                            }
                        }
                        $seoCms->save();
                    }
                }
            }
        }
    }
    public function updateSeoMeta($params)
    {
        $controller = Tools::getValue('controller');
        if (
            (!$this->isNewTheme && $controller == 'AdminMeta') ||
            ($this->isNewTheme && isset($params['object']) && $params['object'] instanceof Meta)
        ) {
            $metaObj = $params['object'];
            if ($metaObj instanceof Meta) {
                $id_meta = $metaObj->id;
                $languages = Language::getLanguages(false);
                if ($languages) {
                    foreach ($languages as $language) {
                        $id_lang = (int)$language['id_lang'];
                        $id_ets_awu_meta = Db::getInstance()->getValue("SELECT id_ets_awu_meta 
                                                        FROM `" . _DB_PREFIX_ . "ets_awu_meta` 
                                                        WHERE `id_meta` = " . (int)$id_meta . " 
                                                            AND id_shop = " . (int)$this->context->shop->id . " 
                                                            AND id_lang = " . (int)$id_lang);
                        $advanced = Tools::getValue('ets_awu_advanced', array());

                        if ((int)$id_ets_awu_meta) {
                            $sql = "UPDATE `" . _DB_PREFIX_ . "ets_awu_meta` SET `key_phrase` = '', `minor_key_phrase` = ''";
                            if($advanced && Ets_awesomeurl::validateArray($advanced))
                            {
                                foreach ($advanced as $key => $val) {
                                    if (isset($val[$id_lang])) {
                                        $sql .= ",`" . (string)$key . "` = '" . pSQL($val[$id_lang]) . "'";
                                    }
                                }
                            }
                            $sql .= " WHERE `id_meta` = " . (int)$id_meta . " 
                                    AND id_shop = " . (int)$this->context->shop->id . " 
                                    AND id_lang = " . (int)$id_lang;

                            Db::getInstance()->execute($sql);
                        } else {
                            $meta = new EtsAwuMeta();
                            $meta->id_meta = $id_meta;
                            $meta->id_shop = $this->context->shop->id;
                            $meta->id_lang = $id_lang;
                            if($advanced && Ets_awesomeurl::validateArray($advanced))
                            {
                                foreach ($advanced as $key => $val) {
                                    if (isset($val[$id_lang])) {
                                        if (is_array($val[$id_lang])) {
                                            $val[$id_lang] = implode(',', $val[$id_lang]);
                                        }
                                        $meta->{$key} = $val[$id_lang];
                                    }
                                }
                            }
                            $meta->add();
                        }

                    }
                }
            }
        }
    }

    public function updateSeoCategory($params)
    {
        $controller = Tools::getValue('controller');
        if (
            (!$this->isNewTheme && $controller == 'AdminCategories') ||
            ($this->isNewTheme && isset($params['object']) && $params['object'] instanceof Category)
        ) {
            $category = $params['object'];
            if ($category instanceof Category) {
                $id_category = $category->id;
                $languages = Language::getLanguages(false);
                if ($languages) {
                    foreach ($languages as $language) {
                        $id_lang  = (int)$language['id_lang'];
                        $id_ets_awu_category = Db::getInstance()->getValue("SELECT id_ets_awu_category 
                                                        FROM `" . _DB_PREFIX_ . "ets_awu_category` WHERE `id_category` = " . (int)$id_category . " 
                                                        AND id_shop = " . (int)$this->context->shop->id . " 
                                                        AND id_lang = " . (int)$id_lang);
                        if ((int)$id_ets_awu_category) {
                            $seoCategory = new EtsAwuCategory($id_ets_awu_category);
                        } else {
                            $seoCategory = new EtsAwuCategory();
                        }
                        $seoCategory->id_category = $id_category;
                        $seoCategory->id_shop = $this->context->shop->id;
                        $seoCategory->id_lang = $id_lang;
                        if (($advanced = Tools::getValue('ets_awu_advanced', array())) && Ets_awesomeurl::validateArray($advanced)) {
                            foreach ($advanced as $key => $val) {
                                if (isset($val[$id_lang])) {
                                    if (is_array($val[$id_lang])) {
                                        $val[$id_lang] = implode(',', $val[$id_lang]);
                                    }
                                    $seoCategory->{$key} = $val[$id_lang];
                                }
                            }
                        }
                        $seoCategory->save();
                    }
                }
            }
        }
    }

    public function updateSeoManufacturer($params)
    {
        $controller = Tools::getValue('controller');
        if (
            (!$this->isNewTheme && $controller == 'AdminManufacturers') ||
            ($this->isNewTheme && isset($params['object']) && $params['object'] instanceof Manufacturer)
        ) {
            $manufacturer = $params['object'];
            if ($manufacturer instanceof Manufacturer) {

                $id_manufacturer = $manufacturer->id;
                $languages = Language::getLanguages(false);
                if ($languages) {
                    foreach ($languages as $language) {
                        $id_lang = (int)$language['id_lang'];
                        $id_ets_awu_manufacturer = Db::getInstance()->getValue("SELECT id_ets_awu_manufacturer 
                                                        FROM `" . _DB_PREFIX_ . "ets_awu_manufacturer` WHERE `id_manufacturer` = " . (int)$id_manufacturer . " 
                                                        AND id_shop = " . (int)$this->context->shop->id . " 
                                                        AND id_lang = " . (int)$id_lang);
                        if ((int)$id_ets_awu_manufacturer) {
                            $seoManuf = new EtsAwuManufacturer($id_ets_awu_manufacturer);
                        } else {
                            $seoManuf = new EtsAwuManufacturer();
                        }
                        $seoManuf->id_manufacturer = $id_manufacturer;
                        $seoManuf->id_shop = $this->context->shop->id;
                        $seoManuf->id_lang = $id_lang;
                        if (($advanced = Tools::getValue('ets_awu_advanced', array())) && Ets_awesomeurl::validateArray($advanced)) {
                            foreach ($advanced as $key => $val) {
                                if (isset($val[$id_lang])) {
                                    if (is_array($val[$id_lang])) {
                                        $val[$id_lang] = implode(',', $val[$id_lang]);
                                    }
                                    $seoManuf->{$key} = $val[$id_lang];
                                }
                            }
                        }
                        $seoManuf->save();
                    }
                }
            }
        }
    }

    public function updateSeoSupplier($params)
    {
        $controller = Tools::getValue('controller');
        if (
            (!$this->isNewTheme && $controller == 'AdminSuppliers') ||
            ($this->isNewTheme && isset($params['object']) && $params['object'] instanceof Supplier)
        ) {
            $supplier = $params['object'];
            if ($supplier instanceof Supplier) {
                $id_supplier = $supplier->id;
                $languages = Language::getLanguages(false);
                if ($languages) {
                    foreach ($languages as $language) {
                        $id_lang = (int)$language['id_lang'];
                        $id_ets_awu_supplier = Db::getInstance()->getValue("SELECT id_ets_awu_supplier 
                                                        FROM `" . _DB_PREFIX_ . "ets_awu_supplier` WHERE `id_supplier` = " . (int)$id_supplier . " 
                                                        AND id_shop = " . (int)$this->context->shop->id . " 
                                                        AND id_lang = " . (int)$id_lang);
                        if ((int)$id_ets_awu_supplier) {
                            $seoSupplier = new EtsAwuSupplier($id_ets_awu_supplier);
                        } else {
                            $seoSupplier = new EtsAwuSupplier();
                        }
                        $seoSupplier->id_supplier = $id_supplier;
                        $seoSupplier->id_shop = $this->context->shop->id;
                        $seoSupplier->id_lang = $id_lang;
                        if (($advanced = Tools::getValue('ets_awu_advanced', array())) && Ets_awesomeurl::validateArray($advanced)) {
                            foreach ($advanced as $key => $val) {
                                if (isset($val[$id_lang])) {
                                    if (is_array($val[$id_lang])) {
                                        $val[$id_lang] = implode(',', $val[$id_lang]);
                                    }
                                    $seoSupplier->{$key} = $val[$id_lang];
                                }
                            }
                        }
                        $seoSupplier->save();
                    }
                }
            }
        }
    }

    public function updateSeoCmsCategory($params)
    {
        $controller = Tools::getValue('controller');
        if (
            (!$this->isNewTheme && $controller == 'AdminCmsContent') ||
            ($this->isNewTheme && isset($params['object']) && $params['object'] instanceof CMSCategory)
        ) {

            $cms = $params['object'];
            if ($cms instanceof CMSCategory) {
                $id_cms = $cms->id;
                $languages = Language::getLanguages(false);
                if ($languages) {
                    foreach ($languages as $language) {
                        $id_lang = (int)$language['id_lang'];
                        $id_ets_awu_cms = Db::getInstance()->getValue("SELECT id_ets_awu_cms_category 
                                                        FROM `" . _DB_PREFIX_ . "ets_awu_cms_category` WHERE `id_cms_category` = " . (int)$id_cms . " 
                                                        AND id_shop = " . (int)$this->context->shop->id . " 
                                                        AND id_lang = " . (int)$id_lang);

                        if ((int)$id_ets_awu_cms) {
                            $seoCms = new EtsAwuCmsCategory($id_ets_awu_cms);
                        } else {
                            $seoCms = new EtsAwuCmsCategory();
                        }

                        $seoCms->id_cms_category = $id_cms;
                        $seoCms->id_shop = $this->context->shop->id;
                        $seoCms->id_lang = $id_lang;
                        if (($advanced = Tools::getValue('ets_awu_advanced', array())) && Ets_awesomeurl::validateArray($advanced)) {
                            foreach ($advanced as $key => $val) {
                                if (isset($val[$id_lang])) {
                                    if (is_array($val[$id_lang])) {
                                        $val[$id_lang] = implode(',', $val[$id_lang]);
                                    }
                                    $seoCms->{$key} = $val[$id_lang];
                                }

                            }
                        }
                        $seoCms->save();
                    }
                }
            }
        }
    }

    public function updateSeoProduct($params)
    {
        if (isset($params['product'])) {

            $id_product = $params['product']->id;
            $id_shop = $this->context->shop->id;
            $languages = Language::getLanguages(false);
            if ($languages) {
                foreach ($languages as $language) {
                    $id_lang = (int)$language['id_lang'];
                    $id_ets_awu_product = Db::getInstance()->getValue("SELECT `id_ets_awu_product` 
                                                FROM `" . _DB_PREFIX_ . "ets_awu_product` 
                                                WHERE id_product = " . (int)$id_product . " AND id_shop = " . (int)$id_shop . " AND id_lang = " . (int)$id_lang);
                    if ($id_ets_awu_product) {
                        $seoProduct = new EtsAwuProduct($id_ets_awu_product);
                    } else {
                        $seoProduct = new EtsAwuProduct();
                        $seoProduct->allow_flw_link = 1;
                        $seoProduct->allow_search = 1;
                    }

                    $seoProduct->id_product = $id_product;
                    $seoProduct->id_shop = $id_shop;
                    $seoProduct->id_lang = $id_lang;
                    if (($advanced = Tools::getValue('ets_awu_advanced', array())) && Ets_awesomeurl::validateArray($advanced) ) {
                        foreach ($advanced as $key => $val) {
                            if (isset($val[$id_lang]))
                                $seoProduct->{$key} = $val[$id_lang];
                        }
                    }
                    $seoProduct->save();
                }
            }
        }
    }

    public function getRequestContainer()
    {
        if(!class_exists('\PrestaShop\PrestaShop\Adapter\SymfonyContainer'))
        {
            if(class_exists('AppKernel'))
            {
                $kernel = null;
                try{
                    $kernel = new AppKernel('prod', false);
                    $kernel->boot();
                    return $kernel->getContainer()->get('request_stack')->getCurrentRequest();
                }
                catch (Exception $ex){
                    return null;
                }
            }
            else
            return null;
        }
        $sfContainer = call_user_func(array('\PrestaShop\PrestaShop\Adapter\SymfonyContainer', 'getInstance'));

        if (null !== $sfContainer && null !== $sfContainer->get('request_stack')->getCurrentRequest()) {
            $request = $sfContainer->get('request_stack')->getCurrentRequest();
            return $request;
        }
        return null;
    }

    public function getSocialImage($path)
    {
        return basename($path);
    }
    public function  isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    public static function validateLinkRewrite($type, $link_rewrites = array(), $id, $context = null)
    {
        if (!(int)Configuration::get('ETS_AWU_ENABLE_REMOVE_ID_IN_URL')) {
            return false;
        }
        if(!$context)
        {
            $context = Context::getContext();
        }
        $table = '';
        $linkRewriteCol = 'link_rewrite';
        $idCol = '';
        $error = false;
        switch ($type){
            case 'product':
                $table = 'product_lang';
                $idCol = 'id_product';
                break;
            case 'category':
                $table = 'category_lang';
                $idCol = 'id_category';
                break;
            case 'cms':
                $table = 'cms_lang';
                $idCol = 'id_cms';
                break;
            case 'cms_category':
                $table = 'cms_category_lang';
                $idCol = 'id_cms_category';
                break;
            case 'meta':
                $table = 'meta_lang';
                $linkRewriteCol = 'url_rewrite';
                $idCol = 'id_meta';
                break;
        }
        if(!$table)
        {
            return $error;
        }
        $filterId = '';
        if ($id) {
            $filterId = " AND `" . (string)$idCol . "` !=" . (int)$id;
        }
        foreach ($link_rewrites as $id_lang => $link_rewrite) {
            $langCheck = Language::getLanguage($id_lang);
            if(!$langCheck || !(int)$langCheck['active'] || !$link_rewrite){
                continue;
            }
            $duplicate = Db::getInstance()->getValue(
                "SELECT *
                    FROM " . _DB_PREFIX_ . (string)$table . " 
                    WHERE `" . (string)$linkRewriteCol . "`='" . (string)$link_rewrite . "' AND id_lang=" . (int)$id_lang . " AND id_shop=" . (int)$context->shop->id . $filterId
            );
            if ($duplicate) {
                $error = $link_rewrite.' ('.Language::getIsoById($id_lang).')';
            }
            break;
        }
        return $error;

    }

    public static function checkLinkRewriteAjax($controller, $linkRewrites, $id = null, $isCmsCate = false)
    {
        $type = null;
        switch ($controller){
            case 'AdminProducts':
                $type = 'product';
                break;
        }
        if($type)
        {
            $dataLinks = array();
            foreach ($linkRewrites as $linkRewrite)
            {
                $dataLinks[$linkRewrite['id_lang']] = $linkRewrite['value'];
            }
            $error = self::validateLinkRewrite($type, $dataLinks, (int)$id);
            if($error)
            {
                die(Tools::jsonEncode(array(
                    'success' => false,
                    'error' => $error
                )));
            }
        }
        if($isCmsCate){
            //
        }
        die(Tools::jsonEncode(array(
            'success' => true,
            'error' => ''
        )));
    }

    public static function isMetaTemplateConfigured($controller, $is_cms_cate = false)
    {
        $title = '';
        $desc = '';
        switch ($controller)
        {
            case 'AdminProducts':
                $title =  'ETS_AWU_PROD_META_TILE';
                $desc =  'ETS_AWU_PROD_META_DESC';
                break;
            case 'AdminCategories':
                $title =  'ETS_AWU_CATEGORY_META_TILE';
                $desc =  'ETS_AWU_CATEGORY_META_DESC';
                break;
            case 'AdminCmsContent':
                if($is_cms_cate)
                {
                    $title =  'ETS_AWU_CMS_CATE_META_TILE';
                    $desc =  'ETS_AWU_CMS_CATE_META_DESC';
                }
                else{
                    $title = 'ETS_AWU_CMS_META_TILE';
                    $desc =  'ETS_AWU_CMS_META_DESC';
                }
                break;
            case 'AdminManufacturers':
                $title =  'ETS_AWU_MANUFACTURER_META_TITLE';
                $desc =  'ETS_AWU_MANUFACTURER_META_DESC';
                break;
            case 'AdminSuppliers':
                $title =  'ETS_AWU_SUPPLIER_META_TILE';
                $desc =  'ETS_AWU_SUPPLIER_META_DESC';
                break;
        }
        $languages = Language::getLanguages(false);
        $result = array();
        if($title)
        {
            foreach ($languages as $lang)
            {
                $result[$lang['id_lang']] = array(
                    'title' => Configuration::get($title, $lang['id_lang']),
                    'desc' => Configuration::get($desc, $lang['id_lang']),
                );
            }
        }
        return $result;
    }
}