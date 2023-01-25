<?php
/**
 * NOTICE OF LICENSE
 *
 * @author    INVERTUS, UAB www.invertus.eu <support@invertus.eu>
 * @copyright Copyright (c) permanent, INVERTUS, UAB
 * @license   MIT
 * @see       /LICENSE
 *
 *  International Registered Trademark & Property of INVERTUS, UAB
 */


class AdminPrintifyLogController extends \Invertus\Printify\Controller\AdminController
{
    /**
     *
     * @throws PrestaShopException
     */
    public function __construct()
    {
        $this->table = 'printify_log';
        $this->identifier_name = 'id';
        parent::__construct();
    }

    public function init()
    {
        parent::init();
        $this->initList();
        unset($this->toolbar_btn['new']);
    }

    private function initList()
    {
        $this->list_no_link = true;
        $this->fields_list = array(
            'type' => array(
                'title' => $this->module->l('Type'),
                'align' => 'center',
                'havingFilter' => true,
                'type' => 'text'
            ),
            'id_object' => array(
                'title' => $this->module->l('Object Id'),
                'align' => 'center',
                'type' => 'text',
            ),
            'status' => array(
                'title' => $this->module->l('Status'),
                'align' => 'center',
                'type' => 'text',

            ),
            'message' => array(
                'title' => $this->module->l('Message'),
                'align' => 'center',
                'type' => 'text',
            ),
            'date' => array(
                'title' => $this->module->l('Date'),
                'align' => 'center',
                'type' => 'datetime',
            ),
        );
    }
}
