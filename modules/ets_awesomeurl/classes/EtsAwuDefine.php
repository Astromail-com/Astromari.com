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

class EtsAwuDefine
{
    public $context;
    public $module;
    public $is17;
    public static $instance = null;

    public function __construct($module = null)
    {
        if (!(is_object($module)) || !$module) {
            $module = Module::getInstanceByName('ets_awesomeurl');
        }
        $this->module = $module;
        $context = Context::getContext();
        $this->context = $context;
        $this->is17 = version_compare('1.7.0.0', _PS_VERSION_, '<=');
    }

    public function l($string)
    {
        return Translate::getModuleTranslation('ets_awesomeurl', $string, pathinfo(__FILE__, PATHINFO_FILENAME));
    }


    public function display($template)
    {
        if (!$this->module)
            return;
        return $this->module->display($this->module->getLocalPath(), $template);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new EtsAwuDefine();
        }
        return self::$instance;
    }

    public function adminControllers()
    {
        return array(
            'AdminEtsAwuUrlRedirects' => array(
                'title' => $this->l('URL Redirection'),
                'title_text' => 'URL Redirection',
                'class' => '',
                'icon' => 'ets-sidebar-icon-url-redirect',
            ),
            'AdminEtsAwuDuplicateUrls' => array(
                'title' => $this->l('Check Duplicate URLs'),
                'title_text' => 'Check Duplicate URLs',
                'class' => '',
                'icon' => 'ets-sidebar-icon-duplicate-url',
            ),
            'AdminEtsAwuSearchAppearanceSitemap' => array(
                'title' => $this->l('Sitemap'),
                'title_text' => 'Sitemap',
                'class' => '',
                'icon' => 'ets-sitemap',
            ),
            'AdminEtsAwuSearchAppearanceRSS' => array(
                'title' => $this->l('Rss'),
                'title_text' => 'Rss',
                'class' => '',
                'icon' => 'ets-rss',
            ),
        );
    }

    public function installDb()
    {
        $tbl_url_redirect = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_awu_redirect` (
            `id_ets_awu_redirect` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `url` VARCHAR(255) NOT NULL,
            `target` VARCHAR(255) NOT NULL,
            `type` ENUM('301', '302', '303', '404') DEFAULT NULL,
            `active` INT(1) DEFAULT 1,
            `id_shop` INT(11) NOT NULL,
            PRIMARY KEY (`id_ets_awu_redirect`),
            INDEX (`active`,`id_shop`)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        $tbl_seo_product = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_awu_product` (
            `id_ets_awu_product` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_product` INT(10) UNSIGNED NOT NULL,
            `id_shop` INT(11) NOT NULL,
            `id_lang` INT(11) NOT NULL,
            `key_phrase` VARCHAR(191) DEFAULT NULL,
            `minor_key_phrase` VARCHAR(191) DEFAULT NULL,
            `allow_search` INT(1) UNSIGNED DEFAULT 2,
            `allow_flw_link` INT(1) UNSIGNED DEFAULT 1,
            `meta_robots_adv` VARCHAR(191) DEFAULT NULL,
            `meta_keywords` VARCHAR(191) DEFAULT NULL,
            `canonical_url` VARCHAR(191) DEFAULT NULL,
            `seo_score` INT(3) UNSIGNED  DEFAULT NULL,
            `readability_score` INT(3) UNSIGNED DEFAULT NULL,
            `score_analysis` TEXT DEFAULT NULL,
            `content_analysis` TEXT DEFAULT NULL,
            `social_title` VARCHAR(191) DEFAULT NULL,
            `social_desc` TEXT DEFAULT NULL,
            `social_img` VARCHAR(191) DEFAULT NULL,
            PRIMARY KEY (`id_ets_awu_product`),
            UNIQUE KEY `ets_awu_psl` (id_product, id_shop, id_lang)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $tbl_seo_category = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_awu_category` (
            `id_ets_awu_category` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_category` INT(10) UNSIGNED NOT NULL,
            `id_shop` INT(11) NOT NULL,
            `id_lang` INT(11) NOT NULL,
            `key_phrase` VARCHAR(191) DEFAULT NULL,
            `minor_key_phrase` VARCHAR(191) DEFAULT NULL,
            `allow_search` INT(1) UNSIGNED DEFAULT 2,
            `allow_flw_link` INT(1) UNSIGNED DEFAULT 1,
            `meta_robots_adv` VARCHAR(191) DEFAULT NULL,
            `meta_keywords` VARCHAR(191) DEFAULT NULL,
            `canonical_url` VARCHAR(191) DEFAULT NULL,
            `seo_score` INT(3) UNSIGNED  DEFAULT NULL,
            `readability_score` INT(3) UNSIGNED DEFAULT NULL,
            `score_analysis` TEXT DEFAULT NULL,
            `content_analysis` TEXT DEFAULT NULL,
            `social_title` VARCHAR(191) DEFAULT NULL,
            `social_desc` TEXT DEFAULT NULL,
            `social_img` VARCHAR(191) DEFAULT NULL,
            PRIMARY KEY (`id_ets_awu_category`),
            UNIQUE KEY `ets_awu_csl` (id_category, id_shop, id_lang)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $tbl_seo_cms = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_awu_cms` (
            `id_ets_awu_cms` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_cms` INT(10) UNSIGNED NOT NULL,
            `id_shop` INT(11) NOT NULL,
            `id_lang` INT(11) NOT NULL,
            `key_phrase` VARCHAR(191) DEFAULT NULL,
            `minor_key_phrase` VARCHAR(191) DEFAULT NULL,
            `allow_search` INT(1) UNSIGNED DEFAULT 2,
            `allow_flw_link` INT(1) UNSIGNED DEFAULT 1,
            `meta_robots_adv` VARCHAR(191) DEFAULT NULL,
            `meta_keywords` VARCHAR(191) DEFAULT NULL,
            `canonical_url` VARCHAR(191) DEFAULT NULL,
            `seo_score` INT(3) UNSIGNED DEFAULT NULL,
            `readability_score` INT(3) UNSIGNED DEFAULT NULL,
            `score_analysis` TEXT DEFAULT NULL,
            `content_analysis` TEXT DEFAULT NULL,
            `social_title` VARCHAR(191) DEFAULT NULL,
            `social_desc` TEXT DEFAULT NULL,
            `social_img` VARCHAR(191) DEFAULT NULL,
            PRIMARY KEY (`id_ets_awu_cms`),
            UNIQUE KEY `ets_awu_csl` (id_cms, id_shop, id_lang)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $tbl_seo_cms_category = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_awu_cms_category` (
            `id_ets_awu_cms_category` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_cms_category` INT(10) UNSIGNED NOT NULL,
            `id_shop` INT(11) NOT NULL,
            `id_lang` INT(11) NOT NULL,
            `key_phrase` VARCHAR(191) DEFAULT NULL,
            `minor_key_phrase` VARCHAR(191) DEFAULT NULL,
            `allow_search` INT(1) UNSIGNED DEFAULT 2,
            `allow_flw_link` INT(1) UNSIGNED DEFAULT 1,
            `meta_robots_adv` VARCHAR(191) DEFAULT NULL,
            `meta_keywords` VARCHAR(191) DEFAULT NULL,
            `canonical_url` VARCHAR(191) DEFAULT NULL,
            `seo_score` INT(3) UNSIGNED DEFAULT NULL,
            `readability_score` INT(3) UNSIGNED DEFAULT NULL,
            `score_analysis` TEXT DEFAULT NULL,
            `content_analysis` TEXT DEFAULT NULL,
            `social_title` VARCHAR(191) DEFAULT NULL,
            `social_desc` TEXT DEFAULT NULL,
            `social_img` VARCHAR(191) DEFAULT NULL,
            PRIMARY KEY (`id_ets_awu_cms_category`),
            UNIQUE KEY `ets_awu_ccsl` (id_cms_category, id_shop, id_lang)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $tbl_seo_meta = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_awu_meta` (
            `id_ets_awu_meta` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_meta` INT(10) UNSIGNED NOT NULL,
            `id_shop` INT(11) NOT NULL,
            `id_lang` INT(11) NOT NULL,
            `key_phrase` VARCHAR(191) DEFAULT NULL,
            `minor_key_phrase` VARCHAR(191) DEFAULT NULL,
            `allow_search` INT(1) UNSIGNED DEFAULT 2,
            `allow_flw_link` INT(1) UNSIGNED DEFAULT 1,
            `meta_robots_adv` VARCHAR(191) DEFAULT NULL,
            `meta_keywords` VARCHAR(191) DEFAULT NULL,
            `canonical_url` VARCHAR(191) DEFAULT NULL,
            `seo_score` INT(3) UNSIGNED DEFAULT NULL,
            `readability_score` INT(3) UNSIGNED DEFAULT NULL,
            `score_analysis` TEXT DEFAULT NULL,
            `content_analysis` TEXT DEFAULT NULL,
            `social_title` VARCHAR(191) DEFAULT NULL,
            `social_desc` TEXT DEFAULT NULL,
            `social_img` VARCHAR(191) DEFAULT NULL,
            PRIMARY KEY (`id_ets_awu_meta`),
            UNIQUE KEY `ets_awu_msl` (id_meta, id_shop, id_lang)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $tbl_seo_supplier = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_awu_supplier` (
            `id_ets_awu_supplier` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_supplier` INT(10) UNSIGNED NOT NULL,
            `id_shop` INT(11) NOT NULL,
            `id_lang` INT(11) NOT NULL,
            `key_phrase` VARCHAR(191) DEFAULT NULL,
            `minor_key_phrase` VARCHAR(191) DEFAULT NULL,
            `allow_search` INT(1) UNSIGNED DEFAULT 2,
            `allow_flw_link` INT(1) UNSIGNED DEFAULT 1,
            `meta_robots_adv` VARCHAR(191) DEFAULT NULL,
            `meta_keywords` VARCHAR(191) DEFAULT NULL,
            `canonical_url` VARCHAR(191) DEFAULT NULL,
            `seo_score` INT(3) UNSIGNED DEFAULT NULL,
            `readability_score` INT(3) UNSIGNED DEFAULT NULL,
            `score_analysis` TEXT DEFAULT NULL,
            `content_analysis` TEXT DEFAULT NULL,
            `social_title` VARCHAR(191) DEFAULT NULL,
            `social_desc` TEXT DEFAULT NULL,
            `social_img` VARCHAR(191) DEFAULT NULL,
            PRIMARY KEY (`id_ets_awu_supplier`),
            UNIQUE KEY `ets_awu_ssl` (id_supplier, id_shop, id_lang)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        $tbl_seo_manufacturer = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "ets_awu_manufacturer` (
            `id_ets_awu_manufacturer` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_manufacturer` INT(10) UNSIGNED NOT NULL,
            `id_shop` INT(11) NOT NULL,
            `id_lang` INT(11) NOT NULL,
            `key_phrase` VARCHAR(191) DEFAULT NULL,
            `minor_key_phrase` VARCHAR(191) DEFAULT NULL,
            `allow_search` INT(1) UNSIGNED DEFAULT 2,
            `allow_flw_link` INT(1) UNSIGNED DEFAULT 1,
            `meta_robots_adv` VARCHAR(191) DEFAULT NULL,
            `meta_keywords` VARCHAR(191) DEFAULT NULL,
            `canonical_url` VARCHAR(191) DEFAULT NULL,
            `seo_score` INT(3) UNSIGNED DEFAULT NULL,
            `readability_score` INT(3) UNSIGNED DEFAULT NULL,
            `score_analysis` TEXT DEFAULT NULL,
            `content_analysis` TEXT DEFAULT NULL,
            `social_title` VARCHAR(191) DEFAULT NULL,
            `social_desc` TEXT DEFAULT NULL,
            `social_img` VARCHAR(191) DEFAULT NULL,
            PRIMARY KEY (`id_ets_awu_manufacturer`),
            UNIQUE KEY `ets_awu_msl` (id_manufacturer, id_shop, id_lang)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
        return Db::getInstance()->execute($tbl_url_redirect)
        && Db::getInstance()->execute($tbl_seo_product)
        && Db::getInstance()->execute($tbl_seo_category)
        && Db::getInstance()->execute($tbl_seo_manufacturer)
        && Db::getInstance()->execute($tbl_seo_supplier)
        && Db::getInstance()->execute($tbl_seo_cms)
        && Db::getInstance()->execute($tbl_seo_cms_category)
        && Db::getInstance()->execute($tbl_seo_meta);
    }

    public function uninstallDb()
    {
        $tables = array(
            'ets_awu_redirect',
            'ets_awu_product',
            'ets_awu_category',
            'ets_awu_cms',
            'ets_awu_cms_category',
            'ets_awu_meta',
            'ets_awu_supplier',
            'ets_awu_manufacturer'
        );
        foreach($tables as $table)
        {
            Db::getInstance()->execute("DROP TABLE IF EXISTS `" . _DB_PREFIX_ .pSQL($table). "`");
        }
        return true;
    }

    public function getFieldConfig()
    {
        return array(
            'url_redirect_setting' => array(
                'ETS_AWU_ENABLE_URL_REDIRECT' => array(
                    'title' => $this->l('Enabled'),
                    'validation' => 'isBool',
                    'cast' => 'intval',
                    'type' => 'bool',
                    'default' => 0,
                    'no_multishop_checkbox' => true,
                    'desc' => $this->l('Enable or disable URL redirection for redirect rules defined below')
                ),
            ),
            'ps_extra' => array(
                'ETS_AWU_ENABLE_REMOVE_ID_IN_URL' => array(
                    'title' => $this->l('Remove ID in URL'),
                    'validation' => 'isBool',
                    'cast' => 'intval',
                    'type' => 'bool',
                    'default' => 0,
                ),
                'ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL' => array(
                    'title' => $this->l('Remove ISO code in URL for default language'),
                    'validation' => 'isBool',
                    'cast' => 'intval',
                    'type' => 'bool',
                    'default' => 0,
                ),
                'ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS' => array(
                    'title' => $this->l('Remove attribute alias in URL'),
                    'validation' => 'isBool',
                    'cast' => 'intval',
                    'type' => 'bool',
                    'default' => 0,
                ),
                'ETS_AWU_ENABLE_REDIRECT_NOTFOUND' => array(
                    'title' => $this->l('Redirect all old URLs to new URLs (keep your page rankings and backlinks)'),
                    'validation' => 'isBool',
                    'cast' => 'intval',
                    'type' => 'bool',
                    'default' => 1,
                ),
                'ETS_AWU_REDIRECT_STATUS_CODE' => array(
                    'title' => $this->l('Redirect type'),
                    'validation' => 'isInt',
                    'type' => 'select',
                    'identifier' => 'value',
                    'list' => array(
                        array(
                            'name' => $this->l('302 Moved Temporarily (recommended while setting up your store)'),
                            'value' => '302'
                        ),
                        array(
                            'name' => $this->l('301 Moved Permanently (recommended once you have gone live)'),
                            'value' => '301'
                        )
                    ),
                    'default' => '302',
                ),
            ),
            'sitemap_setting' => array(
                'ETS_AWU_ENABLE_XML_SITEMAP' => array(
                    'title' => $this->l('Enable sitemaps'),
                    'validation' => 'isBool',
                    'cast' => 'intval',
                    'type' => 'bool',
                    'default' => 1,
                    'no_multishop_checkbox' => true,

                ),
                'ETS_AWU_SITEMAP_PRIMARY' => array(
                    'title' => $this->l('Primary sitemap'),
                    'type' => 'text',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_LANG' => array(
                    'title' => $this->l('Sitemap by languages'),
                    'type' => 'text',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_PRIORITY' => array(
                    'title' => $this->l('Priority / Change frequency'),
                    'validation' => 'isUnsignedFloat',
                    'type' => 'text',
                    'default' => 0.5,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_OPTION' => array(
                    'title' => $this->l('Pages to include in sitemap'),
                    'type' => 'text',
                    'required' => 1,
                    'default' => 'product,category,cms,cms_category,manufacturer,supplier,meta',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_PROD_SITEMAP_LIMIT' => array(
                    'title' => $this->l('Number product per page in sitemap pagination'),
                    'validation' => 'isString',
                    'type' => 'text',
                    'default' => '1000',
                    'no_multishop_checkbox' => true,
                    'desc' => $this->l('Leave blank to include all products in one sitemap (not recommended for large catalog)'),
                ),
            ),
            'sitemap_value' => array(
                'ETS_AWU_SITEMAP_PRIORITY_PRODUCT' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 0.9,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_PRIORITY_CATEGORY' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 0.8,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_PRIORITY_CMS' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 0.1,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_PRIORITY_CMS_CATEGORY' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 0.1,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_PRIORITY_META' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 0.1,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_PRIORITY_SUPPLIER' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 0.1,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_PRIORITY_MANUFACTURER' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 0.1,
                    'no_multishop_checkbox' => true,
                ),
            ),
            'sitemap_freq' => array(
                'ETS_AWU_SITEMAP_FREQ_PRODUCT' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 'weekly',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_FREQ_CATEGORY' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 'weekly',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_FREQ_CMS' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 'weekly',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_FREQ_CMS_CATEGORY' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 'weekly',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_FREQ_META' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 'weekly',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_FREQ_SUPPLIER' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 'weekly',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_SITEMAP_FREQ_MANUFACTURER' => array(
                    'title' => '',
                    'type' => 'text',
                    'default' => 'weekly',
                    'no_multishop_checkbox' => true,
                ),
            ),
            'rss_setting' => array(
                'ETS_AWU_RSS_ENABLE' => array(
                    'title' => $this->l('Enable RSS feed'),
                    'validation' => 'isBool',
                    'cast' => 'intval',
                    'type' => 'bool',
                    'default' => 1,
                    'required' => true,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_RSS_OPTION' => array(
                    'title' => $this->l('Pages to include in RSS'),
                    'validation' => 'isString',
                    'type' => 'text',
                    'default' => 'product_category,cms_category,all_products,new_products,special_products,popular_products',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_RSS_CONTENT_BEFORE' => array(
                    'title' => $this->l('Content to put before each item in the feed'),
                    'validation' => 'isString',
                    'type' => 'textareaLang',
                    'rows' => 5,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_RSS_CONTENT_AFTER' => array(
                    'title' => $this->l('Content to put after each item in the feed'),
                    'validation' => 'isString',
                    'type' => 'textareaLang',
                    'rows' => 5,
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_RSS_LINK' => array(
                    'title' => $this->l('RSS link(s)'),
                    'type' => 'text',
                    'no_multishop_checkbox' => true,
                ),
                'ETS_AWU_RSS_POST_LIMIT' => array(
                    'title' => $this->l('Item limit (the number of latest added items to display)'),
                    'validation' => 'isString',
                    'type' => 'text',
                    'default' => '100',
                    'desc' => $this->l('Leave blank to display all items (not recommended for large catalog)'),
                    'no_multishop_checkbox' => true,
                ),
            ),
        );
    }

    public function urlRules()
    {
        return array(
            'category_rule' => array(
                'rule' => $this->getConfigRule('category_rule', '{id}-{rewrite}'),
                'new_rule' => $this->getConfigRule('category_rule', '{rewrite}', true),
                'desc_rule' => $this->l('Keywords: id* , rewrite , meta_keywords , meta_title'),
                'desc_new_rule' => $this->l('Keywords: id , rewrite* , meta_keywords'),
            ),
            'supplier_rule' => array(
                'rule' => $this->getConfigRule('supplier_rule', 'supplier/{id}-{rewrite}'),
                'new_rule' => $this->getConfigRule('supplier_rule', 'supplier/{rewrite}', true),
                'desc_rule' => $this->l('Keywords: id* , rewrite , meta_keywords , meta_title'),
                'desc_new_rule' => $this->l('Keywords: id , rewrite* , meta_keywords '),
            ),
            'manufacturer_rule' => array(
                'rule' => $this->getConfigRule('manufacturer_rule', 'brand/{id}-{rewrite}'),
                'new_rule' => $this->getConfigRule('manufacturer_rule', 'brand/{rewrite}', true),
                'desc_rule' => $this->l('Keywords: id* , rewrite , meta_keywords , meta_title'),
                'desc_new_rule' => $this->l('Keywords: id , rewrite* , meta_keywords'),
            ),
            'cms_rule' => array(
                'rule' => $this->getConfigRule('cms_rule', 'content/{id}-{rewrite}'),
                'new_rule' => $this->getConfigRule('cms_rule', 'content/{rewrite}', true),
                'desc_rule' => $this->l('Keywords: id* , rewrite , meta_keywords , meta_title'),
                'desc_new_rule' => $this->l('Keywords: id , rewrite* , meta_keywords'),
            ),
            'cms_category_rule' => array(
                'rule' => $this->getConfigRule('cms_category_rule', 'content/category/{id}-{rewrite}'),
                'new_rule' => $this->getConfigRule('cms_category_rule', 'content/category/{rewrite}', true),
                'desc_rule' => $this->l('Keywords: id* , rewrite , meta_keywords , meta_title'),
                'desc_new_rule' => $this->l('Keywords: id , rewrite* , meta_keywords'),
            ),
            'module' => array(
                'rule' => $this->getConfigRule('module', 'module/{module}{/:controller}'),
                'new_rule' => $this->getConfigRule('module', 'module/{module}{/:controller}', true),
                'desc_rule' => $this->l('Keywords: module* , controller*'),
                'desc_new_rule' => $this->l('Keywords: module* , controller*'),
            ),
            'product_rule' => array(
                'rule' => $this->getConfigRule('product_rule', $this->is17 ? '{category:/}{id}{-:id_product_attribute}-{rewrite}{-:ean13}.html' : '{category:/}{id}-{rewrite}{-:ean13}.html'),
                'new_rule' => $this->getConfigRule('product_rule', '{category}/{rewrite}', true),
                'desc_rule' => $this->is17 ? $this->l('Keywords: id* , id_product_attribute* , rewrite* , ean13 , category , categories , reference , meta_keywords , meta_title , manufacturer , supplier , price , tags') : $this->l('Keywords: id* , rewrite* , ean13 , category , categories , reference , meta_keywords , meta_title , manufacturer , supplier , price , tags'),
                'desc_new_rule' => $this->is17 ? $this->l('Keywords: id , id_product_attribute , rewrite* , ean13 , category, categories , reference , meta_keywords , manufacturer , supplier , price , tags') : $this->l('Keywords: id  , rewrite* , ean13 , category, categories , reference , meta_keywords , manufacturer , supplier , price , tags'),
            ),
            /* Must be after the product and category rules in order to avoid conflict */
            'layered_rule' => array(
                'rule' => $this->getConfigRule('layered_rule', '{id}-{rewrite}{/:selected_filters}'),
                'new_rule' => $this->getConfigRule('layered_rule', '{rewrite}/filter/{selected_filters}', true),
                'desc_rule' => $this->l('Keywords: id* , selected_filters* , rewrite , meta_keywords , meta_title'),
                'desc_new_rule' => $this->l('Keywords: id , selected_filters* , rewrite* , meta_keywords'),
            ),
        );
    }

    public function getConfigRule($rule, $default = null, $no_id = false)
    {

        $config = $this->seo_url_schema_configs();
        if ($no_id) {
            return ($data = Configuration::get($config[$rule]['no_id'])) && (($rule !== 'module' && !preg_match('/\{id\}/', $data)) || $rule == 'module') ? Configuration::get($config[$rule]['no_id']) : $default;
        }

        if (($nearest = Configuration::get($config[$rule]['name'])) && (($rule !== 'module' && preg_match('/\{id\}/', $nearest)) || $rule == 'module')) {
            return $nearest;
        } elseif (($old = Configuration::get($config[$rule]['old_name'])) && (($rule !== 'module' && preg_match('/\{id\}/', $old)) || $rule == 'module')) {
            return $old;
        } elseif (($root = Configuration::get($config[$rule]['root_name'])) && (($rule !== 'module' && preg_match('/\{id\}/', $root)) || $rule == 'module')) {
            return $root;
        }
        return $default;
    }

    public function seo_url_schema_configs()
    {
        return array(
            'category_rule' => array(
                'root_name' => 'ETS_AWU_ROOT_URL_CATEGORY_RULE',
                'old_name' => 'ETS_AWU_OLD_URL_CATEGORY_RULE',
                'name' => 'ETS_AWU_URL_CATEGORY_RULE',
                'no_id' => 'ETS_AWU_URL_NOID_CATEGORY_RULE',
                'default' => '{id}-{rewrite}'
            ),
            'supplier_rule' => array(
                'root_name' => 'ETS_AWU_ROOT_URL_SUPPLIER_RULE',
                'old_name' => 'ETS_AWU_OLD_URL_SUPPLIER_RULE',
                'name' => 'ETS_AWU_URL_SUPPLIER_RULE',
                'no_id' => 'ETS_AWU_URL_NOID_SUPPLIER_RULE',
                'default' => 'supplier/{id}-{rewrite}'
            ),
            'manufacturer_rule' => array(
                'root_name' => 'ETS_AWU_ROOT_URL_MANUF_RULE',
                'old_name' => 'ETS_AWU_OLD_URL_MANUF_RULE',
                'name' => 'ETS_AWU_URL_MANUF_RULE',
                'no_id' => 'ETS_AWU_URL_NOID_MANUF_RULE',
                'default' => 'brand/{id}-{rewrite}'
            ),
            'cms_rule' => array(
                'root_name' => 'ETS_AWU_ROOT_URL_CMS_RULE',
                'old_name' => 'ETS_AWU_OLD_URL_CMS_RULE',
                'name' => 'ETS_AWU_URL_CMS_RULE',
                'no_id' => 'ETS_AWU_URL_NOID_CMS_RULE',
                'default' => 'content/{id}-{rewrite}'
            ),
            'cms_category_rule' => array(
                'root_name' => 'ETS_AWU_ROOT_URL_CMS_CATEGORY_RULE',
                'old_name' => 'ETS_AWU_OLD_URL_CMS_CATEGORY_RULE',
                'name' => 'ETS_AWU_URL_CMS_CATEGORY_RULE',
                'no_id' => 'ETS_AWU_URL_NOID_CMS_CATEGORY_RULE',
                'default' => 'content/category/{id}-{rewrite}'
            ),
            'module' => array(
                'root_name' => 'ETS_AWU_ROOT_URL_MODULE_RULE',
                'old_name' => 'ETS_AWU_OLD_URL_MODULE_RULE',
                'name' => 'ETS_AWU_URL_MODULE_RULE',
                'no_id' => 'ETS_AWU_URL_NOID_MODULE_RULE',
                'default' => 'module/{module}{/:controller}'
            ),
            'product_rule' => array(
                'root_name' => 'ETS_AWU_ROOT_URL_PRODUCT_RULE',
                'old_name' => 'ETS_AWU_OLD_URL_PRODUCT_RULE',
                'name' => 'ETS_AWU_URL_PRODUCT_RULE',
                'no_id' => 'ETS_AWU_URL_NOID_PRODUCT_RULE',
                'default' => $this->is17 ? '{category:/}{id}{-:id_product_attribute}-{rewrite}{-:ean13}.html' : '{category:/}{id}-{rewrite}{-:ean13}.html'
            ),
            'layered_rule' => array(
                'root_name' => 'ETS_AWU_ROOT_URL_LAYERED_RULE',
                'old_name' => 'ETS_AWU_OLD_URL_LAYERED_RULE',
                'name' => 'ETS_AWU_URL_LAYERED_RULE',
                'no_id' => 'ETS_AWU_URL_NOID_LAYERED_RULE',
                'default' => '{id}-{rewrite}{/:selected_filters}'
            ),
        );
    }
    public function seo_advanced($type, $id, $context)
    {

        $seo_data = null;
        $config_allow_search = '';
        $indexLabel = $this->l('Allow search engines to show this Post in search results?');
        $followLabel = $this->l('Should search engines follow links on this Product?');
        switch ($type) {
            case 'product':
                $indexLabel = $this->l('Allow search engines to show this Product page in search results?');
                $followLabel = $this->l('Should search engines follow links on this Product?');
                $config_allow_search = (int)Configuration::get('ETS_AWU_PROD_SHOW_IN_SEARCH_RESULT');
                if ((int)$id)
                    $seo_data = EtsAwuProduct::getSeoProduct($id, $context);

                break;
            case 'cms':
                $indexLabel = $this->l('Allow search engines to show this CMS page in search results?');
                $followLabel = $this->l('Should search engines follow links on this CMS?');
                $config_allow_search = (int)Configuration::get('ETS_AWU_CMS_SHOW_IN_SEARCH_RESULT');
                if ((int)$id)
                    $seo_data = EtsAwuCms::getSeoCms($id, $context);
                break;
            case 'meta':
                $indexLabel = $this->l('Allow search engines to show this Meta page in search results?');
                $followLabel = $this->l('Should search engines follow links on this Meta?');
                $config_allow_search = (int)Configuration::get('ETS_AWU_META_SHOW_IN_SEARCH_RESULT');
                if ((int)$id)
                    $seo_data = EtsAwuMeta::getSeoMeta($id, $context);
                break;
            case 'category':
                $indexLabel = $this->l('Allow search engines to show this Category page in search results?');
                $followLabel = $this->l('Should search engines follow links on this Category?');
                $config_allow_search = (int)Configuration::get('ETS_AWU_CATEGORY_SHOW_IN_SEARCH_RESULT');
                if ((int)$id)
                    $seo_data = EtsAwuCategory::getSeoCategory($id, $context);
                break;
            case 'cms_category':
                $indexLabel = $this->l('Allow search engines to show this CMS category page in search results?');
                $followLabel = $this->l('Should search engines follow links on this CMS category?');
                $config_allow_search = (int)Configuration::get('ETS_AWU_CMS_CATE_SHOW_IN_SEARCH_RESULT');
                if ((int)$id)
                    $seo_data = EtsAwuCmsCategory::getSeoCmsCategory($id, $context);
                break;
            case 'manufacturer':
                $indexLabel = $this->l('Allow search engines to show this Brand page in search results?');
                $followLabel = $this->l('Should search engines follow links on this Brand?');
                $config_allow_search = (int)Configuration::get('ETS_AWU_MANUFACTURER_SHOW_IN_SEARCH_RESULT');
                if ((int)$id)
                    $seo_data = EtsAwuManufacturer::getSeoManufacturer($id, $context);
                break;
            case 'supplier':
                $indexLabel = $this->l('Allow search engines to show this Supplier page in search results?');
                $followLabel = $this->l('Should search engines follow links on this Supplier?');
                $config_allow_search = (int)Configuration::get('ETS_AWU_SUPPLIER_SHOW_IN_SEARCH_RESULT');
                if ((int)$id)
                    $seo_data = EtsAwuSupplier::getSeoSupplier($id, $context);
                break;
        }
        $data = array(
            'allow_search' => array(),
            'allow_flw_link' => array(),
            'meta_robots_adv' => array(),
            'canonical_url' => array(),
        );
        if ($seo_data) {
            foreach ($seo_data as $seo) {
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $data[$key][$seo['id_lang']] = $seo[$key];
                    } elseif ($key == 'meta_robots_adv') {
                        $data[$key][$seo['id_lang']] = '';
                    }

                }
            }
        }

        $indexOptions = array(

            array(
                'label' => $this->l('Yes'),
                'value' => 1,
            ),
            array(
                'label' => $this->l('No'),
                'value' => 0,
            ),
        );
        $advanceds =  array(
            'allow_search' => array(
                'label' => $indexLabel,
                'id' => 'ets_awu_allow_search_engine_show_post',
                'type' => 'select',
                'config_value' => $config_allow_search,
                'selected' => $data['allow_search'],
                'link_default' => $this->context->link->getAdminLink('AdminEtsSeoSearchAppearanceContentType', true),
                //'default_selected' => $config_allow_search,
                'options' => $indexOptions
            ),
            'allow_flw_link' => array(
                'label' => $followLabel,
                'id' => 'ets_awu_allow_search_engine_follow_links',
                'type' => 'radio',
                'checked' => $data['allow_flw_link'],
                'options' => array(
                    array(
                        'label' => $this->l('Yes'),
                        'value' => 1,
                        'id' => 'ets_awu_allow_search_engine_follow_links_yes'
                    ),
                    array(
                        'label' => $this->l('No'),
                        'value' => 0,
                        'id' => 'ets_awu_allow_search_engine_follow_links_no'
                    ),
                )
            ),
            'meta_robots_adv' => array(
                'label' => $this->l('Meta robots advanced'),
                'id' => 'ets_awu_meta_robots_advanced',
                'type' => 'select2',
                'options' => array(
                    array(
                        'label' => $this->l('Site-wide default'),
                        'value' => 'default',
                    ),
                    array(
                        'label' => $this->l('None'),
                        'value' => 'none',
                    ),
                    array(
                        'label' => $this->l('No Image index'),
                        'value' => 'noimageindex',
                    ),
                    array(
                        'label' => $this->l('No Archive'),
                        'value' => 'noarchive',
                    ),
                    array(
                        'label' => $this->l('No Snippet'),
                        'value' => 'nosnippet',
                    ),
                ),
                'selected' => $data['meta_robots_adv'],
                'multiple' => true,
                'desc' => $this->l('Advanced meta robots settings for this page.')
            ),
            'canonical_url' => array(
                'label' => $this->l('Canonical URL'),
                'id' => 'ets_awu_canonical_url',
                'type' => 'input_text',
                'value' => $data['canonical_url'],
                'desc' => $this->l('The canonical URL that this page should point to. Leave empty to default to current page link. Cross domain canonical (Opens in a new browser tab) supported too..')
            ),
        );
        if(!$this->module->is17)
            unset($advanceds['meta_robots_adv']);
        return $advanceds;
    }
    public static function getTextLang($text, $lang,$file_name='')
    {
        $moduleName = 'ets_awesomeurl';
        $text2 = preg_replace("/\\\*'/", "\'", $text);
        if(is_array($lang))
            $iso_code = $lang['iso_code'];
        elseif(is_object($lang))
            $iso_code = $lang->iso_code;
        else
        {
            $language = new Language($lang);
            $iso_code = $language->iso_code;
        }
        $modulePath = rtrim(_PS_MODULE_DIR_, '/').'/'.$moduleName;
        $fileTransDir = $modulePath.'/translations/'.$iso_code.'.'.'php';
        if(!@file_exists($fileTransDir)){
            return '';
        }
        $fileContent = Tools::file_get_contents($fileTransDir);
        $strMd5 = md5($text2);
        $keyMd5 = '<{' . $moduleName . '}prestashop>' .($file_name ? Tools::strtolower($file_name) : $moduleName). '_' . $strMd5;
        preg_match('/(\$_MODULE\[\'' . preg_quote($keyMd5) . '\'\]\s*=\s*\')(.*)(\';)/', $fileContent, $matches);
        if($matches && isset($matches[2])){
            return  $matches[2];
        }
        return '';
    }

}