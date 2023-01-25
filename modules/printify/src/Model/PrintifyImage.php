<?php

namespace Invertus\Printify\Model;

use Invertus\Printify\Collection\Collection;
use Invertus\Printify\Collection\IdentifiableCollection;

/**
 * Printify product attribute image data model
 */
class PrintifyImage
{
    const POSITION_BACK = 'back';

    const POSITION_FRONT = 'front';

    /**
     * @var string
     */
    private $src;

    /**
     * @var IdentifiableCollection
     */
    private $combinations;

    /**
     * @var string
     */
    private $position;

    /**
     * @var bool
     */
    private $default;

    /**
     * @param string $src
     * @param IdentifiableCollection $combinations
     * @param string $position
     * @param bool $default
     *
     */
    public function __construct($src, IdentifiableCollection $combinations, $position, $default)
    {
        $this->src = $src;
        $this->combinations = $combinations;
        $this->position = $position !== self::POSITION_BACK && $position !== self::POSITION_FRONT ? null : $position;
        $this->default = $default;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @return Collection
     */
    public function getCombinations()
    {
        return $this->combinations;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->default;
    }
}
