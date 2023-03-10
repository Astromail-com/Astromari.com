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

class WidgetProductRating extends WidgetStarRating
{
    const REMOTE_RENDER = true;

    /**
     * Get widget name.
     *
     * @since 2.5.8
     * @access public
     *
     * @return string Widget name.
     */
    public function getName()
    {
        return 'product-rating';
    }

    /**
     * Get widget title.
     *
     * @since 2.5.8
     * @access public
     *
     * @return string Widget title.
     */
    public function getTitle()
    {
        return __('Product Rating');
    }

    /**
     * Get widget icon.
     *
     * @since 2.5.8
     * @access public
     *
     * @return string Widget icon.
     */
    public function getIcon()
    {
        return 'eicon-product-rating';
    }

    /**
     * Get widget categories.
     *
     * @since 2.5.8
     * @access public
     *
     * @return array Widget categories.
     */
    public function getCategories()
    {
        return ['product-elements'];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.5.8
     * @access public
     *
     * @return array Widget keywords.
     */
    public function getKeywords()
    {
        return ['shop', 'store', 'rating', 'review', 'comments', 'stars', 'product'];
    }

    /**
     * Register product rating widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 2.5.8
     * @access protected
     */
    protected function _registerControls()
    {
        parent::_registerControls();

        $this->updateControl('rating_scale', ['type' => ControlsManager::HIDDEN]);

        $this->updateControl('rating', ['type' => ControlsManager::HIDDEN]);

        $this->updateControl('star_style', ['separator' => '']);

        $this->updateControl('title', ['separator' => '']);

        $this->startInjection([
            'of' => 'title',
        ]);

        $this->addControl(
            'hide_empty',
            [
                'label' => __('Hide Empty'),
                'type' => ControlsManager::SWITCHER,
            ]
        );

        $this->addControl(
            'show_average_grade',
            [
                'label' => __('Average Grade'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('Show'),
                'label_off' => __('Hide'),
            ]
        );

        $this->addControl(
            'show_comments_number',
            [
                'label' => '<b>' . __('Comments Number') . '</b>',
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('Show'),
                'label_off' => __('Hide'),
                'separator' => 'before',
            ]
        );

        $this->addControl(
            'comments_number_icon',
            [
                'label' => __('Icon'),
                'type' => ControlsManager::ICON,
                'default' => 'fa fa-commenting',
                'condition' => [
                    'show_comments_number!' => '',
                ],
            ]
        );

        $this->addControl(
            'comments_number_before',
            [
                'label' => __('Before'),
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Default'),
                'condition' => [
                    'show_comments_number!' => '',
                ],
            ]
        );

        $this->addControl(
            'comments_number_after',
            [
                'label' => __('After'),
                'type' => ControlsManager::TEXT,
                'condition' => [
                    'show_comments_number!' => '',
                ],
            ]
        );

        if ($this->getName() === 'product-rating') {
            $this->addControl(
                'show_post_comment',
                [
                    'label' => '<b>' . __('Post Comment') . '</b>',
                    'type' => ControlsManager::SWITCHER,
                    'label_on' => __('Show'),
                    'label_off' => __('Hide'),
                    'separator' => 'before',
                ]
            );

            $this->addControl(
                'post_comment_icon',
                [
                    'label' => __('Icon'),
                    'type' => ControlsManager::ICON,
                    'default' => 'fa fa-pencil',
                    'condition' => [
                        'show_post_comment!' => '',
                    ],
                ]
            );

            $this->addControl(
                'post_comment',
                [
                    'label' => __('Text'),
                    'type' => ControlsManager::TEXT,
                    'placeholder' => __('Default'),
                    'condition' => [
                        'show_post_comment!' => '',
                    ],
                ]
            );
        }

        $this->endInjection();

        $this->updateControl(
            'align',
            [
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __('Left'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'separator' => 'before'
            ]
        );

        $this->startControlsSection(
            'section_average_grade_style',
            [
                'label' => __('Average Grade'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'show_average_grade!' => '',
                ],
            ]
        );

        $this->addControl(
            'average_grade_spacing',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ce-product-rating__average-grade' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'average_grade_typography',
                'selector' => '{{WRAPPER}} .ce-product-rating__average-grade',
            ]
        );

        $this->addControl(
            'average_grade_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ce-product-rating__average-grade' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_comments_number_style',
            [
                'label' => __('Comments Number'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => [
                    'show_comments_number!' => '',
                ],
            ]
        );

        $this->addControl(
            'comments_number_spacing',
            [
                'label' => __('Spacing'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            [
                'name' => 'comments_number_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-list-item',
            ]
        );

        $this->addControl(
            'comments_number_color',
            [
                'label' => __('Text Color'),
                'type' => ControlsManager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-icon-list-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'comments_number_color_hover',
            [
                'label' => __('Hover'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-icon-list-item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->addControl(
            'comments_number_indent',
            [
                'label' => __('Text Indent'),
                'type' => ControlsManager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'comments_number_icon!' => '',
                ],
            ]
        );

        $this->endControlsSection();

        if ($this->getName() === 'product-rating') {
            $this->startControlsSection(
                'section_post_comment_style',
                [
                    'label' => __('Post Comment'),
                    'tab' => ControlsManager::TAB_STYLE,
                    'condition' => [
                        'show_post_comment!' => '',
                    ],
                ]
            );

            $this->addControl(
                'post_comment_layout',
                [
                    'label' => __('Layout'),
                    'type' => ControlsManager::SELECT,
                    'default' => 'inline',
                    'options' => [
                        'inline' => __('Inline'),
                        'stacked' => __('Stacked'),
                    ],
                    'prefix_class' => 'ce-product-rating--layout-',
                ]
            );

            $this->addControl(
                'post_comment_spacing',
                [
                    'label' => __('Spacing'),
                    'type' => ControlsManager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'default' => [
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}}.ce-product-rating--layout-inline .elementor-button' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}}.ce-product-rating--layout-stacked .elementor-button' => 'margin-top: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->addGroupControl(
                GroupControlTypography::getType(),
                [
                    'name' => 'post_comment_typography',
                    'selector' => '{{WRAPPER}} a.elementor-button',
                ]
            );

            $this->startControlsTabs('tabs_button_style');

            $this->startControlsTab(
                'tab_button_normal',
                [
                    'label' => __('Normal'),
                ]
            );

            $this->addControl(
                'post_comment_color',
                [
                    'label' => __('Text Color'),
                    'type' => ControlsManager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} a.elementor-button:not(#e)' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->addControl(
                'post_comment_bg_color',
                [
                    'label' => __('Background Color'),
                    'type' => ControlsManager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} a.elementor-button' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->endControlsTab();

            $this->startControlsTab(
                'tab_button_hover',
                [
                    'label' => __('Hover'),
                ]
            );

            $this->addControl(
                'post_comment_color_hover',
                [
                    'label' => __('Text Color'),
                    'type' => ControlsManager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} a.elementor-button:not(#e):hover, {{WRAPPER}} a.elementor-button:not(#e):focus' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->addControl(
                'post_comment_bg_color_hover',
                [
                    'label' => __('Background Color'),
                    'type' => ControlsManager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} a.elementor-button:focus' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->addControl(
                'post_comment_border_color_hover',
                [
                    'label' => __('Border Color'),
                    'type' => ControlsManager::COLOR,
                    'condition' => [
                        'border_border!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} a.elementor-button:focus' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->addControl(
                'post_comment_hover_animation',
                [
                    'label' => __('Hover Animation'),
                    'type' => ControlsManager::HOVER_ANIMATION,
                ]
            );

            $this->endControlsTab();

            $this->endControlsTabs();

            $this->addGroupControl(
                GroupControlBorder::getType(),
                [
                    'name' => 'post_comment_border',
                    'selector' => '{{WRAPPER}} .elementor-button',
                    'separator' => 'before',
                ]
            );

            $this->addControl(
                'post_comment_border_radius',
                [
                    'label' => __('Border Radius'),
                    'type' => ControlsManager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors' => [
                        '{{WRAPPER}} a.elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->addGroupControl(
                GroupControlBoxShadow::getType(),
                [
                    'name' => 'post_comment_box_shadow',
                    'selector' => '{{WRAPPER}} .elementor-button',
                ]
            );

            $this->addResponsiveControl(
                'post_comment_padding',
                [
                    'label' => __('Padding'),
                    'type' => ControlsManager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} a.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->endControlsSection();
        }
    }

    /**
     * Render product variations widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 2.5.8
     * @access protected
     * @codingStandardsIgnoreStart Generic.Files.LineLength
     */
    protected function render()
    {
        $productcomments = \Module::getInstanceByName('productcomments');

        if (empty($productcomments->active) || $productcomments->author !== 'PrestaShop') {
            return printf(
                '<div class="alert alert-warning" role="alert">%s</div>',
                __('Please install and enable the official "productcomments" module!')
            );
        }
        $context = \Context::getContext();
        $t = $context->getTranslator();
        $product = &$context->smarty->tpl_vars['product']->value;
        $vars = $productcomments->getWidgetVariables('displayCE', [
            'id_product' => (int) $product['id_product'],
        ]);

        if (!$vars['nb_comments'] && $this->getSettings('hide_empty')) {
            return;
        }
        $average_grade = \Tools::ps_round($vars['average_grade'], 1);
        $this->setSettings('rating', $average_grade);
        $settings = $this->getSettingsForDisplay();
        ?>
        <div class="ce-product-rating" itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
        <?php if ($vars['nb_comments']) : ?>
            <meta itemprop="ratingValue" content="<?= esc_attr($average_grade) ?>">
        <?php endif ?>
            <?php parent::render() ?>

        <?php if ($average_grade && $settings['show_average_grade']) : ?>
            <span class="ce-product-rating__average-grade"><?= $average_grade ?></span>
        <?php endif ?>

        <?php if ($vars['nb_comments'] && $settings['show_comments_number']) : ?>
            <meta itemprop="reviewCount" content="<?= (int) $vars['nb_comments'] ?>">
            <a class="elementor-icon-list-item"<?= 'product-rating' === $this->getName() ? ' href="#product-comments-list-header"' : '' ?>>
            <?php if ($settings['comments_number_icon']) : ?>
                <span class="elementor-icon-list-icon">
                    <i class="<?= esc_attr($settings['comments_number_icon']) ?>" aria-hidden="true"></i>
                </span>
            <?php endif ?>
                <span class="elementor-icon-list-text">
                    <?=
                    ($settings['comments_number_before'] ?: "{$t->trans('Read user reviews', [], 'Modules.Productcomments.Shop')}: ") .
                    (int) $vars['nb_comments'] .
                    $settings['comments_number_after']
                    ?>
                </span>
            </a>
        <?php endif ?>
        </div>
        <?php if ($vars['post_allowed'] && !empty($settings['show_post_comment'])) : ?>
            <a class="elementor-button elementor-button--post-comment elementor-size-sm" href="#product-comments-list-header">
            <?php if ($settings['post_comment_icon']) : ?>
                <span class="elementor-button-icon elementor-align-icon-left">
                    <i class="<?= esc_attr($settings['post_comment_icon']) ?>" aria-hidden="true"></i>
                </span>
            <?php endif ?>
                <span class="elementor-button-text">
                    <?= $settings['post_comment'] ?: $t->trans('Write your review', [], 'Modules.Productcomments.Shop') ?>
                </span>
            </a>
        <?php endif;
    }

    public function renderPlainContent()
    {
    }

    protected function _contentTemplate()
    {
    }
}
