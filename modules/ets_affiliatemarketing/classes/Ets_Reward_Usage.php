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
 * needs please, contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <contact@etssoft.net>
 * @copyright  2007-2023 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
 
if (!defined('_PS_VERSION_')) {
    exit();
}
class Ets_Reward_Usage extends ObjectModel
{
    /**
     * @var int
     */
    public $id_ets_am_reward_usage;
    /**
     * @var float
     */
    public $amount;
    /**
     * @var datetime
     */
    public $datetime_added;
    /**
     * @var int
     */
    public $id_customer;
    /**
     * @var int
     */
    public $id_shop;
    /**
     * @var int
     */
    public $id_voucher;
    /**
     * @var int
     */
    public $id_order;
    /**
     * @var int
     */
    public $id_withdraw;
    /**
     * @var int
     */
    public $id_currency;
    /**
     * @var int
     */
    public $status;
    /**
     * @var string
     */
    public $note;
    /**
     * @var int
     */
    public $deleted;
    public $type;
    public static $definition = array(
        'table' => 'ets_am_reward_usage',
        'primary' => 'id_ets_am_reward_usage',
        'multilang_shop' => true,
        'fields' => array(
            'id_ets_am_reward_usage' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'amount' => array(
                'type' => self::TYPE_FLOAT,
                'validate' => 'isFloat'
            ),
            'type' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isString'
            ),
            'id_customer' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_shop' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_voucher' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_withdraw' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_order' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_currency' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'status' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt'
            ),
            'note' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isString'
            ),
            'datetime_added' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDateFormat',
                'allow_null' => true
            ),
            'deleted' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isInt'
            )
        )
    );
    /**
     * @param string $program
     * @param null $id_customer
     * @param null $context
     * @return float
     */
    public static function getTotalEarn($program = 'all', $id_customer = null, $context = null, $id_order = 0)
    {
        if (!$context)
            $context = Context::getContext();
        if (!$id_customer) {
            $id_customer = $context->customer->id;
        }
        $sql = "SELECT SUM(`amount`) AS `total` FROM `" . _DB_PREFIX_ . "ets_am_reward` WHERE `id_customer` = " . (int)$id_customer . " AND `id_shop` = " . (int)$context->shop->id;
        if ($program != 'all' && $program) {
            $sql .= " AND program = '" . pSQL($program) . "'";
        }
        if ($id_order)
            $sql .= ' AND id_order!="' . (int)$id_order . '"';
        $sql .= " AND `deleted` = 0 AND `status` = 1";
        $result = Db::getInstance()->getRow($sql);
        return $result ? (float)$result['total'] : 0;
    }
    /**
     * @param null $id_customer
     * @param bool $only_withdraw
     * @param null $status
     * @param null $context
     * @return float
     */
    public static function getTotalSpent($id_customer = null, $only_withdraw = false, $status = null, $context = null, $program = 'all')
    {
        if (!$context)
            $context = Context::getContext();
        if (!$id_customer && isset($context->customer))
            $id_customer = $context->customer->id;
        $sql = "SELECT SUM(`amount`) as total from `" . _DB_PREFIX_ . "ets_am_reward_usage` WHERE  `id_shop` = " . (int)$context->shop->id . "  AND `deleted` = 0" . ($id_customer ? " AND `id_customer` = " . (int)$id_customer : '');
        if ($only_withdraw) {
            $sql .= " AND id_withdraw IS NOT NULL ";
        }
        if ($program != 'all')
            $sql .= " AND type='" . pSQL($program) . "'";
        if (!is_null($status) && is_int($status) && ($status != -1 || $status != -2)) {
            $sql .= " AND status = " . (int)$status;
        }
        $sql .= " AND `status` != 0";
        $result = Db::getInstance()->getRow($sql);
        return $result ? (float)$result['total'] : 0;
    }
    public static function getTotalSpentLoy($id_customer = null, $only_withdraw = false, $status = null, $context = null)
    {
        if (!$context)
            $context = Context::getContext();
        if (!$id_customer)
            $id_customer = $context->customer->id;
        $sql = "SELECT SUM(`amount`) as total from `" . _DB_PREFIX_ . "ets_am_reward_usage` WHERE `type` = 'loy' AND `id_customer` = " . (int)$id_customer . " AND `id_shop` = " . (int)$context->shop->id . "  AND `deleted` = 0";
        if ($only_withdraw) {
            $sql .= " AND id_withdraw IS NOT NULL ";
        }
        if (!is_null($status) && is_int($status) && ($status != -1 || $status != -2)) {
            $sql .= " AND status = " . (int)$status;
        }
        $sql .= " AND `status` != 0";
        $result = Db::getInstance()->getRow($sql);
        return $result ? (float)$result['total'] : 0;
    }
    /**
     * @param null $id_customer
     * @param null $context
     * @return float
     */
    public static function getTotalBalance($id_customer = null, $context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }
        if (!$id_customer) {
            $id_customer = $context->customer->id;
        }
        $total_earn = self::getTotalEarn('all', $id_customer, $context);
        $total_spent = self::getTotalSpent(false, null, null, $context);
        $total_balance = $total_earn - $total_spent;
        return $total_balance;
    }
    public static function getAmountCanWithdrawRewards($id_customer = null, $context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }
        if (!$id_customer)
            $id_customer = $context->customer->id;
        $allow_withdraw_loyalty = Configuration::get('ETS_AM_ALLOW_WITHDRAW_LOYALTY_REWARDS');
        $total_earn_rewards = self::getTotalEarn('all', $id_customer, $context);
        $total_spent_rewards = self::getTotalSpent($id_customer, false, null, $context);
        $can_withdraw = $total_earn_rewards - $total_spent_rewards;
        if (!$allow_withdraw_loyalty) {
            $total_loyalty = self::getTotalEarn('loy', $id_customer, $context);
            if ($total_loyalty == $total_earn_rewards) {
                return 0;
            }
            $total_withdraw = Ets_Reward_Usage::getTotalSpent($id_customer, true, null, $context);
            $reward_without_loyalty = $total_earn_rewards - $total_loyalty;
            $temp = $reward_without_loyalty - $total_withdraw;
            if ($temp <= 0) {
                return 0;
            }
            $amount_left = $total_earn_rewards - $total_spent_rewards;
            if ($amount_left <= 0) {
                return 0;
            }
            if ($temp >= $amount_left) {
                $can_withdraw = $amount_left;
            } else {
                $can_withdraw = $temp;
            }
        }
        return $can_withdraw;
    }
    /**
     * @param null $id_customer
     * @param null $context
     * @return bool
     * @throws PrestaShopDatabaseException
     */
    public static function isCustomerHasPendingWithdrawal($id_customer)
    {
        $id_customer = (int)$id_customer;
        $sql = "SELECT COUNT(*) as total FROM  `" . _DB_PREFIX_ . "ets_am_reward_usage` eamru INNER JOIN `" . _DB_PREFIX_ . "ets_am_withdrawal` eaw ON eamru.id_withdraw = eaw.id_ets_am_withdrawal WHERE eaw.status=0 AND eamru.id_customer = " . (int)$id_customer . " AND eamru.id_shop = " . (int)Context::getContext()->shop->id . " AND eamru.deleted = 0";
        return ($rs = Db::getInstance()->getRow($sql)) && $rs['total'] > 0 ? true : false;
    }
    public static function getVouchers($id_customer, $params = array())
    {
        $id_customer = (int)$id_customer;
        $limit = isset($params['limit']) && ($limit = (int)$params['limit']) && $limit > 0 ? $limit : 20;
        $page = isset($params['page']) && ($page = (int)$params['page']) && $page > 0 ? $page : 1;
        $context = Context::getContext();
        $sql_where = "FROM `" . _DB_PREFIX_ . "cart_rule` cr
                LEFT JOIN `" . _DB_PREFIX_ . "cart_rule_lang` crl ON (cr.`id_cart_rule` = crl.`id_cart_rule` AND crl.`id_lang` = " . (int)$context->language->id . ")
                INNER JOIN `" . _DB_PREFIX_ . "ets_am_reward_usage` earu ON (cr.id_cart_rule = earu.id_voucher)
                WHERE cr.`id_customer` = " . (int)$id_customer . "
                AND cr.`active` = 1";
        $sql_total = "SELECT COUNT(*) FROM `" . _DB_PREFIX_ . "cart_rule` cr
                LEFT JOIN `" . _DB_PREFIX_ . "cart_rule_lang` crl ON (cr.`id_cart_rule` = crl.`id_cart_rule` AND crl.`id_lang` = " . (int)$context->language->id . ")
                INNER JOIN (SELECT MAX(id_ets_am_reward_usage) as id_ug FROM `" . _DB_PREFIX_ . "ets_am_reward_usage` GROUP BY id_voucher) ug ON (cr.id_cart_rule = ug.id_ug)
                INNER JOIN `" . _DB_PREFIX_ . "ets_am_reward_usage` earu ON (ug.id_ug = earu.id_ets_am_reward_usage)
                WHERE cr.`id_customer` = " . (int)$id_customer . "
                AND cr.`active` = 1";
        $total = Db::getInstance()->getValue($sql_total);
        $total_page = ceil($total / $limit);
        $offset = ($page - 1) * $limit;
        $sql = "SELECT SQL_NO_CACHE * " . (string)$sql_where . " GROUP BY earu.`id_voucher` ORDER BY cr.id_cart_rule DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        $results = Db::getInstance()->executeS($sql);
        $response = array();
        $response['current_page'] = $page;
        $response['total_page'] = $total_page;
        $response['results'] = $results;
        $response['total_data'] = $total;
        $response['per_page'] = $limit;
        return $response;
    }
    public static function getTotalRemaining($id_customer = null, $program = 'all')
    {
        if ((int)$id_customer) {
            $total_point = self::getTotalEarn($program, $id_customer);
            $total_usage = self::getTotalSpent($id_customer, false, null, null, $program);
        } else {
            $total_point = self::getTotalEarn();
            $total_usage = self::getTotalSpent();
        }
        return $total_point - $total_usage;
    }
    public static function getRewardUsageByIDWithdraw($id_withdraw)
    {
        if ($id = (int)Db::getInstance()->getValue('SELECT id_ets_am_reward_usage FROM `' . _DB_PREFIX_ . 'ets_am_reward_usage` WHERE id_withdraw=' . (int)$id_withdraw)) {
            return new Ets_Reward_Usage($id);
        }
        return false;
    }
}
