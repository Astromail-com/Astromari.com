<?php
/**
 * 2007-2022 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2022 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;

class AdminEtsAwuSearchAppearanceRSSController extends ModuleAdminController
{
    public $priority_options;
    /**
     * __construct
     *
     * @return void
     */
    public $rss_options;

    public function __construct()
    {
        $this->bootstrap  = true;
        parent::__construct();
        
        $awuDef = EtsAwuDefine::getInstance();
        $this->fields_options = array(
            'rss_setting' => array(
                'title' => $this->l('RSS settings'),
                'fields' => $awuDef->getFieldConfig()['rss_setting'],
                'icon'=> '',
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
        $this->rss_options = array(
            'product_category' => array(
                'label' => $this->l('Product categories'),
                'value' => '',
            ),
            'cms_category' => array(
                'label' => $this->l('CMS categories'),
                'value' => '',
            ),
            'all_products' => array(
                'label' => $this->l('All products'),
                'value' => '',
            ),
            'new_products' => array(
                'label' => $this->l('New products'),
                'value' => '',
            ),
            'special_products' => array(
                'label' => $this->l('Special products'),
                'value' => '',
            ),
            'popular_products' => array(
                'label' => $this->l('Popular products'),
                'value' => '',
            ),

        );
        if(Module::isEnabled('ybc_blog'))
        {
            $this->rss_options['blog'] = array(
                'label' => $this->l('Blog'),
                'value' => '',
            );
        }
        if (!Module::isEnabled('ets_awesomeurl'))
        {
            $this->warnings[] = $this->l('You must enable module Awesome URL to configure its features');
        }
    }

    public function renderOptions()
    {
        $option_value = explode(',', (string)Configuration::get('ETS_AWU_RSS_OPTION'));
        $this->context->smarty->assign(array(
            'ets_awu_base_uri' => __PS_BASE_URI__,
            'ets_awu_multilang_activated' => Language::isMultiLanguageActivated($this->context->shop->id),
            'ets_awu_languages' => Language::getLanguages(true),
            'ets_awu_baseurl' => $this->context->shop->getBaseURL(true, true),
            'ETS_AWU_RSS_OPTION' => $option_value,
            'ets_awu_rss_options'=> $this->rss_options
        ));
        return parent::renderOptions();

    }
    public function postProcess()
    {
        if (Tools::isSubmit('submitOptionsconfiguration')) {
            $rss_options = Tools::getValue('ETS_AWU_RSS_OPTION', array());
            $ETS_AWU_RSS_ENABLE = (int)Tools::getValue('ETS_AWU_RSS_ENABLE');
            if ((int)$ETS_AWU_RSS_ENABLE && (!$rss_options || empty($rss_options))) {
                $this->errors[] = $this->l('The page included in rss is required');
            }
            elseif($rss_options && !Ets_awesomeurl::validateArray($rss_options))
                $this->errors[] = $this->l('The page included in rss is not valid');
            $_POST['ETS_AWU_RSS_OPTION'] = implode(',', $rss_options);
            $postLimit = Tools::getValue('ETS_AWU_RSS_POST_LIMIT');
            if ($postLimit && !Validate::isUnsignedInt($postLimit)) {
                $this->errors[] = $this->l('The post limit must be an unsigned integer value');
            } elseif ($postLimit == '0') {
                $this->errors[] = $this->l('The post limit must be an unsigned integer value');
            }

        }

        parent::postProcess();
        if (Tools::isSubmit('submitOptionsconfiguration')) {
            $rssOption = ($rssOption = Tools::getValue('ETS_AWU_RSS_OPTION')) && Validate::isCleanHtml($rssOption) ? $rssOption : '';
            Configuration::updateValue('ETS_AWU_RSS_OPTION', $rssOption);
        }
    }

}