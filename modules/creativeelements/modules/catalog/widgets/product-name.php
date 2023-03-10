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

class WidgetProductName extends WidgetHeading
{
    public function getName()
    {
        return 'product-name';
    }

    public function getTitle()
    {
        return __('Product Name');
    }

    public function getIcon()
    {
        return 'eicon-product-title';
    }

    public function getCategories()
    {
        return ['product-elements'];
    }

    public function getKeywords()
    {
        return ['shop', 'store', 'title', 'name', 'heading', 'product'];
    }

    protected function _registerControls()
    {
        parent::_registerControls();

        $this->updateControl(
            'title',
            [
                'dynamic' => [
                    'default' => Plugin::$instance->dynamic_tags->tagDataToTagText(null, 'product-name'),
                ],
            ],
            [
                'recursive' => true,
            ]
        );

        $this->addControl(
            'link_to',
            [
                'label' => __('Link'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    '' => __('None'),
                    'custom' => __('Product'),
                ],
                'separator' => 'before',
            ],
            [
                'position' => [
                    'of' => 'title',
                ],
            ]
        );

        $this->updateControl(
            'link',
            [
                'label' => '',
                'type' => ControlsManager::URL,
                'dynamic' => [
                    'default' => Plugin::$instance->dynamic_tags->tagDataToTagText(null, 'product-url'),
                ],
                'separator' => '',
                'condition' => [
                    'link_to!' => '',
                ],
            ],
            [
                'recursive' => true,
            ]
        );

        $this->updateControl(
            'header_size',
            [
                'default' => 'h1',
            ]
        );

        $this->addControl(
            'title_multiline',
            [
                'label' => __('Allow Multiline'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('Yes'),
                'label_off' => __('No'),
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .ce-product-name' => 'white-space: normal;',
                ],
            ],
            [
                'position' => [
                    'of' => 'title_color',
                    'at' => 'before',
                ],
            ]
        );
    }

    protected function getHtmlWrapperClass()
    {
        return parent::getHtmlWrapperClass() . ' elementor-widget-heading';
    }

    protected function render()
    {
        // Backward compatibility
        $this->getSettings('__dynamic__') or $this->setSettings('__dynamic__', [
            'title' => Plugin::$instance->dynamic_tags->tagDataToTagText(null, 'product-name'),
            'link' => Plugin::$instance->dynamic_tags->tagDataToTagText(null, 'product-url'),
        ]);

        $this->addRenderAttribute('title', [
            'class' => 'ce-product-name',
            'itemprop' => 'name',
        ]);

        parent::render();
    }

    protected function _contentTemplate()
    {
        ?>
        <# settings.link.url = settings.link_to && settings.link.url #>
        <?php
        parent::_contentTemplate();
    }

    public function renderPlainContent()
    {
    }
}
