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

class CdesignerCanvasoutputModuleFrontController extends ModuleFrontController
{
	public function init()
	{
		$this->page_name = 'canvasoutput'; // page_name and body id
		parent::init();
	}

	/** Import CSS And JS Module **/
	public function setMedia()
	{
		parent::setMedia();
		$this->addCSS(Tools::getHttpHost(true) . __PS_BASE_URI__ . 'modules/cdesigner/views/css/stylesheets/font-awesome.css');
	    $this->addCSS(Tools::getHttpHost(true) . __PS_BASE_URI__ . 'modules/cdesigner/views/css/stylesheets/jquery-ui.css');
	    $this->addCSS(Tools::getHttpHost(true) . __PS_BASE_URI__ . 'modules/cdesigner/views/css/stylesheets/font.css');
	    $this->addCSS(Tools::getHttpHost(true) . __PS_BASE_URI__ . 'modules/cdesigner/views/css/stylesheets/styles.css');
	    $this->addCSS(Tools::getHttpHost(true) . __PS_BASE_URI__ . 'modules/cdesigner/views/css/stylesheets/cropper.css');
	}

	/** Init Function Controller **/
	public function initContent()
	{
		parent::initContent();
		$output = (int)Tools::getValue('output');
		$size = (int)Tools::getValue('s');
		$side_2 = (int)Tools::getValue('side_2');
		$mask = pSQL( Tools::getValue('mask') );
		$fonts = new CdesignerFontsModel();
		$fonts_list = $fonts->getFonts();
		$this->context->smarty->assign(array(
			'size' => $size,
			'output' => $output,
			'fonts' => $fonts_list,
			'side_2' => $side_2,
			'mask' => $mask,
			'urls_site' => Tools::getHttpHost(true) . __PS_BASE_URI__,
		));
		$this->setTemplate('module:cdesigner/views/templates/front/canvastp.tpl');
	}
}