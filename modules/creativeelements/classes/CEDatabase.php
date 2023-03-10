<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

defined('_PS_VERSION_') or die;

class CEDatabase
{
    private static $hooks = [
        'displayBackOfficeHeader',
        'displayHeader',
        'displayFooterProduct',
        'overrideLayoutTemplate',
        'CETemplate',
        // Actions
        'actionFrontControllerAfterInit',
        'actionFrontControllerInitAfter',
        'actionObjectCERevisionDeleteAfter',
        'actionObjectCETemplateDeleteAfter',
        'actionObjectCEThemeDeleteAfter',
        'actionObjectCEContentDeleteAfter',
        'actionObjectProductDeleteAfter',
        'actionObjectCategoryDeleteAfter',
        'actionObjectManufacturerDeleteAfter',
        'actionObjectSupplierDeleteAfter',
        'actionObjectCmsDeleteAfter',
        'actionObjectCmsCategoryDeleteAfter',
        'actionObjectYbc_blog_post_classDeleteAfter',
        'actionObjectXipPostsClassDeleteAfter',
        'actionObjectStBlogClassDeleteAfter',
        'actionObjectBlogPostsDeleteAfter',
        'actionObjectNewsClassDeleteAfter',
        'actionObjectTvcmsBlogPostsClassDeleteAfter',
        'actionProductAdd',
    ];

    public static function initConfigs()
    {
        $defaults = [
            // General
            'elementor_frontend_edit' => 1,
            'elementor_max_revisions' => 10,
            // Style
            'elementor_default_generic_fonts' => 'sans-serif',
            'elementor_container_width' => 1140,
            'elementor_space_between_widgets' => 20,
            'elementor_page_title_selector' => 'header.page-header',
            'elementor_page_wrapper_selector' => '#content, #wrapper, #wrapper .container',
            'elementor_viewport_lg' => 1025,
            'elementor_viewport_md' => 768,
            'elementor_global_image_lightbox' => 1,
            // Advanced
            'elementor_edit_buttons' => 'on',
            'elementor_exclude_modules' => json_encode([
                'administration',
                'analytics_stats',
                'billing_invoicing',
                'checkout',
                'dashboard',
                'export',
                'emailing',
                'i18n_localization',
                'migration_tools',
                'payments_gateways',
                'payment_security',
                'quick_bulk_update',
                'seo',
                'shipping_logistics',
                'market_place',
            ]),
            'elementor_load_fontawesome' => 1,
            'elementor_load_waypoints' => 1,
            'elementor_load_slick' => 1,
        ];
        foreach ($defaults as $key => $value) {
            Configuration::hasKey($key) or Configuration::updateValue($key, $value);
        }
        copy(_CE_PATH_ . 'views/lib/filemanager/config.php', _PS_IMG_DIR_ . 'cms/config.php');
        copy(_CE_PATH_ . 'views/lib/filemanager/.htaccess', _PS_IMG_DIR_ . 'cms/.htaccess');
    }

