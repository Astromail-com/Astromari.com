<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

defined('_PS_VERSION_') or die;

require_once _PS_MODULE_DIR_ . 'creativeelements/classes/CETheme.php';

class AdminCEThemesController extends ModuleAdminController
{
    public $bootstrap = true;

    public $table = 'ce_theme';

    public $identifier = 'id_ce_theme';

    public $className = 'CETheme';

    public $lang = true;

    protected $_defaultOrderBy = 'title';

    public function __construct()
    {
        parent::__construct();

        if ($type = Tools::getValue('type')) {
            if ('all' == $type) {
                unset($this->context->cookie->submitFilterce_template);
                unset($this->context->cookie->cethemesce_themeFilter_type);
            } else {
                $this->context->cookie->submitFilterce_theme = 1;
                $this->context->cookie->cethemesce_themeFilter_type = $type;
            }
        }

        if ((Tools::getIsset('updatece_theme') || Tools::getIsset('addce_theme')) && Shop::getContextShopID() === null) {
            $this->displayWarning(
                $this->trans('You are in a multistore context: any modification will impact all your shops, or each shop of the active group.', [], 'Admin.Catalog.Notification')
            );
        }

        $table_shop = _DB_PREFIX_ . $this->table . '_shop';
        $this->_select = 'sa.*';
        $this->_join = "LEFT JOIN $table_shop sa ON sa.id_ce_theme = a.id_ce_theme AND b.id_shop = sa.id_shop";
        $this->_where = "AND sa.id_shop = " . (int) $this->context->shop->id;

        $this->fields_list = [
            'id_ce_theme' => [
                'title' => $this->trans('ID', [], 'Admin.Global'),
                'class' => 'fixed-width-xs',
                'align' => 'center',
            ],
            'title' => [
                'title' => $this->trans('Title', [], 'Admin.Global'),
            ],
            'type' => [
                'title' => $this->trans('Type', [], 'Admin.Catalog.Feature'),
                'class' => 'fixed-width-xl',
                'type' => 'select',
                'list' => [
                    'header' => $this->l('Header'),
                    'footer' => $this->l('Footer'),
                    'page' => $this->l('Page'),
                    'page-index' => $this->l('Home Page'),
                    'page-contact' => $this->l('Contact Page'),
                    'prod' => $this->l('Product'),
                    'product' => $this->l('Product Page'),
                    'product-quick-view' => $this->l('Quick View'),
                    'product-miniature' => $this->l('Product Miniature'),
                    'page-not-found' => $this->l('404 Page'),
                ],
                'filter_key' => 'type',
            ],
            'date_add' => [
                'title' => $this->trans('Created on', [], 'Modules.Facetedsearch.Admin'),
                'filter_key' => 'sa!date_add',
                'class' => 'fixed-width-lg',
                'type' => 'datetime',
            ],
            'date_upd' => [
                'title' => $this->l('Modified on'),
                'filter_key' => 'sa!date_upd',
                'class' => 'fixed-width-lg',
                'type' => 'datetime',
            ],
            'active' => [
                'title' => $this->trans('Active', [], 'Admin.Global'),
                'filter_key' => 'sa!active',
                'class' => 'fixed-width-xs',
                'align' => 'center',
                'active' => 'status',
                'type' => 'bool',
            ],
        ];

        $this->bulk_actions = [
            'delete' => [
                'text' => $this->trans('Delete selected', [], 'Admin.Notifications.Info'),
                'icon' => 'fa fa-icon-trash',
                'confirm' => $this->trans('Delete selected items?', [], 'Admin.Notifications.Info'),
            ],
        ];

        $this->fields_options['theme_settings'] = [
            'class' => 'ce-theme-panel',
            'icon' => 'icon-cog',
            'title' => $this->l('Theme Settings'),
            'fields' => [
                'CE_HEADER' => [
                    'title' => $this->l('Header'),
                    'cast' => 'strval',
                    'type' => 'select',
                    'identifier' => 'value',
                    'list' => array_merge(
                        [
                            ['value' => '', 'name' => $this->l('Default')],
                        ],
                        CETheme::getOptions('header', $this->context->language->id, $this->context->shop->id)
                    ),
                ],
                'CE_PAGE_INDEX' => [
                    'title' => $this->l('Home Page'),
                    'cast' => 'strval',
                    'type' => 'select',
                    'identifier' => 'value',
                    'list' => array_merge(
                        [
                            ['value' => '', 'name' => $this->l('Default')],
                        ],
                        CETheme::getOptions('page-index', $this->context->language->id, $this->context->shop->id)
                    ),
                ],
                'CE_PRODUCT' => [
                    'title' => $this->l('Product Page'),
                    'cast' => 'strval',
                    'type' => 'select',
                    'identifier' => 'value',
                    'list' => array_merge(
                        [
                            ['value' => '', 'name' => $this->l('Default')],
                        ],
                        CETheme::getOptions('product', $this->context->language->id, $this->context->shop->id)
                    ),
                ],
                'CE_FOOTER' => [
                    'title' => $this->l('Footer'),
                    'cast' => 'strval',
                    'type' => 'select',
                    'identifier' => 'value',
                    'list' => array_merge(
                        [
                            ['value' => '', 'name' => $this->l('Default')],
                        ],
                        CETheme::getOptions('footer', $this->context->language->id, $this->context->shop->id)
                    ),
                ],
                'CE_PAGE_CONTACT' => [
                    'title' => $this->l('Contact Page'),
                    'cast' => 'strval',
                    'type' => 'select',
                    'identifier' => 'value',
                    'list' => array_merge(
                        [
                            ['value' => '', 'name' => $this->l('Default')],
                        ],
                        CETheme::getOptions('page-contact', $this->context->language->id, $this->context->shop->id)
                    ),
                ],
                'CE_PRODUCT_QUICK_VIEW' => [
                    'title' => $this->l('Quick View'),
                    'cast' => 'strval',
                    'type' => 'select',
                    'identifier' => 'value',
                    'list' => array_merge(
                        [
                            ['value' => '', 'name' => $this->l('Default')],
                        ],
                        CETheme::getOptions('product-quick-view', $this->context->language->id, $this->context->shop->id)
                    ),
                ],
                'CE_PAGE_NOT_FOUND' => [
                    'title' => $this->l('404 Page'),
                    'cast' => 'strval',
                    'type' => 'select',
                    'identifier' => 'value',
                    'list' => array_merge(
                        [
                            ['value' => '', 'name' => $this->l('Default')],
                        ],
                        CETheme::getOptions('page-not-found', $this->context->language->id, $this->context->shop->id)
                    ),
                ],
                'CE_PRODUCT_MINIATURE' => [
                    'title' => $this->l('Product Miniature'),
                    'cast' => 'strval',
                    'type' => 'select',
                    'identifier' => 'value',
                    'list' => array_merge(
                        [
                            ['value' => '', 'name' => $this->l('Default')],
                        ],
                        CETheme::getOptions('product-miniature', $this->context->language->id, $this->context->shop->id)
                    ),
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
            ],
        ];
    }

    public function initHeader()
    {
        parent::initHeader();

        $id_lang = $this->context->language->id;
        $link = $this->context->link;
        $tabs = &$this->context->smarty->tpl_vars['tabs']->value;

        foreach ($tabs as &$tab0) {
            foreach ($tab0['sub_tabs'] as &$tab1) {
                if ($tab1['class_name'] == 'AdminParentCEContent') {
                    foreach ($tab1['sub_tabs'] as &$tab2) {
                        if ($tab2['class_name'] == 'AdminCEThemes') {
                            $sub_tabs = &$tab2['sub_tabs'];
                            $tab = Tab::getTab($id_lang, Tab::getIdFromClassName('AdminCEThemes'));
                            $new = Tools::getIsset('addce_theme');
                            $href = $link->getAdminLink('AdminCEThemes');
                            $type = Tools::getValue('type', $this->context->cookie->cethemesce_themeFilter_type);

                            $tab['name'] = $this->l('Templates');
                            $tab['current'] = $new || (!$type || 'all' === $type) && !$this->object;
                            $tab['href'] = "$href&type=all";
                            $sub_tabs[] = $tab;

                            $type = $this->object ? $this->object->type : $type;

                            $tab['name'] = $this->l('Header');
                            $tab['current'] = !$new && 'header' === $type;
                            $tab['href'] = "$href&type=header";
                            $sub_tabs[] = $tab;

                            $tab['name'] = $this->l('Footer');
                            $tab['current'] = !$new && 'footer' === $type;
                            $tab['href'] = "$href&type=footer";
                            $sub_tabs[] = $tab;

                            $tab['name'] = $this->l('Page');
                            $tab['current'] = !$new && stripos($type, 'page') === 0;
                            $tab['href'] = "$href&type=page";
                            $sub_tabs[] = $tab;

                            $tab['name'] = $this->l('Product');
                            $tab['current'] = !$new && 'product-miniature' !== $type && stripos($type, 'prod') === 0;
                            $tab['href'] = "$href&type=prod";
                            $sub_tabs[] = $tab;

                            $tab['name'] = $this->l('Miniature');
                            $tab['current'] = !$new && 'product-miniature' === $type;
                            $tab['href'] = "$href&type=product-miniature";
                            $sub_tabs[] = $tab;

                            break;
                        }
                    }
                }
            }
        }
    }

    public function initToolBarTitle()
    {
        $this->page_header_toolbar_title = $this->l('Theme Builder');

        $this->context->smarty->assign('icon', 'icon-list');

        $this->toolbar_title[] = $this->l(
            'add' === $this->display ? 'Add New Template' : ('edit' === $this->display ? 'Edit Template' : 'Templates List')
        );
    }

    public function initPageHeaderToolbar()
    {
        if (empty($this->display) || 'options' === $this->display) {
            $this->page_header_toolbar_btn['addce_theme'] = [
                'href' => self::$currentIndex . '&addce_theme&token=' . $this->token,
                'desc' => $this->trans('Add new', [], 'Admin.Actions'),
                'icon' => 'process-icon-new',
            ];
        }
        parent::initPageHeaderToolbar();
    }

    public function initModal()
    {
        // Prevent modals
    }

    public function initContent()
    {
        $this->context->smarty->assign('current_tab_level', 3);

        return parent::initContent();
    }

    public function processFilter()
    {
        $type = Tools::getValue('type', $this->context->cookie->cethemesce_themeFilter_type);

        if ('page' === $type || 'prod' === $type) {
            // Trick for type filtering, use LIKE instead of =
            $this->fields_list['type']['type'] = 'text';
        }
        parent::processFilter();

        $this->fields_list['type']['type'] = 'select';
    }

    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false)
    {
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);

