<?php
/**
 * 2007-2022 ETS-Soft
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
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2022 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
	exit;
/**
 * Class Ets_MarketPlaceRatingsModuleFrontController
 * @property \Ets_mp_seller $seller
 * @property \Ets_marketplace $module
 */
class Ets_MarketPlaceRatingsModuleFrontController extends ModuleFrontController
{
    public $_errors= array();
    public $_success ='';
    public $seller;
    public $is_ets;
    public function __construct()
	{
		parent::__construct();
        $this->display_column_right=false;
        $this->display_column_left =false;
        if(Module::isEnabled('productcomments'))
        {
            $this->is_ets = false;
        }elseif( Module::isEnabled('ets_reviews'))
        {
            $this->is_ets = true;
        }
	}
    public function postProcess()
    {
        parent::postProcess();
        if(!Module::isEnabled('productcomments') &&  !Module::isEnabled('ets_reviews'))
            return '';
        if(!$this->context->customer->isLogged() || !($this->seller = $this->module->_getSeller(true)) )
            Tools::redirect($this->context->link->getModuleLink($this->module->name,'myseller'));
        if(!$this->module->_checkPermissionPage($this->seller))
            die($this->module->l('You do not have permission to access this page','suppliers'));
        if(Tools::getValue('approve')=='yes' && ($id_comment = Tools::getValue('id_comment')) && Validate::isUnsignedId($id_comment))
        {
            if(!$this->is_ets)
            {
                $productComment = Ets_mp_product::getProductComment($id_comment);
                if(!$productComment)
                    $this->_errors[] = $this->module->l('Review is not valid','ratings');
                elseif(!$this->seller->checkHasProduct($productComment['id_product']) || !Configuration::get('ETS_MP_SELLER_APPROVE_REVIEW'))
                    $this->_errors[] = $this->module->l('You do not have permission to approve this review','ratings');
                else
                {
                    Ets_mp_product::updateStatusProductComment($id_comment,1);
                    $this->context->cookie->success_message = $this->module->l('Approved successfully','ratings');
                    Tools::redirect($this->context->link->getModuleLink($this->module->name,'ratings'));
                }
            }
            else
            {
                if(Module::isEnabled('ets_reviews'))
                    $productComment = new EtsRVProductComment($id_comment);
                else
                    $productComment = new EtsPcProductComment($id_comment);
                if(!Validate::isLoadedObject($productComment))
                    $this->_errors[] = $this->module->l('Review is not valid','ratings');
                elseif(!$this->seller->checkHasProduct($productComment->id_product) || !Configuration::get('ETS_MP_SELLER_APPROVE_REVIEW') )
                    $this->_errors[] = $this->module->l('You do not have permission to approve this review','ratings');
                else
                {
                    $productComment->validate = 1;
                    if($productComment->update())
                    {
                        $this->context->cookie->success_message = $this->module->l('Approved successfully','ratings');
                        Tools::redirect($this->context->link->getModuleLink($this->module->name,'ratings'));
                    }
                    else
                        $this->_errors[] = $this->module->l('An error occurred while saving the review','ratings');
                }
            }
        }
        if(Tools::getValue('del')=='yes' && ($id_comment = Tools::getValue('id_comment')) && Validate::isUnsignedId($id_comment))
        {
            if(!$this->is_ets)
            {
                $productComment = Ets_mp_product::getProductComment($id_comment);
                if(!$productComment)
                    $this->_errors[] = $this->module->l('Review is not valid','ratings');
                elseif(!$this->seller->checkHasProduct($productComment['id_product']) || !Configuration::get('ETS_MP_SELLER_DELETE_REVIEW'))
                    $this->_errors[] = $this->module->l('You do not have permission to approve this review','ratings');
                else
                {
                    Ets_mp_product::deleteProductComment($id_comment);
                    $this->context->cookie->success_message = $this->module->l('Deleted successfully','ratings');
                    Tools::redirect($this->context->link->getModuleLink($this->module->name,'ratings'));
                }
            }
            else
            {
                if(Module::isEnabled('ets_reviews'))
                    $productComment = new EtsRVProductComment($id_comment);
                else
                    $productComment = new EtsPcProductComment($id_comment);
                if(!Validate::isLoadedObject($productComment))
                    $this->_errors[] = $this->module->l('Review is not valid','ratings');
                elseif(!$this->seller->checkHasProduct($productComment->id_product) || !Configuration::get('ETS_MP_SELLER_DELETE_REVIEW'))
                    $this->_errors[] = $this->module->l('You do not have permission to delete this review','ratings');
                else
                {
                    if($productComment->delete())
                    {
                        $this->context->cookie->success_message = $this->module->l('Deleted successfully');
                        Tools::redirect($this->context->link->getModuleLink($this->module->name,'ratings'));
                    }
                    else
                        $this->_errors[] = $this->module->l('An error occurred while deleting the review','ratings');
                }
            }
        }
    }
    public function initContent()
	{
		parent::initContent();
        if($this->context->cookie->success_message)
        {
            $this->_success = $this->context->cookie->success_message;
            $this->context->cookie->success_message ='';
        }    
        $this->context->smarty->assign(
            array(
                'path' => $this->module->getBreadCrumb(),
                'breadcrumb' => $this->module->is17 ? $this->module->getBreadCrumb() : false, 
                'html_content' => $this->_initContent(),
                '_errors' => $this->_errors ? $this->module->displayError($this->_errors):'',
                '_success' => $this->_success ? $this->module->displayConfirmation($this->_success):'',
            )
        );
        if($this->module->is17)
            $this->setTemplate('module:'.$this->module->name.'/views/templates/front/ratings.tpl');      
        else        
            $this->setTemplate('ratings_16.tpl'); 
    }
    public function _initContent()
    {
        if(!Module::isEnabled('productcomments') && !Module::isEnabled('ets_reviews'))
            return $this->module->displayWarning($this->module->l('Page not found','ratings'));
        $fields_list = array(
            'id_comment' => array(
                'title' => $this->module->l('ID','ratings'),
                'width' => 40,
                'type' => 'text',
                'sort' => true,
                'filter' => true,
            ),
            'review'=> array(
                'title' => $this->module->l('Review','ratings'),
                'type'=>'text',
                'strip_tag' => false,
                'sort'=>false,
                'filter'=> false,
            ),
            'grade' => array(
                'title' => $this->module->l('Ratings','ratings'),
                'type' => 'text',
                'sort' => true,
                'filter' => true,
                'strip_tag' => false,
            ),
            'name' => array(
                'title' => $this->module->l('Product','ratings'),
                'type' => 'text',
                'sort' => true,
                'filter' => true,
                'strip_tag' => false,
            ),
            'validate' => array(
                'title' => $this->module->l('Status','ratings'),
                'type' => 'active',
                'sort' => true,
                'filter' => true,
                'strip_tag' => false,
                'filter_list' => array(
                    'id_option' => 'active',
                    'value' => 'title',
                    'list' => array(
                        0 => array(
                            'active' => 1,
                            'title' => $this->module->l('Enabled','ratings')
                        ),
                        1 => array(
                            'active' => 0,
                            'title' => $this->module->l('Disabled','ratings')
                        )
                    )
                )
            ),
            'date_add' => array(
                'title' => $this->module->l('Time of publication','ratings'),
                'type' => 'date',
                'sort' => true,
                'filter' => true,
                'class' => 'text-center'
            ),
        );
        //Filter
        $validate = true;
        if(!$this->is_ets)
        {
            if(!Configuration::get('PRODUCT_COMMENTS_MODERATE'))
                $validate = false;
        }else
        {
            if(!Configuration::get('ETS_PC_MODERATE'))
                $validate = false;
        }
        if(!$validate)
            unset($fields_list['validate']);
        $show_resset = false;
        $filter = "";
        $having="";
        if(($id_comment = Tools::getValue('id_comment')) && !Tools::getValue('del') && !Tools::getValue('approve'))
        {
            if(Validate::isUnsignedId($id_comment))
            {
                if(Module::isEnabled('ets_reviews'))
                    $filter .= ' AND pc.id_ets_rv_product_comment="'.(int)$id_comment.'"';
                else
                    $filter .= ' AND pc.id_product_comment="'.(int)$id_comment.'"';
            }
            $show_resset = true;
        }
        if(($name = Tools::getValue('name')) || $name!='')
        {
            if(Validate::isCatalogName($name))
                $filter .=' AND pl.name LIKE "%'.pSQL($name).'%"';
            $show_resset = true;
        }
        if(($grade = Tools::getValue('grade')) || $grade!='')
        {
            if(Validate::isInt($grade))
                $filter .= ' AND pc.grade ="'.(int)$grade.'"';
            $show_resset = true;
        }
        if(($validate1 = trim(Tools::getValue('validate'))) || $validate1!=='')
        {
            if(Validate::isBool($validate1))
                $filter .= ' AND pc.validate="'.(int)$validate1.'"';
            $show_resset=true;
        }
        if($date_add_min = Tools::getValue('date_add_min'))
        {
            if(Validate::isDate($date_add_min))
                $filter .= ' AND pc.date_add >= "'.pSQL($date_add_min).'"';
            $show_resset = true;
        }
        if($date_add_max = Tools::getValue('date_add_max'))
        {
            if(Validate::isDate($date_add_max))
                $filter .= ' AND pc.date_add <= "'.pSQL($date_add_max).'"';
            $show_resset = true;
        }
        if($validate && !Configuration::get('ETS_MP_SELLER_DISPLAY_REVIEWS_WAITING'))
            $filter .=' AND pc.validate=1';
        //Sort
        $sort = "";
        $sort_value = Tools::getValue('sort','id_comment');
        $sort_type=Tools::getValue('sort_type','desc');
        if($sort_value)
        {
            switch ($sort_value) {
                case 'id_comment':
                    $sort .='id_comment';
                    break;
                case 'name':
                    $sort .='pl.name';
                    break;
                case 'validate':
                    $sort .='pc.validate';
                    break;
                case 'grade':
                    $sort .='pc.grade';
                    break;
                case 'date_add':
                    $sort .='pc.date_add';
                    break;
            }
            if($sort && $sort_type && in_array($sort_type,array('asc','desc')))
                $sort .= ' '.trim($sort_type);  
        }
        //Paggination
        $page = (int)Tools::getValue('page');
        if($page<=0)
            $page = 1;
        $totalRecords = (int) $this->seller->getProductComments($filter,$having,0,0,'',true);
        $paggination = new Ets_mp_paggination_class();            
        $paggination->total = $totalRecords;
        $paggination->url =$this->context->link->getModuleLink($this->module->name,'ratings',array('list'=>true, 'page'=>'_page_')).$this->module->getFilterParams($fields_list,'mp_ratings');
        $paggination->limit =  (int)Tools::getValue('paginator_rating_select_limit',10);
        $paggination->name ='rating';
        $paggination->num_links =5;
        $totalPages = ceil($totalRecords / $paggination->limit);
        if($page > $totalPages)
            $page = $totalPages;
        $paggination->page = $page;
        $start = $paggination->limit * ($page - 1);
        if($start < 0)
            $start = 0;
        $productComments = $this->seller->getProductComments($filter, $having,$start,$paggination->limit,$sort,false);
        if($productComments)
        {
            foreach($productComments as &$productComment)
            {
                if(Tools::strlen($productComment['content'])>135)
                {
                    $productComment['content'] = Tools::substr($productComment['content'],0,135).'...';
                }
                $productComment['review'] = Module::getInstanceByName('ets_marketplace')->displayText($productComment['title'],'b').Module::getInstanceByName('ets_marketplace')->displayText('','br').$productComment['content'];
                $productComment['grade'] = $productComment['grade'].'/5';
                $productComment['child_view_url'] = $this->context->link->getProductLink($productComment['id_product']);
                $productComment['name'] =Module::getInstanceByName('ets_marketplace')->displayText($productComment['name'],'a','','',$this->context->link->getProductLink($productComment['id_product']));
                $productComment['action_edit'] = false;
                $productComment['action_delete'] = true;
                if($validate && !$productComment['validate'])
                    $productComment['action_approve'] = true;
            }
        }
        $paggination->text =  $this->module->l('Showing {start} to {end} of {total} ({pages} Pages)','ratings');
        $paggination->style_links = 'links';
        $paggination->style_results = 'results';
        $actions = array('view');
        if(Configuration::get('ETS_MP_SELLER_APPROVE_REVIEW'))
            $actions[] = 'approve_review';
        if(Configuration::get('ETS_MP_SELLER_DELETE_REVIEW'))
            $actions[] ='delete';
        $listData = array(
            'name' => 'mp_ratings',
            'actions' => $actions,
            'currentIndex' => $this->context->link->getModuleLink($this->module->name,'ratings',array('list'=>1)).($paggination->limit!=10 ?'&paginator_rating_select_limit='.$paggination->limit:''),
            'postIndex' => $this->context->link->getModuleLink($this->module->name,'ratings',array('list'=>1)),
            'identifier' => 'id_comment',
            'show_toolbar' => true,
            'show_action' => true,
            'title' => $this->module->l('Ratings','ratings'),
            'fields_list' => $fields_list,
            'field_values' => $productComments,
            'paggination' => $paggination->render(),
            'filter_params' => $this->module->getFilterParams($fields_list,'mp_ratings'),
            'show_reset' =>$show_resset,
            'totalRecords' => $totalRecords,
            'sort'=> $sort_value,
            'show_add_new'=>  false,
            'sort_type' => $sort_type,
        );           
        return $this->module->renderList($listData);
    }
 }