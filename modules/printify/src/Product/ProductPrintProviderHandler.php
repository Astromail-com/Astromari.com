<?php
/**
 * 2007-2019 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author INVERTUS UAB www.invertus.eu <support@invertus.eu>
 * @copyright printify.com Limited
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace Invertus\Printify\Product;

use Invertus\Printify\Api\PrintProviderApi;
use Invertus\Printify\Exception\InvalidJsonStringException;
use Invertus\Printify\Model\PrintifyPrintProvider;
use Invertus\Printify\Repository\BlueprintRepository;
use Invertus\Printify\Repository\PrintProviderRepository;
use Invertus\Printify\Repository\ProductRepository;
use Invertus\Printify\Service\BlueprintJsonParser;
use Invertus\Printify\Service\PrintifyPrintProviderJsonParser;
use PrestaShopDatabaseException;
use PrestaShopException;

/**
 * Resolves print provider data from Printify to BO
 */
class ProductPrintProviderHandler
{
    /**
     * @var PrintProviderApi
     */
    private $printProviderApi;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var PrintProviderRepository
     */
    private $printProviderRepository;

    /**
     * @var BlueprintRepository
     */
    private $blueprintRepository;

    /**
     * @param PrintProviderApi $printProviderApi
     * @param ProductRepository $productRepository
     * @param PrintProviderRepository $printProviderRepository
     * @param BlueprintRepository $blueprintRepository
     */
    public function __construct(
        PrintProviderApi $printProviderApi,
        ProductRepository $productRepository,
        PrintProviderRepository $printProviderRepository,
        BlueprintRepository $blueprintRepository
    ) {
        $this->printProviderApi = $printProviderApi;
        $this->productRepository = $productRepository;
        $this->printProviderRepository = $printProviderRepository;
        $this->blueprintRepository = $blueprintRepository;
    }

    /**
     * @param string $printifyId
     *
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     * @throws InvalidJsonStringException
     */
    public function handle($printifyId)
    {
        $printProviderId = $this->productRepository->getPrintProviderIdByPrintifyId($printifyId);
        $blueprintId = $this->productRepository->getBlueprintIdByPrintifyId($printifyId);
        $jsonString = $this->printProviderApi->getPrintProvider($printProviderId);
        $printProviderJsonParser = new PrintifyPrintProviderJsonParser($jsonString);

        $printifyPrintProvider = $printProviderJsonParser->getPrintProvider();

        $this->addPrintifyPrintProvider($printifyPrintProvider, $blueprintId);
    }

    /**
     * @param PrintifyPrintProvider $printProvider
     * @param int $blueprintId
     * @throws InvalidJsonStringException
     * @throws PrestaShopDatabaseException
     */
    private function addPrintifyPrintProvider($printProvider, $blueprintId)
    {
        $blueprints = $printProvider->getBlueprints();
        $blueprint = $blueprints->get($blueprintId);

        if ($blueprint === null) {
            $blueprintJson = $this->printProviderApi->getBlueprint($blueprintId);
            $blueprintParser = new BlueprintJsonParser($blueprintJson);
            $blueprint = $blueprintParser->getBlueprint();
        }

        $this->printProviderRepository->addPrintifyPrintProvider($printProvider->getId(), $printProvider->getTitle());
        $this->blueprintRepository->addPrintifyBlueprint($blueprint->getId(), $blueprint->getBrand());
    }
}
