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

class WidgetSiteTitle extends WidgetHeading
{
    public function getName()
    {
        return 'theme-site-title';
    }

    public function getTitle()
    {
        return __('Shop Title');
    }

    public function getIcon()
    {
        return 'eicon-site-title';
    }

    public function getCategories()
    {
        return ['theme-elements', 'maintenance-theme-elements'];
    }

    public function getKeywords()
    {
        return ['shop', 'title', 'name'];
    }

    protected function _registerControls()
    {
        parent::_registerControls();

        $this->updateControl('title', [
            'dynamic' => ['default' => Plugin::$instance->dynamic_tags->tagDataToTagText(null, 'site-title')],
            'default' => \Configuration::get('PS_SHOP_NAME'),
        ], [
            'recursive' => true,
        ]);

        $this->updateControl('link', [
            'dynamic' => ['default' => Plugin::$instance->dynamic_tags->tagDataToTagText(null, 'site-url')],
            'default' => ['url' => __PS_BASE_URI__],
        ], [
            'recursive' => true,
        ]);
    }

    protected function getHtmlWrapperClass()
    {
        return parent::getHtmlWrapperClass() . ' elementor-widget-' . parent::getName();
    }
}
