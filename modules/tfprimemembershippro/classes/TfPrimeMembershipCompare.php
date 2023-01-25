<?php
/**
* 2008-2022 Prestaworld
*
* NOTICE OF LICENSE
*
* The source code of this module is under a commercial license.
* Each license is unique and can be installed and used on only one website.
* Any reproduction or representation total or partial of the module, one or more of its components,
* by any means whatsoever, without express permission from us is prohibited.
*
* DISCLAIMER
*
* Do not alter or add/update to this file if you wish to upgrade this module to newer
* versions in the future.
*
* @author    prestaworld
* @copyright 2008-2022 Prestaworld
* @license https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
* International Registered Trademark & Property of prestaworld
*/

class TfPrimeMembershipPlanCompare extends ObjectModel
{
    public $id_tf_prime_membership_plan;
    public $active;
    public $message;
    public $date_add;
    public $date_upd;

    const TABLE_NAME = 'tf_prime_membership_plan_compare';
    const TABLE_NAME_LANG = 'tf_prime_membership_plan_compare_lang';

    public static $definition = array(
        'table' => 'tf_prime_membership_plan_compare',
        'primary' => 'id_tf_prime_membership_plan_compare',
        'multilang' => true,
        'fields' => array(
            'id_tf_prime_membership_plan' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'shop' => true,
                'validate' => 'isUnsignedInt'
            ),
            'active' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
                'required' => true,
            ),
            'message' => array(
                'type' => self::TYPE_HTML,
                'validate' => 'isCleanHtml',
                'required' => true,
                'lang' => true,
            ),
            'date_add' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDateFormat',
                'required' => false
            ),
            'date_upd' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDateFormat',
                'required' => false
            ),
        ),
    );

    public function getPlanDetail($status = false)
    {
        $sql = 'SELECT `id_tf_prime_membership_plan_compare` FROM '._DB_PREFIX_.self::TABLE_NAME.' WHERE 1';
        if ($status) {
            $sql .= ' AND active = 1';
        }
        return Db::getInstance()->getValue($sql);
    }
}
