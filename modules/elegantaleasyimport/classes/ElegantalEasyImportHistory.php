<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is an object model class used to manage import history logs
 */
class ElegantalEasyImportHistory extends ElegantalEasyImportObjectModel
{
    public $tableName = 'elegantaleasyimport_history';
    public static $definition = array(
        'table' => 'elegantaleasyimport_history',
        'primary' => 'id_elegantaleasyimport_history',
        'fields' => array(
            'id_elegantaleasyimport' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'total_number_of_products' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'number_of_products_processed' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'number_of_products_created' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'number_of_products_updated' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'number_of_products_deleted' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'date_started' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_ended' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);

        if ($this->date_started == '0000-00-00 00:00:00') {
            $this->date_started = null;
        }
        if ($this->date_ended == '0000-00-00 00:00:00') {
            $this->date_ended = null;
        }
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function createNew($id_elegantaleasyimport)
    {
        $history = new self();
        $history->id_elegantaleasyimport = $id_elegantaleasyimport;
        $history->total_number_of_products = 0;
        $history->number_of_products_processed = 0;
        $history->number_of_products_created = 0;
        $history->number_of_products_updated = 0;
        $history->number_of_products_deleted = 0;
        $history->date_started = date('Y-m-d H:i:s');
        $history->date_ended = date('Y-m-d H:i:s');
        if (!$history->add()) {
            throw new Exception(Db::getInstance()->getMsgError());
        }

        // Clear old error log
        self::clearOldErrors($id_elegantaleasyimport);

        return $history;
    }

    public function getErrorsCount()
    {
        $count = ElegantalEasyImportError::model()->countAll(array(
            'condition' => array(
                'id_elegantaleasyimport_history' => $this->id,
            ),
        ));
        return (int) $count;
    }

    public static function clearOldErrors($id_elegantaleasyimport)
    {
        $date = date('Y-m-d H:i:s', strtotime("-1 week"));
        Db::getInstance()->execute("DELETE FROM `" . _DB_PREFIX_ . "elegantaleasyimport_error` WHERE `id_elegantaleasyimport_history` IN (SELECT `id_elegantaleasyimport_history` FROM `" . _DB_PREFIX_ . "elegantaleasyimport_history` WHERE `id_elegantaleasyimport` = " . (int) $id_elegantaleasyimport . ") AND `date_created` < '" . pSQL($date) . "'");
    }
}
