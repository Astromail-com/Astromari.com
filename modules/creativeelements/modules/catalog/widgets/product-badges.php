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

class WidgetProductBadges extends WidgetBase
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'product-badges';
    }

    public function getTitle()
    {
        return __('Product Badges');
    }

    public function getIcon()
    {
        return 'eicon-meta-data';
    }

    public function getCategories()
    {
        return ['product-elements'];
    }

    public function getKeywords()
    {
        return ['shop', 'store', 'product', 'badges', 'discount', 'sale', 'new', 'pack', 'out-of-stock', 'sold out'];
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_product_badges',
            [
                'label' => __('Product Badges'),
            ]
        );

        $this->addControl(
            'layout',
            [
                'label' => __('Layout'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'inline' => __('Inline'),
                    'stacked' => __('Stacked'),
                ],
                'default' => 'inline',
                'prefix_class' => 'ce-product-badges--',
            ]
        );

        $this->addControl(
            'badges',
            [
                'label' => __('Badges'),
                'type' => ControlsManager::SELECT2,
                'options' => [
                    'sale' => __('Sale'),
                    'new' => __('New'),
                    'pack' => __('Pack'),
                    'out' => __('Out-of-Stock'),
                ],
                'default' => ['sale', 'new', 'pack', 'out'],
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $this->addControl(
            'heading_label',
            [
                'label' => __('Label'),
                'type' => ControlsManager::HEADING,
                'condition' => [
                    'badges!' => [],
                ],
            ]
        );

        $this->addControl(
            'sale_text',
            [
                'label' => __('Sale'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Default'),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'badges',
                            'operator' => 'contains',
                            'value' => 'sale',
                        ],
                    ],
                ],
            ]
        );

        $this->addControl(
            'new_text',
            [
                'label' => __('New'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Default'),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'badges',
                            'operator' => 'contains',
                            'value' => 'new',
                        ],
                    ],
                ],
            ]
        );

        $this->addControl(
            'out_text',
            [
                'label' => __('Out-of-Stock'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Default'),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'badges',
                            'operator' => 'contains',
                            'value' => 'out',
                        ],
                    ],
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style_product_badges',
            [
                'label' => __('Product Badges'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addControl(
            'space_between',
            [
                'label' => __('Space Between'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 5,
                    'unit' => 'px',
                ],
                'selectors' => [
                    'body:not(.lang-rtl) {{WRAPPER}} .ce-product-badge' => 'margin: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
                    'body:not(.lang-rtl) {{WRAPPER}} .ce-product-badges' => 'margin: 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}} 0',
                    'body.lang-rtl {{WRAPPER}} .ce-product-badge' => 'margin: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
                    'body.lang-rtl {{WRAPPER}} .ce-product-badges' => 'margin: 0 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addControl(
            'min_width',
            [
                'label' => __('Min Width'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .ce-product-badge',
            ]
        );

        $this->startControlsTabs('tabs_style_badges');

        $this->startControlsTab(
            'tab_badge_sale',
            [
                'label' => __('Sale'),
            ]
        );

        $this->addControl(
            'sale_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-sale' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'sale_bg_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-sale' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'sale_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-sale' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tab_badge_new',
            [
                'label' => __('New'),
            ]
        );

        $this->addControl(
            'new_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-new' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'new_bg_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-new' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'new_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-new' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tab_badge_pack',
            [
                'label' => __('Pack'),
            ]
        );

        $this->addControl(
            'pack_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-pack' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'pack_bg_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-pack' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'pack_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-pack' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tab_badge_out',
            [
                'label' => __('Out'),
            ]
        );

        $this->addControl(
            'out_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-out' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'out_bg_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-out' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'out_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge-out' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->addControl(
            'border_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::SLIDER,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge' => 'border-style: solid; border-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );


        $this->addControl(
            'border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addResponsiveControl(
            'padding',
            [
                'label' => __('Padding'),
                'type' => ControlsManager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlBoxShadow::getType(),
            [
                'name' => 'box_shadow',
                'selector' => '{{WRAPPER}} .ce-product-badge',
            ]
        );

        $this->endControlsSection();
    }

    protected function shouldPrintEmpty()
    {
        return true;
    }

    protected function getHtmlWrapperClass()
    {
        return parent::getHtmlWrapperClass() . ' elementor-overflow-hidden';
    }

    protected function render()
    {
        $settings = $this->getSettingsForDisplay();

        if (!$settings['badges']) {
            return;
        }

        $product = &\Context::getContext()->smarty->tpl_vars['product']->value;
        $badges = [];

        if (!empty($product['has_discount']) && in_array('sale', $settings['badges'])) {
            $badges['sale'] = $settings['sale_text'] ?: $product[
                'percentage' === $product['discount_type'] ? 'discount_percentage' : 'discount_amount_to_display'
            ];
        }
        if (!empty($product['flags']['new']['label']) && in_array('new', $settings['badges'])) {
            $badges['new'] = $settings['new_text'] ?: $product['flags']['new']['label'];
        }
        if (!empty($product['flags']['pack']['label']) && in_array('pack', $settings['badges'])) {
            $badges['pack'] = $product['flags']['pack']['label'];
        }
        if (!empty($product['flags']['out_of_stock']['label']) && in_array('out', $settings['badges'])) {
            $badges['out'] =  $settings['out_text'] ?: $product['flags']['out_of_stock']['label'];
        }
        if (!$badges) {
            return;
        }
        ?>
        <div class="ce-product-badges">
        <?php foreach ($badges as $badge => $label) : ?>
            <div class="ce-product-badge ce-product-badge-<?= esc_attr($badge) ?>"><?= $label ?></div>
        <?php endforeach ?>
        </div>
        <?php
    }

    protected function renderSmarty()
    {
        $settings = $this->getSettingsForDisplay();

        if (!$settings['badges']) {
            return;
        }
        ?>
        <div class="ce-product-badges">
        <?php if (in_array('sale', $settings['badges'])) : ?>
            {if !empty($product.has_discount)}
                <div class="ce-product-badge ce-product-badge-sale">
                <?php if ($settings['sale_text']) : ?>
                    <?= $settings['sale_text'] ?>
                <?php else : ?>
                    {$product[_q_c_(
                        'percentage' === $product.discount_type, 'discount_percentage', 'discount_amount_to_display'
                    )]}
                <?php endif ?>
                </div>
            {/if}
        <?php endif ?>
        <?php if (in_array('new', $settings['badges'])) : ?>
            {if !empty($product.flags.new.label)}
                <div class="ce-product-badge ce-product-badge-new">
                    <?= $settings['new_text'] ?: '{$product.flags.new.label}' ?>
                </div>
            {/if}
        <?php endif ?>
        <?php if (in_array('pack', $settings['badges'])) : ?>
            {if !empty($product.flags.pack.label)}
                <div class="ce-product-badge ce-product-badge-pack">{$product.flags.pack.label}</div>
            {/if}
        <?php endif ?>
        <?php if (in_array('out', $settings['badges'])) : ?>
            {if !empty($product.flags.out_of_stock.label)}
                <div class="ce-product-badge ce-product-badge-out">
                    <?= $settings['out_text'] ?: '{$product.flags.out_of_stock.label}' ?>
                </div>
            {/if}
        <?php endif ?>
        </div>
        <?php
    }

    public function renderPlainContent()
    {
    }
}
