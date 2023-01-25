<?php

namespace Invertus\Printify\Product;

use Invertus\Printify\Exception\InvalidJsonStringException;
use Invertus\Printify\Model\PublishDetails;
use Invertus\Printify\Repository\PrintifyAssociationRepository;
use Invertus\Printify\Repository\ProductRepository;
use Invertus\Printify\Service\PrintifyProductJsonParser;
use PrestaShopDatabaseException;
use PrestaShopException;
use Product;

/**
 * Handles product json from printify to associate given data to product object
 */
class ProductHandler extends AbstractProductHandler
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
     * @var ProductAttributeHandler
     */
    private $attributeHandler;

    /**
     * @var ProductCombinationHandler
     */
    private $combinationHandler;

    /**
     * @var ProductImageHandler
     */
    private $imageHandler;

    /**
     * @param PrintifyAssociationRepository $printifyAssociationRepository
     * @param ProductRepository $productRepository
     * @param ProductAttributeHandler $attributeHandler
     * @param ProductCombinationHandler $combinationHandler
     * @param ProductImageHandler $imageHandler
     */
    public function __construct(
        PrintifyAssociationRepository $printifyAssociationRepository,
        ProductRepository $productRepository,
        ProductAttributeHandler $attributeHandler,
        ProductCombinationHandler $combinationHandler,
        ProductImageHandler $imageHandler
    ) {
        parent::__construct($printifyAssociationRepository, $productRepository);

        $this->printifyAssociationRepository = $printifyAssociationRepository;
        $this->productRepository = $productRepository;
        $this->attributeHandler = $attributeHandler;
        $this->combinationHandler = $combinationHandler;
        $this->imageHandler = $imageHandler;
    }

    /**
     * @param string $json
     * @param PublishDetails $publishDetails
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     * @throws InvalidJsonStringException
     * @return int
     */
    public function handle($json, $publishDetails)
    {
        $parser = new PrintifyProductJsonParser($json);

        $printifyProduct = $parser->getProduct();

        /**
         * In case it's a new product we should import everything.
         */
        $existingProduct = new Product($this->productRepository->findProductByPrintifyId($printifyProduct->getId()));
        $isNew = $existingProduct->id === null;
        if ($isNew) {
            $publishDetails = new PublishDetails();
            $publishDetails->setVariants(true);
            $publishDetails->setTitle(true);
            $publishDetails->setImages(true);
            $publishDetails->setDescription(true);
            $publishDetails->setTags(true);
        }

        $product = $this->createPrestaShopProduct($printifyProduct, $publishDetails);
        if ($publishDetails->isVariants()) {
            $this->attributeHandler->handle($printifyProduct->getAttributeGroups());
            $this->combinationHandler->handle($product, $printifyProduct->getAttributeCombinations());
        }

        if ($publishDetails->isImages()) {
            $this->imageHandler->handle($product, $printifyProduct->getImages());

        }


        return $product->id;
    }
}
