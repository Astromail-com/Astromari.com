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

class WidgetProductStock extends WidgetBase
{
    const REMOTE_RENDER = true;

    protected $context;

    protected $translator;

    public function getName()
    {
        return 'product-stock';
    }

    public function getTitle()
    {
        return __('Product Stock');
    }

    public function getIcon()
    {
        return 'eicon-product-stock';
    }

    public function getCategories()
    {
        return ['product-elements'];
    }

    public function getKeywords()
    {
        return ['shop', 'store', 'stock', 'quantity', 'availability', 'product'];
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_stock',
            [
                'label' => __('Product Stock'),
            ]
        );

        $this->addControl(
            'heading_icon',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Icon'),
            ]
        );

        $this->addControl(
            'in_stock_icon',
            [
                'label' => $this->translator->trans('In stock', [], 'Shop.Theme.Catalog'),
                'type' => ControlsManager::ICON,
                'default' => 'fa fa-check',
            ]
        );

        $this->addControl(
            'low_stock_level_icon',
            [
                'label' => $this->translator->trans('Low stock level', [], 'Admin.Catalog.Feature'),
                'type' => ControlsManager::ICON,
                'default' => 'fa fa-exclamation',
            ]
        );

        $this->addControl(
            'out_of_stock_icon',
            [
                'label' => $this->translator->trans('Out-of-Stock', [], 'Admin.Shopparameters.Feature'),
                'type' => ControlsManager::ICON,
                'default' => 'fa fa-times',
            ]
        );

        if (is_admin()) {
            $url = $this->context->link->getAdminLink('AdminPPreferences') . '#configuration_fieldset_stock';

            $this->addControl(
                'configure',
                [
                    'raw' => __('Global Settings') . '<br><br>' .
                        '<a class="elementor-button elementor-button-default" href="' .
                            esc_attr($url) . '" target="_blank">' .
                            '<i class="fa fa-external-link"></i> ' . __('Configure') .
                        '</a>',
                    'type' => ControlsManager::RAW_HTML,
                    'classes' => 'elementor-control-descriptor',
                    'separator' => 'before',
                ]
            );
        }

        $this->endControlsSection();

        $this->startControlsSection(
            'section_stock_style',
            [
                'label' => __('Product Stock'),
                'tab' => ControlsManager::TAB_STYLE,
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
                    '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'text_typography',
                'label' => __('Typography'),
                'selector' => '{{WRAPPER}} .ce-product-stock',
            ]
        );

        $this->addControl(
            'heading_text_color',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Text Color'),
            ]
        );

        $this->addControl(
            'in_stock_color',
            [
                'label' => $this->translator->trans('In stock', [], 'Shop.Theme.Catalog'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-stock--in-stock .ce-product-stock__availability' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'low_stock_level_color',
            [
                'label' => $this->translator->trans('Low stock level', [], 'Admin.Catalog.Feature'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-stock--low-stock-level .ce-product-stock__availability' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'out_of_stock_color',
            [
                'label' => $this->translator->trans('Out-of-Stock', [], 'Admin.Shopparameters.Feature'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-stock--out-of-stock .ce-product-stock__availability' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_icon_style',
            [
                'label' => __('Icon'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addResponsiveControl(
            'icon_spacing',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    'body:not(.lang-rtl) {{WRAPPER}} .ce-product-stock__availability i' => 'margin-right: {{SIZE}}{{UNIT}}',
                    'body.lang-rtl {{WRAPPER}} .ce-product-stock__availability i' => 'margin-left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addResponsiveControl(
            'icon_size',
            [
                'label' => __('Size'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 16,
                ],
                'range' => [
                    'px' => [
                        'min' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-stock__availability i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addControl(
            'heading_icon_color',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Color'),
            ]
        );

        $this->addControl(
            'in_stock_icon_color',
            [
                'label' => $this->translator->trans('In stock', [], 'Shop.Theme.Catalog'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-stock--in-stock .ce-product-stock__availability i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'low_stock_level_icon_color',
            [
                'label' => $this->translator->trans('Low stock level', [], 'Admin.Catalog.Feature'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-stock--low-stock-level .ce-product-stock__availability i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'out_of_stock_icon_color',
            [
                'label' => $this->translator->trans('Out-of-Stock', [], 'Admin.Shopparameters.Feature'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-stock--out-of-stock .ce-product-stock__availability i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_min_quantity_style',
            [
                'label' => $this->translator->trans('Minimum quantity for sale', [], 'Admin.Catalog.Feature'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addResponsiveControl(
            'min_quantity_spacing',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-stock__min-quantity' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'min_quantity_typography',
                'label' => __('Typography'),
                'selector' => '{{WRAPPER}} .ce-product-stock__min-quantity',
            ]
        );

        $this->addControl(
            'min_quantity_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-stock__min-quantity' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsSection();
    }

    protected function render()
    {
        $product = &$this->context->smarty->tpl_vars['product']->value;
        $availability = 'available' === $product['availability'] ? 'in-stock' : (
            'last_remaining_items' === $product['availability'] ? 'low-stock-level' : 'out-of-stock'
        );
        if ($show_availability = $product['show_availability'] && $product['availability_message']) {
            $availability_icon = $this->getSettings(str_replace('-', '_', $availability) . '_icon');
        }
        ?>
        <div class="ce-product-stock ce-product-stock--<?= esc_attr($availability) ?>">
        <?php if ($show_availability) : ?>
            <div class="ce-product-stock__availability">
            <?php if ($availability_icon) : ?>
                <i class="<?= esc_attr($availability_icon) ?>"></i>
            <?php endif ?>
                <span class="ce-product-stock__availability-label">
                    <?= esc_html($product['availability_message']) ?>
                </span>
            </div>
        <?php endif ?>
        <?php if ($product['minimal_quantity'] > 1) : ?>
            <div class="ce-product-stock__min-quantity">
                <?php
                echo $this->translator->trans(
                    'The minimum purchase order quantity for the product is %quantity%.',
                    ['%quantity%' => $product['minimal_quantity']],
                    'Shop.Theme.Checkout'
                );
                ?>
            </div>
        <?php endif ?>
        </div>
        <?php
    }

    protected function renderSmarty()
    {
        $settings = $this->getSettingsForDisplay();
        ?>
        {$stock = ['available' => ['class' => 'in-stock', 'icon' => <?php var_export($settings['in_stock_icon']) ?>],
            'unavailable' => ['class' => 'out-of-stock', 'icon' => <?php var_export($settings['out_of_stock_icon']) ?>],
            'last_remaining_items' => ['class' => 'low-stock-level',
                'icon' => <?php var_export($settings['low_stock_level_icon']) ?>
            ]
        ]}
        <div class="ce-product-stock ce-product-stock--{$stock[$product.availability].class}">
        {if $product.show_availability && $product.availability_message}
            <div class="ce-product-stock__availability">
            {if $stock[$product.availability].icon}
                <i class="{$stock[$product.availability].icon}"></i>
            {/if}
                <span class="ce-product-stock__availability-label">{$product.availability_message}</span>
            </div>
        {/if}
        {if $product.minimal_quantity > 1}
            <div class="ce-product-stock__min-quantity">
                {l s='The minimum purchase order quantity for the product is %quantity%.' sprintf=[
                    '%quantity%' => $product.minimal_quantity
                ] d='Shop.Theme.Checkout'}
            </div>
        {/if}
        </div>
        <?php
    }

    public function renderPlainContent()
    {
    }

    public function __construct($data = [], $args = [])
    {
        $this->context = \Context::getContext();
        $this->translator = $this->context->getTranslator();

        parent::__construct($data, $args);
    }
}
