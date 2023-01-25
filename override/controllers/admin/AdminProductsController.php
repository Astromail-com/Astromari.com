<?php

class AdminProductsController extends AdminProductsControllerCore
{
    /*
    * module: wkwarehouses
    * date: 2023-01-21 15:36:37
    * version: 1.69.76
    */
    public function processWarehouses()
    {
        return true;
    }
    /*
    * module: directlabelprintproduct
    * date: 2023-01-21 15:39:14
    * version: 3.5.9
    */
    public function __construct()
    {
        $this->addRowAction('label');
        return parent::__construct();
    }
    /*
    * module: directlabelprintproduct
    * date: 2023-01-21 15:39:14
    * version: 3.5.9
    */
    public function displayLabelLink($token, $id, $name)
    {
        return Module::getInstanceByName('directlabelprintproduct')->displayLabelLink($token, $id, $name);
        
    }
}
