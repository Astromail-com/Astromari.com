<?php
/**
* 2007-2017 PrestaShop
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

class CdesignerFieldsModel extends ObjectModel
{
    /** @var string Name */
    public $id_cdesigner_cfields;
        
    /** @var integer */
    public $id_product;

    /** @var integer */
    public $type_layout;

    public $type_color;

    public $type_image;

    public $design_pre;

    public $design_pre_2;

    public $type_perso;
    
    /** @var integer */
    public $textarea;

    public $image;

    public $mask;

    public $active;

    public $image_2;

    public $mask_2;

    public $zone_1;
    
    public $zone_2;

    public $fonts;

    public $price_per_side;

    public $price_per_image;

    public $price_per_text;

    public $active_2;

    public $active_design;

    public $active_bg;

    public $allow_upload;

    public $allow_help;

    public $allow_zone;
    
    public $allow_comb;


    public $required_field;
    
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'cdesigner_cfields',
        'primary' => 'id_cdesigner_cfields',
        'multilang' => FALSE,
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => TRUE),
            'type_layout' => array('type' => self::TYPE_HTML),
            'type_color' => array('type' => self::TYPE_HTML),
            'type_image' => array('type' => self::TYPE_HTML),
            'design_pre' => array('type' => self::TYPE_HTML),
            'design_pre_2' => array('type' => self::TYPE_HTML),
            'type_perso' => array('type' => self::TYPE_HTML),
            'textarea' => array('type' => self::TYPE_HTML, 'validate' => 'isString'),
            'active' =>         array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'image' => array('type' => self::TYPE_HTML),
            'mask' => array('type' => self::TYPE_HTML),
            'active_2' =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'image_2' => array('type' => self::TYPE_HTML),
            'mask_2' => array('type' => self::TYPE_HTML),
            'zone_1' => array('type' => self::TYPE_HTML),
            'zone_2' => array('type' => self::TYPE_HTML),
            'fonts' => array('type' => self::TYPE_HTML),
            'price_per_side' => array('type' => self::TYPE_HTML),
            'price_per_image' => array('type' => self::TYPE_HTML),
            'price_per_text' => array('type' => self::TYPE_HTML),
            'active_design' =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'active_bg' =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'allow_upload' =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'allow_help' =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'required_field' =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'allow_zone' =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'allow_comb' =>  array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
        ),
    );
    
    public static function loadByIdProduct($id_product){
        $result = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'cdesigner_cfields` sample
            WHERE sample.`id_product` = '.(int)$id_product
        );
        return new CdesignerFieldsModel($result['id_cdesigner_cfields']);
    }
}

