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
 * Holds printify association query methods
 */
class PrintifyAssociationRepository
{
    /**
     * @param int $printifyAttributeId
     * @return int
     */
    public function getPrintifyAssociation($printifyAttributeId)
    {
        $query = new DbQuery();
        $query->select('id_attribute')
            ->from('printify_attribute')
            ->where('id_attribute_printify = ' . pSQL($printifyAttributeId));

        return (int) Db::getInstance()->getValue($query);
    }

    /**
     * @param int $attributeId
     * @param int $printifyAttributeId
     * @throws PrestaShopDatabaseException
     */
    public function addPrintifyAttributeAssociation($attributeId, $printifyAttributeId)
    {
        $query = new DbQuery();
        $query->select('id_attribute')
            ->from('printify_attribute')
            ->where(
                'id_attribute = ' . pSQL($attributeId)
                . ' AND id_attribute_printify = ' . pSQL($printifyAttributeId)
            );

        if (!Db::getInstance()->getValue($query)) {
            Db::getInstance()->insert('printify_attribute', [
                'id_attribute' => pSQL($attributeId),
                'id_attribute_printify' => pSQL($printifyAttributeId)
            ]);
        }
    }

    /**
     * @param int $printifyProductAttributeId
     * @return int
     */
    public function getPrintifyProductAttribute($printifyProductAttributeId, $idProduct)
    {
        $query = new DbQuery();
        $query->select('pa.id_product_attribute')
            ->from('printify_product_attribute', 'paa')
            ->leftJoin('product_attribute', 'pa', 'pa.id_product_attribute = paa.id_product_attribute')
            ->where('id_product_attribute_printify = ' . pSQL($printifyProductAttributeId))
            ->where('paa.id_product=' . (int) $idProduct);

        return (int) Db::getInstance()->getValue($query);
    }

    /**
     * @param int $printifyProductAttributeId
     * @return int
     */
    public function deletePrintifyProductAttribute($printifyProductAttributeId, $idProduct)
    {
        return (int) Db::getInstance()->delete(
            'printify_product_attribute',
            'id_product_attribute_printify = ' . pSQL($printifyProductAttributeId) . ' AND id_product = ' . (int)$idProduct
            );
    }

    /**
     * @param int $attributeId
     * @param int $printifyAttributeId
     * @throws PrestaShopDatabaseException
     */
    public function addPrintifyProductAttributeAssociation($attributeId, $printifyAttributeId, $productId)
    {
        $query = new DbQuery();
        $query->select('id_product_attribute')
            ->from('printify_product_attribute')
            ->where(
                'id_product_attribute = ' . pSQL($attributeId) .
                ' AND id_product_attribute_printify = ' . pSQL($printifyAttributeId) . ' AND id_product='. (int)$productId
            );

        if (!Db::getInstance()->getValue($query)) {
            Db::getInstance()->insert('printify_product_attribute', [
                'id_product_attribute' => pSQL($attributeId),
                'id_product_attribute_printify' => pSQL($printifyAttributeId),
                'id_product' => (int) $productId
            ]);
        }
    }

    /**
     * @param int $productId
     * @param int $printifyProductId
     * @throws PrestaShopDatabaseException
     */
    public function addPrintifyProductAssociation($productId, $printifyProductId)
    {
        Db::getInstance()->insert('printify_product', [
            'id_product' => pSQL($productId),
            'id_printify_product' => pSQL($printifyProductId),
        ]);
    }

    /**
     * @param int $productId
     * @param int $printProviderId
     * @param int $blueprintId
     */
    public function updatePrintInformation($productId, $printProviderId, $blueprintId)
    {
        Db::getInstance()->update(
            'printify_product', [
                'printify_print_provider_id' => pSQL($printProviderId),
                'printify_blueprint_id' => pSQL($blueprintId),
            ],
            'id_product = ' . pSQL($productId)
        );
    }

    /**
     * @param $productId
     */
    public function deleteProductAssociation($productId)
    {
        $query = new DbQuery();
        $query->type('DELETE')
            ->from('printify_product')
            ->where('id_product = ' . pSQL($productId));

        Db::getInstance()->execute($query);
    }

    /**
     * @param $associations
     */
    public function deleteAttributeAssociations($associations)
    {
        $query = new DbQuery();
        $query->type('DELETE');
        $query->from('printify_attribute')
            ->where('id_attribute IN (' . pSQL(implode(', ', $associations)) . ')');

        Db::getInstance()->execute($query);
    }

    /**
     * @param $associations
     */
    public function deleteProductAttributeAssociations($associations)
    {
        $query = new DbQuery();
        $query->type('DELETE');
        $query->from('printify_product_attribute')
            ->where('id_product_attribute IN (' . pSQL(implode(', ', $associations)) . ')');

        Db::getInstance()->execute($query);
    }

    /**
     * @param int $productId
     * @return array
     * @throws PrestaShopDatabaseException
     */
    public function getAssociationIds($productId)
    {
        $resultArray = [];

        $query = new DbQuery();
        $query->select('pa.`id_product_attribute`');
        $query->from('printify_product_attribute', 'pa');
        $query->where('pa.id_product = ' . pSQL($productId));

        foreach (Db::getInstance()->executeS($query) as $productAttributeId) {
            $resultArray[] = (int) $productAttributeId['id_product_attribute'];
        }

        return $resultArray;
    }

    /**
     * @param $idLang
     * @param $name
     * @param $groupId
     * @return int
     */
    public function getAttributeByName($idLang, $name, $groupId)
    {
        $query = new DbQuery();
        $query->select('a.id_attribute')
            ->from('attribute', 'a')
            ->leftJoin('attribute_lang', 'al', 'a.id_attribute = al.id_attribute')
            ->where('al.id_lang = ' . pSQL($idLang))
            ->where('al.name = \'' . pSQL($name) . '\'')
            ->where('a.id_attribute_group = \'' . pSQL($groupId) .'\'');

        return (int) Db::getInstance()->getValue($query);
    }

    public function getPrintifyProductId($idProduct)
    {
        $query = new DbQuery();
        $query->select('id_printify_product');
        $query->from('printify_product');
        $query->where('id_product = ' . pSQL($idProduct));
        return Db::getInstance()->getValue($query);
    }

}
