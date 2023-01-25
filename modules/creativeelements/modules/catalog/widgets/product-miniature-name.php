<?php
/**
 * Creative Elements - live PageBuilder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

namespace CE;

defined('_PS_VERSION_') or die;

include_once dirname(__FILE__) . '/product-name.php';

class WidgetProductMiniatureName extends WidgetProductName
{
    public function getName()
    {
        return 'product-miniature-name';
    }

    protected function _registerControls()
    {
        parent::_registerControls();

        $this->updateControl('link_to', [
            'default' => 'custom',
        ]);

        $this->updateControl('header_size', [
            'default' => 'h3',
        ]);

        $this->updateControl('title_multiline', [
            'default' => '',
        ]);
    }

    protected function renderSmarty()
    {
        $link = $this->getSettings('link');

        empty($link['url']) or $this->addRenderAttribute('url', [
            'itemprop' => 'url',
            'content' => $link['url'],
        ]);

        parent::render();
    }
}
