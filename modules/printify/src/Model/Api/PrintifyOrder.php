<?php

namespace Invertus\Printify\Model\Api;

use Invertus\Printify\Collection\LineItemCollection;

class PrintifyOrder
{
    /**
     * @var string
     */
    private $externalId;

    /**
     * @var LineItemCollection
     */
    private $lineItems;

    /**
     * @var PrintifyAddress
     */
    private $addressTo;

    /**
     * @var int
     */
    private $shippingMethod = 1;

    /**
     * @var bool
     */
    private $sendShippingNotification = false;

    /**
     * @param string $externalId
     * @param LineItemCollection $lineItems
     * @param PrintifyAddress $addressTo
     *
     */
    public function __construct(
        $externalId,
        LineItemCollection $lineItems,
        PrintifyAddress $addressTo
    ) {
        $this->externalId = $externalId;
        $this->lineItems = $lineItems;
        $this->addressTo = $addressTo;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @return LineItemCollection
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * @return PrintifyAddress
     */
    public function getAddressTo()
    {
        return $this->addressTo;
    }

    /**
     * @return int
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @return bool
     */
    public function isSendShippingNotification()
    {
        return $this->sendShippingNotification;
    }

    /**
     * @param int $shippingMethod
     * @return PrintifyOrder
     */
    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
    }

    /**
     * @param bool $sendShippingNotification
     * @return PrintifyOrder
     */
    public function setSendShippingNotification($sendShippingNotification)
    {
        $this->sendShippingNotification = $sendShippingNotification;

        return $this;
    }
}
