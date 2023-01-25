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

use CE\CoreXSettingsXBaseXModel as BaseModel;
use CE\CoreXSettingsXGeneralXManager as Manager;

/**
 * Elementor global settings model.
 *
 * Elementor global settings model handler class is responsible for registering
 * and managing Elementor global settings models.
 *
 * @since 1.6.0
 */
class CoreXSettingsXGeneralXModel extends BaseModel
{
    /**
     * Get model name.
     *
     * Retrieve global settings model name.
     *
     * @since 1.6.0
     * @access public
     *
     * @return string Model name.
     */
    public function getName()
    {
        return 'global-settings';
    }

    /**
     * Get CSS wrapper selector.
     *
     * Retrieve the wrapper selector for the global settings model.
     *
     * @since 1.6.0
     * @access public
     *
     * @return string CSS wrapper selector.
     */

    public function getCssWrapperSelector()
    {
        return '';
    }

    /**
     * Get panel page settings.
     *
     * Retrieve the panel setting for the global settings model.
     *
     * @since 1.6.0
     * @access public
     *
     * @return array {
     *    Panel settings.
     *
     *    @type string $title The panel title.
     *    @type array  $menu  The panel menu.
     * }
     */
    public function getPanelPageSettings()
    {
        return [
            'title' => __('Global Settings'),
            'menu' => [
                'icon' => 'fa fa-cogs',
                'beforeItem' => 'elementor-settings',
            ],
        ];
    }

