<?php

use Invertus\Printify\Config\Config;
use Invertus\Printify\Service\Logger;
use Invertus\Printify\Service\PrintifyOrderResolver;

class PrintifyOrderEventsModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);
        if (empty($data) || !isset($data->type)) {
            $this->ajaxDie('No data');
        }

        /** @var PrintifyOrderResolver $orderResolver */
        $orderResolver = $this->module->getModuleContainer()->get('printify_order_resolver');

        /** @var Logger $logger */
        $logger = $this->module->getModuleContainer()->get('printify_logger');

        try {
            if ($data->type === 'order:updated') {
                $orderResolver->updateOrder($data->resource->id);
            }
            if ($data->type === 'order:shipment:created') {
                $orderResolver->updateOrder($data->resource->id);
            }
            if ($data->type === 'order:shipment:delivered') {
                $orderResolver->updateOrder($data->resource->id);
            }
        } catch (Exception $e) {
            $logger->log(Config::PRINTIFY_LOG_TYPE_ORDER_WEBHOOK, $e->getMessage(), $data->resource->id);
        }

        $this->ajaxDie('');
    }
}


