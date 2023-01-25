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
class AttributeDeleteHandler
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
     * @param Logger $logger
     */
    public function __construct($printifyAssociationRepository, $logger)
    {
        $this->printifyAssociationRepository = $printifyAssociationRepository;
        $this->logger = $logger;
    }

    /**
     * @param $idProductAttribute
     * @throws ProductNotFoundException
     */
    public function handle($idAttribute)
    {
        if ($idAttribute === null) {
            return;
        }

        try {
            $this->printifyAssociationRepository->deleteAttributeAssociations([$idAttribute]);
        } catch (\Exception $e) {
            $this->logger->log(
                Config::PRINTIFY_LOG_TYPE_PRODUCT,
                sprintf('Failed to delete attribute data id: %s, reason: %s', $idAttribute, $e->getMessage()
                )
            );
        }
    }
}
