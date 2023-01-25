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

use CE\CoreXDynamicTagsXBaseTag as BaseTag;

/**
 * Elementor tag.
 *
 * An abstract class to register new Elementor tag.
 *
 * @since 2.0.0
 * @abstract
 */
abstract class CoreXDynamicTagsXTag extends BaseTag
{
    const WRAPPED_TAG = false;

    private static $render_method = 'render';

    /**
     * @since 2.0.0
     * @access public
     *
     * @param array $options
     *
     * @return string
     */
    public function getContent(array $options = [])
    {
        if (static::REMOTE_RENDER && is_admin() && 'render' === self::$render_method) {
            return;
        }

        $settings = $this->getSettings();

        ob_start();

        $this->{self::$render_method}();

        $value = ob_get_clean();

        if ('renderSmarty' === self::$render_method) {
            if ($settings['before'] || $settings['after'] || $settings['fallback']) {
                $value = "{capture assign='ce_tag'}$value{/capture}" .
                    '{if strlen($ce_tag)}' .
                        wp_kses_post($settings['before'] . '{$ce_tag nofilter}' . $settings['after']) .
                    '{else}' .
                        $settings['fallback'] .
                    '{/if}';
            }
        } elseif ($value) {
            if (!empty($settings['before'])) {
                $value = wp_kses_post($settings['before']) . $value;
            }

            if (!empty($settings['after'])) {
                $value .= wp_kses_post($settings['after']);
            }

            if (static::WRAPPED_TAG) {
                $id = $this->getId();
                $value = '<span id="elementor-tag-' . esc_attr($id) . '" class="elementor-tag">' . $value . '</span>';
            }
        } elseif (!empty($settings['fallback'])) {
            $value = $settings['fallback'];
        }

        return $value;
    }

    /**
     * @since 2.5.10
     * @access protected
     */
    protected function renderSmarty()
    {
        $this->render();
    }

    /**
     * @since 2.0.0
     * @access public
     */
    final public function getContentType()
    {
        return 'ui';
    }

    /**
     * @since 2.0.9
     * @access public
     */
    public function getEditorConfig()
    {
        $config = parent::getEditorConfig();

        $config['wrapped_tag'] = $this::WRAPPED_TAG;

        return $config;
    }

    /**
     * @since 2.0.0
     * @access protected
     */
    protected function registerAdvancedSection()
    {
        $this->startControlsSection(
            'advanced',
            [
                'label' => __('Advanced'),
            ]
        );

        $this->addControl(
            'before',
            [
                'label' => __('Before'),
            ]
        );

        $this->addControl(
            'after',
            [
                'label' => __('After'),
            ]
        );

        $this->addControl(
            'fallback',
            [
                'label' => __('Fallback'),
                'separator' => 'before',
            ]
        );

        $this->endControlsSection();
    }
}
