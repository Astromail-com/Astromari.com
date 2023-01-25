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

class CdesignerImagedpiModuleFrontController extends ModuleFrontController
{
	public function init()
	{
		$this->page_name = 'imagedpi'; // page_name and body id
		parent::init();
	}
	/** Init Function Controller **/
	public function initContent()
	{
		parent::initContent();
		$data = filter_var( Tools::getValue('output'), FILTER_SANITIZE_SPECIAL_CHARS);
		$type = (int) Tools::getValue('type');
		$found = false;
		$not_allowed =array('.zip','.rar','.html','.tar','.php','.exe','.js','.py','.jsp','.asp','.txt', '.pht','.phtml', '.shtml', '.asa', '.cer', '.asax', '.swf', '.xap');
		foreach ($not_allowed as $key => $value) {
			if( strpos( strtolower($value), strtolower($data) ) !== false) {
				$found = true;
			}
		}
		if( $found ) {
			echo 'Suspect Operation !!!';
			exit();
		}

		$decoded = base64_decode(str_replace('data:image/png;base64,', '', $data));

		file_put_contents(dirname(__FILE__).'/../../views/img/files/canvas/_tempoimg_.png', $decoded);

		$output = 'tempoimg';
		$img = _PS_ROOT_DIR_. '/modules/cdesigner/views/img/files/canvas/_' . $output . '_.png';

		/*
			$image = new Imagick( $img );
			$image->setImageResolution(300, 300);
			$image->writeImage(_PS_ROOT_DIR_. '/modules/cdesigner/views/img/files/canvas/_' . $output . '_300.png');
			exit();
		*/
		$pdf = _PS_ROOT_DIR_. '/modules/cdesigner/views/img/files/canvas/_' . $output . '_300_dpi.pdf';

		//shell_exec("convert -units PixelsPerInch " . $img . " -resample 300 " . $pdf);
		shell_exec("convert -units PixelsPerInch " . $img . " -density 300 " . $pdf);
		$url = @$_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER["SERVER_NAME"] . __PS_BASE_URI__ . 'modules/cdesigner/views/img/files/canvas/_' . $output . '_300_dpi.pdf';
		echo '<script>
				window.location = \''.$url.'\';
			  </script>';
		exit();  
	}
}