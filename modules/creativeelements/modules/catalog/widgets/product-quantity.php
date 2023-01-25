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

class WidgetProductQuantity extends WidgetBase
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'product-quantity';
    }

    public function getTitle()
    {
        return __('Product Quantity');
    }

    public function getIcon()
    {
        return 'eicon-text-field';
    }

    public function getCategories()
    {
        return ['product-elements'];
    }

    public function getKeywords()
    {
        return ['shop', 'store', 'cart', 'product', 'number', 'quantity', 'add to cart'];
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_product_quantity',
            [
                'label' => __('Product Quantity'),
            ]
        );

        $this->addControl(
            'view',
            [
                'label' => __('View'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'default' => __('Default'),
                    'inline' => __('Inline'),
                    'stacked' => __('Stacked'),
                ],
                'default' => 'default',
                'prefix_class' => 'ce-product-quantity--view-',
            ]
        );

        $this->addControl(
            'size',
            [
                'label' => __('Size'),
                'type' => ControlsManager::SELECT,
                'default' => 'sm',
                'options' => [
                    'xs' => __('Extra Small'),
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                    'xl' => __('Extra Large'),
                ],
            ]
        );

        $this->addResponsiveControl(
            'align',
            [
                'label' => __('Alignment'),
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
            ]
        );

        $this->addControl(
            'heading_buttons',
            [
                'label' => __('Buttons'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $plus_options = [
            'ceicon-plus' => 'plus',
            'fa fa-plus' => 'plus-bold',
            'fa fa-plus-square' => 'plus-square',
            'fa fa-plus-square-o' => 'plus-square-o',
            'ceicon-sort-up' => 'caret',
            'fa fa-caret-square-o-up' => 'caret-square',
            'fa fa-angle-up' => 'angle',
            'fa fa-angle-double-up' => 'angle-double',
            'fa fa-chevron-up' => 'chevron',
            'fa fa-chevron-circle-up' => 'chevron-circle',
            'fa fa-arrow-up' => 'arrow',
            'fa fa-arrow-circle-up' => 'arrow-circle',
            'fa fa-arrow-circle-o-up' => 'arrow-circle-o',
            'fa fa-long-arrow-up' => 'long-arrow',
        ];
        $this->addControl(
            'plus',
            [
                'label' => __('Up'),
                'label_block' => false,
                'type' => ControlsManager::ICON,
                'default' => 'ceicon-sort-up',
                'options' => &$plus_options,
                'include' => array_keys($plus_options),
            ]
        );

        $minus_options = [
            'ceicon-minus' => 'minus',
            'fa fa-minus' => 'minus-bold',
            'fa fa-minus-square' => 'minus-square',
            'fa fa-minus-square-o' => 'minus-square-o',
            'ceicon-sort-down' => 'caret',
            'fa fa-caret-square-o-down' => 'caret-square',
            'fa fa-angle-down' => 'angle',
            'fa fa-angle-double-down' => 'angle-double',
            'fa fa-chevron-down' => 'chevron',
            'fa fa-chevron-circle-down' => 'chevron-circle',
            'fa fa-arrow-down' => 'arrow',
            'fa fa-arrow-circle-down' => 'arrow-circle',
            'fa fa-arrow-circle-o-down' => 'arrow-circle-o',
            'fa fa-long-arrow-down' => 'long-arrow',
        ];
        $this->addControl(
            'minus',
            [
                'label' => __('Down'),
                'label_block' => false,
                'type' => ControlsManager::ICON,
                'default' => 'ceicon-sort-down',
                'options' => &$minus_options,
                'include' => array_keys($minus_options),
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_input_style',
            [
                'label' => __('Input'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addResponsiveControl(
            'width',
            [
                'label' => __('Width'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} input[type=number]' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'align!' => 'justify',
                ],
                'device_args' => [
                    ControlsStack::RESPONSIVE_TABLET => [
                        'condition' => [
                            'align_tablet!' => 'justify',
                        ],
                    ],
                    ControlsStack::RESPONSIVE_MOBILE => [
                        'condition' => [
                            'align_mobile!' => 'justify',
                        ],
                    ],
                ],
            ]
        );

        $this->addControl(
            'input_align',
            [
                'label' => __('Alignment'),
                'label_block' => false,
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} input[type=number]' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} input[type=number]',
            ]
        );

        $this->startControlsTabs('tabs_input_style');

        $this->startControlsTab(
            'tab_input_normal',
            [
                'label' => __('Normal'),
            ]
        );

        $this->addControl(
            'text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} input[type=number]' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} input[type=number]' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} input[type=number]' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tab_input_focus',
            [
                'label' => __('Focus'),
            ]
        );

        $this->addControl(
            'text_color_focus',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} input[type=number]:focus' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'background_color_focus',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} input[type=number]:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'border_color_focus',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} input[type=number]:focus' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->addControl(
            'border_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} input[type=number]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}}.ce-product-quantity--view-stacked .ce-product-quantity__plus' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}}.ce-product-quantity--view-stacked .ce-product-quantity__minus' => 'margin: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} input[type=number]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlBoxShadow::getType(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} input[type=number]',
            ]
        );

        $this->addResponsiveControl(
            'text_padding',
            [
                'label' => __('Padding'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} input[type=number]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_buttons_style',
            [
                'label' => __('Buttons'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $this->addResponsiveControl(
            'buttons_spacing',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}.ce-product-quantity--view-inline input[type=number]' => 'margin: 0 {{SIZE}}{{UNIT}}',
                    'body:not(.lang-rtl) {{WRAPPER}}.ce-product-quantity--view-stacked .ce-product-quantity__btn' => 'right: {{SIZE}}{{UNIT}}',
                    'body.lang-rtl {{WRAPPER}}.ce-product-quantity--view-stacked .ce-product-quantity__btn' => 'left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addControl(
            'buttons_margin',
            [
                'label' => __('Margin'),
                'type' => ControlsManager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__plus' => 'top: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .ce-product-quantity__minus' => 'bottom: {{SIZE}}{{UNIT}}',
                ],
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'condition' => [
                    'view' => 'stacked',
                ],
            ]
        );

        $this->addControl(
            'buttons_width',
            [
                'label' => __('Width'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__btn' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'view' => 'stacked',
                ],
            ]
        );

        $this->addResponsiveControl(
            'buttons_size',
            [
                'label' => __('Icon Size'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} i.ce-product-quantity__btn' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addResponsiveControl(
            'buttons_padding',
            [
                'label' => __('Padding'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} i.ce-product-quantity__btn' => 'padding: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'view' => 'inline',
                ],
            ]
        );

        $this->startControlsTabs('tabs_colors_style');

        $this->startControlsTab(
            'tab_colors_normal',
            [
                'label' => __('Normal'),
            ]
        );

        $this->addControl(
            'buttons_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} i.ce-product-quantity__btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'buttons_background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__btn' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'buttons_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__btn' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tab_colors_hover',
            [
                'label' => __('Hover'),
            ]
        );

        $this->addControl(
            'buttons_color_hover',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} i.ce-product-quantity__btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'buttons_background_color_hover',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__btn:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'buttons_border_color_hover',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__btn:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->startControlsTabs(
            'tabs_border_style',
            [
                'condition' => [
                    'view' => 'stacked',
                ],
            ]
        );

        $this->startControlsTab(
            'tab_border_plus',
            [
                'label' => __('Up'),
            ]
        );

        $this->addControl(
            'plus_border_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__plus' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->addControl(
            'plus_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__plus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tab_border_minus',
            [
                'label' => __('Down'),
            ]
        );

        $this->addControl(
            'minus_border_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__minus' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->addControl(
            'minus_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__minus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->addControl(
            'buttons_border_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__btn' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',
                'condition' => [
                    'view' => 'inline',
                ],
            ]
        );

        $this->addControl(
            'buttons_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-quantity__btn' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'default' => [
                    'size' => 2,
                ],
                'condition' => [
                    'view' => 'inline',
                ],
            ]
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $settings = $this->getSettingsForDisplay();
        $product = &\Context::getContext()->smarty->tpl_vars['product']->value;
        $min_qty = !empty($product['product_attribute_minimal_quantity'])
            ? 'product_attribute_minimal_quantity'
            : 'minimal_quantity'
        ;
        $this->addRenderAttribute('input', [
            'class' => 'elementor-field elementor-field-textual elementor-size-' . $settings['size'],
            'type' => 'number',
            'form' => 'add-to-cart-or-refresh',
            'name' => 'qty',
            'value' => $product['quantity_wanted'],
            'min' => max(1, $product[$min_qty]),
            'inputmode' => 'decimal',
            'oninput' => '$(this.form.qty).val(this.value)',
        ]);
        ?>
        <div class="ce-product-quantity elementor-field-group">
            <i class="ce-product-quantity__btn ce-product-quantity__minus <?= esc_attr($settings['minus']) ?>"
                onclick="this.nextElementSibling.stepDown(), $(this.nextElementSibling).trigger('input')"></i>
            <input <?= $this->getRenderAttributeString('input') ?>>
            <i class="ce-product-quantity__btn ce-product-quantity__plus <?= esc_attr($settings['plus']) ?>"
                onclick="this.previousElementSibling.stepUp(), $(this.previousElementSibling).trigger('input')"></i>
        </div>
        <?php
    }

    public function renderPlainContent()
    {
    }
}
