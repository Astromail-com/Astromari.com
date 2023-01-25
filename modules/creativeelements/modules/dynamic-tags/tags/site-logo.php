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

use CE\CoreXDynamicTagsXDataTag as DataTag;
use CE\ModulesXDynamicTagsXModule as Module;

class ModulesXDynamicTagsXTagsXSiteLogo extends DataTag
{
    public function getName()
    {
        return 'site-logo';
    }

    public function getTitle()
    {
        return __('Shop Logo');
    }

    public function getGroup()
    {
        return Module::SITE_GROUP;
    }

    public function getCategories()
    {
        return [Module::IMAGE_CATEGORY];
    }

    public function getValue(array $options = [])
    {
        return [
            'id' => '',
            'url' => 'img/' . \Configuration::get('PS_LOGO'),
        ];
    }

    protected function getSmartyValue(array $options = [])
    {
        return [
            'id' => '',
            'url' => 'img/{Configuration::get(PS_LOGO)}',
        ];
    }
}
