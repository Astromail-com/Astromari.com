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

/** Model Cdesigner **/
class CdesignerColorsModel extends ObjectModel
{
	public $color;

	/** Define Prototype Of Cdesigner **/
	public static $definition = array(
		'table' => 'cdesigner_colors',
		'primary' => 'id_color',
		'multilang' => false,
		'fields' => array(
			'color' =>	array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
		)
	);

	public	function __construct($id_color = null)
	{
		parent::__construct($id_color);
	}

	public function getColors()
	{
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
					SELECT  `id_color` , `color`
					FROM '._DB_PREFIX_.'cdesigner_colors'
			);
	}

	public function colorExists($id_color)
	{
		$req = 'SELECT `id_color`
				FROM `'._DB_PREFIX_.'cdesigner_colors`
				WHERE `id_color` = '.(int)$id_color;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}
}