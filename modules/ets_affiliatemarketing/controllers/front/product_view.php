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
 * needs please, contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <contact@etssoft.net>
 * @copyright  2007-2023 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

class Ets_affiliatemarketingProduct_viewModuleFrontController extends ModuleFrontController
{
    /**
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     * @throws Exception
     */
    public function init()
    {
        parent::init();
        header('X-Robots-Tag: noindex, nofollow', true);
        $id_product = (int)Tools::getValue('id_product');
        if (! Configuration::get('ETS_AM_AFF_ENABLED', false) || ! Ets_Affiliate::isCustomerApplicableAffiliatedProgram()) {
            json_encode(array('success' => false, 'message' => $this->module->l('Request not found','product_view')));
        }
        if ($affp = (int)Tools::getValue('eam_id_seller')) {
            $id_seller = (int) $affp;
            $ip_address = Tools::getRemoteAddr();
            $access_key = Ets_Access_Key::generateAccessKey();
            if ($id_product) {
                $id_product = (int) $id_product;
                if (Tools::isSubmit('eam_get_access_key')) {
                    if( !$this->isTokenValid()){
                        die(json_encode(array(
                            'success' => false,
                            'message' => $this->module->l('Token is invalid', 'product_view')
                        )));
                    }
                    $check = "SELECT COUNT(*) FROM `" . _DB_PREFIX_ . "ets_am_access_key` WHERE `id_product` = " . (int)$id_product . " AND `id_seller` = " . (int)$id_seller . " AND `ip_address` = '" . pSQL($ip_address) . "'";
                    if (Db::getInstance()->getValue($check)) {
                        die(json_encode(array('success' => false)));
                    }
                    $cookie = $this->getCookie(EAM_CUSTOMER_VIEW_PRODUCT);
                    if ($cookie) {
                        $cookie = explode('-', $cookie);
                        if (!in_array($id_product, $cookie)) {
                            $this->sendAccessKeyResponse($id_seller, $id_product, $access_key, $ip_address);
                        }
                    } else {
                        $this->sendAccessKeyResponse($id_seller, $id_product, $access_key, $ip_address);
                    }
                    die(json_encode(array('success' => false)));
                }
                if (Tools::isSubmit('eam_check_access_key')) {
                    $key = Tools::getValue('eam_access_key');
                    if(!$this->isTokenValid()){
                        die(json_encode(array(
                            'success' => false,
                            'message' => $this->module->l('Token is invalid', 'product_view')
                        )));
                    }
                    if ($key && Validate::isCleanHtml($key) && Ets_Access_Key::isValidAccessKey($key, $id_product, $id_seller)) {
                        $sql = "SELECT * FROM `" . _DB_PREFIX_ . "ets_am_product_view` WHERE `id_product` = " . (int)$id_product . " AND `id_seller` = '" . pSQL($id_seller). "' AND `date_added` = '" . pSQL(date('Y-m-d')) . "'";
                        $result = Db::getInstance()->getRow($sql);
                        if ($result) {
                            $count = (int)$result['count'] + 1;
                            $sql = "UPDATE `" . _DB_PREFIX_ . "ets_am_product_view` SET `count` = " . (int)$count . " WHERE `id_product` = " . (int)$id_product . " AND `id_seller` = '" .pSQL($id_seller) . "' AND `date_added` = '" . pSQL(date('Y-m-d')) . "'";
                            Db::getInstance()->execute($sql);
                            die(json_encode(array('success' => true)));
                        } else {
                            $product_view = new Ets_Product_View();
                            $product_view->id_product = $id_product;
                            $product_view->id_seller = $id_seller;
                            $product_view->count = 1;
                            $product_view->date_added = date('Y-m-d');
                            if ($product_view->add()) {
                                die(json_encode(array('success' => true)));
                            }
                        }
                    }
                }
            }
        }
        die(json_encode(array('success' => false)));
    }

    /**
     * @param $id_seller
     * @param $id_product
     * @param $access_key
     * @param $ip_address
     * @throws Exception
     */
    protected function sendAccessKeyResponse($id_seller, $id_product, $access_key, $ip_address)
    {
        $access = new Ets_Access_Key();
        $access->id_seller = (int)$id_seller;
        $access->id_product = (int)$id_product;
        $access->ip_address = $ip_address;
        $access->key = $access_key;
        $access->datetime_added = date('Y-m-d H:i:s');
        if ($access->add()) {
            $curr_cookie = $this->getCookie(EAM_CUSTOMER_VIEW_PRODUCT);
            $curr_cookie = explode('-', $curr_cookie);
            if (!in_array($id_product, $curr_cookie)) {
                $curr_cookie[] = $id_product;
            }
            $curr_cookie = implode('-', $curr_cookie);
            $this->setCookie(EAM_CUSTOMER_VIEW_PRODUCT, $curr_cookie);
            die(json_encode(array('success' => true, 'access_key' => $access_key)));
        }
    }

    /**
     * @param $key
     * @return string
     */
    protected function getCookie($key)
    {
        return $this->context->cookie->__get($key);
    }

    /**
     * @param $key
     * @param $value
     * @throws Exception
     */
    protected function setCookie($key, $value)
    {
        $this->context->cookie->__set($key, $value);
    }

    /**
     * @param $key
     */
    protected function unsetCookie($key)
    {
        $this->context->cookie->__unset($key);
    }
}
