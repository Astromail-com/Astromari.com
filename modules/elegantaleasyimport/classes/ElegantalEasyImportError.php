<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is an object model class used to manage import history error logs
 */
class ElegantalEasyImportError extends ElegantalEasyImportObjectModel
{
    public $tableName = 'elegantaleasyimport_error';
    public static $definition = array(
        'table' => 'elegantaleasyimport_error',
        'primary' => 'id_elegantaleasyimport_error',
        'fields' => array(
            'id_elegantaleasyimport_history' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'product_id_reference' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'error' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'date_created' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        )
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
