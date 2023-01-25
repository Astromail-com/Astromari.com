<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is an object model class used to manage CSV rows saved in database
 */
class ElegantalEasyImportData extends ElegantalEasyImportObjectModel
{
    public $tableName = 'elegantaleasyimport_data';
    public static $definition = array(
        'table' => 'elegantaleasyimport_data',
        'primary' => 'id_elegantaleasyimport_data',
        'fields' => array(
            'id_elegantaleasyimport' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'id_reference' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'csv_row' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
        )
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
