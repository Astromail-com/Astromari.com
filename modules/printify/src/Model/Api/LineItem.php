<?php

namespace Invertus\Printify\Model\Api;

class LineItem
{
    /**
     * @var string
     */
    private $productId;

    /**
     * @var int
     */
    private $variantId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @return string
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     * @return LineItem
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @return int
     */
    public function getVariantId()
    {
        return $this->variantId;
    }

    /**
     * @param int $variantId
     * @return LineItem
     */
    public function setVariantId($variantId)
    {
        $this->variantId = $variantId;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return LineItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function toArray()
    {
        return array(
            'product_id' => $this->getProductId(),
            'variant_id' => $this->getVariantId(),
            'quantity' => $this->getQuantity()
        );
    }
}
