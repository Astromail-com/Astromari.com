<?php
/**
 * 2007-2023 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <contact@etssoft.net>
 * @copyright  2007-2023 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
 
if (!defined('_PS_VERSION_')) {
    exit();
}
class Ets_User extends ObjectModel
{
    /**
     * @var int
     */
    public $id_ets_am_user;
    /**
     * @var int
     */
    public $id_customer;
    /**
     * @var int
     */
    public $ref;
    /**
     * @var int
     */
    public $aff;
    /**
     * @var int
     */
    public $loy;
    /**
     * @var int
     */
    public $status;
    public $id_shop;
    public static $definition = array(
        'table' => 'ets_am_user',
        'primary' => 'id_ets_am_user',
        'fields' => array(
            'id_customer' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
            ),
            'loy' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt',
            ),
            'ref' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt',
            ),
            'aff' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt',
            ),
            'status' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt',
            ),
            'id_shop' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt',
            ),
        )
    );
    public static function getUserByCustomerId($id_customer)
    {
        return Db::getInstance()->getRow("SELECT user.*, customer.email as email,customer.id_lang 
            FROM `" . _DB_PREFIX_ . "ets_am_user` user
            LEFT JOIN `" . _DB_PREFIX_ . "customer` customer ON user.id_customer = customer.id_customer
            WHERE user.id_customer = " . (int)$id_customer);
    }
    public static function processActionStatus($id_customer, $action)
    {
        $context = Context::getContext();
        $user = self::getUserByCustomerId($id_customer);
        $actions = array(
            array(
                'label' => Ets_affiliatemarketing::$trans['View'],
                'href' => $context->link->getAdminLink('AdminModules', true) . '&configure=ets_affiliatemarketing&tabActive=reward_users&id_reward_users=' . (int)$id_customer . '&viewreward_users',
                'icon' => 'search',
                'class' => '',
                'action' => '',
                'id' => '',
            )
        );
        if ($action == 'active') {
            $actions[] = array(
                'label' => Ets_affiliatemarketing::$trans['suspend'],
                'class' => 'js-action-user-reward',
                'action' => 'decline',
                'id' => $id_customer,
                'icon' => 'times'
            );
            if ($user) {
                $res = Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "ets_am_user` SET status = 1 WHERE id_customer = " . (int)$id_customer . " AND id_shop = " . (int)$context->shop->id);
                return array(
                    'success' => $res,
                    'actions' => $actions
                );
            }
            return array(
                'success' => true,
                'actions' => $actions
            );
        } elseif ($action == 'decline') {
            $actions[] = array(
                'label' => Ets_affiliatemarketing::$trans['Active'],
                'class' => 'js-action-user-reward',
                'action' => 'active',
                'id' => $id_customer,
                'icon' => 'check'
            );
            if ($user) {
                $res = Db::getInstance()->execute("UPDATE `" . _DB_PREFIX_ . "ets_am_user` SET status = -1 WHERE id_customer = " . (int)$id_customer . " AND id_shop = " . (int)$context->shop->id);
                return array(
                    'success' => $res,
                    'actions' => $actions
                );
            } else {
                $u = new Ets_User();
                $u->id_customer = $id_customer;
                $u->status = -1;
                $u->id_shop = $context->shop->id;
                $u->add();
                return array(
                    'success' => true,
                    'actions' => $actions
                );
            }
        }
        return array(
            'success' => false,
            'actions' => array()
        );
    }
}