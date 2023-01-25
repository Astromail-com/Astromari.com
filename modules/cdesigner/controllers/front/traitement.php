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

class CdesignerTraitementModuleFrontController extends ModuleFrontController
{
	public function init()
	{
		$this->page_name = 'traitement';
		parent::init();
	}
	public function initContent()
	{
		parent::initContent();

		if (!is_numeric(Tools::getValue('state')) || !is_numeric(Tools::getValue('id_input')) || !is_numeric(Tools::getValue('id_output'))) exit();

		$state = Tools::getValue('state');

		if ($state == 1)
		{
			Db::getInstance()->insert('cdesigner_output_design', array(
				'key_product_output' => pSQL(Tools::getValue('id_output')),
				'uri_phone_output'      => '_'.pSQL(Tools::getValue('id_output').'.png'),
				'uri_img_to_print'      => '_'.pSQL(Tools::getValue('id_output').'_.png'),
				'font_canvas'			=> pSQL(Tools::getValue("sfont")),
				'img_canvas'			=> pSQL(Tools::getValue("simg")),
				'size_canvas'			=> pSQL(Tools::getValue("scanvas")),
				'font_canvas_2'			=> pSQL(Tools::getValue("sfont_2")),
				'img_canvas_2'			=> pSQL(Tools::getValue("simg_2")),
				'size_canvas_2'			=> pSQL(Tools::getValue("scanvas_2"))
				)
			);

		}
		else if ($state == 2)
		{
			$output = pSQL(Tools::getValue("id_output"));
			$id_product = pSQL(Tools::getValue('id_input'));
			$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');
			$idProductAttribute = 0;
			if($output != ''){
				if (!$this->context->cart->id) {
	                $this->context->cart->add();
	                if ($this->context->cart->id) {
	                    $this->context->cookie->id_cart = (int) $this->context->cart->id;
	                }
	            }

				$product = new Product($id_product, true, (int)($this->context->cookie->id_lang));
				$field_ids = $product->getCustomizationFieldIds();
				$authorized_text_fields = array();
				foreach ($field_ids as $field_id) {
					if ($field_id['type'] == Product::CUSTOMIZE_TEXTFIELD) {
						$authorized_text_fields[(int) $field_id['id_customization_field']] = 'textField'.(int) $field_id['id_customization_field'];
					}
				}

				$indexes = array_flip($authorized_text_fields);
				foreach ($_POST as $field_name => $value) {
					if (in_array($field_name, $authorized_text_fields) && $value != '') {
						$this->context->cart->addTextFieldToProduct($id_product, $indexes[$field_name], Product::CUSTOMIZE_TEXTFIELD, $value);
					}
					/*
					elseif (in_array($field_name, $authorized_text_fields) && $value == '') {
						$this->context->cart->deleteCustomizationToProduct((int) $id_product, $indexes[$field_name]);
					}*/
				}
				$idProductAttribute = Db::getInstance()->executeS(
					'SELECT `id_customization` FROM `'._DB_PREFIX_.'customization` ORDER BY id_customization DESC LIMIT 1'
				);

				$price_per_side = floatval( Tools::getValue('sss') ) / 3333;
				$price_per_image = floatval( Tools::getValue('ssi') ) / 3333;
				$price_per_text = floatval( Tools::getValue('sst') ) / 3333;
				$total =  $price_per_side + $price_per_image + $price_per_text;
				$total = $total / (  1 +  ( ( floatval( Tools::getValue('data_rate') ) / 100 )  ) );

				Db::getInstance()->update('customized_data', ['price' => pSQL( $total) ], '`id_customization` = ' . $idProductAttribute[0]['id_customization']);

			}
			print $idProductAttribute[0]['id_customization'] .':'. $id_product;
		}
		else if ($state == 3)
		{
			$infos = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
						SELECT `id_custom_output`, `id_custom_product`, `id_combination`
						FROM '._DB_PREFIX_.'cdesigner_combination'
					);

			print Tools::jsonEncode($infos);
		}
		else if ($state == 4)
		{
			$infos = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
						SELECT `key_product_output`, `font_canvas`, `img_canvas`,`size_canvas`, `font_canvas_2`, `img_canvas_2`,`size_canvas_2`
						FROM '._DB_PREFIX_.'cdesigner_output_design'
					);

			print Tools::jsonEncode($infos);
		}
		else if ($state == 5 )
		{
			$loc = Tools::getValue('loc');
			$rot = Tools::getValue('rotate');
			$path = '';
			$source = NULL;
			$ext = Tools::substr($loc, -3);
			if (Tools::substr($loc, -3) == "png") {
			    $source = imagecreatefrompng($path . $loc);
			}
			else if ( Tools::substr($loc, -3) == "jpg" || Tools::substr($loc, -3) == "peg" ) {
			    $source = imagecreatefromjpeg($path . $loc);
			}
			var_dump($source);
			imagealphablending($source, false);
			imagesavealpha($source, true);
			$img = imagerotate($source, $rot, imageColorAllocateAlpha($source, 0, 0, 0, 127));
			imagealphablending($img, false);
			imagesavealpha($img, true);

			if (Tools::substr($loc, -3) == "png") {
			    imagepng($img, time().".".$ext);
			}
			else if ( Tools::substr($loc, -3) == "jpg" || Tools::substr($loc, -3) == "peg" ) {
			    imagejpeg($img, time().".".$ext);
			}



			/*
			var_dump($img);
			$decoded = base64_decode( $img );
			file_put_contents(dirname(__FILE__).'/../../views/img/dump/_'.time().".".$ext, $decoded);
			*/
			//echo $id.$ext;
		}
		else if ($state == 6 )
		{
			exit();
			$output = pSQL(Tools::getValue("id_output"));
			$id_product = pSQL(Tools::getValue('id_input'));
			$id_lang = (int)Configuration::get('PS_LANG_DEFAULT');

			$context = Context::getContext();
			$id = (int)$context->cookie->id_customer;
			$link = $context->link->getProductLink($id_product);

			if( is_numeric($id) && $id != 0 )
			{
				Db::getInstance()->insert('cdesigner_user_design', array(
					'id_user' => (int) $id,
					'id_design'  => pSQL($output),
					'url_design'  => pSQL($link) . '?design=' . pSQL($output),
					)
				);

				$html = filter_var(Tools::getValue('id'), FILTER_SANITIZE_SPECIAL_CHARS);
				$myfile = fopen( dirname(__FILE__).'/../../views/img/files/tpl/tp_'.$output.'.html', "w") or die("Unable to open file!");
				fwrite($myfile, $html);
				fclose($myfile);
				$subject = 'Your Custom Design Here';
				$donnees = array('{url}'  => $link . '?design=' . $output);
				$destinataire = $context->cookie->email;
				Mail::Send(intval($context->cookie->id_lang), 'design_sos', $subject , $donnees, $destinataire, NULL, NULL, NULL, NULL, NULL, dirname(__FILE__).'/../../mails/');

			}
		}
		else if ($state == 7)
		{
			$infos = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("
						SELECT `id_user`, `id_design`, `url_design`
						FROM "._DB_PREFIX_."cdesigner_user_design
						WHERE `id_user` = '". (int)$this->context->cookie->id_customer ."'
						ORDER BY `id_design` DESC
						"
					);
			print Tools::jsonEncode($infos);
		}
		else if ($state == 8)
		{
			$id_design = pSQL($_POST['id_design']);
			Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("
				DELETE FROM "._DB_PREFIX_."cdesigner_user_design
				WHERE `id_design` = '". $id_design ."'"
			);
		}
		exit();
	}
}
?>