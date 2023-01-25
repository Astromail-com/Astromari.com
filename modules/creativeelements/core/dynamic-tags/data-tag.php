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
 * Elementor base data tag.
 *
 * An abstract class to register new Elementor data tags.
 *
 * @since 2.0.0
 * @abstract
 */
abstract class CoreXDynamicTagsXDataTag extends BaseTag
{
    private static $getter_method = 'getValue';

    /**
     * @since 2.0.0
     * @access protected
     * @abstract
     *
     * @param array $options
     */
    abstract protected function getValue(array $options = []);

    /**
     * @since 2.5.10
     * @access protected
     *
     * @return mixed
     */
    protected function getSmartyValue(array $options = [])
    {
        return '{literal}' . $this->getValue($options) . '{/literal}';
    }

    /**
     * @since 2.0.0
     * @access public
     */
    final public function getContentType()
    {
        return 'plain';
    }

    /**
     * @since 2.0.0
     * @access public
     *
     * @param array $options
     *
     * @return mixed
     */
    public function getContent(array $options = [])
    {
        return static::REMOTE_RENDER && is_admin() && 'getValue' === self::$getter_method ? null : $this->{self::$getter_method}($options);
    }
}
