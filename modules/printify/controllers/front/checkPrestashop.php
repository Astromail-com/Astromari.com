<?php

class PrintifyCheckPrestashopModuleFrontController extends ModuleFrontController
{
    /**
     * @throws PrestaShopException
     */
    public function postProcess()
    {
        $this->ajaxDie(_PS_VERSION_);
    }
}


