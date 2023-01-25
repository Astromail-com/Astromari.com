<?php
/**
 * 2007-2021 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2021 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
	exit;
class Ets_CollectionsCollectionModuleFrontController extends ModuleFrontController
{
    public function __construct()
	{
		parent::__construct();
        $this->display_column_right=false;
        $this->display_column_left =false;
	}
    public function initContent()
	{
		parent::initContent();
        if(Tools::isSubmit('submitLoadmoreCollections'))
        {
            die(
                Tools::jsonEncode(
                    array(
                        'list_collections' => $this->displayBlockListCollections(),
                    )
                )
            );
        }
        if(Configuration::get('PS_REWRITING_SETTINGS') && Configuration::get('ETS_COL_FRIENDLY_URL') && isset($_SERVER['REQUEST_URI']) && Tools::strpos($_SERVER['REQUEST_URI'],'module/ets_collections'))
        {
            if($id_collection = (int)Tools::getValue('id_collection'))
                Tools::redirect($this->module->getCollectionLink(array('id_collection' =>$id_collection)));
            else    
                Tools::redirect($this->module->getCollectionLink());
        }
        $this->module->setMetas();
        $this->context->smarty->assign(
            array(
                'html_content' =>$this->_initContent(),
                'path' => $this->module->getBreadCrumb(),
                'breadcrumb' => $this->module->is17 ? $this->module->getBreadCrumb() : false, 
            )
        );
        if($this->module->is17)
            $this->setTemplate('module:'.$this->module->name.'/views/templates/front/collection.tpl');      
        else        
            $this->setTemplate('collection_16.tpl'); 
    }
    public function _initContent()
    {
        if(($id_collection= (int)Tools::getValue('id_collection')) && ($collectionClass = new Ets_collection_class($id_collection,$this->context->language->id)) && Validate::isLoadedObject($collectionClass) && $collectionClass->active)
        {
            if($collections = Ets_collection_class::getCollectionsByHook('collection_page',$id_collection))
            { 
                $collectionClass->addProductView();
                $this->context->smarty->assign(
                    array(
                        'block_product_list' => $this->module->displayProductList($collections[0]),
                        'collection' => $collectionClass,
                        'list_collections' => $this->displayBlockListCollections(),
                    )
                );
                return $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/collection/collection.tpl');;
            }
            else
            {
                return $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/collection/no_collection.tpl');
            }
        }
        else
        {
            $collections = Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product>0',false,0,false,'c.position asc',false);
            if($collections)
            {
                foreach($collections as &$col)
                {
                    $col['link_view'] = $this->module->getCollectionLink(array('id_collection'=>$col['id_ets_col_collection']));
                }
            }
            $this->context->smarty->assign(
                array(
                    'collections' => $collections,
                    'link_base' => $this->module->getBaseLink(),
                    'paggination' => '',
                    'ETS_COL_PAGE_TITLE' => Configuration::get('ETS_COL_PAGE_TITLE',$this->context->language->id),
                    'ETS_COL_PAGE_DESCRIPTION' => Configuration::get('ETS_COL_PAGE_DESCRIPTION',$this->context->language->id),
                )
            );
            if(Tools::isSubmit('ajax'))
                die(
                    Tools::jsonEncode(
                        array(
                            'collection_list'=> $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/collection/collection_list.tpl'),
                        )
                    )
                );
            else
            $this->context->smarty->assign(
                array(
                    'collection_list'=> $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/collection/collection_list.tpl'),
                )
            );
            return $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/collection/collections.tpl');
        }
    }
    public function displayBlockListCollections()
    {
        $limit = 10;
        $page = (int)Tools::getValue('next_page');
        if($page <1)
            $page = 1;
        $totalRecords = (int)Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product >0','',0,0,'',true);
        $totalPages = ceil($totalRecords / $limit);
        if($page > $totalPages)
            $page = $totalPages;
        $start = $limit * ($page - 1);
        if($start < 0)
            $start = 0;
        $collections = Ets_collection_class::getInstance()->getCollections(' AND c.active=1 AND cp.total_product >0',false,$start,$limit);
        if($collections)
        {
            foreach($collections as &$col)
                $col['link'] = $this->module->getCollectionLink(array('id_collection'=>$col['id_ets_col_collection']));
        }
        $this->context->smarty->assign(
            array(
                'collections' => $collections,
                'load_more' => $page < $totalPages ? $page+1 :false
            )
        );
        return $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/block_list_collections.tpl');
    }
}