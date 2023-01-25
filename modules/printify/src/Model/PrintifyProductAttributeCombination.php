<?php

namespace Invertus\Printify\Model;

use Invertus\Printify\Collection\IdentifiableCollection;

/**
 * Printify product attribute data model
 */
class PrintifyProductAttributeCombination implements IdentifiableModelInterface
{
    const DEFAULT_QUANTITY = 0;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var int
     */
    private $cost;

    /**
     * @var int
     */
    private $price;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $weight;

    /**
     * @var bool
     */
    private $inStock;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var bool
     */
    private $default;

    /**
     * @var IdentifiableCollection
     */
    private $attributes;

    /**
     * @param int $id
     * @param string $sku
     * @param int $cost
     * @param int $price
     * @param string $title
     * @param int $weight
     * @param bool $inStock
     * @param bool $enabled
     * @param bool $default
     * @param IdentifiableCollection $attributes
     */
    public function __construct(
        $id,
        $sku,
        $cost,
        $price,
        $title,
        $weight,
        $inStock,
        $enabled,
        $default,
        IdentifiableCollection $attributes
    ) {
        $this->id = $id;
        $this->sku = $sku;
        $this->cost = $cost / 100;
        $this->price = $price / 100;
        $this->title = $title;
        $this->weight = $weight / 1000;
        $this->inStock = $inStock;
        $this->enabled = $enabled;
        $this->default = $default;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return bool
     */
    public function isInStock()
    {
        return $this->inStock;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * @return IdentifiableCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
