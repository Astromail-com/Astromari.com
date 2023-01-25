<?php

namespace Invertus\Printify\Model;

use Invertus\Printify\Collection\Collection;
use Invertus\Printify\Collection\IdentifiableCollection;

/**
 * Printify product data model
 */
class PrintifyProduct implements IdentifiableModelInterface
{
    const SHORT_DESCRIPTION_LENGTH = 800;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var int
     */
    private $shopId;

    /**
     * @var int
     */
    private $printProviderId;

    /**
     * @var int
     */
    private $blueprintId;

    /**
     * @var Collection
     */
    private $attributeGroups;

    /**
     * @var IdentifiableCollection
     */
    private $attributeCombinations;

    /**
     * @var Collection
     */
    private $images;

    /**
     * @var string[]
     */
    private $tags = [];

    /**
     * @var bool
     */
    private $visible = false;

    /**
     * @var bool
     */
    private $locked = false;

    /**
     * @param string $id
     * @param string $title
     * @param string $description
     * @param int $userId
     * @param int $shopId
     * @param int $printProviderId
     * @param int $blueprintId
     * @param Collection $attributeGroups
     * @param IdentifiableCollection $attributeCombinations
     * @param Collection $images
     */
    public function __construct(
        $id,
        $title,
        $description,
        $userId,
        $shopId,
        $printProviderId,
        $blueprintId,
        $attributeGroups,
        $attributeCombinations,
        $images
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->userId = $userId;
        $this->shopId = $shopId;
        $this->printProviderId = $printProviderId;
        $this->blueprintId = $blueprintId;
        $this->attributeGroups = $attributeGroups;
        $this->attributeCombinations = $attributeCombinations;
        $this->images = $images;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return strlen($this->getDescription()) <= self::SHORT_DESCRIPTION_LENGTH ?
            $this->getDescription() :
            implode(', ', $this->getTags());
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @return int
     */
    public function getPrintProviderId()
    {
        return $this->printProviderId;
    }

    /**
     * @return int
     */
    public function getBlueprintId()
    {
        return $this->blueprintId;
    }

    /**
     * @return string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @return bool
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * @return Collection
     */
    public function getAttributeGroups()
    {
        return $this->attributeGroups;
    }

    /**
     * @return IdentifiableCollection
     */
    public function getAttributeCombinations()
    {
        return $this->attributeCombinations;
    }

    /**
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param string[] $tags
     * @return PrintifyProduct
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param bool $visible
     * @return PrintifyProduct
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @param bool $locked
     * @return PrintifyProduct
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }


}
