<?php

namespace Invertus\Printify\Builder;

use Invertus\Printify\Collection\LineItemCollection;
use Invertus\Printify\Model\Api\LineItem;

class LineItemBuilder
{
    /**
     * @param array $data
     * @return LineItemCollection
     */
    public function buildLineItems($data)
    {
        $collection = new LineItemCollection();

        foreach ($data as $item) {
            $lineItem = new LineItem();
            $lineItem->setProductId($item['id_printify_product'])
                ->setVariantId((int) $item['id_product_attribute_printify'])
                ->setQuantity((int) $item['product_quantity']);

            $collection->add($lineItem);
        }

        return $collection;
    }
}
