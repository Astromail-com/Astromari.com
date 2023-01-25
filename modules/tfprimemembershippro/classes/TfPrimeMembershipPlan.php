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

class TfPrimeMembershipPlan extends ObjectModel
{
    // Shop Fields
    public $id_shop;
    public $id_shop_default;

    // Multi Lang Fields
    public $features;
    public $description;
    public $name;

    public $id_product;
    public $id_customer_group;
    public $type;
    public $duration;

    public $price;
    public $id_tax_rules_group;
    public $id_currency;
    public $allow_renew;
    public $allow_extend;
    public $active;
    public $date_add;
    public $date_upd;

    const TABLE_NAME = 'tf_prime_membership_plan';
    const TABLE_NAME2 = 'tf_prime_membership_customer';
    const TABLE_NAME3 = 'tf_prime_membership_plan_lang';
    const TABLE_NAME4 = 'tf_prime_membership_plan_compare';
    const TABLE_NAME5 = 'tf_prime_membership_plan_compare_lang';

    public static $definition = array(
        'table' => 'tf_prime_membership_plan',
        'primary' => 'id_tf_prime_membership_plan',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'id_shop_default' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'id_product' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'id_customer_group' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'type' => array(
                'type' => self::TYPE_STRING,
                'required' => true,
                'validate' => 'isGenericName'
            ),
            'duration' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'price' => array(
                'type' => self::TYPE_FLOAT,
                'validate' => 'isUnsignedFloat'
            ),
            'id_tax_rules_group' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_currency' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'allow_renew' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
            ),
            'allow_extend' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
            ),
            'img_name' => array(
                'type' => self::TYPE_STRING
            ),
            'active' => array(
                'type' => self::TYPE_INT,
            ),
            'date_add' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDateFormat',
                'required' => false
            ),
            'date_upd' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDateFormat',
                'required' => false
            ),
            /* Lang fields */
            'name' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isGenericName'
            ),
            'description' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isCleanHtml'
            ),
            'features' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isCleanHtml'
            ),
        ),
    );

    public function createMembershipProduct($price, $taxRule, $idProduct = false, $idShopDefault = false)
    {
        $product = new Product();
        if ($idProduct) {
            $product = new Product((int) $idProduct);
            if (!Validate::isLoadedObject($product)) {
                $product = new Product();
            }
        }
        $product->price = $price;
        $product->id_tax_rules_group = $taxRule;
        $languages = Language::getLanguages();

        $psDefaultLang = Configuration::get('PS_LANG_DEFAULT');
        $primeDefaultName = trim(Tools::getValue('name_'.$psDefaultLang));
        $primeDefaultDesc = trim(Tools::getValue('presta_description_'.$psDefaultLang));
        $primeDefaultShortDesc = trim(Tools::getValue('features_'.$psDefaultLang));

        foreach ($languages as $language) {
            $primeName = trim(Tools::getValue('name_'.$language['id_lang']));
            if ($primeName) {
                $product->name[$language['id_lang']] = $primeName;
                $product->link_rewrite[$language['id_lang']] = Tools::link_rewrite($primeName);
            } else {
                $product->name[$language['id_lang']] = $primeDefaultName;
                $product->link_rewrite[$language['id_lang']] = Tools::link_rewrite($primeDefaultName);
            }

            $description = trim(Tools::getValue('presta_description_'.$language['id_lang']));
            if ($description) {
                $product->description[$language['id_lang']] = $description;
            } else {
                $product->description[$language['id_lang']] = $primeDefaultDesc;
            }

            $descriptionshort = trim(Tools::getValue('features_'.$language['id_lang']));
            if ($descriptionshort) {
                $product->description_short[$language['id_lang']] = $descriptionshort;
            } else {
                $product->description_short[$language['id_lang']] = $primeDefaultShortDesc;
            }
        }

        $product->id_shop_default = $idShopDefault;
        $product->id_category_default = 2;
        $product->is_virtual = 1;
        $product->visibility = 'none';
        $product->quantity = 100000000;
        $product->available_date = '';
        $product->save();
        StockAvailable::setQuantity($product->id, 0, 100000000);
        foreach ($languages as $language) {
            Search::indexation($primeDefaultName, $product->id);
        }
        $product->addToCategories(array(2));
        return $product->id;
    }

    public function createPrimeCustomerGroup($idCustomerGroup = false)
    {
        $group = new Group();
        if ($idCustomerGroup) {
            $group = new Group($idCustomerGroup);
        }
        $group->name = array();
        $psDefaultLang = Configuration::get('PS_LANG_DEFAULT');
        $primeDefaultName = trim(Tools::getValue('name_'.$psDefaultLang));
        foreach (Language::getLanguages(true) as $lang) {
            $primeName = trim(Tools::getValue('name_'.$lang['id_lang']));
            if ($primeName) {
                $group->name[$lang['id_lang']] = $primeName;
            } else {
                $group->name[$lang['id_lang']] = $primeDefaultName;
            }
        }
        $group->reduction = 0.00;
        $group->price_display_method = 0;
        if ($idCustomerGroup) {
            $group->update();
        } else {
            $group->save();
        }
        $groupID = $group->id;

        $group->addModulesRestrictions(
            $groupID,
            $this->getAllModules(),
            $this->getAllShops()
        );
        return ($groupID > 0 ? $groupID : false);
    }

    public function getAllModules()
    {
        $modules = Db::getInstance()->executeS(
            'SELECT `id_module` FROM `'._DB_PREFIX_.'module`'
        );
        $arr = array();
        foreach ($modules as $data) {
            $arr[] = $data['id_module'];
        }
        return $arr;
    }

    public function getAllShops()
    {
        $shops = Db::getInstance()->executeS(
            'SELECT `id_shop` FROM `'._DB_PREFIX_.'shop`'
        );
        $arr = array();
        foreach ($shops as $data) {
            $arr[] = $data['id_shop'];
        }
        // $arr[] = 1;
        return $arr;
    }

    public function getPrimePlan($idLang, $idShop, $status = false)
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME.' p
            INNER JOIN '._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME3.' pl ON
                (p.id_tf_prime_membership_plan = pl.id_tf_prime_membership_plan)
            WHERE 1 AND pl.id_lang = '.(int) $idLang.' AND p.`id_shop` = '.(int) $idShop ;

        if ($status) {
            $sql .= ' AND active = 1';
        }

        return Db::getInstance()->executeS($sql);
    }

    public static function getPlanByIdProduct($idProduct)
    {
        return Db::getInstance()->getRow(
            'SELECT * FROM '._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME.'  p
            INNER JOIN '._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME3.' pl ON
                (p.id_tf_prime_membership_plan = pl.id_tf_prime_membership_plan)
            WHERE id_product = '.(int)$idProduct
        );
    }

    public static function getCustomerGroup($idPlan)
    {
        return Db::getInstance()->getValue(
            'SELECT `id_customer_group` FROM '._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME.'
                WHERE
                    `id_tf_prime_membership_plan` = '.(int) $idPlan
        );
    }

    public function createTable()
    {
        $tables[] = "CREATE TABLE IF NOT EXISTS "._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME2." (
            `id_tf_prime_membership_customer` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_shop` int(11) unsigned NOT NULL,
            `id_shop_default` int(11) unsigned NOT NULL,
            `id_plan` int(11) unsigned NOT NULL,
            `id_reference` int(11) unsigned NOT NULL DEFAULT 0,
            `id_customer` varchar(128) NOT NULL,
            `id_customer_group` varchar(128) NOT NULL,
            `type` varchar(255) character set utf8 NOT NULL,
            `duration` varchar(128) NOT NULL,
            `id_product` int(11) unsigned NOT NULL,
            `id_order` int(11) unsigned NOT NULL,
            `price` decimal(20,6) DEFAULT '0.000000',
            `id_currency` int(11) unsigned NOT NULL,
            `is_renew` int(2) unsigned NOT NULL DEFAULT 0,
            `is_extended` int(2) unsigned NOT NULL DEFAULT 0,
            `is_warning_sent` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `active` int(2) unsigned NOT NULL DEFAULT 0,
            `activated_date` datetime NOT NULL,
            `expiry_date` datetime NOT NULL,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_tf_prime_membership_customer`)
        ) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8";

        $tables[] = "CREATE TABLE IF NOT EXISTS "._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME." (
            `id_tf_prime_membership_plan` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_shop` int(11) unsigned NOT NULL,
            `id_shop_default` int(11) unsigned NOT NULL,
            `id_product` int(11) unsigned NOT NULL DEFAULT 0,
            `id_customer_group` varchar(128) NOT NULL,
            `type` varchar(255) character set utf8 NOT NULL,
            `duration` varchar(128) NOT NULL,
            `price` decimal(20,6) DEFAULT '0.000000',
            `id_tax_rules_group` int(11) DEFAULT '0',
            `id_currency` int(11) unsigned NOT NULL,
            `allow_renew` int(2) unsigned NOT NULL DEFAULT 0,
            `allow_extend` int(2) unsigned NOT NULL DEFAULT 0,
            `img_name` varchar(255) character set utf8 NULL,
            `active` int(2) unsigned NULL DEFAULT 0,
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_tf_prime_membership_plan`)
        ) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8";

        $tables[] = "CREATE TABLE IF NOT EXISTS "._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME3." (
            `id_tf_prime_membership_plan_lang` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_tf_prime_membership_plan` int(11) unsigned NOT NULL,
            `id_lang` int(11) unsigned NOT NULL DEFAULT 0,
            `name` varchar(255) character set utf8 NULL,
            `features` text,
            `description` text,
            PRIMARY KEY (`id_tf_prime_membership_plan_lang`, `id_tf_prime_membership_plan`)
        ) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8";

        $tables[] = "CREATE TABLE IF NOT EXISTS "._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME4." (
            `id_tf_prime_membership_plan_compare` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_tf_prime_membership_plan` int(11) unsigned NOT NULL,
            `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `date_add` datetime NOT NULL,
            `date_upd` datetime NOT NULL,
            PRIMARY KEY (`id_tf_prime_membership_plan_compare`)
        ) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8";

        $tables[] = "CREATE TABLE IF NOT EXISTS "._DB_PREFIX_.TfPrimeMembershipPlan::TABLE_NAME5." (
            `id_tf_prime_membership_plan_compare_lang` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `id_tf_prime_membership_plan_compare` int(11) unsigned NOT NULL,
            `id_lang` int(11) unsigned NOT NULL,
            `message` text,
            PRIMARY KEY (`id_tf_prime_membership_plan_compare_lang`)
        ) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8";

        foreach ($tables as $table) {
            if (!Db::getInstance()->execute($table)) {
                return false;
            }
        }
        return true;
    }
}
