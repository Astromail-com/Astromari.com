<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

namespace CE;

defined('_PS_VERSION_') or die;

use CE\ModulesXCatalogXTagsXProductAddToCart as ProductAddToCart;

class ModulesXCatalogXTagsXProductBuyNow extends ProductAddToCart
{
    const ACTION = 'buyNow';

    public function getName()
    {
        return 'product-buy-now';
    }

    public function getTitle()
    {
        return __('Buy Now');
    }
}
