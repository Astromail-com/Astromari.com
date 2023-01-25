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

class CdesignerSaveModuleFrontController extends ModuleFrontController
{
	public function init()
	{
		$this->page_name = 'save'; // page_name and body id
		parent::init();
	}

	/** Init Function Controller **/
	public function initContent()
	{
		parent::initContent();
		if (!is_numeric(Tools::getValue('id_img'))) exit();
		$id = filter_var((int)Tools::getValue('id_img'), FILTER_SANITIZE_SPECIAL_CHARS);
		$img = filter_var(Tools::getValue('img'), FILTER_SANITIZE_SPECIAL_CHARS);
		//$img_to_print = filter_var(Tools::getValue('img_to_print'), FILTER_SANITIZE_SPECIAL_CHARS);

		$found = false;
		$not_allowed =array('.zip','.rar','.html','.tar','.php','.exe','.js','.py','.jsp','.asp','.txt', '.pht','.phtml', '.shtml', '.asa', '.cer', '.asax', '.swf', '.xap');
		foreach ($not_allowed as $key => $value) {
			if( strpos( strtolower($value), strtolower($id) ) !== false) {
				$found = true;
			}
			if( strpos( strtolower($value), strtolower($img) ) !== false) {
				$found = true;
			}
		}
		if( $found ) {
			echo 'Suspect Operation !!!';
			exit();
		}

		if (@$img != '')
		{
			$decoded = base64_decode(str_replace('data:image/png;base64,', '', $img));
			file_put_contents(dirname(__FILE__).'/../../views/img/files/canvas/_'.$id.'.png', $decoded);
		}
		/*
		else if (@$img_to_print != '')
		{
			$decoded_to_print = base64_decode(str_replace('data:image/png;base64,', '', $img_to_print));
			file_put_contents(dirname(__FILE__).'/../../views/img/files/canvas/_'.$id.'_.png', $decoded_to_print);
		}
		*/

		print $id;
		exit();
	}
}