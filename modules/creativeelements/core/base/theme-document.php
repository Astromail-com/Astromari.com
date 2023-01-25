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

use CE\CoreXBaseXDocument as Document;

abstract class CoreXBaseXThemeDocument extends Document
{
    /*
    public static function getPreviewAsDefault()
    {
        return '';
    }

    public static function getPreviewAsOptions()
    {
        return [];
    }
    */
    public static function getProperties()
    {
        $properties = parent::getProperties();

        $properties['show_in_library'] = true;
        $properties['register_type'] = true;

        return $properties;
    }

    public function _getInitialConfig()
    {
        $config = parent::_getInitialConfig();

        $config['library'] = [
            'save_as_same_type' => true,
        ];

        return $config;
    }

    // protected function _registerControls()
}
