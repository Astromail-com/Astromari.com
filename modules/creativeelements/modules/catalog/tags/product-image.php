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

use CE\CoreXDynamicTagsXDataTag as DataTag;
use CE\ModulesXDynamicTagsXModule as Module;

class ModulesXCatalogXTagsXProductImage extends DataTag
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'product-image';
    }

    public function getTitle()
    {
        return __('Product Image');
    }

    public function getGroup()
    {
        return Module::CATALOG_GROUP;
    }

    public function getCategories()
    {
        return [Module::IMAGE_CATEGORY];
    }

    protected function _registerControls()
    {
        $image_size_options = GroupControlImageSize::getAllImageSizes('products');

        $this->addControl(
            'image_size',
            [
                'label' => __('Image Size'),
                'type' => ControlsManager::SELECT,
                'options' => &$image_size_options,
                'default' => key($image_size_options),
            ]
        );
    }

    protected function registerAdvancedSection()
    {
        $this->startControlsSection(
            'advanced',
            [
                'label' => __('Advanced'),
            ]
        );

        $this->addControl(
            'fallback_image',
            [
                'label' => __('Fallback'),
                'type' => ControlsManager::MEDIA,
            ]
        );

        $this->endControlsSection();
    }

    public function getValue(array $options = [])
    {
        $product = \Context::getContext()->smarty->tpl_vars['product']->value;

        return empty($product['cover']) ? $this->getSettings('fallback_image') : [
            'id' => '',
            'url' => $product['cover']['bySize'][$this->getSettings('image_size')]['url'],
            'alt' => $product['cover']['legend'],
        ];
    }

    protected function getSmartyValue(array $options = [])
    {
        $image_size = $this->getSettings('image_size');
        $fallback = $this->getSettings('fallback_image');

        return [
            'id' => '',
            // tmp fix: Absolute URLs need to be marked with {*://*}
            'url' => '{*://*}' .
                '{if product.cover}' .
                    "{\$product.cover.bySize.$image_size.url}" .
                (empty($fallback['url']) ? '' : '{else}' .
                    // Generate absolute URL for fallback image
                    '//{Tools::getMediaServer($product.id_product)}{$smarty.const.__PS_BASE_URI__}' .
                    $fallback['url']
                ) .
                '{/if}',
            'alt' => '{if $product.cover}{$product.cover.legend}{/if}',
        ];
    }
}
