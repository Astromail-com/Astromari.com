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

use CE\CoreXBaseXThemeDocument as ThemeDocument;
use CE\CoreXDocumentTypesXPost as Post;
use CE\TemplateLibraryXSourceLocal as SourceLocal;

abstract class CoreXBaseXThemePageDocument extends ThemeDocument
{
    public function getCssWrapperSelector()
    {
        return 'body.ce-theme-' . \Tools::substr($this->getMainId(), 0, -6);
    }

    protected function _registerControls()
    {
        parent::_registerControls();

        if ('product' !== $this->getName()) {
            Post::registerPostFieldsControl($this);
        }

        Post::registerStyleControls($this);
    }
}
