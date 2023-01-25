<?php
class Cart extends CartCore
{
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:34
    * version: 1.69.76
    */
    public function getPackageShippingCost($id_carrier = null, $use_tax = true, Country $default_country = null, $product_list = null, $id_zone = null, bool $keepOrderPrices = false)
	{
        $shipping_cost = parent::getPackageShippingCost($id_carrier, $use_tax, $default_country, $product_list, $id_zone, $keepOrderPrices);
        if (!Module::isEnabled('wkwarehouses') || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') || !$use_tax) {
            return $shipping_cost;
        }
        if (!empty($id_carrier)) {
            $carrier = new Carrier((int)$id_carrier);
            if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_invoice') {
                $address_id = (int)$this->id_address_invoice;
            } elseif (is_array($product_list) && count($product_list)) {
                $prod = current($product_list);
                $address_id = (int)$prod['id_address_delivery'];
            } else {
                $address_id = null;
            }
            if (!Address::addressExists($address_id)) {
                $address_id = null;
            }
            if (!Tax::excludeTaxeOption()) {
                $address = Address::initialize((int)$address_id);
                if (Configuration::get('PS_ATCP_SHIPWRAP')) {
                    $carrier_tax = 0;
                } else {
                    $carrier_tax = $carrier->getTaxesRate($address);
                }
            }
            $id_tax_rule_group = (int)$carrier->getIdTaxRulesGroup();
            if (!empty($address_id)) {
                $currency = Currency::getCurrencyInstance((int)($this->id_currency));
                $address = new Address($address_id);
                $country = new Country($address->id_country);
                $taxes = TaxRulesGroup::getAssociatedTaxRatesByIdCountry($country->id);
                if ($id_tax_rule_group > 0 && isset($taxes[$id_tax_rule_group]) && isset($carrier_tax)) {
                    $carrier_tax_rate = $taxes[$id_tax_rule_group];
                    if ($carrier_tax != $carrier_tax_rate) {
                        return Tools::convertPriceFull($shipping_cost * (1 + ($carrier_tax_rate / 100)), $currency);
                    }
                }
            }
            if ($shipping_cost !== false) {
                return $shipping_cost;
            }
        }
        return $shipping_cost;
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:34
    * version: 1.69.76
    */
    public function checkQuantities($returnProductOnFailure = false)
    {
        if (!Module::isEnabled('wkwarehouses') || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return parent::checkQuantities($returnProductOnFailure);
        }
        if (Configuration::isCatalogMode() && !defined('_PS_ADMIN_DIR_')) {
            return false;
        }
        if (!class_exists('StoreHouse')) {
            require_once(dirname(__FILE__).'/../../modules/wkwarehouses/classes/Warehouse.php');
            require_once(dirname(__FILE__).'/../../modules/wkwarehouses/classes/WarehouseStock.php');
            require_once(dirname(__FILE__).'/../../modules/wkwarehouses/classes/WorkshopAsm.php');
        }
        WarehouseStock::isMultiShipping($this);
        foreach ($this->getProducts() as $product) {
            $id_product = (int)$product['id_product'];
            $id_product_attribute = (int)$product['id_product_attribute'];
            if (!isset($product['allow_oosp'])) {
                $product['allow_oosp'] = Product::isAvailableWhenOutOfStock($product['out_of_stock']);
            }
            if (!$this->allow_seperated_package && !$product['allow_oosp'] &&
                $product['advanced_stock_management'] &&
                ($delivery = $this->getDeliveryOption()) && !empty($delivery)) {
                
                if (empty(WorkshopAsm::getAssociatedWarehousesArray($id_product, $id_product_attribute))) {
                    return $returnProductOnFailure ? $product : false;
                }
                $result = WarehouseStock::getAvailableWarehouseAndCartQuantity($id_product, $id_product_attribute, $this, true);
                $product['stock_quantity'] = ($result ? (int)$result['quantity'] : 0);
            }
            if (!$product['active'] ||
                !$product['available_for_order'] ||
                (!$product['allow_oosp'] && $product['stock_quantity'] < $product['cart_quantity'])) {
                return $returnProductOnFailure ? $product : false;
            }
            if (!$product['allow_oosp'] && version_compare(_PS_VERSION_, '1.7.3.2', '>=') === true) {
                $productQuantity = Product::getQuantity(
                    $id_product,
                    $id_product_attribute,
                    null,
                    $this,
                    $product['id_customization']
                );
                if ($productQuantity < 0) {
                    return $returnProductOnFailure ? $product : false;
                }
            }
        }
        return true;
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:34
    * version: 1.69.76
    */
    public function getCarriersIntersection($packages_carriers, $id_package)
    {
        $array_search = $packages_carriers[$id_package];
        $target = $id_package - 1;
        if ($target == -1) {
            return null;
        }
        for ($i = $target; $i >= 0; --$i) {
            if (array_intersect($array_search, $packages_carriers[$i])) {
                return $i;
            }
        }
        return false;
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:34
    * version: 1.69.76
    */
    public function getPackageList($flush = false)
    {
        if (!Module::isEnabled('wkwarehouses') || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return parent::getPackageList($flush);
        }
        if (Module::isInstalled('wkmergeorders') && Module::isEnabled('wkmergeorders')) {
			if (!class_exists('WorkshopMo')) {
				require_once(dirname(__FILE__).'/../../modules/wkmergeorders/classes/WorkshopMo.php');
			}
			$packageList = parent::getPackageList($flush);
			if ($package_list = WorkshopMo::getUniquePackageList($packageList)) {
				return $package_list;
			}
        }
        if (!class_exists('WarehouseStock')) {
            require_once(dirname(__FILE__).'/../../modules/wkwarehouses/classes/Warehouse.php');
            require_once(dirname(__FILE__).'/../../modules/wkwarehouses/classes/WarehouseStock.php');
            require_once(dirname(__FILE__).'/../../modules/wkwarehouses/classes/WorkshopAsm.php');
        }
        WarehouseStock::checkCartIntegrity($this);
        if (WarehouseStock::getNumberOfAsmProductsInCart($this->id) <= 0) {
            return parent::getPackageList($flush);
        }
        $package_list = $this->getMyPackageList($flush);
        $multi_packages = false;
        if ($package_list) {
            foreach ($package_list as $id_address => $packages) {
                if (count($packages) > 1) {
                    $multi_packages = true;
                    break;
                }
            }
        }
        if ($multi_packages) {
            $sorted_packages_list = array();
            foreach ($package_list as $id_address => $packages) {
                if (count($packages) > 1) {
                    $packages_warehouses = array_column($packages, 'warehouse_list');
                    $ids_warehouses = array();
                    foreach ($packages_warehouses as $array_warehouse) {
                        $ids_warehouses[] = (int)key($array_warehouse);
                    }
                    if (count($packages) == count($ids_warehouses)) {
                        $sorted_packages_list[$id_address] = $package_list[$id_address];
                    } else {
                        $packages_carriers = array_column($packages, 'carrier_list');
                        krsort($packages_carriers); // sort by keys desc
                        foreach ($packages_carriers as $id_package => $carriers) {
                            $index = $this->getCarriersIntersection($packages_carriers, $id_package);
                            if ($index === false || $index === null) {
                                $id_package = ($index === null ? 0 : $id_package);
                                if (!isset($sorted_packages_list[$id_address][$id_package])) {
                                    $sorted_packages_list[$id_address][$id_package] = $package_list[$id_address][$id_package];
                                }
                            } else {
                                if (isset($sorted_packages_list[$id_address][$id_package])) {
                                    $package_index = $sorted_packages_list[$id_address][$id_package];
                                    unset($sorted_packages_list[$id_address][$id_package]);
                                } else {
                                    $package_index = $packages[$id_package];
                                }
                                $commonCarriers = array_intersect($packages[$index]['carrier_list'], $package_index['carrier_list']);
                                $sorted_packages_list[$id_address][$index]['product_list'] = array_merge($packages[$index]['product_list'], $package_index['product_list']);
                                $sorted_packages_list[$id_address][$index]['carrier_list'] = $commonCarriers;
                                $sorted_packages_list[$id_address][$index]['warehouse_list'] = array_intersect($packages[$index]['warehouse_list'], $package_index['warehouse_list']);
                                $sorted_packages_list[$id_address][$index]['id_warehouse'] = 0;
                                $packages_carriers[$index] = $commonCarriers;
                            }
                        }
                        ksort($sorted_packages_list[$id_address]); // sort asc
                    }
                } else {
                    $sorted_packages_list[$id_address] = $package_list[$id_address];
                }
            }
            $package_list = $sorted_packages_list;
        }
        return $package_list;
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:34
    * version: 1.69.76
    */
    protected static $cachePackageList = [];
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:34
    * version: 1.69.76
    */
    public function getMyPackageList($flush = false)
    {
        $cache_key = (int)$this->id . '_' . (int)$this->id_address_delivery;
        if (isset(static::$cachePackageList[$cache_key]) && static::$cachePackageList[$cache_key] !== false && !$flush) {
            return static::$cachePackageList[$cache_key];
        }
        $product_list = $this->getProducts($flush);
        $warehouse_count_by_address = array();
        foreach ($product_list as &$product) {
            if ((int)$product['id_address_delivery'] == 0 || !Configuration::get('WKWAREHOUSE_ALLOW_MULTI_ADDRESSES')) {
                $product['id_address_delivery'] = (int)$this->id_address_delivery;
				if (!Configuration::get('WKWAREHOUSE_ALLOW_MULTI_ADDRESSES')) {
					Db::getInstance()->execute(
						'UPDATE `'._DB_PREFIX_.'cart_product` SET
						 `id_address_delivery` = '.(int)$this->id_address_delivery
						 .' WHERE `id_cart` = '.(int)$this->id
					);
				}
            }
            if (!isset($warehouse_count_by_address[$product['id_address_delivery']])) {
                $warehouse_count_by_address[$product['id_address_delivery']] = array();
            }
            $product['warehouse_list'] = array();
            if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') && (int)$product['advanced_stock_management'] == 1) {
                $rs = WarehouseStock::productIsPresentInCart(
                    $this->id,
                    $product['id_product'],
                    $product['id_product_attribute']
                );
                if ($rs) {
                    $warehouse_list = array(0 => array('id_warehouse' => (int)$rs['id_warehouse']));
                } else {
                    $warehouse_list = StoreHouse::getProductWarehouseList(
						$product['id_product'],
						$product['id_product_attribute'],
						false
					);
                }
                $warehouse_in_stock = array();
                foreach ($warehouse_list as $key => $warehouse) {
                    $product_real_quantities = WarehouseStock::getAvailableQuantityByWarehouse(
                        $product['id_product'],
                        $product['id_product_attribute'],
                        $warehouse['id_warehouse']
                    );
                    if ($product_real_quantities > 0 || Pack::isPack((int)$product['id_product'])) {
                        $warehouse_in_stock[] = $warehouse;
                    }
                }
                if (!empty($warehouse_in_stock)) {
                    $warehouse_list = $warehouse_in_stock;
                    $product['in_stock'] = true;
                } else {
                    $product['in_stock'] = false;
                }
            } else {
                $warehouse_list = array(0 => array('id_warehouse' => 0));
                $product['in_stock'] = StockAvailable::getQuantityAvailableByProduct($product['id_product'], $product['id_product_attribute']) > 0;
            }
            foreach ($warehouse_list as $warehouse) {
                $product['warehouse_list'][$warehouse['id_warehouse']] = $warehouse['id_warehouse'];
                if (!isset($warehouse_count_by_address[$product['id_address_delivery']][$warehouse['id_warehouse']])) {
                    $warehouse_count_by_address[$product['id_address_delivery']][$warehouse['id_warehouse']] = 0;
                }
                ++$warehouse_count_by_address[$product['id_address_delivery']][$warehouse['id_warehouse']];
            }
        }
        unset($product);
        arsort($warehouse_count_by_address);
        $grouped_by_warehouse = array();
        foreach ($product_list as &$product) {
            if (!isset($grouped_by_warehouse[$product['id_address_delivery']])) {
                $grouped_by_warehouse[$product['id_address_delivery']] = array(
                    'in_stock' => array(),
                    'out_of_stock' => array(),
                );
            }
            $product['carrier_list'] = array();
            $id_warehouse = 0;
            foreach ($warehouse_count_by_address[$product['id_address_delivery']] as $id_war => $val) {
                if (array_key_exists((int)$id_war, $product['warehouse_list'])) {
                    $product['carrier_list'] = array_replace(
                        $product['carrier_list'],
                        Carrier::getAvailableCarrierList(new Product($product['id_product'], false), $id_war, $product['id_address_delivery'], null, $this)
                    );
                    if (!$id_warehouse) {
                        $id_warehouse = (int)$id_war;
                    }
                }
            }
            if (!isset($grouped_by_warehouse[$product['id_address_delivery']]['in_stock'][$id_warehouse])) {
                $grouped_by_warehouse[$product['id_address_delivery']]['in_stock'][$id_warehouse] = array();
                $grouped_by_warehouse[$product['id_address_delivery']]['out_of_stock'][$id_warehouse] = array();
            }
            if (!$this->allow_seperated_package) {
                $key = 'in_stock';
            } else {
                $key = $product['in_stock'] ? 'in_stock' : 'out_of_stock';
                $product_quantity_in_stock = StockAvailable::getQuantityAvailableByProduct($product['id_product'], $product['id_product_attribute']);
                if ($product['in_stock'] && $product['cart_quantity'] > $product_quantity_in_stock) {
                    $out_stock_part = $product['cart_quantity'] - $product_quantity_in_stock;
                    $product_bis = $product;
                    $product_bis['cart_quantity'] = $out_stock_part;
                    $product_bis['in_stock'] = 0;
                    $product['cart_quantity'] -= $out_stock_part;
                    $grouped_by_warehouse[$product['id_address_delivery']]['out_of_stock'][$id_warehouse][] = $product_bis;
                }
            }
            if (empty($product['carrier_list'])) {
                $product['carrier_list'] = array(0 => 0);
            }
            $grouped_by_warehouse[$product['id_address_delivery']][$key][$id_warehouse][] = $product;
        }
        unset($product);
        $grouped_by_carriers = array();
        foreach ($grouped_by_warehouse as $id_address_delivery => $products_in_stock_list) {
            if (!isset($grouped_by_carriers[$id_address_delivery])) {
                $grouped_by_carriers[$id_address_delivery] = array(
                    'in_stock' => array(),
                    'out_of_stock' => array(),
                );
            }
            foreach ($products_in_stock_list as $key => $warehouse_list) {
                if (!isset($grouped_by_carriers[$id_address_delivery][$key])) {
                    $grouped_by_carriers[$id_address_delivery][$key] = array();
                }
                foreach ($warehouse_list as $id_warehouse => $product_list) {
                    if (!isset($grouped_by_carriers[$id_address_delivery][$key][$id_warehouse])) {
                        $grouped_by_carriers[$id_address_delivery][$key][$id_warehouse] = array();
                    }
                    foreach ($product_list as $product) {
                        $package_carriers_key = implode(',', $product['carrier_list']);
                        if (!isset($grouped_by_carriers[$id_address_delivery][$key][$id_warehouse][$package_carriers_key])) {
                            $grouped_by_carriers[$id_address_delivery][$key][$id_warehouse][$package_carriers_key] = array(
                                'product_list' => array(),
                                'carrier_list' => $product['carrier_list'],
                                'warehouse_list' => $product['warehouse_list'],
                            );
                        }
                        $grouped_by_carriers[$id_address_delivery][$key][$id_warehouse][$package_carriers_key]['product_list'][] = $product;
                    }
                }
            }
        }
        $package_list = array();
        foreach ($grouped_by_carriers as $id_address_delivery => $products_in_stock_list) {
            if (!isset($package_list[$id_address_delivery])) {
                $package_list[$id_address_delivery] = array(
                    'in_stock' => array(),
                    'out_of_stock' => array(),
                );
            }
            foreach ($products_in_stock_list as $key => $warehouse_list) {
                if (!isset($package_list[$id_address_delivery][$key])) {
                    $package_list[$id_address_delivery][$key] = array();
                }
                $carrier_count = array();
                foreach ($warehouse_list as $id_warehouse => $products_grouped_by_carriers) {
                    foreach ($products_grouped_by_carriers as $data) {
                        foreach ($data['carrier_list'] as $id_carrier) {
                            if (!isset($carrier_count[$id_carrier])) {
                                $carrier_count[$id_carrier] = 0;
                            }
                            ++$carrier_count[$id_carrier];
                        }
                    }
                }
                arsort($carrier_count);
                foreach ($warehouse_list as $id_warehouse => $products_grouped_by_carriers) {
                    if (!isset($package_list[$id_address_delivery][$key][$id_warehouse])) {
                        $package_list[$id_address_delivery][$key][$id_warehouse] = array();
                    }
                    foreach ($products_grouped_by_carriers as $data) {
                        foreach ($carrier_count as $id_carrier => $rate) {
                            if (array_key_exists($id_carrier, $data['carrier_list'])) {
                                if (!isset($package_list[$id_address_delivery][$key][$id_warehouse][$id_carrier])) {
                                    $package_list[$id_address_delivery][$key][$id_warehouse][$id_carrier] = array(
                                        'carrier_list' => $data['carrier_list'],
                                        'warehouse_list' => $data['warehouse_list'],
                                        'product_list' => array(),
                                    );
                                }
                                $package_list[$id_address_delivery][$key][$id_warehouse][$id_carrier]['carrier_list'] =
                                    array_intersect($package_list[$id_address_delivery][$key][$id_warehouse][$id_carrier]['carrier_list'], $data['carrier_list']);
                                $package_list[$id_address_delivery][$key][$id_warehouse][$id_carrier]['product_list'] =
                                    array_merge($package_list[$id_address_delivery][$key][$id_warehouse][$id_carrier]['product_list'], $data['product_list']);
                                break;
                            }
                        }
                    }
                }
            }
        }
        $final_package_list = array();
        foreach ($package_list as $id_address_delivery => $products_in_stock_list) {
            if (!isset($final_package_list[$id_address_delivery])) {
                $final_package_list[$id_address_delivery] = array();
            }
            foreach ($products_in_stock_list as $key => $warehouse_list) {
                foreach ($warehouse_list as $id_warehouse => $products_grouped_by_carriers) {
                    foreach ($products_grouped_by_carriers as $data) {
                        $final_package_list[$id_address_delivery][] = array(
                            'product_list' => $data['product_list'],
                            'carrier_list' => $data['carrier_list'],
                            'warehouse_list' => $data['warehouse_list'],
                            'id_warehouse' => $id_warehouse,
                        );
                    }
                }
            }
        }
        static::$cachePackageList[$cache_key] = $final_package_list;
        return $final_package_list;
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:34
    * version: 1.69.76
    */
    public function updateAddressId($id_address, $id_address_new)
    {
        if (!Module::isEnabled('wkwarehouses') || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return parent::updateAddressId($id_address, $id_address_new);
        }
        if (!class_exists('WarehouseStock')) {
            require_once(dirname(__FILE__).'/../../modules/wkwarehouses/classes/WarehouseStock.php');
        }
        $to_update = false;
        if (!isset($this->id_address_invoice) || $this->id_address_invoice == $id_address) {
            $to_update = true;
            $this->id_address_invoice = $id_address_new;
        }
        if (!isset($this->id_address_delivery) || $this->id_address_delivery == $id_address) {
            $to_update = true;
            $this->id_address_delivery = $id_address_new;
        }
        if ($to_update) {
            $this->update();
        }
        if (!WarehouseStock::isMultiShipping($this)) {
            return parent::updateAddressId($id_address, $id_address_new);
        }
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:34
    * version: 1.69.76
    */
    public function duplicate()
    {
        if (!Module::isEnabled('wkwarehouses') || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT') ||
            !Configuration::get('WKWAREHOUSE_ALLOW_MULTIWH_CART') ||
            !Configuration::get('WKWAREHOUSE_ALLOW_MULTICARRIER_CART')) {
            return parent::duplicate();
        }
        if (!class_exists('StoreHouse')) {
            require_once(dirname(__FILE__).'/../../modules/wkwarehouses/classes/Warehouse.php');
            require_once(dirname(__FILE__).'/../../modules/wkwarehouses/classes/WarehouseStock.php');
        }
        $id_old_cart = $this->id;
        if (WarehouseStock::getNumberOfAsmProductsInCart($id_old_cart) <= 0) {
            return parent::duplicate();
        }
        $duplication = parent::duplicate();
        $duplicated_cart = null;
        if ($duplication && Validate::isLoadedObject($duplication['cart']) && $duplication['success']) {
            $duplicated_cart = $duplication['cart'];
            $action = Tools::getIsset('action') ? Tools::getValue('action') : '';
			foreach ($duplicated_cart->getProducts() as $data) {
				if (empty(WorkshopAsm::getAssociatedWarehousesArray($data['id_product'], $data['id_product_attribute']))) {
					$duplicated_cart->deleteProduct($data['id_product'], $data['id_product_attribute']);
					$duplicated_cart->update();
				}
			}
            if ($action == 'duplicateOrder' && Tools::getValue('tab') == 'AdminCarts') {
                
                $order_duplicate = new Order((int)Tools::getValue('id_order'));
                if (Validate::isLoadedObject($order_duplicate) && count($order_duplicate->getBrother()) >= 1) {
                    $order_products = $order_duplicate->getProductsDetail();
                    $order_products_array = array();
                    foreach ($order_products as $row) {
                        array_push($order_products_array, $row['product_id'].'_'.$row['product_attribute_id']);
                    }
                    foreach ($duplicated_cart->getProducts() as $data) {
                        if (!in_array($data['id_product'].'_'.$data['id_product_attribute'], $order_products_array)) {
                            $duplicated_cart->deleteProduct($data['id_product'], $data['id_product_attribute']);
                            $duplicated_cart->update();
                        }
                    }
                }
            }
            if ((!empty($action) && !in_array($action, array('addProductOnOrder', 'deleteProductLine'))) || empty($action)) {
                foreach ($duplicated_cart->getProducts() as $product) {
                    $id_product = (int)$product['id_product'];
                    $productObj = new Product($id_product, false);
                    if (Validate::isLoadedObject($productObj) && $productObj->advanced_stock_management) {
                        $id_product_attribute = (int)$product['id_product_attribute'];
                        $rs = WarehouseStock::productIsPresentInCart($id_old_cart, $id_product, $id_product_attribute);
                        if ($rs && (int)$rs['id_warehouse'] > 0) {
                            $id_warehouse = (int)$rs['id_warehouse'];
                            $warehouse = new StoreHouse($id_warehouse);
                            if (Validate::isLoadedObject($warehouse)) {
                                WarehouseStock::updateProductWarehouseCart(
                                    $duplicated_cart->id,
                                    $id_product,
                                    $id_product_attribute,
                                    $id_warehouse
                                );
                            }
                        }
                    }
                }
            }
            if (Tools::getIsset('action') && Tools::getValue('action') == 'duplicateOrder' &&
                Tools::getValue('tab') == 'AdminCarts') {
                WarehouseStock::checkAvailabilityCarriersInCart($duplicated_cart);
            }
            if (Tools::getIsset('submitReorder')) {
                WarehouseStock::assignRightDeliveryAddressToEachProductInCart($duplicated_cart);
            }
        }
        return array('cart' => $duplicated_cart, 'success' => $duplication['success']);
    }
}
