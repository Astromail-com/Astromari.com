<?php
/**
 * 2007-2023 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2023 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

class Dispatcher extends DispatcherCore
{
    public function getController___ybc_blog($id_shop = null)
    {
        parent::getController($id_shop);
        $controller = $this->controller;
        if ($controller == '404' || $controller == 'pagenotfound' || $controller == 'sitemap') {
            if (Configuration::get('YBC_BLOG_ENABLE_SITEMAP') && preg_match("/modules\/ybc_blog\/sitemap(\/(\w+(\/(\w+)|))|)\.xml$/", $this->request_uri)) {
                $_GET['module'] = 'ybc_blog';
                $this->controller = 'sitemap';
                $_GET['fc'] = 'module';
                $this->front_controller = self::FC_MODULE;
            }
        }
        return $this->controller;
    }   
}