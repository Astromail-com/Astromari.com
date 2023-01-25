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

use CE\ModulesXLibraryXDocumentsXLibraryDocument as LibraryDocument;

/**
 * Elementor section library document.
 *
 * Elementor section library document handler class is responsible for
 * handling a document of a section type.
 *
 * @since 2.0.0
 */
class ModulesXLibraryXDocumentsXSection extends LibraryDocument
{
    /**
     * Get document name.
     *
     * Retrieve the document name.
     *
     * @since 2.0.0
     * @access public
     *
     * @return string Document name.
     */
    public function getName()
    {
        return 'section';
    }

    /**
     * Get document title.
     *
     * Retrieve the document title.
     *
     * @since 2.0.0
     * @access public
     * @static
     *
     * @return string Document title.
     */
    public static function getTitle()
    {
        return __('Section');
    }
}
