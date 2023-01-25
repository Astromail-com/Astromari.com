<?php
/**
* NOTICE OF LICENSE
*
* This file is part of the 'Wk Warehouses Management For Prestashop 1.7' module feature.
* Developped by Khoufi Wissem (2018).
* You are not allowed to use it on several site
* You are not allowed to sell or redistribute this module
* This header must not be removed
*
*  @author    KHOUFI Wissem - K.W
*  @copyright 2022 Khoufi Wissem
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  @version   1.69.76; PSCompatiblity 1.7.3 and Greater
*/

use PrestaShop\PrestaShop\Core\Stock\StockManager;
use PrestaShop\PrestaShop\Adapter\StockManager as StockManagerAdapter;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Wkwarehouses extends Module
{
    const CONFIG_KEY = 'WKWAREHOUSE_';

    public function __construct()
    {
        require_once(dirname(__FILE__).'/classes/Warehouse.php');
        require_once(dirname(__FILE__).'/classes/WarehouseProductLocation.php');
        require_once(dirname(__FILE__).'/classes/WorkshopAsm.php');
        require_once(dirname(__FILE__).'/classes/WarehouseStock.php');
        require_once(dirname(__FILE__).'/classes/WarehouseStockMvt.php');

        $this->name = 'wkwarehouses';
        $this->tab = 'administration';
        $this->version = '1.69.76';
        $this->author = 'Khoufi Wissem';
        $this->need_instance = 0;
        $this->module_key = '5038543a31e6ce1ed934927c19d32bb8';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Wk Warehouses Management');
        $this->description = $this->l('Manage warehouses, their locations and quantities in stock for your products.');
        $this->confirmUninstall = $this->l('All products using already advanced stock management will switch to normal stock management and lose accordingly warehouses stocks configurations. Are you sure you want to uninstall? ');

        /* Add to cart button allowed pages */
        $this->listing_pages = array(
            'category',
            'manufacturer',
            'supplier',
            'search',
            'index', // Homepage
            'searchiqit', // IQIT Warehouse theme
            'retrieveproducts', // wk search products plus module search controller (1.7)
            'findproducts', // wk advanced search by categories module search controller (1.7)
        );
        /* Overrides list */
        $this->my_overrides = array(
            0 => array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/controllers/admin/AdminProductsController.php',
                'target' => _PS_OVERRIDE_DIR_.'controllers/admin/AdminProductsController.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'controllers/admin/'
            ),
            1 => array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/controllers/front/OrderConfirmationController.php',
                'target' => _PS_OVERRIDE_DIR_.'controllers/front/OrderConfirmationController.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'controllers/front/'
            ),
            2 => array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/controllers/front/CartController.php',
                'target' => _PS_OVERRIDE_DIR_.'controllers/front/CartController.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'controllers/front/'
            ),
            3 => array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/classes/order/Order.php',
                'target' => _PS_OVERRIDE_DIR_.'classes/order/Order.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'classes/order/'
            ),
            4 => array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/classes/Cart.php',
                'target' => _PS_OVERRIDE_DIR_.'classes/Cart.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'classes/'
            ),
            5 => array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/classes/Address.php',
                'target' => _PS_OVERRIDE_DIR_.'classes/Address.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'classes/'
            ),
            6 => array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/classes/stock/StockManager.php',
                'target' => _PS_OVERRIDE_DIR_.'classes/stock/StockManager.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'classes/stock/'
            ),
            7 => array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/classes/checkout/DeliveryOptionsFinder.php',
                'target' => _PS_OVERRIDE_DIR_.'classes/checkout/DeliveryOptionsFinder.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'classes/checkout/'
            ),
            8 => array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/classes/stock/Warehouse.php',
                'target' => _PS_OVERRIDE_DIR_.'classes/stock/Warehouse.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'classes/stock/'
            ),
        );
        if (version_compare(_PS_VERSION_, '1.7.7.0', '<')) {
            $this->my_overrides[] = array(
                'source' => _PS_MODULE_DIR_.$this->name.'/override/controllers/admin/AdminOrdersController.php',
                'target' => _PS_OVERRIDE_DIR_.'controllers/admin/AdminOrdersController.php',
                'targetdir' => _PS_OVERRIDE_DIR_.'controllers/admin/',
            );
        }

        /* T A B S */
        $this->my_tabs = array(
            0 => array(
                'name' => array(
                    'en' => 'Wk Warehouses Management',
                    'fr' => 'WK Gestion Entrepôts'
                ),
                'className' => 'AdminParentWkwarehousesconf',
                'id_parent' => 0,
                'is_tool' => 0,
                'is_hidden' => 0,
                'ico' => 0
            ),
            1 => array(
                'name' => array(
                    'en' => 'Dashboard',
                    'fr' => 'Tableau De Bord'
                ),
                'className' => 'AdminWkwarehousesdash',
                'id_parent' => 0,
                'is_tool' => 0,
                'is_hidden' => 0,
                'ico' => 0
            ),
            2 => array(
                'name' => array(
                    'en' => 'Manage Warehouses',
                    'fr' => 'Gestion Entrepôts'
                ),
                'className' => 'AdminManageWarehouses',
                'id_parent' => -1,
                'is_tool' => 0,
                'is_hidden' => 0,
                'ico' => 'warehouses.png'
            ),
            3 => array(
                'name' => array(
                    'en' => 'Manage Products/Warehouses',
                    'fr' => 'Gestion Produits/Entrepôts'
                ),
                'className' => 'AdminWkwarehousesManageQty',
                'id_parent' => -1,
                'is_tool' => 1,
                'is_hidden' => 0,
                'ico' => 'stock.png'
            ),
            4 => array(
                'name' => array(
                    'en' => 'Stock Movements',
                    'fr' => 'Mouvements de Stock'
                ),
                'className' => 'AdminWkwarehousesStockMvt',
                'id_parent' => -1,
                'is_tool' => 1,
                'is_hidden' => 0,
                'ico' => 'movement.png'
            ),
            5 => array(
                'name' => array(
                    'en' => 'Instant Stock Status',
                    'fr' => 'État Instantané du Stock'
                ),
                'className' => 'AdminWkwarehousesStockInstantState',
                'id_parent' => -1,
                'is_tool' => 1,
                'is_hidden' => 0,
                'ico' => 'instant.png'
            ),
            6 => array(
                'name' => array(
                    'en' => 'Orders/Warehouses Assignments',
                    'fr' => 'Associations Entrepôts/Commandes'
                ),
                'className' => 'AdminWkwarehousesOrders',
                'id_parent' => -1,
                'is_tool' => 1,
                'is_hidden' => 0,
                'ico' => 'assign-order.png'
            ),
        );
        /* CONFIG PARAMETERS NAMES */
        $this->keyInfos = array(
            'USE_ASM_NEW_PRODUCT' => 'int',
            'STOCKPRIORITY_INC' => 'int',
            'ON_DELIVERY_SLIP' => 'int',
            'STOCKPRIORITY_DEC' => 'int',
            'DISPLAY_STOCK_INFOS' => 'int',
            'WAREHOUSES_INCART' => 'int',
            'DISPLAY_STOCK_ICON' => 'int',
            'LOCATIONS_INCART' => 'int',
            'DELIVERYTIMES_INCART' => 'int',
            'QUANTITIES_INCART' => 'int',
            'DISPLAY_DELIVERIES_TIME' => 'int',
            'DISPLAY_LOCATION' => 'int',
            'ALLOW_MULTIWH_CART' => 'int',
            'LOCATION_ORDER_PAGE' => 'int',
            'ALLOWSET_WAREHOUSE' => 'int',
            'CHANGE_ORDER_WAREHOUSE' => 'int',
            'DISPLAY_SELECTED_WAREHOUSE' => 'int',
            //'NO_SPLIT_ORDERS' => 'int',
            'DISPLAY_WAREHOUSE_NAME' => 'int',
            'DISPLAY_SELECTED_LOCATION' => 'int',
            'ENABLE_FONTAWESOME' => 'int',
            'DISPLAY_SELECTED_STOCK' => 'int',
            'WAREHOUSEINFOS_POSITION' => 'string',
            'DISPLAY_DELIVERYTIME' => 'int',
            'ENABLE_INCART' => 'int',
            'POSITION_INCART' => 'string',
            'ALLOW_MULTICARRIER_CART' => 'int',
            'DISPLAY_COUNTRIES' => 'int',
            'DISPLAY_COUNTRY' => 'int',
            'COUNTRIES_INCART' => 'int',
            'ALLOW_MULTI_ADDRESSES' => 'int',
            'DELIVERY_ADDRESS_INCART' => 'int',
            'SHOW_OUTOFSTOCK' => 'int',
        );
    }

    public function install($install = true)
    {
        if (!version_compare(_PS_VERSION_, '1.7.2.0', '>=')) {
            $this->_errors[] = $this->l('This module can not be installed on Prestashop version less than 1.7.2!');
            return false;
        } else {
            // Prepare override cart file according to PS version to avoid warning declaration in debug mode
            $override_cart_file = _PS_MODULE_DIR_.$this->name.DIRECTORY_SEPARATOR
			.'override'.DIRECTORY_SEPARATOR
			.'classes'.DIRECTORY_SEPARATOR.'Cart.php';
            if (version_compare(_PS_VERSION_, '1.7.7.0', '<=')) {
				$override_cart_content = Tools::file_get_contents($override_cart_file);
				$override_cart_content = str_replace(
					'public function getPackageShippingCost($id_carrier = null, $use_tax = true, Country $default_country = null, $product_list = null, $id_zone = null, bool $keepOrderPrices = false)',
					'public function getPackageShippingCost($id_carrier = null, $use_tax = true, Country $default_country = null, $product_list = null, $id_zone = null)',
					$override_cart_content
				);
				$override_cart_content = str_replace(
					'$shipping_cost = parent::getPackageShippingCost($id_carrier, $use_tax, $default_country, $product_list, $id_zone, $keepOrderPrices);',
					'$shipping_cost = parent::getPackageShippingCost($id_carrier, $use_tax, $default_country, $product_list, $id_zone);',
					$override_cart_content
				);
            	file_put_contents($override_cart_file, ''.$override_cart_content);
            }

        	if (version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
                copy($path.'PaymentModule1760.php', $path.'PaymentModule.php');
			}
            if (!parent::install() ||
                !Configuration::updateGlobalValue('WKWAREHOUSE_LAST_VERSION', $this->version) ||
                //!$this->registerHook('actionProductSave') ||
                //!$this->registerHook('actionAdminControllerSetMedia') ||
                !$this->registerHook('header') ||
                !$this->registerHook('actionValidateOrder') ||
                !$this->registerHook('actionProductUpdate') ||
                !$this->registerHook('actionObjectUpdateAfter') ||
                !$this->registerHook('actionCartUpdateQuantityBefore') ||
                !$this->registerHook('actionProductDelete') ||
                !$this->registerHook('displayProductAdditionalInfo') ||
                !$this->registerHook('actionObjectAddAfter') ||
                !$this->registerHook('actionObjectDeleteAfter') ||
                !$this->registerHook('actionAdminDeleteBefore') ||
                !$this->registerHook('actionCartSave') ||
                !$this->registerHook('actionOrderStatusPostUpdate') ||
                !$this->registerHook('actionObjectProductInCartDeleteAfter') ||
                !$this->registerHook('actionAttributeCombinationDelete') ||
                !$this->registerHook('actionUpdateQuantity') ||
                !$this->registerHook('actionGetProductPropertiesAfter') ||
                !$this->registerHook('actionGetProductPropertiesBefore') ||
                !$this->registerHook('actionSetInvoice') ||
                !$this->registerHook('actionOrderEdited') ||
                !$this->registerHook('displayAdminOrder') ||
                !$this->registerHook('displayAdminProductsExtra') ||
                !$this->registerHook('displayPDFDeliverySlip') ||
                !$this->registerHook('displayProductExtraContent') ||
                !$this->registerHook('displayReassurance') ||
                !$this->registerHook('displayBackOfficeHeader')) {
                return false;
            }
            // Fix Prestashop bug (does not call to ActionCartUpdateQuantityBefore Hook while it's present in Cart.php)
            $this->fixActionCartUpdateQuantityBeforeHook();

            Configuration::updateValue('PS_ADVANCED_STOCK_MANAGEMENT', 1); // Activate A.S.M
            Configuration::updateValue('PS_DEFAULT_WAREHOUSE_NEW_PRODUCT', 0);
            Configuration::updateValue('WKWAREHOUSE_USE_ASM_NEW_PRODUCT', 0);
            Configuration::updateValue('WKWAREHOUSE_ON_DELIVERY_SLIP', 0);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_STOCK_INFOS', 0);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_STOCK_ICON', 0);
            Configuration::updateValue('WKWAREHOUSE_PRIORITY', '');
            Configuration::updateValue('WKWAREHOUSE_ALLOW_MULTIWH_CART', 1);
            Configuration::updateValue('WKWAREHOUSE_ALLOW_MULTICARRIER_CART', 1);
            Configuration::updateValue('WKWAREHOUSE_PRIORITY_DECREASE', '');
            Configuration::updateValue('WKWAREHOUSE_ALLOWSET_WAREHOUSE', 0);
            Configuration::updateValue('WKWAREHOUSE_ALLOW_MULTI_ADDRESSES', 0);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_DELIVERIES_TIME', 0);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_SELECTED_WAREHOUSE', 0);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_COUNTRIES', 1);
            Configuration::updateValue('WKWAREHOUSE_ENABLE_FONTAWESOME', 1);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_LOCATION', 0);
            Configuration::updateValue('WKWAREHOUSE_LOCATION_ORDER_PAGE', 0);
            Configuration::updateValue('WKWAREHOUSE_WAREHOUSEINFOS_POSITION', 'afterCart');
            Configuration::updateValue('WKWAREHOUSE_POSITION_INCART', 'belowProductName');
            Configuration::updateValue('WKWAREHOUSE_STOCKPRIORITY_INC', 1);
            Configuration::updateValue('WKWAREHOUSE_STOCKPRIORITY_DEC', 1);
            Configuration::updateValue('WKWAREHOUSE_CHANGE_ORDER_WAREHOUSE', 0);
            Configuration::updateValue('WKWAREHOUSE_WAREHOUSES_INCART', 0);
            Configuration::updateValue('WKWAREHOUSE_DELIVERYTIMES_INCART', 0);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_SELECTED_LOCATION', 0);
            Configuration::updateValue('WKWAREHOUSE_LOCATIONS_INCART', 0);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_WAREHOUSE_NAME', 1);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_SELECTED_STOCK', 1);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_DELIVERYTIME', 0);
            Configuration::updateValue('WKWAREHOUSE_QUANTITIES_INCART', 0);
            Configuration::updateValue('WKWAREHOUSE_ENABLE_INCART', 0);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_COUNTRIES', 1);
            Configuration::updateValue('WKWAREHOUSE_DISPLAY_COUNTRY', 0);
            Configuration::updateValue('WKWAREHOUSE_COUNTRIES_INCART', 0);
            Configuration::updateValue('WKWAREHOUSE_DELIVERY_ADDRESS_INCART', 0);
            Configuration::updateValue('WKWAREHOUSE_SHOW_OUTOFSTOCK', 1);

            if ($install) {
                // Remove Added Tabs when asm is activated
                $classeNames_tabs = array(
                    'AdminStock',
                    'AdminWarehouses',
                    'AdminParentStockManagement',
                    'AdminStockMvt',
                    'AdminStockInstantState',
                    'AdminStockCover',
                    'AdminSupplyOrders',
                    'AdminStockConfiguration'
                );
                foreach ($classeNames_tabs as $classname) {
                    $tab = Tab::getInstanceFromClassName($classname);
                    if (Validate::isLoadedObject($tab)) {
                        $tab->delete();
                    }
                }
                $this->installDB();
                $this->installTabs();
            }

            if (version_compare(_PS_VERSION_, '1.7.6.0', '<')) {
                // Patch for front cart controller (make updateOperationError accessible from override)
                $fileOverride = _PS_ROOT_DIR_.'/controllers/front/CartController.php';
                if (file_exists($fileOverride)) {
                    $cartContent = Tools::file_get_contents($fileOverride);
                    $cartContent = str_replace(
                        'private $updateOperationError = array();',
                        'protected $updateOperationError = array();',
                        $cartContent
                    );
                    file_put_contents($fileOverride, $cartContent);
                }
                // Patch for PaymentModule class
                // Fix Major Prestashop Bug : when splitted orders, differents carriers but
                // the carrier name is the same in order confirmation emails!
                $fileOverride = _PS_ROOT_DIR_.'/classes/PaymentModule.php';
                if (file_exists($fileOverride)) {
                    $paymentContent = Tools::file_get_contents($fileOverride);
                    $paymentContent = str_replace(
                        array('$invoice = new Address((int) $order->id_address_invoice);', '$invoice = new Address((int)$order->id_address_invoice);'),
                        '$invoice = new Address((int)$order->id_address_invoice);
                        $carrier = $order->id_carrier ? new Carrier($order->id_carrier) : false;',
                        $paymentContent
                    );
                    file_put_contents($fileOverride, $paymentContent);
                }
            }
            // Sometimes, override admin controller folder is missing
            if (!is_dir(dirname(__FILE__).'/../../override/controllers/admin/')) {
                mkdir(dirname(__FILE__).'/../../override/controllers/admin/', 0777, true);
            }
            return true;
        }
    }

    public function reset()
    {
        if (!$this->uninstall(false)) {
            return false;
        }
        if (!$this->install(false)) {
            return false;
        }
        return true;
    }

    /**
     * Activate current module without installing overrides
     * @param bool $force_all If true, enable module for all shop
     * @return bool
     */
    public function enable($force_all = false)
    {
        // Retrieve all shops where the module is enabled
        $list = Shop::getContextListShopID();
        if (!$this->id || !is_array($list)) {
            return false;
        }
        $sql = 'SELECT `id_shop` FROM `' . _DB_PREFIX_ . 'module_shop`
                WHERE `id_module` = '.(int)$this->id .
                (!$force_all ? ' AND `id_shop` IN(' . implode(', ', $list) . ')' : '');

        // Store the results in an array
        $items = array();
        if ($results = Db::getInstance($sql)->executeS($sql)) {
            foreach ($results as $row) {
                $items[] = $row['id_shop'];
            }
        }
        Configuration::updateValue('PS_ADVANCED_STOCK_MANAGEMENT', 1); // Activate A.S.M
        // Install overrides
        if ($this->getOverrides() != null) {
            try {
                $this->installOverrides();
            } catch (Exception $e) {
                $this->_errors[] = Context::getContext()
                ->getTranslator()
                ->trans('Unable to install override: %s', [$e->getMessage()], 'Admin.Modules.Notification');
                $this->uninstallOverrides();
                return false;
            }
        }
        // Enable module in the shop where it is not enabled yet
        foreach ($list as $id) {
            if (!in_array($id, $items)) {
                Db::getInstance()->insert('module_shop', array(
                    'id_module' => $this->id,
                    'id_shop' => $id,
                ));
            }
        }
        return true;
    }

    /**
     * Desactivate current module without uninstalling overrides
     * @param bool $force_all If true, disable module for all shop
     * @return bool
     */
    public function disable($force_all = false)
    {
        $result = true;
        if ($this->getOverrides() != null) {
            $result &= $this->uninstallOverrides();
        }
        // Disable module for all shops
        Configuration::updateValue('PS_ADVANCED_STOCK_MANAGEMENT', 0); // Disable A.S.M
        return Db::getInstance()->execute(
            'DELETE FROM `' . _DB_PREFIX_ . 'module_shop` 
             WHERE `id_module` = ' . (int) $this->id . ' '
            .(!$force_all ? ' AND `id_shop` IN('.implode(', ', Shop::getContextListShopID()).')' : '')
        );
    }

    public function fixActionCartUpdateQuantityBeforeHook()
    {
        if (!Hook::getIdByName('actionCartUpdateQuantityBefore')) {
            $hook = new Hook(); // Create new hook
            $hook->name = 'actionCartUpdateQuantityBefore';
            $hook->title = $hook->name;
            $hook->description = 'Added from Wk Warehouses Management module';
            $hook->position = true;
            $hook->save();
            $this->registerHook('actionCartUpdateQuantityBefore'); // then link to our module
        }
    }

    public function installTabs()
    {
        $id_parent = null;
        foreach ($this->my_tabs as $k => $tab) {
            $tab_name = $tab['name'];
            $obj = new Tab();
            foreach (Language::getLanguages() as $lang) {
                if (!isset($tab_name[$lang['iso_code']])) {
                    $obj->name[$lang['id_lang']] = $tab_name['en'];
                } else {
                    $obj->name[$lang['id_lang']] = $tab_name[$lang['iso_code']];
                }
            }
            $obj->class_name = $tab['className'];

            // Process Parent ID
            if ($k == 0) {// First tab
                $parent_tab = Tab::getIdFromClassName('IMPROVE');
                if (property_exists($obj, 'icon')) {
                    $obj->icon = 'home';
                }
            } else {
                $parent_tab = is_null($id_parent) ? $tab['id_parent'] : $id_parent;
            }
            $obj->id_parent = (int)$parent_tab;
            // End processing parent ID

            $obj->module = $this->name;
            if ($obj->add()) {
                // Get the ID of the first tab that will be the parent ID of the next tabs
                if ($k == 0) {
                    $id_parent = (int)$obj->id;
                }
            }
        }
        return true;
    }

    public function installDB()
    {
        require_once(dirname(__FILE__).'/install/install.php');

        $result = true;
        // Export already existant warehouses names to the new table
        $result &= StoreHouse::exportWarehousesLanguages();

        return $result;
    }

    public function loadSQLFile($sql_file)
    {
        $sql_content = Tools::file_get_contents($sql_file);
        $sql_content = str_replace('PREFIX_', _DB_PREFIX_, $sql_content);
        $sql_content = str_replace('_SQLENGINE_', _MYSQL_ENGINE_, $sql_content);
        $sql_requests = preg_split("/;\s*[\r\n]+/", $sql_content);
        $result = true;
        foreach ($sql_requests as $request) {
            if (!empty($request)) {
                $result &= Db::getInstance()->execute(trim($request));
            }
        }
        return $result;
    }

    public function uninstall($uninstall = true)
    {
        if (!parent::uninstall()) {
            return false;
        }
        if ($uninstall) {
            Configuration::updateValue('PS_ADVANCED_STOCK_MANAGEMENT', 0); // Reset A.S.M
            Configuration::updateValue('PS_DEFAULT_WAREHOUSE_NEW_PRODUCT', 0);
            // Delete all module config. parameters
            Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'configuration` WHERE `name` LIKE "WKWAREHOUSE_%" ');
            $this->uninstallTabs();
            // Disable advanced stock management from products
            WorkshopAsm::setAdvancedStockManagement();
        }
        return true;
    }

    public function uninstallTabs()
    {
        $tabs = Tab::getCollectionFromModule($this->name);
        foreach ($tabs as $tab) {
            $tab->delete();
        }
    }

    public function hookActionBeforeCartUpdateQty($data)
    {
        return $this->hookActionCartUpdateQuantityBefore($data);
    }

    /*
    * BO Order Management: only one carrier is allowed when adding product in cart
    */
    public function hookActionCartUpdateQuantityBefore($data)
    {
        if (!$this->active || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') ||
            !isset($data['product']) || !$data['product'] instanceof Product) {
            return;
        }
        
        // Management from BO
        if (defined('_PS_ADMIN_DIR_')) {
            $request = $this->getAdminControllerNameAndAction();
            if (in_array($request['admin_action'], array(
                'updateQty', // adding product during creating order
                'addProductOnOrder', // adding product during editing order PS < 1.7.7.x
                'addProductAction', // adding product during editing order PS >= 1.7.7.x
            ))) {
                $id_product = (int)$data['product']->id;
                $id_product_attribute = (int)$data['id_product_attribute'];
                $product_asm = (int)$data['product']->advanced_stock_management;
                $id_address_delivery = $order = null;

                $idOrder = Tools::getIsset('id_order') ? Tools::getValue('id_order') : null;
                if (is_null($idOrder) && isset($request['orderId'])) {
                    $idOrder = $request['orderId'];
                }
                if (in_array($request['admin_action'], array('addProductOnOrder', 'addProductAction'))) {
                    $order = new Order((int)$idOrder);
                }

                $access = false;
                if (($data['product']->hasAttributes() && $id_product_attribute) ||
                    (!$data['product']->hasAttributes() && empty($id_product_attribute))) {
                    $access = true;
                }
                
                // Test if ASM product is at least associated to one warehouse
                if ($product_asm && $access) {
                    if (empty(WorkshopAsm::getAssociatedWarehousesArray($id_product, $id_product_attribute))) {
                        $errors = $this->l('Error: this product is handled by the advanced stock management system but not yet associated with any warehouse!');
                        $this->useAjaxDieError(
                            $id_product,
                            $id_product_attribute,
                            $request['admin_action'],
                            $errors,
                            $order
                        );
                    }
                }

                $result = WarehouseStock::productIsPresentInCart(
                    $this->context->cart->id,
                    $id_product,
                    $id_product_attribute
                );
                /* is Product stored in warehouse ? */
                $id_warehouse = null;
                if ($product_asm && $result && (int)$result['id_warehouse'] > 0) {
                    $id_warehouse = (int)$result['id_warehouse'];
                }

                // BO Orders Management (EDIT): Adding new product
                // Because PS create new cart, so we need to use the original cart ID to check carrier availability
                if ($request['admin_controller'] == 'AdminOrders' &&
                    in_array($request['admin_action'], array('addProductOnOrder', 'addProductAction')) &&
                    Validate::isLoadedObject($order)) {
                    if (Tools::getIsset('add_product_warehouse')) {
                        $id_warehouse = Tools::getValue('add_product_warehouse');
                        $id_warehouse = (int)(is_array($id_warehouse) ? current($id_warehouse) : $id_warehouse);
                    }
                    $id_address_delivery = (int)$order->id_address_delivery;
                }
                if (empty($id_warehouse)) {
                    $selected_warehouse = WarehouseStock::getAvailableWarehouseAndCartQuantity(
                        $id_product,
                        $id_product_attribute,
                        $this->context->cart
                    );
                    $id_warehouse = (int)$selected_warehouse['id_warehouse'];
                }
                if (empty($id_address_delivery)) {
                    $id_address_delivery = $this->context->cart->id_address_delivery;
                }

                // Check carrier availability
                $carriers = WarehouseStock::getAvailableCarrierList($data['product'], $id_warehouse, $id_address_delivery);

                if (empty($carriers)) {
                    $errors = sprintf(
                        $this->l('Error: this product can not be delivered to the selected delivery address %s'),
                        (Validate::isLoadedObject($order) ? ' '.$this->l('by the selected carrier !') : '')
                    );
                    $this->useAjaxDieError($id_product, $id_product_attribute, $request['admin_action'], $errors, $order);
                }
            }
            return;
        }
    }

    public function useAjaxDieError($id_product, $id_product_attribute, $action, $errors, $order)
    {
        if (in_array($action, array('addProductOnOrder', 'addProductAction')) && Validate::isLoadedObject($order)) {
            // Remove specific price created during process
            $this->removeSpecificPrice($id_product, $id_product_attribute, $order);
            // Throw an exception (an error)
            if (version_compare(_PS_VERSION_, '1.7.7.0', '>=')) {
                throw new Exception($errors);
            } else {
                die(Tools::jsonEncode(array('error' => $errors)));
            }
        } else {
            if (version_compare(_PS_VERSION_, '1.7.7.0', '>=')) {
                throw new Exception($errors);
            } else {
                die(Tools::jsonEncode(
                    array_merge((new AdminCartsControllerCore())->ajaxReturnVars(), array('errors' => array($errors)))
                ));
            }
        }
    }

    public function removeSpecificPrice($id_product, $id_product_attribute, $order)
    {
        $initial_product_price_tax_incl = Product::getPriceStatic(
            $id_product,
            true, // use tax
            (!empty($id_product_attribute) ? (new Combination($id_product_attribute))->id : null),
            2,
            null,
            false,
            true,
            1,
            false,
            $order->id_customer,
            $this->context->cart->id,
            $order->{Configuration::get('PS_TAX_ADDRESS_TYPE', null, null, $order->id_shop)}
        );
        $price_tax_incl = Tools::getIsset('product_price_tax_incl') ? Tools::getValue('product_price_tax_incl') : Tools::getValue('price_tax_incl');
        $quantity = (int)(Tools::getIsset('product_quantity') ? Tools::getValue('product_quantity') : Tools::getValue('quantity'));

        if ($price_tax_incl != $initial_product_price_tax_incl) {
            /* be aware, $this->context->cart is regarding the new cart created specially for the new product on order */
            $specific_price = SpecificPrice::getSpecificPrice(
                $id_product,
                $this->context->cart->id_shop,
                $this->context->cart->id_currency,
                0, //id_country
                $this->context->cart->id_shop_group,
                $quantity,
                $id_product_attribute,
                $this->context->cart->id_customer,
                $this->context->cart->id
            );
            /* that mean specific price has been created */
            if ($specific_price && (float)$specific_price['price'] == (float)$initial_product_price_tax_incl) {
                /* so, remove it to avoid future error */
                $specific_price_obj = new SpecificPrice((int)$specific_price['id_specific_price']);
                $specific_price_obj->delete();
            }
        }
    }

    public function hookAddProduct($params)
    {
        $this->_clearCache('*');
    }

    public function hookUpdateProduct($params)
    {
        if (!isset($params['product'])) {
            return;
        }
        $this->_clearCache('*');
    }

    public function hookDeleteProduct($params)
    {
        $this->_clearCache('*');
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        if (!$this->active || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return;
        }
        // Need to select a store
        if (Shop::isFeatureActive() &&
            in_array($this->context->shop->getContext(), array(Shop::CONTEXT_GROUP, Shop::CONTEXT_ALL))) {
            return $this->displayError(
                $this->l('You are in multishop environment. To use the module, you must select a shop.')
            );
        } else {
            $id_product = (int)$params['id_product'];
            $obj = new Product($id_product, false);

            if (Validate::isLoadedObject($obj)) {
                $this->_clearCache('*');
                return $this->initAdminProductTabWarehouses($obj);
            } else {
                return $this->displayError($this->l('You must save this product before adding warehouses.'));
            }
        }
    }

    /*
    * BackOffice Product Settings In Product Tab
    */
    private function initAdminProductTabWarehouses($obj)
    {
        $this->context->smarty->assign(array(
            'prod' => $obj,
            'use_asm' => Configuration::get('WKWAREHOUSE_USE_ASM_NEW_PRODUCT'),
            'isPack' => !empty($obj->id) ? Pack::isPack($obj->id) : false,
        ));
        return $this->display(__FILE__, 'views/templates/admin/product_tab.tpl');
    }

    /*
    * How to get id_product_attribute on product page
    * https://stackoverflow.com/questions/56061282/prestashop-1-7-how-to-get-id-product-attribute-on-product-page
    */
    public function hookDisplayProductAdditionalInfo($params)
    {
        if (!$this->active || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return;
        }
        $this->page_name = Dispatcher::getInstance()->getController();
        if ($this->page_name == 'product') {
            $this->context->smarty->assign(array(
                'id_product_attribute' => $params['product']['id_product_attribute'],
            ));
            return $this->fetch(
                'module:wkwarehouses/views/templates/hook/product_combination.tpl'
            );
        }
    }

    private function setProductProperties($product)
    {
        $id_product_attribute = (!empty($product['id_product_attribute']) ? (int)$product['id_product_attribute'] : null);
        if (Combination::isFeatureActive() && $id_product_attribute === null) {
            if (isset($product['cache_default_attribute']) && !empty($product['cache_default_attribute'])) {
                $id_product_attribute = $product['cache_default_attribute'];
            } else {
                $id_product_attribute = Product::getDefaultAttribute(
                    $product['id_product'],
                    Product::isAvailableWhenOutOfStock($product['out_of_stock'])
                );
            }
        }
        return $id_product_attribute;
    }

    /***********************************************/
    /***** Fix delivery address if cart empty *****/
    /**********************************************/
    public function hookActionGetProductPropertiesBefore($params)
    {
		// Fom FO
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && !defined('_PS_ADMIN_DIR_')) {
            $this->page_name = Dispatcher::getInstance()->getController();
			// IF Product page and cart loaded and valid
            if ($this->page_name == 'product' && Tools::getIsset('id_product') && Tools::getValue('id_product') &&
                ($params['product']['id_product'] == Tools::getValue('id_product')) &&
                Validate::isLoadedObject($this->context->cart) && $this->context->cart->id_address_delivery) {
                // Get all delivery addresses
                $addresses = $this->context->customer->getAddresses($this->context->language->id);

                if (!$this->context->cart->hasProducts() && count($addresses) > 1) {
                    // Instanciate product
                    $product = new Product((int)Tools::getValue('id_product'), false);
                    if (Validate::isLoadedObject($product)) {
                        $id_product_attribute = (int)$this->setProductProperties($params['product']);

                        $id_warehouse = null;
                        if ($product->advanced_stock_management &&
                            !empty(WorkshopAsm::getAssociatedWarehousesArray($product->id, $id_product_attribute))) {
                            // Get the warehouse with enough quantity
                            $id_warehouse = WorkshopAsm::findWarehousePriority(array(), true, $product->id, $id_product_attribute, 'desc');
                        }
                        // Begin to checkup carriers with the default cart delivery address
                        $carriers = WarehouseStock::getAvailableCarrierList(
                            $product,
                            $id_warehouse,
                            $this->context->cart->id_address_delivery
                        );
                        if (count($carriers) == 0) {
                            foreach ($addresses as $address) {
                                $carriers = WarehouseStock::getAvailableCarrierList(
                                    $product,
                                    $id_warehouse,
                                    $address['id_address']
                                );
                                if (count($carriers) && $this->context->cart->id_address_delivery != $address['id_address']) {
                                    $this->context->cart->id_address_delivery = $address['id_address'];
                                    $this->context->cart->id_address_invoice = $address['id_address'];
                                    $this->context->cart->save();
                                    /*WarehouseStock::updateCartDeliveryAddress(
                                        $this->context->cart->id,
                                        $address['id_address'],
                                        true
                                    );*/
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /*
    * - This hook is very important as that it allows to adjust/override the product/combination quantity
    *   according to the right warehouse quantity
    * - Executed only from product page or products listing page
    */
    public function hookActionGetProductPropertiesAfter($params)
    {
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && !defined('_PS_ADMIN_DIR_')) {
            $this->page_name = Dispatcher::getInstance()->getController();
            $inListing = in_array($this->page_name, $this->listing_pages);
            if (($this->page_name == 'product' && Tools::getIsset('id_product') && $params['product']['id_product'] == Tools::getValue('id_product')) ||// from product page
                ($inListing && $params['product']['id_product'] > 0)) {// From listing pages
                $id_product = Tools::getIsset('id_product') ? Tools::getValue('id_product') : $params['product']['id_product'];

                $product = new Product((int)$id_product, false);
                if (Validate::isLoadedObject($product)) {
                    if ($product->advanced_stock_management) {
                        $id_product_attribute = (int)$this->setProductProperties($params['product']);
                        /*
                         * iF Product is handled by A.S.M but not store in any warehouse yet or is Pack :
                         *  - Make product as out-of-stock
                         *  - Display message to customer in product page: Not available in any warehouse
                        */
                        if (empty(WorkshopAsm::getAssociatedWarehousesArray($product->id, $id_product_attribute)) ||
                            Pack::isPack($product->id)) {
                            $params['product']['quantity'] = 0;
                            $params['product']['quantity_all_versions'] = 0;
                            $params['product']['allow_oosp'] = 0; // Force disabling adding product to cart
                            $params['product']['cart_quantity'] = 0;
                            $params['product']['quantity_wanted'] = 0;
                            $params['product']['quantity_available'] = 0;
                            $params['product']['available_for_order'] = 0;
                        } else {
                            $selected_warehouse = WarehouseStock::getAvailableWarehouseAndCartQuantity(
                                $product->id,
                                $id_product_attribute
                            );
                            if ($selected_warehouse && $selected_warehouse['id_warehouse'] > 0) {
                                $has_carriers = $inListing ? true : $selected_warehouse['has_carriers'];
								$available_quantity = $selected_warehouse['quantity'];
								// If user do not see the target warehouse, display the whole available quantity
								if (!Configuration::get('WKWAREHOUSE_ALLOWSET_WAREHOUSE') &&
									!Configuration::get('WKWAREHOUSE_DISPLAY_SELECTED_WAREHOUSE')) {
									$stock_infos = WorkshopAsm::getAvailableStockByProduct(
                                		$product->id,
										$id_product_attribute
									);
									if ($stock_infos) {
										$available_quantity = $stock_infos['quantity'];
									}
								}

                                $params['product']['quantity'] = $has_carriers ? $available_quantity : 0;
                                $params['product']['quantity_all_versions'] = $has_carriers ? $available_quantity : 0;
                                $params['product']['id_warehouse'] = $selected_warehouse['id_warehouse'];
                            }
                        }
                    } else {/* Not A.S.M */
                        if (!$inListing && !Configuration::get('WKWAREHOUSE_ALLOW_MULTICARRIER_CART')) {
                            $product_carriers = WarehouseStock::getCarriersByCustomerAddresses($product);
                            if (!count($product_carriers['available_carriers'])) {
                                $params['product']['quantity'] = 0;
                                $params['product']['quantity_all_versions'] = 0;
								$params['product']['cart_quantity'] = 0;
								$params['product']['quantity_wanted'] = 0;
								$params['product']['quantity_available'] = 0;
								$params['product']['available_for_order'] = 0;
                            }
                        }
                    }
                }
            }
        }
    }

    public function hookHeader()
    {
        if (!$this->active || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return;
        }

        $allow_multicarriers_cart = (int)Configuration::get('WKWAREHOUSE_ALLOW_MULTICARRIER_CART');
        $this->page_name = Dispatcher::getInstance()->getController();
        // If product page
        if ($this->page_name == 'product' && Configuration::get('PS_STOCK_MANAGEMENT') &&
            Tools::getIsset('id_product') && Tools::getValue('id_product')) {
            $allow_multiwarehouses_cart = (int)Configuration::get('WKWAREHOUSE_ALLOW_MULTIWH_CART');
            $allow_set_warehouse = (int)Configuration::get('WKWAREHOUSE_ALLOWSET_WAREHOUSE');
            $display_best_warehouse = Configuration::get('WKWAREHOUSE_DISPLAY_SELECTED_WAREHOUSE');

            $id_product = (int)Tools::getValue('id_product');
            $product = new Product($id_product, false);

            if (Validate::isLoadedObject($product)) {
                $this->context->controller->addJqueryPlugin('fancybox');
                if (!$product->advanced_stock_management) {
                    if (!$allow_multicarriers_cart) {
                        $this->context->controller->addJS($this->_path.'views/js/product-not-asm.min.js');
                        return ($this->display(__FILE__, '/product_header.tpl'));
                    }
                } else {
                    if (Configuration::get('WKWAREHOUSE_DISPLAY_STOCK_INFOS') ||
                        Configuration::get('WKWAREHOUSE_DISPLAY_LOCATION') ||
                        Configuration::get('WKWAREHOUSE_DISPLAY_DELIVERIES_TIME') ||
                        Configuration::get('WKWAREHOUSE_DISPLAY_COUNTRIES') ||
                        !$allow_multiwarehouses_cart || $display_best_warehouse || $allow_set_warehouse ||
                        !$allow_multicarriers_cart) {
                        $this->context->controller->addJS($this->_path.'views/js/product.min.js');

                        // Load JS & CSS files
                        if (Configuration::get('WKWAREHOUSE_ENABLE_FONTAWESOME')) {// Font Awesome 5.11.2
                            $this->context->controller->addCSS($this->_path.'views/css/fontawesome.css', 'all');
                        }
                        $this->context->controller->addCSS($this->_path.'views/css/solid.css', 'all');
                        $this->context->controller->addCSS($this->_path.'views/css/product.css', 'all');

                        if (Configuration::get('WKWAREHOUSE_WAREHOUSEINFOS_POSITION') == 'afterCart') {
                            $warehouses_infos = WarehouseStock::warehousesDataOnProductPage($id_product);
							WarehouseStock::takeOffDisabledWarehouses($warehouses_infos);

                            $this->context->smarty->assign('product_stocks_list', $warehouses_infos);
                            $this->setCommonSmartyVarsProductPage();
                        }
                    }
                    if ((isset($warehouses_infos) && count($warehouses_infos)) || !$allow_multiwarehouses_cart ||
                        !$allow_multicarriers_cart || $allow_set_warehouse || $display_best_warehouse) {
                        $this->context->smarty->assign('module_dir', $this->_path);
                        return $this->display(__FILE__, '/product_header.tpl');
                    }
                }
            }
        }

        // On product list pages
        if (in_array($this->page_name, $this->listing_pages)) {
            $this->context->controller->addJqueryPlugin('fancybox');
            $this->context->controller->registerJavascript(
                'modules-'.$this->name.'-global',
                'modules/'.$this->name.'/views/js/product_list.min.js',
                array('position' => 'bottom', 'priority' => 99999999) // prioriy hight to load always after all others scripts
            );
            Media::addJsDefL('process_cart_url', $this->context->link->getModuleLink($this->name, 'processactions'));
            Media::addJsDefL('txt_ok', $this->l('Ok'));
        }

        // On cart page
        if ($this->page_name == 'cart') {
            $this->context->controller->addJS($this->_path.'views/js/cart.min.js');
            /* Check up for every product if it can be delivered to the customer address */
            if (!Configuration::get('WKWAREHOUSE_ALLOW_MULTI_ADDRESSES') &&
                $this->context->cart->id_address_delivery) {
                $this->context->smarty->assign(
                    'delivery_address',
                    $this->getCountryName($this->context->cart->id_address_delivery)
                );
                $this->context->smarty->assign(
                    'carriers_restrictions',
                    $this->checkDeliveriesCustomerAddressOnCartListing()
                );
            }
            /* Display warehouses informations for each A.S.M product */
            if (Configuration::get('WKWAREHOUSE_ENABLE_INCART')) {
                $result = $this->initWarehousesInformationsOnCartListing();
                if ($result['asmProductsInCart'] && count($result['warehousesInfos'])) {
                    $this->context->smarty->assign('warehouses_cart_details', $result['warehousesInfos']);
                }
            }
            $this->context->smarty->assign(array(
                'link' => new Link(),
                'deliver_address_incart' => Configuration::get('WKWAREHOUSE_DELIVERY_ADDRESS_INCART') && !Configuration::get('WKWAREHOUSE_ALLOW_MULTI_ADDRESSES'),
            ));
            return $this->display($this->_path, 'views/templates/hook/cart_products.tpl');
        }

        // Checkout page and multi-shipping (multi-carriers) option enabled
        if ($this->page_name == 'order' && $allow_multicarriers_cart &&
            WarehouseStock::isMultiShipping($this->context->cart)) {
            $this->context->controller->addJS($this->_path.'views/js/order.min.js');
            $this->context->controller->addJqueryPlugin('fancybox');
            $this->context->controller->addCSS($this->_path.'views/css/wkwarehouses.css', 'all');

            /* Check delivery address of each product in cart and try to fix it if possible */
            WarehouseStock::assignRightDeliveryAddressToEachProductInCart($this->context->cart);

            if (class_exists('PrestaShop\PrestaShop\Adapter\Presenter\Cart\CartPresenter')) {
                $presenter = new PrestaShop\PrestaShop\Adapter\Presenter\Cart\CartPresenter();
            } else {
                $presenter = new PrestaShop\PrestaShop\Adapter\Cart\CartPresenter();
            }
            if (class_exists('PrestaShop\PrestaShop\Adapter\Presenter\Object\ObjectPresenter')) {
                $object_presenter = new PrestaShop\PrestaShop\Adapter\Presenter\Object\ObjectPresenter();
            } else {
                $object_presenter = new PrestaShop\PrestaShop\Adapter\ObjectPresenter();
            }

            $presented_cart = $presenter->present($this->context->cart);
            $id_lang = (int)$this->context->language->id;

            if (count($presented_cart['products']) > 0) {
                $cart_collection = array();

                /***** Generate delivery addresses list related to each product ******/
                /*********************************************************************/
                if (Configuration::get('WKWAREHOUSE_ALLOW_MULTI_ADDRESSES')) {
                    foreach ($presented_cart['products'] as $cart_line) {
                        $id_product = (int)$cart_line['id_product'];
                        $id_product_attribute = (int)$cart_line['id_product_attribute'];
                        $id_address_delivery = (int)$cart_line['id_address_delivery'];
                        $product = new Product($id_product, false);

                        $product_tmp = array();
                        $product_tmp['id_product'] = $id_product;
                        $product_tmp['id_product_attribute'] = $id_product_attribute;
                        $product_tmp['id_address_delivery'] = $id_address_delivery;
                        $format = array('cart', 'default');
                        $product_tmp['image'] = $cart_line['cover']['bySize'][$format[0].'_'.$format[1]]['url'];
                        $product_tmp['url'] = $cart_line['url'];
                        $product_tmp['has_discount'] = $cart_line['has_discount'];
                        $product_tmp['name'] = $cart_line['name'];
                        $product_tmp['discount_type'] = $cart_line['discount_type'];
                        $product_tmp['regular_price'] = $cart_line['regular_price'];
                        $product_tmp['discount_percentage_absolute'] = $cart_line['discount_percentage_absolute'];
                        $product_tmp['discount_to_display'] = $cart_line['discount_to_display'];
                        $product_tmp['price'] = $cart_line['price'];
                        $product_tmp['unit_price_full'] = $cart_line['unit_price_full'];
                        $attributes = array();
                        foreach ($cart_line['attributes'] as $k => $attribute) {
                            array_push($attributes, $k.': '.$attribute);
                        }
                        $product_tmp['attributes'] = $attributes;

                        /* Get all customer delivery addresses */
                        $addresses = $this->context->customer->getAddresses($id_lang);

                        $id_warehouse = 0;
                        $result = WarehouseStock::productIsPresentInCart(
                            $this->context->cart->id,
                            $id_product,
                            $id_product_attribute
                        );
                        if ($result && $result['id_warehouse'] > 0 && $product->advanced_stock_management) {
                            $id_warehouse = (int)$result['id_warehouse'];
                            /* Look for the customer addresses that match with the warehouse */
                            $warehouse = new StoreHouse($id_warehouse, $id_lang);

                            if (Validate::isLoadedObject($warehouse) && Address::isCountryActiveById($warehouse->id_address)) {
                                $product_tmp['warehouse_name'] = $warehouse->name;

                                $wa = Address::getCountryAndState($warehouse->id_address);
                                $warehouse_country = new Country($wa['id_country'], $id_lang);
    
                                /* Add warehouse country informations */
                                $product_tmp['warehouse_country_name'] = $warehouse_country->name;
                                /* Get the warehouse zone */
                                $id_zone = $warehouse_country->id_zone;
                            }
                        } else {
                            /* Handled by Normal stock management */
                            $carriers_list = WarehouseStock::getAvailableCarrierList($product, null, $id_address_delivery);
                            if (empty($carriers_list)) {/* product can not be delivered to that delivery address */
                                $id_zone = 0;
                                if (count($product->getCarriers())) {
                                    // Get the best carrier according to its assigned zones && propose it to user
                                    $best_carrier = WarehouseStock::getBestAvailableProductCarrier($product->id);
                                    if ($best_carrier) {
                                        $id_zone = $best_carrier['id_zone'];
                                        // Get all countries
                                        if (Configuration::get('PS_RESTRICT_DELIVERED_COUNTRIES')) {
                                            $availableCountries = Carrier::getDeliveredCountries($id_lang, true, true);
                                        } else {
                                            $availableCountries = Country::getCountries($id_lang, true);
                                        }
                                        $countries_by_zone = array();
                                        foreach ($availableCountries as $country) {
                                            $countryObject = new Country($country['id_country'], $id_lang);
                                            if ($countryObject->id_zone == $id_zone) {
                                                $countries_by_zone[] = $countryObject->name;
                                            }
                                        }
                                        $product_tmp['best_zone'] = count($countries_by_zone) ? implode(', ', $countries_by_zone) : '';
                                    }
                                }
                            } else {
                                $wa = Address::getCountryAndState($id_address_delivery);
                                $id_zone = (new Country($wa['id_country']))->id_zone;
                            }
                        }

                        /* Available delivery addresses for each product */
                        foreach ($addresses as $k => $address) {
                            $id_address_zone = Address::getZoneById((int)$address['id_address']);
                            if (isset($id_zone) && $id_address_zone != $id_zone) {
                                unset($addresses[$k]);
                            }
                        }
                        /* Prepare the default delivery selected address */
                        foreach ($addresses as &$addr) {
                            $addr['selected'] = ($addr['id_address'] == $id_address_delivery ? 1 : 0);
                        }
                        $product_tmp['address_list'] = $addresses;

                        $product_tmp['id_warehouse'] = (int)$id_warehouse;
                        /* Get all authorized carriers for each product
                        $product_tmp['carriers_list'] = WarehouseStock::getAvailableCarrierList(
                            (new Product($id_product, false)),
                            $id_warehouse,
                            $id_address_delivery
                        ); */
                        array_push($cart_collection, $product_tmp);
                    }
                }

                /***** Shipping methods according to available delivery addresses in cart ****/
                /*********************************************************************************/
                $delivery_option_list = $this->context->cart->getDeliveryOptionList();
				/*echo '<pre>';
				print_r($this->context->cart->getPackageList());
				echo '</pre>';
				exit();*/
                $include_taxes = !Product::getTaxCalculationMethod((int)$this->context->cart->id_customer) && (int)Configuration::get('PS_TAX');
                $display_taxes_label = (Configuration::get('PS_TAX') && !Configuration::get('AEUC_LABEL_TAX_INC_EXC'));
                // Get the default selected carrier for each delivery address
                $selected_delivery_option = $this->context->cart->getDeliveryOption(null, false, false);

                /*
                * IF module must show ALL available carriers by delivery address (package)
                * regardless of who has the best grade, best price, best weight, etc.
                */
                /*if (Configuration::get('WKWAREHOUSE_ALLCARRIERS_BYADDRESS')) {
                    $package_list = $this->context->cart->getPackageList();
                    foreach ($delivery_option_list as $id_address_delivery => $by_address) {
                        if (isset($delivery_option_list[$id_address_delivery])) {
                            $carriers_by_address = array();
                            // Delivery option: Get all carriers id by delivery option
                            foreach ($by_address as $id_carrier => $delivery_option) {
                                $tmp_carriers = array_filter(explode(',', $id_carrier));
                                foreach ($tmp_carriers as $id_carrier) {
                                    $carriers_by_address[$id_carrier] = (int)$id_carrier;
                                }
                            }

                            // Package: Get all carriers id by delivery address
                            $carriers_by_packages = array();
                            foreach ($package_list[$id_address_delivery] as $option) {
                                foreach ($option['carrier_list'] as $id_carrier) {
                                    if (!empty($id_carrier)) {
                                        $carriers_by_packages[$id_carrier] = (int)$id_carrier;
                                    }
                                }
                            }

                            // Look for the carriers that don't exist (we use an operator + to maintain the keys)
                            // The difference result will be added to the delivery options to have all carriers (no matter if best price, grade, etc.)
                            $package_carrier_list_diff = array_diff($carriers_by_address, $carriers_by_packages) + array_diff($carriers_by_packages, $carriers_by_address);
                            if (count($package_carrier_list_diff)) {
                                // Get products related to this carrier
                                $product_list = null;
                                foreach ($package_list[$id_address_delivery] as $option) {
                                    if (array_intersect($package_carrier_list_diff, array_map('intval', $option['carrier_list']))) {
                                        $product_list = $option['product_list'];
                                        break;
                                    }
                                }

                                $address = new Address($id_address_delivery);
                                $country = new Country($address->id_country);

                                foreach ($package_carrier_list_diff as $idCarrier) {
                                    $shipping_cost_wtax = $this->context->cart->getPackageShippingCost((int)$idCarrier, false, $country, $product_list);
                                    $delivery_option_list[$id_address_delivery][$idCarrier.','] = array(
                                        'carrier_list' => array($idCarrier => array('instance' => new Carrier($idCarrier))),
                                        'total_price_with_tax' => $this->context->cart->getPackageShippingCost((int)$idCarrier, true, $country, $product_list),
                                        'total_price_without_tax' => $shipping_cost_wtax,
                                        'unique_carrier' => 1,
                                        'is_best_grade' => 1,
                                        'is_best_price' => 1,
                                        'is_free' => !$shipping_cost_wtax ? true : false,
                                    );
                                }
                            }
                        }
                    }
                }*/
                /*******************************************************************************/

                $delivery_options_available = $methods_shipping_collection = array();

                // Generate new delivery options list (just for display)
                // For each package, get the best carrier (best price, range, weight, etc.)
                foreach ($delivery_option_list as $id_address_delivery => $by_address) {
                    if (isset($delivery_option_list[$id_address_delivery])) {
                        $carriers_available = array();

                        $package_multi_carriers = false;
                        foreach ($by_address as $id_carriers_list => $carriers_list) {
                            // IF some products must be delivered to the same address
                            // but not delivered by the same carrier (each product has its own carrier => no intersection)
                            if (count(array_filter(explode(',', $id_carriers_list))) > 1) {
                                $package_multi_carriers = true;
                            }
                            foreach ($carriers_list as $carriers) {
                                // iF we're processing carrier_list index from array
                                if (is_array($carriers)) {
                                    /* default carrier in delivery_option */
                                    $selected_carrier = 0;
                                    if (isset($selected_delivery_option[(int)$id_address_delivery])) {
                                        $selected_carrier = $selected_delivery_option[(int)$id_address_delivery];
                                    }
                                    /* collect carriers names, delays, logos before */
                                    if ($package_multi_carriers) {
                                        $carriers_table = array();
                                        foreach ($carriers as $carrier) {
                                            $carrier = array_merge($carrier, $object_presenter->present($carrier['instance']));

                                            // Warehouse collection to be displayed below carrier name
                                            $warehouse_name = array();
                                            $before_name = '';
                                            $product_list = $carrier['product_list'];
                                            if (count($product_list) == 1) {
                                                $prod = current($carrier['product_list']);
                                                $warehouse_name[] = (new StoreHouse(current($prod['warehouse_list']), $id_lang))->name;
                                            } else {
                                                /* despite of knowing that it can not be more than one warehouse, but do collect for security */
                                                foreach ($product_list as $prod) {
                                                    $id_warehouse_carrier = current($prod['warehouse_list']);
                                                    if (!empty($id_warehouse_carrier)) {
                                                        $warehouse_name[] = (new StoreHouse($id_warehouse_carrier, $id_lang))->name;
                                                    }
                                                }
                                                if (!empty($warehouse_name) && count($warehouse_name) != count($product_list)) {
                                                    $before_name = $this->l('Some products are delivered from').' ';
                                                }
                                            }
                                            $extraContent = '';
                                            if ($carrier['is_module']) {
                                                if ($moduleId = Module::getModuleIdByName($carrier['external_module_name'])) {
                                                    $extraContent = Hook::exec('displayCarrierExtraContent', array('carrier' => $carrier), $moduleId);
                                                }
                                            }
                                            $carriers_table[] = array(
                                                'name' => $carrier['name'].' ('.(new PriceFormatter())->format($carrier['price_with_tax']).')',
                                                'delay' => $carrier['delay'][$id_lang],
                                                'logo' => $carrier['logo'],
                                                'warehouse_name' => !empty($warehouse_name) ? $before_name.implode(', ', $warehouse_name) : '',
                                                'extraContent' => $extraContent,
                                            );
                                        }
                                    }
                                    /* loop carriers */
                                    foreach ($carriers as $carrier) {
                                        $carrier = array_merge($carrier, $object_presenter->present($carrier['instance']));
                                        $delay = $carrier['delay'][$id_lang];
                                        unset($carrier['instance'], $carrier['delay']);
                                        // delay
                                        $carrier['delay'] = $delay;
                                        // price
                                        if ($this->isFreeShipping($this->context->cart, $carriers_list)) {
                                            $carrier['price'] = $this->trans('Free', array(), 'Shop.Theme.Checkout');
                                        } else {
                                            if ($include_taxes) {
                                                $carrier['price'] = (new PriceFormatter())->format($carriers_list['total_price_with_tax']);
                                                if ($display_taxes_label) {
                                                    $carrier['price'] = $this->trans(
                                                        '%price% tax incl.',
                                                        array('%price%' => $carrier['price']),
                                                        'Shop.Theme.Checkout'
                                                    );
                                                }
                                            } else {
                                                $carrier['price'] = (new PriceFormatter())->format($carriers_list['total_price_without_tax']);
                                                if ($display_taxes_label) {
                                                    $carrier['price'] = $this->trans(
                                                        '%price% tax excl.',
                                                        array('%price%' => $carrier['price']),
                                                        'Shop.Theme.Checkout'
                                                    );
                                                }
                                            }
                                        }
                                        // label
                                        if (count($carriers) > 1) {
                                            $carrier['label'] = $carrier['price'];
                                        } else {
                                            $carrier['label'] = $carrier['name'].' - '.$carrier['delay'].' - '.$carrier['price'];
                                        }
                                        // If carrier related to a module, check for additionnal data to display
                                        $carrier['extraContent'] = '';
                                        if (!$package_multi_carriers) {
                                            if ($carrier['is_module']) {
                                                if ($moduleId = Module::getModuleIdByName($carrier['external_module_name'])) {
                                                    $carrier['extraContent'] = Hook::exec('displayCarrierExtraContent', array('carrier' => $carrier), $moduleId);
                                                }
                                            }
                                        }

                                        // Which one has to be selected by default
                                        $carrier['selected'] = 0;
                                        if ($selected_carrier == $id_carriers_list) {
                                            $carrier['selected'] = 1;
                                            array_push($methods_shipping_collection, $carrier);
                                        }
                                        if ($package_multi_carriers) {
                                            if (isset($carriers_table) && count($carriers_table)) {
                                                $carrier['carriers_table'] = $carriers_table;
                                            }
                                        }
                                        // IF products being delivered to the same address but from different carriers
                                        $carriers_available[$id_carriers_list] = $carrier;
                                    }
                                }
                            }
                        }
                        $delivery_options_available[$id_address_delivery] = $carriers_available;
                    }
                }

                // IF "Enable final summary" is enabled from "Order Settings" preferences page
                if (Configuration::get('PS_FINAL_SUMMARY_ENABLED') && count($selected_delivery_option) >= 1 &&
                    count($methods_shipping_collection)) {
                    Media::addJsDef(array(
                        'methods_shipping_collection' => $methods_shipping_collection,
                    ));
                }

                $link = new \Link();
                // For delivery addresses checkout tab
                Media::addJsDefL('txt_delivery_addresses', $this->l('Delivery addresses'));
                Media::addJsDefL('txt_choose_addresses', $this->l('Ship to multiple addresses'));
                Media::addJsDefL('txt_warehouse', $this->l('Warehouse'));
                Media::addJsDefL('txt_incomplete_addresses', $this->l('Delivery addresses selections are required! May be you need to create new delivery address.'));
                Media::addJsDefL('txt_incomplete_carriers', $this->l('Carriers selections are required!'));
                // For shipping method checkout tab
                Media::addJsDefL('txt_choose_shipping_adress', $this->l('Choose the shipping option for this address:'));
                Media::addJsDefL('txt_choose_shipping', $this->l('Choose the shipping option'));
                Media::addJsDefL('txt_countries_zone', $this->l('Delivery Countries'));
                Media::addJsDefL('txt_country_zone', $this->l('Delivery Country'));
                Media::addJsDefL('txt_delivery_where', $this->l('This product can be delivered to:'));
                // Common
                Media::addJsDefL('txt_ok', $this->l('Ok'));
                Media::addJsDef(array(
                    // For delivery addresses checkout tab
                    'cart_collection' => $cart_collection,
                    'delivery_cart_id' => $this->context->cart->id_address_delivery,
                    'cart_wkwarehouses_url' => $link->getModuleLink($this->name, 'processactions'),
                    // For shipping method checkout tab
                    'delivery_option_list' => $delivery_options_available,
                    'delivery_option' => current($selected_delivery_option),
                    'address_collection' => $this->context->cart->getAddressCollection(),
                ));
            }
        }
        // Check always if multi-shipping, if that's so set id_delivery_address to 0
        WarehouseStock::isMultiShipping($this->context->cart);
    }

    private function isFreeShipping($cart, array $carrier)
    {
        $free_shipping = false;

        if ($carrier['is_free']) {
            $free_shipping = true;
        } else {
            foreach ($cart->getCartRules() as $rule) {
                if ($rule['free_shipping'] && !$rule['carrier_restriction']) {
                    $free_shipping = true;
                    break;
                }
            }
        }
        return $free_shipping;
    }

    public function getCountryName($id_address_delivery)
    {
        return (new Country((new Address($id_address_delivery))->id_country, $this->context->language->id))->name;
    }

    public function checkDeliveriesCustomerAddressOnCartListing()
    {
        $carriers_restrictions = array();
        $cart = $this->context->cart;
        if (Validate::isLoadedObject($cart) && $cart->nbProducts()) {
            foreach ($cart->getProducts() as $row) {/* checkup for all products in cart */
                $id_product = (int)$row['id_product'];
                $id_product_attribute = (int)$row['id_product_attribute'];

                $product = new Product($id_product, false);
                if (Validate::isLoadedObject($product)) {
                    $result = WarehouseStock::productIsPresentInCart($cart->id, $id_product, $id_product_attribute);

                    $carriers_list = WarehouseStock::getAvailableCarrierList(
                        $product,
                        ($result && $result['id_warehouse'] > 0 ? (int)$result['id_warehouse'] : null),
                        $cart->id_address_delivery
                    );
                    if (empty($carriers_list)) {
                        $carriers_restrictions[$id_product.'_'.$id_product_attribute] = 1;
                    }
                }
            }
        }
        return $carriers_restrictions;
    }

    public function initWarehousesInformationsOnCartListing()
    {
        if (!Configuration::get('WKWAREHOUSE_WAREHOUSES_INCART') && !Configuration::get('WKWAREHOUSE_LOCATIONS_INCART')) {
            return;
        }
        $id_lang = (int)$this->context->language->id;
        $asmProductsInCart = false;
        $warehouses_infos = array();

        $cart = $this->context->cart;
        if ($cart && $cart->nbProducts()) {
            $cartProducts = $cart->getProducts();
            if (is_array($cartProducts)) {
                foreach ($cartProducts as $row) {
                    $id_product = (int)$row['id_product'];
                    $id_product_attribute = (int)$row['id_product_attribute'];

                    $product = new Product($id_product, false);
                    if (Validate::isLoadedObject($product) && $product->advanced_stock_management) {
                        /* IF At least, one product uses A.S.M, continue */
                        $asmProductsInCart = true;
                        $result = WarehouseStock::productIsPresentInCart($cart->id, $id_product, $id_product_attribute);
                        if ($result && $result['id_warehouse'] > 0) {
                            $id_warehouse = (int)$result['id_warehouse'];

                            $warehouse = new StoreHouse($id_warehouse, $id_lang);
                            if (Validate::isLoadedObject($warehouse)) {
                                $country_address = Address::getCountryAndState($warehouse->id_address);

                                $warehouses_infos[$id_product.'_'.$id_product_attribute] = array(
                                    'name' => $warehouse->name,
                                    'delivery_time' => $warehouse->delivery_time,
                                    'location' => $warehouse->getProductLocation($id_product, $id_product_attribute, $id_warehouse),
                                    'quantity' => WarehouseStock::getAvailableQuantityByWarehouse(
                                        $id_product,
                                        $id_product_attribute,
                                        $id_warehouse
                                    ),
                                    'country' => (new Country($country_address['id_country'], $id_lang))->name,
                                );
                            }
                        }
                    }
                }
            }
        }
        return array(
            'asmProductsInCart' => $asmProductsInCart,
            'warehousesInfos' => $warehouses_infos,
        );
    }

    public function setCommonSmartyVarsProductPage()
    {
        $this->context->smarty->assign(array(
            'warehouses_txt' => $this->setTitleExtraProductContent(),
            'link' => new Link(),
        ));
    }

    /**
     * Display warehouses informations on product page tab
     */
    public function hookDisplayProductExtraContent($params)
    {
        if ($this->active && Configuration::get('WKWAREHOUSE_WAREHOUSEINFOS_POSITION') == 'extraContent' &&
            Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $extraContent = (new PrestaShop\PrestaShop\Core\Product\ProductExtraContent());
            if (!isset($params['product'])) {
                return $extraContent;
            }
            $product = new Product((int)$params['product']->id, false);

            if (Validate::isLoadedObject($product) && $product->advanced_stock_management) {
                $warehouses_infos = WarehouseStock::warehousesDataOnProductPage($product->id);
				WarehouseStock::takeOffDisabledWarehouses($warehouses_infos);

                if (count($warehouses_infos)) {
                    $this->setCommonSmartyVarsProductPage();
                    $this->context->smarty->assign('product_stocks_list', $warehouses_infos);

                    $extraContent->setTitle(
                        $this->setTitleExtraProductContent(false)
                    )->setContent(
                        $this->display($this->_path, 'views/templates/hook/product_header.tpl')
                    )->addAttr(
                        array('class' => 'warehousesExtraTabContent')
                    );
                    return array($extraContent);
                }
            }
        }
    }

    public function setTitleExtraProductContent($with_detailed = true)
    {
        $regarding = array();
        if (Configuration::get('WKWAREHOUSE_DISPLAY_STOCK_INFOS')) {
            $regarding[] = $this->l('Stock');
        }
        if (Configuration::get('WKWAREHOUSE_DISPLAY_LOCATION')) {
            $regarding[] = $this->l('Locations');
        }
        if (Configuration::get('WKWAREHOUSE_DISPLAY_DELIVERIES_TIME')) {
            $regarding[] = $this->l('Delivery times');
        }
        if (Configuration::get('WKWAREHOUSE_DISPLAY_COUNTRIES')) {
            $regarding[] = $this->l('Countries');
        }
        return $this->l('Warehouses').($with_detailed ? ' ('.implode(', ', $regarding).')' : '');
    }

    /**
     * Hook action called when product is saved
     */
    public function hookActionProductUpdate($params)
    {
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $id_product = $this->getProductSID($params);
            if (Tools::getIsset('form')) {
                $product_form = Tools::getValue('form');

                if ((int)$product_form['step1']['type_product'] != 1) {/* Not pack */
                    $use_asm = (Tools::getIsset('field_asm') ? Tools::getValue('field_asm') : 0);
                    // Set advanced stock management for new product
                    WorkshopAsm::setAdvancedStockManagement($id_product, $use_asm);
                }
            }
        }
        return true;
    }

    public function hookActionObjectDeleteAfter($params)
    {
        if (!$this->active || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return;
        }
        if (isset($params['object']) && is_object($params['object'])) {
            // After deleting an address
            if (Configuration::get('WKWAREHOUSE_ALLOW_MULTICARRIER_CART') &&
                Validate::isLoadedObject($this->context->cart)) {
                if ($params['object'] instanceof Address) {
                    Db::getInstance()->execute(
                        'UPDATE `'._DB_PREFIX_.'cart_product`
                         SET `id_address_delivery` = 0
                         WHERE `id_cart` = '.(int)$this->context->cart->id.' AND 
                         `id_address_delivery` = '.(int)$params['object']->id
                    );
                }
            }
            // Edit Order: deleting product
            if ($params['object'] instanceof OrderDetail) {
                $request = $this->getAdminControllerNameAndAction();
                if ($request['admin_controller'] == 'AdminOrders' && $request['admin_action'] == 'deleteProductAction') {
                    $order_detail = $params['object'];
                    if ($order_detail->id_warehouse) {
                        if ((new Product($order_detail->product_id, false))->advanced_stock_management) {
                            Configuration::updateValue(
                                'WKWAREHOUSE_ORDERDETAIL_DELETED',
                                serialize(array(
                                    $order_detail->id => array(
                                        'product_id' => $order_detail->product_id,
                                        'product_attribute_id' => $order_detail->product_attribute_id,
                                        'id_warehouse' => $order_detail->id_warehouse,
                                    )
                                ))
                            );
                        }
                    }
                }
            }
        }
        return true;
    }

    /*
    * Hook executed after an object is updated
    */
    public function hookActionObjectUpdateAfter(array $params)
    {
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') &&
            isset($params['object']) && is_object($params['object'])) {
            /*
            * When product in order has been canceled or refunded, synchronize PS and Warehouses Qties
            * * * OrderDetail object has been updated
            * * * Specifically, when product_quantity_refunded field has been updated
            * PS 1.7.7.x makes synchronization automatically when it's about cancelling product action
            */
            if (defined('_PS_ADMIN_DIR_') && $params['object'] instanceof OrderDetail) {
                $request = $this->getAdminControllerNameAndAction();

                if ($request['admin_controller'] == 'AdminOrders') {
                    if (Tools::isSubmit('cancelProduct') || // PS < 1.7.7.x
                        Tools::isSubmit('partialRefund') || // PS < 1.7.7.x
                        ($request['admin_action'] == 'standardRefundAction') || // PS >= 1.7.7.x
                        ($request['admin_action'] == 'partialRefundAction' && $request['cancel_product']['restock'])) {// PS >= 1.7.7.x
                        $order_detail = new OrderDetail((int)$params['object']->id);
                        $order = new Order($order_detail->id_order);

                        if (Validate::isLoadedObject($order) &&
                            Validate::isLoadedObject($order_detail) && $order_detail->id_warehouse) {
                            $product = new Product($order_detail->product_id, false);
                            if ($product->advanced_stock_management) {/* Product is A.S.M ? */
                                WorkshopAsm::updatePhysicalProductAvailableQuantity(
                                    $order_detail->product_id,
                                    $order->id_shop
                                );
                                (new WorkshopAsm())->synchronize(
                                    (int)$order_detail->product_id,
                                    (int)$order_detail->product_attribute_id,
                                    null,
                                    array(),
                                    false,
                                    $order_detail->id_warehouse
                                );
                            }
                        }
                    }
                }
            }
            if ($params['object'] instanceof Address) {
                if (Tools::getIsset('delete') && Tools::getValue('delete')) {/* if delete action from frontoffice form */
                    $this->hookActionObjectDeleteAfter($params);
                }
            }
        }
        return true;
    }

    /**
     * Hook that is fired after an object has been created in the db.
     * Useful when adding new product, new combination, etc.
     */
    public function hookActionObjectAddAfter(array $params)
    {
        // Can we use this hook?
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') &&
            isset($params['object']) && is_object($params['object'])) {
            // After adding new product
            if ($params['object'] instanceof Product) {
                $id_product = (int)$params['object']->id;

                if (!empty($id_product)) {
                    /* IF we're coming from product form, otherwise use default setting */
                    $use_asm = (Tools::getIsset('field_asm') ? Tools::getValue('field_asm') : Configuration::get('WKWAREHOUSE_USE_ASM_NEW_PRODUCT'));
                    /* Set advanced stock management for new product */
                    WorkshopAsm::setAdvancedStockManagement($id_product, $use_asm);
                    /* Set default Warehouse, synchronize quantities */
                    if (Configuration::get('PS_DEFAULT_WAREHOUSE_NEW_PRODUCT') != 0) {
                        WorkshopAsm::processWarehouses($id_product, null);
                    }
                }
            }
            // After adding new combination
            if ($params['object'] instanceof Combination) {
                $default_warehouse = Configuration::get('PS_DEFAULT_WAREHOUSE_NEW_PRODUCT');
                if (!empty($default_warehouse)) {
                    $id_combination = (int)$params['object']->id;
                    if (!empty($id_combination)) {
                        $combination = new Combination($id_combination);

                        $wpl_id = (int)StorehouseProductLocation::getIdByProductAndWarehouse(
                            (int)$combination->id_product,
                            (int)$id_combination,
                            (int)$default_warehouse
                        );
                        if (empty($wpl_id)) {
                            // Create new warehouse association
                            $warehouse_location_entity = new StorehouseProductLocation();
                            $warehouse_location_entity->id_product = (int)$combination->id_product;
                            $warehouse_location_entity->id_product_attribute = (int)$id_combination;
                            $warehouse_location_entity->id_warehouse = (int)$default_warehouse;
                            $warehouse_location_entity->location = '';
                            if ($warehouse_location_entity->save()) {
                                // Because product has combinations, so remove the useless warehouse association with product attribute 0
                                $awc = StorehouseProductLocation::getCollection($combination->id_product, 0);
                                foreach ($awc as $wc) {
                                    $wc->delete();
                                }
                            }
                        }
                    }
                }
            }
            /*
            * IF creating order from BO & product is associated to warehouse(s) but without any stock
            * PS >= 1.7.7.x: if we're adding A.S.M product from Edit order page, save warehouse ID
            */
            if ($params['object'] instanceof OrderDetail) {
                if (defined('_PS_ADMIN_DIR_')) {
                    $order_detail = new OrderDetail((int)$params['object']->id);
                    $product = new Product((int)$order_detail->product_id, false);
                    if (Validate::isLoadedObject($order_detail) && Validate::isLoadedObject($product) &&
                        $product->advanced_stock_management) {
                        // If we are adding product from Edit order page (PS >= 1.7.7.x)
                        if (!$order_detail->id_warehouse) {
                            $request = $this->getAdminControllerNameAndAction();
                            if (!empty($request) && $request['admin_controller'] == 'AdminOrders' &&
                                $request['admin_action'] == 'addProductAction') {
                                /* Get the warehouse ID of this product auto. saved when adding product to cart */
                                $result = WarehouseStock::productIsPresentInCart(
                                    (new Order($order_detail->id_order))->id_cart,
                                    $order_detail->product_id,
                                    $order_detail->product_attribute_id
                                );
                                if ($result && isset($result['id_warehouse']) && $result['id_warehouse'] > 0) {
                                    $order_detail->id_warehouse = (int)$result['id_warehouse'];
                                    $order_detail->save();
                                }
                            }
                        }
                    }
                }
            }
            // After adding new address
            if ($params['object'] instanceof Address) {
                $id_address = (int)$params['object']->id;
                $cart = $this->context->cart;
                if (!empty($id_address) && Validate::isLoadedObject($cart)) {
                    WarehouseStock::assignRightDeliveryAddressToEachProductInCart($cart, $id_address);
                }
            }
        }
        return true;
    }

    /*
     * This hook is called before a product is deleted
    */
    public function hookActionAdminDeleteBefore($params)
    {
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            if (isset($params['product_id'])) {// when single product to remove
                $id_product = $params['product_id'];
            } elseif (isset($params['product_list_id'])) {// when bulk remove
                $id_product = $params['product_list_id'][0];
            }
            if (isset($id_product) && !empty($id_product)) {
                // Give ablility to delete product by disabling A.S.M for product
                WorkshopAsm::setAdvancedStockManagement($id_product, 0);
            }
        }
        return true;
    }

    /*
     * This hook is called when a product is deleted
    */
    public function hookActionProductDelete($params)
    {
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $id_product = $this->getProductSID($params);
            if (!empty($id_product)) {
                foreach (StorehouseProductLocation::getCollection($id_product) as $awc) {
                    $awc->delete();
                }
            }
        }
        return true;
    }

    /*
     * This hook is called after a combination is deleted
    */
    public function hookActionAttributeCombinationDelete($params)
    {
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $id_product_attribute = (int)$params['id_product_attribute'];
            if (!empty($id_product_attribute)) {
                foreach (StorehouseProductLocation::getCollection(null, $id_product_attribute) as $awc) {
                    $awc->delete();
                }
            }
        }
        return true;
    }

    // This hook is called after a product is removed from a cart
    public function hookActionObjectProductInCartDeleteAfter($params)
    {
        if (!$this->active || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return;
        }
        $id_cart = (int)$params['id_cart'];
        $id_product = (int)$params['id_product'];
        if ($id_cart && $id_product) {
            $id_product_attribute = (int)$params['id_product_attribute'];
            // Remove trace from warehouse cart table
            WarehouseStock::removeProductFromWarehouseCart($id_cart, $id_product, $id_product_attribute);

            // Fix the right delivery address in cart if it remains only one product in cart
			$cartProducts = $this->context->cart->getProducts();
            if ($this->context->cookie->id_customer &&
				is_array($cartProducts) && count($cartProducts) == 1) {/* logged in ? */
                $last_product = WarehouseStock::getLastCartProduct($id_cart, $id_product, $id_product_attribute);
                if ($last_product) {
                    WarehouseStock::updateCartDeliveryAddress(
                        $id_cart,
                        $last_product['id_address_delivery'],
                        false
                    );
                }
            }
			// Check if cart is existant and does not contains any products, delete the cart
			if (!$this->context->cart->hasProducts()) {
				$this->context->cart->delete();
			}
        }
    }

    /*
    * Use it only when we're adding product to CART
    */
    public function hookActionCartSave($params)
    {
        if (!$this->active) {
            return false;
        }
        $cart = $this->context->cart;

        if (defined('_PS_ADMIN_DIR_')) {
            $id_product_attribute = $id_product = 0;
            if (Tools::getIsset('add_product')) {
                $add_product = Tools::getValue('add_product');
                $id_product = $add_product['product_id'];
                $id_product_attribute = $add_product['product_attribute_id'];
            }
            if (Tools::getIsset('product_id')) {
                $id_product = Tools::getValue('product_id');
            }
            if (Tools::getIsset('combination_id')) {
                $id_product_attribute = Tools::getValue('combination_id');
            }
            if (Tools::getIsset('productId')) {
                $id_product = Tools::getValue('productId');
            }
            if (Tools::getIsset('attributeId')) {
                $id_product_attribute = Tools::getValue('attributeId');
            }
        } else {
            $id_product = Tools::getValue('id_product');
        }
        $product = new Product((int)$id_product, false);

        $actionCartSave = false;

        // BO order page management
        if (defined('_PS_ADMIN_DIR_')) {
            $request = $this->getAdminControllerNameAndAction();

            // Order From BO > Add product
            if (Validate::isLoadedObject($product) && $product->advanced_stock_management &&
                in_array($request['admin_action'], array('addProductOnOrder', 'addProductAction'))) {
                $actionCartSave = true;
            }
            /*
            * BO Order Management: Remove also product from warehouse cart
            ** - remove product from cart during creating Order
            ** - remove product from order during editing Order
            */
            if (in_array($request['admin_action'], array('deleteProduct', 'deleteProductAction'))) {
                /* When removing product from order page, the ids of product and combination are not provided */
                if (empty($id_product) && $request['admin_controller'] == 'AdminOrders' &&
                    $request['admin_action'] == 'deleteProductAction' && isset($request['orderDetailId'])) {
                    $order_detail = new OrderDetail((int)$request['orderDetailId']);
                    if (Validate::isLoadedObject($order_detail)) {
                        $id_product = (int)$order_detail->product_id;
                        $id_product_attribute = (int)$order_detail->product_attribute_id;
                    }
                }
                $this->hookActionObjectProductInCartDeleteAfter(array(
                    'id_cart' => Validate::isLoadedObject($cart) ? $cart->id : $request['cartId'],
                    'id_product' => $id_product,
                    'id_product_attribute' => $id_product_attribute,
                ));
                return;
            }
        }

        if (Tools::getIsset('add')) {// Shopping cart (From FO)
            $actionCartSave = true;
        }

        if ($actionCartSave && Validate::isLoadedObject($cart) && Validate::isLoadedObject($product)) {
            if (!isset($id_product_attribute)) {
                $group = Tools::getIsset('group') ? Tools::getValue('group') : '';
                $id_product_attribute = (!empty($group) ? (int)Product::getIdProductAttributesByIdAttributes($product->id, $group) : 0);
                if (Tools::getIsset('id_product_attribute')) {
                    $id_product_attribute = (int)Tools::getValue('id_product_attribute');
                }
            }
            // IF A.S.M
            if ($product->advanced_stock_management) {
                /* Select the best warehouse (according to stock and carrier) */
                $selected_warehouse = WarehouseStock::getAvailableWarehouseAndCartQuantity(
                    $product->id,
                    $id_product_attribute,
                    $cart
                );
                if ($selected_warehouse && $selected_warehouse['id_warehouse'] > 0) {
                    /* Add / Update module cart table */
                    WarehouseStock::updateProductWarehouseCart(
                        $cart->id,
                        $product->id,
                        $id_product_attribute,
                        $selected_warehouse['id_warehouse']
                    );
                    /* Set the right delivery address for the added product in cart */
                    $new_id_address_delivery = (int)$selected_warehouse['id_address_delivery'];
                }
            } else {
                // IF Not A.S.M Product but we allow multi-carriers
                // Look for at least one common carrier, if not found, let our module handle
                if (Configuration::get('WKWAREHOUSE_ALLOW_MULTICARRIER_CART')) {
                    $product_carriers = WarehouseStock::getCarriersByCustomerAddresses($product);
                    $product_carriers = $product_carriers['available_carriers'];
                    if (count($product_carriers)) {
                        $cart_delivery_option = $cart->getDeliveryOption();
                        if (count($cart_delivery_option)) {
                            $carriers_in_cart = array();
                            foreach ($cart_delivery_option as $delivery_option) {
                                $carriers_in_cart = array_merge($carriers_in_cart, array_filter(explode(',', $delivery_option)));
                            }
                            $carriers_in_cart = array_unique($carriers_in_cart);
                            $product_carriers = array_values($product_carriers);
                            /* IF there is not at least one common carrier */
                            if (!array_intersect($product_carriers, $carriers_in_cart)) {
                                $product_carriers = WarehouseStock::getCarriersByCustomerAddresses($product, null);
                                if (count($product_carriers['available_carriers'])) {
                                    $new_id_address_delivery = (int)$product_carriers['id_address_delivery'];
                                }
                            }
                        }
                    }
                }
            }

            // Change to the right delivery address
            if (isset($new_id_address_delivery) &&
                ((isset($this->context->cookie->id_customer) && $this->context->cookie->id_customer) || !empty($cart->id_customer))) {
                $last_product = WarehouseStock::getLastCartProduct($cart->id, $product->id, $id_product_attribute);
                if ($last_product) {
                    $old_id_address_delivery = (int)$last_product['id_address_delivery'];
                    if ($new_id_address_delivery > 0) {
                        $cart->setProductAddressDelivery(
                            $product->id,
                            $id_product_attribute,
                            $old_id_address_delivery,
                            $new_id_address_delivery
                        );
                    } else {
                        WarehouseStock::updateCartProduct($cart->id, $new_id_address_delivery, $product->id, $id_product_attribute);
                    }
					$cartProducts = $cart->getProducts();
                    if (is_array($cartProducts) && count($cartProducts) == 1) {
                        WarehouseStock::updateCartDeliveryAddress($cart->id, $new_id_address_delivery, true);
                    }
                }
            }
        }
        // Validate cart integrity
        if (!Tools::getIsset('action')) {
            WarehouseStock::checkCartIntegrity($cart);
        }
    }

    public function hookActionSetInvoice($params)
    {
        if (!$this->active || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') || !($order = $params['Order'])) {
            return false;
        }
        if ($params['use_existing_payment'] && (Order::isOrderMultiWarehouses($order) || Order::isOrderMultiCarriers($order))) {
            $order_invoice = $params['OrderInvoice'];

            $id_order_payments = Db::getInstance()->executeS(
                'SELECT DISTINCT op.id_order_payment
                 FROM `'._DB_PREFIX_.'order_payment` op
                 INNER JOIN `'._DB_PREFIX_.'orders` o ON (o.reference = op.order_reference)
                 LEFT JOIN `'._DB_PREFIX_.'order_invoice_payment` oip ON (oip.id_order_payment = op.id_order_payment)
                 WHERE (oip.id_order != '.(int)$order_invoice->id_order.' OR oip.id_order IS NULL) AND 
                 o.id_order = '.(int)$order_invoice->id_order
            );
            if (count($id_order_payments)) {
                foreach ($id_order_payments as $order_payment) {
                    Db::getInstance()->execute(
                        'DELETE FROM `'._DB_PREFIX_.'order_invoice_payment`
                         WHERE
                            `id_order_invoice` = '.(int)$order_invoice->id.' AND
                            `id_order_payment` = '.(int)$order_payment['id_order_payment'].' AND
                            `id_order` = '.(int)$order_invoice->id_order
                    );
                }
                Cache::clean('order_invoice_paid_*'); // Clear cache
            }
        }
    }

    /*
    * Check up assigned warehouse for each product of placed order
    * Save mvt after validating order (Prestashop don't)
    */
    public function hookActionValidateOrder($params)
    {
        if (!$this->active || !($order = $params['order'])) {
            return false;
        }
        // IF A.S.M enabled
        if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $productList = $order->getProducts();
            $id_order_carrier = $order->id_carrier; // Have Order Carrier
            $id_cart = $order->id_cart; // Init cart

            foreach ($productList as $product) {
                $product_id = (int)$product['product_id'];
                $productObj = new Product($product_id, false);

                if (Validate::isLoadedObject($productObj) && $productObj->advanced_stock_management) {
                    $id_order_detail = (int)$product['id_order_detail'];
                    $product_attribute_id = (int)$product['product_attribute_id'];
                    $product_warehouse_id = (int)$product['id_warehouse'];

                    /* Get the warehouse ID of this product in module cart table */
                    $result = WarehouseStock::productIsPresentInCart($id_cart, $productObj->id, $product_attribute_id);
                    if ($result && isset($result['id_warehouse']) && $result['id_warehouse'] > 0) {
                        $id_warehouse_priority = (int)$result['id_warehouse'];
                    } else {
                        /* Look for the warehouse according to the priorities parameters */
                        $id_warehouse_priority = WorkshopAsm::findWarehousePriority(
							array(),
							true,
							$product_id,
							$product_attribute_id,
							'desc'
						);
                    }
                    /* IF Warehouse Priority */
                    if ($id_warehouse_priority) {
                        $update = false;
                        if ($result) {
                            $update = true;
                        } else {
                            if (empty($id_order_carrier) && empty($product_warehouse_id)) {
                                $update = true;
                            } else {
                                // Carriers of prior warehouse
                                $warehouse_carrier_list = (new StoreHouse($id_warehouse_priority))->getCarriers(true);
                                $id_reference_order_carrier = (new Carrier($order->id_carrier))->id_reference;

                                // If warehouse not assigned by order
                                // Don't assign warehouse to product since the order carrier don't
                                // match any of the prior warehouse carriers
                                if (empty($product_warehouse_id)) {
                                    if (in_array($id_reference_order_carrier, $warehouse_carrier_list)) {
                                        $update = true;
                                    }
                                } else {
                                    if ($product_warehouse_id != $id_warehouse_priority) {
                                        if (in_array($id_reference_order_carrier, $warehouse_carrier_list)) {
                                            $update = true;
                                        }
                                    }
                                }
                            }
                        }
                        // Update order detail with the new warehouse id
                        if ($update && $id_order_detail && $id_warehouse_priority) {
                            $order_detail = new OrderDetail($id_order_detail);
                            $order_detail->id_warehouse = (int)$id_warehouse_priority;
                            $order_detail->update();
                        }
                    }
                    // Save stock movement
                    $this->saveMovement(
                        $productObj,
                        $product_attribute_id,
                        $product['product_quantity'] * -1, // because this is order, so decrease stock
                        array(
                            'id_order' => $order->id,
                            'id_stock_mvt_reason' => Configuration::get('PS_STOCK_CUSTOMER_ORDER_REASON')
                        )
                    );
                }
            }
        }
    }

    public function saveMovement($product, $productAttributeId, $deltaQuantity, $params = array())
    {
        if ($deltaQuantity != 0) {
            $stockAvailable = (new StockManagerAdapter())->getStockAvailableByProduct($product, $productAttributeId);

            $employee = new Employee(1); // super admin

            $mvt_params = array(
                'id_stock' => (int)$stockAvailable->id,
                'id_order' => (int)$params['id_order'],
                'id_stock_mvt_reason' => (int)$params['id_stock_mvt_reason'],
                'id_employee' => (int)$employee->id,
                'employee_firstname' => $employee->firstname,
                'employee_lastname' => $employee->lastname,
                'physical_quantity' => abs($deltaQuantity),
                'date_add' => date('Y-m-d H:i:s'),
                'sign' => -1,
                'price_te' => 0.000000,
                'last_wa' => 0.000000,
                'current_wa' => 0.000000,
            );
            // Add the cart rule to the cart
            if (!Db::getInstance()->insert('stock_mvt', $mvt_params)) {
                return false;
            }
        }
    }

    /*
    * Called after applying the new status to customer order.
    *
    * 'newOrderStatus' => (object)OrderState,
    * 'id_order' => (int)Order ID,
    */
    public function hookActionOrderStatusPostUpdate($params)
    {
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $new_os = $params['newOrderStatus'];
            $order = new Order((int)$params['id_order']);

            if (Validate::isLoadedObject($new_os) && Validate::isLoadedObject($order)) {
                $order->fixOrderPayment(); // if order has been paid from front directly
                $this->synchronizeProductsOrder($order);
            }
        }
    }

    /*
    * IF order product has been changed (quantity change or product deletion)
    */
    public function hookActionOrderEdited($params)
    {
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $order = $params['order'];
            if (Validate::isLoadedObject($order)) {
                $request = $this->getAdminControllerNameAndAction();

                if ($request['admin_controller'] == 'AdminOrders') {
                    /* if product quantity has been changed */
                    if ($request['admin_action'] == 'updateProductAction') {
                        $this->synchronizeProductsOrder($order);
                    }
                    /* if product has been deleted from order */
                    if ($request['admin_action'] == 'deleteProductAction' && Configuration::get('WKWAREHOUSE_ORDERDETAIL_DELETED')) {
                        $deleted_order_detail_id = (int)$request['orderDetailId'];
                        $deleted_product = unserialize(Configuration::get('WKWAREHOUSE_ORDERDETAIL_DELETED'));
                        if (isset($deleted_product[$deleted_order_detail_id])) {
                            $product = $deleted_product[$deleted_order_detail_id];
                            if ($product['product_id'] && $product['id_warehouse']) {
                                WorkshopAsm::updatePhysicalProductAvailableQuantity($product['product_id']);
                                (new WorkshopAsm())->synchronize(
                                    $product['product_id'],
                                    $product['product_attribute_id'],
                                    null,
                                    array(),
                                    false,
                                    $product['id_warehouse']
                                );
                                Configuration::deleteByName('WKWAREHOUSE_ORDERDETAIL_DELETED');
                            }
                        }
                    }
                }
            }
        }
    }

    // Sync stock of all products of a given order
    public function synchronizeProductsOrder($order)
    {
        WorkshopAsm::updatePhysicalProductAvailableQuantity(null, $order->id_shop, $order->id);

        foreach ($order->getProductsDetail() as $product) {
            if ((new Product($product['product_id'], false))->advanced_stock_management && !empty($product['id_warehouse'])) {
                (new WorkshopAsm())->synchronize(
                    (int)$product['product_id'],
                    (int)$product['product_attribute_id'],
                    null,
                    array(),
                    false,
                    $product['id_warehouse']
                );
            }
        }
    }
    
    public function hookActionUpdateQuantity($params)
    {
        if ($this->active && Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $id_product = $this->getProductSID($params);
            $id_product_attribute = isset($params['id_product_attribute']) ? $params['id_product_attribute'] : null;
            //$qty = $params['quantity'];

            if (!Pack::isPack($id_product)) {// don't process pack : not yet, may be later!
                $product = new Product((int)$id_product, false);

                if (Validate::isLoadedObject($product) && $product->advanced_stock_management) {
                    $stockAvailable = (new StockManagerAdapter())->getStockAvailableByProduct($product, $id_product_attribute);

                    if ($stockAvailable->id) {
                        // Get associated warehouses
                        $associated_warehouses = WorkshopAsm::getAssociatedWarehousesArray(
                            $id_product,
                            $id_product_attribute
                        );
                        // If product is stored in warehouse(s)
                        if (count($associated_warehouses) > 0) {
                            $this->synchronizeWarehousesQty(
                                $associated_warehouses,
                                $product->id,
                                ($product->hasAttributes() && !empty($id_product_attribute) ? $id_product_attribute : 0)
                            );
                        }
                    }
                }
            }
        }
    }

    protected function getAdminControllerNameAndAction()
    {
        $params = array();
        if (!Tools::getIsset('controller')) {
            $request = $this->getBackofficeRequestParameters();
            if (!is_null($request)) {
                $params['admin_controller'] = $request->get('_legacy_controller');
                $controller_param = $request->get('_controller');
                $controller_array = explode('::', $controller_param);
                $params['admin_action'] = $controller_array[1];
                if ($request->get('cartId')) {
                    $params['cartId'] = $request->get('cartId');
                }
                if ($request->get('orderDetailId')) {
                    $params['orderDetailId'] = $request->get('orderDetailId');
                }
                if ($request->get('orderId')) {
                    $params['orderId'] = $request->get('orderId');
                }
                // Merge also all sent post variables
                if (is_array($request->request->all())) {
                    $params = array_merge($params, $request->request->all());
                }
            }
        } else {
            $params['admin_controller'] = Tools::getValue('controller');
            $params['admin_action'] = Tools::getValue('action');
        }
        return $params;
    }

    protected function getBackofficeRequestParameters()
    {
        try {
            $kernel = ${'GLOBALS'}['kernel'];
            if (!is_null($kernel)) {
                if (version_compare(_PS_VERSION_, '1.7.4.0', '>=')) {
                    $request = $kernel->getContainer()->get('request_stack')->getCurrentRequest();
                } else {
                    $request = $kernel->getContainer()->get('request');
                }
                if (!is_object($request)) {
                    return null;
                }
                return $request;
            }
        } catch (Exception $e) {
            return null;
        }
        return null;
    }

    /*
     * Check reserved quantity, if not empty, add it to available qty to have the real physical stock
     * stock_available.quantity: available stock in your shop
     * stock_available.reserved_quantity: if there is customer order, this quantity is reserved
     * stock_available.physical_quantity (quantity in warehouse): stock_available.quantity + stock_available.reserved_quantity
     */
    public function synchronizeWarehousesQty($associated_warehouses, $id_product, $id_product_attribute)
    {
        $authorizeSyncQty = $authorizePhysicalUpdateQty = true;

        if (defined('_PS_ADMIN_DIR_')) {
            $request = $this->getAdminControllerNameAndAction();
        }

        // CASES WHERE SYNC NOT AUTHORIZED
        if (Tools::getIsset('controller') || (isset($request) && !empty($request))) {
            /* IF from payment page (FO) */
            if (Tools::getIsset('module')) {
                foreach (Module::getPaymentModules() as $module) {
                    if ($module['name'] == Tools::getValue('module')) {
                        $authorizeSyncQty = false;
                        break;
                    }
                }
            }
            /*
            ** IF creating new customer's order From BO
            ** OR
            ** Adding / Editing / deleting product of order from BO
            */
            if (isset($request) && $request['admin_controller'] == 'AdminOrders') {
                if (Tools::isSubmit('submitAddOrder') || // PS < 1.7.7.x : Create order from BO
                    Tools::isSubmit('cart_summary') || // Ps >= 1.7.7.x : Create order from BO
                    Tools::isSubmit('submitState') || // PS < 1.7.7.x : Change order status
                    in_array(
                        $request['admin_action'],
                        array(
                            'addProductOnOrder', // PS < 1.7.7.x : Edit order: Add new product
                            'updateProductAction', // PS >= 1.7.7.x : From Order Edit page (decrease qty)
                            'deleteProductAction', // PS >= 1.7.7.x : From Order Edit page (delete product)
                            'updateStatusAction', // PS >= 1.7.7.x : Change order status
                        )
                    )) {
                    $authorizeSyncQty = false;
                }
                // Ps >= 1.7.7.x : Adding product from edit order page
                if ($request['admin_action'] == 'addProductAction') {
                    $authorizePhysicalUpdateQty = false;
                }
            }
            /* IF order is being created from RockPos (External module) */
            if (Tools::getValue('controller') == 'sales' && Tools::getValue('module') == 'hspointofsalepro') {
                if (Tools::getIsset('action') && Tools::getValue('action') == 'order') {
                    $authorizeSyncQty = false;
                }
            }
        }

        // IF SYNC IS AUTHORIZED
        if ($authorizeSyncQty) {
            /* Sync Prestashop quantities */
            if ($authorizePhysicalUpdateQty) {
                WorkshopAsm::updatePhysicalProductAvailableQuantity($id_product);
            }

            $id_warehouse = null;
            $productIsPresentRestrict = true;
            $synchronizeIncreaseProduct = true; /* addProduct function */

            /* IF PRODUCT STORED IN ONE WAREHOUSE */
            if (count($associated_warehouses) == 1) {
                $id_warehouse = (int)$associated_warehouses[0];
                $productIsPresentRestrict = false; /* !Important, be able to create stock in database if not exists */
            } else {
            /* IF PRODUCT STORED IN MULTIPLE WAREHOUSES => USE PRIORITY */
                $is_present = WarehouseStock::productIsPresentInStock(
                    $id_product,
                    (empty($id_product_attribute) ? null : $id_product_attribute)
                );
                if (!$is_present) {
                    /* Use only warehouses priority, no need for stock priority */
                    $id_warehouse = WorkshopAsm::findWarehousePriority($associated_warehouses, false);
                    $productIsPresentRestrict = false;
                } else {
                    /* Compare the two physical quantities (Prestashop & Warehouses) */
                    $physical_quantity_in_warehouses = (int)WorkshopAsm::getProductPhysicalQuantities(
                        $id_product,
                        $id_product_attribute
                    );
                    $stock_infos = WorkshopAsm::getAvailableStockByProduct($id_product, $id_product_attribute);
                    $delta_qty = (int)($stock_infos['physical_quantity'] - $physical_quantity_in_warehouses);

                    if ($delta_qty <= 0) {
                        $synchronizeIncreaseProduct = false;
                        /* If decrease qty, can be decreased from many warehouses */
                        if ($delta_qty < 0) {
                            $delta_qty *= -1; /* need to be positive always */
                            (new WorkshopAsm())->updateAccordingDescWarehouseQtiesPriority(
                                $associated_warehouses,
                                $id_product,
                                $id_product_attribute,
                                $delta_qty
                            );
                        }
                    }
                }
            }
            if ($synchronizeIncreaseProduct) {
                (new WorkshopAsm())->synchronize(
                    $id_product,
                    $id_product_attribute,
                    null,
                    $associated_warehouses,
                    $productIsPresentRestrict,
                    $id_warehouse
                );
            }
        }
    }

    public function getProductSID($params)
    {
        if (isset($params['product']->id)) {
            return $params['product']->id;
        } elseif (isset($params['id_product'])) {
            return $params['id_product'];
        } elseif (isset($params['product'])) {
            return $params['product']['id_product'];
        } else {
            return false;
        }
    }

    public function hookDisplayPDFDeliverySlip($params)
    {
        if (!$this->active) {
            return;
        }
        if (Configuration::get('WKWAREHOUSE_ON_DELIVERY_SLIP')) {
            $order = new Order((int)$params['object']->id_order);

            if (Validate::isLoadedObject($order)) {
                $order_details = $order->getProducts(); // Order's products

                if ($order_details) {
                    foreach ($order_details as $key => $order_detail) {
                        if (!empty($order_detail['id_warehouse'])) {
                            $warehouse = new StoreHouse((int)$order_detail['id_warehouse'], $this->context->language->id);
                            if (Validate::isLoadedObject($warehouse)) {
                                $order_details[$key]['warehouse_name'] = $warehouse->name;
                                $order_details[$key]['warehouse_location'] = $warehouse->getProductLocation(
                                    $order_detail['product_id'],
                                    $order_detail['product_attribute_id'],
                                    $warehouse->id
                                );
                            } else {
                                unset($order_details[$key]);
                            }
                        } else {
                            unset($order_details[$key]);
                        }
                    }
                    if (isset($order_details) && $order_details) {
                        $this->context->smarty->assign(array(
                            'order_details' => $order_details,
                            'link' => $this->context->link,
                        ));
                        return $this->display(__file__, 'delivery_slip.tpl');
                    }
                }
            }
        }
    }

    /*
    * Display new elements in the Back Office, tab AdminOrder
    * This hook launches modules when the AdminOrder tab is displayed in the Back Office
    */
    public function hookDisplayAdminOrder($params)
    {
        if (!$this->active) {
            return;
        }
        if (Configuration::get('WKWAREHOUSE_LOCATION_ORDER_PAGE')) {
            $id_order = (int)$params['id_order'];
            $order = new Order($id_order);

            if (Validate::isLoadedObject($order)) {
                $canChangeWarehouse = (int)Configuration::get('WKWAREHOUSE_CHANGE_ORDER_WAREHOUSE');
                $orderLocations = array();
                $orderDetails = $order->getProducts(); // Order's products

                foreach ($orderDetails as $orderDetail) {
                    $id_product = (int)$orderDetail['product_id'];
                    $id_product_attribute = (int)$orderDetail['product_attribute_id'];
                    $id_warehouse = (int)$orderDetail['id_warehouse'];
                    $warehouses_locations = array();

                    $product = new Product($id_product, false);
                    if (Validate::isLoadedObject($product)) {
                        $assigned_warehouses = array();
                        $associated_warehouses = WorkshopAsm::getAssociatedWarehousesArray(
                            $id_product,
                            $id_product_attribute
                        );
                        if (empty($id_warehouse)) {
                            $id_warehouse = (int)WorkshopAsm::findWarehousePriority(
                                $associated_warehouses,
                                true,
                                $id_product,
                                $id_product_attribute
                            );
                        }

                        $assigned_warehouses[] = array('id_warehouse' => $id_warehouse);
                        foreach ($assigned_warehouses as $warehouse) {
                            $wh = new StoreHouse($warehouse['id_warehouse'], $this->context->language->id);
                            if (Validate::isLoadedObject($wh)) {
                                // Let me set a warehouse ?
                                if ($canChangeWarehouse) {
                                    $warehouseList = StoreHouse::getWarehouses($associated_warehouses, false);
                                    foreach ($warehouseList as $k => &$row) {
                                        $id_storehouse = (int)$row['id_warehouse'];
                                        // Be aware: look by reference ID, Not carrier ID
                                        $carriers = (new StoreHouse($id_storehouse))->getCarriers(true);
                                        if (in_array((int)(new Carrier($order->id_carrier))->id_reference, $carriers)) {
                                            $row['is_default'] = ($id_storehouse == $wh->id ? 1 : 0);
                                        } else {
                                            unset($warehouseList[$k]);
                                        }
                                    }
                                }
                                $warehouses_locations[] = array(
                                    'name' => trim($wh->name),
                                    'location' => trim($wh->getProductLocation($id_product, $id_product_attribute, $wh->id)),
                                    'warehouseList' => isset($warehouseList) ? $warehouseList : array(),
                                );
                            }
                        }
                    }
                    $orderLocations[$orderDetail['id_order_detail']] = $warehouses_locations;
                }
                
                if (version_compare(_PS_VERSION_, '1.7.7', '>=')) {
                    $this->context->smarty->assign(array(
                        'orderLocations' => $orderLocations,
                    ));
                    return $this->display(__FILE__, 'views/templates/hook/admin_order.tpl');
                } else {
                    Media::addJsDef(array(
                        'orderLocations' => $orderLocations,
                    ));
                }
            }
        }
    }

    public function getContent()
    {
        if (Tools::isSubmit('submitWarehouseForm')) {
            Configuration::updateValue(
                'PS_ADVANCED_STOCK_MANAGEMENT',
                (int)Tools::getValue('PS_ADVANCED_STOCK_MANAGEMENT')
            );
            Configuration::updateValue(
                'PS_DEFAULT_WAREHOUSE_NEW_PRODUCT',
                (int)Tools::getValue('PS_DEFAULT_WAREHOUSE_NEW_PRODUCT')
            );
            foreach ($this->keyInfos as $key => $type) {
                $dbKey = static::CONFIG_KEY.$key;
                $dbValue = Tools::getValue($dbKey);
                Configuration::updateValue($dbKey, ($type == 'int' ? (int)$dbValue : $dbValue));
            }

            $warehouseBox = Tools::getValue('warehouseBox');
            if (is_array($warehouseBox) && count($warehouseBox)) {
                Configuration::updateValue('WKWAREHOUSE_PRIORITY', implode(',', $warehouseBox));
            }
            $warehouseBox = Tools::getValue('warehouseDecreaseBox');
            if (is_array($warehouseBox) && count($warehouseBox)) {
                Configuration::updateValue('WKWAREHOUSE_PRIORITY_DECREASE', implode(',', $warehouseBox));
            }

            Tools::redirectAdmin(
                AdminController::$currentIndex.'&configure='.$this->name.'&token='
                .Tools::getAdminTokenLite('AdminModules').'&conf=6'
            );
            exit();
        } elseif (Tools::getIsset('dismissRating')) {// Rating process
            WorkshopAsm::cleanBuffer();
            Configuration::updateValue('WKWAREHOUSE_DISMISS_RATING', 1);
            die;
        }
        return $this->showWarningMessage().$this->prepareTabsHeader().$this->renderForm().'</div>';
    }

    public function prepareTabsHeader()
    {
        return $this->display(__FILE__, 'views/templates/admin/_configure/helpers/form/tabs.tpl');
    }

    public function renderForm()
    {
        $radioOptions = array(
            array('id' => 'active_on', 'value' => 1, 'label' => $this->l('Enabled')),
            array('id' => 'active_off', 'value' => 0, 'label' => $this->l('Disabled'))
        );
        $submitBtn = array('title' => $this->l('Save'), 'class' => 'btn btn-default pull-right');

        $warehouse_list = StoreHouse::getWarehouses();
        $warehouse_no = array(array('id_warehouse' => 0, 'name' => $this->l('No default warehouse')));
        $warehouse_list = array_merge($warehouse_no, $warehouse_list);

        // G E N E R A L   S E T T I N G S
        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('General Settings'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable advanced stock management'),
                    'class' => 't',
                    'name' => 'PS_ADVANCED_STOCK_MANAGEMENT',
                    'desc' => $this->l('Allows you to manage warehouses / locations / physical stock for your products.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Default warehouse on new products'),
                    'class' => 'fixed-width-xxl',
                    'name' => 'PS_DEFAULT_WAREHOUSE_NEW_PRODUCT',
                    'desc' => $this->l('Automatically set a default warehouse when new product is created').'.',
                    'options' => array(
                        'query' => $warehouse_list,
                        'id' => 'id_warehouse',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Use advanced stock on new products'),
                    'name' => 'WKWAREHOUSE_USE_ASM_NEW_PRODUCT',
                    'desc' => $this->l('Use by default the advanced stock management system when new product is created').'.',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable FONT AWESOME'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_ENABLE_FONTAWESOME',
                    'desc' => $this->l('Activate FONT AWESOME library which is responsible of showing icons.').
                    '<br />'.$this->l('Disable if your theme is already using this library to avoid conflicts.'),
                    'values' => $radioOptions
                ),
            ),
            'submit' => $submitBtn
        );

        // B A C K O F F I C E   S E T T I N G S
        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Backoffice Display Settings'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                array(
                    'type' => 'free',
                    'label' => $this->l('Order Details Page Settings'),
                    'name' => 'option_settings'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display warehouses, locations infos'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_LOCATION_ORDER_PAGE',
                    'desc' => $this->l('Display for each product the warehouse and location in customer order details page even if a product is not assigned to a warehouse.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Set / Change warehouse association'),
                    'class' => 't',
                    'disabled' => Configuration::get('WKWAREHOUSE_LOCATION_ORDER_PAGE') ? false : true,
                    'name' => 'WKWAREHOUSE_CHANGE_ORDER_WAREHOUSE',
                    'desc' => $this->l('Let me change the warehouse association of each product (using advanced stock management) from the list directly?')
                    .'<br />'.$this->l('The warehouses list will be loaded according to the already associated warehouses to the product and the selected order carrier.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'free',
                    'label' => $this->l('Delivery Slip Settings'),
                    'name' => 'option_settings'
                ),
                array(
                    'type' => 'switch', //Activate to insert the location of each product of an order in the warehouse as additional information in the delivery note (PDF)
                    'label' => $this->l('Insert the product location'),
                    'name' => 'WKWAREHOUSE_ON_DELIVERY_SLIP',
                    'desc' => $this->l('Enable to insert the location of each product in warehouse of customer order as additional information in Delivery Slip PDF document').'.',
                    'hint' => $this->l('Remember that you can generate delivery slip only when customer order take the "Processing in progress" status').'.',
                    'values' => $radioOptions
                ),
            ),
            'submit' => $submitBtn
        );

        // I N C R E A S E   P R I O R I T Y   S E T T I N G S
        $this->fields_form[2]['form'] = array(
            'legend' => array(
                'title' => $this->l('Define priority in case of an increase of stock (If product is stored in different warehouses)'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                array(
                    'type' => 'free',
                    'label' => $this->l('These options are used only if it\'s about a supply / replenishment / increase / etc. movements.'),
                    'name' => 'option_warnings'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Use stock priority first'),
                    'name' => 'WKWAREHOUSE_STOCKPRIORITY_INC',
                    'desc' => $this->l('If enabled, it will be the warehouse with less stock that will be selected').'.',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'priority_increase',
                    'label' => $this->l('Warehouses priority'),
                    'name' => 'priority',
                ),
            ),
            'submit' => $submitBtn
        );

        // D E C R E A S E   P R I O R I T Y   S E T T I N G S
        $this->fields_form[3]['form'] = array(
            'legend' => array(
                'title' => $this->l('The priority in case of a decrease of stock (If product is stored in different warehouses)'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                array(
                    'type' => 'free',
                    'label' => $this->l('These priority parameters are used only if it\'s about a movement decrease of stock').'.'
                    .'\n'.$this->l('If Frontoffice movements such as cart / order placement / etc., the priority parameters will be applied unless you give to your customers the ability to choose the target warehouse  from a list').'.',
                    'name' => 'option_warnings'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Use stock priority first'),
                    'name' => 'WKWAREHOUSE_STOCKPRIORITY_DEC',
                    'desc' => $this->l('If enabled, it will be the warehouse with enough stock that will be selected').'.',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'priority_decrease',
                    'label' => $this->l('Warehouses priority'),
                    'name' => 'priority',
                ),
            ),
            'submit' => $submitBtn
        );

        // P R O D U C T   P A G E   S E T T I N G S
        $this->fields_form[4]['form'] = array(
            'legend' => array(
                'title' => $this->l('Product Page Display Settings').' (Frontoffice)',
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show out of stock warehouses'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_SHOW_OUTOFSTOCK',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'free',
                    'label' => $this->l('Warehouse Infos Display Settings'),
                    'name' => 'option_settings'
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Position'),
                    'name' => 'WKWAREHOUSE_WAREHOUSEINFOS_POSITION',
                    'options' => array(
                        'query' => array(
                            array('id' => 'afterCart', 'name' => $this->l('Just after cart button')),
                            array(
                                'id' => 'extraContent',
                                'name' => $this->l('Product tabs (displayProductExtraContent hook)'),
                            ),
                            array('id' => 'none', 'name' => $this->l('None')),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display locations'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_LOCATION',
                    'desc' => $this->l('Display the location information in each warehouse.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display available quantities'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_STOCK_INFOS',
                    'desc' => $this->l('Display the stored available quantity in each warehouse.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => '',
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_STOCK_ICON',
                    'desc' => $this->l('Display icon instead of the warehouse quantity.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display deliveries times'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_DELIVERIES_TIME',
                    'desc' => $this->l('Display the delivery time of each warehouse.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display countries'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_COUNTRIES',
                    'desc' => $this->l('Display country of each warehouse.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'free',
                    'label' => $this->l('Warehouses as combination'),
                    'name' => 'option_settings'
                ),
                array(
                    'type' => 'switch',
                    'class' => 't',
                    'disabled' => Configuration::get('WKWAREHOUSE_DISPLAY_SELECTED_WAREHOUSE') ? true : false,
                    'name' => 'WKWAREHOUSE_ALLOWSET_WAREHOUSE',
                    'label' => $this->l('Allow choosing warehouse'),
                    'desc' => $this->l('Allow your visitors and customers choosing a warehouse from a dropdown list (like a combination).'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'class' => 't',
                    'disabled' => Configuration::get('WKWAREHOUSE_ALLOWSET_WAREHOUSE') ? true : false,
                    'name' => 'WKWAREHOUSE_DISPLAY_SELECTED_WAREHOUSE',
                    'label' => $this->l('Display the best warehouse'),
                    'desc' => $this->l('Display to your visitors and customers automatically the best selected warehouse.')
                    .'<br>'.$this->l('Disable the option above to enable handling this feature.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'free',
                    'label' => '',
                    'name' => 'separator'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display warehouse name'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_WAREHOUSE_NAME',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display location'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_SELECTED_LOCATION',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display available quantity'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_SELECTED_STOCK',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display delivery time'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_DELIVERYTIME',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display country'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DISPLAY_COUNTRY',
                    'values' => $radioOptions
                ),
            ),
            'submit' => $submitBtn
        );

        // C A R T   S E T T I N G S
        $this->fields_form[5]['form'] = array(
            'legend' => array(
                'title' => $this->l('Shopping Cart Page Settings'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                array(
                    'type' => 'free',
                    'label' => $this->l('Cart product informations Settings (Left block)'),
                    'name' => 'option_settings'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_ENABLE_INCART',
                    'desc' => $this->l('Display the warehouse informations of each product using the advanced stock management system in cart.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Position'),
                    'class' => 'fixed-width-xxl',
                    'name' => 'WKWAREHOUSE_POSITION_INCART',
                    'options' => array(
                        'query' => array(
                            array('id' => 'belowProductName', 'name' => $this->l('Just below the product name')),
                            array('id' => 'belowCartLine', 'name' => $this->l('Just below product cart line')),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display warehouses names'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_WAREHOUSES_INCART',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display locations'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_LOCATIONS_INCART',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display available quantities'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_QUANTITIES_INCART',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display deliveries times'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DELIVERYTIMES_INCART',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display countries'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_COUNTRIES_INCART',
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'free',
                    'label' => $this->l('Summary cart (Right block)'),
                    'name' => 'option_settings'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Display the delivery address'),
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_DELIVERY_ADDRESS_INCART',
                    'desc' => $this->l('If enabled, this option allows your customers to see the current delivery address in the right block.')
                    .'<br />- '.$this->l('Available only if you do not allow the multi-delivery addresses.'),
                    'values' => $radioOptions
                ),
            ),
            'submit' => $submitBtn
        );

        // C H E C K O U T   S E T T I N G S
        $this->fields_form[6]['form'] = array(
            'legend' => array(
                'title' => $this->l('Checkout Page Settings'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_ALLOW_MULTIWH_CART',
                    'label' => $this->l('Allow multi-warehouses'),
                    'desc' => '- '.$this->l('Allow adding products of different warehouses during checkout process.')
                    .'<br />- '.$this->l('If option disabled, you can add only products that are stored in the same warehouse.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'switch',
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_ALLOW_MULTICARRIER_CART',
                    'label' => $this->l('Allow multi-carriers'),
                    'disabled' => Configuration::get('WKWAREHOUSE_ALLOW_MULTIWH_CART') ? false : true,
                    'desc' => $this->l('If enabled, this option allow adding products of different carriers during checkout process.')
                    .'<br />'.$this->l('In other words, in the selection part of shipment, the customer can choose a carrier for each package.')
                    .'<br />'.$this->l('Finally, it could convert the customer\'s cart into one or more orders.'),
                    'values' => $radioOptions
                ),
                array(
                    'type' => 'free',
                    'label' => $this->l('Multi delivery addresses'),
                    'name' => 'option_settings'
                ),
                array(
                    'type' => 'switch',
                    'class' => 't',
                    'name' => 'WKWAREHOUSE_ALLOW_MULTI_ADDRESSES',
                    'label' => $this->l('Allow'),
                    'desc' => $this->l('If enabled, this option allows your customers to ship orders to multiple addresses.')
                    .'<br />'.$this->l('Therefore, during payment process, in the selection part of addresses, the customer can choose a delivery address for each package.'),
                    'values' => $radioOptions
                ),
            ),
            'submit' => $submitBtn
        );

        // M O D U L E S   L I N K S
        $this->fields_form[7]['form'] = array(
            'legend' => array(
                'title' => $this->l('Other Related Modules'),
                'icon' => 'icon-cogs'
            ),
            'input' => array(array('type' => 'free', 'label' => '', 'name' => 'other_modules_tab'))
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table =  $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = (
            Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ?
            Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') :
            0
        );
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitWarehouseForm';
        $helper->name_controller = 'formConfigWarehouses';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).
        '&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        // Prepare warehouses positions priorities
        array_shift($warehouse_list);
        $warehouse_list_increase = array();
        if (Configuration::get('WKWAREHOUSE_PRIORITY')) {
            $ids_warehouses = explode(',', Configuration::get('WKWAREHOUSE_PRIORITY'));
            foreach ($ids_warehouses as $id_warehouse) {
                $warehouse = new StoreHouse($id_warehouse, $this->context->language->id);
                if (Validate::isLoadedObject($warehouse) && !$warehouse->deleted) {
                    $warehouse_item = array(
                        'id_warehouse' => $warehouse->id,
                        'name' => $warehouse->reference.' - '.$warehouse->name
                    );
                    array_push($warehouse_list_increase, $warehouse_item);
                }
            }
        }
        if (empty($warehouse_list_increase)) {
            $warehouse_list_increase = $warehouse_list;
        }
        $warehouse_list_decrease = array();
        if (Configuration::get('WKWAREHOUSE_PRIORITY_DECREASE')) {
            $ids_warehouses = explode(',', Configuration::get('WKWAREHOUSE_PRIORITY_DECREASE'));
            foreach ($ids_warehouses as $id_warehouse) {
                $warehouse = new StoreHouse($id_warehouse, $this->context->language->id);
                if (Validate::isLoadedObject($warehouse) && !$warehouse->deleted) {
                    $warehouse_item = array(
                        'id_warehouse' => $warehouse->id,
                        'name' => $warehouse->reference.' - '.$warehouse->name
                    );
                    array_push($warehouse_list_decrease, $warehouse_item);
                }
            }
        }
        if (empty($warehouse_list_decrease)) {
            $warehouse_list_decrease = $warehouse_list;
        }
        /*****************************************/

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'warehouses_increase' => $warehouse_list_increase,
            'warehouses_decrease' => $warehouse_list_decrease,
        );
        return $helper->generateForm($this->fields_form);
    }

    public function getConfigFieldsValues()
    {
        $configs_array = array();
        foreach ($this->keyInfos as $key => $type) {
            unset($type);
            $dbKey = static::CONFIG_KEY.$key;
            $configs_array[$dbKey] = Tools::getValue($dbKey, Configuration::get($dbKey));
        }
        return array_merge($configs_array, array(
            'PS_ADVANCED_STOCK_MANAGEMENT' => Tools::getValue('PS_ADVANCED_STOCK_MANAGEMENT', Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')),
            'PS_DEFAULT_WAREHOUSE_NEW_PRODUCT' => Tools::getValue('PS_DEFAULT_WAREHOUSE_NEW_PRODUCT', Configuration::get('PS_DEFAULT_WAREHOUSE_NEW_PRODUCT')),
            'option_settings' => '',
            'option_warnings' => '',
            'separator' => '',
            'other_modules_tab' => $this->otherModulesTab(),
        ));
    }

    public function otherModulesTab()
    {
        $this->context->smarty->assign(array(
			'module_folder' => $this->_path,
            'iso_code' => $this->context->language->iso_code,
		));
        return $this->display(__FILE__, 'views/templates/admin/other_modules_tab.tpl');
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (!$this->active) {
            return;
        }
        // Force loading jquery before
        $this->context->controller->addjQuery();

        $ctrl = Tools::strtolower(Tools::getValue('controller'));
        $allowed_controllers = array(
            'adminwkwarehousesmanageqty',
            'adminwkwarehousesdash',
            'adminwkwarehousesorders',
        );
        $isConfigPage = ($ctrl == 'adminmodules' && Tools::getValue('configure') == $this->name ? true : false);

        // Add warehouses behaviours to product sheet to be able to edit quantities by product/combination
        if ($isConfigPage || $ctrl == 'adminproducts' || in_array($ctrl, $allowed_controllers)) {
            // Load css
            $this->context->controller->addCSS($this->_path.'views/css/wkwarehouses-admin.css', 'all');
            if ($isConfigPage || in_array($ctrl, $allowed_controllers)) {
                if ($isConfigPage) {
                    $this->context->controller->addJqueryUI('ui.tabs');
                }
                $this->context->controller->addJS($this->_path.'views/js/wkwarehouses-admin.min.js');
            }
        }
        if (in_array($ctrl, array('adminwkwarehousesstockmvt', 'adminwkwarehousesstockinstantstate'))) {
            // Load css
            $this->context->controller->addCSS($this->_path.'views/css/wkwarehouses-admin.css', 'all');
        }

        if ($ctrl == 'adminmanagewarehouses' || $ctrl == 'adminorders') {
            $this->context->controller->addJS($this->_path.'views/js/wkwarehouses-admin.min.js');
            if ($ctrl == 'adminorders') {
                Media::addJsDefL('txt_no_warehouse', $this->l('No warehouse'));
                Media::addJsDefL('txt_location', $this->l('Location'));
                Media::addJsDefL('txt_warehouse', $this->l('Warehouse'));
                Media::addJsDef(array(
                    'canChangeWarehouse' => (int)Configuration::get('WKWAREHOUSE_CHANGE_ORDER_WAREHOUSE'),
                    'admin_warehouses_orders_url' => $this->context->link->getAdminLink('AdminWkwarehousesOrders'),
                ));
            }
        }
        if ($ctrl == 'adminwkwarehousesmanageqty') {
            return $this->display(__FILE__, 'views/templates/admin/commun_header.tpl');
        }
    }

    public function hookDisplayReassurance()
    {
        // Display the current delivery address in the right block of cart page
        if (Configuration::get('WKWAREHOUSE_DELIVERY_ADDRESS_INCART') &&
            !Configuration::get('WKWAREHOUSE_ALLOW_MULTI_ADDRESSES')) {
            $cart = $this->context->cart;
            $page_name = Dispatcher::getInstance()->getController();
            if (Validate::isLoadedObject($cart) && $cart->id_address_delivery && $page_name == 'cart') {
                $delivery_address = $this->context->customer->getSimpleAddress($cart->id_address_delivery);
                $this->context->smarty->assign(
                    'delivery_address',
                    $delivery_address ? AddressFormat::generateAddress(new Address($delivery_address['id']), array(), '<br>') : ''
                );
                return $this->display(__FILE__, 'displayRightColumnCart.tpl');
            }
        }
    }

    public function showWarningMessage($display_rate = true)
    {
        if (Configuration::get('WKWAREHOUSE_DISMISS_RATING') != 1 &&
            WorkshopAsm::getNbDaysModuleUsage() >= 2 && $display_rate) {
            $this->context->smarty->assign('show_rating_block', true);
        }

        $missing_overrides = array();
        if (!Configuration::get('PS_DISABLE_OVERRIDES')) {// If override allowed
            foreach ($this->my_overrides as $override) {
                if (!file_exists($override['target'])) {
                    $missing_overrides[] = $override;
                }
            }
        }
        $this->context->smarty->assign(array(
            'missing_overrides' => $missing_overrides,
            'link' => $this->context->link,
        ));
        return $this->display(__FILE__, 'views/templates/admin/messages_info.tpl');
    }

    /**
     * Install overrides files
     *
     * @return bool
     */
    public function installMyOverrides()
    {
        foreach ($this->my_overrides as $override) {
            if (!file_exists($override['target']) && is_writable($override['targetdir'])) {
                if (!Tools::copy($override['source'], $override['target'])) {
                    //throw new Exception(Tools::displayError('Can not copy '.$override['source'].' to '.$override['target']));
                    return false;
                }
            }
        }
        $this->emptyClassIndexCache();
    }

    /**
     * Uninstall overrides files
     *
     * @return bool
     */
    public function uninstallMyOverrides()
    {
        foreach ($this->my_overrides as $override) {
            if (file_exists($override['target'])) {
                // If the same file
                if (crc32(Tools::file_get_contents($override['target'])) == crc32(Tools::file_get_contents($override['source']))) {
                    unlink($override['target']);
                }
            }
        }
        $this->emptyClassIndexCache();
    }

    public function emptyClassIndexCache()
    {
        $cache_dir = (_PS_MODE_DEV_ ? 'dev' : 'prod');

        if (file_exists(_PS_ROOT_DIR_.'/app/cache/'.$cache_dir.'/class_index.php')) {
            @unlink(_PS_ROOT_DIR_.'/app/cache/'.$cache_dir.'/class_index.php');
        }
        if (file_exists(_PS_ROOT_DIR_.'/var/cache/'.$cache_dir.'/class_index.php')) {
            @unlink(_PS_ROOT_DIR_.'/var/cache/'.$cache_dir.'/class_index.php');
        }
    }
}
