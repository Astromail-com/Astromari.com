<?php

namespace Invertus\Printify\Product;

use Invertus\Printify\Exception\CannotDeleteProductException;
use Invertus\Printify\Exception\ProductNotFoundException;
use Invertus\Printify\Repository\PrintifyAssociationRepository;
use Invertus\Printify\Repository\ProductRepository;
use PrestaShopDatabaseException;
use PrestaShopException;
use Product;

/**
 * Handles product and printify associations deletions
 */
class ProductDeleteHandler
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var PrintifyAssociationRepository
     */
    private $printifyAssociationRepository;

    /**
     * @param ProductRepository $productRepository
     * @param PrintifyAssociationRepository $printifyAssociationRepository
     *
     */
    public function __construct($productRepository, $printifyAssociationRepository)
    {
        $this->productRepository = $productRepository;
        $this->printifyAssociationRepository = $printifyAssociationRepository;
    }

    /**
     * @param string $printifyProductId
     * @throws CannotDeleteProductException
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     * @throws ProductNotFoundException
     */
    public function handle($printifyProductId)
    {
        $productId = $this->productRepository->findProductByPrintifyId($printifyProductId);

        $product = new Product($productId);

        if ($product->id === null) {
            throw new ProductNotFoundException(sprintf('Product not found with printify id: %s', $printifyProductId));
        }

        $printifyAttributeAssociations = $this->printifyAssociationRepository->getAssociationIds($product->id);

        if (!$product->delete()) {
            throw new CannotDeleteProductException(
                sprintf(
                    'Failed to delete product PrestaShop id: %s, Printify id: %s',
                    $productId,
                    $printifyProductId
                )
            );
        }

        $this->printifyAssociationRepository->deleteProductAssociation($product->id);
        if (!empty($printifyAttributeAssociations)) {
            $this->printifyAssociationRepository->deleteProductAttributeAssociations($printifyAttributeAssociations);
        }    }
}
