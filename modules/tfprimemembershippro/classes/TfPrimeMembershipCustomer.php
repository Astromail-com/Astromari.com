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

class TfPrimeMembershipCustomer extends ObjectModel
{
    // Shop Fields
    public $id_shop;
    public $id_shop_default;

    public $id_reference;
    public $id_plan;
    public $id_customer;
    public $type;
    public $duration;
    public $id_product;
    public $id_customer_group;
    public $id_order;
    public $price;
    public $id_currency;
    public $is_renew;
    public $is_extended;
    public $activated_date;
    public $expiry_date;
    public $is_warning_sent;
    public $active;
    public $date_add;
    public $date_upd;

    const TABLE_NAME = 'tf_prime_membership_customer';

    public static $definition = array(
        'table' => 'tf_prime_membership_customer',
        'primary' => 'id_tf_prime_membership_customer',
        'fields' => array(
            'id_shop' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'id_shop_default' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'id_reference' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt'
            ),
            'id_plan' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'id_customer' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'id_customer_group' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'type' => array(
                'type' => self::TYPE_STRING,
                'required' => true,
                'validate' => 'isCleanHtml'
            ),
            'duration' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'id_product' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'id_order' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'price' => array(
                'type' => self::TYPE_FLOAT,
                'validate' => 'isUnsignedFloat'
            ),
            'id_currency' => array(
                'type' => self::TYPE_INT,
                'required' => true,
                'validate' => 'isUnsignedInt'
            ),
            'is_extended' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
            ),
            'is_renew' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
            ),
            'active' => array(
                'type' => self::TYPE_INT,
                'required' => true
            ),
            'is_warning_sent' => array(
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
            ),
            'activated_date' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDateFormat',
                'required' => false
            ),
            'expiry_date' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDateFormat',
                'required' => false
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

    public function getPrimeUser($idCustomer, $idPlan, $active = true)
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.TfPrimeMembershipCustomer::TABLE_NAME.'
            WHERE `id_customer` = '.(int) $idCustomer.' AND id_plan = '.(int)$idPlan;

        if ($active) {
            $sql .= ' AND `active` = 1';
        }
        return Db::getInstance()->getRow($sql);
    }

    public function getPrimeUserDetails($idCustomer, $idLang, $idShop)
    {
        return Db::getInstance()->executeS(
            'SELECT
                o.`reference`,
                pl.`name`,
                pc.`active` as prime_customer_active,
                pc.*,
                p.* FROM '._DB_PREFIX_.TfPrimeMembershipCustomer::TABLE_NAME.' pc
            LEFT JOIN '._DB_PREFIX_.'orders o on (o.`id_order` = pc.`id_order`)
            LEFT JOIN '._DB_PREFIX_.'tf_prime_membership_plan p on (p.`id_tf_prime_membership_plan` = pc.`id_plan`)
            LEFT JOIN '._DB_PREFIX_.'tf_prime_membership_plan_lang pl on
            (pl.`id_tf_prime_membership_plan` = p.`id_tf_prime_membership_plan`)
                WHERE
                    pc.`id_customer` = '.(int) $idCustomer.' AND
                    pl.`id_lang` = '.(int) $idLang.' AND
                    pc.`id_shop` = '.(int) $idShop
        );
    }

    public function addCustomerIntoPrimeGroup($idCustomer, $idCustomerGroup)
    {
        if (!$this->checkCustomerGroup($idCustomer, $idCustomerGroup)) {
            Db::getInstance()->insert(
                'customer_group',
                array(
                    'id_group' => (int) $idCustomerGroup,
                    'id_customer' => (int) $idCustomer
                )
            );

            $obj_cust = new Customer($idCustomer);
            $obj_cust->id_default_group = (int) $idCustomerGroup;
            $obj_cust->update();
        }
    }

    public function removeCustomerFromPrimeGroup($idCustomer, $idCustomerGroup)
    {
        Db::getInstance()->delete(
            'customer_group',
            '`id_customer` = '.(int) $idCustomer.' AND
            `id_group` = '.(int) $idCustomerGroup
        );
        $self = new self();
        $idGroup = $self->getLastUpdateCustomerGroup($idCustomer);
        if (!$idGroup) {
            $idGroup = 3;
        }
        $obj_cust = new Customer($idCustomer);
        $obj_cust->id_default_group = $idGroup;
        $obj_cust->update();
    }

    public function getLastUpdateCustomerGroup($idCustomer)
    {
        return Db::getInstance()->getValue(
            'SELECT `id_group` FROM '._DB_PREFIX_.'customer_group
                Where id_customer = '. (int) $idCustomer.' ORDER BY id_group DESC'
        );
    }

    public function checkCustomerGroup($idCustomer, $idCustomerGroup)
    {
        return Db::getInstance()->getValue(
            'SELECT `id_group` FROM '._DB_PREFIX_.'customer_group
                WHERE
                    id_group = '.(int) $idCustomerGroup.' AND
                    id_customer = '.(int) $idCustomer
        );
    }

    public function getPrimeUserByIdOrder($idOrder)
    {
        return Db::getInstance()->getRow(
            'SELECT * FROM '._DB_PREFIX_.TfPrimeMembershipCustomer::TABLE_NAME.' WHERE id_order = '.(int) $idOrder
        );
    }

    public function getExpiredPrimeUserByIdCustomer($idCustomer, $idPlan)
    {
        return Db::getInstance()->getRow(
            'SELECT * FROM '._DB_PREFIX_.TfPrimeMembershipCustomer::TABLE_NAME.'
                WHERE `id_customer` = '.(int) $idCustomer.' AND id_plan = '.(int)$idPlan.' AND `active` = 2'
        );
    }

    public static function getPrimeReferenceByID($id)
    {
        return Db::getInstance()->getRow(
            'SELECT * FROM '._DB_PREFIX_.TfPrimeMembershipCustomer::TABLE_NAME.'
                WHERE `id_reference` = '.(int) $id
        );
    }

    public function getAllPrimeUser($active = true)
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.TfPrimeMembershipCustomer::TABLE_NAME.' WHERE 1 ';

        if ($active) {
            $sql .= ' AND `active` = 1';
        }
        return Db::getInstance()->executeS($sql);
    }

    public static function getCustomers($onlyActive = true, $lastCount = 0, $limit = 10)
    {
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            'SELECT `id_customer`, `email`, `firstname`, `lastname` FROM `'._DB_PREFIX_.'customer` c
                WHERE 1 '.Shop::addSqlRestriction(Shop::SHARE_CUSTOMER).($onlyActive ? ' AND `active` = 1' : '').'
                    AND c.`id_customer` NOT IN
                    (SELECT id_customer FROM `'._DB_PREFIX_.'tf_prime_membership_customer` Where 1)
                    ORDER BY `id_customer` ASC LIMIT '.(int) $lastCount.', ' . (int) $limit
        );
    }
}
