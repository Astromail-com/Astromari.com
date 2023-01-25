<?php

use Invertus\Printify\Api\OrderApi;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Exception\FailedToUpdateOrderException;
use Invertus\Printify\Repository\PrintifyOrderRepository;
use Invertus\Printify\Service\Logger;
use Invertus\Printify\Service\PrintifyOrderResolver;

class AdminPrintifyOrderController extends \Invertus\Printify\Controller\AdminController
{
    const PRINTIFY_ORDER_LINK = 'https://printify.com/app/order/';

    /**
     * @var PrintifyContainer
     */
    private $moduleContainer;

    /**
     *
     * @throws PrestaShopException
     */
    public function __construct()
    {
        $this->table = 'printify_order';
        $this->identifier_name = 'reference';
        parent::__construct();

        $this->moduleContainer = $this->module->getModuleContainer();
    }

    public function init()
    {
        parent::init();
        $this->initList();
        unset($this->toolbar_btn['new']);
    }

    public function setMedia($isNewTheme = false)
    {
        $this->addCSS($this->module->getPathUri() . 'views/css/status.css');
        parent::setMedia($isNewTheme);
    }

    private function initList()
    {
        $this->addRowAction('fulfillOrder');

        $this->list_no_link = true;
        $this->fields_list = array(
            'created_at' => array(
                'title' => $this->module->l('Created at'),
                'align' => 'center',
                'havingFilter' => true,
                'type' => 'date'
            ),
            'reference' => array(
                'title' => $this->module->l('Order reference'),
                'align' => 'center',
                'type' => 'text',
                'filter_key' => 'a!reference',
                'callback' => 'returnPsOrderLink'
            ),
            'id_printify_order' => array(
                'title' => $this->module->l('Printify Id'),
                'align' => 'center',
                'type' => 'text',
                'callback' => 'returnPrintifyOrderLink'

            ),
            'customer' => array(
                'title' => $this->module->l('Customer'),
                'align' => 'center',
                'type' => 'text',
            ),

            'total_paid' => array(
                'title' => $this->module->l('Total Paid'),
                'align' => 'center',
                'type' => 'price',
                'search' => false,
            ),
            'status' => array(
                'title' => $this->module->l('Status'),
                'align' => 'center',
                'search' => false,
                'callback' => 'returnStatus'
            ),
        );

        $this->moduleContainer->get('printify_logger')->clearOldLogs();
    }

    public function returnPrintifyOrderLink($id)
    {
        $tpl = $this->context->smarty->createTemplate(
            $this->module->getLocalPath() . 'views/templates/admin/listLink.tpl'
        );

        $tpl->assign(
            array(
                'text' => $id,
                'blank' => true,
                'link' => self::PRINTIFY_ORDER_LINK . $id
            )
        );

        return $tpl->fetch();
    }

    public function returnPsOrderLink($reference)
    {
        $order = Order::getByReference($reference)->getFirst();
        $tpl = $this->context->smarty->createTemplate(
            $this->module->getLocalPath() . 'views/templates/admin/listLink.tpl'
        );

        $tpl->assign(
            array(
                'text' => $reference,
                'blank' => true,
                'link' => $this->context->link->getAdminLink(
                    'AdminOrders',
                    'true',
                    array(),
                    array(
                        'id_order' => $order->id,
                        'vieworder' => 1
                    )
                )
            )
        );

        return $tpl->fetch();
    }

    protected function renderListAction(array $params)
    {
        $this->context->smarty->assign($params);

        return $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/listAction.tpl');
    }


    public function displayFulfillOrderLink($token, $idOrder)
    {
        /** @var PrintifyOrderRepository $orderRepository */
        $orderRepository = $this->moduleContainer->get('printify_order_repository');
        $orderStatus = $orderRepository->getOrderStatus($idOrder);
        if ($orderStatus !== Config::PRINTIFY_ORDER_PENDING && $orderStatus !== Config::PRINTIFY_ORDER_PAYMENT_NOT_RECEIVED) {
            return false;
        }
        $orderUrl = $this->context->link->getAdminLink($this->controller_name).'&fulfillOrder=1&id_order=' . $idOrder;

        $params = array(
            'href' => $orderUrl,
            'action' => $this->l('Fulfill'),
            'icon' => 'icon-download-alt',
        );

        return $this->renderListAction($params);
    }

    public function returnStatus($idStatus)
    {
        $tpl = $this->context->smarty->createTemplate(
            $this->module->getLocalPath() . 'views/templates/admin/listOrderStatus.tpl'
        );

        $orderStatuses = Config::getPrintifyOrderStatuses();
        $nameStatus = '';

        foreach ($orderStatuses as $orderStatus) {
            if ($orderStatus['id'] == $idStatus) {
                $nameStatus = $orderStatus['name'];
            }
        }

        $tpl->assign(
            array(
                'id' => $idStatus,
                'name' => $nameStatus,
            )
        );

        return $tpl->fetch();
    }

    public function postProcess()
    {
        if (Tools::isSubmit('fulfillOrder') && Tools::getValue('id_order')) {
            $this->fulfillOrder(Tools::getValue('id_order'));
        }
        parent::postProcess();
    }

    public function fulfillOrder($idOrderPrintify)
    {
        /** @var OrderApi $orderApi */
        $orderApi = $this->moduleContainer->get('invertus.printify.api.order_api');
        /** @var PrintifyOrderResolver $orderResolver */
        $orderResolver = $this->moduleContainer->get('printify_order_resolver');
        /** @var Logger $logger */
        $logger = $this->moduleContainer->get('printify_logger');

        try {
            $orderApi->fulfillOrder($idOrderPrintify);
            $orderResolver->updateOrder($idOrderPrintify);
        } catch (Exception $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            if (isset($response->error)) {
                $this->errors[] = $response->error;
            } else {
                $this->errors[] = $response->errors->reason;
                if (!$e instanceof FailedToUpdateOrderException) {
                    $orderResolver->updateOrder($idOrderPrintify);
                }
            }
        }

        if (!empty($this->errors)) {
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_ORDER,
                sprintf('Failed to fullfill order id: %s, reason: %s', $idOrderPrintify, implode(',', $this->errors)),
                $idOrderPrintify
            );

            return;
        }

        $logger->log(
            Config::PRINTIFY_LOG_TYPE_ORDER,
            sprintf('Order with id: %s successfully fullfiled', $idOrderPrintify),
            $idOrderPrintify,
            Config::PRINTIFY_LOG_STATUS_SUCCESS
        );
    }
}
