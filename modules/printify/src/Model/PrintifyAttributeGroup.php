<?php

namespace Invertus\Printify\Model;

use Invertus\Printify\Collection\Collection;
use Invertus\Printify\Collection\IdentifiableCollection;

/**
 * Printify product option group data model
 */
class PrintifyAttributeGroup
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var Collection
     */
    private $attributes;

    /**
     * @param string $name
     * @param string $type
     * @param IdentifiableCollection $attributes
     */
    public function __construct($name, $type, IdentifiableCollection $attributes)
    {
        $this->name = $name;
        $this->type = $type !== 'color' ? 'select' : $type;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
