<?php

namespace Invertus\Printify\Model;

class PrintifyOrder
{
    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $id_printify_order;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $customer;

    /**
     * @var string
     */
    private $total_paid;

    /**
     * @var string
     */
    private $status;

    /**
     * @return string
     */
    public function getIdPrintifyOrder()
    {
        return $this->id_printify_order;
    }

    /**
     * @param string $id_printify_order
     */
    public function setIdPrintifyOrder($id_printify_order)
    {
        $this->id_printify_order = $id_printify_order;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return string
     */
    public function getTotalPaid()
    {
        return $this->total_paid;
    }

    /**
     * @param string $total_paid
     */
    public function setTotalPaid($total_paid)
    {
        $this->total_paid = $total_paid;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }
}
