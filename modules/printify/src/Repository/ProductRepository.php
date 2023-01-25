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

namespace Invertus\Printify\Repository;

use Db;
use DbQuery;
use PrestaShopDatabaseException;

/**
 * Holds product query methods
 */
class ProductRepository
{
    /**
     * @param int $attributeId
     * @param int $imageId
     * @throws PrestaShopDatabaseException
     */
    public function addProductAttributeImage($attributeId, $imageId)
    {
        Db::getInstance()->insert('product_attribute_image', [
            'id_product_attribute' => pSQL($attributeId),
            'id_image' => pSQL($imageId)
        ]);
    }

    /**
     * @param int $productAttributeId
     * @param int $attributeId
     * @throws PrestaShopDatabaseException
     */
    public function addProductAttributeCombination($productAttributeId, $attributeId)
    {
        $query = new DbQuery();
        $query->select('id_product_attribute')
            ->from('product_attribute_combination')
            ->where(
                'id_product_attribute = ' . pSQL($productAttributeId)
                . ' AND id_attribute = ' . pSQL($attributeId)
            );

        if (!Db::getInstance()->getValue($query)) {
            Db::getInstance()->insert(
                'product_attribute_combination',
                [
                    'id_product_attribute' => pSQL($productAttributeId),
                    'id_attribute' => pSQL($attributeId)
                ]
            );
        }
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function getExistingAttributeGroupId($name)
    {
        $query = new DbQuery();
        $query->select('id_attribute_group')
            ->from('attribute_group_lang')
            ->where('LOWER(name) = SUBSTR(LOWER("' . pSQL($name) . '"), 1, LENGTH(name))');

        return (int) Db::getInstance()->getValue($query);
    }

    /**
     * @param string $printifyId
     * @return bool|int
     */
    public function findProductByPrintifyId($printifyId = '')
    {
        if (null === trim($printifyId)) {
            return false;
        }

        $query = new DbQuery();
        $query->select('id_product');
        $query->from('printify_product');

        $query->where('id_printify_product = "' . pSQL($printifyId) . '"');

        return (int) Db::getInstance()->getValue($query);
    }

    /**
     * @param $printifyId
     * @return int
     */
    public function getPrintProviderIdByPrintifyId($printifyId)
    {
        $query = new DbQuery();
        $query->select('printify_print_provider_id');
        $query->from('printify_product');

        $query->where('id_printify_product = "' . pSQL($printifyId) . '"');

        return (int) Db::getInstance()->getValue($query);
    }

    /**
     * @param $printifyId
     * @return int
     */
    public function getBlueprintIdByPrintifyId($printifyId)
    {
        $query = new DbQuery();
        $query->select('printify_blueprint_id');
        $query->from('printify_product');

        $query->where('id_printify_product = "' . pSQL($printifyId) . '"');

        return (int) Db::getInstance()->getValue($query);
    }

    /**
     * @param $reference
     * @return array|false|\mysqli_result|\PDOStatement|resource|null
     * @throws PrestaShopDatabaseException
     */
    public function getPrintifyProductsFromOrder($reference)
    {
        $query = new DbQuery();
        $query->select('pp.`id_printify_product`, ppa.`id_product_attribute_printify`, od.`product_quantity`');
        $query->from('order_detail', 'od');
        $query->leftJoin('orders', 'o', 'od.`id_order` = o.`id_order`');
        $query->rightJoin('printify_product', 'pp', 'od.`product_id` = pp.`id_product`');
        $query->rightJoin('printify_product_attribute', 'ppa', 'od.`product_attribute_id` = ppa.`id_product_attribute`');

        $query->where('o.`reference` = "' . pSQL($reference) . '"');

        return Db::getInstance()->executeS($query);
    }

    public function resetDefaultCombination($idProduct)
    {
        Db::getInstance()->execute('UPDATE ' . _DB_PREFIX_ . 'product_attribute SET default_on = NULL WHERE id_product = ' . (int) $idProduct);
        Db::getInstance()->execute('UPDATE ' . _DB_PREFIX_ . 'product_attribute_shop SET default_on = NULL WHERE id_product = ' . (int) $idProduct);

    }
}
