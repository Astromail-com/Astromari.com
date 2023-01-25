<?php

namespace Invertus\Printify\Product;

use Invertus\Printify\Api\ProductApi;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Exception\ProductNotFoundException;
use Invertus\Printify\Repository\PrintifyAssociationRepository;
use Invertus\Printify\Service\Logger;
use PrestaShopDatabaseException;

/**
 * Handles product and printify associations deletions
 */
class PrintifyProductDeleteHandler
{
    /**
     * @var PrintifyAssociationRepository
     */
    private $printifyAssociationRepository;
    /**
     * @var ProductApi
     */
    private $productApi;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param PrintifyAssociationRepository $printifyAssociationRepository
     * @param ProductApi $productApi
     * @param Logger $logger
     */
    public function __construct($printifyAssociationRepository, $productApi, $logger)
    {
        $this->printifyAssociationRepository = $printifyAssociationRepository;
        $this->productApi = $productApi;
        $this->logger = $logger;
    }

    /**
     * @param $idProduct
     * @throws PrestaShopDatabaseException
     * @throws ProductNotFoundException
     */
    public function handle($idProduct)
    {
        if ($idProduct === null) {
            throw new ProductNotFoundException(sprintf('Product not found with printify id: %s', $idProduct));
        }

        $printifyAttributeAssociations = $this->printifyAssociationRepository->getAssociationIds($idProduct);

        $idPrintifyProduct = $this->printifyAssociationRepository->getPrintifyProductId($idProduct);

        try {
            $this->productApi->unpublish($idPrintifyProduct);
        } catch (\Exception $e) {
            $this->logger->log(
                Config::PRINTIFY_LOG_TYPE_PRODUCT,
                sprintf('Failed to delete product data id: %s, reason: %s', $idProduct, $e->getMessage()
                )
            );
        }

        $this->printifyAssociationRepository->deleteProductAssociation($idProduct);
        if (!empty($printifyAttributeAssociations)) {
            $this->printifyAssociationRepository->deleteProductAttributeAssociations($printifyAttributeAssociations);
        }
    }
}
