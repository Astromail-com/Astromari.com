<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks, Elementor
 * @copyright 2019-2022 WebshopWorks.com & Elementor.com
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CE;

defined('_PS_VERSION_') or die;

/**
 * Shopping Cart widget
 *
 * @since 2.5.0
 */
class WidgetShoppingCart extends WidgetBase
{
    const REMOTE_RENDER = true;

    protected $context;

    protected $imageSize;

    /**
     * Get widget name.
     *
     * @since 2.5.0
     * @access public
     *
     * @return string Widget name.
     */
    public function getName()
    {
        return 'shopping-cart';
    }

    /**
     * Get widget title.
     *
     * @since 2.5.0
     * @access public
     *
     * @return string Widget title.
     */
    public function getTitle()
    {
        return __('Shopping Cart');
    }

    /**
     * Get widget icon.
     *
     * @since 2.5.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function getIcon()
    {
        return 'eicon-cart';
    }

    /**
     * Get widget categories.
     *
     * @since 2.5.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function getCategories()
    {
        return ['theme-elements'];
    }

    /**
     * Get widget keywords.
     *
     * @since 2.5.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function getKeywords()
    {
        return ['shopping', 'cart', 'basket', 'bag'];
    }

    /**
     * Register shopping cart widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 2.5.0
     * @access protected
     */
    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_shopping_cart',
            [
                'label' => __('Shopping Cart'),
            ]
        );

        $this->addControl(
            'skin',
            [
                'label' => __('Skin'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'classic' => __('Classic'),
                    'sidebar' => __('Sidebar'),
                ],
                'default' => 'sidebar',
            ]
        );

        $this->addControl(
            'title',
            [
                'label' => __('Title'),
                'type' => ControlsManager::TEXT,
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addControl(
            'empty_message',
            [
                'label' => __('Empty Message'),
                'type' => ControlsManager::TEXT,
                'label_block' => true,
                'default' => __('No products in the cart.'),
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addControl(
            'show_shipping',
            [
                'label' => __('Shipping Price'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('Show'),
                'label_off' => __('Hide'),
                'default' => 'yes',
                'prefix_class' => 'elementor-cart--show-shipping-',
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addControl(
            'show_view_cart',
            [
                'label' => __('View Cart'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('Show'),
                'label_off' => __('Hide'),
                'prefix_class' => 'elementor-cart--show-view-cart-',
                'default' => 'yes',
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addControl(
            'checkout',
            [
                'label' => __('Buttons'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Checkout'),
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addControl(
            'view_cart',
            [
                'type' => ControlsManager::TEXT,
                'placeholder' => __('View Cart'),
                'condition' => [
                    'skin' => 'sidebar',
                    'show_view_cart!' => '',
                ],
            ]
        );

        $this->addControl(
            'heading_toggle',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Toggle'),
                'separator' => 'before',
            ]
        );

        $icon_options = [
            'fa fa-shopping-cart' => 'cart-fa',
            'ceicon-cart-light' => 'cart-light',
            'ceicon-cart-medium' => 'cart-medium',
            'ceicon-cart-solid' => 'cart-solid',
            'ceicon-trolley-light' => 'trolley-light',
            'ceicon-trolley-medium' => 'trolley-medium',
            'ceicon-trolley-solid' => 'trolley-solid',
            'ceicon-trolley-bold' => 'trolley-bold',
            'fa fa-shopping-basket' => 'basket-fa',
            'ceicon-basket-light' => 'basket-light',
            'ceicon-basket-medium' => 'basket-medium',
            'ceicon-basket-solid' => 'basket-solid',
            'fa fa-shopping-bag' => 'bag-fa',
            'ceicon-bag-light' => 'bag-light',
            'ceicon-bag-medium' => 'bag-medium',
            'ceicon-bag-solid' => 'bag-solid',
            'ceicon-bag-rounded-o' => 'bag-rounded-o',
            'ceicon-bag-rounded' => 'bag-rounded',
            'ceicon-bag-trapeze-o' => 'bag-trapeze-o',
            'ceicon-bag-trapeze' => 'bag-trapeze',
        ];

        $this->addControl(
            'icon',
            [
                'label' => __('Icon'),
                'type' => ControlsManager::ICON,
                'default' => 'ceicon-basket-solid',
                'options' => &$icon_options,
                'include' => array_keys($icon_options),
            ]
        );

        $this->addControl(
            'icon_align',
            [
                'label' => __('Icon Position'),
                'type' => ControlsManager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => __('Before'),
                    'right' => __('After'),
                ],
                'prefix_class' => 'elementor-cart--align-icon-',
                'condition' => [
                    'show_subtotal!' => '',
                ],
            ]
        );

        $this->addControl(
            'items_indicator',
            [
                'label' => __('Items Indicator'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'none' => __('None'),
                    'bubble' => __('Bubble'),
                    // 'plain' => __('Plain'),
                ],
                'prefix_class' => 'elementor-cart--items-indicator-',
                'default' => 'bubble',
            ]
        );

        $this->addControl(
            'hide_empty_indicator',
            [
                'label' => __('Hide Empty'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('Yes'),
                'label_off' => __('No'),
                'return_value' => 'hide',
                'prefix_class' => 'elementor-cart--empty-indicator-',
                'condition' => [
                    'items_indicator!' => 'none',
                ],
            ]
        );

        $this->addControl(
            'show_subtotal',
            [
                'label' => __('Subtotal'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('Show'),
                'label_off' => __('Hide'),
                'return_value' => 'yes',
                'default' => 'yes',
                'prefix_class' => 'elementor-cart--show-subtotal-',
            ]
        );

        $this->addControl(
            'alignment',
            [
                'label' => __('Alignment'),
                'type' => ControlsManager::CHOOSE,
                'label_block' => false,
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
                    '{{WRAPPER}} .elementor-cart__toggle' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'heading_atc_action',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Add to Cart Action'),
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'action_show_modal',
            [
                'label' => __('Show Modal'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('On'),
                'label_off' => __('Off'),
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->addControl(
            'action_open_cart',
            [
                'label' => __('Open Shopping Cart'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('On'),
                'label_off' => __('Off'),
                'frontend_available' => true,
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addControl(
            'modal_url',
            [
                'type' => ControlsManager::HIDDEN,
                'default' => $this->context->link->getModuleLink('creativeelements', 'ajax', [], true),
                'condition' => [
                    'action_show_modal!' => '',
                ],
                'frontend_available' => true,
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_toggle_style',
            [
                'label' => __('Toggle'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->startControlsTabs('toggle_button_colors');

        $this->startControlsTab('toggle_button_normal_colors', ['label' => __('Normal')]);

        $this->addControl(
            'toggle_button_text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle a.elementor-button:not(#e)' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_subtotal!' => '',
                ],
            ]
        );

        $this->addControl(
            'toggle_button_icon_color',
            [
                'label' => __('Icon Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'toggle_button_background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'toggle_button_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab('toggle_button_hover_colors', ['label' => __('Hover')]);

        $this->addControl(
            'toggle_button_hover_text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle a.elementor-button:not(#e):hover' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_subtotal!' => '',
                ],
            ]
        );

        $this->addControl(
            'toggle_button_hover_icon_color',
            [
                'label' => __('Icon Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button:hover .elementor-button-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'toggle_button_hover_background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'toggle_button_hover_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->addControl(
            'toggle_button_border_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addControl(
            'toggle_button_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],

            ]
        );

        $this->addResponsiveControl(
            'toggle_button_padding',
            [
                'label' => __('Padding'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'toggle_button_typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-cart__toggle .elementor-button',
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'heading_icon_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Icon'),
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'toggle_icon_size',
            [
                'label' => __('Size'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addControl(
            'toggle_icon_spacing',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size-units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}}.elementor-cart--align-icon-left .elementor-cart__toggle .elementor-button-text' => 'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.elementor-cart--align-icon-right .elementor-cart__toggle .elementor-button-text' => 'margin-right: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'show_subtotal!' => '',
                ],
            ]
        );

        $this->addControl(
            'items_indicator_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Items Indicator'),
                'separator' => 'before',
                'condition' => [
                    'items_indicator!' => 'none',
                ],
            ]
        );
        $this->addControl(
            'items_indicator_text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button-icon[data-counter]:before' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'items_indicator!' => 'none',
                ],
            ]
        );

        $this->addControl(
            'items_indicator_background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button-icon[data-counter]:before' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'items_indicator' => 'bubble',
                ],
            ]
        );

        $this->addControl(
            'items_indicator_distance_top',
            [
                'label' => __('Top Distance'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'unit' => 'em',
                ],
                'range' => [
                    'em' => [
                        'min' => -4,
                        'max' => 4,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button-icon[data-counter]:before' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'items_indicator' => 'bubble',
                ],
            ]
        );

        $this->addControl(
            'items_indicator_distance_right',
            [
                'label' => __('Right Distance'),
                'type' => ControlsManager::SLIDER,
                'default' => [
                    'unit' => 'em',
                ],
                'range' => [
                    'em' => [
                        'min' => -4,
                        'max' => 4,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__toggle .elementor-button-icon[data-counter]:before' => 'right: calc(0em - {{SIZE}}{{UNIT}})',
                ],
                'condition' => [
                    'items_indicator' => 'bubble',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_cart_style',
            [
                'label' => __('Shopping Cart'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlBackground::getType(),
            [
                'name' => 'cart_background',
                'selector' => '{{WRAPPER}} .elementor-cart__main',
            ]
        );

        $this->addControl(
            'lightbox_color',
            [
                'label' => __('Overlay Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__container' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'lightbox_ui_color',
            [
                'label' => __('UI Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__close-button, {{WRAPPER}} .elementor-cart__product-remove' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'lightbox_ui_color_hover',
            [
                'label' => __('UI Hover Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__close-button:hover, {{WRAPPER}} .elementor-cart__product-remove:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'heading_title_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Title'),
                'separator' => 'before',
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->addControl(
            'title_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-cart__title',
                'condition' => [
                    'title!' => '',
                ],
            ]
        );

        $this->addControl(
            'heading_empty_message_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Empty Message'),
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'empty_message_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__empty-message' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'empty_message_typography',
                'selector' => '{{WRAPPER}} .elementor-cart__empty-message',
            ]
        );

        $this->addControl(
            'heading_product_divider_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Divider'),
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'divider_style',
            [
                'label' => __('Style'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    '' => __('Default'),
                    'none' => __('None'),
                    'solid' => __('Solid'),
                    'double' => __('Double'),
                    'dotted' => __('Dotted'),
                    'dashed' => __('Dashed'),
                    'groove' => __('Groove'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__product:not(:last-of-type), {{WRAPPER}} .elementor-cart__products, {{WRAPPER}} .elementor-cart__summary' => 'border-bottom-style: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'divider_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__product:not(:last-of-type), {{WRAPPER}} .elementor-cart__products, {{WRAPPER}} .elementor-cart__summary' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'divider_style!' => 'none',
                ]
            ]
        );

        $this->addControl(
            'divider_width',
            [
                'label' => __('Weight'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__product:not(:last-of-type), {{WRAPPER}} .elementor-cart__products, {{WRAPPER}} .elementor-cart__summary' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'divider_style!' => 'none',
                ]
            ]
        );

        $this->addResponsiveControl(
            'divider_gap',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__product, {{WRAPPER}} .elementor-cart__footer-buttons, {{WRAPPER}} .elementor-cart__summary' => 'padding-bottom: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-cart__product:not(:first-of-type), {{WRAPPER}} .elementor-cart__footer-buttons, {{WRAPPER}} .elementor-cart__summary' => 'padding-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_product_tabs_style',
            [
                'label' => __('Products'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addControl(
            'heading_product_title_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Product Title'),
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'product_title_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__product-name a:not(#e)' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'product_title_typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-cart__product-name a',
            ]
        );

        $this->addControl(
            'heading_product_attr_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Product Attributes'),
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'product_attr_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__product-attrs' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'product_attr_typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .elementor-cart__product-attr',
            ]
        );

        $this->addControl(
            'heading_product_price_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Product Price'),
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'product_price_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__product-price' => 'color: {{VALUE}}',

                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'product_price_typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-cart__product-price',
            ]
        );

        $this->addControl(
            'show_remove_icon',
            [
                'label' => __('Remove Item Icon'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('Show'),
                'label_off' => __('Hide'),
                'return_value' => 'yes',
                'default' => 'yes',
                'prefix_class' => 'elementor-cart--show-remove-button-',
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style_summary',
            [
                'label' => __('Summary'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addControl(
            'subtotal_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__summary' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'subtotal_typography',
                'selector' => '{{WRAPPER}} .elementor-cart__summary',
            ]
        );

        $this->addControl(
            'heading_total_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Total'),
                'separator' => 'before',
                'condition' => [
                    'show_shipping!' => '',
                ],
            ]
        );

        $this->addControl(
            'total_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__summary strong' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_shipping!' => '',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'total_typography',
                'selector' => '{{WRAPPER}} .elementor-cart__summary strong',
                'condition' => [
                    'show_shipping!' => '',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style_buttons',
            [
                'label' => __('Buttons'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'skin' => 'sidebar',
                ],
            ]
        );

        $this->addControl(
            'buttons_layout',
            [
                'label' => __('Layout'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'inline' => __('Inline'),
                    'stacked' => __('Stacked'),
                ],
                'default' => 'inline',
                'prefix_class' => 'elementor-cart--buttons-',
            ]
        );

        $this->addControl(
            'space_between_buttons',
            [
                'label' => __('Space Between'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__footer-buttons' => 'grid-column-gap: {{SIZE}}{{UNIT}}; grid-row-gap: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'show_view_cart!' => '',
                ],
            ]
        );

        $this->addControl(
            'button_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-cart__footer-buttons .elementor-button' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'product_buttons_typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-cart__footer-buttons .elementor-button',
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'heading_view_cart_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('View Cart'),
                'separator' => 'before',
                'condition' => [
                    'show_view_cart!' => '',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            [
                'name' => 'view_cart_border',
                'selector' => '{{WRAPPER}} .elementor-button--view-cart',
                'condition' => [
                    'show_view_cart!' => '',
                ],
            ]
        );

        $this->startControlsTabs(
            'tabs_view_cart_style',
            [
                'condition' => [
                    'show_view_cart!' => '',
                ],
            ]
        );

        $this->startControlsTab(
            'tabs_view_cart_normal',
            [
                'label' => __('Normal'),
            ]
        );

        $this->addControl(
            'view_cart_text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button--view-cart:not(#e)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'view_cart_background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button--view-cart' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tabs_view_cart_hover',
            [
                'label' => __('Hover'),
            ]
        );

        $this->addControl(
            'view_cart_text_color_hover',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button--view-cart:not(#e):hover, {{WRAPPER}} a.elementor-button--view-cart:not(#e):focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'view_cart_background_color_hover',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button--view-cart:hover, {{WRAPPER}} .elementor-button--view-cart:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'view_cart_border_color_hover',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button--view-cart:hover, {{WRAPPER}} .elementor-button--view-cart:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'view_cart_border_border!' => '',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->addControl(
            'heading_checkout_style',
            [
                'type' => ControlsManager::HEADING,
                'label' => __('Checkout'),
                'separator' => 'before',
            ]
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            [
                'name' => 'checkout_border',
                'selector' => '{{WRAPPER}} .elementor-button--checkout',
            ]
        );

        $this->startControlsTabs('tabs_checkout_style');

        $this->startControlsTab(
            'tabs_checkout_normal',
            [
                'label' => __('Normal'),
            ]
        );

        $this->addControl(
            'checkout_text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button--checkout:not(#e)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'checkout_background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button--checkout' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tabs_checkout_hover',
            [
                'label' => __('Hover'),
            ]
        );

        $this->addControl(
            'checkout_text_color_hover',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button--checkout:not(#e):hover, {{WRAPPER}} a.elementor-button--checkout:not(#e):focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'checkout_background_color_hover',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button--checkout:hover, {{WRAPPER}} .elementor-button--checkout:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'checkout_border_color_hover',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button--checkout:hover, {{WRAPPER}} .elementor-button--checkout:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'checkout_border_border!' => '',
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->endControlsSection();
    }

    /**
     * Render shopping cart widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 2.5.0
     * @access protected
     * @codingStandardsIgnoreStart Generic.Files.LineLength
     */
    protected function render()
    {
        $settings = $this->getSettingsForDisplay();
        $controller = $this->context->controller;

        $cart_is_hidden = 'sidebar' !== $settings['skin'] ||
            $controller instanceof \CartController ||
            $controller instanceof \OrderController ||
            $controller instanceof \OrderConfirmationController;
        $cart = $controller->cart_presenter->present($this->context->cart, true);

        $toggle_button_link = $this->context->link->getPageLink('cart', true, null, ['action' => 'show'], false, null, true);
        $toggle_button_classes = 'elementor-button elementor-size-sm' . ($cart_is_hidden ? ' elementor-cart-hidden' : '');
        ?>
        <div class="elementor-cart__wrapper">
            <?php if (!$cart_is_hidden) : ?>
            <div class="elementor-cart__container elementor-lightbox">
                <div class="elementor-cart__main">
                    <div class="elementor-cart__close-button ceicon-close"></div>
                    <div class="elementor-cart__title"><?= $settings['title'] ?></div>
                    <?php $this->renderCartContent($cart, $settings, $toggle_button_link) ?>
                </div>
            </div>
            <?php endif ?>
            <div class="elementor-cart__toggle elementor-button-wrapper">
                <a href="<?= esc_attr($toggle_button_link) ?>" class="<?= $toggle_button_classes ?>">
                    <span class="elementor-button-icon" data-counter="<?= (int) $cart['products_count'] ?>">
                        <i class="<?= esc_attr($this->getSettings('icon')) ?>" aria-hidden="true"></i>
                        <span class="elementor-screen-only"><?= __('Shopping Cart') ?></span>
                    </span>
                    <span class="elementor-button-text"><?= $cart['subtotals']['products']['value'] ?></span>
                </a>
            </div>
        </div>
        <?php
    }

    protected function renderCartContent(array &$cart, array &$settings, $view_cart_link)
    {
        $checkout_link = $this->context->smarty->tpl_vars['urls']->value['pages']['order'];
        $checkout_disabled = $cart['minimalPurchaseRequired'] || !$cart['products'] ? ' ce-disabled' : '';
        ?>
        <div class="elementor-cart__empty-message<?= $cart['products'] ? ' elementor-hidden' : '' ?>"><?= $settings['empty_message'] ?></div>
        <div class="elementor-cart__products" data-gift="<?= esc_attr__('Gift') ?>">
            <?php
            foreach ($cart['products'] as $product) {
                $this->renderCartItem($product);
            }
            // echo \Hook::exec('displayShoppingCart');
            ?>
        </div>
        <div class="elementor-cart__summary">
            <div class="elementor-cart__summary-label"><?= $cart['summary_string'] ?></div>
            <div class="elementor-cart__summary-value"><?= $cart['subtotals']['products']['value'] ?></div>
            <span class="elementor-cart__summary-label"><?= $cart['subtotals']['shipping']['label'] ?></span>
            <span class="elementor-cart__summary-value"><?= $cart['subtotals']['shipping']['value'] ?></span>
            <strong class="elementor-cart__summary-label"><?= $cart['totals']['total']['label'] ?></strong>
            <strong class="elementor-cart__summary-value"><?= $cart['totals']['total']['value'] ?></strong>
        </div>
        <div class="elementor-alert elementor-alert-warning<?= $cart['minimalPurchaseRequired'] ? '' : ' elementor-hidden' ?>" role="alert">
            <span class="elementor-alert-description"><?= $cart['minimalPurchaseRequired'] ?></span>
        </div>
        <div class="elementor-cart__footer-buttons">
            <a href="<?= esc_attr($view_cart_link) ?>" class="elementor-button elementor-button--view-cart elementor-size-md">
                <span class="elementor-button-text"><?= !empty($settings['view_cart']) ? $settings['view_cart'] : __('View Cart') ?></span>
            </a>
            <a href="<?= esc_attr($checkout_link) ?>" class="elementor-button elementor-button--checkout elementor-size-md <?= $checkout_disabled ?>">
                <span class="elementor-button-text"><?= !empty($settings['checkout']) ? $settings['checkout'] : __('Checkout') ?></span>
            </a>
            <?php // echo \Hook::exec('displayExpressCheckout') ?>
        </div>
        <?php
        // echo \Hook::exec('displayReassurance');
    }

    protected function renderCartItem($product)
    {
        $cover = isset($product['default_image']) ? $product['default_image'] : $product['cover'] ?: Helper::getNoImage();
        $cover_image = isset($cover['bySize'][$this->imageSize]) ? $cover['bySize'][$this->imageSize] : $cover['small'];
        ?>
        <div class="elementor-cart__product">
            <div class="elementor-cart__product-image">
                <img src="<?= esc_attr($cover_image['url']) ?>" alt="<?= esc_attr($cover['legend']) ?>">
            </div>
            <div class="elementor-cart__product-name">
                <a href="<?= esc_attr($product['url']) ?>">
                    <?= $product['name'] ?>
                </a>
                <div class="elementor-cart__product-attrs">
                <?php foreach ($product['attributes'] as $attribute => $value) : ?>
                  <div class="elementor-cart__product-attr">
                    <span class="elementor-cart__product-attr-label"><?= $attribute ?>:</span>
                    <span class="elementor-cart__product-attr-value"><?= $value ?></span>
                  </div>
                <?php endforeach ?>
                <?php foreach ($product['customizations'] as $customization) : ?>
                    <?php foreach ($customization['fields'] as &$field) : ?>
                        <div class="elementor-cart__product-attr">
                            <span class="elementor-cart__product-attr-label"><?= $field['label'] ?>:</span>
                            <span class="elementor-cart__product-attr-value">
                            <?php if ('image' === $field['type']) : ?>
                                <img src="<?= $field['image']['small']['url'] ?>" alt="">
                            <?php elseif ('text' === $field['type']) : ?>
                                <?= $field['text'] ?>
                            <?php endif;  ?>
                            </span>
                        </div>
                    <?php endforeach ?>
                <?php endforeach ?>
                </div>
            </div>
            <div class="elementor-cart__product-price">
                <span class="elementor-cart__product-quantity"><?= $product['quantity'] ?></span> &times; <?= $product['is_gift'] ? __('Gift') : $product['price'] ?>
            <?php if ($product['has_discount']) : ?>
                <del><?= $product['regular_price'] ?></del>
            <?php endif ?>
            </div>
            <div class="elementor-cart__product-remove ceicon-times">
                <a href="<?= esc_attr($product['remove_from_cart_url']) ?>" rel="nofollow"
                    data-id-product="<?= (int) $product['id_product'] ?>"
                    data-id-product-attribute="<?= (int) $product['id_product_attribute'] ?>"
                    data-id-customization="<?= (int) $product['id_customization'] ?>"
                    title="<?= esc_attr__('Remove this item') ?>"></a>
            </div>
        </div>
        <?php
    }

    public function renderPlainContent()
    {
    }

    public function __construct($data = [], $args = [])
    {
        $this->context = \Context::getContext();
        $this->imageSize = \ImageType::getFormattedName('cart');

        parent::__construct($data, $args);
    }
}
