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

class WidgetProductBox extends WidgetProductBase
{
    public function getName()
    {
        return 'product-box';
    }

    public function getTitle()
    {
        return __('Product Box');
    }

    public function getIcon()
    {
        return 'eicon-info-box';
    }

    public function getKeywords()
    {
        return ['shop', 'store', 'product', 'box'];
    }

    protected function getDefaultProductId()
    {
        $prods = is_admin() ? \Product::getProducts($this->context->language->id, 0, 1, 'id_product', 'ASC', false, true) : [];

        return !empty($prods[0]['id_product']) ? $prods[0]['id_product'] : 1;
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_product_box',
            [
                'label' => __('Product Box'),
            ]
        );

        $this->addControl(
            'skin',
            [
                'label' => __('Skin'),
                'type' => ControlsManager::SELECT,
                'options' => $this->getSkinOptions(),
                'default' => 'product',
            ]
        );

        $this->addControl(
            'product_id',
            [
                'label' => __('Product'),
                'type' => ControlsManager::SELECT2,
                'label_block' => true,
                'select2options' => [
                    'placeholder' => __('Loading') . '...',
                    'allowClear' => false,
                    'product' => true,
                    'ajax' => [
                        'url' => Helper::getAjaxProductsListLink(),
                    ],
                ],
                'default' => $this->getDefaultProductId(),
                'separator' => 'before',
            ]
        );

        $this->endControlsSection();

        $this->registerMiniatureSections();

        $this->startControlsSection(
            'section_style_product',
            [
                'label' => __('Product Box'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $product_selector = '{{WRAPPER}}:not(.wrapfix) .elementor-product-box > *, {{WRAPPER}}.wrapfix .elementor-product-box > * > *';
        $product_selector_hover = '{{WRAPPER}}:not(.wrapfix) .elementor-product-box > :hover, {{WRAPPER}}.wrapfix .elementor-product-box > * > :hover';

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
                    '' => [
                        'title' => __('Justified'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-box' => 'text-align: {{VALUE}};',
                    $product_selector => 'display: inline-block;',
                ],
            ]
        );

        $this->addResponsiveControl(
            'product_padding',
            [
                'label' => __('Padding'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    $product_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->addControl(
            'product_border_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    $product_selector => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
                ],
            ]
        );

        $this->addControl(
            'product_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    $product_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->startControlsTabs('product_style_tabs');

        $this->startControlsTab(
            'product_style_normal',
            [
                'label' => __('Normal'),
            ]
        );

        $this->addControl(
            'product_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    $product_selector => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'product_bg_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-miniature' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'skin' => 'custom',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlBoxShadow::getType(),
            [
                'name' => 'product_box_shadow',
                'selector' => $product_selector,
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'product_style_hover',
            [
                'label' => __('Hover'),
            ]
        );

        $this->addControl(
            'product_border_color_hover',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    $product_selector_hover => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'product_bg_color_hover',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-product-miniature:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'skin' => 'custom',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlBoxShadow::getType(),
            [
                'name' => 'product_box_shadow_hover',
                'selector' => $product_selector_hover,
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->endControlsSection();

        $this->registerMiniatureStyleSections();
    }

    protected function render()
    {
        $settings = $this->getSettingsForDisplay();
        $product = $this->getProduct($settings['product_id']);

        if (empty($product) || empty($this->context->currency->id)) {
            return;
        }

        if ('custom' === $settings['skin']) {
            echo '<div class="elementor-product-box">' . $this->fetchMiniature($settings, $product) . '</div>';
        } else {
            if (!$tpl = $this->getSkinTemplate($settings['skin'])) {
                return;
            }
            // Store product temporary if exists
            isset($this->context->smarty->tpl_vars['product']) && $tmp = $this->context->smarty->tpl_vars['product'];

            $this->context->smarty->assign('product', $product);

            echo '<div class="elementor-product-box">' . $this->context->smarty->fetch($tpl) . '</div>';

            // Restore product if exists
            isset($tmp) && $this->context->smarty->tpl_vars['product'] = $tmp;
        }
    }
}
