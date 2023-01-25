<?php
class Order extends OrderCore
{
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:36
    * version: 1.69.76
    */
    public function getProductsDetail()
    {
        if (!Module::isEnabled('wkwarehouses') || !Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            return parent::getProductsDetail();
        }
        $order = new Order((int)$this->id);
        if ((self::isOrderMultiWarehouses($order) || self::isOrderMultiCarriers($order)) &&
            Tools::getValue('controller') != 'orderconfirmation') {
            return parent::getProductsDetail();
        }
    
        $orders_ids = array((int)$this->id);
        foreach ($order->getBrother() as $suborder) {
            $orders_ids[] = (int)$suborder->id;
        }
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            'SELECT *
             FROM `'._DB_PREFIX_.'order_detail` od
             LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.id_product = od.product_id)
             LEFT JOIN `'._DB_PREFIX_.'product_shop` ps ON (
                ps.id_product = p.id_product AND ps.id_shop = od.id_shop
             )
             WHERE od.`id_order` IN ('.implode(',', $orders_ids).')'
        );
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:36
    * version: 1.69.76
    */
    public static function isOrderMultiWarehouses($order)
    {
        $warehouses_list = array();
        $orders_collection = $order->getBrother();
        if (count($orders_collection)) {
            $warehouses_list = $order->getWarehouseList();
            foreach ($orders_collection as $suborder) {
                foreach ($suborder->getWarehouseList() as $id_warehouse) {
                    array_push($warehouses_list, (int)$id_warehouse);
                }
            }
            $warehouses_list = array_unique(array_filter($warehouses_list));
        }
        return (!empty($warehouses_list) && count($warehouses_list) > 1  ? true : false);
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:36
    * version: 1.69.76
    */
    public static function isOrderMultiCarriers($order)
    {
        $carriers_list = array();
        $orders_collection = $order->getBrother();
        if (count($orders_collection)) {
            $carriers_list[] = (int)$order->id_carrier;
            foreach ($orders_collection as $suborder) {
                array_push($carriers_list, (int)$suborder->id_carrier);
            }
            $carriers_list = array_unique(array_filter($carriers_list));
        }
        return (!empty($carriers_list) && count($carriers_list) > 1 ? true : false);
    }
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:36
    * version: 1.69.76
    */
    public function fixOrderPayment()
    {
        if ($this->id) {
            $query = new DbQuery();
            $query->select('op.id_order_payment, op.amount');
            $query->from('order_payment', 'op');
            $query->innerJoin('order_invoice_payment', 'oip', 'op.id_order_payment = oip.id_order_payment');
            $query->innerJoin('orders', 'o', 'oip.id_order = o.id_order');
            $query->where('oip.id_order = '.(int)$this->id);
            $rowPaid = Db::getInstance()->getRow($query->build());
            if ($rowPaid) {
                if ((float)$rowPaid['amount'] != (float)$this->total_paid_tax_incl && $rowPaid['id_order_payment']) {
                    Db::getInstance()->execute(
                        'UPDATE `'._DB_PREFIX_.'order_payment`
                         SET amount = '.(float)$this->total_paid_tax_incl.'
                         WHERE `id_order_payment` = '.(int)$rowPaid['id_order_payment']
                    );
                }
            }
        }
    }
    /*
    * module: ets_ordermanager
    * date: 2023-01-22 10:08:47
    * version: 2.5.8
    */
    public static function getCustomerOrders($id_customer, $show_hidden_status = false, Context $context = null)
    {
        $res =parent::getCustomerOrders($id_customer, $show_hidden_status,$context);
        if($res)
        {
            $values = array();
            foreach ($res as $key => $val) 
            {
                if($val['deleted']) 
                    unset($res[$key]);
                else
                   $values[] = $val; 
            }
            return $values;
        }
        return array();
    }
    /*
    * module: ets_ordermanager
    * date: 2023-01-22 10:08:47
    * version: 2.5.8
    */
    public function hasBeenShipped()
    {
        $action = Tools::getValue('action');
        $controller = Tools::getValue('controller');
        if(($action=='addProductOnOrder' || $action=='editProductOnOrder') && $controller=='AdminOrders')
            return false;
        return parent::hasBeenShipped();
    }
    /*
    * module: ets_ordermanager
    * date: 2023-01-22 10:08:47
    * version: 2.5.8
    */
    public function refreshShippingCost()
    {
        $ets_ordermanager = Module::getInstanceByName('ets_ordermanager');
        $ets_ordermanager->refreshShippingCost($this);
        if($this->invoice_number)
        {
            $id_order_invoice = (int)Db::getInstance()->getValue('SELECT id_order_invoice FROM `'._DB_PREFIX_.'order_invoice` WHERE id_order='.(int)$this->id);
            if($id_order_invoice)
            {
                $order_invoice = new OrderInvoice($id_order_invoice);
                    $this->setInvoiceDetails($order_invoice);
            } 
            else
                $this->setInvoice();
        }
        return $this;
    }
    /*
    * module: ets_ordermanager
    * date: 2023-01-22 10:08:47
    * version: 2.5.8
    */
    public function hasBeenDelivered()
    {
        $action = Tools::getValue('action');
        $controller = Tools::getValue('controller');
        if(($action=='addProductOnOrder' || $action=='editProductOnOrder') && $controller=='AdminOrders')
            return false;
        return parent::hasBeenDelivered();
    }
}
