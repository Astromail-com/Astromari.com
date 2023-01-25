<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
exit;

/** Call Cdesigner Models **/
include_once(_PS_MODULE_DIR_.'cdesigner/models/CdesignerFontsModel.php');
include_once(_PS_MODULE_DIR_.'cdesigner/models/CdesignerColorsModel.php');
include_once(_PS_MODULE_DIR_.'cdesigner/models/CdesignerImagesModel.php');
include_once(_PS_MODULE_DIR_.'cdesigner/models/CdesignerImagesModelEmojis.php');
include_once(_PS_MODULE_DIR_.'cdesigner/models/CdesignerFieldsModel.php');

/** Define Class Cdesigner **/
class Cdesigner extends Module
{
    /** Init Constructor **/
    public function __construct()
    {
        $this->name = 'cdesigner';
        $this->tab = 'front_office_features';
        $this->version = '3.2.0';
        $this->author = 'Prestaeg';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        parent::__construct();
        $this->module_key = 'c619c66f3753b5515048ce79f8925060';
        $this->displayName = $this->l('Custom Product Designer');
        $this->module_key = '';
        $this->description = $this->l('Helps your customers to create there unique custom product');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall cdesigner?');
    }


    /** Function Install Module **/
    public function install()
    {
        if (parent::install()
            && $this->registerHook('actionShopDataDuplication')
            && $this->registerHook('displayHeader')
            && $this->registerHook('actionValidateOrder')
            && $this->registerHook('displayAdminOrder')
            && $this->registerHook('displayAdminProductsExtra')
            && $this->registerHook('actionProductUpdate')
            && $this->registerHook('displayFooterProduct')
            && Configuration::updateValue('extra_mask', '')
            && Configuration::updateValue('extra_image', '')
            && Configuration::updateValue('extra_active', '')
            && Configuration::updateValue('main_color', '#f34968')
        )
        {
            $this->setDataBase('add');
            $this->installDemo();
            $conf = Configuration::updateValue('redirect_URI', Tools::getHttpHost(true).__PS_BASE_URI__.'modules/cdesigner/api');
            return (bool)$conf;
        }
        return false;
    }

    /** Function Uninstall Module **/
    public function uninstall()
    {
        if (!parent::uninstall()) return false;

        Configuration::deleteByName('redirect_URI');
        Configuration::deleteByName('client_id');
        Configuration::deleteByName('app_id');
        Configuration::deleteByName('secret_id');
        Configuration::deleteByName('client_secret');
        $this->deleteImg();
        return $this->setDataBase('delete');
    }

    /** Function Install Demo Cdesigner **/
    private function installDemo()
    {
        $this->addDemoFonts();
        $this->addDemoColors();
        //$this->addDemoDefaultsImages();
    }

