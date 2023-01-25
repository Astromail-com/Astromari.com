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

class CdesignerImagesModelEmojis extends ObjectModel
{
	public $image;
	public $tags;

	/** Define Prototype Of Cdesigner **/
	public static $definition = array(
		'table' => 'cdesigner_defaults_img_emojis',
		'primary' => 'id_img',
		'multilang' => true,
		'fields' => array(
			'image' =>	array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isCleanHtml', 'size' => 255),
			'tags' =>	array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255),
		)
	);

	public	function __construct($id_img = null, $id_lang = null)
	{
		parent::__construct($id_img,$id_lang);
	}

	public function delete()
	{
		$sql = true;
		/*$image = $this->image;
		$path = dirname(__FILE__).'/../views/img/upload/'.$image;
		$sql = @unlink($path);*/
		$sql &= parent::delete();
		return $sql;
	}

	public function getImages( $id_lang = '' )
	{
		if( empty ($id_lang ) )
			$id_lang = (int) Configuration::get('PS_LANG_DEFAULT');

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
				SELECT  a.`id_img` , b.`tags`
				FROM '._DB_PREFIX_.'cdesigner_defaults_img_emojis a
				LEFT JOIN '._DB_PREFIX_.'cdesigner_defaults_img_emojis_lang b ON (a.id_img = b.id_img)
				WHERE b.id_lang = '.(int)$id_lang
		);
	}

	public function imageExists($id_img)
	{
		$req = 'SELECT `id_img`
				FROM `'._DB_PREFIX_.'cdesigner_defaults_img_emojis`
				WHERE `id_img` = '.(int)$id_img;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}
}