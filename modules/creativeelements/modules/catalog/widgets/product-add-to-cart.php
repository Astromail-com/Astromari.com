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

class WidgetProductAddToCart extends WidgetButton
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'product-add-to-cart';
    }

    public function getTitle()
    {
        return __('Add to Cart');
    }

    public function getIcon()
    {
        return 'eicon-product-add-to-cart';
    }

    public function getCategories()
    {
        return ['product-elements'];
    }

    public function getKeywords()
    {
        return ['shop', 'store', 'product', 'button', 'add to cart', 'buy now'];
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
                    'full-details' => __('View Full Details'),
                ],
                'default' => 'add-to-cart',
                'render_type' => 'template',
            ]
        );

        $this->updateControl(
            'link',
            [
                'type' => ControlsManager::HIDDEN,
                'default' => '',
            ]
        );

        $this->updateControl(
            'text',
            [
                'default' => '',
                'placeholder' => 'Default',
            ]
        );

        $icon_options = [
            'fa fa-shopping-cart' => 'cart-fa',
            'fa fa-cart-plus' => 'cart-plus-fa',
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

            'ceicon-angle-right' => 'angle-right',
            'ceicon-arrow-right' => 'arrow-right',
            'fa fa-angle-right' => 'angle-right-fa',
            'fa fa-arrow-right' => 'arrow-right-fa',
            'fa fa-arrow-circle-right' => 'arrow-circle-right',
            'fa fa-arrow-circle-o-right' => 'arrow-circle-o-right',
            'fa fa-angle-double-right' => 'angle-double-right',
            'fa fa-caret-right' => 'caret-right',
            'fa fa-caret-square-o-right' => 'caret-square-o-right',
            'fa fa-chevron-right' => 'chevron-right',
            'fa fa-chevron-circle-right' => 'chevron-circle-right',
            'fa fa-long-arrow-right' => 'long-arrow-right',
            'fa fa-hand-o-right' => 'hand-o-right',
            'fa fa-toggle-right' => 'toggle-right',
            'ceicon-angle-left' => 'angle-left',
            'ceicon-arrow-left' => 'arrow-left',
            'fa fa-angle-left' => 'angle-left-fa',
            'fa fa-arrow-left' => 'arrow-left-fa',
            'fa fa-arrow-circle-left' => 'arrow-circle-left',
            'fa fa-arrow-circle-o-left' => 'arrow-circle-o-left',
            'fa fa-angle-double-left' => 'angle-double-left',
            'fa fa-caret-left' => 'caret-left',
            'fa fa-caret-square-o-left' => 'caret-square-o-left',
            'fa fa-chevron-left' => 'chevron-left',
            'fa fa-chevron-circle-left' => 'chevron-circle-left',
            'fa fa-long-arrow-left' => 'long-arrow-left',
            'fa fa-hand-o-left' => 'hand-o-left',
            'fa fa-toggle-left' => 'toggle-left',
        ];

        $this->updateControl(
            'icon',
            [
                'default' => 'ceicon-basket-solid',
                'options' => &$icon_options,
                'include' => array_keys($icon_options),
            ]
        );

        $this->removeControl('button_css_id');

        $this->startControlsSection(
            'section_disabled_style',
            [
                'label' => __('Disabled'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'button_type!' => 'full-details',
                ],
            ]
        );

        $this->addControl(
            'disabled_cursor',
            [
                'label' => __('Cursor'),
                'label_block' => false,
                'type' => ControlsManager::CHOOSE,
                'options' => [
                    'default' => [
                        'icon' => 'fa fa-mouse-pointer',
                    ],
                    'not-allowed' => [
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'default' => 'not-allowed',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button' => 'cursor: pointer;',
                    '{{WRAPPER}} a.elementor-button:not([href])' => 'cursor: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'disabled_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:not([href]):not(#e)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'disabled_background_color',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'default' => 'rgba(129,138,145,0.35)',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:not([href])' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'disabled_border_color',
            [
                'label' => __('Border Color'),
                'type' => ControlsManager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:not([href])' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->endControlsSection();
    }

    protected function getHtmlWrapperClass()
    {
        return parent::getHtmlWrapperClass() . ' elementor-widget-' . parent::getName();
    }

    protected function addInlineEditingAttributes($key, $toolbar = 'basic')
    {
        isset($this->preventInlineEditing) or parent::addInlineEditingAttributes($key, $toolbar);
    }

    protected function render()
    {
        $context = \Context::getContext();
        $product = &$context->smarty->tpl_vars['product']->value;
        $button_type = $this->getSettings('button_type');

        if ('full-details' === $button_type) {
            $this->addRenderAttribute('button', 'href', $product['url']);
        } elseif ($product['add_to_cart_url']) {
            $action = \Tools::toCamelCase($button_type);
            $this->addRenderAttribute('button', 'href', "#ce-action=$action{}");
        }

        if (!$this->getSettings('text')) {
            $this->preventInlineEditing = true;
            $this->setSettings(
                'text',
                'add-to-cart' === $button_type ? __('Add to Cart') : (
                    'buy-now' === $button_type ? __('Buy Now') : __('View Full Details')
                )
            );
        }
        parent::render();
    }

    public function renderPlainContent()
    {
    }

    protected function _contentTemplate()
    {
    }
}
