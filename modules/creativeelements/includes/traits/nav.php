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

trait NavTrait
{
    protected static $li_class = 'menu-item menu-item-type-%s menu-item-%s%s%s';

    protected $indicator = 'fa fa-caret-down';

    public function getScriptDepends()
    {
        return ['smartmenus'];
    }

    public static function getPointerAnimationType($pointer)
    {
        return in_array($pointer, ['framed', 'background', 'text']) ? "animation_$pointer" : 'animation_line';
    }

    protected function registerNavContentControls(array $args = [])
    {
        $self = ${'this'};
        $layout_options = isset($args['layout_options']) ? $args['layout_options'] : [];

        if ($layout_options) {
            $self->addControl(
                'layout',
                [
                    'label' => __('Layout'),
                    'type' => ControlsManager::SELECT,
                    'default' => 'horizontal',
                    'options' => &$layout_options,
                    'frontend_available' => true,
                    'separator' => 'before',
                ]
            );
        } else {
            $self->addControl(
                'layout',
                [
                    'type' => ControlsManager::HIDDEN,
                    'default' => 'horizontal',
                    'frontend_available' => true,
                ]
            );
        }

        $self->addControl(
            'align_items',
            [
                'label' => __('Align'),
                'type' => ControlsManager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'justify' => [
                        'title' => __('Stretch'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'prefix_class' => 'elementor-nav--align-',
                'condition' => [
                    'layout!' => 'dropdown',
                ],
                'separator' => $layout_options ? '' : 'before',
            ]
        );

        $self->addControl(
            'pointer',
            [
                'label' => __('Pointer'),
                'type' => ControlsManager::SELECT,
                'default' => 'underline',
                'options' => [
                    'none' => __('None'),
                    'underline' => __('Underline'),
                    'overline' => __('Overline'),
                    'double-line' => __('Double Line'),
                    'framed' => __('Framed'),
                    'background' => __('Background'),
                    'text' => __('Text'),
                ],
                'condition' => [
                    'layout!' => 'dropdown',
                ],
            ]
        );

        $self->addControl(
            'animation_line',
            [
                'label' => __('Animation'),
                'type' => ControlsManager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => 'Fade',
                    'slide' => 'Slide',
                    'grow' => 'Grow',
                    'drop-in' => 'Drop In',
                    'drop-out' => 'Drop Out',
                    'none' => 'None',
                ],
                'condition' => [
                    'layout!' => 'dropdown',
                    'pointer' => ['underline', 'overline', 'double-line'],
                ],
            ]
        );

        $self->addControl(
            'animation_framed',
            [
                'label' => __('Animation'),
                'type' => ControlsManager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => 'Fade',
                    'grow' => 'Grow',
                    'shrink' => 'Shrink',
                    'draw' => 'Draw',
                    'corners' => 'Corners',
                    'none' => 'None',
                ],
                'condition' => [
                    'layout!' => 'dropdown',
                    'pointer' => 'framed',
                ],
            ]
        );

        $self->addControl(
            'animation_background',
            [
                'label' => __('Animation'),
                'type' => ControlsManager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => 'Fade',
                    'grow' => 'Grow',
                    'shrink' => 'Shrink',
                    'sweep-left' => 'Sweep Left',
                    'sweep-right' => 'Sweep Right',
                    'sweep-up' => 'Sweep Up',
                    'sweep-down' => 'Sweep Down',
                    'shutter-in-vertical' => 'Shutter In Vertical',
                    'shutter-out-vertical' => 'Shutter Out Vertical',
                    'shutter-in-horizontal' => 'Shutter In Horizontal',
                    'shutter-out-horizontal' => 'Shutter Out Horizontal',
                    'none' => 'None',
                ],
                'condition' => [
                    'layout!' => 'dropdown',
                    'pointer' => 'background',
                ],
            ]
        );

