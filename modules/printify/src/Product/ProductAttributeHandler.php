<?php

namespace Invertus\Printify\Product;

use Attribute;
use AttributeGroup;
use Configuration;
use Invertus\Printify\Collection\Collection;
use Invertus\Printify\Model\PrintifyAttribute;
use Invertus\Printify\Model\PrintifyAttributeGroup;
use Invertus\Printify\Repository\PrintifyAssociationRepository;
use Invertus\Printify\Repository\ProductRepository;
use PrestaShopDatabaseException;
use PrestaShopException;

/**
 * Handles product attribute addition an updates
 */
class ProductAttributeHandler
{
    /**
     * @var PrintifyAssociationRepository
     */
    private $printifyAssociationRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var int
     */
    private $defaultLangId;

    /**
     * @param PrintifyAssociationRepository $printifyAssociationRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(
        PrintifyAssociationRepository $printifyAssociationRepository,
        ProductRepository $productRepository
    ) {
        $this->printifyAssociationRepository = $printifyAssociationRepository;
        $this->productRepository = $productRepository;
        $this->defaultLangId = $defaultLang = (int) Configuration::get('PS_LANG_DEFAULT');
    }

    /**
     * @param Collection $printifyAttributeGroups
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function handle(Collection $printifyAttributeGroups)
    {
        /** @var PrintifyAttributeGroup $group */
        foreach ($printifyAttributeGroups as $group) {
            $attributeGroupId = $this->addAttributeGroup($group->getName(), $group->getType());

            /** @var PrintifyAttribute $option */
            foreach ($group->getAttributes() as $attribute) {
                $this->addAttribute($attribute, $attributeGroupId);
            }
        }
    }

    /**
     * @param string $name
     * @param string $type
     * @return int
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function addAttributeGroup($name, $type)
    {
        $groupId = $this->productRepository->getExistingAttributeGroupId($name);

        if (!$groupId) {
            $groupId = $this->addPrintifyAttributeGroup($name, $type);
        }

        return $groupId;
    }

    /**
     * @param string $name
     * @param string $type
     * @return int
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function addPrintifyAttributeGroup($name, $type)
    {
        $attributeGroup = new AttributeGroup();

        $attributeGroup->name = [$this->defaultLangId => $name];
        $attributeGroup->group_type = $type;
        $attributeGroup->public_name = [$this->defaultLangId => $name];

        $attributeGroup->add();

        return $attributeGroup->id;
    }

    /**
     * @param PrintifyAttribute $printifyAttribute
     * @param int $groupId
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function addAttribute(PrintifyAttribute $printifyAttribute, $groupId)
    {
        $attributeId = $this->printifyAssociationRepository->getAttributeByName(
            $this->defaultLangId,
            $printifyAttribute->getTitle(),
            $groupId
        );

        if (!$attributeId) {
            $attributeId = $this->addPrestaShopAttribute($printifyAttribute, $groupId);
        }

        $this->printifyAssociationRepository->addPrintifyAttributeAssociation(
            $attributeId,
            $printifyAttribute->getId()
        );
    }

    /**
     * @param PrintifyAttribute $printifyAttribute
     * @param $groupId
     * @return int
     * @throws PrestaShopException
     */
    private function addPrestaShopAttribute(PrintifyAttribute $printifyAttribute, $groupId)
    {
        $attributeId = $this->printifyAssociationRepository->getPrintifyAssociation($printifyAttribute->getId());
        $attribute = new Attribute($attributeId);

        $attribute->name = [$this->defaultLangId => $printifyAttribute->getTitle()];
        $attribute->id_attribute_group = $groupId;

        if (null !== $printifyAttribute->getColor()) {
            $attribute->color = $printifyAttribute->getColor();
        }

        $attribute->save();

        return $attribute->id;
    }
}
