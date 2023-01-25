<?php
/**
 * 2016-2017 Leone MusicReader B.V.
 *
 * NOTICE OF LICENSE
 *
 * Source file is copyrighted by Leone MusicReader B.V.
 * Only licensed users may install, use and alter it.
 * Original and altered files may not be (re)distributed without permission.
 *
 * @author    Leone MusicReader B.V.
 *
 * @copyright 2016-2017 Leone MusicReader B.V.
 *
 * @license   custom see above
 */

class AdminOrdersController extends AdminOrdersControllerCore
{

    public function __construct()
    {
        $this->addRowAction('label');
        return parent::__construct();
    }

    public function displayLabelLink($token, $id, $name)
    {
        return Module::getInstanceByName('directlabelprint')->displayLabelLink($token, $id, $name);
    }
}
