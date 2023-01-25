<?php

namespace Invertus\Printify\Product;

use Exception;
use Image;
use Invertus\Printify\Collection\Collection;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Image\ImageCopier;
use Invertus\Printify\Model\PrintifyImage;
use Invertus\Printify\Model\PrintifyProductAttributeCombination;
use Invertus\Printify\Repository\PrintifyAssociationRepository;
use Invertus\Printify\Repository\ProductRepository;
use Invertus\Printify\Service\Logger;
use PrestaShopDatabaseException;
use PrestaShopException;
use Product;

/**
 * Handles product attribute images addition, updates and download
 */
class ProductImageHandler
{
    /**
     * @var ImageCopier
     */
    private $imageCopier;

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
     * @param ImageCopier $imageCopier
     * @param PrintifyAssociationRepository $printifyAssociationRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ImageCopier $imageCopier,
        PrintifyAssociationRepository $printifyAssociationRepository,
        ProductRepository $productRepository,
        Logger $logger
    ) {
        $this->imageCopier = $imageCopier;
        $this->printifyAssociationRepository = $printifyAssociationRepository;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
    }

    /**
     * @param Product $product
     * @param Collection $images
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function handle(Product $product, Collection $images)
    {
        $product->deleteImages();

        /** @var PrintifyImage $image */
        foreach ($images as $image) {
            try {
                $imageObject = $this->copyImage((int)$product->id, $image->getSrc());
            } catch (Exception $e) {
                $this->logger->log(
                    Config::PRINTIFY_LOG_TYPE_IMAGE,
                    sprintf(
                        'Image %s has an error',
                        $image->getSrc()
                    )

                );
                throw $e;
            }

            /** @var PrintifyProductAttributeCombination $combination */
            foreach ($image->getCombinations() as $combination) {
                if ($image->isDefault() && $combination->isDefault()) {
                    $imageObject->cover = 1;
                    $imageObject->save();
                }

                $this->addProductAttributeImage($combination->getId(), (int) $imageObject->id, $product->id);
            }
        }
    }

    /**
     * @param int $productId
     * @param string $imageUrl
     * @return Image
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function copyImage($productId, $imageUrl)
    {
        $image = new Image();
        $image->id_product = $productId;
        $image->cover = 0;
        $image->save();

        $this->imageCopier->copyImg($productId, $image->id, $imageUrl);

        return $image;
    }

    /**
     * @param int $printifyCombinationId
     * @param int $imageId
     * @throws PrestaShopDatabaseException
     */
    private function addProductAttributeImage($printifyCombinationId, $imageId, $productId)
    {
        $result = $this->printifyAssociationRepository->getPrintifyProductAttribute($printifyCombinationId, $productId);

        if (!$result) {
            return;
        }

        $this->productRepository->addProductAttributeImage($result, $imageId);
    }
}
