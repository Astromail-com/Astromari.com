<?php
/**
 * 2016-2017 Leone MusicReader B.V.
 *
 * NOTICE OF LICENSE
 *
 * Source file is copyrighted by Leone MusicReader B.V.
 * Only licensed users may install, use and alter it.
 * Original and altered files may not be (re)distributed without permission.
 *
 * @author    Leone MusicReader B.V.
 *
 * @copyright 2016-2017 Leone MusicReader B.V.
 *
 * @license   custom see above
 */

/*if (!defined('_PS_VERSION_')) {
    exit;
}*/

class DirectLabelPrint extends Module
{
    private $myError;
    private $mySuc;

    public function __construct()
    {
        $this->name = 'directlabelprint';
        $this->tab = 'shipping_logistics';
        $this->version = '3.5.7';
        $this->author = 'Leoné MusicReader B.V.';
        $this->module_key = '5c2efd5cb56f8f718e91cf958b8fb489';

        $this->bootstrap=true;

        $this->controllers=array("AdminDirectLabelPrintController");

        parent::__construct();

        $this->displayName = $this->l('Direct Label Print - Address Edition');
        $this->description = $this->l('Add label print button in order details page. Works with Dymo label printers.');

        $this->prefix="dlp_ad_";

        if (!Tab::getIdFromClassName("AdminDirectLabelPrint")) {
            $this->installTabs();
        }
    }

    public function install()
    {
        if (!parent::install()
            || !$this->registerHook('backofficeheader')
            || !$this->registerHook('displayAdminOrder')
            || !$this->installTabs()
        ) {
            return false;
        }
        return true;
    }

    public function installTabs()
    {
        $tab = new Tab();
        $tab->class_name = "AdminDirectLabelPrint";
        $tab->active = true;
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = $this->l($tab->class_name);
        }
        $tab->id_parent = -1;
        $tab->module = $this->name;

