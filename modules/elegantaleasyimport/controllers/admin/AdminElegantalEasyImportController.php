<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is controller for admin Menu
 */
class AdminElegantalEasyImportController extends ModuleAdminController
{
    /** @var ElegantalEasyImport */
    public $module;

    public function __construct()
    {
        parent::__construct();

        Tools::redirectAdmin($this->module->getAdminUrl());
    }
}
