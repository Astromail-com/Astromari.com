<?php
/**
 * 2021 Leone MusicReader B.V.
 *
 * NOTICE OF LICENSE
 *
 * Source file is copyrighted by Leone MusicReader B.V.
 * Only licensed users may install, use and alter it.
 * Original and altered files may not be (re)distributed without permission.
 *
 * @author    Leone MusicReader B.V.
 *
 * @copyright 2021 Leone MusicReader B.V.
 *
 * @license   custom see above
 */

class AdminDirectLabelPrintController extends ModuleAdminController
{

    public function ajaxProcessGetAddress()
    {
        $id=(int)Tools::getValue("id");

        $module=Module::getInstanceByName('directlabelprint');
        $address = $module->getDeliver($id);
        $lines = $module->getlinesString($address);
        $this->ajaxDie($lines);
    }

    public function ajaxProcessGetOrderedProducts()
    {
        $id=(int)Tools::getValue("id");

        $products = Module::getInstanceByName('directlabelprint')->getOrderedProducts($id);
        $serialnumbers=Module::getInstanceByName('serialnumbers');
        if ($serialnumbers!=false) {
            //[{"id_order_detail":"21","quantity":"1","product_name":"Printed Dress - Size : S- Color : Orange","id_warehouse":"0","download_hash":"","id_keymanager_product":"2","id_product":"3","id_product_attribute":"13","email":"1"}]

            //$products_json = Tools::jsonEncode($ordered_serials);
            //print($products_json);
            for ($i = 0; $i < count($products); $i++) {
                $id_order_detail=$products[$i]["id_order_detail"];
                $serials=Module::getInstanceByName('directlabelprintproduct')->getOrderedSerials($id, $id_order_detail);
                if (count($serials)>0) {
                    $products[$i]["serial_no"] = $serials;
                }
            }
        }
        $products_json = Tools::jsonEncode($products);
        $this->ajaxDie($products_json);
    }

    public function ajaxProcessGetOrderInfo()
    {
        $id=(int)Tools::getValue("order_id");

        $info = Module::getInstanceByName('directlabelprint')->getOrderInfo($id);

        $info_json = Tools::jsonEncode($info);
        $this->ajaxDie($info_json);
    }

    public function ajaxProcessGetCurrentTemplate()
    {
        $data=Module::getInstanceByName('directlabelprint')->getDymoTemplate();

        $template_file="labeltemplate.label";
        if (strpos($data, "<DesktopLabel ")>0) {
            $template_file="labeltemplate.dymo";
        }

        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename="'.$template_file.'"');

        $this->ajaxDie($data);
    }
}