    public static function createTables()
    {
        $db = Db::getInstance();
        $ce_revision = _DB_PREFIX_ . 'ce_revision';
        $ce_template = _DB_PREFIX_ . 'ce_template';
        $ce_content = _DB_PREFIX_ . 'ce_content';
        $ce_theme = _DB_PREFIX_ . 'ce_theme';
        $ce_font = _DB_PREFIX_ . 'ce_font';
        $ce_meta = _DB_PREFIX_ . 'ce_meta';
        $engine = _MYSQL_ENGINE_;

        return $db->execute("
            CREATE TABLE IF NOT EXISTS `$ce_revision` (
                `id_ce_revision` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `parent` bigint(20) UNSIGNED NOT NULL,
                `id_employee` int(10) UNSIGNED NOT NULL,
                `title` varchar(255) NOT NULL,
                `type` varchar(64) NOT NULL DEFAULT '',
                `content` longtext NOT NULL,
                `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_ce_revision`),
                KEY `id` (`parent`),
                KEY `date_add` (`date_upd`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ") && $db->execute("
            CREATE TABLE IF NOT EXISTS `$ce_template` (
                `id_ce_template` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_employee` int(10) UNSIGNED NOT NULL,
                `title` varchar(128) NOT NULL DEFAULT '',
                `type` varchar(64) NOT NULL DEFAULT '',
                `content` longtext,
                `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
                `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
                `date_add` datetime NOT NULL,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_ce_template`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ") && $db->execute("
            CREATE TABLE IF NOT EXISTS `$ce_content` (
                `id_ce_content` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_employee` int(10) UNSIGNED NOT NULL,
                `id_product` int(10) UNSIGNED NOT NULL DEFAULT 0,
                `hook` varchar(64) NOT NULL DEFAULT '',
                `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
                `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
                `date_add` datetime NOT NULL,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_ce_content`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ") && $db->execute("
            CREATE TABLE IF NOT EXISTS `{$ce_content}_shop` (
                `id_ce_content` int(10) UNSIGNED NOT NULL,
                `id_shop` int(10) UNSIGNED NOT NULL,
                `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
                `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
                `date_add` datetime NOT NULL,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_ce_content`,`id_shop`),
                KEY `id_shop` (`id_shop`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ") && $db->execute("
            CREATE TABLE IF NOT EXISTS `{$ce_content}_lang` (
                `id_ce_content` int(10) UNSIGNED NOT NULL,
                `id_lang` int(10) UNSIGNED NOT NULL,
                `id_shop` int(10) UNSIGNED NOT NULL DEFAULT 1,
                `title` varchar(128) NOT NULL DEFAULT '',
                `content` longtext,
                PRIMARY KEY (`id_ce_content`,`id_shop`,`id_lang`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ") && $db->execute("
            CREATE TABLE IF NOT EXISTS `$ce_theme` (
                `id_ce_theme` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id_employee` int(10) UNSIGNED NOT NULL,
                `type` varchar(64) NOT NULL DEFAULT '',
                `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
                `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
                `date_add` datetime NOT NULL,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_ce_theme`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ") && $db->execute("
            CREATE TABLE IF NOT EXISTS `{$ce_theme}_shop` (
                `id_ce_theme` int(10) UNSIGNED NOT NULL,
                `id_shop` int(10) UNSIGNED NOT NULL,
                `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
                `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
                `date_add` datetime NOT NULL,
                `date_upd` datetime NOT NULL,
                PRIMARY KEY (`id_ce_theme`,`id_shop`),
                KEY `id_shop` (`id_shop`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ") && $db->execute("
            CREATE TABLE IF NOT EXISTS `{$ce_theme}_lang` (
                `id_ce_theme` int(10) UNSIGNED NOT NULL,
                `id_lang` int(10) UNSIGNED NOT NULL,
                `id_shop` int(10) UNSIGNED NOT NULL DEFAULT 1,
                `title` varchar(128) NOT NULL DEFAULT '',
                `content` text,
                PRIMARY KEY (`id_ce_theme`,`id_shop`,`id_lang`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ") && $db->execute("
            CREATE TABLE IF NOT EXISTS `$ce_font` (
                `id_ce_font` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `family` varchar(128) NOT NULL DEFAULT '',
                `files` text,
                PRIMARY KEY (`id_ce_font`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ") && $db->execute("
            CREATE TABLE IF NOT EXISTS `$ce_meta` (
                `id_ce_meta` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
                `name` varchar(255) DEFAULT NULL,
                `value` longtext,
                PRIMARY KEY (`id_ce_meta`),
                KEY `id` (`id`),
                KEY `name` (`name`)
            ) ENGINE=$engine DEFAULT CHARSET=utf8;
        ");
    }

    public static function updateTabs()
    {
        $id = (int) Tab::getIdFromClassName('IMPROVE');

        try {
            $pos = $id ? 1 : Tab::getInstanceFromClassName('AdminParentModules')->position;
            $parent = self::updateTab($id, $pos, 'AdminParentCEContent', true, ['en' => 'Creative Elements'], 'ce');

            self::updateTab($parent->id, 1, 'AdminCEThemes', true, [
                'en' => 'Theme Builder',
                'fr' => 'Constructeur de th??me',
                'es' => 'Maquetador de temas',
                'it' => 'Generatore di temi',
                'de' => 'Theme Builder',
                'pl' => 'Kreator motyw??w',
            ]);
            self::updateTab($parent->id, 2, 'AdminCEContent', true, [
                'en' => 'Content Anywhere',
                'fr' => 'Contenu n???importe o??',
                'es' => 'Contenido cualquier lugar',
                'it' => 'Contenuto Ovunque',
                'de' => 'Inhalt ??berall',
                'pl' => 'Tre???? w dowolnym miejscu',
            ]);
            self::updateTab($parent->id, 3, 'AdminCETemplates', true, [
                'en' => 'Saved Templates',
                'fr' => 'Mod??les enregistr??s',
                'es' => 'Plantillas guardadas',
                'it' => 'Template salvati',
                'de' => 'Gespeicherte Templates',
                'pl' => 'Zapisane szablony',
            ]);
            self::updateTab($parent->id, 4, 'AdminCEFonts', true, [
                'en' => 'Custom Fonts',
                'fr' => 'Polices personnalis??es',
                'es' => 'Fuentes personalizadas',
                'it' => 'Font Personalizzati',
                'de' => 'Eigene Schriftarten',
                'pl' => 'W??asne czcionki',
            ]);
            self::updateTab($parent->id, 5, 'AdminCESettings', true, [
                'en' => 'Settings',
                'fr' => 'R??glages',
                'es' => 'Ajustes',
                'it' => 'Impostazioni',
                'de' => 'Einstellungen',
                'pl' => 'Ustawienia',
            ]);
            self::updateTab($parent->id, 6, 'AdminCEEditor', false, [
                'en' => 'Live Editor',
                'fr' => '??diteur en direct',
                'es' => 'Editor en vivo',
                'it' => 'Editor live',
                'de' => 'Live Editor',
                'pl' => 'Edytor na ??ywo',
            ]);
        } catch (Exception $ex) {
            return false;
        }

        return true;
    }

    protected static function updateTab($id_parent, $position, $class, $active, array $name, $icon = '')
    {
        $id = (int) Tab::getIdFromClassName($class);
        $tab = new Tab($id);
        $tab->id_parent = $id_parent;
        $tab->position = (int) $position;
        $tab->module = 'creativeelements';
        $tab->class_name = $class;
        $tab->active = $active;
        $tab->icon = $icon;
        $tab->name = [];

        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[$lang['id_lang']] = isset($name[$lang['iso_code']]) ? $name[$lang['iso_code']] : $name['en'];
        }

        if (!$tab->save()) {
            throw new Exception('Can not save Tab: ' . $class);
        }

        if (!$id && $tab->position != $position) {
            $tab->position = (int) $position;
            $tab->update();
        }

        return $tab;
    }

    public static function getHooks($all = true)
    {
        $hooks = self::$hooks;

        if ($all) {
            $ce_content = _DB_PREFIX_ . 'ce_content';
            $rows = Db::getInstance()->executeS("SELECT DISTINCT hook FROM $ce_content");

            if (!empty($rows)) {
                foreach ($rows as &$row) {
                    $hook = $row['hook'];

                    if ($hook && !in_array($hook, $hooks)) {
                        $hooks[] = $hook;
                    }
                }
            }
        }
        return $hooks;
    }
}