        return  $tab->save();
    }

    /*public function createDBTable()
    {
        Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dlpa_templates` (
            `id_dlpa_templates` varchar(40) NOT NULL,
            `template` MEDIUMTEXT NOT NULL,
            PRIMARY KEY (`id_dlppa_templates`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;');
        return true;
    }*/

    public function hookbackofficeheader($params)
    {
        $this->context->controller->addJquery();

        $c_ctrl=$this->context->controller;
        if (method_exists($c_ctrl, "addJS")) {
            if (strpos($_SERVER['QUERY_STRING'], "directlabelprint")) {
                //include riot.js -->
                $c_ctrl->addJS(($this->_path) ."views/js/riot+compiler.min.js", 'all');
                $c_ctrl->addJS(($this->_path) ."views/js/riot.min.js", 'all');
            }
            $c_ctrl->addJS(($this->_path) . 'views/js/directlabelprint.js', 'all');
            $printerset=Configuration::get('label_printertypeset');
            $justsubmitted=(Configuration::get('label_printertype') && !Tools::isSubmit('printertype_submit'));
            $isDymo=$justsubmitted || (Tools::isSubmit('printertype_submit') && Tools::getValue('printertype'));
            if ($isDymo && $printerset) {//Dymo
                $c_ctrl->addJS(($this->_path) . 'views/js/dymo.connect.framework.js', 'all');
                $c_ctrl->addJS(($this->_path) . 'views/js/dymo_fix.js', 'all');
            } else { //Generic Printer
                $c_ctrl->addJS(($this->_path) . 'views/js/genericprintersupport.js', 'all');
                $c_ctrl->addJS(($this->_path) . 'views/js/html2canvas.js', 'all');
                $c_ctrl->addJS(($this->_path) . 'views/js/canvas2svg.js', 'all');
                $c_ctrl->addJS(($this->_path) . 'views/js/JsBarcode.all.min.js', 'all');
                $c_ctrl->addJS(($this->_path) . 'views/js/qrcode.js', 'all');
            }
            if ($printerset || Tools::isSubmit('printertype_submit')) {
                if (strpos($_SERVER['QUERY_STRING'], "directlabelprint")) {//Only on module configuration page
                    $c_ctrl->addJS(($this->_path) . 'views/js/summernote-lite.js', 'all');
                    $c_ctrl->addCSS(($this->_path) . 'views/css/summernote-lite.css', 'all');
                }
            }
            if (strpos($_SERVER['QUERY_STRING'], "directlabelprint")) {//Only on module configuration page
                $c_ctrl->addCSS(($this->_path) . 'views/css/settings.css', 'all');
            }

            $c_ctrl->addCSS(($this->_path) . 'views/css/directlabelprint.css', 'all');

            $token=Module::getInstanceByName('directlabelprint')->getSecurityToken();
            //$producttoken="";
            $addProductLabelsToPrint="false";
            $dlpp_controller_url="";
            if (Module::getInstanceByName('directlabelprintproduct')) {
                //check if other module exists and setting active
                $dlpp_controller_url = Module::getInstanceByName('directlabelprintproduct')->getControllerURL();
                if (Configuration::get('printproductlabels')) {
                    $addProductLabelsToPrint = "true";
                }
            }
            $url = Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/directlabelprint/MyText.label';

            $printproductlabels_count="false";
            if (Configuration::get('printproductlabels_count')) {
                $printproductlabels_count = "true";
            }
            $printproductlabels_hideaddress="false";
            if (Configuration::get('printproductlabels_hideaddress')) {
                $printproductlabels_hideaddress = "true";
            }

            $w=Configuration::get($this->prefix.'width_input');
            if (!$w) {
                $w = 100;
            }
            $h=Configuration::get($this->prefix.'height_input');
            if (!$h) {
                $h = 50;
            }
            $r=Configuration::get($this->prefix.'rotate_image');
            if (!$r) {
                $r = 0;
            }
            $printertypeset="true";
            if (!Configuration::get('label_printertypeset')) {
                $printertypeset = "false";
            }

            //SDI selected printer
            $selectedDymoIndex=Configuration::get('selectedDymoIndex_dlpa', null, null, null, 0);
            if (!$selectedDymoIndex) {
                $selectedDymoIndex = 0;
            }

            $dymoPrinterIndex=Configuration::get('dymoPrinterIndex_dla');
            if ($dymoPrinterIndex!=1 && $dymoPrinterIndex!="1") {
                $dymoPrinterIndex = 0;
            }

            $changeorderstatus="false";
            if (Configuration::get($this->prefix.'changeorderstatus')) {
                $changeorderstatus = "true";
            }

            $dlp_auto_order_status=Configuration::get($this->prefix.'auto_order_status');
            if (!$dlp_auto_order_status) {
                $dlp_auto_order_status = -1; //Default
            }

            $this->smarty->assign(array(
                'token'=> $token,
                'url' => $url,
                'shop_root' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__,
                'printertypeset' => $printertypeset,
                'addProductLabelsToPrint' => $addProductLabelsToPrint,
                'changeorderstatus' => $changeorderstatus,
                'dlp_auto_order_status' => $dlp_auto_order_status,
                'generic_label_width' => $w,
                'generic_label_height' => $h,
                'generic_label_rotate' => $r,
                'generic_label_content' => preg_replace("/\r|\n/", "", $this->getLabelTemplate()),
                'printproductlabels_count'=> $printproductlabels_count,
                'printproductlabels_hideaddress'=> $printproductlabels_hideaddress,
                'dymoPrinterIndex'=>$dymoPrinterIndex,
                'selectedDymoIndex'=>$selectedDymoIndex,
                'dlpa_controller_url'=>$this->getDLPAControllerURL(),
                'dlpp_controller_url'=>$dlpp_controller_url
            ));

            return $this->display(__FILE__, 'views/templates/admin/header_orders.tpl');
        }
    }



    public function hookdisplayAdminOrder()
    {
        $id=(int)Tools::getValue('id_order');
        $token=Module::getInstanceByName('directlabelprint')->getSecurityToken();
        $addProductLabelsToPrint="false";
        $dlpp_controller_url="";
        if (Module::getInstanceByName('directlabelprintproduct')) { //check if other module exists and setting active
            $dlpp_controller_url = Module::getInstanceByName('directlabelprintproduct')->getControllerURL();
            if (Configuration::get('printproductlabels')) {
                $addProductLabelsToPrint = "true";
            }
        }
        $order = new Order($id);
        $reference=$order->reference;

        $printproductlabels_count="false";
        if (Configuration::get('printproductlabels_count')) {
            $printproductlabels_count = "true";
        }
        $printproductlabels_hideaddress="false";
        if (Configuration::get('printproductlabels_hideaddress')) {
            $printproductlabels_hideaddress = "true";
        }

        $delivery = $this->getDeliver();
        $invoice = $this->getInvoice();
        $linedeliver = $this->getlinesString($delivery);
        $lineinvoice = $this->getlinesString($invoice);
        $url = Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__
            . 'modules/directlabelprint/MyText.label';

        $w=Configuration::get($this->prefix.'width_input');
        if (!$w) {
            $w = 100;
        }
        $h=Configuration::get($this->prefix.'height_input');
        if (!$h) {
            $h = 50;
        }
        $r=Configuration::get($this->prefix.'rotate_image');
        if (!$r) {
            $r = 0;
        }
        $printertypeset="true";
        if (!Configuration::get('label_printertypeset')) {
            $printertypeset = "false";
        }

        //SDI selected printer
        $selectedDymoIndex=Configuration::get('selectedDymoIndex_dlpa', null, null, null, 0);
        if (!$selectedDymoIndex) {
            $selectedDymoIndex = 0;
        }

        $dymoPrinterIndex=Configuration::get('dymoPrinterIndex_dla');
        if ($dymoPrinterIndex!=1 && $dymoPrinterIndex!="1") {
            $dymoPrinterIndex = 0;
        }

        $changeorderstatus="false";
        if (Configuration::get($this->prefix.'changeorderstatus')) {
            $changeorderstatus = "true";
        }

        $dlp_auto_order_status=Configuration::get($this->prefix.'auto_order_status');
        if (!$dlp_auto_order_status) {
            $dlp_auto_order_status = -1; //Default
        }

        $this->smarty->assign(array(
            'stringdeliver' => $linedeliver,
            'stringinvoice' => $lineinvoice,
            'deliver' => $delivery,
            'invoice' => $invoice,
            'url' => $url,
            'shop_root' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__,
            'id'=> $id,
            'reference'=> $reference,
            'token'=> $token,
            'addProductLabelsToPrint' => $addProductLabelsToPrint,
            'changeorderstatus' => $changeorderstatus,
            'dlp_auto_order_status' => $dlp_auto_order_status,
            'printertypeset' => $printertypeset,
            'generic_label_width' => $w,
            'generic_label_height' => $h,
            'generic_label_rotate' => $r,
            'generic_label_content' => preg_replace("/\r|\n/", "", $this->getLabelTemplate()),
            'selectedDymoIndex'=>$selectedDymoIndex,
            'dymoPrinterIndex'=>$dymoPrinterIndex,
            'printproductlabels_count'=> $printproductlabels_count,
            'printproductlabels_hideaddress'=> $printproductlabels_hideaddress,
            'dlpa_controller_url'=>$this->getDLPAControllerURL(),
            'dlpp_controller_url'=>$dlpp_controller_url
        ));
        return $this->display(__FILE__, 'views/templates/admin/header.tpl');
    }

    private function getDLPAControllerURL()
    {
        return Context::getContext()->link->getAdminLink('AdminDirectLabelPrint', true)."&ajax=true";
    }

    public function getDeliver($order = null)
    {
        if ($order == null) {
            $order = new Order((int)Tools::getValue('id_order'));
        } else {
            $order = new Order($order);
        }

        $addressDelivery = new Address($order->id_address_delivery, $this->context->language->id);
        $data = array();
        foreach ($addressDelivery as $key => $value) {
            $data[$key] = $value;
        }
        if ($data['id_country']) {
            $country = new Country((int)$data['id_country'], $this->context->language->id);
            $data['iso_code'] = $country->iso_code;
            $data['country'] = $country->name;
        }
        if ($data['id_state'] && !isset($data['state'])) {
            $data['state'] = State::getNameById($data['id_state']);
            $data['state_iso']= $this->getStateIsoById($data['id_state']);
        } else {
            $data['state'] = "";
        }
        if (!isset($data['city'])) {
            $data['city'] = '';
        }
        if (!isset($data['company'])) {
            $data['company'] = '';
        }
        if (!isset($data['address2'])) {
            $data['address2'] = '';
        }

        return $data;
    }

    public function getInvoice($order = null)
    {
        if ($order == null) {
            $order = new Order((int)Tools::getValue('id_order'));
        } else {
            $order = new Order($order);
        }

        $addressInvoice = new Address($order->id_address_invoice, $this->context->language->id);
        $data = array();
        foreach ($addressInvoice as $key => $value) {
            $data[$key] = $value;
        }
        if ($data['id_country']) {
            $country = new Country((int)$data['id_country'], $this->context->language->id);
            $data['iso_code'] = $country->iso_code;
            $data['country'] = $country->name;
        }
        if ($data['id_state'] && !isset($data['state'])) {
            $data['state'] = State::getNameById($data['id_state']);
            $data['state_iso']= $this->getStateIsoById($data['id_state']);
        } else {
            $data['state'] = "";
        }

        if (!isset($data['city'])) {
            $data['city'] = '';
        }
        if (!isset($data['company'])) {
            $data['company'] = '';
        }
        if (!isset($data['address2'])) {
            $data['address2'] = '';
        }

        return $data;
    }

    public function getlinesString($data)
    {
        require_once("addressformat.php");

        $lines = DLPAddressFormatter::convertAddressFormat($data);

        //Remove HOME Country
        $home_country = Tools::strtoupper(Configuration::get('PS_SHOP_COUNTRY'));
        if ($lines[count($lines) - 1] == $home_country) {
            unset($lines[count($lines) - 1]);
        }

        $linesString = "";
        foreach ($lines as $line) {
            $linesString = $linesString . "*" . $line . "*";
        }
        $linesString = str_replace("**", "||", $linesString);
        $linesString = str_replace("*", "", $linesString);
        $linesString = str_replace("'", "&#039;", $linesString);
        return $linesString;
    }

    private function uploadlabel()
    {
        $file_path = $_FILES["filelabel"]["tmp_name"];
        $file_name = $_FILES["filelabel"]["name"];
        $extension = $this->getExtension($file_name);
        if ($extension == '.label' || $extension == '.labelx' || $extension == '.dlabel' || $extension == '.dymo') {
            $labelfile = 'MyText.label';
            $new_path = dirname(__FILE__) . '/' . $labelfile;

            if (move_uploaded_file($file_path, $new_path)) {
                $this->mySuc = $this->l('Label updated successfully.');
                return true;
            };
        } else {
            $extensions=" .label / .dymo / .labelx / .dlabel.";
            $this->myError = $this->l('File type is invalid. Dymo templates have extension').$extensions;
        }
        if (empty($this->myError)) {
            $this->myError = $this->l('There was problem while uploading file.');
        }
        return false;
    }

    public function getExtension($str)
    {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $ext = Tools::substr($str, $i);
        return Tools::strtolower($ext);
    }

    public function displayForm()
    {
        $sampletemplateurl_label = Tools::getShopDomainSsl(true, true)
            . __PS_BASE_URI__
            . 'modules/directlabelprint/MyText_sample.label';
        $sampletemplateurl_connect = Tools::getShopDomainSsl(true, true)
            . __PS_BASE_URI__
            . 'modules/directlabelprint/DymoConnect_sample.dymo';

        $printlabels="false";
        if (Configuration::get('printproductlabels')) {
            $printlabels = "true";
        }
        $printproductlabels_count="false";
        if (Configuration::get('printproductlabels_count')) {
            $printproductlabels_count = "true";
        }
        $printproductlabels_hideaddress="false";
        if (Configuration::get('printproductlabels_hideaddress')) {
            $printproductlabels_hideaddress = "true";
        }

        $changeorderstatus="false";
        if (Configuration::get($this->prefix.'changeorderstatus')) {
            $changeorderstatus = "true";
        }

        $dlp_auto_order_status=Configuration::get($this->prefix.'auto_order_status');
        if (!$dlp_auto_order_status) {
            $dlp_auto_order_status = -1; //Default
        }

        $printertype="false"; //Genreic Printer
        if (Configuration::get('label_printertype')) {
            $printertype = "true"; //Dymo
        }
        $printertypeerror=$this->l("Please select printer type and press SAVE");
        if (Configuration::get('label_printertypeset')) {
            $printertypeerror=null;
        }

        $dymosoftwaretype="false";
        if (Configuration::get('label_dymosoftwaretype')) {
            $dymosoftwaretype = "true";
        }

        $width_input="100";
        if (Configuration::get($this->prefix.'width_input')) {
            $width_input=Configuration::get($this->prefix.'width_input');
        }
        $height_input="50";
        if (Configuration::get($this->prefix.'height_input')) {
            $height_input=Configuration::get($this->prefix.'height_input');
        }
        $rotate_image="false";
        if (Configuration::get($this->prefix.'rotate_image')) {
            $rotate_image = "true";
        }

        $label_content=$this->getLabelTemplate();

        //SDI selected printer
        $selectedDymoIndex=Configuration::get('selectedDymoIndex_dlpa', null, null, null, 0);
        if (!$selectedDymoIndex) {
            $selectedDymoIndex = 0;
        }

        $dymoPrinterIndexActive="false";
        $dymoPrinterIndex=Configuration::get('dymoPrinterIndex_dla');
        if ($dymoPrinterIndex!=1 && $dymoPrinterIndex!="1") {
            $dymoPrinterIndex = 0;
        } else {
            $dymoPrinterIndexActive="true";
        }

        $this->smarty->assign(array(
            'sampletemplateurl_connect' => $sampletemplateurl_connect,
            'sampletemplateurl_label' => $sampletemplateurl_label,
            'formactionurl' => $_SERVER['REQUEST_URI'],
            'error' => $this->myError,
            'success' => $this->mySuc,
            'iconurl' => ($this->_path) . 'views/img/icon-print-16.png',
            'printicon' => ($this->_path) . 'views/img/icon-print.png',
            'imgfolder' => ($this->_path) . 'views/img/',
            'printproductlabels' => $printlabels,
            'changeorderstatus' => $changeorderstatus,
            'dlp_auto_order_status' => $dlp_auto_order_status,
            'printertype' => $printertype,
            'dymosoftwaretype' => $dymosoftwaretype,
            'printertypeerror' => $printertypeerror,
            'width_input' => $width_input,
            'height_input' => $height_input,
            'rotate_image' => $rotate_image,
            'label_content' => $label_content,
            'selectedDymoIndex' => $selectedDymoIndex,
            'dymoPrinterIndex'=>$dymoPrinterIndex,
            'dymoPrinterIndexActive'=>$dymoPrinterIndexActive,
            'printproductlabels_count'=> $printproductlabels_count,
            'printproductlabels_hideaddress'=> $printproductlabels_hideaddress,
            'barcode_sample_url' => ($this->_path) . 'views/img/barcode.svg',
            'qrcode_sample_url' => ($this->_path) . 'views/img/qrcode.svg',
            'openSettingsArea'=> Tools::getValue('settingsArea')
        ));
        $html=$this->display(__FILE__, 'views/templates/admin/prestui/ps-tags.tpl');
        return $html.$this->display(__FILE__, 'views/templates/admin/settings.tpl');
    }

    public function getLabelTemplate()
    {
        $label_content=urldecode(Configuration::get($this->prefix.'label_content'));
        if (!Configuration::get($this->prefix.'label_content')) {
            $label_content = '<p><span style="font-size: 34px;">[[ShippingAddress]]</span></p>';
        }
        return $label_content;
    }

    public function getDymoTemplate()
    {
        return Tools::file_get_contents(dirname(__FILE__) ."/MyText.label");
    }

    public function getContent()
    {
        if (Tools::isSubmit('upload')) {
            $this->uploadlabel() ;
        }
        if (Tools::isSubmit('printertype_submit')) {
            Configuration::updateValue('label_printertype', Tools::getValue('printertype'));
            Configuration::updateValue('label_printertypeset', "set");
            Configuration::updateValue('label_dymosoftwaretype', Tools::getValue('dymosoftwaretype'));
            $this->mySuc=$this->l("Printer settings updated successfully.");
        }
        if (Tools::isSubmit('settings')) {
            if (Module::getInstanceByName('directlabelprintproduct')) {
                Configuration::updateValue('printproductlabels', Tools::getValue('printproductlabels'));
                $this->mySuc=$this->l("Settings updated successfully.");
            } elseif (Tools::getValue('printproductlabels')) {
                $err=$this->l('You need Direct Label Print Product/Barcode Edition installed for this feature.');
                $this->myError = $err;
            } else {
                Configuration::updateValue('printproductlabels', Tools::getValue('printproductlabels'));
                $this->mySuc=$this->l("Settings updated successfully.");
            }

            $hide_address_value=Tools::getValue('printproductlabels_hideaddress');
            Configuration::updateValue('printproductlabels_hideaddress', $hide_address_value);
            Configuration::updateValue('printproductlabels_count', Tools::getValue('printproductlabels_count'));
        }
        if (Tools::isSubmit('orderStatusSettings')) {
            if (Module::getInstanceByName('directstatusupdate')) {
                Configuration::updateValue($this->prefix.'changeorderstatus', Tools::getValue('changeorderstatus'));
                Configuration::updateValue($this->prefix.'auto_order_status', Tools::getValue('auto_order_status'));
                $this->mySuc=$this->l("Settings updated successfully.");
            } elseif (Tools::getValue('changeorderstatus')) {
                $this->myError = $this->l('You need Direct Status Update installed for this feature.');
                Configuration::updateValue($this->prefix.'changeorderstatus', false);
            } else {
                Configuration::updateValue($this->prefix.'changeorderstatus', false);
                $this->mySuc=$this->l("Settings updated successfully.");
            }
        }
        if (Tools::isSubmit('dymoSettings')) {
            Configuration::updateValue('dymoPrinterIndex_dla', Tools::getValue('dymoPrinterIndex'));
            Configuration::updateValue('selectedDymoIndex_dlpa', Tools::getValue('selectedDymoIndex')); //SDI
            $this->mySuc=$this->l("Printer settings updated successfully.");
        }

        if (Tools::isSubmit('generic_label_submit')) {
            Configuration::updateValue($this->prefix.'width_input', Tools::getValue('width_input'));
            Configuration::updateValue($this->prefix.'height_input', Tools::getValue('height_input'));
            Configuration::updateValue($this->prefix.'rotate_image', Tools::getValue('rotate_image'));
            Configuration::updateValue($this->prefix.'label_content', urlencode(Tools::getValue('label_content')));
            $this->mySuc=$this->l("Template saved successfully.");
        }

        return $this->displayForm();
    }

    public function getStateIsoById($id_state)
    {
        $result = Db::getInstance()->getRow('
		SELECT `iso_code`
		FROM `'._DB_PREFIX_.'state`
		WHERE `id_state` = '.(int)$id_state);
        return $result['iso_code'];
    }

    public function getOrderedProducts($id)
    {
        error_reporting(E_ALL);
        $order = new Order($id);
        $products=$order->getProducts();
        return $products;
    }

    public function getOrderInfo($id)
    {

        $order = new Order($id);
        $data=array();

        $addressInvoice = new Address($order->id_address_invoice, $this->context->language->id);
        $addressDelivery = new Address($order->id_address_delivery, $this->context->language->id);

        $data["address_shipping_country"]=$addressDelivery->country;
        $data["address_shipping_company"]=$addressDelivery->company;
        $data["address_shipping_name"]=$addressDelivery->firstname." ".$addressDelivery->lastname;
        $data["address_shipping_address1"]=$addressDelivery->address1;
        $data["address_shipping_address2"]=$addressDelivery->address2;
        $data["address_shipping_postcode"]=$addressDelivery->postcode;
        $data["address_shipping_city"]=$addressDelivery->city;
        $data["address_shipping_other"]=$addressDelivery->other;
        $data["address_shipping_state"]=$this->getStateIsoById($addressDelivery->id_state);
        $data["address_shipping_country"]=$addressDelivery->country;

        $data["address_billing_country"]=$addressInvoice->country;
        $data["address_billing_company"]=$addressInvoice->company;
        $data["address_billing_name"]=$addressInvoice->firstname." ".$addressInvoice->lastname;
        $data["address_billing_address1"]=$addressInvoice->address1;
        $data["address_billing_address2"]=$addressInvoice->address2;
        $data["address_billing_postcode"]=$addressInvoice->postcode;
        $data["address_billing_city"]=$addressInvoice->city;
        $data["address_billing_other"]=$addressInvoice->other;
        $data["address_billing_state"]=$this->getStateIsoById($addressInvoice->id_state);
        $data["address_billing_country"]=$addressInvoice->country;

        $data["vat_number"]=$addressDelivery->vat_number;
        $data["telephone_invoice"]=$addressInvoice->phone;
        $data["telephone_delivery"]=$addressDelivery->phone;
        $data["mobile_invoice"]=$addressInvoice->phone_mobile;
        $data["mobile_delivery"]=$addressDelivery->phone_mobile;
        $data["order_reference"]=$order->reference;
        $data["order_id"]="".$order->id;
        $data["invoice_number"]="".$order->invoice_number;

        $customer = new Customer($order->id_customer);
        $data["customer_email"]=$customer->email;

        $data["tracking_number"]="".$order->shipping_number;
            $id_order_carrier = Db::getInstance()->getValue('
                SELECT `id_order_carrier`
                FROM `'._DB_PREFIX_.'order_carrier`
                WHERE `id_order` = '.(int)$id);

        if ($id_order_carrier) {
            $order_carrier = new OrderCarrier($id_order_carrier);
            $data["tracking_number"]=$order_carrier->tracking_number;
        }

        //New/Existing Customer
        $order_number=Order::getCustomerNbOrders($order->id_customer);
        $data["first_order"]="NO";
        if ($order_number==1) {
            $data["first_order"]="YES";
        }

        //Shipping Method
        $order_carrier = new Carrier($order->id_carrier);
        $data["shipping_method"]=$order_carrier->name;
        return $data;
    }

    public function getSecurityToken()
    {
        $passwd="DLP9876DirectLabelPrint";
        return Tools::encrypt($passwd);
    }

    public function displayLabelLink($token, $id, $name)
    {
        $js=$token.$name;//dummy

        $delivery = $this->getDeliver($id);
        $linedeliver = $this->getlinesString($delivery);

        $url = Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/directlabelprint/MyText.label';
        //$url_base=Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ ;
        //$url_product_template = $url_base . 'modules/directlabelprintproduct/MyText.label';

        $tpl_file=dirname(__FILE__)."/views/templates/admin/list_action_label.tpl";
        $tpl =  $this->context->smarty->createTemplate($tpl_file);
        /*if (!array_key_exists('Label', self::$cache_lang)) {
            self::$cache_lang['Label'] = $this->l('Label', 'Helper');
        }*/

        if (Module::getInstanceByName('directlabelprintproduct') && Configuration::get('printproductlabels')) {
            //Print both address and product labels
            $order = new Order($id);
            $reference=$order->reference;
            $js="id_order=".$id.";var callbackProducts=printProducts.bind(this,'".$id.
                "','".$reference."',callback,isLast);".
                "if(!printproductlabels_hideaddress){".
                "printLabel('".$url."',convertAddressLines('".$linedeliver."'),callbackProducts);".
                "}else{".
                "callbackProducts();".
                "}".
                "callback=undefined;callbackProducts=undefined;changeOrderStatusOfOrder(id_order);";
        } else {
            $js="id_order=".$id.";printLabel('".$url."',convertAddressLines('".$linedeliver."'),callback,isLast);"
                ."changeOrderStatusOfOrder(id_order);";
            $js=$js."callback=undefined;";
            //print only address labels
        }
        $tpl->assign(array(
            'jscode' => $js,
            'action' => 'Label',//self::$cache_lang['Label'],
            'id' => $id
        ));

        return $tpl->fetch();
    }

    public function upgradeOverride()
    {
        $override_path=_PS_OVERRIDE_DIR_."controllers/admin/AdminOrdersController.php";

        if (file_exists($override_path)) {
            $replace="\$delivery = Module::getInstanceByName('directlabelprint')->getDeliver(\$id);";
            $replaceby="return Module::getInstanceByName('directlabelprint')->displayLabelLink(\$token, \$id, \$name);";
            $file_contents=Tools::file_get_contents($override_path);
            $file_contents=str_replace($replace, $replaceby, $file_contents);
            file_put_contents($override_path, $file_contents);
            return true;
        } else {
            return true;
        }
    }
}
