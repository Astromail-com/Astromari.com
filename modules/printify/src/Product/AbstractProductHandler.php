<?php
//TODO NOTICE OF LICENSE

namespace Invertus\Printify\Product;

use Category;
use Invertus\Printify\Model\PublishDetails;
use Invertus\Printify\Repository\PrintifyAssociationRepository;
use Invertus\Printify\Repository\ProductRepository;
use PrestaShopDatabaseException;
use PrestaShopException;
use Product;
use Invertus\Printify\Model\PrintifyProduct as PrintifyProduct;
use StockAvailable;
use Tools;

/**
 * Holds common methods for product handler
 */
abstract class AbstractProductHandler
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
     * @param PrintifyAssociationRepository $printifyAssociationRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(
        PrintifyAssociationRepository $printifyAssociationRepository,
        ProductRepository $productRepository
    ) {
        $this->printifyAssociationRepository = $printifyAssociationRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param PrintifyProduct $printifyProduct
     * @param PublishDetails $publishDetails
     * @return Product
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    protected function createPrestaShopProduct(PrintifyProduct $printifyProduct, $publishDetails)
    {
        $product = new Product($this->productRepository->findProductByPrintifyId($printifyProduct->getId()));
        $category = Category::getRootCategory();
        $isNew = $product->id === null ? true : false;

        if ($publishDetails->isTitle()) {
            $product->name = $printifyProduct->getTitle();
            if ($isNew) {
                $product->link_rewrite = Tools::link_rewrite($printifyProduct->getTitle());
            }
        }

        if ($publishDetails->isDescription()) {
            $product->description = $printifyProduct->getDescription();
            $product->description_short = $printifyProduct->getShortDescription();

        }
        if ($isNew) {
            $product->id_category_default = $category->id;

        }
        $product->active = $printifyProduct->isVisible();

        $product->save();
        if ($isNew) {
            $product->addToCategories($category->id);
        }


        if ($isNew) {
            $this->printifyAssociationRepository->addPrintifyProductAssociation(
                $product->id,
                $printifyProduct->getId()
            );
        }

        StockAvailable::setProductOutOfStock($product->id, true);

        $this->printifyAssociationRepository->updatePrintInformation(
            $product->id,
            $printifyProduct->getPrintProviderId(),
            $printifyProduct->getBlueprintId()
        );

        return $product;
    }
}