        // Translate template types
        if (!empty($this->_list)) {
            $type = &$this->fields_list['type']['list'];

            foreach ($this->_list as &$row) {
                empty($type[$row['type']]) or $row['type'] = $type[$row['type']];
            }
        }
    }

    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        return parent::renderList();
    }

    protected function getThemeType()
    {
        $theme_types = [
            ['value' => '', 'label' => $this->l('Select...')],
            ['value' => 'header', 'label' => $this->l('Header')],
            ['value' => 'footer', 'label' => $this->l('Footer')],
            ['value' => 'page-index', 'label' => $this->l('Home Page')],
            ['value' => 'page-contact', 'label' => $this->l('Contact Page')],
            ['value' => 'product', 'label' => $this->l('Product Page')],
            ['value' => 'product-quick-view', 'label' => $this->l('Quick View')],
            ['value' => 'product-miniature', 'label' => $this->l('Product Miniature')],
            ['value' => 'page-not-found', 'label' => $this->l('404 Page')],
        ];
        if (!empty($this->object->type)) {
            return array_filter($theme_types, function ($option) {
                return ${'this'}->object->type === $option['value'];
            });
        }
        return $theme_types;
    }

    public function renderForm()
    {
        $col = count(Language::getLanguages(false, false, true)) > 1 ? 9 : 7;

        version_compare(_PS_VERSION_, '1.7.8', '<') or $col--;

        $this->fields_form = [
            'legend' => [
                'title' => $this->l('Template'),
                'icon' => 'icon-edit',
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->trans('Title', [], 'Admin.Global'),
                    'name' => 'title',
                    'lang' => true,
                    'col' => $col,
                ],
                [
                    'type' => 'select',
                    'label' => $this->trans('Type', [], 'Admin.Catalog.Feature'),
                    'name' => 'type',
                    'required' => true,
                    'options' => [
                        'id' => 'value',
                        'name' => 'label',
                        'query' => $this->getThemeType(),
                    ],
                    'col' => 3,
                ],
                [
                    'type' => 'textarea',
                    'label' => $this->l('Content'),
                    'name' => 'content',
                    'lang' => true,
                    'col' => $col,
                ],
                [
                    'type' => 'switch',
                    'label' => $this->trans('Active', [], 'Admin.Global'),
                    'name' => 'active',
                    'required' => false,
                    'is_bool' => true,
                    'values' => [
                        [
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->trans('Enabled', [], 'Admin.Global'),
                        ],
                        [
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->trans('Disabled', [], 'Admin.Global'),
                        ],
                    ],
                ],
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Admin.Actions'),
            ],
            'buttons' => [
                'save_and_stay' => [
                    'type' => 'submit',
                    'title' => $this->trans('Save and stay', [], 'Admin.Actions'),
                    'icon' => 'process-icon-save',
                    'name' => 'submitAddce_themeAndStay',
                    'class' => 'btn btn-default pull-right',
                ],
            ],
        ];

        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = [
                'type' => 'shop',
                'label' => $this->trans('Shop association', [], 'Admin.Global'),
                'name' => 'checkBoxShopAsso',
            ];
        }

        return parent::renderForm();
    }

    protected function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        return empty($this->translator) ? $this->l($id) : parent::trans($id, $parameters, $domain, $locale);
    }

    protected function l($string, $module = 'creativeelements', $addslashes = false, $htmlentities = true)
    {
        $str = Translate::getModuleTranslation($module, $string, '', null, $addslashes || !$htmlentities);

        return $htmlentities ? $str : call_user_func('stripslashes', $str);
    }
}
