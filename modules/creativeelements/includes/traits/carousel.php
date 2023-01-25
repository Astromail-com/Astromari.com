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

trait CarouselTrait
{
    public function getScriptDepends()
    {
        return ['jquery-slick'];
    }

    protected function registerCarouselSection(array $args = [])
    {
        $self = ${'this'};
        $default_slides_count = isset($args['default_slides_count']) ? $args['default_slides_count'] : 3;
        $variable_width = isset($args['variable_width']) ? ['variable_width' => ''] : [];

        $self->startControlsSection(
            'section_additional_options',
            [
                'label' => __('Carousel'),
            ]
        );

        $self->addControl(
            'default_slides_count',
            [
                'type' => ControlsManager::HIDDEN,
                'default' => (int) $default_slides_count,
                'frontend_available' => true,
            ]
        );

        $slides_to_show = range(1, 10);
        $slides_to_show = array_combine($slides_to_show, $slides_to_show);

        $self->addResponsiveControl(
            'slides_to_show',
            [
                'label' => __('Slides to Show'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    '' => __('Default'),
                ] + $slides_to_show,
                'frontend_available' => true,
            ]
        );

        $self->addResponsiveControl(
            'slides_to_scroll',
            [
                'label' => __('Slides to Scroll'),
                'type' => ControlsManager::SELECT,
                'description' => __('Set how many slides are scrolled per swipe.'),
                'options' => [
                    '' => __('Default'),
                ] + $slides_to_show,
                'condition' => [
                    'slides_to_show!' => '1',
                    'center_mode' => '',
                ] + $variable_width,
                'frontend_available' => true,
            ]
        );

        $self->addControl(
            'center_mode',
            [
                'label' => __('Center Mode'),
                'type' => ControlsManager::SWITCHER,
                'frontend_available' => true,
            ]
        );

        $self->addResponsiveControl(
            'center_padding',
            [
                'label' => __('Center Padding'),
                'type' => ControlsManager::SLIDER,
                'size_units' => ['px', '%'],
                'default' => [
                    'size' => 50,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                    '%' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'center_mode!' => '',
                ] + $variable_width,
                'frontend_available' => true,
            ]
        );

        $self->addControl(
            'navigation',
            [
                'label' => __('Navigation'),
                'type' => ControlsManager::SELECT,
                'default' => 'both',
                'options' => [
                    'both' => __('Arrows and Dots'),
                    'arrows' => __('Arrows'),
                    'dots' => __('Dots'),
                    'none' => __('None'),
                ],
                'frontend_available' => true,
            ]
        );

        $self->addControl(
            'additional_options',
            [
                'label' => __('Additional Options'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            ]
        );

        $self->addControl(
            'pause_on_hover',
            [
                'label' => __('Pause on Hover'),
                'type' => ControlsManager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $self->addResponsiveControl(
            'autoplay',
            [
                'label' => __('Autoplay'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => __('Yes'),
                    '' => __('No'),
                ],
                'frontend_available' => true,
            ]
        );

        $self->addControl(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed'),
                'type' => ControlsManager::NUMBER,
                'default' => 5000,
                'frontend_available' => true,
            ]
        );

        $self->addResponsiveControl(
            'infinite',
            [
                'label' => __('Infinite Loop'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'tablet_default' => 'yes',
                'mobile_default' => 'yes',
                'options' => [
                    'yes' => __('Yes'),
                    '' => __('No'),
                ],
                'frontend_available' => true,
            ]
        );

        $self->addControl(
            'effect',
            [
                'label' => __('Effect'),
                'type' => ControlsManager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide'),
                    'fade' => __('Fade'),
                ],
                'condition' => [
                    'slides_to_show' => '1',
                    'center_mode' => '',
                ],
                'frontend_available' => true,
            ]
        );

        $self->addControl(
            'speed',
            [
                'label' => __('Animation Speed'),
                'type' => ControlsManager::NUMBER,
                'default' => 500,
                'frontend_available' => true,
            ]
        );

        $self->addControl(
            'direction',
            [
                'label' => __('Direction'),
                'type' => ControlsManager::SELECT,
                'default' => 'ltr',
                'options' => [
                    'ltr' => __('Left'),
                    'rtl' => __('Right'),
                ],
                'frontend_available' => true,
            ]
        );

        $self->endControlsSection();
    }

    protected function registerNavigationStyleSection()
    {
        $self = ${'this'};

        $self->startControlsSection(
            'section_style_navigation',
            [
                'label' => __('Navigation'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'navigation' => ['arrows', 'dots', 'both'],
                ],
            ]
        );

        $self->addControl(
            'heading_style_arrows',
            [
                'label' => __('Arrows'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $self->addControl(
            'arrows_position',
            [
                'label' => __('Position'),
                'type' => ControlsManager::SELECT,
                'default' => 'inside',
                'options' => [
                    'inside' => __('Inside'),
                    'outside' => __('Outside'),
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $self->addResponsiveControl(
            'arrows_size',
            [
                'label' => __('Size'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $self->addControl(
            'arrows_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $self->addControl(
            'heading_style_dots',
            [
                'label' => __('Dots'),
                'type' => ControlsManager::HEADING,
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $self->addControl(
            'dots_position',
            [
                'label' => __('Position'),
                'type' => ControlsManager::SELECT,
                'default' => 'outside',
                'options' => [
                    'outside' => __('Outside'),
                    'inside' => __('Inside'),
                ],
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $self->addResponsiveControl(
            'dots_size',
            [
                'label' => __('Size'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $self->addControl(
            'dots_color',
            [
                'label' => __('Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $self->endControlsSection();
    }

    protected function renderCarousel(array &$settings, array &$slides)
    {
        if (empty($slides)) {
            return;
        }
        $self = ${'this'};

        $self->addRenderAttribute('carousel', 'class', 'elementor-image-carousel');

        if ('none' !== $settings['navigation']) {
            if ('dots' !== $settings['navigation']) {
                $self->addRenderAttribute('carousel', 'class', 'slick-arrows-' . $settings['arrows_position']);
            }

            if ('arrows' !== $settings['navigation']) {
                $self->addRenderAttribute('carousel', 'class', 'slick-dots-' . $settings['dots_position']);
            }
        }
        ?>
        <div class="elementor-image-carousel-wrapper elementor-slick-slider" dir="<?= $settings['direction'] ?>">
            <div <?= $self->getRenderAttributeString('carousel') ?>>
            <?php foreach ($slides as &$slide) : ?>
                <div class="slick-slide">
                    <?= $slide ?>
                </div>
            <?php endforeach ?>
            </div>
        </div>
        <?php
    }
}