        $self->addControl(
            'animation_text',
            [
                'label' => __('Animation'),
                'type' => ControlsManager::SELECT,
                'default' => 'grow',
                'options' => [
                    'grow' => 'Grow',
                    'shrink' => 'Shrink',
                    'sink' => 'Sink',
                    'float' => 'Float',
                    'skew' => 'Skew',
                    'rotate' => 'Rotate',
                    'none' => 'None',
                ],
                'condition' => [
                    'layout!' => 'dropdown',
                    'pointer' => 'text',
                ],
            ]
        );

        $indicator_options = [
            'fa fa-caret-down' => 'classic',
            'fa fa-angle-down' => 'angle',
            'fa fa-chevron-down' => 'chevron',
            'fa fa-plus' => 'plus',
        ];

        $submenu_condition = isset($args['submenu_condition']) ? $args['submenu_condition'] : [];

        $self->addControl(
            'indicator',
            [
                'label' => __('Submenu Indicator'),
                'label_block' => false,
                'type' => ControlsManager::ICON,
                'default' => $self->indicator,
                'options' => &$indicator_options,
                'include' => array_keys($indicator_options),
                'condition' => $submenu_condition,
            ]
        );

        if (isset($layout_options['dropdown'])) {
            $submenu_condition['layout!'] = 'dropdown';
        }

        $self->addControl(
            'align_submenu',
            [
                'label' => __('Submenu Align'),
                'type' => ControlsManager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'frontend_available' => true,
                'condition' => $submenu_condition,
            ]
        );

