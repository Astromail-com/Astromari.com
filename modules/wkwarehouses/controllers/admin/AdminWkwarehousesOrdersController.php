<?php
/**
* NOTICE OF LICENSE
*
* This file is part of the 'WK Mass Suppliers & Warehouses Assignment For Products' module feature.
* Developped by Khoufi Wissem (2017).
* You are not allowed to use it on several site
* You are not allowed to sell or redistribute this module
* This header must not be removed
*
*  @author    KHOUFI Wissem - K.W
*  @copyright Khoufi Wissem
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

class AdminWkwarehousesOrdersController extends ModuleAdminController
{
    const FILTER_WAREHOUSE = 'id_filter_warehouse';

	public function __construct()
    {
        require_once(dirname(__FILE__).'/../../classes/Warehouse.php');
        require_once(dirname(__FILE__).'/../../classes/WarehouseProductLocation.php');
        require_once(dirname(__FILE__).'/../../classes/WorkshopAsm.php');

        $this->table = 'order';
        $this->className = 'Order';
        $this->list_id = 'order';
        $this->lang = false;
        $this->explicitSelect = true;
        $this->bootstrap = true;
        $this->deleted = false;
        $this->context = Context::getContext();
        $this->list_no_link = true;
        $this->use_asm = Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT');
        $this->warehouses = array();

        if ($this->use_asm) {
            $warehouses = StoreHouse::getWarehouses();
            if (empty($warehouses)) {
                $this->errors[] = $this->l('You must have at least one warehouse.');
            }
        }

        // Delivery countries
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS(
            'SELECT DISTINCT c.id_country, cl.`name`
             FROM `'._DB_PREFIX_.'orders` o
             '.Shop::addSqlAssociation('orders', 'o').'
             INNER JOIN `'._DB_PREFIX_.'address` a ON a.id_address = o.id_address_delivery
             INNER JOIN `'._DB_PREFIX_.'country` c ON a.id_country = c.id_country
             INNER JOIN `'._DB_PREFIX_.'country_lang` cl ON (
                c.`id_country` = cl.`id_country` AND 
                cl.`id_lang` = '.(int)$this->context->language->id.'
             )
             ORDER BY cl.name ASC'
        );
        $country_array = array();
        foreach ($result as $row) {
            $country_array[$row['id_country']] = $row['name'];
        }

        $this->fields_list = array(
            'id_order' => array(
                'title' => 'ID',
                'class' => 'text-center fixed-width-sm tbody-order',
            ),
            'reference' => array(
                'title' => $this->l('Reference'),
                'class' => 'text-center fixed-width-md tbody-order',
                'prefix' => '<b>',
                'suffix' => '</b>',
            ),
            'customer' => array(
                'title' => $this->l('Customer'),
                'class' => 'text-left tbody-order',
                'tmpTableFilter' => true
            ),
            'osname' => array(
                'title' => $this->l('Status'),
                'color' => 'color',
                'class' => 'text-left tbody-order',
                'search' => false,
                'orderby' => false,
            ),
            'cname' => array(
                'title' => $this->l('Delivery'),
                'type' => 'select',
                'class' => 'text-left tbody-order',
                'list' => $country_array,
                'filter_key' => 'country!id_country',
                'filter_type' => 'int',
                'order_key' => 'cname'
            ),
            'total_paid_tax_incl' => array(
                'title' => $this->l('Total'),
                'class' => 'text-center fixed-width-md tbody-order',
                'prefix' => '<b>',
                'suffix' => '</b>',
                'type' => 'price',
                'currency' => true
            ),
            'date_add' => array(
                'title' => $this->l('Date'),
                'class' => 'fixed-width-lg tbody-order',
                'align' => 'right',
                'type' => 'datetime',
                'filter_key' => 'a!date_add'
            ),
            'carrier_name' => array(
                'title' => $this->l('Carrier'),
                'callback' => 'carrier',
                'class' => 'text-left fixed-width-lg tbody-order',
                'filter_key' => 'ca!name',
            ),
            'id_product_detail' => array(
                'title' => '',
                'align' => 'center',
                'class' => 'tbody-order',
                'callback' => 'viewProduct',
                'orderby' => false,
                'search' => false,
                'remove_onclick' => true
            )
        );
        parent::__construct();
    }

    public function renderList()
    {
        $id_lang = $this->context->language->id;
        $this->_select = '
            a.id_currency,
            a.id_order AS id_product_detail,        
            CONCAT(LEFT(c.`firstname`, 1), \'. \', c.`lastname`) AS `customer`,
            osl.`name` AS `osname`,
            os.`color`,
            ca.name as carrier_name,
            country_lang.name as cname,
            IF((SELECT COUNT(so.id_order) FROM `'._DB_PREFIX_.'orders` so WHERE so.id_customer = a.id_customer) > 1, 0, 1) as new';
        $this->_join = '
            LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = a.`id_customer`)
            INNER JOIN `'._DB_PREFIX_.'address` address ON address.id_address = a.id_address_delivery
            INNER JOIN `'._DB_PREFIX_.'country` country ON address.id_country = country.id_country
            INNER JOIN `'._DB_PREFIX_.'country_lang` country_lang ON (
                country.`id_country` = country_lang.`id_country` AND 
                country_lang.`id_lang` = '.(int)$id_lang.'
            )
            LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = a.`current_state`)
            LEFT JOIN `'._DB_PREFIX_.'carrier` ca ON (ca.`id_carrier` = a.`id_carrier`)
            LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (
                os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$id_lang.'
            )';
        $this->_where = $this->getQueryShopList();
		$id_warehouse = $this->filterWarehouse();
		if (!empty($id_warehouse)) {
            $this->_where .= ' AND (
                SELECT COUNT(*) FROM `'._DB_PREFIX_.'order_detail` od 
                WHERE od.`id_order` = a.`id_order` AND od.`id_warehouse` = '.(int)$id_warehouse.'
            ) > 0 ';
		}
        $this->_orderBy = 'date_add';
        $this->_orderWay = 'DESC';

        return parent::renderList();
    }

    public function viewProduct($id_order)
    {
        $order = new Order((int)$id_order);
        if (!Validate::isLoadedObject($order)) {
            return '';
        }
        // Get all products related to the current order
        $products = $order->getProducts();
        foreach ($products as $k => &$product) {
            $id_product = (int)$product['product_id'];
            $id_product_attribute = (int)$product['product_attribute_id'];
			// Search orders by warehouse filter
			$id_warehouse = $this->filterWarehouse();
			if (!empty($id_warehouse) && $product['id_warehouse'] != $id_warehouse) {
				unset($products[$k]);
				continue;
			}
			// Available qty = physical - reserved quantity
            $product['in_stock'] = (int)WorkshopAsm::getProductPhysicalQuantities(
				$id_product,
				$id_product_attribute,
				$product['id_warehouse']
			) - (int)WorkshopAsm::getReservedQuantityByProductAndWarehouse(
				$id_product,
				$id_product_attribute,
				$product['id_warehouse']
			);
            $product['product_link'] = WorkshopAsm::getProductLink($id_product);

            // Warehouses list according to the selected carrier
            $order_id_warehouse = (int)$product['id_warehouse'];
            if (!empty($order_id_warehouse)) {
				$associatedWarehouseList = array();
				/* Get associated warehouses list */
				$product_associated_warehouses = WorkshopAsm::getAssociatedWarehousesArray($id_product, $id_product_attribute);
				if (!empty($product_associated_warehouses)) {
					$associatedWarehouseList = StoreHouse::getWarehouses(
						$product_associated_warehouses,
						false
					);
				}
                if (count($associatedWarehouseList)) {
                    foreach ($associatedWarehouseList as $k => &$row) {
                        $id_storehouse = (int)$row['id_warehouse'];
                        $carriers = (new StoreHouse($id_storehouse))->getCarriers(true);
                        if (in_array((int)(new Carrier($order->id_carrier))->id_reference, $carriers)) {
                            $row['is_default'] = ($id_storehouse == $order_id_warehouse ? 1 : 0);
                        } else {
                            unset($associatedWarehouseList[$k]);
                        }
                    }
                    $product['warehouses_list'] = $associatedWarehouseList;
                }
            }
        }

        $this->context->smarty->assign(array(
            'order' => $order,
            'order_link' => WorkshopAsm::getOrderLink($id_order),
            'products' => $products,
            'use_asm' => $this->use_asm,
        ));
        return $this->fetchTemplate(
            '/views/templates/admin/wkwarehouses_orders/helpers/list/',
            'product_details'
        );
    }

    public function carrier($carrier_name)
    {
        return (!empty($carrier_name) ? $carrier_name : '');
    }

    public function ajaxProcessUpdateOrderWarehouse()
    {
        $id_order_detail = (int)Tools::getValue('id_order_detail');
        $id_warehouse = (int)Tools::getValue('id_warehouse');
        $order_detail = new OrderDetail($id_order_detail);

        if (empty($id_warehouse)) {
            die(Tools::jsonEncode(array(
                'hasError' => true,
                'msgError' => $this->l('The warehouse selection is required!')
            )));
        }

        if (Validate::isLoadedObject($order_detail)) {
            $id_order = (int)$order_detail->id_order;
            $order = new Order($id_order);
            if (Validate::isLoadedObject($order)) {
                $sent_statuses = array(
                    (int)Configuration::get('PS_OS_SHIPPING'),
                    (int)Configuration::get('PS_OS_DELIVERED')
                );
                if (in_array($order->current_state, $sent_statuses) &&
                    $order_detail->id_warehouse && $id_warehouse != $order_detail->id_warehouse) {
                    die(Tools::jsonEncode(array(
                        'hasError' => true,
                        'msgError' => $this->l('You can\'t change the warehouse while the order is already delivered, change order status and try again!')
                    )));
                }
            }
            // Add warehouse association if not exists yet
            if (!StorehouseProductLocation::getIdByProductAndWarehouse(
                $order_detail->product_id,
                $order_detail->product_attribute_id,
                $id_warehouse
            )) {
                $warehouse_location_entity = new StorehouseProductLocation();
                $warehouse_location_entity->id_product = (int)$order_detail->product_id;
                $warehouse_location_entity->id_product_attribute = (int)$order_detail->product_attribute_id;
                $warehouse_location_entity->id_warehouse = (int)$id_warehouse;
                $warehouse_location_entity->save();
            }
            $order_detail->id_warehouse = (int)$id_warehouse;
            $order_detail->save();
            die(Tools::jsonEncode(array(
                'hasError' => false,
                'msgOk' => $this->l('Warehouse has been assigned successfully!')
            )));
        } else {
            die(Tools::jsonEncode(array(
                'hasError' => true,
                'msgError' => $this->l('Error: order detail does not exist!')
            )));
        }
    }

    public function fetchTemplate($path, $name, $extension = false)
    {
        return $this->context->smarty->fetch(
            _PS_MODULE_DIR_.$this->module->name.$path.$name.'.'.($extension ? $extension : 'tpl')
        );
    }

    /*public function getList($id_lang, $orderBy = null, $orderWay = null, $start = 0, $limit = null, $id_lang_shop = false)
    {
        //unset($id_lang_shop);
        $this->context = Context::getContext();

        if (Tools::getValue($this->list_id.'Orderby')) {
            $orderBy = Tools::getValue($this->list_id.'Orderby');
        }
        if (Tools::getValue($this->list_id.'Orderway')) {
            $orderWay = Tools::getValue($this->list_id.'Orderway');
        }

        parent::getList($id_lang, $orderBy, $orderWay, $start, $limit, $this->context->shop->id);
    }*/

    public function initContent()
    {
		$cookie = $this->context->cookie;
		$warehouses = StoreHouse::getWarehouses();
		// ==============================
		// Warehouses Filter
		// ==============================
		$id_warehouse = $this->filterWarehouse();
		foreach ($warehouses as &$s) {
			$s['is_selected'] = 0;
			if (!empty($id_warehouse) && $s['id_warehouse'] == $id_warehouse) {
				$s['is_selected'] = 1;
			}
		}
		$cookie->{self::FILTER_WAREHOUSE} = $id_warehouse;
		$cookie->Filter_id_warehouse = (!empty($id_warehouse) ? 1 : 0);

		// For Header tpl
		$this->tpl_list_vars = array(
			'filter_warehouse' => self::FILTER_WAREHOUSE,
			'this_path' => _MODULE_DIR_.$this->module->name,
			'warehouses' => $warehouses,
			'is_warehouse_filter' => $cookie->Filter_id_warehouse,
		);
		parent::initContent();
    }

    /*
    * Function must return array of selected warehouse from filter
    */
    public function filterWarehouse()
    {
        $id_filter = '';
        if (Tools::getIsset($this->list_id.self::FILTER_WAREHOUSE)) {
            $id_filter = Tools::getValue($this->list_id.self::FILTER_WAREHOUSE);
            // If empty value submitted
            if (!$id_filter) {
                unset($this->context->cookie->{self::FILTER_WAREHOUSE});
                unset($this->context->cookie->Filter_id_warehouse);
                return false;
            }
        } elseif (!empty($this->context->cookie->{self::FILTER_WAREHOUSE}) &&
			isset($this->context->cookie->{self::FILTER_WAREHOUSE})) {
            $id_filter = $this->context->cookie->{self::FILTER_WAREHOUSE};
        }
        return $id_filter;
    }

    public function processResetFilters($list_id = null)
    {
        $prefix = str_replace(array('admin', 'controller'), '', Tools::strtolower(get_class($this)));
        $filters = $this->context->cookie->getFamily($prefix.$this->list_id.'Filter_');

        foreach ($filters as $cookie_key => $filter) {
            if (strncmp($cookie_key, $prefix.$this->list_id.'Filter_', 7 + Tools::strlen($prefix.$this->list_id)) == 0) {
                $key = Tools::substr($cookie_key, 7 + Tools::strlen($prefix.$this->list_id));
                /* Table alias could be specified using a ! eg. alias!field */
                $tmp_tab = explode('!', $key);
                $key = (count($tmp_tab) > 1 ? $tmp_tab[1] : $tmp_tab[0]);
                unset($this->context->cookie->$cookie_key);
            }
        }

        if (isset($this->context->cookie->{'submitFilter'.$this->list_id})) {
            unset($this->context->cookie->{'submitFilter'.$this->list_id});
        }
        if (isset($this->context->cookie->{$prefix.$this->list_id.'Orderby'})) {
            unset($this->context->cookie->{$prefix.$this->list_id.'Orderby'});
        }
        if (isset($this->context->cookie->{$prefix.$this->list_id.'Orderway'})) {
            unset($this->context->cookie->{$prefix.$this->list_id.'Orderway'});
        }

        // Reset Custom Filters
        unset($this->context->cookie->{self::FILTER_WAREHOUSE});
        unset($this->context->cookie->Filter_id_warehouse);

        unset($_POST);
        $this->_filter = false;
        unset($this->_filterHaving);
        unset($this->_having);
    }

    public function getQueryShop()
    {
        $query = '';
        $shop_context = Shop::getContext();
        $context = Context::getContext();

        if (isset($this->context->shop->id) && ($shop_context != Shop::CONTEXT_ALL || ($context->controller->multishop_context_group != false && $shop_context != Shop::CONTEXT_GROUP))) {
            $query = ' AND id_shop = '.(int)$this->context->shop->id;
        } elseif (isset($this->context->shop->id_shop_group)) {
            $id_shops = ShopGroup::getShopsFromGroup($this->context->shop->id_shop_group);

            $array_shop = array();
            foreach ($id_shops as $id_shop) {
                $array_shop[] = (int)$id_shop['id_shop'];
            }
            $query = ' AND id_shop IN ('.pSQL(implode(',', $array_shop)).')';
        }
        return $query;
    }
    
    public function getQueryShopList()
    {
        $query = '';
        $shop_context = Shop::getContext();
        $context = Context::getContext();

        if (isset($this->context->shop->id) && ($shop_context != Shop::CONTEXT_ALL || ($context->controller->multishop_context_group != false && $shop_context != Shop::CONTEXT_GROUP))) {
            $query = ' AND a.id_shop = '.(int)$this->context->shop->id;
        } elseif (isset($this->context->shop->id_shop_group)) {
            $id_shops = ShopGroup::getShopsFromGroup($this->context->shop->id_shop_group);

            $array_shop = array();
            foreach ($id_shops as $id_shop) {
                $array_shop[] = (int)$id_shop['id_shop'];
            }
            $query = ' AND a.id_shop IN ('.pSQL(implode(',', $array_shop)).')';
        }
        return $query;
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);
        $this->addJqueryPlugin(array('cooki-plugin'));
    }

    public function initToolbar()
    {
        parent::initToolbar();
        unset($this->toolbar_btn['new']);
    }

    public function initPageHeaderToolbar()
    {
        $this->page_header_toolbar_btn['back_to_dashboard'] = array(
            'href' => $this->context->link->getAdminLink('AdminWkwarehousesdash'),
            'desc' => $this->l('Dashboard', null, null, false),
            'icon' => 'process-icon-back'
        );
        parent::initPageHeaderToolbar();
    }

    /*
    * Method Translation Override For PS 1.7
    */
    protected function l($string, $class = null, $addslashes = false, $htmlentities = true)
    {
        if (method_exists('Context', 'getTranslator')) {
            $this->translator = Context::getContext()->getTranslator();
            $translated = $this->translator->trans($string);
            if ($translated !== $string) {
                return $translated;
            }
        }
        if ($class === null || $class == 'AdminTab') {
            $class = Tools::substr(get_class($this), 0, -10);
        } elseif (Tools::strtolower(Tools::substr($class, -10)) == 'controller') {
            $class = Tools::substr($class, 0, -10);
        }
        return Translate::getAdminTranslation($string, $class, $addslashes, $htmlentities);
    }
}
