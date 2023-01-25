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

use CE\CoreXDynamicTagsXTag as Tag;
use CE\ModulesXDynamicTagsXModule as Module;

class ModulesXCatalogXTagsXProductMeta extends Tag
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'product-meta';
    }

    public function getTitle()
    {
        return __('Product Meta');
    }

    public function getGroup()
    {
        return Module::CATALOG_GROUP;
    }

    public function getCategories()
    {
        return [Module::TEXT_CATEGORY];
    }

    public function getPanelTemplateSettingKey()
    {
        return 'type';
    }

    protected function _registerControls()
    {
        $this->addControl(
            'type',
            [
                'label' => __('Field'),
                'type' => ControlsManager::SELECT,
                'groups' => [
                    'category' => __('Category'),
                    'manufacturer' => __('Brand'),
                    // 'tags' => __('Tags'),
                    'delivery' => __('Delivery Time'),
                    'quantity' => __('Quantity'),
                    'availability_date' => __('Availability Date'),
                    'condition' => __('Condition'),
                    'references' => [
                        'label' => __('References'),
                        'options' => [
                            'reference' => __('SKU'),
                            'isbn' => __('ISBN'),
                            'ean13' => __('EAN-13'),
                            'upc' => __('UPC'),
                            'mpn' => __('MPN'),
                        ],
                    ],
                ],
                'default' => 'reference',
            ]
        );
    }

    public function render()
    {
        $context = \Context::getContext();
        $vars = &$context->smarty->tpl_vars;
        $product = &$vars['product']->value;
        $type = $this->getSettings('type');

        switch ($type) {
            case 'delivery':
                if (1 == $product['additional_delivery_times']) {
                    echo $product['delivery_information'];
                } elseif (2 == $product['additional_delivery_times']) {
                    if ($product['quantity'] > 0) {
                        echo $product['delivery_in_stock'];
                    } elseif ($product['add_to_cart_url']) {
                        echo $product['delivery_out_stock'];
                    }
                }
                break;
            case 'quantity':
                if (!empty($product['show_quantities'])) {
                    echo esc_html(max(0, $product['quantity']) . " {$product['quantity_label']}");
                }
                break;
            case 'condition':
                empty($product['condition']) or print esc_html($product['condition']['label']);
                break;
            case 'reference':
                empty($product['reference_to_display']) or print esc_html($product['reference_to_display']);
                break;
            case 'availability_date':
                empty($product[$type]) or print esc_html($product[$type]);
                break;
            case 'isbn':
            case 'ean13':
            case 'upc':
            case 'npm':
                if (!empty($product['attributes'][1][$type])) {
                    echo esc_html($product['attributes'][1][$type]);
                } elseif (!empty($product[$type])) {
                    echo esc_html($product[$type]);
                }
                break;
        }
    }

    protected function renderSmarty()
    {
        $type = $this->getSettings('type');

        switch ($type) {
            case 'delivery':
                echo
                    '{if 1 == $product.additional_delivery_times}',
                        '{$product.delivery_information}',
                    '{elseif 2 == $product.additional_delivery_times}',
                        '{if $product.quantity > 0}',
                            '{$product.delivery_in_stock}',
                        '{elseif $product.add_to_cart_url}',
                            '{$product.delivery_out_stock}',
                        '{/if}',
                    '{/if}';
                break;
            case 'quantity':
                echo '{if !empty($product.show_quantities)}{max(0, $product.quantity)} {$product.quantity_label}{/if}';
                break;
            case 'condition':
                echo '{if !empty($product.condition)}{$product.condition.label}{/if}';
                break;
            case 'reference':
                echo '{if !empty($product.reference_to_display)}{$product.reference_to_display}{/if}';
            case 'availability_date':
                echo "{if !empty(\$product.$type)}{\$product.$type}{/if}";
                break;
            case 'isbn':
            case 'ean13':
            case 'upc':
            case 'npm':
                echo
                    "{if !empty(\$product.attributes[1].$type)}",
                        "{\$product.attributes[1].$type}",
                    "{elseif !empty(\$product.$type)}{\$product.$type}{/if}";
                break;
        }
    }
}
