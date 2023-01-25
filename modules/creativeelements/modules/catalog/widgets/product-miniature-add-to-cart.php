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

include_once dirname(__FILE__) . '/product-add-to-cart.php';

class WidgetProductMiniatureAddToCart extends WidgetProductAddToCart
{
    public function getName()
    {
        return 'product-miniature-add-to-cart';
    }

    protected function _registerControls()
    {
        parent::_registerControls();

        $this->updateControl(
            'button_type',
            [
                'options' => [
                    'add-to-cart' => __('Add to Cart'),
                    'buy-now' => __('Buy Now'),
                ],
            ]
        );

        $this->startControlsSection(
            'section_combinations',
            [
                'label' => __('Product with Combinations'),
            ]
        );

        $this->addControl(
            'combinations_action',
            [
                'label' => __('Action'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    '' => __('Default'),
                    'quickview' => __('Quick View'),
                    'full-details' => __('View Full Details'),
                ],
            ]
        );

        $this->addControl(
            'combinations_text',
            [
                'label' => __('Text'),
                'type' => ControlsManager::TEXT,
                'placeholder' => 'Default',
                'condition' => [
                    'combinations_action!' => '',
                ]
            ]
        );

        $this->addControl(
            'combinations_icon',
            [
                'label' => __('Icon'),
                'type' => ControlsManager::ICON,
                'default' => 'fa fa-eye',
                'condition' => [
                    'combinations_action!' => '',
                ]
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_combinations_style',
            [
                'label' => __('Product with Combinations'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'combinations_action!' => '',
                ]
            ]
        );

        $this->startControlsTabs('tabs_combinations_style');

        $this->startControlsTab(
            'tab_combinations_normal',
            [
                'label' => __('Normal'),
            ]
        );

        $this->addControl(
            'combinations_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button-combinations:not(#e)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'combinations_background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button-combinations' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'combinations_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button-combinations' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tab_combinations_hover',
            [
                'label' => __('Hover'),
            ]
        );

        $this->addControl(
            'combinations_color_hover',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button-combinations:not(#e):hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'combinations_background_color_hover',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button-combinations:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'combinations_border_color_hover',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button-combinations:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->endControlsSection();
    }

    protected function render()
    {
        $context = \Context::getContext();
        $product = &$context->smarty->tpl_vars['product']->value;
        $settings = $this->getSettings();
        $action = \Tools::toCamelCase($settings['button_type']);

        $this->addRenderAttribute('button', 'href', "#ce-action=$action{}");

        if ($settings['combinations_action'] && $product['attributes']) {
            $this->preventInlineEditing = true;
            $this->addRenderAttribute('button', 'class', 'elementor-button-combinations');

            $href = 'quickview' === $settings['combinations_action'] ? '#ce-action=quickview{}' : $product['url'];
            $this->setRenderAttribute('button', 'href', $href);

            $this->setSettings('icon', $settings['combinations_icon']);
            $this->setSettings(
                'text',
                $settings['combinations_text'] ?: (
                    'quickview' === $settings['combinations_action'] ? __('Quick View') : __('View Full Details')
                )
            );
        } elseif (!$settings['text']) {
            $this->preventInlineEditing = true;
            $this->setSettings(
                'text',
                'add-to-cart' === $settings['button_type'] ? __('Add to Cart') : __('Buy Now')
            );
        }
        WidgetButton::render();
    }

    protected function renderSmarty()
    {
        $settings = $this->getSettings();
        $action = \Tools::toCamelCase($settings['button_type']);

        if ($settings['combinations_action']) {
            $this->addRenderAttribute('button', [
                'class' => '{if $product.attributes}elementor-button-combinations{/if}',
                '{if $product.attributes}' .
                    'href="' . ('quickview' === $settings['combinations_action']
                        ? '#ce-action=quickview&lbrace;}'
                        : '{$product.url}'
                    ) . '"' .
                '{elseif $product.add_to_cart_url}' .
                    'href="#ce-action=' . $action . '&lbrace;}"' .
                '{/if}' => null,
            ]);
            $this->setSettings(
                'icon',
                '{if $product.attributes}' . $settings['combinations_icon'] . '{else}' . $settings['icon'] . '{/if}'
            );
            $this->setSettings(
                'text',
                '{if $product.attributes}' .
                    ($settings['combinations_text'] ?:
                        ('quickview' === $settings['combinations_action'] ? __('Quick View') : __('View Full Details'))
                    ) .
                '{else}' .
                    ($settings['text'] ?:
                        ('add-to-cart' === $settings['button_type'] ? __('Add to Cart') : __('Buy Now'))
                    ) .
                '{/if}'
            );
        } else {
            $this->addRenderAttribute('button', [
                '{if $product.add_to_cart_url}href="#ce-action=' . $action . '&lbrace;}"{/if}' => null,
            ]);
            empty($settings['text']) && $this->setSettings(
                'text',
                'add-to-cart' === $settings['button_type'] ? __('Add to Cart') : __('Buy Now')
            );
        }
        WidgetButton::render();
    }
}