    /**  Function Set DataBase **/
    private function setDataBase($action)
    {
        switch ($action)
        {
            case 'add':
                $sql = Db::getInstance()->execute('
                                CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'cdesigner_output_design(
                                    `key_product_output` varchar(100) NOT NULL,
                                    `uri_phone_output` varchar(3000) CHARACTER SET utf8,
                                    `uri_img_to_print` varchar(3000) CHARACTER SET utf8,
                                    `font_canvas` varchar(3000) CHARACTER SET utf8,
                                    `img_canvas` varchar(3000) CHARACTER SET utf8,
                                    `size_canvas` varchar(255) CHARACTER SET utf8,
                                    `font_canvas_2` varchar(3000) CHARACTER SET utf8,
                                    `img_canvas_2` varchar(3000) CHARACTER SET utf8,
                                    `size_canvas_2` varchar(255) CHARACTER SET utf8,
                                     PRIMARY KEY (`key_product_output`)
                                )
                            ');

                $sql &= Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'cdesigner_cfields` (
                              `id_cdesigner_cfields` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `id_product` INT( 11 ) UNSIGNED NOT NULL,
                              `type_layout` varchar(2000) NOT NULL,
                              `type_color` varchar(2000) NOT NULL,
                              `type_image` varchar(2000) NOT NULL,
                              `type_perso` varchar(255) NOT NULL,
                              `textarea` TEXT NOT NULL,
                              `image` varchar(255) NOT NULL,
                              `mask` varchar(255) NOT NULL,
                              `active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
                              `image_2` varchar(255) NOT NULL,
                              `mask_2` varchar(255) NOT NULL,
                              `zone_1` varchar(255) NOT NULL,
                              `zone_2` varchar(255) NOT NULL,
                              `fonts` varchar(255) NOT NULL,
                              `design_pre` varchar(2000) NOT NULL,
                              `design_pre_2` varchar(2000) NOT NULL,
                              `price_per_side` varchar(255) NOT NULL,
                              `price_per_image` varchar(255) NOT NULL,
                              `price_per_text` varchar(255) NOT NULL,
                              `active_2` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
                              `active_design` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
                              `active_bg` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
                              `allow_upload` tinyint(1) unsigned NOT NULL DEFAULT \'1\',
                              `allow_help` tinyint(1) unsigned NOT NULL DEFAULT \'1\',
                              `required_field` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
                              `allow_zone` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
                              `allow_comb` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
                              PRIMARY KEY (`id_cdesigner_cfields`),
                              UNIQUE  `BELVG_SAMPLE_UNIQ` (  `id_product` )
                            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8');

                $sql &= Db::getInstance()->execute('
                            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'cdesigner_combination` (
                              `id_custom_output` varchar(255) NOT NULL,
                              `id_custom_product` varchar(255) NOT NULL,
                              `id_combination` varchar(255) NOT NULL,
                              PRIMARY KEY (`id_custom_output`)
                            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
                        ');

                $sql &= Db::getInstance()->execute('
                            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'cdesigner_fonts` (
                              `id_font` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `title` varchar(255) NOT NULL,
                              `url_font` varchar(255) NOT NULL,
                              `woff` varchar(255) NOT NULL,
                              `woff2` varchar(255) NOT NULL,
                              `eot` varchar(255) NOT NULL,
                              `svg` varchar(255) NOT NULL,
                              `ttf` varchar(255) NOT NULL,
                              PRIMARY KEY (`id_font`)
                            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
                        ');

                $sql &= Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'cdesigner_user_design(
                                                    `id_user` varchar(255) CHARACTER SET utf8,
                                                    `id_design` varchar(255) CHARACTER SET utf8,
                                                    `url_design` varchar(255) CHARACTER SET utf8 )');

                $sql &= Db::getInstance()->execute('
                            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'cdesigner_colors` (
                              `id_color` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `color` varchar(255) NOT NULL,
                              PRIMARY KEY (`id_color`)
                            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
                        ');

                $sql &= Db::getInstance()->execute('
                            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'cdesigner_defaults_img` (
                              `id_img` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `image` varchar(255) NOT NULL,
                              `id_tag` varchar(255) NOT NULL,
                              PRIMARY KEY (`id_img`)
                            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
                        ');

                $sql &= Db::getInstance()->execute('
                            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'cdesigner_defaults_img_lang` (
                              `id_img` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `id_lang` int(10) unsigned NOT NULL,
                              `tags` varchar(500) NOT NULL,
                              PRIMARY KEY (`id_img`,`id_lang`)
                            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
                        ');
                $sql &= Db::getInstance()->execute('
                            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'cdesigner_defaults_img_emojis` (
                              `id_img` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `image` varchar(255) NOT NULL,
                              PRIMARY KEY (`id_img`)
                            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
                        ');

                $sql &= Db::getInstance()->execute('
                            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'cdesigner_defaults_img_emojis_lang` (
                              `id_img` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `id_lang` int(10) unsigned NOT NULL,
                              `tags` varchar(500) NOT NULL,
                              PRIMARY KEY (`id_img`,`id_lang`)
                            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
                        ');
                return $sql;
            break;

            case 'delete':
                return Db::getInstance()->execute('
                    DROP TABLE IF EXISTS `'._DB_PREFIX_.'cdesigner_output_design`,
                    `'._DB_PREFIX_.'cdesigner_combination`,
                    `'._DB_PREFIX_.'cdesigner_fonts`,
                    `'._DB_PREFIX_.'cdesigner_colors`,
                    `'._DB_PREFIX_.'cdesigner_defaults_img`,
                    `'._DB_PREFIX_.'cdesigner_defaults_img_lang`,
                    `'._DB_PREFIX_.'cdesigner_defaults_img_emojis`,
                    `'._DB_PREFIX_.'cdesigner_defaults_img_lang_emojis`,
                    `'._DB_PREFIX_.'cdesigner_cfields`;
                ');
            break;
        }
        return true;
    }

    /**  Function Remove Product **/
    private function removeProduct()
    {
        $id_product = Configuration::get('cdesigner_ID_PRODUCT');
        Configuration::deleteByName('cdesigner_ID_PRODUCT');
        return @Product::deleteSelection(array($id_product));
    }

    private function getPredefinedImages(){
        $images_def = new CdesignerImagesModel();
        return $images_def->getImages();
    }

    public function hookExtraFlag($id_product) {
      /* {hook h="extraFlag" id_product=$product.id} to put in theme */
      $sampleObj = CdesignerFieldsModel::loadByIdProduct( $id_product['id_product'] );
      if(is_numeric($sampleObj->id)){
        return $this->display(__FILE__, 'views/templates/front/extraflag.tpl');
      }
    }

    /**  Function Hook display Product Extra **/
    public function hookDisplayAdminProductsExtra($params) {
        $id_product = $params['id_product'];
        $sampleObj = CdesignerFieldsModel::loadByIdProduct($id_product);
        $fonts = new CdesignerFontsModel();
        $fonts_list = $fonts->getFonts();
        $fonts_array = explode('|', $sampleObj->fonts);
        $type_layout = explode('|', $sampleObj->type_layout);
        $type_color = explode('|', $sampleObj->type_color);
        $type_image = explode('|', $sampleObj->type_image);
        $type_perso = $sampleObj->type_perso;
        $design_pre = $sampleObj->design_pre;
        $design_pre_2 = $sampleObj->design_pre_2;

        $tags_images = $this->getTagsImage();
        $tab_tags_image = array();
        $tab_tags_check = array();
        foreach ($tags_images as $key => $value) {
            $str_low = Tools::strtolower($value['tags']);

            if( !empty($str_low) && !in_array($str_low, $tab_tags_check) ) {
                $tab_tags_check[] = $str_low;
                $tab_tags_image[] = array( $value['id_tag'] ,$str_low );
            }
        }

        $allImages = $this->getPredefinedImages();
        $layout = $this->getLayouts();
        $currency = $this->context->currency->sign;

        $colors = new CdesignerColorsModel();
        $colors_list = $colors->getColors();

        if(is_numeric($sampleObj->id)){
            if( ! empty( $sampleObj->zone_1 ) )
            {
                $area_1 = explode(';', $sampleObj->zone_1);

                $top_1 = ( is_numeric( $area_1[0] ) ) ? $area_1[0] : '0';
                $left_1 = ( is_numeric( $area_1[1] ) ) ? $area_1[1] : '0';
                $right_1 = ( is_numeric( $area_1[2] ) ) ? $area_1[2] : '0';
                $bottom_1 = ( is_numeric( $area_1[3] ) ) ? $area_1[3] : '0';
            }
            else
                $top_1 = $left_1 = $right_1 = $bottom_1 = 0;

            if( ! empty( $sampleObj->zone_2 ) )
            {
                $area_2 = explode(';', $sampleObj->zone_2);

                $top_2 = ( is_numeric( $area_2[0] ) ) ? $area_2[0] : '0';
                $left_2 = ( is_numeric( $area_2[1] ) ) ? $area_2[1] : '0';
                $right_2 = ( is_numeric( $area_2[2] ) ) ? $area_2[2] : '0';
                $bottom_2 = ( is_numeric( $area_2[3] ) ) ? $area_2[3] : '0';
            }
            else
                $top_2 = $left_2 = $right_2 = $bottom_2 = 0;

            $this->context->smarty->assign(array(
                'cdesigner_textarea' => $sampleObj->textarea,
                'extra_image' => $sampleObj->image,
                'extra_mask' => $sampleObj->mask,
                'type_layout' => $type_layout,
                'type_color' => $type_color,
                'alllayouts' => $layout,
                'type_image' => $type_image,
                'type_perso' => $type_perso,
                'allimages' => $allImages,
                'fonts' => $fonts_array,
                'allfonts' => $fonts_list,
                'top_1' => $top_1,
                'left_1' => $left_1,
                'right_1' => $right_1,
                'bottom_1' => $bottom_1,

                'top_2' => $top_2,
                'left_2' => $left_2,
                'right_2' => $right_2,
                'bottom_2' => $bottom_2,

                'extra_active' => $sampleObj->active,
                'extra_design' => $sampleObj->active_design,
                'active_bg' => $sampleObj->active_bg,
                'allow_upload' => $sampleObj->allow_upload,
                'allow_help' => $sampleObj->allow_help,
                'allow_zone' => $sampleObj->allow_zone,
                'allow_comb' => $sampleObj->allow_comb,
                'required_field' => $sampleObj->required_field,

                'extra_image_2' => $sampleObj->image_2,
                'extra_mask_2' => $sampleObj->mask_2,
                'extra_active_2' => $sampleObj->active_2,

                'price_per_side' => ( $sampleObj->price_per_side != '') ?  $sampleObj->price_per_side : '0' ,
                'price_per_image' => ( $sampleObj->price_per_image != '') ?  $sampleObj->price_per_image : '0' ,
                'price_per_text' => ( $sampleObj->price_per_text != '') ?  $sampleObj->price_per_text : '0' ,
                'design_pre' => $design_pre,
                'design_pre_2' => $design_pre_2,
                'image_baseurl' => $this->_path.'views/img/files/',
                'image_folder_baseurl' => $this->_path.'views/img/',
                'url_base' => $this->_path,
                'currency' => $currency,
                'urls_site' => Tools::getHttpHost(true) . __PS_BASE_URI__,
                'colors' => $colors_list,
                'allTags' => $tab_tags_image
            ));
        }
        else{
            $this->context->smarty->assign(array(
                'image_baseurl' => $this->_path.'views/img/files/',
                'image_folder_baseurl' => $this->_path.'views/img/',
                'url_base' => $this->_path,
                'fonts' => $fonts_array,
                'allfonts' => $fonts_list,
                'type_layout' => $type_layout,
                'type_color' => $type_color,
                'alllayouts' => $layout,
                'allimages' => $allImages,
                'type_image' => $type_image,
                'currency' => $currency,
                'price_per_side' => '0',
                'price_per_image' => '0',
                'price_per_text' => '0',
                'top_1' => '0',
                'left_1' => '0',
                'right_1' => '100',
                'bottom_1' => '100',
                'top_2' => '0',
                'left_2' => '0',
                'right_2' => '100',
                'bottom_2' => '100',
                'urls_site' => Tools::getHttpHost(true) . __PS_BASE_URI__,
                'colors' => $colors_list,
                'allTags' => $tab_tags_image
            ));
        }

        return $this->display(__FILE__, 'views/templates/admin/cdesigner_fields.tpl');
    }

    /**  Function Hook display Product **/
    public function hookActionProductUpdate($params) {
        $helper = (int)Tools::getValue('helper-id');
        $enabled_clicked = (int)Tools::getValue('enabled_clicked');
        $errors = '';

        if( is_numeric($helper) && $helper == 1 ){
            $id_product = $params['id_product'];
            if( is_numeric($id_product) ){
                $sampleObj = CdesignerFieldsModel::loadByIdProduct($id_product);
                $sampleObj->active = (bool)Tools::getValue('extra_active');
                $sampleObj->active_2 = (bool)Tools::getValue('extra_active_2');
                $sampleObj->active_design = (bool)Tools::getValue('extra_design');
                $sampleObj->active_bg = (bool)Tools::getValue('active_bg');
                $sampleObj->allow_upload = (bool)Tools::getValue('allow_upload');
                $sampleObj->allow_help = (bool)Tools::getValue('allow_help');
                $sampleObj->allow_zone = (bool)Tools::getValue('allow_zone');
                $sampleObj->allow_comb = (bool)Tools::getValue('allow_comb');
                $sampleObj->required_field = (bool)Tools::getValue('required_field');

                $sampleObj->id_product = $id_product;
                $sampleObj->zone_1 = Tools::getValue('zone-1');
                $sampleObj->zone_2 = Tools::getValue('zone-2');

                $sampleObj->price_per_side = Tools::getValue('price_per_side');
                $sampleObj->price_per_image = Tools::getValue('price_per_image');
                $sampleObj->price_per_text = Tools::getValue('price_per_text');

                $sampleObj->design_pre = Tools::getValue('design_pre');
                $sampleObj->design_pre_2 = Tools::getValue('design_pre_2');

                $fonts_string = implode('|',Tools::getValue('fonts', array('') ));
                $sampleObj->fonts = $fonts_string;

                $layout_string = implode('|',Tools::getValue('layouts', array('all') ));
                $sampleObj->type_layout = $layout_string;

                $color_string = implode('|',Tools::getValue('colors_data', array('all') ));
                $sampleObj->type_color = $color_string;

                $images_string = implode('|',Tools::getValue('images', array('') ));
                $sampleObj->type_image = $images_string;

                $sampleObj->type_perso = Tools::getValue('type_perso');

                if( Tools::getValue('extra_image') != '' ){
                    $sampleObj->image = Tools::getValue('extra_image');
                }
                if( Tools::getValue('extra_mask') != '' ){
                    $sampleObj->mask = Tools::getValue('extra_mask');
                }

                if( Tools::getValue('extra_image_2') != '' ){
                    $sampleObj->image_2 = Tools::getValue('extra_image_2');
                }
                if( Tools::getValue('extra_mask_2') != '' ){
                    $sampleObj->mask_2 = Tools::getValue('extra_mask_2');
                }
                if(!empty($sampleObj) && isset($sampleObj->id)){
                    $sampleObj->update();
                } else {
                    $sampleObj->add();
                }

                /*
                if( $enabled_clicked == 1 ) {
                    //Add One CustomizeTextfield
                    Db::getInstance()->execute('UPDATE `' . _DB_PREFIX_ . 'customization_field` cf
                        SET cf.`is_deleted` = 1
                        WHERE
                        cf.`id_product` = ' . (int) $id_product . '
                        AND cf.`is_deleted` = 0
                        AND cf.`type` = 1 ');
                    $customization_field = new CustomizationField();
                    $customization_field->id_product = $id_product;
                    $customization_field->type = 1;
                    $customization_field->required = 0;
                    $customization_field->is_module = 0;
                    $customization_field->is_deleted = 0;
                    $languages = Language::getLanguages(false);
                    $key_1 = 0;
                    foreach ($languages as $key_1 => $language)
                    {
                        $customization_field->name[(int) $language['id_lang']] = $this->l('Custom Design');
                    }
                    $customization_field->add();
                }*/
            }
        }
    }

    private function getTagsImage(){
        $id_lang = $this->context->language->id;
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                SELECT  a.`id_img`, a.`id_tag`, b.`tags`
                FROM '._DB_PREFIX_.'cdesigner_defaults_img a
                LEFT JOIN '._DB_PREFIX_.'cdesigner_defaults_img_emojis_lang b ON (a.id_tag = b.id_img)
                WHERE b.id_lang = '.(int)$id_lang .' ORDER BY b.`tags` ASC');
    }

    private function getTagsImageEmojis(){
        $id_lang = $this->context->language->id;
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                SELECT  b.`tags`
                FROM '._DB_PREFIX_.'cdesigner_defaults_img_emojis a
                LEFT JOIN '._DB_PREFIX_.'cdesigner_defaults_img_emojis_lang b ON (a.id_img = b.id_img)
                WHERE b.id_lang = '.(int)$id_lang.'
                ');
    }

    /**  Function Hook display Footer Product **/
    public function hookDisplayFooterProduct($params) {
        $id_product = $params['product']['id_product'];

        $data['id_product'] = $id_product;
        $data = Product::getTaxesInformations($data, $this->context);

        $sampleObj = CdesignerFieldsModel::loadByIdProduct($id_product);
        if (!empty($sampleObj) && isset($sampleObj->id) && $sampleObj->active == 1 )
        {
            $fonts = new CdesignerFontsModel();
            $fonts_list = $fonts->getFonts();

            $fonts_array = explode('|', $sampleObj->fonts);


            $type_layout = explode('|', $sampleObj->type_layout);
            $type_color = explode('|', $sampleObj->type_color);

            $layout = $this->getLayouts();

            $type_image = explode('|', $sampleObj->type_image);
            $type_perso = $sampleObj->type_perso;
            $design_pre = $sampleObj->design_pre;
            $design_pre_2 = $sampleObj->design_pre_2;


            $colors = new CdesignerColorsModel();
            $images_def = new CdesignerImagesModel();
            $images_def_emojis = new CdesignerImagesModelEmojis();
            $colors_list = $colors->getColors();
            $images_def_list = $images_def->getImages( $this->context->language->id );
            $images_def_list_emojis = $images_def_emojis->getImages( $this->context->language->id );

            $tags_images = $this->getTagsImage();

            $tags_images_emojis = $this->getTagsImageEmojis();

            $tab_tags_image = array();
            $tab_tags_check = array();
            foreach ($tags_images as $key => $value) {
                $str_low = Tools::strtolower($value['tags']);

                if( !empty($str_low) && !in_array($str_low, $tab_tags_check) ) {
                    $tab_tags_check[] = $str_low;
                    $tab_tags_image[] = array( $value['id_tag'] ,$str_low );
                }
            }
            $tab_tags_image_emojis = array();

            /*
            foreach ($tags_images_emojis as $key => $value) {
                $str = explode(";", $value['tags'] );
                foreach ($str as $tags_c) {
                    $str_low = Tools::strtolower($tags_c);
                    if( !empty($str_low) && !in_array($str_low, $tags_images_emojis) )
                        $tags_images_emojis[] = $str_low;
                }
            }
            sort($tab_tags_image);
            sort($tags_images_emojis);
            */

            if( ! empty( $sampleObj->zone_1 ) )
            {
                $area_1 = explode(';', $sampleObj->zone_1);

                $top_1 = ( is_numeric( $area_1[0] ) ) ? $area_1[0] : '0';
                $left_1 = ( is_numeric( $area_1[1] ) ) ? $area_1[1] : '0';
                $right_1 = ( is_numeric( $area_1[2] ) ) ? $area_1[2] : '0';
                $bottom_1 = ( is_numeric( $area_1[3] ) ) ? $area_1[3] : '0';
            }
            else
                $top_1 = $left_1 = $right_1 = $bottom_1 = 0;

            if( ! empty( $sampleObj->zone_2 ) )
            {
                $area_2 = explode(';', $sampleObj->zone_2);

                $top_2 = ( is_numeric( $area_2[0] ) ) ? $area_2[0] : '0';
                $left_2 = ( is_numeric( $area_2[1] ) ) ? $area_2[1] : '0';
                $right_2 = ( is_numeric( $area_2[2] ) ) ? $area_2[2] : '0';
                $bottom_2 = ( is_numeric( $area_2[3] ) ) ? $area_2[3] : '0';
            }
            else
                $top_2 = $left_2 = $right_2 = $bottom_2 = 0;

            $this->context->smarty->assign(array(
                'cdesigner_textarea' => $sampleObj->textarea,
                'extra_image' => $sampleObj->image,
                'extra_mask' => $sampleObj->mask,
                'zone_1' => $sampleObj->zone_1,
                'zone_2' => $sampleObj->zone_2,
                'extra_active' => $sampleObj->active,
                'extra_image_2' => $sampleObj->image_2,
                'extra_mask_2' => $sampleObj->mask_2,
                'extra_active_2' => $sampleObj->active_2,
                'name_product' => $params['product']['name'],
                'id_product'=> $id_product,
                'image_baseurl' => $this->_path.'views/img/files/',
                'image_baseurl_upload' => $this->_path.'views/img/upload/',
                'client_id' => Configuration::get('client_id'),
                'app_id' => Configuration::get('app_id'),
                'secret_id' => Configuration::get('secret_id'),
                'redirect_URI' => Configuration::get('redirect_URI'),
                'active_item' => Configuration::get('active_item'),
                'active_item_face' => Configuration::get('active_item_face'),
                'url_demo_video' => Configuration::get('url_demo_video'),
                'images_def' => $images_def_list,
                'images_def_emojis' => $images_def_list_emojis,
                'colors' => $colors_list,
                'tags_image' => $tab_tags_image,
                'tags_image_emojis' => $tab_tags_image_emojis,

                'fonts' => $fonts_list,
                'fonts_array' => $fonts_array,

                'type_layout' => $type_layout,
                'type_color' => $type_color,
                'layout' => $layout,

                'type_image' => $type_image,
                'type_perso' => $type_perso,
                'design_pre' => $design_pre,
                'design_pre_2' => $design_pre_2,
                'extra_design' => $sampleObj->active_design,
                'active_bg' => $sampleObj->active_bg,
                'allow_upload' => $sampleObj->allow_upload,
                'allow_help' => $sampleObj->allow_help,
                'allow_zone' => $sampleObj->allow_zone,
                'allow_comb' => $sampleObj->allow_comb,
                'required_field' => $sampleObj->required_field,

                'urls_site' => Tools::getHttpHost(true) . __PS_BASE_URI__,
                'top_1' => $top_1,
                'left_1' => $left_1,
                'right_1' => $right_1,
                'bottom_1' => $bottom_1,

                'top_2' => $top_2,
                'left_2' => $left_2,
                'right_2' => $right_2,
                'bottom_2' => $bottom_2,
                'design' => '',//$_COOKIE['xd_'.$id_product],
                'logged' => $this->context->cookie->isLogged(),
                'price_per_side' => ( $sampleObj->price_per_side != '') ?  $sampleObj->price_per_side : '0' ,
                'price_per_image' => ( $sampleObj->price_per_image != '') ?  $sampleObj->price_per_image : '0' ,
                'price_per_text' => ( $sampleObj->price_per_text != '') ?  $sampleObj->price_per_text : '0' ,
                'rate_tax' => $data['rate'],
                'main_color' => trim( Configuration::get('main_color') ),
            ));
            return $this->display(__FILE__, 'views/templates/front/cdesigner_footer.tpl');
        }
    }

    /** Function Remove All Images From Folder **/
    private function removeAllImgFolder($uri)
    {
        $files = glob($uri);
        foreach ($files as $file)
        {
            if (is_file($file))
            unlink($file);
        }
    }

    /** Function Call All Delete Images **/
    private function deleteImg()
    {
        $this->removeAllImgFolder(dirname(__FILE__).'/views/img/upload/*');
        $this->removeAllImgFolder(dirname(__FILE__).'/views/img/upload/thumbnail/*');
        $this->removeAllImgFolder(dirname(__FILE__).'/views/img/upload/mask/*');
        $this->removeAllImgFolder(dirname(__FILE__).'/views/img/files/*');
        $this->removeAllImgFolder(dirname(__FILE__).'/views/img/files_front/*');
        $this->removeAllImgFolder(dirname(__FILE__).'/views/img/files/tpl/*');
        $this->removeAllImgFolder(dirname(__FILE__).'/views/img/files/thumbnail/*');
        $this->removeAllImgFolder(dirname(__FILE__).'/views/img/files/canvas/*');
    }

    /** Function List Of Front Page Module **/
    public function frontPageModule()
    {

        $html = '<div class="panel"><h3><i class="icon icon-tags"></i> Documentation</h3>
                    <p>
                        &raquo; '. $this->l('You can get the documentation to configure this module here') .' :
                        <ul>
                            <li><a href="https://customizer-17.foruntil.com/documentation/" target="_blank">English</a></li>
                            <li><a href="https://customizer-17.foruntil.com/documentation/fr/" target="_blank">French</a></li>
                        </ul>
                    </p>
                </div>';
        //$html .= $this->renderAddInstagramForm();
        $html .= $this->renderAddFormCtheme();
        $html .= $this->renderAddURLForm();
        $html .= $this->renderAddFacebookForm();
        $html .= $this->renderFontList();
        $html .= $this->renderColorList();
        $html .= $this->renderImgDefaultListEmojis();
        $html .= $this->renderImgDefaultList();
        return $html;
    }

    /** Function Show Config Module In Backoffice **/
    public function getContent()
    {
        @$this->_html .= '';
        if (Tools::isSubmit('submitCdesignerInstagram'))
        {
            $validation = $this->_postValidation();
            if ( !is_numeric( $validation ) )
                $this->_postProcess();
            @$this->_html .= $this->frontPageModule();
        }
        else if (Tools::isSubmit('submitcolorShop'))
        {
            $this->_postProcess();
            @$this->_html .= $this->frontPageModule();
        }
        else if (Tools::isSubmit('submitCdesignerURL'))
        {
            $this->_postProcess();
            @$this->_html .= $this->frontPageModule();
        }
        else if (Tools::isSubmit('submitCdesignerFacebook'))
        {
            $this->_postProcess();
            @$this->_html .= $this->frontPageModule();
        }
        else
        if (Tools::isSubmit('submitCdesignerFont') ||
            Tools::isSubmit('delete_id_font')
           )
        {
            $validation = $this->_postValidation();
            if ( is_numeric( $validation ) &&  (int)$validation == 2 )
            {
                @$this->_html .= $this->renderAddFontForm();
            }
            else
            {
                $this->_postProcess();
                @$this->_html .= $this->frontPageModule();
            }
        }
        elseif( Tools::isSubmit('submitCdesignerColor') ||
                Tools::isSubmit('delete_id_color')
          )
        {
            $validation = $this->_postValidation();
            if ( is_numeric( $validation ) &&  (int)$validation == 3 )
            {
                @$this->_html .= $this->renderAddColorForm();
            }
            else
            {
                $this->_postProcess();
                @$this->_html .= $this->frontPageModule();
            }
        }
        elseif( Tools::isSubmit('submitCdesignerImage') ||
                Tools::isSubmit('delete_id_image')
          )
        {
            $validation = $this->_postValidation();
            if ( is_numeric( $validation ) &&  (int)$validation == 4 )
            {
                @$this->_html .= $this->renderAddImageForm();
            }
            else
            {
                $this->_postProcess();
                @$this->_html .= $this->frontPageModule();
            }
        }
        elseif( Tools::isSubmit('submitCdesignerImageEmojis') ||
                Tools::isSubmit('delete_id_image_emojis')
          )
        {
            $validation = $this->_postValidation();
            if ( is_numeric( $validation ) &&  (int)$validation == 4 )
            {
                @$this->_html .= $this->renderAddImageFormEmojis();
            }
            else
            {
                $this->_postProcess();
                @$this->_html .= $this->frontPageModule();
            }
        }
        elseif (Tools::isSubmit('submitCdesignerShop') ||
            Tools::isSubmit('delete_id_cdesigner') ||
            Tools::isSubmit('submitCdesigner') ||
            Tools::isSubmit('changeStatus')
        )
        {

            if ( $this->_postValidation() )
            {
                $this->_postProcess();
                @$this->_html .= $this->frontPageModule();
            }
            else
                @$this->_html .= $this->renderAddForm();
        }
        elseif (Tools::isSubmit('addItem') ||
               (Tools::isSubmit('id_cdesigner') &&
                $this->itemExists((int)Tools::getValue('id_cdesigner')))
            )
            @$this->_html .= $this->renderAddForm();

        elseif (Tools::isSubmit('addFont') ||
               Tools::isSubmit('id_font')
            )
            @$this->_html .= $this->renderAddFontForm();

        elseif (Tools::isSubmit('addColor') ||
               Tools::isSubmit('id_color')
            )
            @$this->_html .= $this->renderAddColorForm();
        elseif (Tools::isSubmit('addImage') ||
               Tools::isSubmit('id_img')
            )
            @$this->_html .= $this->renderAddImageForm();
        elseif (Tools::isSubmit('addImageEmojis') ||
               Tools::isSubmit('id_img_emojis')
            )
            @$this->_html .= $this->renderAddImageFormEmojis();

        else
        {
            @$this->_html .= $this->frontPageModule();
        }
        return @$this->_html;
    }

    /** Function Validate Field  **/
    private function _postValidation()
    {
        $errors = array();
        if (Tools::isSubmit('changeStatus'))
        {
            if (!Validate::isInt(Tools::getValue('id_cdesigner')))
                $errors[] = $this->l('Invalid product');
        }
        elseif (Tools::isSubmit('submitCdesignerFont'))
        {
            if (Tools::strlen(Tools::getValue('title_font') ) == 0)
                $errors[] = $this->l('The title is not set.');
            /*
            if (Tools::strlen(Tools::getValue('url_font')) == 0)
                $errors[] = $this->l('The url font is not set.');
            */
            if (count($errors))
            {
                $this->_html .= $this->displayError(implode('<br />', $errors));
                return 2;
            }
        }
        elseif (Tools::isSubmit('submitCdesignerInstagram'))
        {
            if (Tools::strlen(Tools::getValue('client_id') ) == 0)
                $errors[] = $this->l('The client id is not set.');

            if (Tools::strlen(Tools::getValue('client_secret')) == 0)
                $errors[] = $this->l('The client secret is not set.');

            if (count($errors))
            {
                $this->_html .= $this->displayError(implode('<br />', $errors));
                return 5;
            }
        }

        elseif (Tools::isSubmit('submitCdesignerColor'))
        {

            if (Tools::strlen(Tools::getValue('color')) == 0)
                $errors[] = $this->l('The color is not set.');

            if (count($errors))
            {
                $this->_html .= $this->displayError(implode('<br />', $errors));
                return 3;
            }
        }
        elseif (Tools::isSubmit('delete_id_cdesigner') && (!Validate::isInt(Tools::getValue('delete_id_cdesigner')) || !$this->itemExists((int)Tools::getValue('delete_id_cdesigner'))))
            $errors[] = $this->l('Invalid id_cdesigner');

        if (count($errors))
        {
            $this->_html .= $this->displayError(implode('<br />', $errors));

            return false;
        }
        return true;
    }

    /** Function Main Process **/
    private function _postProcess()
    {
            $errors = array();

            if (Tools::isSubmit('submitCdesignerFont'))
            {
                if (Tools::getValue('id_font'))
                {
                    $item = new CdesignerFontsModel((int)Tools::getValue('id_font'));
                    if (!Validate::isLoadedObject($item))
                    {
                        $this->_html .= $this->displayError( $this->l('Invalid id_font') );
                        return false;
                    }
                }
                else
                    $item = new CdesignerFontsModel();

                $item->title= Tools::getValue('title_font');
                $item->url_font = Tools::getValue('url_font');

                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['woff']['name'], '.'), 1));
                $imagesize = @getimagesize($_FILES['woff']['tmp_name']);
                if (isset($_FILES['woff']) && isset($_FILES['woff']['tmp_name']) && !empty($_FILES['woff']['tmp_name']) && in_array($type, array('woff', 'woff2', 'eot', 'ttf', 'svg')) )
                {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    $salt = sha1(microtime());
                    if ( !move_uploaded_file($_FILES['woff']['tmp_name'], dirname(__FILE__).'/views/img/upload/'.$_FILES['woff']['name']) )
                        $errors[] = $error;

                    if (isset($temp_name))
                        @unlink($temp_name);

                    $item->woff = $_FILES['woff']['name'];
                }

                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['woff2']['name'], '.'), 1));
                $imagesize = @getimagesize($_FILES['woff2']['tmp_name']);
                if (isset($_FILES['woff2']) && isset($_FILES['woff2']['tmp_name']) && !empty($_FILES['woff2']['tmp_name']) && in_array($type, array('woff', 'woff2', 'eot', 'ttf', 'svg')) )
                {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    $salt = sha1(microtime());
                    if ( !move_uploaded_file($_FILES['woff2']['tmp_name'], dirname(__FILE__).'/views/img/upload/'.$_FILES['woff2']['name']) )
                        $errors[] = $error;

                    if (isset($temp_name))
                        @unlink($temp_name);

                    $item->woff2 = $_FILES['woff2']['name'];
                }

                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['eot']['name'], '.'), 1));
                $imagesize = @getimagesize($_FILES['eot']['tmp_name']);
                if (isset($_FILES['eot']) && isset($_FILES['eot']['tmp_name']) && !empty($_FILES['eot']['tmp_name']) && in_array($type, array('woff', 'woff2', 'eot', 'ttf', 'svg')) )
                {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    $salt = sha1(microtime());
                    if ( !move_uploaded_file($_FILES['eot']['tmp_name'], dirname(__FILE__).'/views/img/upload/'.$_FILES['eot']['name']) )
                        $errors[] = $error;

                    if (isset($temp_name))
                        @unlink($temp_name);

                    $item->eot = $_FILES['eot']['name'];
                }

                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['svg']['name'], '.'), 1));
                $imagesize = @getimagesize($_FILES['svg']['tmp_name']);
                if (isset($_FILES['svg']) && isset($_FILES['svg']['tmp_name']) && !empty($_FILES['svg']['tmp_name']) && in_array($type, array('woff', 'woff2', 'eot', 'ttf', 'svg')) )
                {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    $salt = sha1(microtime());
                    if ( !move_uploaded_file($_FILES['svg']['tmp_name'], dirname(__FILE__).'/views/img/upload/'.$_FILES['svg']['name']) )
                        $errors[] = $error;

                    if (isset($temp_name))
                        @unlink($temp_name);

                    $item->svg = $_FILES['svg']['name'];
                }

                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['ttf']['name'], '.'), 1));
                $imagesize = @getimagesize($_FILES['ttf']['tmp_name']);
                if (isset($_FILES['ttf']) && isset($_FILES['ttf']['tmp_name']) && !empty($_FILES['ttf']['tmp_name']) && in_array($type, array('woff', 'woff2', 'eot', 'ttf', 'svg')) )
                {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    $salt = sha1(microtime());
                    if ( !move_uploaded_file($_FILES['ttf']['tmp_name'], dirname(__FILE__).'/views/img/upload/'.$_FILES['ttf']['name']) )
                        $errors[] = $error;

                    if (isset($temp_name))
                        @unlink($temp_name);

                    $item->ttf = $_FILES['ttf']['name'];
                }

                if (!$errors)
                {
                    if (!Tools::getValue('id_font'))
                    {
                        if (!$item->add())
                            $errors[] = $this->displayError($this->l('The font could not be added.'));
                    }
                    elseif (!$item->update())
                        $errors[] = $this->displayError($this->l('The font could not be updated.'));

                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
                }

            }
            elseif (Tools::isSubmit('submitCdesignerInstagram')){
                Configuration::updateValue('client_id', pSQL(Tools::getValue('client_id')));
                Configuration::updateValue('client_secret', pSQL(Tools::getValue('client_secret')) );
                Configuration::updateValue('active_item', pSQL(Tools::getValue('active_item')) );
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
            }
            elseif (Tools::isSubmit('submitCdesignerFacebook')){
                Configuration::updateValue('app_id', pSQL(Tools::getValue('app_id')) );
                Configuration::updateValue('secret_id', pSQL(Tools::getValue('secret_id')) );
                Configuration::updateValue('active_item_face', pSQL(Tools::getValue('active_item_face')) );
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
            }
            elseif (Tools::isSubmit('submitCdesignerURL')){
                Configuration::updateValue('url_demo_video', pSQL(Tools::getValue('url_demo_video')) );
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
            }
            elseif (Tools::isSubmit('submitCdesignerColor'))
            {
                if (Tools::getValue('id_color'))
                {
                    $item = new CdesignerColorsModel((int)Tools::getValue('id_color'));
                    if (!Validate::isLoadedObject($item))
                    {
                        $this->_html .= $this->displayError( $this->l('Invalid id_font') );
                        return false;
                    }
                }
                else
                    $item = new CdesignerColorsModel();

                $item->color = Tools::getValue('color');

                if (!$errors)
                {
                    if (!Tools::getValue('id_color'))
                    {
                        if (!$item->add())
                            $errors[] = $this->displayError($this->l('The font could not be added.'));
                    }
                    elseif (!$item->update())
                        $errors[] = $this->displayError($this->l('The font could not be updated.'));

                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
                }

            }
            elseif (Tools::isSubmit('delete_id_font'))
            {
                $item = new CdesignerFontsModel( (int)Tools::getValue('delete_id_font') );
                $sql = $item->delete();

                if (!$sql)
                    $this->_html .= $this->displayError('Could not delete.');
                else
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
            }
            elseif (Tools::isSubmit('delete_id_color'))
            {
                $item = new CdesignerColorsModel( (int)Tools::getValue('delete_id_color') );
                $sql = $item->delete();

                if (!$sql)
                    $this->_html .= $this->displayError('Could not delete.');
                else
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
            }
            elseif (Tools::isSubmit('delete_id_image'))
            {
                $item = new CdesignerImagesModel( (int)Tools::getValue('delete_id_image') );
                $sql = $item->delete();

                if (!$sql)
                    $this->_html .= $this->displayError('Could not delete.');
                else
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
            }
            elseif (Tools::isSubmit('delete_id_image_emojis'))
            {
                $item = new CdesignerImagesModelEmojis( (int)Tools::getValue('delete_id_image_emojis') );
                $sql = $item->delete();
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
            }
            elseif (Tools::isSubmit('submitCdesignerImage'))
            {
                if (Tools::getValue('id_img'))
                {
                    $item = new CdesignerImagesModel((int)Tools::getValue('id_img'));
                    if (!Validate::isLoadedObject($item))
                    {
                        $this->_html .= $this->displayError($this->l('Invalid id_img'));
                        return false;
                    }
                }
                else
                    $item = new CdesignerImagesModel();

                $item->id_tag = Tools::getValue('id_tag');

                $languages = Language::getLanguages(false);
                foreach ($languages as $language)
                {
                    $item->tags[$language['id_lang']] = Tools::getValue('tags_'.$language['id_lang']);
                }
                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['img_default']['name'], '.'), 1));
                $imagesize = @getimagesize($_FILES['img_default']['tmp_name']);
                if (isset($_FILES['img_default']) && isset($_FILES['img_default']['tmp_name']) && !empty($_FILES['img_default']['tmp_name']) && !empty($imagesize) && in_array(Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array('jpg', 'gif', 'jpeg', 'png')) && in_array($type, array('jpg', 'gif', 'jpeg', 'png')))
                {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    $salt = sha1(microtime());
                    if ($error = ImageManager::validateUpload($_FILES['img_default']))
                        $errors[] = $error;
                    elseif (!$temp_name || !move_uploaded_file($_FILES['img_default']['tmp_name'], $temp_name))
                        return false;
                    //elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/views/img/upload/'.$salt.'_'.$_FILES['img_default']['name'], null, null, $type))
                    //$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                    $x = $imagesize[0];
                    $y = $imagesize[1];

                    $nx = 200;
                    $ny = ( $y * 200 ) / $x;

                    ImageManager::resize($temp_name, dirname(__FILE__).'/views/img/upload/_thumb_'.$salt.'_'.$_FILES['img_default']['name'], $nx, $ny, $type);

                    ImageManager::resize($temp_name, dirname(__FILE__).'/views/img/upload/'.$salt.'_'.$_FILES['img_default']['name'], null, null, $type);
                    if (isset($temp_name))
                        @unlink($temp_name);
                    $item->image = $salt.'_'.$_FILES['img_default']['name'];
                }
                if (!$errors)
                {
                    if (!Tools::getValue('id_img'))
                    {
                        if (!$item->add())
                            $errors[] = $this->displayError($this->l('The image could not be added.'));
                    }
                    elseif (!$item->update())
                        $errors[] = $this->displayError($this->l('The image could not be updated.'));

                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
                }

            }

            elseif (Tools::isSubmit('submitCdesignerImageEmojis'))
            {
                if (Tools::getValue('id_img_emojis'))
                {
                    $item = new CdesignerImagesModelEmojis((int)Tools::getValue('id_img_emojis'));
                    if (!Validate::isLoadedObject($item))
                    {
                        $this->_html .= $this->displayError($this->l('Invalid id_img'));
                        return false;
                    }
                }
                else
                    $item = new CdesignerImagesModelEmojis();

                $languages = Language::getLanguages(false);
                foreach ($languages as $language)
                {
                    $item->tags[$language['id_lang']] = Tools::getValue('tags_'.$language['id_lang']);
                }
                /*
                $type = Tools::strtolower(Tools::substr(strrchr($_FILES['img_default']['name'], '.'), 1));
                $imagesize = @getimagesize($_FILES['img_default']['tmp_name']);
                if (isset($_FILES['img_default']) && isset($_FILES['img_default']['tmp_name']) && !empty($_FILES['img_default']['tmp_name']) && !empty($imagesize) && in_array(Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array('jpg', 'gif', 'jpeg', 'png')) && in_array($type, array('jpg', 'gif', 'jpeg', 'png')))
                {
                    $temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
                    $salt = sha1(microtime());
                    if ($error = ImageManager::validateUpload($_FILES['img_default']))
                        $errors[] = $error;
                    elseif (!$temp_name || !move_uploaded_file($_FILES['img_default']['tmp_name'], $temp_name))
                        return false;
                    elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/views/img/upload/'.$salt.'_'.$_FILES['img_default']['name'], null, null, $type))
                        $errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));
                    if (isset($temp_name))
                        @unlink($temp_name);
                    $item->image = $salt.'_'.$_FILES['img_default']['name'];
                }*/
                if (!$errors)
                {
                    if (!Tools::getValue('id_img_emojis'))
                    {
                        if (!$item->add())
                            $errors[] = $this->displayError($this->l('The image could not be added.'));
                    }
                    elseif (!$item->update())
                        $errors[] = $this->displayError($this->l('The image could not be updated.'));

                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
                }

            }elseif (Tools::isSubmit('submitcolorShop'))
            {
                Configuration::updateValue('main_color', pSQL(Tools::getValue('main_color')) );
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
            }

            if (count($errors))
                $this->_html .= $this->displayError(implode('<br />', $errors));
            elseif (Tools::isSubmit('submitCdesignerShop') && Tools::getValue('id_cdesigner'))
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
            elseif (Tools::isSubmit('submitCdesignerShop'))
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name.'#module_form_1');
        }

    /** Function Show List Fonts **/
    public function renderFontList()
    {
        $font = new CdesignerFontsModel();
        $items = $font->getFonts();
        $this->context->smarty->assign(
            array(
                'link' => $this->context->link,
                'items' => $items,
                'image_baseurl' => $this->_path.'views/img/upload/'
            )
        );
        return $this->display(__FILE__, 'list-font.tpl');
    }

    /** Function Show List Colors **/
    public function renderColorList()
    {
        $font = new CdesignerColorsModel();
        $items = $font->getColors();
        $this->context->smarty->assign(
            array(
                'link' => $this->context->link,
                'items' => $items
            )
        );
        return $this->display(__FILE__, 'list-colors.tpl');
    }

    /** Function Show List Default Image **/
    public function renderImgDefaultList()
    {
        $images = new CdesignerImagesModel();
        $items = $images->getImagesWithTags();
        $this->context->smarty->assign(
            array(
                'link' => $this->context->link,
                'items' => $items,
                'image_baseurl' => $this->_path.'views/img/upload/'
            )
        );
        return $this->display(__FILE__, 'list-images.tpl');
    }

    /** Function Show List Default Image **/
    public function renderImgDefaultListEmojis()
    {
        $images = new CdesignerImagesModelEmojis();
        $items = $images->getImages();
        $this->context->smarty->assign(
            array(
                'link' => $this->context->link,
                'items' => $items,
                'image_baseurl' => $this->_path.'views/img/upload/'
            )
        );
        return $this->display(__FILE__, 'list-images-emojis.tpl');
    }

    /** Function Show Form Add Device **/
        public function renderAddFormCtheme()
        {
            $current_index = AdminController::$currentIndex;
            $token = Tools::getAdminTokenLite('AdminModules');
            $back = Tools::safeOutput(Tools::getValue('back', ''));
            if (!isset($back) || empty($back))
                $back = $current_index.'&amp;configure='.$this->name.'&token='.$token;
            $fields_form = array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->l('The Main Module Color'),
                        'icon' => 'icon-cogs'
                    ),
                    'input' => array(
                        array(
                            'type' => 'color',
                            'label' => $this->l('Main Color'),
                            'name' => 'main_color',
                            'desc' => $this->l('The Main color of your theme, Default #f34968.'),
                        ),
                    ),
                    'buttons' => array(
                        'cancelBlock' => array(
                            'title' => $this->l('Back to list'),
                            'href' => $back,
                            'icon' => 'process-icon-back'
                        )
                    ),
                    'submit' => array(
                        'title' => $this->l('Save'),
                    )
                ),
            );

            $helper = new HelperForm();
            $helper->show_toolbar = false;
            $helper->table = $this->table;
            $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $helper->default_form_language = $lang->id;
            $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
            $this->fields_form = array();
            $helper->module = $this;
            $helper->identifier = $this->identifier;
            $helper->submit_action = 'submitcolorShop';
            $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
            $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $helper->tpl_vars = array(
                'base_url' => $this->context->shop->getBaseURL(),
                'language' => array(
                    'id_lang' => $language->id,
                    'iso_code' => $language->iso_code
                ),
                'fields_value' => $this->getAddFieldsValuesCtheme(),
                'languages' => $this->context->controller->getLanguages(),
                'id_language' => $this->context->language->id,
                'image_baseurl' => $this->_path.'views/img/upload/'
            );

            $helper->override_folder = '/';
            return $helper->generateForm(array($fields_form));
        }

        /** Function Get HelperField for Devices Fields **/
        public function getAddFieldsValuesCtheme()
        {
            $fields = array();
            $fields['main_color'] = Tools::getValue('main_color', Configuration::get('main_color'));
            return $fields;
        }


    /** Function Show Form Add Fonts **/
    public function renderAddFontForm()
    {
        $back = '';
        $current_index = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        $back = Tools::safeOutput(Tools::getValue('back', ''));
        if (!isset($back) || empty($back))
            $back = $current_index.'&amp;configure='.$this->name.'&token='.$token;
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Manage Custom Fonts'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'html',
                        'desc' => '<h4 class="alert-text">'. $this->l('Configure From GoogleWebfonts').'</h4>',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Title Font'),
                        'name' => 'title_font',
                        'lang' => false,
                        'desc' => 'Example "Open Sans", you can get these informations from <a href="https://www.google.com/fonts" target="_blank">Google Fonts</a> if you hope to use googlefonts api, If you want to use others custom fonts, please upload bellow all needed formats (woff,woff2), and use the reel name, it will be used as a font-face.'
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('URL Font From GoogleFonts'),
                        'name' => 'url_font',
                        'lang' => false,
                        'desc' => $this->l('Example "https://fonts.googleapis.com/css?family=Open+Sans"')
                    ),
                    array(
                        'type' => 'html',
                        'label' => '',
                        'desc' => '<h4 class="alert-text">'. $this->l('Or You Can Upload a Custom Font').'</h4>'
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Upload Custom Font (Format woff)'),
                        'name' => 'woff',
                        'lang' => false
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Upload Custom Font (Format woff2)'),
                        'name' => 'woff2',
                        'lang' => false
                    ),
                    /*
                    array(
                        'type' => 'file',
                        'label' => $this->l('Upload Custom Font (Format eot)'),
                        'name' => 'eot',
                        'lang' => false
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Upload Custom Font (Format svg)'),
                        'name' => 'svg',
                        'lang' => false
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Upload Custom Font (Format ttf)'),
                        'name' => 'ttf',
                        'lang' => false
                    ),*/
                ),
                'buttons' => array(
                    'cancelBlock' => array(
                        'title' => $this->l('Back to list'),
                        'href' => $back,
                        'icon' => 'process-icon-back'
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        if (Tools::isSubmit('id_font'))
        {
            $fonts = new CdesignerFontsModel((int)Tools::getValue('id_font'));

            if ($fonts->fontExists((int)Tools::getValue('id_font')))
                $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_font');
        }
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCdesignerFont';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $this->getAddFontFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        $helper->override_folder = '/';
        return $helper->generateForm(array($fields_form));
    }

    /** Function Show Form Add Instagram API **/
    public function renderAddInstagramForm()
    {
        $back = '';
        $current_index = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        if (!isset($back) || empty($back))
            $back = $current_index.'&amp;configure='.$this->name.'&token='.$token;
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuration api instagram'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Client ID'),
                        'name' => 'client_id',
                        'lang' => false,
                        'desc' =>'You can get these information from your account instagram <a href="https://instagram.com/developer/clients/manage/" target="blank">https://instagram.com/developer/clients/manage/</a>'
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Client secret'),
                        'name' => 'client_secret',
                        'lang' => false,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Redirect URI'),
                        'name' => 'redirect_URI',
                        'lang' => false,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enabled'),
                        'name' => 'active_item',
                        'is_bool' => true,
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
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCdesignerInstagram';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $this->getAddInstagramFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        $helper->override_folder = '/';
        return $helper->generateForm(array($fields_form));
    }

    public function renderAddURLForm()
    {
        $back = '';
        $current_index = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        if (!isset($back) || empty($back))
            $back = $current_index.'&amp;configure='.$this->name.'&token='.$token;
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Video Demonstration'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('ID Youtube Video Demonstration'),
                        'name' => 'url_demo_video',
                        'lang' => false,
                        'desc' => $this->l('Not Required, you can insert this ID of the video youtube only if you hope to show to your customers how the customization works on your website, this will be added as a HELP button on the customization page, ( and you can select from product configuration page to display or not this button for each product) .')
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCdesignerURL';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $this->getAddURLFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        $helper->override_folder = '/';
        return $helper->generateForm(array($fields_form));
    }

    public function renderAddFacebookForm()
    {
        $back = '';
        $current_index = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        if (!isset($back) || empty($back))
            $back = $current_index.'&amp;configure='.$this->name.'&token='.$token;
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Configuration api facebook'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('App ID'),
                        'name' => 'app_id',
                        'lang' => false,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Client Secret'),
                        'name' => 'secret_id',
                        'lang' => false,
                        'desc' =>'You can get these information from your account facebook <a href="https://developers.facebook.com/" target="blank">https://developers.facebook.com/</a>'
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enabled'),
                        'name' => 'active_item_face',
                        'is_bool' => true,
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
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCdesignerFacebook';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $this->getAddFacebookFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        $helper->override_folder = '/';
        return $helper->generateForm(array($fields_form));
    }

    /** Function Show Form Add Colors **/
    public function renderAddColorForm()
    {
        $back = '';
        $current_index = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        $back = Tools::safeOutput(Tools::getValue('back', ''));
        if (!isset($back) || empty($back))
            $back = $current_index.'&amp;configure='.$this->name.'&token='.$token;
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Color font'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Color'),
                        'name' => 'color',
                        'class' => 'color',
                        'lang' => false,
                        'prefix' => '#'
                    )
                ),
                'buttons' => array(
                    'cancelBlock' => array(
                        'title' => $this->l('Back to list'),
                        'href' => $back,
                        'icon' => 'process-icon-back'
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        if (Tools::isSubmit('id_color'))
        {
            $fonts = new CdesignerColorsModel((int)Tools::getValue('id_color'));

            if ($fonts->colorExists((int)Tools::getValue('id_color')))
                $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_color');
        }
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCdesignerColor';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $this->getAddColorFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        $helper->override_folder = '/';
        return $helper->generateForm(array($fields_form));
    }

    /** Function Show Form Add Images **/
    public function renderAddImageForm()
    {
        $back = '';
        $current_index = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        $back = Tools::safeOutput(Tools::getValue('back', ''));

        $tags_object = new CdesignerImagesModelEmojis();
        $tag_list = $tags_object->getImages();

        foreach ($tag_list as $key => $value) {
          $tags[] = array(
                      'idtag' => $value['id_img'],
                      'name' => $value['tags']
                  );
        }

        if (!isset($back) || empty($back))
            $back = $current_index.'&amp;configure='.$this->name.'&token='.$token;
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Galeries images form'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'file',
                        'label' => $this->l('Select image'),
                        'name' => 'img_default',
                        'lang' => false
                    ),
                    array(
                        'type' => 'select',
                        'required' => true,
                        'label' => $this->l('Category'),
                        'name' => 'id_tag',
                        'lang' => true,
                        'desc' => $this->l('You can manage the categories in the section "Categories Image".'),
                        'options' => array(
                          'query' => $tags,
                          'id' => 'idtag',
                          'name' => 'name'
                        )
                    )
                ),
                'buttons' => array(
                    'cancelBlock' => array(
                        'title' => $this->l('Back to list'),
                        'href' => $back,
                        'icon' => 'process-icon-back'
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        if (Tools::isSubmit('id_img'))
        {
            $fonts = new CdesignerImagesModel((int)Tools::getValue('id_img'));

            if ($fonts->imageExists((int)Tools::getValue('id_img')))
                $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_img');
        }
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCdesignerImage';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $this->getAddImageFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        $helper->override_folder = '/';
        return $helper->generateForm(array($fields_form));
    }

    /** Function Show Form Add Images **/
    public function renderAddImageFormEmojis()
    {
        $back = '';
        $current_index = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        $back = Tools::safeOutput(Tools::getValue('back', ''));
        if (!isset($back) || empty($back))
            $back = $current_index.'&amp;configure='.$this->name.'&token='.$token;
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Manage Category Images'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Category'),
                        'name' => 'tags',
                        'lang' => true,
                    )
                ),
                'buttons' => array(
                    'cancelBlock' => array(
                        'title' => $this->l('Back to list'),
                        'href' => $back,
                        'icon' => 'process-icon-back'
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        if (Tools::isSubmit('id_img_emojis'))
        {
            $fonts = new CdesignerImagesModelEmojis((int)Tools::getValue('id_img_emojis'));

            if ($fonts->imageExists((int)Tools::getValue('id_img_emojis')))
                $fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_img_emojis');
        }
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $this->fields_form = array();
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCdesignerImageEmojis';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->tpl_vars = array(
            'base_url' => $this->context->shop->getBaseURL(),
            'language' => array(
                'id_lang' => $language->id,
                'iso_code' => $language->iso_code
            ),
            'fields_value' => $this->getAddImageFieldsValuesEmojis(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        $helper->override_folder = '/';
        return $helper->generateForm(array($fields_form));
    }
    /**  Hook Header Page Back **/
    public function hookDisplayAdminOrder($params)
    {
        //echo 'amine';
        $this->context->controller->addJquery();
        $js = $this->getPathUri().'views/js/update.js';
        return $this->_runJS( $js );
        //$this->hookDisplayHeader($params);
    }

    public function getLayouts(){
        require "views/img/config/layout/data.php";
        return $tab;
    }

    /**  Hook Header Page Front **/
    public function hookDisplayHeader($params)
    {
        $this->context->controller->addJS($this->getPathUri().'views/js/update.js');
    }

    /** Function Get Next Position Device **/
    public function getNextPosition()
    {
        $row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
            SELECT MAX(cca.`position`) AS `next_position`
            FROM `'._DB_PREFIX_.'cdesigner` cca, `'._DB_PREFIX_.'cdesigner_shop` cs
            WHERE cca.`id_cdesigner` = cs.`id_cdesigner` AND cs.`id_shop` = '.(int)$this->context->shop->id
        );

        return (++$row['next_position']);
    }

    /** Function Show status For Device **/
    public function displayStatus($id_cdesigner, $active)
    {
        $title = ((int)$active == 0 ? $this->l('Disabled') : $this->l('Enabled'));
        $icon = ((int)$active == 0 ? 'icon-remove' : 'icon-check');
        $class = ((int)$active == 0 ? 'btn-danger' : 'btn-success');
        $html = '<a class="btn '.$class.'" href="'.AdminController::$currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules').'&changeStatus&id_cdesigner='.(int)$id_cdesigner.'" title="'.$title.'"><i class="'.$icon.'"></i></a>';
        return $html;
    }

    /** Function Get HelperField for Fonts fields **/
    public function getAddFontFieldsValues()
    {
        $fields = array();
        if (Tools::isSubmit('id_font'))
        {
            $item = new CdesignerFontsModel((int)Tools::getValue('id_font'));
            $fields['id_font'] = (int)Tools::getValue('id_font', $item->id);
        }
        else
            $item = new CdesignerFontsModel();
        $fields['title_font'] = Tools::getValue('title_font', $item->title);
        $fields['url_font'] = Tools::getValue('url_font', $item->url_font);
        $fields['woff'] = Tools::getValue('woff', $item->woff);
        $fields['woff2'] = Tools::getValue('woff', $item->woff2);
        $fields['eot'] = Tools::getValue('eot', $item->eot);
        $fields['svg'] = Tools::getValue('svg', $item->svg);
        $fields['ttf'] = Tools::getValue('ttf', $item->ttf);
        return $fields;
    }

    /** Function Get HelperField for Instagram fields **/
    public function getAddInstagramFieldsValues()
    {
        $fields = array();
        $fields['active_item'] = Tools::getValue('active_item', Configuration::get('active_item'));
        $fields['client_id'] = Tools::getValue('client_id', Configuration::get('client_id'));
        $fields['client_secret'] = Tools::getValue('client_secret', Configuration::get('client_secret') );
        $fields['redirect_URI'] = Tools::getValue('redirect_URI', Configuration::get('redirect_URI') );
        return $fields;
    }

    /** Function Get HelperField for Instagram fields **/
    public function getAddFacebookFieldsValues()
    {
        $fields = array();
        $fields['active_item_face'] = Tools::getValue('active_item_face', Configuration::get('active_item_face'));
        $fields['app_id'] = Tools::getValue('app_id', Configuration::get('app_id'));
        $fields['secret_id'] = Tools::getValue('secret_id', Configuration::get('secret_id'));
        return $fields;
    }

    /** Function Get HelperField for Instagram fields **/
    public function getAddURLFieldsValues()
    {
        $fields = array();
        $fields['url_demo_video'] = Tools::getValue('url_demo_video', Configuration::get('url_demo_video'));
        return $fields;
    }

    public function _runJS( $url ){
        return '<script src="'.$url.'"></script>';
    }

    /** Function Get HelperField for Colors Demo **/
    public function getAddColorFieldsValues()
    {
        $fields = array();
        if (Tools::isSubmit('id_color'))
        {
            $item = new CdesignerColorsModel((int)Tools::getValue('id_color'));
            $fields['id_color'] = (int)Tools::getValue('id_color', $item->id);
        }
        else
            $item = new CdesignerColorsModel();
        $fields['color'] = Tools::getValue('color', $item->color);
        return $fields;
    }

    /** Function Get HelperField for defaultImage Demo **/
    public function getAddImageFieldsValues()
    {
        $fields = array();
        if (Tools::isSubmit('id_img'))
        {
            $item = new CdesignerImagesModel((int)Tools::getValue('id_img'));
            $fields['id_img'] = (int)Tools::getValue('id_img', $item->id);
        }
        else
            $item = new CdesignerImagesModel();

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang)
        {
            $fields['tags'][$lang['id_lang']] = Tools::getValue('tags_'.(int)$lang['id_lang'], $item->tags[$lang['id_lang']]);
        }
        $fields['img_default'] = Tools::getValue('img_default', $item->image);
        $fields['id_tag'] = Tools::getValue('id_tag', $item->id_tag);
        return $fields;
    }
    /** Function Get HelperField for defaultImage Demo **/
    public function getAddImageFieldsValuesEmojis()
    {
        $fields = array();
        if (Tools::isSubmit('id_img_emojis'))
        {
            $item = new CdesignerImagesModelEmojis((int)Tools::getValue('id_img_emojis'));
            $fields['id_img_emojis'] = (int)Tools::getValue('id_img_emojis', $item->id);
        }
        else
            $item = new CdesignerImagesModelEmojis();

        $languages = Language::getLanguages(false);
        foreach ($languages as $lang)
        {
            $fields['tags'][$lang['id_lang']] = Tools::getValue('tags_'.(int)$lang['id_lang'], $item->tags[$lang['id_lang']]);
        }
        $fields['img_default'] = Tools::getValue('img_default', $item->image);
        return $fields;
    }

    /** Function Add Fonts Demo To DataBase **/
    private function addDemoFonts()
    {
        return Db::getInstance()->execute('INSERT INTO '._DB_PREFIX_.'cdesigner_fonts(title, url_font)
                                            VALUES
                                              (\'Poiret One\', \'https://fonts.googleapis.com/css?family=Poiret+One\'),
                                              (\'Dancing Script\', \'https://fonts.googleapis.com/css?family=Dancing+Script\'),
                                              (\'Gloria Hallelujah\', \'https://fonts.googleapis.com/css?family=Gloria+Hallelujah\'),
                                              (\'Indie Flower\', \'https://fonts.googleapis.com/css?family=Indie+Flower\'),
                                              (\'Pacifico\', \'https://fonts.googleapis.com/css?family=Pacifico\'),
                                              (\'Lobster\', \'https://fonts.googleapis.com/css?family=Lobster\'),
                                              (\'Yanone Kaffeesatz\', \'https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz\'),
                                              (\'Shadows Into Light\', \'https://fonts.googleapis.com/css?family=Shadows+Into+Light\');
                                            ');
    }

    /** Function Add Colors Demo To DataBase **/
    private function addDemoColors()
    {
        return Db::getInstance()->execute('INSERT INTO '._DB_PREFIX_.'cdesigner_colors(color)
                                            VALUES (\'976b01\'),(\'3498db\'),(\'2ecc71\'),(\'f1c40f\'),(\'f613d9\'),(\'3ad6e4\'),(\'000\'),(\'818080\'),(\'fff\'),(\'e74c3c\'),(\'e67e22\'),(\'bdc3c7\');');
    }

    /** Function Add Default Image Demo To DataBase **/
    private function addDemoDefaultsImages()
    {
        for ($i = 1; $i < 9; $i++)
            copy(Tools::getHttpHost(true).__PS_BASE_URI__.'modules/cdesigner/views/img/config/device/defaultimg/img'.$i.'.jpg', _PS_ROOT_DIR_.'/modules/cdesigner/views/img/upload/img'.$i.'.jpg');
        return Db::getInstance()->execute('INSERT INTO '._DB_PREFIX_.'cdesigner_defaults_img(image)
                                            VALUES (\'img1.jpg\'),(\'img2.jpg\'),(\'img3.jpg\'),(\'img4.jpg\'),(\'img5.jpg\'),(\'img6.jpg\'),(\'img7.jpg\'),(\'img8.jpg\');');
    }

    /** Function Add Default Image Demo To DataBase **/
    private function addDemoDefaultsImagesEmojis()
    {
        for ($i = 1; $i < 9; $i++)
            copy(Tools::getHttpHost(true).__PS_BASE_URI__.'modules/cdesigner/views/img/config/device/defaultimg/img'.$i.'.jpg', _PS_ROOT_DIR_.'/modules/cdesigner/views/img/upload/img'.$i.'.jpg');
        return Db::getInstance()->execute('INSERT INTO '._DB_PREFIX_.'cdesigner_defaults_img_emojis(image)
                                            VALUES (\'img1.jpg\'),(\'img2.jpg\'),(\'img3.jpg\'),(\'img4.jpg\'),(\'img5.jpg\'),(\'img6.jpg\'),(\'img7.jpg\'),(\'img8.jpg\');');
    }
}