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

use CE\CoreXDocumentTypesXPost as Post;
use CE\CoreXBaseXDocument as Document;

class CoreXDocumentTypesXContent extends Document
{
    protected static $maintenance = false;

    /**
     * @since 2.0.0
     * @access public
     */
    public function getName()
    {
        return 'content';
    }

    /**
     * @since 2.0.0
     * @access public
     * @static
     */
    public static function getTitle()
    {
        return __('Content');
    }

    /**
     * @since 2.1.2
     * @access protected
     * @static
     */
    protected static function getEditorPanelCategories()
    {
        $categories = parent::getEditorPanelCategories();

        if (self::$maintenance) {
            $categories['maintenance-premium'] = $categories['premium'];
            $categories['maintenance-theme-elements'] = $categories['theme-elements'];

            unset($categories['premium'], $categories['theme-elements']);
        }

        return $categories;
    }

    /**
     * @since 2.0.0
     * @access public
     */
    public function getCssWrapperSelector()
    {
        return '.elementor.elementor-' . uidval($this->getMainId())->toDefault();
    }

    /**
     * @since 2.0.0
     * @access protected
     */
    protected function _registerControls()
    {
        parent::_registerControls();

        $this->startInjection([
            'of' => 'post_title',
        ]);

        $this->addControl(
            'full_width',
            [
                'label' => __('Clear Content Wrapper'),
                'type' => ControlsManager::SWITCHER,
                'description' => sprintf(__(
                    'Not working? You can set a different selector for the content wrapper ' .
                    'in the <a href="%s" target="_blank">Settings page</a>.'
                ), Helper::getSettingsLink()),
                'selectors' => [
                    \Configuration::get('elementor_page_wrapper_selector') => 'min-width: 100%; margin: 0; padding: 0;',
                ],
            ]
        );

        $this->endInjection();

        Post::registerStyleControls($this);

        $this->updateControl(
            'section_page_style',
            [
                'label' => __('Style'),
            ]
        );
    }

    /**
     * @since 2.0.0
     * @access public
     *
     * @param array $data
     *
     * @throws \Exception
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        if (isset($this->post->_obj->hook) && stripos($this->post->_obj->hook, 'displayMaintenance') === 0) {
            self::$maintenance = true;
        }
    }

    protected function getRemoteLibraryConfig()
    {
        $config = parent::getRemoteLibraryConfig();

        $config['type'] = 'page';

        return $config;
    }
}
