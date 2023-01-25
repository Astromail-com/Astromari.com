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
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2022 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_')) {
    exit();
}

class EtsAwuRedirect extends ObjectModel
{
    /**
     * @var int
     */
    public $id_ets_awu_redirect;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $target;

    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $active;

    /**
     * @var int
     */
    public $id_shop;

    public static $definition = array(
        'table' => 'ets_awu_redirect',
        'primary' => 'id_ets_awu_redirect',
        'multilang_shop' => false,
        'fields' => array(
            'id_ets_awu_redirect' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'url' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isString'
            ),
            'target' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isString'
            ),
            'type' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isString'
            ),
            'active' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool'
            ),

            'id_shop' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),

        )
    );

    public static function getTypeUrlRedirect($current_url, $context = null, $active = false)
    {
        if(!$context)
        {
            $context = Context::getContext();
        }
        $url = trim(str_replace($context->shop->getBaseURL(true, false).__PS_BASE_URI__, '', $current_url));
        $where_active = $active ? " AND active = 1" : '';

        return  Db::getInstance()->getRow("SELECT * FROM `"._DB_PREFIX_."ets_awu_redirect` WHERE '".pSQL($url)."' REGEXP (CONCAT('(^|\/)', REPLACE(`url`, '*', '(.*)'), '($|\/$|\/?\\\?(.*))')) ".pSQL($where_active)." AND `id_shop`=".(int)$context->shop->id);
    }

    public static function doRedirect($context = null)
    {
        if (!$context)
            $context = Context::getContext();

        $redirect = self::getTypeUrlRedirect($context->shop->getBaseURL(true, false) . $_SERVER['REQUEST_URI'], $context, true);

        if ($redirect && $redirect['target']) {
            if (strpos($redirect['target'], 'http://') === false && strpos($redirect['target'], 'https://') === false) {
                $redirect['target'] = 'http://' . trim($redirect['target']);
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            $code = $redirect['type'];
            $text = '';
            switch ($redirect['type']) {
                case 301:
                    $text = 'Moved Permanently';
                    break;
                case 302:
                    $text = 'Moved Temporarily';
                    break;
                case 303:
                    $text = 'See Other';
                    break;
            }
            Tools::redirect($redirect['target'], __PS_BASE_URI__, $context->link, $protocol . ' ' . $code . ' ' . $text);
        }
    }
}