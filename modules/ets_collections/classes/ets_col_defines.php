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

class Ets_col_defines
{
    public static $instance;
    public function __construct()
    {
        $this->context = Context::getContext();
        if (is_object($this->context->smarty)) {
            $this->smarty = $this->context->smarty;
        }
    }
    public static function getInstance()
    {
        if (!(isset(self::$instance)) || !self::$instance) {
            self::$instance = new Ets_col_defines();
        }
        return self::$instance;
    }
    public function _installDb()
    {
        Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_col_collection` ( 
        `id_ets_col_collection` INT(11) NOT NULL AUTO_INCREMENT , 
        `active` INT(1) NOT NULL ,
        `views` INT(11) NOT NULL ,
        `position` INT(11) NOT NULL ,
        `id_shop` INT(1) NOT NULL ,
        `date_add` datetime ,
        PRIMARY KEY (`id_ets_col_collection`))
        ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
        Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_col_collection_lang` ( 
        `id_ets_col_collection` INT(11) NOT NULL,
        `id_lang` INT(11) NOT NULL,  
        `name` varchar(1000),
        `meta_title` varchar(1000),
        `meta_description` text,
        `link_rewrite` varchar(1000),
        `description` text,
        `image` varchar(222) , 
        `thumb` varchar(222) ,PRIMARY KEY (`id_ets_col_collection`,`id_lang`))
        ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
        Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ets_col_collection_product` ( 
        `id_ets_col_collection` INT(11) NOT NULL , 
        `id_product` INT(1) NOT NULL ,
        `position` INT(11) NOT NULL ,
        `views` INT(11) NOT NULL ,
         PRIMARY KEY (`id_ets_col_collection`,`id_product`))
        ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
        Db::getInstance()->execute('CREATE TABLE `'._DB_PREFIX_.'ets_col_collection_display` ( 
        `id_ets_col_collection` INT(11) NOT NULL , 
        `hook_display` VARCHAR(30) NOT NULL , 
        `list_layout` VARCHAR(10) NOT NULL , 
        `per_row_desktop` INT(1) NOT NULL , 
        `per_row_mobile` INT(1) NOT NULL , 
        `per_row_tablet` INT(1) NOT NULL , 
        `sort_order` VARCHAR(10),
        `active` INT(1) NOT NULL , 
        INDEX (`id_ets_col_collection`), 
        INDEX (`hook_display`)) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
        Db::getInstance()->execute('CREATE TABLE `'._DB_PREFIX_.'ets_col_collection_order` ( 
        `id_ets_col_collection` INT(11) NOT NULL , 
        `id_product` INT(11) NOT NULL , 
        `id_product_attribute` INT(11) NOT NULL , 
        `id_order` INT(11) NOT NULL , 
        `quantity` INT(11) NOT NULL , 
        `total_price` DECIMAL(10,2) NOT NULL , 
        `total_price_tax_incl` DECIMAL(10,2) NOT NULL , 
        `date_add` DATETIME NOT NULL , 
        PRIMARY KEY (`id_ets_col_collection`, `id_product`,`id_product_attribute`, `id_order`)) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
        Db::getInstance()->execute('CREATE TABLE `'._DB_PREFIX_.'ets_col_collection_view` ( 
        `id_ets_col_collection` INT(11) NOT NULL , 
        `id_product` INT(11) NOT NULL , 
        `ip` VARCHAR(32) NOT NULL , 
        `date_add` DATETIME NOT NULL , 
        PRIMARY KEY (`id_ets_col_collection`, `id_product`, `ip`)) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');
        return true;
    }
    public function _uninstallDb()
    {
        return Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'ets_col_collection')
            && Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'ets_col_collection_lang')
            && Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'ets_col_collection_display')
            && Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'ets_col_collection_product')
            && Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'ets_col_collection_order')
            && Db::getInstance()->execute('DROP TABLE IF EXISTS ' . _DB_PREFIX_ . 'ets_col_collection_view');
    }
    public function getCategoriesTree($id_root=0)
    {
        if(!$id_root)
        {
            $id_root = Db::getInstance()->getValue('SELECT c.id_category FROM `'._DB_PREFIX_.'category` c
            INNER JOIN `'._DB_PREFIX_.'category_shop` cs ON (c.id_category = cs.id_category AND cs.id_shop="'.(int)$this->context->shop->id.'")
            WHERE c.active=1 AND is_root_category=1');
        }
        $sql ='SELECT * FROM `'._DB_PREFIX_.'category` c
        INNER JOIN `'._DB_PREFIX_.'category_shop` cs ON (c.id_category = cs.id_category AND cs.id_shop="'.(int)$this->context->shop->id.'")
        LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.id_category=cl.id_category AND cl.id_lang ="'.(int)$this->context->language->id.'" AND cl.id_shop="'.(int)$this->context->shop->id.'")
        WHERE c.id_category = "'.(int)$id_root.'" AND c.active=1 GROUP BY c.id_category';
        $tree=array();
        if($category = Db::getInstance()->getRow($sql))
        {
            $cat = array(
                'name' => $category['name'],
                'id_category' => $category['id_category']
            );
            $temp = array();
            $Childrens = $this->getChildrenCategories($category['id_category']);
            if($Childrens)
            {
                foreach($Childrens as $children)
                {
                    $arg = $this->getCategoriesTree($children['id_category']);
                    if($arg && isset($arg['0']))
                    {
                        $temp[] = $arg[0];
                    }
                }
            }
            $cat['children'] = $temp;
            $tree[] = $cat;
        }
        return $tree;
    }
    public function getChildrenCategories($id_parent)
    {
        $sql = 'SELECT c.id_category,cl.name FROM `'._DB_PREFIX_.'category` c
        INNER JOIN `'._DB_PREFIX_.'category_shop` cs ON (c.id_category = cs.id_category AND cs.id_shop="'.(int)$this->context->shop->id.'")
        LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.id_category = cl.id_category AND cl.id_lang="'.(int)$this->context->language->id.'" AND cl.id_shop="'.(int)$this->context->shop->id.'")
        WHERE c.id_parent="'.(int)$id_parent.'" AND c.active=1
        ';
        return Db::getInstance()->executeS($sql);
    }
    public static function getImageByIdProduct($id_product,$type='home')
    {
        if(version_compare(_PS_VERSION_, '1.7', '>='))
            $type_image= ImageType::getFormattedName($type);
        else
            $type_image= ImageType::getFormatedName($type);
        $product = new Product($id_product,false,Context::getContext()->language->id);
        if(!$id_image = (int)Db::getInstance()->getValue('SELECT id_image FROM `'._DB_PREFIX_.'image` WHERE id_product="'.(int)$id_product.'" AND cover=1'))
            $id_image = (int)Db::getInstance()->getValue('SELECT id_image FROM `'._DB_PREFIX_.'image` WHERE id_product ='.(int)$id_product);
        if($id_image)
        {
            return  Context::getContext()->link->getImageLink($product->link_rewrite, $id_image, $type_image);
        }
        return '';
    }
}