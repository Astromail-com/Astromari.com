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

use Invertus\Printify\Exception\InvalidPrintifyRoutingConfiguration;
use Invertus\Printify\Exception\RouteDefinitionNotFoundException;
use Invertus\Printify\Repository\ProductRepository;
use Invertus\Printify\Service\PrintifyLink;
use Invertus\Printify\Service\ImageManager;

/**
 * Class AdminPrintifyProductController - used for information display for printify product
 */
class AdminPrintifyProductController extends \Invertus\Printify\Controller\AdminController
{
    /**
     * @var PrintifyContainer
     */
    private $moduleContainer;

    /**
     * @throws PrestaShopException
     */
    public function __construct()
    {
        $this->table = 'printify_product';
        $this->lang = false;
        $this->identifier_name = 'id_printify_product';

        parent::__construct();

        $this->moduleContainer = $this->module->getModuleContainer();
    }

    public function init()
    {
        $this->page_header_toolbar_btn['add_new_product'] = array(
            'href' => 'https://printify.com/app/products',
            'desc' => $this->module->l('Add new product'),
            'icon' => 'process-icon-add',
        );
        parent::init();

        unset($this->toolbar_btn['new']);
        $this->initList();
    }

    private function initList()
    {

        $this->list_no_link = true;
        $this->addRowAction('EditProduct');
        $this->addRowAction('ViewProduct');

        $this->_select = 'pl.name, print.title, pb.brand, i.id_image';
        $this->_join = 'LEFT JOIN ' . _DB_PREFIX_ . 'product p ON a.id_product = p.id_product
            LEFT JOIN ' . _DB_PREFIX_ . 'product_lang pl ON pl.id_product = p.id_product AND pl.id_lang = 1
            LEFT JOIN ' . _DB_PREFIX_ . 'image i ON i.id_product = p.id_product AND i.cover = 1
            LEFT JOIN ' . _DB_PREFIX_ . 'printify_print_provider print ON print.printify_print_provider_id = a.printify_print_provider_id
            LEFT JOIN ' . _DB_PREFIX_ . 'printify_blueprint pb ON pb.printify_blueprint_id = a.printify_blueprint_id';

        $this->fields_list = array(
            'id_image' => array(
                'title' => $this->trans('Image', array(), 'Admin.Global'),
                'callback' => 'getImagePath',
                'search' => false,
                'orderby' => false,
            ),
            'name' => array(
                'title' => $this->trans('Product', array(), 'Admin.Global'),
            ),
            'title' => array(
                'title' => $this->trans('Print provider', array(), 'Admin.Global'),

            ),
            'brand' => array(
                'title' => $this->trans('Brand', array(), 'Admin.Global'),
            ),
        );
    }

    /**
     * @param $token
     * @param $id
     * @return string
     * @throws InvalidPrintifyRoutingConfiguration
     * @throws RouteDefinitionNotFoundException
     * @throws SmartyException
     */
    public function displayEditProductLink($token, $id)
    {
        /** @var PrintifyLink $router */
        $router = $this->moduleContainer->get('printify_router');
        $url = $router->generateUrl('admin_printify_product_edit', ['productId' => $id]);

        $params = [
            'href' => $url,
            'action' => $this->module->l('Edit'),
            'icon' => 'icon-edit',
            'target' => '_blank'
        ];

        return $this->renderListAction($params);
    }

    /**
     * @param $token
     * @param $id
     * @return string
     * @throws PrestaShopException
     * @throws SmartyException
     */
    public function displayViewProductLink($token, $id)
    {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->module->getModuleContainer()->get('product_repository');

        $url = $this->context->link->getAdminLink(
            'AdminProducts',
            true,
            ['id_product' => $productRepository->findProductByPrintifyId($id)]
        );

        $params = [
            'href' => $url,
            'action' => $this->module->l('View'),
            'icon' => 'icon-eye-open',
            'target' => null,
        ];

        return $this->renderListAction($params);
    }

    /**
     * @param array $params
     * @return string
     * @throws SmartyException
     */
    private function renderListAction(array $params)
    {
        $this->context->smarty->assign($params);

        return $this->context->smarty->fetch($this->module->getLocalPath().'views/templates/admin/list-action.tpl');
    }

    /**
     * @param $imageId
     * @return mixed
     */
    public function getImagePath($imageId)
    {
        /** @var ImageManager $imageManager */
        $imageManager = $this->module->getModuleContainer()->get('image_manager');

        return $imageManager->getThumbnailForListing($imageId);
    }
}
