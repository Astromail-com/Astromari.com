<?php

namespace Invertus\Printify\Product;

use Combination;
use Invertus\Printify\Collection\IdentifiableCollection;
use Invertus\Printify\Model\PrintifyAttribute;
use Invertus\Printify\Model\PrintifyProductAttributeCombination;
use Invertus\Printify\Repository\PrintifyAssociationRepository;
use Invertus\Printify\Repository\ProductRepository;
use Invertus\Printify\Service\Logger;
use PrestaShopDatabaseException;
use PrestaShopException;
use Product;
use StockAvailable;

/**
 * Handles product attribute combinations addition an updates
 */
class ProductCombinationHandler
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
     * @var Logger
     */
    private $logger;

    /**
     * @param PrintifyAssociationRepository $printifyAssociationRepository
     * @param ProductRepository $productRepository
     * @param Logger $logger
     */
    public function __construct(
        PrintifyAssociationRepository $printifyAssociationRepository,
        ProductRepository $productRepository,
        Logger $logger
    ) {
        $this->printifyAssociationRepository = $printifyAssociationRepository;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
    }

    /**
     * @param Product $product
     * @param IdentifiableCollection $combinations
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function handle(Product $product, IdentifiableCollection $combinations)
    {
        $lowestPriceCombination = $this->getLowestPriceFromCombinations($combinations);

        $this->updateProductPricing($product, $lowestPriceCombination);
        $this->productRepository->resetDefaultCombination($product->id);
        /** @var PrintifyProductAttributeCombination $combination */
        foreach ($combinations as $combination) {
            $this->handleProductAttributeCombination($product, $combination, $lowestPriceCombination->getPrice());
        }
    }


    /**
     * @param Product $product
     * @param PrintifyProductAttributeCombination $combination
     * @param int $lowestPrice
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function handleProductAttributeCombination(
        Product $product,
        PrintifyProductAttributeCombination $combination,
        $lowestPrice
    ) {
        $result = $this->printifyAssociationRepository->getPrintifyProductAttribute($combination->getId(), $product->id);

        if (!$combination->isEnabled()) {
            $combinationForDeletion = new Combination($result);
            if ($combinationForDeletion->id_product) {
                $product->deleteAttributeCombination((int) $result);
            }
            $this->printifyAssociationRepository->deletePrintifyProductAttribute($combination->getId(), $product->id);

            return;
        }
        $productAttributeId = !$result ?
            $this->createCombination($product, $combination, $lowestPrice) :
            $this->updateCombination($combination, (int) $result, $lowestPrice);

        StockAvailable::setProductOutOfStock($product->id, true, null, $productAttributeId);

        if ($combination->isDefault()) {
            $product->weight = $combination->getWeight();
            $product->reference = $combination->getSku();

            $product->save();
        }

        /** @var PrintifyAttribute $attribute */
        foreach ($combination->getAttributes() as $attribute) {
            $attributeId = $this->printifyAssociationRepository->getPrintifyAssociation($attribute->getId());

            if (!$attributeId) {
                continue;
            }

            $this->productRepository->addProductAttributeCombination($productAttributeId, $attributeId);
        }
    }

    /**
     * @param PrintifyProductAttributeCombination $attribute
     * @param int $combinationId
     * @param int  $lowestPrice
     * @return mixed
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function updateCombination(PrintifyProductAttributeCombination $attribute, $combinationId, $lowestPrice)
    {
        $productAttribute = new Combination($combinationId);

        $productAttribute->weight = $attribute->getWeight();
        $productAttribute->wholesale_price = $attribute->getCost();
        $productAttribute->price = round($attribute->getPrice() - $lowestPrice, 8);
        $productAttribute->reference = $attribute->getSku();
        $productAttribute->default_on = $attribute->isDefault();
        $productAttribute->ean13 = '';
        $productAttribute->quantity = PrintifyProductAttributeCombination::DEFAULT_QUANTITY;
        $productAttribute->ecotax = 0.0;
        $productAttribute->unit_price_impact = 0.0;
        $productAttribute->update();

        return $combinationId;
    }

    /**
     * @param Product $prestaShopProduct
     * @param PrintifyProductAttributeCombination $attribute
     * @param int $lowestPrice
     * @return bool|mixed
     * @throws PrestaShopDatabaseException
     */
    private function createCombination(
        Product $prestaShopProduct,
        PrintifyProductAttributeCombination $attribute,
        $lowestPrice
    ) {
        $productAttributeId = $prestaShopProduct->addCombinationEntity(
            $attribute->getCost(),
            round($attribute->getPrice() - $lowestPrice, 8),
            $attribute->getWeight(),
            0.0,
            0.0,
            PrintifyProductAttributeCombination::DEFAULT_QUANTITY,
            null,
            $attribute->getSku(),
            0,
            '',
            $attribute->isDefault()
        );

        $this->printifyAssociationRepository->addPrintifyProductAttributeAssociation(
            $productAttributeId,
            $attribute->getId(),
            $prestaShopProduct->id
        );

        return $productAttributeId;
    }

    /**
     * @param IdentifiableCollection $combinations
     * @return PrintifyProductAttributeCombination
     */
    private function getLowestPriceFromCombinations(IdentifiableCollection $combinations)
    {
        $collection = $combinations->getCollection();

        /** @var PrintifyProductAttributeCombination $lowestPriceCombination */
        $lowestPriceCombination = array_reduce($collection, function(
            PrintifyProductAttributeCombination $a,
            PrintifyProductAttributeCombination $b
        ) {
            return $a->getPrice() < $b->getPrice() ? $a : $b;
        }, array_shift($collection));

        return $lowestPriceCombination;
    }

    /**
     * @param Product $product
     * @param PrintifyProductAttributeCombination $lowestPriceCombination
     * @throws PrestaShopException
     */
    private function updateProductPricing(Product $product, PrintifyProductAttributeCombination $lowestPriceCombination)
    {
        $product->price = round($lowestPriceCombination->getPrice(), 8);
        $product->wholesale_price = round($lowestPriceCombination->getCost(), 8);

        $product->save();
    }
}
