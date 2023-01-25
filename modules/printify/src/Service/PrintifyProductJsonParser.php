<?php

namespace Invertus\Printify\Service;

use Invertus\Printify\Collection\Collection;
use Invertus\Printify\Collection\IdentifiableCollection;
use Invertus\Printify\Exception\InvalidJsonStringException;
use Invertus\Printify\Model\PrintifyImage;
use Invertus\Printify\Model\PrintifyAttribute;
use Invertus\Printify\Model\PrintifyAttributeGroup;
use Invertus\Printify\Model\PrintifyProduct;
use Invertus\Printify\Model\PrintifyProductAttributeCombination;

/**
 * Handles and validates json string and fills product models with its data
 */
class PrintifyProductJsonParser extends AbstractJsonParser
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param $json
     *
     * @throws InvalidJsonStringException
     */
    public function __construct($json)
    {
        $this->data = $this->decodeJson($json);
    }

    /**
     * @return PrintifyProduct
     * @throws InvalidJsonStringException
     */
    public function getProduct()
    {
        $product = new PrintifyProduct(
            $this->getValueOrNull($this->data, 'id', true),
            $this->getValueOrNull($this->data, 'title', true),
            $this->getValueOrNull($this->data, 'description', true),
            $this->getValueOrNull($this->data, 'user_id', true),
            $this->getValueOrNull($this->data, 'shop_id', true),
            $this->getValueOrNull($this->data, 'print_provider_id', true),
            $this->getValueOrNull($this->data, 'blueprint_id', true),
            $this->getAttributeGroups(),
            $this->getAttributeCombinations(),
            $this->getImages()
        );

        if (!empty($this->getValueOrEmptyArray($this->data, 'tags'))) {
            $product->setTags($this->getValueOrEmptyArray($this->data, 'tags'));
        }

        if (null !== $this->getValueOrNull($this->data, 'visible')) {
            $product->setVisible($this->getBool($this->data, 'visible'));
        }

        if (null !== $this->getValueOrNull($this->data, 'is_locked')) {
            $product->setLocked($this->getBool($this->data, 'is_locked'));
        }

        return $product;
    }

    /**
     * @return Collection
     * @throws InvalidJsonStringException
     */
    private function getAttributeGroups()
    {
        $attributeGroupsCollection = new Collection();

        foreach ($this->getValueOrEmptyArray($this->data, 'options') as $attributeGroup) {
            $attributesCollection = $this->fillAttributesCollection(
                new IdentifiableCollection(),
                $this->getValueOrEmptyArray($attributeGroup, 'values')
            );

            $prinitifyAttributeGroup = new PrintifyAttributeGroup(
                $this->getValueOrNull($attributeGroup, 'name', true),
                $this->getValueOrNull($attributeGroup, 'type', true),
                $attributesCollection
            );

            $attributeGroupsCollection->add($prinitifyAttributeGroup);
        }

        return $attributeGroupsCollection;
    }

    /**
     * @return IdentifiableCollection
     * @throws InvalidJsonStringException
     */
    private function getAttributeCombinations()
    {
        $attributes = $this->getAttributes();
        $variantsCollection = new IdentifiableCollection();

        foreach ($this->getValueOrEmptyArray($this->data, 'variants') as $combination) {
            $combinationAttributesCollections = new IdentifiableCollection();
            $invalidCombination = false;
            foreach ($this->getValueOrEmptyArray($combination, 'options') as $combinationAttribute) {
                if (!$attributes->get((int) $combinationAttribute)) {
                    $invalidCombination = true;
                    break;
                }
                $combinationAttributesCollections->add($attributes->get((int) $combinationAttribute));
            }
            if ($invalidCombination) {
                continue;
            }

            $productAttributeCombination = new PrintifyProductAttributeCombination(
                (int) $this->getValueOrNull($combination, 'id', true),
                $this->getValueOrNull($combination, 'sku', true),
                (int) $this->getValueOrNull($combination, 'cost', true),
                (int) $this->getValueOrNull($combination, 'price', true),
                $this->getValueOrNull($combination, 'title', true),
                (int) $this->getValueOrNull($combination, 'grams', true),
                (bool) $this->getBool($combination, 'in_stock'),
                (bool) $this->getBool($combination, 'is_enabled'),
                (bool) $this->getBool($combination, 'is_default'),
                $combinationAttributesCollections
            );

            $variantsCollection->add($productAttributeCombination);
        }

        return $variantsCollection;
    }

    /**
     * @return Collection
     * @throws InvalidJsonStringException
     */
    private function getImages()
    {
        $imagesCollection = new Collection();

        foreach ($this->getValueOrEmptyArray($this->data, 'images') as $image) {
            $combinations = $this->getAttributeCombinations();
            $imageCombinations = new IdentifiableCollection();

            foreach ($image['variant_ids'] as $id) {
                $variant = $combinations->get((int) $id);
                if (null !== $variant && $variant->isEnabled()) {
                    $imageCombinations->add($variant);
                }
            }
            if (empty($imageCombinations->getCollection())) {
                continue;
            }

            $imageModel = new PrintifyImage(
                $this->getValueOrNull($image, 'src', true),
                $imageCombinations,
                $this->getValueOrNull($image, 'position'),
                $this->getBool($image, 'is_default')
            );

            $imagesCollection->add($imageModel);
        }

        return $imagesCollection;
    }

    /**
     * @return IdentifiableCollection
     * @throws InvalidJsonStringException
     */
    private function getAttributes()
    {
        $attributesCollection = new IdentifiableCollection();

        foreach ($this->getValueOrEmptyArray($this->data, 'options') as $attributeGroup) {
            $this->fillAttributesCollection(
                $attributesCollection,
                $this->getValueOrEmptyArray($attributeGroup, 'values')
            );
        }

        return $attributesCollection;
    }

    /**
     * @param IdentifiableCollection $attributesCollection
     * @param $attributes
     * @return IdentifiableCollection
     * @throws InvalidJsonStringException
     */
    private function fillAttributesCollection(IdentifiableCollection $attributesCollection, $attributes)
    {
        foreach ($attributes as $attribute) {
            $printifyAttribute = new PrintifyAttribute(
                $this->getValueOrNull($attribute, 'id', true),
                $this->getValueOrNull($attribute, 'title', true)
            );

            $colors = $this->getValueOrEmptyArray($attribute, 'colors');

            if (!empty($colors)) {
                $printifyAttribute->setColor($colors[0]);
            }

            $attributesCollection->add($printifyAttribute);
        }

        return $attributesCollection;
    }
}
