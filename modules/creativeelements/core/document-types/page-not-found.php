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

use CE\CoreXBaseXThemePageDocument as ThemePageDocument;

class CoreXDocumentTypesXPageNotFound extends ThemePageDocument
{
    public function getName()
    {
        return 'page-not-found';
    }

    public static function getTitle()
    {
        return __('404 Page');
    }

    protected function getRemoteLibraryConfig()
    {
        $config = parent::getRemoteLibraryConfig();

        $config['category'] = '404 error';

        return $config;
    }
}