    /**
     * Get controls list.
     *
     * Retrieve the global settings model controls list.
     *
     * @since 1.6.0
     * @access public
     * @static
     *
     * @return array Controls list.
     */
    public static function getControlsList()
    {
        return [
            ControlsManager::TAB_STYLE => [
                'style' => [
                    'label' => __('Style'),
                    'controls' => [
                        'elementor_default_generic_fonts' => [
                            'label' => __('Default Generic Fonts'),
                            'type' => ControlsManager::TEXT,
                            'default' => 'Sans-serif',
                            'description' => __('The list of fonts used if the chosen font is not available.'),
                            'label_block' => true,
                        ],
                        'elementor_container_width' => [
                            'label' => __('Content Width') . ' (px)',
                            'type' => ControlsManager::NUMBER,
                            'min' => 300,
                            'description' => __('Sets the default width of the content area (Default: 1140)'),
                            'selectors' => [
                                '.elementor-section.elementor-section-boxed > .elementor-container' => 'max-width: {{VALUE}}px',
                            ],
                        ],
                        'elementor_space_between_widgets' => [
                            'label' => __('Widgets Space') . ' (px)',
                            'type' => ControlsManager::NUMBER,
                            'min' => 0,
                            'placeholder' => '20',
                            'description' => __('Sets the default space between widgets (Default: 20)'),
                            'selectors' => [
                                '.elementor-widget:not(:last-child)' => 'margin-bottom: {{VALUE}}px',
                            ],
                        ],
                        'elementor_stretched_section_container' => [
                            'label' => __('Stretched Section Fit To'),
                            'type' => ControlsManager::TEXT,
                            'placeholder' => 'body',
                            'description' => __('Enter parent element selector to which stretched sections will fit to (e.g. #primary / .wrapper / main etc). Leave blank to fit to page width.'),
                            'label_block' => true,
                            'frontend_available' => true,
                        ],
                        'elementor_page_title_selector' => [
                            'label' => __('Page Title Selector'),
                            'type' => ControlsManager::TEXTAREA,
                            'rows' => 1,
                            'placeholder' => 'header.page-header',
                            'description' => sprintf(
                                __("You can hide the title at document settings. This works for themes that have ”%s” selector. If your theme's selector is different, please enter it above."),
                                'header.page-header'
                            ),
                            'label_block' => true,
                        ],
                        'elementor_page_wrapper_selector' => [
                            'label' => __('Content Wrapper Selector'),
                            'type' => ControlsManager::TEXTAREA,
                            'rows' => 3,
                            'placeholder' => '#content, #wrapper, #wrapper .container',
                            'description' => sprintf(
                                __("You can clear margin, padding, max-width from content wrapper at document settings. This works for themes that have ”%s” selector. If your theme's selector is different, please enter it above."),
                                '#content, #wrapper, #wrapper .container'
                            ),
                            'label_block' => true,
                        ],
                    ],
                ],
            ],
            Manager::PANEL_TAB_LIGHTBOX => [
                'lightbox' => [
                    'label' => __('Lightbox'),
                    'controls' => [
                        'elementor_global_image_lightbox' => [
                            'label' => __('Image Lightbox'),
                            'type' => ControlsManager::SWITCHER,
                            'return_value' => '1',
                            'description' => __('Open all image links in a lightbox popup window. The lightbox will automatically work on any link that leads to an image file.'),
                            'frontend_available' => true,
                        ],
                        'elementor_enable_lightbox_in_editor' => [
                            'label' => __('Enable In Editor'),
                            'type' => ControlsManager::SWITCHER,
                            'default' => 'yes',
                            'frontend_available' => true,
                        ],
                        'elementor_lightbox_enable_counter' => [
                            'label' => __('Counter'),
                            'type' => ControlsManager::SWITCHER,
                            'default' => 'yes',
                            'frontend_available' => true,
                        ],
                        'elementor_lightbox_enable_zoom' => [
                            'label' => __('Zoom'),
                            'type' => ControlsManager::SWITCHER,
                            'default' => 'yes',
                            'frontend_available' => true,
                        ],
                        'elementor_lightbox_title_src' => [
                            'label' => __('Title'),
                            'type' => ControlsManager::SELECT,
                            'options' => [
                                '' => __('None'),
                                'title' => __('Title'),
                                'caption' => __('Caption'),
                                'alt' => __('Alt'),
                                // 'description' => __('Description'),
                            ],
                            'default' => 'title',
                            'frontend_available' => true,
                        ],
                        'elementor_lightbox_description_src' => [
                            'label' => __('Description'),
                            'type' => ControlsManager::SELECT,
                            'options' => [
                                '' => __('None'),
                                'title' => __('Title'),
                                'caption' => __('Caption'),
                                'alt' => __('Alt'),
                                // 'description' => __('Description'),
                            ],
                            'default' => 'caption',
                            'frontend_available' => true,
                        ],
                        'elementor_lightbox_color' => [
                            'label' => __('Background Color'),
                            'type' => ControlsManager::COLOR,
                            'selectors' => [
                                '.elementor-lightbox' => 'background-color: {{VALUE}}',
                            ],
                        ],
                        'elementor_lightbox_ui_color' => [
                            'label' => __('UI Color'),
                            'type' => ControlsManager::COLOR,
                            'selectors' => [
                                '.elementor-lightbox' => '--lightbox-ui-color: {{VALUE}}',
                            ],
                        ],
                        'elementor_lightbox_ui_color_hover' => [
                            'label' => __('UI Hover Color'),
                            'type' => ControlsManager::COLOR,
                            'selectors' => [
                                '.elementor-lightbox' => '--lightbox-ui-color-hover: {{VALUE}}',
                            ],
                        ],
                        'elementor_lightbox_text_color' => [
                            'label' => __('Text Color'),
                            'type' => ControlsManager::COLOR,
                            'selectors' => [
                                '.elementor-lightbox' => '--lightbox-text-color: {{VALUE}}',
                            ],
                        ],
                        'lightbox_box_shadow_type' => [
                            'label' => _x('Box Shadow', 'Box Shadow Control'),
                            'type' => ControlsManager::POPOVER_TOGGLE,
                            'return_value' => 'yes',
                            'render_type' => 'ui',
                        ],
                        'lightbox_box_shadow' => [
                            'label' => _x('Box Shadow', 'Box Shadow Control'),
                            'type' => ControlsManager::BOX_SHADOW,
                            'default' => [
                                'horizontal' => 0,
                                'vertical' => 0,
                                'blur' => 10,
                                'spread' => 0,
                                'color' => 'rgba(0,0,0,0.5)',
                            ],
                            'selectors' => [
                                '.elementor-lightbox .elementor-lightbox-image' => 'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}} {{lightbox_box_shadow_position.VALUE}};',
                            ],
                            'condition' => [
                                'lightbox_box_shadow_type!' => '',
                            ],
                            'popover' => [
                                'start' => true,
                            ],
                        ],
                        'lightbox_box_shadow_position' => [
                            'label' => 'Position',
                            'type' => ControlsManager::SELECT,
                            'options' => [
                                ' ' => 'Outline',
                                'inset' => 'Inset',
                            ],
                            'default' => ' ',
                            'render_type' => 'ui',
                            'condition' => [
                                'lightbox_box_shadow_type!' => '',
                            ],
                            'popover' => [
                                'end' => true,
                            ],
                        ],
                        'lightbox_icons_size' => [
                            'label' => __('Toolbar Icons Size'),
                            'type' => ControlsManager::SLIDER,
                            'selectors' => [
                                '.elementor-lightbox' => '--lightbox-header-icons-size: {{SIZE}}{{UNIT}}',
                            ],
                            'separator' => 'before',
                        ],
                        'lightbox_slider_icons_size' => [
                            'label' => __('Navigation Icons Size'),
                            'type' => ControlsManager::SLIDER,
                            'selectors' => [
                                '.elementor-lightbox' => '--lightbox-navigation-icons-size: {{SIZE}}{{UNIT}}',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Register model controls.
     *
     * Used to add new controls to the global settings model.
     *
     * @since 1.6.0
     * @access protected
     */
    protected function _registerControls()
    {
        $controls_list = self::getControlsList();

        foreach ($controls_list as $tab_name => $sections) {
            foreach ($sections as $section_name => $section_data) {
                $this->startControlsSection(
                    $section_name,
                    [
                        'label' => $section_data['label'],
                        'tab' => $tab_name,
                    ]
                );

                foreach ($section_data['controls'] as $control_name => $control_data) {
                    $this->addControl($control_name, $control_data);
                }

                $this->endControlsSection();
            }
        }
    }
}
