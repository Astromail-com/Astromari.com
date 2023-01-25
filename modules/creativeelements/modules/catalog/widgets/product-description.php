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

class WidgetProductDescription extends WidgetBase
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'product-description';
    }

    public function getTitle()
    {
        return __('Product Description');
    }

    public function getIcon()
    {
        return 'eicon-align-left';
    }

    public function getCategories()
    {
        return ['product-elements'];
    }

    public function getKeywords()
    {
        return ['shop', 'store', 'text', 'description', 'product'];
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_style',
            [
                'label' => __('Style'),
                'tab' => ControlsManager::TAB_STYLE,
            ]
        );

        $this->addResponsiveControl(
            'text_align',
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
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->addControl(
            'text_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'text_typography',
                'label' => __('Typography'),
                'selector' => '{{WRAPPER}} .ce-product-description',
            ]
        );

        $this->endControlsSection();
    }

    protected function getHtmlWrapperClass()
    {
        return parent::getHtmlWrapperClass() . ' elementor-widget-text-editor';
    }

    protected function render()
    {
        $context = \Context::getContext();
        $product = &$context->smarty->tpl_vars['product']->value;

        if (\Tools::getValue('render') === 'widget') {
            UId::$_ID = new UId($product['id_product'], UId::PRODUCT, $context->language->id, $context->shop->id);

            $product['description'] = apply_filters('the_content', $product['description']);
        }
        ?>
        <div class="ce-product-description"><?= $product['description'] ?></div>
        <?php
    }

    public function renderPlainContent()
    {
    }
}
