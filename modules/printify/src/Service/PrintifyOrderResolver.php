<?php

namespace Invertus\Printify\Service;

use Address;
use Country;
use Customer;
use Exception;
use Invertus\Printify\Api\OrderApi;
use Invertus\Printify\Builder\LineItemBuilder;
use Invertus\Printify\Collection\LineItemCollection;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Exception\FailedToSynchronizeOrderException;
use Invertus\Printify\Exception\FailedToUpdateOrderException;
use Invertus\Printify\Model\Api\PrintifyAddress;
use Invertus\Printify\Model\Api\PrintifyOrder;
use Invertus\Printify\Repository\PrintifyOrderRepository;
use Invertus\Printify\Repository\ProductRepository;
use Order;
use PrestaShopDatabaseException;
use PrestaShopException;
use State;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Invertus\Printify\Model\PrintifyOrder as PrintifyOrderModel;

class PrintifyOrderResolver
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var PrintifyOrderRepository
     */
    private $printifyOrderRepository;

    /**
     * @var LineItemBuilder
     */
    private $lineItemBuilder;

    /**
     * @var OrderApi
     */
    private $orderApi;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param ProductRepository $productRepository
     * @param PrintifyOrderRepository $printifyOrderRepository
     * @param LineItemBuilder $lineItemBuilder
     * @param OrderApi $orderApi
     */
    public function __construct(
        ProductRepository $productRepository,
        PrintifyOrderRepository $printifyOrderRepository,
        LineItemBuilder $lineItemBuilder,
        OrderApi $orderApi,
        Logger $logger
    ) {
        $this->productRepository = $productRepository;
        $this->printifyOrderRepository = $printifyOrderRepository;
        $this->lineItemBuilder = $lineItemBuilder;
        $this->orderApi = $orderApi;
        $this->logger = $logger;
    }

    /**
     * @param $price
     * @return float|int
     */
    private function convetFromCents($price)
    {
        return $price/100;
    }

    /**
     * @param $data
     * @return PrintifyOrderModel
     */
    private function buildOrder($data)
    {
        $data = json_decode($data);
        $printifyOrder = new PrintifyOrderModel();
        $printifyOrder->setIdPrintifyOrder($data->id);
        $printifyOrder->setReference($data->metadata->shop_order_id);
        $printifyOrder->setCustomer($data->address_to->first_name . ' ' . $data->address_to->last_name);
        $printifyOrder->setCreatedAt($data->created_at);
        $printifyOrder->setStatus($data->status);
        $printifyOrder->setTotalPaid($this->convetFromCents($data->total_price));

        return $printifyOrder;
    }

    /**
     * @param $idOrderPrintify
     * @throws FailedToUpdateOrderException
     */
    public function updateOrder($idOrderPrintify)
    {
        try {
            $data = $this->orderApi->getOrder($idOrderPrintify);
            $order = $this->buildOrder($data);
            $this->printifyOrderRepository->updateOrderFromObject($order);
            $psOrder = Order::getByReference($order->getReference())->getFirst();
            if ($psOrder) {
                $idOrderState = $this->printifyOrderRepository->getOrderStateId($order->getStatus());
                if ($idOrderState && $psOrder->current_state != $idOrderState) {
                    $orderHistory = new \OrderHistory();
                    $orderHistory->id_order_state = $idOrderState;
                    $orderHistory->id_order = $psOrder->id;
                    $orderHistory->save();
                    $psOrder->current_state = $idOrderState;
                    $psOrder->save();
                }
            }
        } catch (Exception $e) {
            throw new FailedToUpdateOrderException(
                sprintf('Failed to update printify order in prestashop with id: %s. Reason %s', $idOrderPrintify, $e->getMessage())
            );
        }
    }

    /**
     * @param Order $order
     * @throws FailedToSynchronizeOrderException
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function resolveOrder(Order $order)
    {
        $productData = $this->productRepository->getPrintifyProductsFromOrder($order->reference);
        if (count($productData) === 0) {
            return;
        }
        $lineItems = $this->lineItemBuilder->buildLineItems($productData);

        $printifyOrder = $this->formPrintifyOrder($order, $lineItems);

        $normalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter());
        $serializer = new Serializer([$normalizer], ['json' => new JsonEncoder()]);
        $serializedObject = $serializer->serialize($printifyOrder, 'json');

        try {
            $this->logger->log(
                Config::PRINTIFY_LOG_TYPE_ORDER_REQUEST,
                $serializedObject,
                null,
                Config::PRINTIFY_LOG_STATUS_SUCCESS
            );
            $result = $this->orderApi->submitOrder($serializedObject);
            $result = json_decode($result);
            $this->updateOrder($result->id);
        } catch (Exception $e) {
            throw new FailedToSynchronizeOrderException(
                sprintf('Order "%s" failed to synchronize. Reason: %s', $order->id, $e->getMessage())
            );
        }
    }

    /**
     * @param Order $order
     * @param LineItemCollection $lineItems
     * @return PrintifyOrder
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function formPrintifyOrder(Order $order, LineItemCollection $lineItems)
    {
        $address = new Address($order->id_address_delivery);
        $customer = new Customer($order->id_customer);
        $country = new Country($address->id_country);
        $region = '';
        if ($address->id_state) {
            $state = new State($address->id_state);
            $region = $state->iso_code;
        }
        $printifyAddress = new PrintifyAddress(
            $address->firstname,
            $address->lastname,
            $customer->email,
            $address->phone,
            $country->iso_code,
            $region,
            $address->address1,
            $address->address2,
            $address->city,
            $address->postcode
        );

        return new PrintifyOrder(
            (string) $order->reference,
            $lineItems,
            $printifyAddress
        );
    }
}
