<?php
/**
 * Copyright 2022 LÍNEA GRÁFICA E.C.E S.L.
 *
 * @author    Línea Gráfica E.C.E. S.L.
 * @copyright Lineagrafica.es - Línea Gráfica E.C.E. S.L. all rights reserved.
 * @license   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class LGDropShipping extends Module
{
    protected $error = false;
    public $bootstrap;

    public function __construct()
    {
        $this->name = 'lgdropshipping';
        $this->tab = 'shipping_logistics';
        $this->version = '1.2.17';
        $this->author = 'Línea Gráfica';
        $this->module_key = '1e7232ca14138003f61b0cec10b5442d';
        parent::__construct();
        $this->bootstrap = true;
        $this->displayName = $this->l('Dropshipping - Emails to Suppliers and Carriers');
        $this->description = $this->l('Send your dropshipping orders automatically to suppliers and carriers.');
        $this->confirmUninstall = $this->l('Are you sure that you want to uninstall the module?');
    }

    public function install()
    {
        if (parent::install() == false || $this->registerHook('actionOrderStatusPostUpdate') == false) {
            return false;
        }
        // tables
        $query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'lgdropshipping_supplier` (
                  `id_supplier` int(11) NOT NULL,
                  `contact_supplier` text NOT NULL,
                  `email_supplier` text NOT NULL,
                  `email_supplier2` text NOT NULL,
                  `supplier_subject` text NOT NULL,
                  `supplier_template` text NOT NULL,
                  `supplier_invoice` int(1),
                  `supplier_slip` int(1),
                  UNIQUE KEY `id_supplier` (`id_supplier`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        if (!Db::getInstance()->Execute($query)) {
            return false;
        }
        $query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'lgdropshipping_carrier` (
                  `id_reference` int(11) NOT NULL,
                  `contact_carrier` text NOT NULL,
                  `email_carrier` text NOT NULL,
                  `email_carrier2` text NOT NULL,
                  `carrier_subject` text NOT NULL,
                  `carrier_template` text NOT NULL,
                  `carrier_invoice` int(1),
                  `carrier_slip` int(1),
                  UNIQUE KEY `id_reference` (`id_reference`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        if (!Db::getInstance()->Execute($query)) {
            return false;
        }
        $query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'lgdropshipping_order_state_supplier` (
                  `id_order_state_supplier` int(11) NOT NULL,
                  KEY `id_orderstate_supplier` (`id_order_state_supplier`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        if (!Db::getInstance()->Execute($query)) {
            return false;
        }
        $query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'lgdropshipping_order_state_carrier` (
                  `id_order_state_carrier` int(11) NOT NULL,
                  KEY `id_orderstate_carrier` (`id_order_state_carrier`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        if (!Db::getInstance()->Execute($query)) {
            return false;
        }
        $query = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'lgdropshipping_carrier_to_supplier` (
                  `id_reference` int(11) NOT NULL,
                  `id_supplier` int(11) NOT NULL,
                  UNIQUE KEY `id_supplier` (`id_supplier`),
                  KEY `id_reference` (`id_reference`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        if (!Db::getInstance()->Execute($query)) {
            return false;
        }
        // main langs, english by default
        $default_lang = $this->context->language->id;
        $lang = Language::getIsoById($default_lang);
        $suppliers = Db::getInstance()->ExecuteS('SELECT name, id_supplier FROM '._DB_PREFIX_.'supplier');
        foreach ($suppliers as $supplier) {
            if ($lang == 'en') {
                $title = 'Dropshipping Notification - Preparation in Progress - Order {ORDER_REF}';
                $text = 'Dear {SUPPLIER_NAME}. Please prepare the order #{ORDER_REF} of {CUSTOMER_NAME} that '.
                    'contains the following items: {PRODUCTS} The package will be sent with the delivery '.
                    'method {CARRIER_NAME} to the following address: {CUSTOMER_ADDRESS} Best regards,';
            } elseif ($lang == 'fr') {
                $title = 'Notification de Dropshipping - Commande en Préparation - Commande {ORDER_REF}';
                $text = 'Cher {SUPPLIER_NAME}. Veuillez préparer s\'il vous plaît la commande #{ORDER_REF} '.
                    'destinée à {CUSTOMER_NAME} contenant les articles suivants : {PRODUCTS} Le colis sera '.
                    'envoyé avec la méthode de livraison {CARRIER_NAME} à l\'adresse suivante : '.
                    '{CUSTOMER_ADDRESS} Cordialement,';
            } elseif ($lang == 'es') {
                $title = 'Aviso de Dropshipping - Preparación de Pedido - Pedido {ORDER_REF}';
                $text = 'Estimado {SUPPLIER_NAME}. Por favor prepare el pedido #{ORDER_REF} del cliente '.
                    '{CUSTOMER_NAME} que contiene los productos siguientes: {PRODUCTS} Se mandará el paquete '.
                    'mediante el transportista {CARRIER_NAME} a la dirección siguiente: {CUSTOMER_ADDRESS} '.
                    'Un saludo,';
            } else {
                $title = 'Dropshipping Notification - Preparation in Progress - Order {ORDER_REF}';
                $text = 'Dear {SUPPLIER_NAME}. Please prepare the order #{ORDER_REF} of {CUSTOMER_NAME} that '.
                    'contains the following items: {PRODUCTS} The package will be sent with the delivery '.
                    'method {CARRIER_NAME} to the following address: {CUSTOMER_ADDRESS} Best regards,';
            }
            Db::getInstance()->Execute(
                'INSERT INTO '._DB_PREFIX_.'lgdropshipping_supplier (id_supplier, contact_supplier, '.
                'supplier_subject, supplier_template, supplier_invoice, supplier_slip) VALUES '.
                '(\''.pSQL($supplier['id_supplier']).'\', \''.pSQL($supplier['name']).'\', '.
                '\''.pSQL($title, 'html').'\', \''.pSQL($text, 'html').'\', \'1\', \'0\')'
            );
            Db::getInstance()->Execute(
                'INSERT INTO '._DB_PREFIX_.'lgdropshipping_carrier_to_supplier '.
                '(id_reference, id_supplier) VALUES (\'0\', \''.pSQL($supplier['id_supplier']).'\')'
            );
        }
        $carriers = Db::getInstance()->ExecuteS(
            'SELECT id_reference, name '.
            'FROM '._DB_PREFIX_.'carrier '.
            'GROUP BY id_reference'
        );
        foreach ($carriers as $carrier) {
            if ($lang == 'en') {
                $title = 'Dropshipping Notification - Package Pick-Up - Order {ORDER_REF}';
                $text = 'Dear {CARRIER_NAME}. Please pick up the order #{ORDER_REF} in the company {SUPPLIER_NAME} '.
                    'located at the following address: {SUPPLIER_ADDRESS} Please send the package to the '.
                    'following address: {CUSTOMER_ADDRESS} Best regards,';
            } elseif ($lang == 'fr') {
                $title = 'Notification de Dropshipping - Collecte du Colis - Commande {ORDER_REF}';
                $text = 'Cher {CARRIER_NAME}. Veuillez récupérer s\'il vous plaît la commande #{ORDER_REF} dans '.
                    'l\'entreprise {SUPPLIER_NAME} située à l\'adresse suivante : {SUPPLIER_ADDRESS} Merci '.
                    'd\'envoyer le colis à l\'adresse suivante : {CUSTOMER_ADDRESS} Cordialement,';
            } elseif ($lang == 'es') {
                $title = 'Aviso de Dropshipping - Recogida de Pedido - Pedido {ORDER_REF}';
                $text = 'Estimado {CARRIER_NAME}. Por favor recoge el pedido #{ORDER_REF} en la empresa '.
                    '{SUPPLIER_NAME} ubicada en: {SUPPLIER_ADDRESS} Y mande el paquete a la direccion '.
                    'siguiente: {CUSTOMER_ADDRESS} Un saludo,';
            } else {
                $title = 'Dropshipping Notification - Package Pick-Up - Order {ORDER_REF}';
                $text = 'Dear {CARRIER_NAME}. Please pick up the order #{ORDER_REF} in the company {SUPPLIER_NAME} '.
                    'located at the following address: {SUPPLIER_ADDRESS} Please send the package to the '.
                    'following address: {CUSTOMER_ADDRESS} Best regards,';
            }
            Db::getInstance()->Execute(
                'INSERT INTO '._DB_PREFIX_.'lgdropshipping_carrier (id_reference, contact_carrier, '.
                'carrier_subject, carrier_template, carrier_invoice, carrier_slip) VALUES '.
                '(\''.pSQL($carrier['id_reference']).'\', \''.pSQL($carrier['name']).'\', '.
                '\''.pSQL($title, 'html').'\', \''.pSQL($text, 'html').'\', \'0\', \'1\')'
            );
        }
        if (!Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'lgdropshipping_order_state_supplier')) {
            $order_state = Db::getInstance()->getValue(
                'SELECT id_order_state '.
                'FROM '._DB_PREFIX_.'order_state WHERE paid = 1'
            );
            Db::getInstance()->Execute(
                'INSERT INTO '._DB_PREFIX_.'lgdropshipping_order_state_supplier '.
                'VALUES ('.pSQL($order_state).')'
            );
        }
        if (!Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'lgdropshipping_order_state_carrier')) {
            $order_state = Db::getInstance()->getValue(
                'SELECT id_order_state '.
                'FROM '._DB_PREFIX_.'order_state WHERE shipped = 1'
            );
            Db::getInstance()->Execute(
                'INSERT INTO '._DB_PREFIX_.'lgdropshipping_order_state_carrier '.
                'VALUES ('.pSQL($order_state).')'
            );
        }
        /* Default value */
        if (!Configuration::updateValue('PS_LGDROPSHIPPING_ASSOCIATION', '0')
        ) {
            return false;
        }
        return true;
    }

    public function uninstall()
    {
        if (parent::uninstall() == false) {
            return false;
        }
        if (!Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'lgdropshipping_supplier')) {
            return false;
        }
        if (!Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'lgdropshipping_carrier')) {
            return false;
        }
        if (!Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'lgdropshipping_order_state_supplier')) {
            return false;
        }
        if (!Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'lgdropshipping_order_state_carrier')) {
            return false;
        }
        if (!Db::getInstance()->Execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'lgdropshipping_carrier_to_supplier')) {
            return false;
        }
        return true;
    }

    private function getSuppliers()
    {
        return Db::getInstance()->ExecuteS(
            'SELECT *, 
                s.id_supplier AS supplierid, 
                s.name, 
                ls.supplier_subject AS subject, 
                ls.supplier_template AS template,
                ls.supplier_slip as slip,
                ls.supplier_invoice as invoice,
                cs.id_reference AS carrierid '.
            'FROM '._DB_PREFIX_.'supplier s '.
            'LEFT JOIN '._DB_PREFIX_.'lgdropshipping_supplier ls '.
            'ON s.id_supplier = ls.id_supplier '.
            'LEFT JOIN '._DB_PREFIX_.'lgdropshipping_carrier_to_supplier cs '.
            'ON s.id_supplier = cs.id_supplier'
        );
    }

    private function getSupplierName($id_supplier)
    {
        return Db::getInstance()->getValue(
            'SELECT name FROM '._DB_PREFIX_.'supplier '.
            'WHERE id_supplier = '.(int)$id_supplier
        );
    }

    private function getCarriers()
    {
        return Db::getInstance()->ExecuteS(
            'SELECT *, 
                c.id_reference AS carrierid,
                lc.carrier_invoice AS invoice,
                lc.carrier_slip AS slip,
                lc.carrier_subject AS subject,
                lc.carrier_template AS template '.
            'FROM '._DB_PREFIX_.'carrier c '.
            'LEFT JOIN '._DB_PREFIX_.'lgdropshipping_carrier lc '.
            'ON c.id_reference = lc.id_reference '.
            'WHERE c.deleted <> 1'
            /*'GROUP BY c.id_reference'*/
        );
    }

    private function getCarrierName($id_reference)
    {
        return Db::getInstance()->getValue(
            'SELECT name FROM '._DB_PREFIX_.'carrier '.
            'WHERE id_reference = '.(int)$id_reference.' '.
            'ORDER BY id_carrier DESC'
        );
    }

    private function getOrderState()
    {
        $order_state = Db::getInstance()->ExecuteS(
            'SELECT * '.
            'FROM '._DB_PREFIX_.'order_state_lang osl '.
            'INNER JOIN '._DB_PREFIX_.'order_state os '.
            'ON osl.id_order_state = os.id_order_state '.
            'WHERE osl.id_lang = '.(int)$this->context->language->id.' '.
            'ORDER BY osl.id_order_state ASC'
        );
        foreach ($order_state as $k => $row) {
            $order_state[$k]['supplier_selected'] = (int)$this->getSupplierOrderState($row['id_order_state']);
            $order_state[$k]['carrier_selected'] = (int)$this->getCarrierOrderState($row['id_order_state']);
        }
        return $order_state;
    }

    private function getOrderStateName($id_order_state)
    {
        return Db::getInstance()->getValue(
            'SELECT name FROM '._DB_PREFIX_.'order_state_lang '.
            'WHERE id_lang = '.(int)$this->context->language->id.
            '  AND id_order_state = '.(int)$id_order_state
        );
    }

    private function getSupplierOrderState($id_order_state)
    {
        return Db::getInstance()->getValue(
            'SELECT id_order_state_supplier '.
            'FROM '._DB_PREFIX_.'lgdropshipping_order_state_supplier '.
            'WHERE id_order_state_supplier = '.(int)$id_order_state
        );
    }
    private function getCarrierOrderState($id_order_state)
    {
        return Db::getInstance()->getValue(
            'SELECT id_order_state_carrier '.
            'FROM '._DB_PREFIX_.'lgdropshipping_order_state_carrier '.
            'WHERE id_order_state_carrier = '.(int)$id_order_state
        );
    }

    private function getSupplierContact($id_supplier)
    {
        return Db::getInstance()->getValue(
            'SELECT contact_supplier FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
            'WHERE id_supplier = '.(int)$id_supplier
        );
    }

    private function getSupplierEmail($id_supplier)
    {
        return Db::getInstance()->getValue(
            'SELECT email_supplier FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
            'WHERE id_supplier = '.(int)$id_supplier
        );
    }

    private function getSupplierEmail2($id_supplier)
    {
        return Db::getInstance()->getValue(
            'SELECT email_supplier2 FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
            'WHERE id_supplier = '.(int)$id_supplier
        );
    }

    private function getSupplierSubject($id_supplier)
    {
        return Db::getInstance()->getValue(
            'SELECT supplier_subject '.
            'FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
            'WHERE id_supplier = '.(int)$id_supplier
        );
    }

    private function getSupplierTemplate($id_supplier)
    {
        return Db::getInstance()->getValue(
            'SELECT supplier_template '.
            'FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
            'WHERE id_supplier = '.(int)$id_supplier
        );
    }

    private function getSupplierSlip($id_supplier)
    {
        return Db::getInstance()->getValue(
            'SELECT supplier_slip '.
            'FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
            'WHERE id_supplier = '.(int)$id_supplier
        );
    }

    private function getSupplierInvoice($id_supplier)
    {
        return Db::getInstance()->getValue(
            'SELECT supplier_invoice '.
            'FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
            'WHERE id_supplier = '.(int)$id_supplier
        );
    }

    private function getCarrierSupplier($id_supplier)
    {
        return Db::getInstance()->getValue(
            'SELECT id_reference FROM '._DB_PREFIX_.'lgdropshipping_carrier_to_supplier '.
            'WHERE id_supplier = '.(int)$id_supplier
        );
    }

    private function getCarrierContact($id_reference)
    {
        return Db::getInstance()->getValue(
            'SELECT contact_carrier FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
            'WHERE id_reference = '.(int)$id_reference
        );
    }

    private function getCarrierEmail($id_reference)
    {
        return Db::getInstance()->getValue(
            'SELECT email_carrier FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
            'WHERE id_reference = '.(int)$id_reference
        );
    }

    private function getCarrierEmail2($id_reference)
    {
        return Db::getInstance()->getValue(
            'SELECT email_carrier2 FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
            'WHERE id_reference = '.(int)$id_reference
        );
    }

    private function getCarrierSubject($id_reference)
    {
        return Db::getInstance()->getValue(
            'SELECT carrier_subject '.
            'FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
            'WHERE id_reference = '.(int)$id_reference
        );
    }

    private function getCarrierTemplate($id_reference)
    {
        return Db::getInstance()->getValue(
            'SELECT carrier_template '.
            'FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
            'WHERE id_reference = '.(int)$id_reference
        );
    }

    private function getCarrierSlip($id_reference)
    {
        return Db::getInstance()->getValue(
            'SELECT carrier_slip '.
            'FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
            'WHERE id_reference = '.(int)$id_reference
        );
    }

    private function getCarrierInvoice($id_reference)
    {
        return Db::getInstance()->getValue(
            'SELECT carrier_invoice '.
            'FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
            'WHERE id_reference = '.(int)$id_reference
        );
    }

    private function formatBootstrap($text)
    {
        $text = str_replace('<fieldset>', '<div class="panel">', $text);
        $text = str_replace(
            '<fieldset style="background:#DFF2BF;color:#4F8A10;border:1px solid #4F8A10;">',
            '<div class="panel"  style="background:#DFF2BF;color:#4F8A10;border:1px solid #4F8A10;">',
            $text
        );
        $text = str_replace('</fieldset>', '</div>', $text);
        $text = str_replace('<legend>', '<h3>', $text);
        $text = str_replace('</legend>', '</h3>', $text);
        return $text;
    }

    private function getP($template)
    {
        $iso_langs = array('es', 'en', 'fr');
        $current_iso_lang = $this->context->language->iso_code;
        $iso = (in_array($current_iso_lang, $iso_langs)) ? $current_iso_lang : 'en';

        $this->context->smarty->assign(
            array(
                'iso' => $iso,
                'base_url' => _MODULE_DIR_. $this->name . DIRECTORY_SEPARATOR,
            )
        );

        return $this->context->smarty->fetch(
            _PS_MODULE_DIR_ . $this->name
            . DIRECTORY_SEPARATOR . 'views'
            . DIRECTORY_SEPARATOR . 'templates'
            . DIRECTORY_SEPARATOR . 'admin'
            . DIRECTORY_SEPARATOR . '_p_' . $template . '.tpl'
        );
    }

    /*
    private function getP()
    {
        $default_lang = $this->context->language->id;
        $lang         = Language::getIsoById($default_lang);
        $pl           = array('es','fr');
        if (!in_array($lang, $pl)) {
            $lang = 'en';
        }
        $this->context->controller->addCSS(_MODULE_DIR_.$this->name.'/views/css/publi/style.css');
        $base = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')  ?
            'https://'.$this->context->shop->domain_ssl :
            'http://'.$this->context->shop->domain);
        if (version_compare(_PS_VERSION_, '1.5.0', '>')) {
            $uri = $base.$this->context->shop->getBaseURI();
        } else {
            $uri = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')  ?
                    'https://'._PS_SHOP_DOMAIN_SSL_DOMAIN_:
                    'http://'._PS_SHOP_DOMAIN_).__PS_BASE_URI__;
        }
        $path = _PS_MODULE_DIR_.$this->name
            .DIRECTORY_SEPARATOR.'views'
            .DIRECTORY_SEPARATOR.'publi'
            .DIRECTORY_SEPARATOR.$lang
            .DIRECTORY_SEPARATOR.'index.php';
        $object = Tools::file_get_contents($path);
        $object = str_replace('src="/modules/', 'src="'.$uri.'modules/', $object);

        return $object;
    }
    */

    public function getContent()
    {
        $this->context->controller->addCSS(_MODULE_DIR_.$this->name.'/views/css/lgdropshipping.css');
        $this->context->controller->addJS(_MODULE_DIR_.$this->name.'/views/js/lgdropshipping.js');
        $this->context->controller->addCSS(_MODULE_DIR_.$this->name.'/views/css/publi/lgpubli.css');
        if (version_compare(_PS_VERSION_, '1.6.0', '<')) {
            $this->context->controller->addJS(__PS_BASE_URI__.'js/tiny_mce/tiny_mce.js');
            $this->context->controller->addCSS(_MODULE_DIR_.$this->name.'/views/css/admin15.css');
            $this->context->controller->addJS(_MODULE_DIR_.$this->name.'/views/js/admin15.js');
            $this->context->controller->addJS(_MODULE_DIR_.$this->name.'/views/js/bootstrap.js');
            $this->context->controller->addJS(__PS_BASE_URI__.'js/tinymce.inc.js');
        } else {
            $this->context->controller->addJS(__PS_BASE_URI__.'js/tiny_mce/tinymce.min.js');
            if (file_exists(_PS_ROOT_DIR_.'/js/tinymce.inc.js')) {
                $this->context->controller->addJS(__PS_BASE_URI__.'js/tinymce.inc.js');
            } else {
                $this->context->controller->addJS(_MODULE_DIR_.$this->name.'/views/js/tinymce.inc.js');
            }
        }
        // TinyMCE
        $iso = $this->context->language->iso_code;
        $isoTinyMCE = (file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en');
        $ad = dirname($_SERVER['PHP_SELF']);
        $this->context->controller->addJS(
            _MODULE_DIR_.
            $this->name.
            '/views/js/tinymce.init.js?iso_tinymce='.$isoTinyMCE.
            '&path_css='.urlencode(_THEME_CSS_DIR_).'&ad='.urlencode($ad)
        );
        $this->_html = $this->getP('top');
        // update email address
        if (Tools::isSubmit('updateEmail')) {
            Configuration::updateValue('PS_LGDROPSHIPPING_EMAIL', Tools::getValue('emailcp'));
            $this->_html .= $this->displayConfirmation($this->l('The email address has been successfully updated'));
        }
        // update order status
        if (Tools::isSubmit('updateOrderState')) {
            Db::getInstance()->Execute('TRUNCATE TABLE '._DB_PREFIX_.'lgdropshipping_order_state_supplier');
            foreach ($this->getOrderState() as $order_state) {
                if (Tools::getValue('supplierState'.$order_state['id_order_state']) == 1) {
                    Db::getInstance()->Execute(
                        'INSERT INTO '._DB_PREFIX_.'lgdropshipping_order_state_supplier '.
                        'VALUES ('.$order_state['id_order_state'].')'
                    );
                }
            }
            Db::getInstance()->Execute('TRUNCATE TABLE '._DB_PREFIX_.'lgdropshipping_order_state_carrier');
            foreach ($this->getOrderState() as $order_state) {
                if (Tools::getValue('carrierState'.$order_state['id_order_state']) == 1) {
                    Db::getInstance()->Execute(
                        'INSERT INTO '._DB_PREFIX_.'lgdropshipping_order_state_carrier '.
                        'VALUES ('.$order_state['id_order_state'].')'
                    );
                }
            }
            $this->_html .= $this->displayConfirmation($this->l('The order status have been successfully updated'));
        }
        // update suppliers
        if (Tools::isSubmit('updateSupplier')) {
            foreach ($this->getSuppliers() as $supplier) {
                $invoicecheck = (int)Tools::getValue('invoice'.$supplier['supplierid']);
                if ($invoicecheck > 0) {
                    $invoice = '1';
                } else {
                    $invoice = '0';
                }
                $slipcheck = (int)Tools::getValue('delivery_slip'.$supplier['supplierid']);
                if ($slipcheck > 0) {
                    $delivery_slip = '1';
                } else {
                    $delivery_slip = '0';
                }
                if (Db::getInstance()->getRow(
                    'SELECT * FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
                    'WHERE id_supplier = '.$supplier['supplierid']
                )
                ) {
                    Db::getInstance()->Execute(
                        'UPDATE '._DB_PREFIX_.'lgdropshipping_supplier SET contact_supplier = '.
                        '\''.pSQL(Tools::getValue('scontact'.$supplier['supplierid'])).'\', '.
                        'email_supplier = \''.pSQL(Tools::getValue('semail'.$supplier['supplierid'])).'\', '.
                        'email_supplier2 = \''.pSQL(Tools::getValue('semailb'.$supplier['supplierid'])).'\', '.
                        'supplier_subject = '.
                        '\''.pSQL(Tools::getValue('supplier_subject'.$supplier['supplierid'])).'\', '.
                        'supplier_template = '.
                        '\''.pSQL(htmlentities(Tools::getValue('supplier_template'.$supplier['supplierid']))).'\', '.
                        'supplier_invoice = \''.$invoice.'\', '.
                        'supplier_slip = \''.$delivery_slip.'\' '.
                        'WHERE id_supplier = '.$supplier['supplierid']
                    );
                } else {
                    Db::getInstance()->Execute(
                        'INSERT INTO '._DB_PREFIX_.'lgdropshipping_supplier '.
                        '(id_supplier, contact_supplier, email_supplier, email_supplier2, supplier_subject, '.
                        'supplier_template, supplier_invoice, supplier_slip) VALUES (\''.$supplier['supplierid'].'\', '.
                        '\''.pSQL(Tools::getValue('scontact'.$supplier['supplierid'])).'\', '.
                        '\''.pSQL(Tools::getValue('semail'.$supplier['supplierid'])).'\', '.
                        '\''.pSQL(Tools::getValue('semailb'.$supplier['supplierid'])).'\', '.
                        '\''.pSQL(Tools::getValue('supplier_subject'.$supplier['supplierid'])).'\', '.
                        '\''.pSQL(htmlentities(Tools::getValue('supplier_template'.$supplier['supplierid']))).'\', '.
                        '\''.$invoice.'\', '.
                        '\''.$delivery_slip.'\')'
                    );
                }
            }
            $this->_html .=
                $this->displayConfirmation($this->l('The configuration of suppliers has been successfully updated'));
        }
        // update supplier-carrier associations
        if (Tools::isSubmit('updateCarrierSupplier')) {
            Db::getInstance()->Execute('TRUNCATE TABLE '._DB_PREFIX_.'lgdropshipping_carrier_to_supplier');
            foreach ($this->getSuppliers() as $supplier) {
                Db::getInstance()->Execute(
                    'INSERT INTO '._DB_PREFIX_.'lgdropshipping_carrier_to_supplier '.
                    'VALUES ('.pSQL(Tools::getValue('carriersupplier'.$supplier['supplierid'])).
                    ','.pSQL($supplier['supplierid']).')'
                );
            }
            Configuration::updateValue(
                'PS_LGDROPSHIPPING_ASSOCIATION',
                Tools::getValue('lgdropshipping_association')
            );
            $this->_html .=
                $this->displayConfirmation($this->l('The selection of carriers has been successfully updated'));
        }
        // update carriers
        if (Tools::isSubmit('updateCarrier')) {
            foreach ($this->getCarriers() as $carrier) {
                $invoicecheck = (int)Tools::getValue('invoice'.$carrier['carrierid']);
                if ($invoicecheck > 0) {
                    $invoice = '1';
                } else {
                    $invoice = '0';
                }
                $slipcheck = (int)Tools::getValue('delivery_slip'.$carrier['carrierid']);
                if ($slipcheck > 0) {
                    $delivery_slip = '1';
                } else {
                    $delivery_slip = '0';
                }
                if (Db::getInstance()->getRow(
                    'SELECT * FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
                    'WHERE id_reference = '.$carrier['carrierid']
                )) {
                    Db::getInstance()->Execute(
                        'UPDATE '._DB_PREFIX_.'lgdropshipping_carrier '.
                        'SET contact_carrier = \''.pSQL(Tools::getValue('ccontact'.$carrier['carrierid'])).'\', '.
                        'email_carrier = \''.pSQL(Tools::getValue('cemail'.$carrier['carrierid'])).'\', '.
                        'email_carrier2 = \''.pSQL(Tools::getValue('cemailb'.$carrier['carrierid'])).'\', '.
                        'carrier_subject = \''.pSQL(Tools::getValue('carrier_subject'.$carrier['carrierid'])).'\', '.
                        'carrier_template = '.
                        '\''.pSQL(htmlentities(Tools::getValue('carrier_template'.$carrier['carrierid']))).'\', '.
                        'carrier_invoice = \''.$invoice.'\', '.
                        'carrier_slip = \''.$delivery_slip.'\' '.
                        'WHERE id_reference = '.$carrier['carrierid']
                    );
                } else {
                    Db::getInstance()->Execute(
                        'INSERT INTO '._DB_PREFIX_.'lgdropshipping_carrier '.
                        '(id_reference, contact_carrier, email_carrier, email_carrier2, carrier_subject, '.
                        'carrier_template, carrier_invoice, carrier_slip) '.
                        'VALUES (\''.$carrier['carrierid'].'\', '.
                        '\''.pSQL(Tools::getValue('ccontact'.$carrier['carrierid'])).'\', '.
                        '\''.pSQL(Tools::getValue('cemail'.$carrier['carrierid'])).'\', '.
                        '\''.pSQL(Tools::getValue('cemailb'.$carrier['carrierid'])).'\', '.
                        '\''.pSQL(Tools::getValue('carrier_subject'.$carrier['carrierid'])).'\', '.
                        '\''.pSQL(htmlentities(Tools::getValue('carrier_template'.$carrier['carrierid']))).'\', '.
                        '\''.$invoice.'\', '.
                        '\''.$delivery_slip.'\')'
                    );
                }
            }
            $this->_html .=
                $this->displayConfirmation($this->l('The configuration of carriers has been successfully updated'));
        }
        $productSupplier = Db::getInstance()->ExecuteS(
            'SELECT DISTINCT p.id_product '.
            'FROM '._DB_PREFIX_.'product as p '.
            'LEFT JOIN '._DB_PREFIX_.'product_supplier as ps '.
            'ON p.id_product = ps.id_product '.
            'WHERE ps.id_product IS NULL '.
            'ORDER BY p.id_product ASC'
        );
        if (count($productSupplier) > 0) {
            $orderID = '';
            foreach ($productSupplier as $pSupplier) {
                $orderID .= ' #'.$pSupplier['id_product'];
            }
            $this->_html .=
                $this->displayError($this->l('There is no supplier selected for the following products:').' '.$orderID);
        }
        $selectedsupplier =
            Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'lgdropshipping_order_state_supplier');
        if (!$selectedsupplier) {
            $this->_html .=
                $this->displayError($this->l('You haven\'t selected any order status to send supplier emails'));
        }
        $selectedcarrier =
            Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'lgdropshipping_order_state_carrier');
        if (!$selectedcarrier) {
            $this->_html .=
                $this->displayError($this->l('You haven\'t selected any order status to send carrier emails'));
        }
        if (!Configuration::get('PS_LGDROPSHIPPING_ASSOCIATION')) {
            $supplierCarrier = Db::getInstance()->ExecuteS(
                'SELECT s.name '.
                'FROM '._DB_PREFIX_.'lgdropshipping_carrier_to_supplier cs '.
                'INNER JOIN '._DB_PREFIX_.'supplier s '.
                'ON cs.id_supplier = s.id_supplier '.
                'WHERE cs.id_reference < 1'
            );
            if (count($supplierCarrier) > 0) {
                $supplierName = '';
                foreach ($supplierCarrier as $sC) {
                    $supplierName .= ' - '.$sC['name'];
                }
                $this->_html .=
                    $this->displayError(
                        $this->l('There is no carrier selected for the following suppliers:').' '.$supplierName
                    );
            }
        }
        $this->context->smarty->assign(
            array(
                'order_states' => $this->getOrderState(),
                'suppliers' => $this->getSuppliers(),
                'carriers' => $this->getCarriers(),
                'lgdropshipping_association' => (int)Configuration::get('PS_LGDROPSHIPPING_ASSOCIATION'),
                'lgdropshipping_email' => Configuration::get('PS_LGDROPSHIPPING_EMAIL'),
                'lgdropshipping_lang_iso' => $this->context->language->iso_code,
            )
        );
        if ($this->bootstrap == true) {
            $this->_html.= $this->formatBootstrap($this->display(__FILE__, 'views/templates/admin/config.tpl'));
        } else {
            $this->_html.= $this->display(__FILE__, 'views/templates/admin/config.tpl');
        }
        return $this->_html.$this->getP('bottom');
    }

    public function hookActionOrderStatusPostUpdate($params)
    {
        if (!Validate::isLoadedObject($params['cart'])) {
            $params['cart'] = Cart::getCartByOrderId((int)$params['id_order']);
        }

        // Check if email template exists for current iso code. If not, use English template.
        $idlang = $this->context->language->id;
        $module_path = _PS_MODULE_DIR_.'lgdropshipping/mails/'.Language::getIsoById($idlang).'/';
        $template_path = _PS_THEME_DIR_.'modules/lgdropshipping/mails/'.Language::getIsoById($idlang).'/';
        if (is_dir($module_path) or is_dir($template_path)) {
            $langId = $idlang;
        } else {
            $langId = (int)Language::getIdByIso('en');
        }
        $id_order_state = $params['newOrderStatus']->id;
        if ($this->getSupplierOrderState($id_order_state) == $id_order_state ||
            $this->getCarrierOrderState($id_order_state) == $id_order_state
        ) {
            $id_order = $params['id_order'];
            $id_address_delivery = Db::getInstance()->getValue(
                'SELECT `id_address_delivery` '.
                'FROM `'._DB_PREFIX_.'orders` '.
                'WHERE `id_order` = '.(int)$id_order
            );
            $id_lang = $params['cart']->id_lang;
            // get order products
            $products = Db::getInstance()->ExecuteS(
                'SELECT * FROM '._DB_PREFIX_.'order_detail '.
                'WHERE id_order = '.(int)$id_order
            );
            $suppliers = array();
            // get suppliers
            foreach ($products as $product) {
                $id_supplier = Db::getInstance()->getValue(
                    'SELECT id_supplier FROM '._DB_PREFIX_.'product '.
                    'WHERE id_product = '.(int)$product['product_id']
                );

                if ($id_supplier > 0 && !in_array($id_supplier, $suppliers)) {
                    array_push($suppliers, $id_supplier);
                }
            }
            // preparation of the emails
            foreach ($suppliers as $supplier) {
                $id_reference = $this->getCarrierSupplier($supplier);
                $products_arr = array();
                foreach ($products as $product) {
                    $id_supplier = Db::getInstance()->getValue(
                        'SELECT id_supplier FROM '._DB_PREFIX_.'product '.
                        'WHERE id_product = '.(int)$product['product_id']
                    );
                    $product['link'] = $this->context->link->getProductLink((int)$product['product_id']);
                    $link_rewrite = Db::getInstance()->getValue(
                        'SELECT link_rewrite FROM '._DB_PREFIX_.'product_lang '.
                        'WHERE id_product = '.(int)$product['product_id']
                    );
                    // Obtenemos la imagen del producto
                    $id_image   = $this->getProductImage($product['product_id'], $langId);
                    $product['image'] = $this->context->link->getImageLink($link_rewrite, (int)$id_image);
                    if ($product['product_attribute_id'] > 0) {
                        $product['supplier_reference'] = Db::getInstance()->getValue(
                            'SELECT product_supplier_reference '.
                            'FROM '._DB_PREFIX_.'product_supplier '.
                            'WHERE id_product_attribute = '.(int)$product['product_attribute_id']
                        );
                    } else {
                        $product['supplier_reference'] = Db::getInstance()->getValue(
                            'SELECT product_supplier_reference '.
                            'FROM '._DB_PREFIX_.'product_supplier '.
                            'WHERE id_product = '.(int)$product['product_id']
                        );
                    }
                    if ($id_supplier == $supplier) {
                        $query = '
                            SELECT cd.value, cd.index '.
                            'FROM '._DB_PREFIX_.'customized_data cd '.
                            'INNER JOIN '._DB_PREFIX_.'customization c '.
                            'ON c.id_customization = cd.id_customization '.
                            'AND id_cart = '.(int)$params['cart']->id.' '.
                            'AND cd.type = 1 '.
                            'AND c.in_cart = 1 '.
                            'AND c.id_product = '.(int)$product['product_id'].' '.
                            'AND c.id_product_attribute = '.(int)$product['product_attribute_id'];
                        $customized_data = Db::getInstance()->executeS($query);
                        if ($customized_data) {
                            foreach ($customized_data as $data) {
                                $datatitle = Db::getInstance()->getValue(
                                    'SELECT name FROM '._DB_PREFIX_.'customization_field_lang '.
                                    'WHERE id_customization_field = '.(int)$data['index']
                                );
                                $product['customization'][] = $datatitle.' '.$data['value'];
                            }
                        }
                        $products_arr[] = $product;
                    }
                }
                $this->context->smarty->assign('products', $products_arr);
                $products_tpl = $this->display(__FILE__, 'views/templates/admin/products.tpl');
                // get variables for supplier template
                if ($this->getSupplierOrderState($id_order_state) == $id_order_state) {
                    if (Configuration::get('PS_LGDROPSHIPPING_ASSOCIATION') > 0) {
                        $id_reference = Db::getInstance()->getValue(
                            'SELECT c.id_reference '.
                            'FROM '._DB_PREFIX_.'carrier c '.
                            'INNER JOIN '._DB_PREFIX_.'orders o '.
                            'ON c.id_carrier = o.id_carrier '.
                            'WHERE o.id_order = '.(int)$id_order
                        );
                    } else {
                        $id_reference = $this->getCarrierSupplier($supplier);
                    }
                    $order_ref = Db::getInstance()->getValue(
                        'SELECT reference '.
                        'FROM '._DB_PREFIX_.'orders '.
                        'WHERE id_order = '.(int)$id_order
                    );
                    $invoice_num = Db::getInstance()->getValue(
                        'SELECT invoice_number '.
                        'FROM '._DB_PREFIX_.'orders '.
                        'WHERE id_order = '.(int)$id_order
                    );
                    $order_date0 = Db::getInstance()->getValue(
                        'SELECT date_add '.
                        'FROM '._DB_PREFIX_.'orders '.
                        'WHERE id_order = '.(int)$id_order
                    );
                    $order_date = date('d-m-Y', strtotime($order_date0));
                    $contact = $this->getSupplierContact($supplier);
                    $email = $this->getSupplierEmail($supplier);
                    $email2 = $this->getSupplierEmail2($supplier);
                    $address_delivery = '';
                    $del_address = Db::getInstance()->getRow(
                        'SELECT * FROM '._DB_PREFIX_.'address '.
                        'WHERE id_address = '.(int)$id_address_delivery
                    );
                    $customer_email = Db::getInstance()->getValue(
                        'SELECT email FROM '._DB_PREFIX_.'customer '.
                        'WHERE id_customer = '.(int)$del_address['id_customer']
                    );
                    $customer_email2 = '<a href="mailto:'.$customer_email.'">'.$customer_email.'</a>';
                    $customer_thread = Db::getInstance()->getValue(
                        'SELECT id_customer_thread '.
                        'FROM '._DB_PREFIX_.'customer_thread '.
                        'WHERE id_order = '.(int)$id_order
                    );
                    $customer_message = Db::getInstance()->getValue(
                        'SELECT message FROM '._DB_PREFIX_.'customer_message '.
                        'WHERE id_customer_thread = '.(int)$customer_thread
                    );
                    $del_state = Db::getInstance()->getValue(
                        'SELECT name FROM '._DB_PREFIX_.'state '.
                        'WHERE id_state = '.(int)$del_address['id_state']
                    );
                    $del_country = Db::getInstance()->getValue(
                        'SELECT name FROM '._DB_PREFIX_.'country_lang '.
                        'WHERE id_country = '.(int)$del_address['id_country'].' '.
                        'AND id_lang = '.(int)$id_lang
                    );
                    $customer_name = $del_address['firstname'].' '.$del_address['lastname'];
                    $address_delivery .= $del_address['firstname'].' '.$del_address['lastname']."\n";
                    if (Tools::strlen($del_address['company']) > 0) {
                        $address_delivery .= $del_address['company']."\n";
                    }
                    $address_delivery .= $del_address['address1']."\n";
                    if (Tools::strlen($del_address['address2']) > 0) {
                        $address_delivery .= $del_address['address2']."\n";
                    }
                    $address_delivery .= $del_address['postcode'].' '.$del_address['city']."\n";
                    if (Tools::strlen($del_state) > 0) {
                        $address_delivery .= $del_state."\n";
                    }
                    $address_delivery .= $del_country."\n";
                    $customer_phone = '';
                    $customer_phone .= $del_address['phone']."\n";
                    if (Tools::strlen($del_address['phone_mobile']) > 0) {
                        $customer_phone .= ' '.$del_address['phone_mobile']."\n";
                    }
                    $supplier_address = '';
                    $sup_address = Db::getInstance()->getRow(
                        'SELECT * FROM '._DB_PREFIX_.'address '.
                        'WHERE id_supplier = '.(int)$supplier
                    );
                    $sup_state = Db::getInstance()->getValue(
                        'SELECT name FROM '._DB_PREFIX_.'state '.
                        'WHERE id_state = '.(int)$sup_address['id_state']
                    );
                    $sup_country = Db::getInstance()->getValue(
                        'SELECT name FROM '._DB_PREFIX_.'country_lang '.
                        'WHERE id_country = '.(int)$sup_address['id_country'].' '.
                        'AND id_lang = '.(int)$id_lang
                    );
                    $supplier_address .= $sup_address['alias']."\n";
                    $supplier_address .= $sup_address['address1']."\n";
                    if (Tools::strlen($sup_address['address2']) > 0) {
                        $supplier_address .= $sup_address['address2']."\n";
                    }
                    $supplier_address .= $sup_address['postcode'].' '.$sup_address['city']."\n";
                    if (Tools::strlen($sup_state) > 0) {
                        $supplier_address .= $sup_state."\n";
                    }
                    $supplier_address .= $sup_country."\n";
                    $supplier_phone = '';
                    $supplier_phone .= $sup_address['phone']."\n";
                    if (Tools::strlen($sup_address['phone_mobile']) > 0) {
                        $supplier_phone .= ' '.$sup_address['phone_mobile']."\n";
                    }
                    // get supplier template
                    $supplier_template = Db::getInstance()->getValue(
                        'SELECT supplier_template '.
                        'FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
                        'WHERE id_supplier = '.(int)$supplier
                    );

                    $supplier_template = Tools::htmlentitiesDecodeUTF8($supplier_template);

                    $supplier_template =
                        str_replace('{SUPPLIER_NAME}', $this->getSupplierContact($supplier), $supplier_template);
                    $supplier_template =
                        str_replace('{CARRIER_NAME}', $this->getCarrierContact($id_reference), $supplier_template);
                    $supplier_template = str_replace('{ORDER_INFO}', $customer_message, $supplier_template);
                    $supplier_template = str_replace('{CUSTOMER_NAME}', $customer_name, $supplier_template);
                    $supplier_template = str_replace('{ORDER_DATE}', $order_date, $supplier_template);
                    $supplier_template = str_replace('{ORDER_ID}', $id_order, $supplier_template);
                    $supplier_template = str_replace('{ORDER_REF}', $order_ref, $supplier_template);
                    $supplier_template = str_replace('{INVOICE_NUMBER}', $invoice_num, $supplier_template);
                    $supplier_template = str_replace('{PRODUCTS}', $products_tpl, $supplier_template);
                    $supplier_template =
                        str_replace('{CUSTOMER_ADDRESS}', nl2br($address_delivery), $supplier_template);
                    $supplier_template =
                        str_replace('{SUPPLIER_ADDRESS}', nl2br($supplier_address), $supplier_template);
                    $supplier_template = str_replace('{CUSTOMER_EMAIL}', $customer_email2, $supplier_template);
                    $supplier_template = str_replace('{CUSTOMER_PHONE}', $customer_phone, $supplier_template);
                    $supplier_template = str_replace('{SUPPLIER_PHONE}', $supplier_phone, $supplier_template);
                    $data = array('{SUPPLIER_TEMPLATE}' => $supplier_template);
                    $supplier_title = Db::getInstance()->getValue(
                        'SELECT supplier_subject '.
                        'FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
                        'WHERE id_supplier = '.(int)$supplier
                    );
                    $supplier_title =
                        str_replace('{SUPPLIER_NAME}', $this->getSupplierContact($supplier), $supplier_title);
                    $supplier_title =
                        str_replace('{CARRIER_NAME}', $this->getCarrierContact($id_reference), $supplier_title);
                    $supplier_title = str_replace('{CUSTOMER_NAME}', $customer_name, $supplier_title);
                    $supplier_title = str_replace('{ORDER_DATE}', $order_date, $supplier_title);
                    $supplier_title = str_replace('{ORDER_ID}', $id_order, $supplier_title);
                    $supplier_title = str_replace('{ORDER_REF}', $order_ref, $supplier_title);
                    $supplier_title = str_replace('{INVOICE_NUMBER}', $invoice_num, $supplier_title);
                    $attachments = array();
                    $order = new Order($id_order);
                    $supplier_slip = Db::getInstance()->getValue(
                        'SELECT supplier_slip '.
                        'FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
                        'WHERE id_supplier = '.(int)$supplier
                    );
                    $supplier_invoice = Db::getInstance()->getValue(
                        'SELECT supplier_invoice '.
                        'FROM '._DB_PREFIX_.'lgdropshipping_supplier '.
                        'WHERE id_supplier = '.(int)$supplier
                    );
                    if ($supplier_slip) {
                        $pdf =
                            new PDF(
                                $order->getDeliverySlipsCollection(),
                                PDF::TEMPLATE_DELIVERY_SLIP,
                                $this->context->smarty
                            );
                        $file_attachement = array();
                        $file_attachement['content'] = $pdf->render(false);
                        $file_attachement['name'] =
                            Configuration::get('PS_DELIVERY_PREFIX', (int)$order->id_lang, null, $order->id_shop).
                            sprintf('%06d', $order->delivery_number).'.pdf';
                        $file_attachement['mime'] = 'application/pdf';
                        $attachments[] = $file_attachement;
                    }
                    if ($supplier_invoice) {
                        $pdf =
                            new PDF($order->getInvoicesCollection(), PDF::TEMPLATE_INVOICE, $this->context->smarty);
                        $file_attachement = array();
                        $file_attachement['content'] = $pdf->render(false);
                        $file_attachement['name'] =
                            Configuration::get('PS_INVOICE_PREFIX', (int)$order->id_lang, null, $order->id_shop).
                            sprintf('%06d', $order->invoice_number).'.pdf';
                        $file_attachement['mime'] = 'application/pdf';
                        $attachments[] = $file_attachement;
                    }
                    // send supplier email 1
                    if ($email != false) {
                        Mail::Send(
                            (int)$langId,
                            'suppliermail',
                            $supplier_title,
                            $data,
                            $email,
                            $contact,
                            null,
                            (string)Configuration::get('PS_SHOP_NAME'),
                            $attachments,
                            null,
                            dirname(__FILE__).'/mails/',
                            '',
                            $this->context->shop->id
                        );
                    }
                    // send supplier email 2
                    if ($email2 != false) {
                        Mail::Send(
                            (int)$langId,
                            'suppliermail',
                            $supplier_title,
                            $data,
                            $email2,
                            $contact,
                            null,
                            (string)Configuration::get('PS_SHOP_NAME'),
                            $attachments,
                            null,
                            dirname(__FILE__).'/mails/',
                            '',
                            $this->context->shop->id
                        );
                    }
                    // send supplier email copy
                    if ($email != false or $email2 != false) {
                        if (Tools::strlen(Configuration::get('PS_LGDROPSHIPPING_EMAIL')) > 5) {
                            $supplier_titleC = $supplier_title . " " . $this->l('(copy)');
                            Mail::Send(
                                (int)$langId,
                                'suppliermail',
                                $supplier_titleC,
                                $data,
                                Configuration::get('PS_LGDROPSHIPPING_EMAIL'),
                                $contact,
                                null,
                                (string)Configuration::get('PS_SHOP_NAME'),
                                $attachments,
                                null,
                                dirname(__FILE__).'/mails/',
                                '',
                                $this->context->shop->id
                            );
                        }
                    }
                }
                // get variables for carrier template
                if ($this->getCarrierOrderState($id_order_state) == $id_order_state) {
                    if (Configuration::get('PS_LGDROPSHIPPING_ASSOCIATION') > 0) {
                        $id_reference = Db::getInstance()->getValue(
                            'SELECT c.id_reference '.
                            'FROM '._DB_PREFIX_.'carrier c '.
                            'INNER JOIN '._DB_PREFIX_.'orders o '.
                            'ON c.id_carrier = o.id_carrier '.
                            'WHERE o.id_order = '.(int)$id_order
                        );
                    } else {
                        $id_reference = $this->getCarrierSupplier($supplier);
                    }
                    $order_ref = Db::getInstance()->getValue(
                        'SELECT reference '.
                        'FROM '._DB_PREFIX_.'orders '.
                        'WHERE id_order = '.(int)$id_order
                    );
                    $invoice_num = Db::getInstance()->getValue(
                        'SELECT invoice_number '.
                        'FROM '._DB_PREFIX_.'orders '.
                        'WHERE id_order = '.(int)$id_order
                    );
                    $order_date0 = Db::getInstance()->getValue(
                        'SELECT date_add '.
                        'FROM '._DB_PREFIX_.'orders '.
                        'WHERE id_order = '.(int)$id_order
                    );
                    $order_date = date('d-m-Y', strtotime($order_date0));
                    $contact = $this->getCarrierContact($id_reference);
                    $email = $this->getCarrierEmail($id_reference);
                    $email2 = $this->getCarrierEmail2($id_reference);
                    $address_delivery = '';
                    $del_address = Db::getInstance()->getRow(
                        'SELECT * FROM '._DB_PREFIX_.'address '.
                        'WHERE id_address = '.(int)$id_address_delivery
                    );
                    $customer_email = Db::getInstance()->getValue(
                        'SELECT email FROM '._DB_PREFIX_.'customer '.
                        'WHERE id_customer = '.(int)$del_address['id_customer']
                    );
                    $customer_email2 = '<a href="mailto:'.$customer_email.'">'.$customer_email.'</a>';
                    $customer_thread = Db::getInstance()->getValue(
                        'SELECT id_customer_thread '.
                        'FROM '._DB_PREFIX_.'customer_thread '.
                        'WHERE id_order = '.(int)$id_order
                    );
                    $customer_message = Db::getInstance()->getValue(
                        'SELECT message '.
                        'FROM '._DB_PREFIX_.'customer_message '.
                        'WHERE id_customer_thread = '.(int)$customer_thread
                    );
                    $del_state = Db::getInstance()->getValue(
                        'SELECT name '.
                        'FROM '._DB_PREFIX_.'state '.
                        'WHERE id_state = '.(int)$del_address['id_state']
                    );
                    $del_country = Db::getInstance()->getValue(
                        'SELECT name '.
                        'FROM '._DB_PREFIX_.'country_lang '.
                        'WHERE id_country = '.(int)$del_address['id_country'].' '.
                        'AND id_lang = '.(int)$id_lang
                    );
                    $customer_name2 = $del_address['firstname'].' '.$del_address['lastname'];
                    $address_delivery .= $del_address['firstname'].' '.$del_address['lastname']."\n";
                    if (Tools::strlen($del_address['company']) > 0) {
                        $address_delivery .= $del_address['company']."\n";
                    }
                    $address_delivery .= $del_address['address1']."\n";
                    if (Tools::strlen($del_address['address2']) > 0) {
                        $address_delivery .= $del_address['address2']."\n";
                    }
                    $address_delivery .= $del_address['postcode'].' '.$del_address['city']."\n";
                    if (Tools::strlen($del_state) > 0) {
                        $address_delivery .= $del_state."\n";
                    }
                    $address_delivery .= $del_country."\n";
                    $customer_phone = '';
                    $customer_phone .= $del_address['phone']."\n";
                    if (Tools::strlen($del_address['phone_mobile']) > 0) {
                        $customer_phone .= ' '.$del_address['phone_mobile']."\n";
                    }
                    $supplier_address = '';
                    $sup_address = Db::getInstance()->getRow(
                        'SELECT * FROM '._DB_PREFIX_.'address '.
                        'WHERE id_supplier = '.(int)$supplier
                    );
                    $sup_state = Db::getInstance()->getValue(
                        'SELECT name FROM '._DB_PREFIX_.'state '.
                        'WHERE id_state = '.(int)$sup_address['id_state']
                    );
                    $sup_country = Db::getInstance()->getValue(
                        'SELECT name FROM '._DB_PREFIX_.'country_lang '.
                        'WHERE id_country = '.(int)$sup_address['id_country'].' '.
                        'AND id_lang = '.(int)$id_lang
                    );
                    $supplier_address .= $sup_address['alias']."\n";
                    $supplier_address .= $sup_address['address1']."\n";
                    if (Tools::strlen($sup_address['address2']) > 0) {
                        $supplier_address .= $sup_address['address2']."\n";
                    }
                    $supplier_address .= $sup_address['postcode'].' '.$sup_address['city']."\n";
                    if (Tools::strlen($sup_state) > 0) {
                        $supplier_address .= $sup_state."\n";
                    }
                    $supplier_address .= $sup_country."\n";
                    $supplier_phone = '';
                    $supplier_phone .= $sup_address['phone']."\n";
                    if (Tools::strlen($sup_address['phone_mobile']) > 0) {
                        $supplier_phone .= ' '.$sup_address['phone_mobile']."\n";
                    }
                    // get carrier template
                    $carrier_template = Db::getInstance()->getValue(
                        'SELECT carrier_template '.
                        'FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
                        'WHERE id_reference = '.(int)$id_reference
                    );

                    $carrier_template = Tools::htmlentitiesDecodeUTF8($carrier_template);

                    $carrier_template =
                        str_replace('{SUPPLIER_NAME}', $this->getSupplierContact($supplier), $carrier_template);
                    $carrier_template =
                        str_replace('{CARRIER_NAME}', $this->getCarrierContact($id_reference), $carrier_template);
                    $carrier_template = str_replace('{ORDER_INFO}', $customer_message, $carrier_template);
                    $carrier_template = str_replace('{CUSTOMER_NAME}', $customer_name2, $carrier_template);
                    $carrier_template = str_replace('{ORDER_DATE}', $order_date, $carrier_template);
                    $carrier_template = str_replace('{ORDER_ID}', $id_order, $carrier_template);
                    $carrier_template = str_replace('{ORDER_REF}', $order_ref, $carrier_template);
                    $carrier_template = str_replace('{INVOICE_NUMBER}', $invoice_num, $carrier_template);
                    $carrier_template = str_replace('{PRODUCTS}', $products_tpl, $carrier_template);
                    $carrier_template =
                        str_replace('{CUSTOMER_ADDRESS}', nl2br($address_delivery), $carrier_template);
                    $carrier_template =
                        str_replace('{SUPPLIER_ADDRESS}', nl2br($supplier_address), $carrier_template);
                    $carrier_template = str_replace('{CUSTOMER_EMAIL}', $customer_email2, $carrier_template);
                    $carrier_template = str_replace('{CUSTOMER_PHONE}', $customer_phone, $carrier_template);
                    $carrier_template = str_replace('{SUPPLIER_PHONE}', $supplier_phone, $carrier_template);
                    $data = array('{CARRIER_TEMPLATE}' => $carrier_template);
                    $carrier_title = Db::getInstance()->getValue(
                        'SELECT carrier_subject '.
                        'FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
                        'WHERE id_reference = '.(int)$id_reference
                    );
                    $carrier_title =
                        str_replace('{SUPPLIER_NAME}', $this->getSupplierContact($supplier), $carrier_title);
                    $carrier_title =
                        str_replace('{CARRIER_NAME}', $this->getCarrierContact($id_reference), $carrier_title);
                    $carrier_title = str_replace('{CUSTOMER_NAME}', $customer_name2, $carrier_title);
                    $carrier_title = str_replace('{ORDER_DATE}', $order_date, $carrier_title);
                    $carrier_title = str_replace('{ORDER_ID}', $id_order, $carrier_title);
                    $carrier_title = str_replace('{ORDER_REF}', $order_ref, $carrier_title);
                    $carrier_title = str_replace('{INVOICE_NUMBER}', $invoice_num, $carrier_title);
                    $attachments = array();
                    $order = new Order($id_order);
                    $carrier_slip = Db::getInstance()->getValue(
                        'SELECT carrier_slip '.
                        'FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
                        'WHERE id_reference = '.(int)$id_reference
                    );
                    $carrier_invoice = Db::getInstance()->getValue(
                        'SELECT carrier_invoice '.
                        'FROM '._DB_PREFIX_.'lgdropshipping_carrier '.
                        'WHERE id_reference = '.(int)$id_reference
                    );
                    if ($carrier_slip) {
                        $pdf =
                            new PDF(
                                $order->getDeliverySlipsCollection(),
                                PDF::TEMPLATE_DELIVERY_SLIP,
                                $this->context->smarty
                            );
                        $file_attachement = array();
                        $file_attachement['content'] = $pdf->render(false);
                        $file_attachement['name'] =
                            Configuration::get('PS_DELIVERY_PREFIX', (int)$order->id_lang, null, $order->id_shop).
                            sprintf('%06d', $order->delivery_number).'.pdf';
                        $file_attachement['mime'] = 'application/pdf';
                        $attachments[] = $file_attachement;
                    }
                    if ($carrier_invoice) {
                        $pdf = new PDF($order->getInvoicesCollection(), PDF::TEMPLATE_INVOICE, $this->context->smarty);
                        $file_attachement = array();
                        $file_attachement['content'] = $pdf->render(false);
                        $file_attachement['name'] =
                            Configuration::get('PS_INVOICE_PREFIX', (int)$order->id_lang, null, $order->id_shop).
                            sprintf('%06d', $order->invoice_number).'.pdf';
                        $file_attachement['mime'] = 'application/pdf';
                        $attachments[] = $file_attachement;
                    }
                    // send carrier email 1
                    if ($email != false) {
                        Mail::Send(
                            (int)$langId,
                            'carriermail',
                            $carrier_title,
                            $data,
                            $email,
                            $contact,
                            (string)Configuration::get('PS_SHOP_EMAIL'),
                            (string)Configuration::get('PS_SHOP_NAME'),
                            $attachments,
                            null,
                            dirname(__FILE__).'/mails/'
                        );
                    }
                    // send carrier email 2
                    if ($email2 != false) {
                        Mail::Send(
                            (int)$langId,
                            'carriermail',
                            $carrier_title,
                            $data,
                            $email2,
                            $contact,
                            (string)Configuration::get('PS_SHOP_EMAIL'),
                            (string)Configuration::get('PS_SHOP_NAME'),
                            $attachments,
                            null,
                            dirname(__FILE__).'/mails/'
                        );
                    }
                    // send carrier email copy
                    if ($email != false or $email2 != false) {
                        if (Tools::strlen(Configuration::get('PS_LGDROPSHIPPING_EMAIL')) > 5) {
                            $carrier_titleC = $carrier_title . " " . $this->l('(copy)');
                            Mail::Send(
                                (int)$langId,
                                'carriermail',
                                $carrier_titleC,
                                $data,
                                Configuration::get('PS_LGDROPSHIPPING_EMAIL'),
                                $contact,
                                (string)Configuration::get('PS_SHOP_EMAIL'),
                                (string)Configuration::get('PS_SHOP_NAME'),
                                $attachments,
                                null,
                                dirname(__FILE__).'/mails/'
                            );
                        }
                    }
                }
            }
        }
    }

    public function getProductImage($id_product, $id_lang)
    {
        $product  = new Product($id_product);
        $images   = $product->getImages((int)$id_lang);
        $language = new LanguageCore($id_lang);

        $main_image = $language->iso_code.'-default';
        if (isset($images[0])) {
            $main_image = $images[0]['id_image'];
        }
        foreach ($images as $image) {
            if ($image['cover']) {
                $main_image = $image['id_image'];
            }
        }
        return $main_image;
    }
}