        $self->addControl(
            'show_submenu_on',
            [
                'label' => __('Show Submenu'),
                'type' => ControlsManager::SELECT,
                'label_block' => false,
                'default' => 'hover',
                'options' => [
                    'hover' => __('On Hover'),
                    'click' => __('On Click'),
                ],
                'frontend_available' => true,
                'condition' => $submenu_condition,
            ]
        );
    }

    protected function registerNavStyleSection(array $args = [])
    {
        $self = ${'this'};
        $devices = isset($args['devices']) ? $args['devices'] : [
            'desktop',
            'tablet',
            'mobile',
        ];

        $self->startControlsSection(
            'section_style_nav',
            [
                'label' => $self->getTitle(),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => isset($args['condition']) ? $args['condition'] : [],
            ]
        );

        $self->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'menu_typography',
                'scheme' => empty($args['scheme']) ? null : SchemeTypography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-nav--main',
            ]
        );

        $self->startControlsTabs('tabs_menu_item_style');

        $self->startControlsTab(
            'tab_menu_item_normal',
            [
                'label' => __('Normal'),
            ]
        );

        $self->addControl(
            'color_menu_item',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'scheme' => empty($args['scheme']) ? null : [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_3,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item:not(#e)' => 'color: {{VALUE}}',
                ],
            ]
        );

        empty($args['show_icon']) or $self->addControl(
            'color_icon',
            [
                'label' => __('Icon Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-item > i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $self->endControlsTab();

        $self->startControlsTab(
            'tab_menu_item_hover',
            [
                'label' => __('Hover'),
            ]
        );

        $self->addControl(
            'color_menu_item_hover',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'scheme' => empty($args['scheme']) ? null : [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item.elementor-item-active:not(#e), ' .
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item.highlighted:not(#e), ' .
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item:not(#e):hover, ' .
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item:not(#e):focus' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'pointer!' => 'background',
                ],
            ]
        );

        empty($args['show_icon']) or $self->addControl(
            'color_icon_hover',
            [
                'label' => __('Icon Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-item:hover > i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $self->addControl(
            'color_menu_item_hover_pointer_bg',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item.elementor-item-active:not(#e), ' .
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item.highlighted:not(#e), ' .
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item:not(#e):hover, ' .
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item:not(#e):focus' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'pointer' => 'background',
                ],
            ]
        );

        $self->addControl(
            'pointer_color_menu_item_hover',
            [
                'label' => __('Pointer Color'),
                'type' => ControlsManager::COLOR,
                'scheme' => empty($args['scheme']) ? null : [
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_4,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--main:not(.e--pointer-framed) .elementor-item:before, ' .
                    '{{WRAPPER}} .elementor-nav--main:not(.e--pointer-framed) .elementor-item:after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .e--pointer-framed .elementor-item:before, ' .
                    '{{WRAPPER}} .e--pointer-framed .elementor-item:after' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'pointer!' => ['none', 'text'],
                ],
            ]
        );

        $self->endControlsTab();

        $self->startControlsTab(
            'tab_menu_item_active',
            [
                'label' => __('Active'),
                'condition' => isset($args['active_condition']) ? $args['active_condition'] : [],
            ]
        );

        $self->addControl(
            'color_menu_item_active',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--main a.elementor-item.elementor-item-active:not(#e)' => 'color: {{VALUE}}',
                ],
            ]
        );

        $self->addControl(
            'pointer_color_menu_item_active',
            [
                'label' => __('Pointer Color'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:before, ' .
                    '{{WRAPPER}} .elementor-nav--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .e--pointer-framed .elementor-item.elementor-item-active:before, ' .
                    '{{WRAPPER}} .e--pointer-framed .elementor-item.elementor-item-active:after' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'pointer!' => ['none', 'text'],
                ],
            ]
        );

        $self->endControlsTab();

        $self->endControlsTabs();

        $self->addResponsiveControl(
            'padding_horizontal_menu_item',
            [
                'label' => __('Horizontal Padding'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'devices' => $devices,
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--main .elementor-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',
            ]
        );

        $self->addResponsiveControl(
            'padding_vertical_menu_item',
            [
                'label' => __('Vertical Padding'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'devices' => $devices,
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--main .elementor-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        empty($args['show_icon']) or $self->addControl(
            'icon_size',
            [
                'label' => __('Icon Size'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-item > i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $self->addResponsiveControl(
            'menu_space_between',
            [
                'label' => __('Space Between'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'devices' => $devices,
                'selectors' => [
                    'body:not(.lang-rtl) {{WRAPPER}} .elementor-nav--layout-horizontal .elementor-nav > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
                    'body.lang-rtl {{WRAPPER}} .elementor-nav--layout-horizontal .elementor-nav > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-nav--main:not(.elementor-nav--layout-horizontal) .elementor-nav > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => isset($args['space_between_condition']) ? $args['space_between_condition'] : [],
            ]
        );

        $self->addResponsiveControl(
            'border_radius_menu_item',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'devices' => $devices,
                'selectors' => [
                    '{{WRAPPER}} .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
                    '{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:after' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:before' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
                    '{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:after' => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'pointer' => 'background',
                ],
            ]
        );

        $self->addControl(
            'pointer_width',
            [
                'label' => __('Pointer Width'),
                'type' => ControlsManager::SLIDER,
                'devices' => $devices,
                'range' => [
                    'px' => [
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .e--pointer-framed .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:before' => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:after' => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
                    '{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:after' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
                    '{{WRAPPER}} .e--pointer-underline .elementor-item:after, ' .
                    '{{WRAPPER}} .e--pointer-overline .elementor-item:before, ' .
                    '{{WRAPPER}} .e--pointer-double-line .elementor-item:before, ' .
                    '{{WRAPPER}} .e--pointer-double-line .elementor-item:after' => 'height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'pointer' => ['underline', 'overline', 'double-line', 'framed'],
                ],
            ]
        );

        $self->endControlsSection();
    }

    protected function registerDropdownStyleSection(array $args = [])
    {
        $self = ${'this'};

        $self->startControlsSection(
            'section_style_dropdown',
            [
                'label' => __('Dropdown'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => isset($args['dropdown_condition']) ? $args['dropdown_condition'] : [],
            ]
        );

        empty($args['show_description']) or $self->addControl(
            'dropdown_description',
            [
                'raw' => __('On desktop, this will affect the submenu. On mobile, this will affect the entire menu.'),
                'type' => ControlsManager::RAW_HTML,
                'content_classes' => 'elementor-descriptor',
                'separator' => 'after',
            ]
        );

        $self->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'dropdown_typography',
                'scheme' => empty($args['scheme']) ? null : SchemeTypography::TYPOGRAPHY_4,
                'exclude' => ['line_height'],
                'selector' => '{{WRAPPER}} .elementor-nav--dropdown',
            ]
        );

        $self->startControlsTabs('tabs_dropdown_item_style');

        $self->startControlsTab(
            'tab_dropdown_item_normal',
            [
                'label' => __('Normal'),
            ]
        );

        $self->addControl(
            'color_dropdown_item',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown a:not(#e), {{WRAPPER}} .elementor-menu-toggle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $self->addControl(
            'background_color_dropdown_item',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $self->endControlsTab();

        $self->startControlsTab(
            'tab_dropdown_item_hover',
            [
                'label' => __('Hover'),
            ]
        );

        $self->addControl(
            'color_dropdown_item_hover',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown a.elementor-item-active:not(#e), ' .
                    '{{WRAPPER}} .elementor-nav--dropdown a.highlighted:not(#e), ' .
                    '{{WRAPPER}} .elementor-nav--dropdown a:not(#e):hover, ' .
                    '{{WRAPPER}} .elementor-menu-toggle:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $self->addControl(
            'background_color_dropdown_item_hover',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown a:hover, ' .
                    '{{WRAPPER}} .elementor-nav--dropdown a.elementor-item-active, ' .
                    '{{WRAPPER}} .elementor-nav--dropdown a.highlighted' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $self->endControlsTab();

        $self->startControlsTab(
            'tab_dropdown_item_active',
            [
                'label' => __('Active'),
                'condition' => isset($args['active_condition']) ? $args['active_condition'] : [],
            ]
        );

        $self->addControl(
            'color_dropdown_item_active',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown a.elementor-item-active:not(#e)' => 'color: {{VALUE}}',
                ],
            ]
        );

        $self->addControl(
            'background_color_dropdown_item_active',
            [
                'label' => __('Background Color'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown a.elementor-item-active' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $self->endControlsTab();

        $self->endControlsTabs();

        $self->addGroupControl(
            GroupControlBorder::getType(),
            [
                'name' => 'dropdown_border',
                'selector' => '{{WRAPPER}} .elementor-nav--dropdown',
                'separator' => 'before',
            ]
        );

        $self->addResponsiveControl(
            'dropdown_border_radius',
            [
                'label' => __('Border Radius'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-nav--dropdown li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-nav--dropdown li:last-child a' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $self->addGroupControl(
            GroupControlBoxShadow::getType(),
            [
                'name' => 'dropdown_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .elementor-nav--main .elementor-nav--dropdown, {{WRAPPER}} .elementor-nav__container.elementor-nav--dropdown',
            ]
        );

        $self->addResponsiveControl(
            'padding_horizontal_dropdown_item',
            [
                'label' => __('Horizontal Padding'),
                'type' => ControlsManager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',

            ]
        );

        $self->addResponsiveControl(
            'padding_vertical_dropdown_item',
            [
                'label' => __('Vertical Padding'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $self->addControl(
            'heading_dropdown_divider',
            [
                'label' => __('Divider'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            ]
        );

        $self->addGroupControl(
            GroupControlBorder::getType(),
            [
                'name' => 'dropdown_divider',
                'selector' => '{{WRAPPER}} .elementor-nav--dropdown li:not(:last-child)',
                'exclude' => ['width'],
            ]
        );

        $self->addControl(
            'dropdown_divider_width',
            [
                'label' => __('Border Width'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--dropdown li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dropdown_divider_border!' => '',
                ],
            ]
        );

        $self->addResponsiveControl(
            'dropdown_top_distance',
            [
                'label' => __('Distance'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-nav--main > .elementor-nav > li > .elementor-nav--dropdown, ' .
                    '{{WRAPPER}} .elementor-nav__container.elementor-nav--dropdown' => 'margin-top: {{SIZE}}{{UNIT}} !important',
                ],
                'separator' => 'before',
            ]
        );

        $self->endControlsSection();
    }
}
