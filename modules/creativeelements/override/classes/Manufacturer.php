<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

defined('_PS_VERSION_') or die;

class Manufacturer extends ManufacturerCore
{
    const CE_OVERRIDE = true;

    public function __construct($id = null, $idLang = null)
    {
        parent::__construct($id, $idLang);

        $ctrl = Context::getContext()->controller;
        if ($ctrl instanceof ManufacturerController && !ManufacturerController::$initialized && !$this->active && Tools::getIsset('id_employee') && Tools::getIsset('adtoken')) {
            $tab = 'AdminManufacturers';
            if (Tools::getAdminToken($tab . (int) Tab::getIdFromClassName($tab) . (int) Tools::getValue('id_employee')) == Tools::getValue('adtoken')) {
                $this->active = 1;
            }
        }
    }
}
