<?php

use Invertus\Printify\Api\ProductApi;
use Invertus\Printify\Config\Config;
use Invertus\Printify\Model\PublishDetails;
use Invertus\Printify\Product\ProductDeleteHandler;
use Invertus\Printify\Product\ProductHandler;
use Invertus\Printify\Product\ProductPrintProviderHandler;
use Invertus\Printify\Service\Logger;

class PrintifyProductEventsModuleFrontController extends ModuleFrontController
{
    /**
     * @throws PrestaShopException
     */
    public function postProcess()
    {
        $container = $this->module->getModuleContainer();

        $data = file_get_contents("php://input");
        /** @var Logger $logger */
        $logger = $container->get('printify_logger');
        $logger->log(
            Config::PRINTIFY_LOG_TYPE_PRODUCT_DATA,
            $data,
            null,
            Config::PRINTIFY_LOG_STATUS_LOG
        );
        $data = json_decode($data);
        if (empty($data) || !isset($data->resource->data)) {
            $this->ajaxDie('No data');
        }

        if ($data->resource->type == 'product') {
            if ($data->resource->data->action == 'create') {
                $this->eventCreateProduct($data->resource->id, $this->adaptPublishDetails($data->resource->data->publish_details));
            }
            if ($data->resource->data->action == 'update') {
                $this->eventCreateProduct($data->resource->id, $this->adaptPublishDetails($data->resource->data->publish_details));
            }
            if ($data->resource->data->action == 'delete') {
                $this->eventDeleteProduct($data->resource->id);
            }
        }

        $this->ajaxDie('');
    }

    public function adaptPublishDetails($publishDetailsPrintify)
    {
        $publishDetails = new PublishDetails();

        $publishDetails->setTitle((bool)$publishDetailsPrintify->title);
        $publishDetails->setVariants((bool)$publishDetailsPrintify->variants);
        $publishDetails->setDescription((bool)$publishDetailsPrintify->description);
        $publishDetails->setTags((bool)$publishDetailsPrintify->tags);
        $publishDetails->setImages((bool)$publishDetailsPrintify->images);
        return $publishDetails;

    }

    /**
     * @param $idProduct
     * @param PublishDetails
     * @throws PrestaShopException
     */
    private function eventCreateProduct($idProduct, $publishDetails)
    {
        $container = $this->module->getModuleContainer();

        /** @var ProductApi $productApi */
        $productApi = $container->get('invertus.printify.product_api');

        /** @var ProductHandler $handler */
        $handler = $container->get('product_data_handler');

        /** @var ProductPrintProviderHandler $printProviderHandler */
        $printProviderHandler = $container->get('print_provider_data_handler');

        $productData = $productApi->getProduct($idProduct);

        /** @var Logger $logger */
        $logger = $container->get('printify_logger');
        try {
            $idProductPs = $handler->handle($productData, $publishDetails);
            $printProviderHandler->handle($idProduct);
        } catch (Exception $e) {
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_PRODUCT,
                sprintf('Failed to sync product id: %s, reason: %s', $idProduct, $e->getMessage()),
                $idProduct
            );
            $productApi->publishFailure($idProduct, $e->getMessage());

            return;
        }

        $product = new Product($idProductPs);
        $path = $this->context->link->getProductLink($product);

        $logger->log(
            Config::PRINTIFY_LOG_TYPE_PRODUCT,
            sprintf('Product with id: %s successfully synced', $idProduct),
            $idProduct,
            Config::PRINTIFY_LOG_STATUS_SUCCESS
        );

        try {
            $productApi->publishSuccess($idProduct, $idProductPs, $path);
        } catch (Exception $e) {
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_PRODUCT,
                sprintf('Failed to publish success product id: %s, reason: %s', $idProduct, $e->getMessage()),
                $idProduct
            );
            $productApi->publishFailure($idProduct, $e->getMessage());

            return;
        }
    }

    /**
     * @param $idProduct
     * @return bool
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    private function eventDeleteProduct($idProduct)
    {
        $container = $this->module->getModuleContainer();

        /** @var ProductDeleteHandler $handler */
        $handler = $container->get('product_delete_handler');

        /** @var Logger $logger */
        $logger = $container->get('printify_logger');

        try {
            $handler->handle($idProduct);
        } catch (Exception $e) {
            $logger->log(
                Config::PRINTIFY_LOG_TYPE_PRODUCT,
                sprintf('Failed to delete product id: %s, reason: %s', $idProduct, $e->getMessage()),
                $idProduct
            );

            return false;
        }

        $logger->log(
            Config::PRINTIFY_LOG_TYPE_PRODUCT,
            sprintf('Product with id: %s successfully deleted', $idProduct),
            $idProduct,
            Config::PRINTIFY_LOG_STATUS_SUCCESS
        );

        return true;
    }
}


