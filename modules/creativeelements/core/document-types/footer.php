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

use CE\CoreXBaseXHeaderFooterBase as HeaderFooterBase;

class CoreXDocumentTypesXFooter extends HeaderFooterBase
{
    public static function getProperties()
    {
        $properties = parent::getProperties();

        $properties['location'] = 'footer';

        return $properties;
    }

    public function getName()
    {
        return 'footer';
    }

    public static function getTitle()
    {
        return __('Footer');
    }
}
