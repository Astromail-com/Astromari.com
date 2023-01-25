<?php

namespace Invertus\Printify\Model;

/**
 * Printify product option data model
 */
class PrintifyAttribute implements IdentifiableModelInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string|null
     */
    private $color;

    /**
     * @param int $id
     * @param string $title
     *
     */
    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     *
     * @return PrintifyAttribute
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }
}
