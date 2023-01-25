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

/**
 * Sing in widget
 *
 * @since 2.5.0
 */
class WidgetSignIn extends WidgetBase
{
    use NavTrait;

    const REMOTE_RENDER = true;

    /**
     * Get widget name.
     *
     * @since 2.5.0
     * @access public
     *
     * @return string Widget name.
     */
    public function getName()
    {
        return 'sign-in';
    }

    /**
     * Get widget title.
     *
     * @since 2.5.0
     * @access public
     *
     * @return string Widget title.
     */
    public function getTitle()
    {
        return __('Sign in');
    }

    /**
     * Get widget icon.
     *
     * @since 2.5.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function getIcon()
    {
        return 'eicon-lock-user';
    }

    /**
     * Get widget categories.
     *
     * @since 2.5.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function getCategories()
    {
        return ['theme-elements'];
    }

    /**
     * Get widget keywords.
     *
     * @since 2.5.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function getKeywords()
    {
        return ['login', 'user', 'account', 'logout'];
    }

    public function getLinkToOptions()
    {
        return [
            'my-account' => __('My account'),
            'identity' => __('Personal info'),
            'address' => __('New Address'),
            'addresses' => __('Addresses'),
            'history' => __('Order history'),
            'order-slip' => __('Credit slip'),
            'discount' => __('My vouchers'),
            'logout' => __('Sign out'),
            'custom' => __('Custom URL'),
        ];
    }

    /**
     * Register sign in widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 2.5.0
     * @access protected
     */
    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_selector',
            [
                'label' => $this->getTitle(),
            ]
        );

        $this->startControlsTabs('tabs_label_content');

        $this->startControlsTab(
            'tab_label_sign_in',
            [
                'label' => __('Sign in'),
            ]
        );

        $icon_options = [
            'fa fa-user' => 'user',
            'fa fa-user-o' => 'user-o',
            'fa fa-user-circle' => 'user-circle',
            'fa fa-user-circle-o' => 'user-circle-o',
            'ceicon-user-simple' => 'user-simple',
            'ceicon-user-minimal' => 'user-minimal',
        ];

        $this->addControl(
            'icon',
            [
                'label' => __('Icon'),
                'type' => ControlsManager::ICON,
                'label_block' => false,
                'default' => 'fa fa-user',
                'options' => &$icon_options,
                'include' => array_keys($icon_options),
            ]
        );

        $this->addControl(
            'label',
            [
                'label' => __('Label'),
                'type' => ControlsManager::TEXT,
                'default' => __('Sign in'),
            ]
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tab_label_signed_in',
            [
                'label' => __('Signed in'),
            ]
        );

        $this->addControl(
            'account',
            [
                'label' => __('Label'),
                'label_block' => true,
                'type' => ControlsManager::SELECT2,
                'default' => ['icon', 'firstname'],
                'multiple' => true,
                'options' => [
                    'icon' => __('Icon'),
                    'before' => __('Before'),
                    'firstname' => __('First Name'),
                    'lastname' => __('Last Name'),
                    'after' => __('After'),
                ],
            ]
        );

        $this->addControl(
            'before',
            [
                'label' => __('Before'),
                'type' => ControlsManager::TEXT,
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'account',
                            'operator' => 'contains',
                            'value' => 'before',
                        ],
                    ],
                ],
            ]
        );

        $this->addControl(
            'after',
            [
                'label' => __('After'),
                'type' => ControlsManager::TEXT,
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'account',
                            'operator' => 'contains',
                            'value' => 'after',
                        ],
                    ],
                ],
            ]
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->registerNavContentControls();

        $this->addControl(
            'heading_usermenu',
            [
                'label' => __('Usermenu'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater = new Repeater();

        $repeater->addControl(
            'link_to',
            [
                'label' => __('Link'),
                'type' => ControlsManager::SELECT,
                'default' => 'identity',
                'options' => $this->getLinkToOptions(),
            ]
        );

        $repeater->addControl(
            'link',
            [
                'label_block' => true,
                'type' => ControlsManager::URL,
                'placeholder' => __('http://your-link.com'),
                'classes' => 'ce-hide-link-options',
                'condition' => [
                    'link_to' => 'custom',
                ],
            ]
        );

        $repeater->addControl(
            'text',
            [
                'label' => __('Text'),
                'type' => ControlsManager::TEXT,
            ]
        );

        $repeater->addControl(
            'icon',
            [
                'label' => __('Icon'),
                'type' => ControlsManager::ICON,
                'label_block' => false,
                'default' => 'fa fa-user',
                'options' => &$icon_options,
            ]
        );

        $this->addControl(
            'usermenu',
            [
                'type' => ControlsManager::REPEATER,
                'fields' => $repeater->getControls(),
                'default' => [
                    [
                        'link_to' => 'my-account',
                        'icon' => 'fa fa-user-o',
                    ],
                    [
                        'link_to' => 'addresses',
                        'icon' => 'fa fa-address-book-o',
                    ],
                    [
                        'link_to' => 'history',
                        'icon' => 'fa fa-list',
                    ],
                    [
                        'link_to' => 'logout',
                        'icon' => 'fa fa-sign-out',
                    ],
                ],
                'title_field' => '<i class="{{ icon }}"></i> {{{ text || ' .
                    'elementor.panel.currentView.currentPageView.model.get("settings").controls.' .
                    'usermenu.fields.link_to.options[link_to] }}}',
            ]
        );

        $this->endControlsSection();

        $this->registerNavStyleSection([
            'show_icon' => true,
            'active_condition' => [
                'hide!' => '',
            ],
            'space_between_condition' => [
                'hide!' => '',
            ],
        ]);

        $this->registerDropdownStyleSection([
            'active_condition' => [
                'hide!' => '',
            ],
        ]);
    }

    protected function getHtmlWrapperClass()
    {
        return parent::getHtmlWrapperClass() . ' elementor-widget-nav-menu';
    }

    public function getUrl(&$item)
    {
        if ('custom' === $item['link_to']) {
            return $item['link']['url'];
        }
        if ('logout' === $item['link_to']) {
            return $this->context->link->getPageLink('index', true, null, 'mylogout');
        }
        return $this->context->link->getPageLink($item['link_to'], true);
    }

    /**
     * Render sing in widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 2.5.0
     * @access protected
     * @codingStandardsIgnoreStart Generic.Files.LineLength
     */
    protected function render()
    {
        $settings = $this->getActiveSettings();
        $customer = $this->context->customer;
        $this->indicator = $settings['indicator'];

        if ($customer->isLogged()) {
            $options = $this->getLinkToOptions();
            $account = &$settings['account'];
            $menu = [
                [
                    'id' => 0,
                    'icon' => in_array('icon', $account) ? $settings['icon'] : '',
                    'label' => call_user_func(function () use ($settings, $account, $customer) {
                        $label = '';

                        in_array('before', $account) && $label .= $settings['before'];
                        in_array('firstname', $account) && $label .= " {$customer->firstname}";
                        in_array('lastname', $account) && $label .= " {$customer->lastname}";
                        in_array('after', $account) && $label .= $settings['after'];

                        return trim($label);
                    }),
                    'url' => $this->context->link->getPageLink('my-account', true),
                    'children' => [],
                ],
            ];
            foreach ($settings['usermenu'] as $i => &$item) {
                $menu[0]['children'][] = [
                    'id' => $i + 1,
                    'icon' => $item['icon'],
                    'label' => $item['text'] ?: $options[$item['link_to']],
                    'url' => $this->getUrl($item),
                ];
            }
        } else {
            $menu = [
                [
                    'id' => 0,
                    'icon' => $settings['icon'],
                    'label' => $settings['label'],
                    'url' => $this->context->link->getPageLink('my-account', true),
                    'children' => [],
                ],
            ];
        }
        $ul_class = 'elementor-nav';

        // General Menu.
        ob_start();
        $this->accountList($menu, 0, $ul_class);
        $menu_html = ob_get_clean();

        $this->addRenderAttribute('main-menu', 'class', [
            'elementor-sign-in',
            'elementor-nav--main',
            'elementor-nav__container',
            'elementor-nav--layout-horizontal',
        ]);

        if ('none' !== $settings['pointer']) {
            $animation_type = self::getPointerAnimationType($settings['pointer']);

            $this->addRenderAttribute('main-menu', 'class', [
                'e--pointer-' . $settings['pointer'],
                'e--animation-' . $settings[$animation_type],
            ]);
        }
        ?>
        <nav <?= $this->getRenderAttributeString('main-menu') ?>><?= $menu_html ?></nav>
        <?php
    }

    protected function accountList(array &$nodes, $depth = 0, $ul_class = '')
    {
        ?>
        <ul <?= $depth ? 'class="sub-menu elementor-nav--dropdown"' : 'id="usermenu-' . $this->getId() . '" class="' . $ul_class . '"' ?>>
        <?php foreach ($nodes as &$node) : ?>
            <li class="<?= sprintf(self::$li_class, 'account', "account-{$node['id']}", '', !empty($node['children']) ? ' menu-item-has-children' : '') ?>">
                <a class="<?= $depth ? 'elementor-sub-item' : 'elementor-item' ?>" href="<?= esc_attr($node['url']) ?>">
                <?php if ($node['icon']) : ?>
                    <i class="<?= $node['icon'] ?>"></i>
                <?php endif ?>
                <?php if ($node['label']) : ?>
                    <span><?= $node['label'] ?></span>
                <?php endif ?>
                <?php if ($this->indicator && !empty($node['children'])) : ?>
                    <span class="sub-arrow <?= esc_attr($this->indicator) ?>"></span>
                <?php endif ?>
                </a>
                <?php empty($node['children']) or $this->accountList($node['children'], $depth + 1) ?>
            </li>
        <?php endforeach ?>
        </ul>
        <?php
    }

    public function __construct($data = [], $args = [])
    {
        $this->context = \Context::getContext();

        parent::__construct($data, $args);
    }
}
