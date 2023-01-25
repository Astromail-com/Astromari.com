<?php
/**
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
* @author    Prestaeg <infos@presta.com>
* @copyright Prestaeg
* @version   1.0.0
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

class CdesignerStoredatapreModuleFrontController extends ModuleFrontController
{
	public function init()
	{
		$this->page_name = 'storedata'; // page_name and body id
		parent::init();
	}

	/** Init Function Controller **/
	public function initContent()
	{
		parent::initContent();
		if( !is_numeric(Tools::getValue('output')) )
			exit();
		$output = (int)Tools::getValue('output');
		$link = filter_var(Tools::getValue('link'), FILTER_SANITIZE_SPECIAL_CHARS);
		$html = filter_var(Tools::getValue('id'), FILTER_SANITIZE_SPECIAL_CHARS);

		$found = false;
		$not_allowed =array('.zip','.rar','.html','.tar','.php','.exe','.js','.py','.jsp','.asp','.txt', '.pht','.phtml', '.shtml', '.asa', '.cer', '.asax', '.swf', '.xap');
		foreach ($not_allowed as $key => $value) {
			if( strpos( strtolower($value), strtolower($link) ) !== false) {
				$found = true;
			}
			if( strpos( strtolower($value), strtolower($html) ) !== false) {
				$found = true;
			}
		}
		if( $found ) {
			echo 'Suspect Operation !!!';
			exit();
		}


		setcookie('xd_'.Tools::getValue('prod'), Tools::getValue('output'), (time() + 3600));
		$myfile = fopen( dirname(__FILE__).'/../../views/img/files/tpl/tp_'.$output.'.html', "w") or die("Unable to open file!");
		fwrite($myfile, $html);
		fclose($myfile);
		$id_product = (int)Tools::getValue('prod');
		$link_back = $this->context->link->getProductLink($id_product);
		echo $link_back . '?design=' . $output;
		exit();
	}
}