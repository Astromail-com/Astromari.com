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

class CdesignerFontsModel extends ObjectModel
{
	public $title;
	public $url_font;

	/** Define Prototype Of Cdesigner **/
	public static $definition = array(
		'table' => 'cdesigner_fonts',
		'primary' => 'id_font',
		'multilang' => false,
		'fields' => array(
			'title' =>			array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
			'url_font' =>	    array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
			'woff' =>	array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
			'woff2' =>	array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
			'eot' =>	array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
			'svg' =>	array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
			'ttf' =>	array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
		)
	);

	public	function __construct($id_font = null, $id_lang = null, $id_shop = null, Context $context = null)
	{
		parent::__construct($id_font, $id_lang, $id_shop, $context);
	}

	public function getFonts()
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
					SELECT *
					FROM '._DB_PREFIX_.'cdesigner_fonts'
			);
	}

	public function fontExists($id_font)
	{
		$req = 'SELECT `id_font`
				FROM `'._DB_PREFIX_.'cdesigner_fonts`
				WHERE `id_font` = '.(int)$id_font;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}
}