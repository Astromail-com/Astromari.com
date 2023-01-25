<?php

namespace Invertus\Printify\Repository;

use Db;
use DbQuery;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Model\PrintifyOrder;
use PrestaShopDatabaseException;

class PrintifyOrderRepository
{
    /**
     * @param PrintifyOrder $order
     * @return bool
     * @throws PrestaShopDatabaseException
     */
    public function updateOrderFromObject($order)
    {
        return Db::getInstance()->insert(
            'printify_order',
            array(
                'reference' => pSQL($order->getReference()),
                'id_printify_order' => pSQL($order->getIdPrintifyOrder()),
                'created_at' => pSQL($order->getCreatedAt()),
                'customer' => pSQL($order->getCustomer()),
                'total_paid' => pSQL($order->getTotalPaid()),
                'status' => pSQL($order->getStatus()),
            ),
            false,
            true,
            DB::ON_DUPLICATE_KEY
        );
    }

    /**
     * @param $idOrder
     * @param $status
     * @return bool
     */
    public function changeOrderStatus($idOrder, $status)
    {
        return Db::getInstance()->update(
            'printify_order',
            array('status' => pSQL($status)),
            'id_printify_order = "' . pSQL($idOrder) . '"'
        );
    }

    /**
     * @param $idOrder
     * @return false|string|null
     */
    public function getOrderStatus($idOrder)
    {
        $query = new DbQuery();
        $query->select('status');
        $query->from('printify_order');
        $query->where('id_printify_order = "' . pSQL($idOrder) . '"');

        return Db::getInstance()->getValue($query);
    }

    /**
     * @param $reference
     * @return false|string|null
     */
    public function checkIfOrderExists($reference)
    {
        $query = new DbQuery();
        $query->select('reference');
        $query->from('printify_order');
        $query->where('reference = "' . pSQL($reference) . '"');

        return Db::getInstance()->getValue($query);
    }

    public function getOrderStateId($id)
    {
        $query = new DbQuery();
        $query->select('id_order_state');
        $query->from('printify_order_state');
        $query->where('id = "' . pSQL($id) . '"');
        return Db::getInstance()->getValue($query);
    }
}
