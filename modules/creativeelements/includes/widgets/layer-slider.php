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
 * Creative Slider widget
 *
 * @since 1.0.0
 */
class WidgetLayerSlider extends WidgetBase
{
    const REMOTE_RENDER = true;

    protected $module;

    /**
     * Get widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function getName()
    {
        return 'ps-widget-LayerSlider';
    }

    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function getTitle()
    {
        return __('Creative Slider');
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function getIcon()
    {
        return 'eicon-slideshow';
    }

    /**
     * Get widget categories.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function getCategories()
    {
        return ['premium'];
    }

    /**
     * Get widget keywords.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function getKeywords()
    {
        return ['creative', 'layer', 'slider', 'slideshow'];
    }

    protected function getSliderOptions()
    {
        if (!$this->module) {
            return false;
        }
        $opts = [];
        $table = _DB_PREFIX_ . 'layerslider';
        $sliders = \Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            "SELECT `id`, `name` FROM `$table` WHERE `flag_hidden` = 0 AND `flag_deleted` = 0 LIMIT 100"
        );
        if (!empty($sliders)) {
            foreach ($sliders as &$slider) {
                $name = empty($slider['name']) ? 'Unnamed' : $slider['name'];
                $opts[$slider['id']] = "#{$slider['id']} - $name";
            }
        }

        return $opts;
    }

    /**
     * Register Creative Slider widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_layerslider',
            [
                'label' => __('Creative Slider'),
            ]
        );

        if ($this->module) {
            $this->addControl(
                'ls-new',
                [
                    'type' => ControlsManager::BUTTON,
                    'text' => '<i class="fa fa-plus"></i> ' . __('Create New Slider'),
                    'label_block' => true,
                    'description' => __('or'),
                ]
            );

            $this->addControl(
                'slider',
                [
                    'classes' => 'ls-selector',
                    'label' => __('Slider'),
                    'type' => ControlsManager::SELECT2,
                    'select2options' => [
                        'placeholder' => __('Select...'),
                    ],
                    'options' => $this->getSliderOptions(),
                    'separator' => 'before',
                ]
            );

            $this->addControl(
                'ls-edit',
                [
                    'type' => ControlsManager::BUTTON,
                    'text' => '<i class="fa fa-edit"></i> ' . __('Edit Slider'),
                    'condition' => [
                        'slider!' => '0',
                    ],
                ]
            );
        } else {
            $this->addControl(
                'ls-alert',
                [
                    'raw' => $this->getAlert(),
                    'type' => ControlsManager::RAW_HTML,
                ]
            );

            $this->addControl(
                'ls-promo',
                [
                    'raw' => $this->getPromo(),
                    'type' => ControlsManager::RAW_HTML,
                ]
            );

            $this->addControl('slider', ['type' => ControlsManager::HIDDEN]);
        }

        $this->endControlsSection();
    }

    /**
     * Render Creative Slider widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        if (!$this->module) {
            return;
        }
        $id = (int) $this->getSettings('slider');

        if (!empty($id)) {
            $slider = $this->module->generateSlider($id);

            if (\Tools::getValue('render') === 'widget') {
                $this->patchInitScript($slider, $id);
            }
            echo $slider;
        }
    }

    protected function patchInitScript(&$slider, $id)
    {
        $suffix = '_' . time();
        $slider = str_replace("layerslider_$id", "layerslider_$id$suffix", $slider);
        ob_start();
        ?>
        <script>
        var js = $('#layerslider_<?= $id . $suffix ?>').prev().html() || '';
        if (js = js.match(/{([^]*)}/)) eval(js[1]);
        </script>
        <?php
        $slider .= ob_get_clean();
    }

    /**
     * Render Creative Slider widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     * @codingStandardsIgnoreStart Generic.Files.LineLength
     */
    protected function _contentTemplate()
    {
        if ($this->module) {
            return;
        }
        echo "<\x69frame src=\"https://creativeslider.webshopworks.com/promo-slider.html\" " .
            "style=\"width: 100%; height: 66vh; border: none;\"></\x69frame>";
    }

    protected function getAlert()
    {
        return '
            <div style="background: #d1eff8; border: 1px solid #bcdff1; border-radius: 4px; padding: 20px; font-size: 12px; text-align: center; color: #43a2bf;">
                <svg width="40" viewBox="0 0 259.559 259.559" fill="currentColor">
                    <polygon points="186.811,106.547 129.803,218.647 73.273,106.547"/><polygon points="78.548,94.614 129.779,43.382 181.011,94.614"/>
                    <polygon points="144.183,40.912 213.507,40.912 193.941,90.67"/><polygon points="66.375,89.912 50.044,40.912 115.375,40.912"/>
                    <polygon points="59.913,106.547 109.546,204.977 3.288,106.547"/><polygon points="200.2,106.547 256.271,106.547 150.258,204.75"/>
                    <polygon points="205.213,94.614 223.907,47.082 259.559,94.614"/><polygon points="38.331,43.507 55.373,94.614 0,94.614"/>
                </svg>
                <h3 style="margin: 5px 0 13px; font-size: 13px; font-weight: bold;">Do you need an awesome slider?</h3>
                <p style="line-height: 1.3em">Creative Slider is the perfect choice for you. With this widget you can easily place Creative Slider anywhere.</p>
            </div>';
    }

    protected function getPromo()
    {
        ob_start();
        $iso = get_locale();
        $more = "https://addons.prestashop.com/$iso/sliders-galleries/19062-creative-slider-responsive-slideshow.html";
        $demo = 'https://addons.prestashop.com/demo/FO11013.html';
        ?>
        <style>
        #ls-btn-demo, #ls-btn-more {
            display: inline-block;
            width: 48%;
            text-align: center;
        }
        #ls-btn-demo { background: #38b54a; }
        #ls-btn-demo:hover { opacity: 0.85; }
        #ls-btn-more { margin-left: 4%; }
        </style>
        <a href="<?= $demo ?>" target="_blank" id="ls-btn-demo" class="elementor-button elementor-button-default"><?= __('Live Demo')?></a
        ><a href="<?= $more ?>" target="_blank" id="ls-btn-more" class="elementor-button elementor-button-default"><?= __('Read More')?></a>
        <?php
        return ob_get_clean();
    }

    public function __construct($data = [], $args = [])
    {
        $ls = \Module::getInstanceByName('layerslider');

        if (!empty($ls->active)) {
            $this->module = $ls;

            $context = \Context::getContext();

            empty($context->employee) or Helper::$body_scripts['ce-layerslider'] = [
                'hndl' => 'ce-layerslider',
                'l10n' => [
                    'ls' => [
                        'url' => $context->link->getAdminLink('AdminLayerSlider'),
                        'NameYourSlider' => __('Name your new slider'),
                        'ChangesYouMadeMayNotBeSaved' => __('Changes you made may not be saved, are you sure you want to close?'),
                    ],
                ],
            ];

            if (is_admin()) {
                wp_enqueue_style('jquery-fancybox', _PS_JS_DIR_ . 'jquery/plugins/fancybox/jquery.fancybox.css');
                wp_enqueue_script('jquery-fancybox', _PS_JS_DIR_ . 'jquery/plugins/fancybox/jquery.fancybox.js', ['jquery'], false, true);
            }
        }
        parent::__construct($data, $args);
    }
}
