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
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2021 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

if (!defined('_PS_VERSION_'))
    exit;

class Ets_collection_class extends ObjectModel
{
    protected static $instance;
    public $id_shop;
    public $name;
    public $meta_title;
    public $meta_description;
    public $link_rewrite;
    public $description;
    public $image;
    public $thumb;
    public $active;
    public $position;
    public $views;
    public $date_add;
    public static $definition = array(
        'table' => 'ets_col_collection',
        'primary' => 'id_ets_col_collection',
        'multilang' => true,
        'fields' => array(
            'active' => array('type' => self::TYPE_INT),
            'position' => array('type' => self::TYPE_INT),
            'views' => array('type' => self::TYPE_INT),
            'date_add' => array('type'=>self::TYPE_DATE),
            'id_shop' => array('type' => self::TYPE_INT),
            'image' => array('type' => self::TYPE_STRING,'lang'=>true),
            'thumb' => array('type' => self::TYPE_STRING,'lang'=>true),
            'name' => array('type' => self::TYPE_STRING,'lang'=>true),
            'link_rewrite' => array('type' => self::TYPE_STRING,'lang'=>true),
            'meta_title' => array('type' => self::TYPE_STRING,'lang'=>true),
            'meta_description' => array('type' => self::TYPE_STRING,'lang'=>true),
            'description' => array('type' => self::TYPE_STRING,'lang'=>true),
        ),
    );
    public	function __construct($id_item = null, $id_lang = null, $id_shop = null)
	{
		parent::__construct($id_item, $id_lang, $id_shop);
        //Context::getContext() = Context::getContext();
    }
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Ets_collection_class();
        }
        return self::$instance;
    }
    public function add($auto_date=true,$null_values=false)
    {
        $max_posistion = Db::getInstance()->getValue('SELECT max(position) FROM `'._DB_PREFIX_.'ets_col_collection`');
        $this->position = $max_posistion+1;
        return parent::add($auto_date,$null_values);
    }
    public function delete()
    {
        $images = $this->image;
        $thumbs = $this->thumb;
        if(parent::delete())
        {
            if($images)
            {
                foreach($images as $image)
                {
                    if($image)
                        @unlink(_PS_IMG_DIR_.'col_collection/'.$image);
                }
            }
            if($thumbs)
            {
                foreach($thumbs as $thumb)
                {
                    if($thumb)
                        @unlink(_PS_IMG_DIR_.'col_collection/'.$thumb);
                }
            }
            Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_col_collection_display` WHERE id_ets_col_collection='.(int)$this->id);
            Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_col_collection_order` WHERE id_ets_col_collection='.(int)$this->id);
            Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_col_collection_view` WHERE id_ets_col_collection='.(int)$this->id);
            return $this->deleteAllProduct();
        }
    }
    public function _renderCollection()
    {
        $sort_type = Tools::strtolower(Tools::getValue('sort_type','asc'));
        if(!in_array($sort_type,array('asc','desc')))
            $sort_type = 'asc';
        $sort_post = Tools::strtolower(Tools::getValue('sort','position'));
        $fields_list = array(
            'id_ets_col_collection' => array(
                'title' => $this->l('ID'),
                'width' => 40,
                'type' => 'text',
                'strip_tag'=> false,
                'sort' => true,
                'filter' => true,
            ),
            'thumb' => array(
                'title' => $this->l('Thumbnail'),
                'width' => 40,
                'type' => 'text',
                'strip_tag'=> false,
            ),
            'name' => array(
                'title' => $this->l('Collection'),
                'width' => 40,
                'type' => 'text',
                'sort' => true,
                'filter' => true,
                'strip_tag' => false,
            ),
            'total_product' => array(
                'title' => $this->l('Product quantity'),
                'type' => 'int',
                'sort' => true,
                'filter' => true,             
            ),
            'total_order' => array(
                'title' => $this->l('Total order'),
                'type' => 'int',
                'sort' => true,
                'filter' => true,
                'strip_tag' => false,
            ),
            'total_amount' => array(
                'title' => $this->l('Total amount'),
                'type' => 'int',
                'sort' => true,
                'filter' => true,
                'class' => 'center'
            ),
            'views' => array(
                'title' => $this->l('Total views'),
                'type' => 'int',
                'sort' => true,
                'filter' => true,
            ),
            'date_add' => array(
                'title' => $this->l('Date added'),
                'type' => 'date',
                'sort' => true,
                'filter' => true,
            ),
            'hook_display' => array(
                'title' => $this->l('Display'),
                'type' => 'select',
                'sort' => false,
                'filter' => true,
                'strip_tag' => false,
                'filter_list' => array(
                    'list' => array(
                        array(
                            'id_option'=>'home_page',
                            'value' => $this->l('Home'),
                        ),
                        array(
                            'id_option'=>'product_page',
                            'value' => $this->l('Product detail page'),
                        ),
                        array(
                            'id_option'=>'right_column',
                            'value' => $this->l('Right column'),
                        ),
                        array(
                            'id_option'=>'left_column',
                            'value' => $this->l('Left column'),
                        ),
                        array(
                            'id_option' => 'collection_page',
                            'value' => $this->l('Collection page'),
                        ),
                        array(
                            'id_option'=>'custom_hook',
                            'value' => $this->l('Custom hook'),
                        ),
                    ),
                    'id_option' => 'id_option',
                    'value' => 'value',
                ),
            ),
            'active' => array(
                'title' => $this->l('Status'),
                'type' => 'active',
                'sort' => true,
                'filter' => true,
                'strip_tag'=> false,
                'filter_list' => array(
                    'list' => array(
                        array(
                            'id_option'=>1,
                            'value' => $this->l('On'),
                        ),
                        array(
                            'id_option'=>0,
                            'value' => $this->l('Off'),
                        ),
                    ),
                    'id_option' => 'id_option',
                    'value' => 'value',
                ),
            ),
            'position' => array(
                'title' => $this->l('Position'),
                'type' => 'int',
                'sort' => true,
                'update_position' => $sort_post=='position' && $sort_type=='asc' ? true :false,
            ),
            'view_statistic' => array(
                'title' => '',
                'type' => 'text',
                'sort' => false,
                'filter' => false,
                'strip_tag' => false,
            ),
        );
        //Filter
        $show_resset = false;
        $filter = "";
        $having = "";
        $controller = Tools::getValue('controller');
        if(Tools::isSubmit('ets_col_submit_col_collection'))
        {
            if(($active = Tools::getValue('active'))!=='' && Validate::isCleanHtml($active))
            {
                $filter .=' AND c.active= '.(int)$active;
                $show_resset = true;
            }
            if(($id = Tools::getValue('id_ets_col_collection')) && Validate::isCleanHtml($id))
            {
                $filter .=' AND c.id_ets_col_collection ='.(int)$id;
                $show_resset = true;
            }
            if(($name = Tools::getValue('name'))!=='' && Validate::isCleanHtml($name))
            {
                $filter .=' AND cl.name LIKE "%'.pSQL($name).'%"';
                $show_resset = true;
            }
            if(($total_product_min = Tools::getValue('total_product_min'))!=='' && Validate::isCleanHtml($total_product_min))
            {
                $filter .=' AND cp.total_product >="'.(int)$total_product_min.'"';
                $show_resset = true;
            }
            if(($total_product_max = Tools::getValue('total_product_max'))!=='' && Validate::isCleanHtml($total_product_max))
            {
                $filter .=' AND cp.total_product <="'.(int)$total_product_max.'"';
                $show_resset = true;
            }
            if(($total_amount_min = Tools::getValue('total_amount_min'))!=='' && Validate::isCleanHtml($total_amount_min))
            {
                $filter .=' AND colo.total_amount >="'.(float)$total_amount_min.'"';
                $show_resset = true;
            }
            if(($total_amount_max = Tools::getValue('total_amount_max'))!='' && Validate::isCleanHtml($total_amount_max))
            {
                $filter .=' AND colo.total_amount <="'.(float)$total_amount_max.'"';
                $show_resset = true;
            }
            if(($total_order_min = Tools::getValue('total_order_min')) && Validate::isCleanHtml($total_order_min))
            {
                $filter .=' AND colo.total_order >="'.(int)$total_order_min.'"';
                $show_resset = true;
            }
            if(($total_order_max = Tools::getValue('total_order_max'))!=='' && Validate::isCleanHtml($total_order_max))
            {
                $filter .=' AND colo.total_order <="'.(int)$total_order_max.'"';
                $show_resset = true;
            }
            if(($date_add_min = Tools::getValue('date_add_min'))!=='' && Validate::isCleanHtml($date_add_min))
            {
                $filter .=' AND c.date_add >="'.pSQL($date_add_min).' 00:00:00"';
                $show_resset = true;
            }
            if(($date_add_max = Tools::getValue('date_add_max'))!=='' && Validate::isCleanHtml($date_add_max))
            {
                $filter .=' AND c.date_add <="'.pSQL($date_add_max).' 23:59:59"';
                $show_resset = true;
            }
            if(($hook_display = Tools::getValue('hook_display'))!=='' && Validate::isCleanHtml($hook_display))
            {
                $filter .=' AND cd.hook_display LIKE "'.pSQL($hook_display).'"';
                $show_resset= true;
            }
        }
        //Sort
        $sort = "";
        
        if($sort_post)
        {
            switch ($sort_post) {
                case 'id_ets_col_collection':
                    $sort .='c.id_ets_col_collection';
                    break;
                case 'name':
                    $sort .='cl.name';
                    break;
                case 'total_product':
                    $sort .='cp.total_product';
                    break;
                case 'total_amount':
                    $sort .='colo.total_amount';
                    break;
                case 'total_order':
                    $sort .='colo.total_order';
                    break;
                case 'date_add':
                    $sort .='c.date_add';
                    break;
                case 'active':
                    $sort .='c.active';
                    break;
                case 'position':
                    $sort .='c.position';
                    break;
            }
            if($sort && $sort_type && in_array($sort_type,array('asc','desc')))
                $sort .= ' '.trim($sort_type);  
        }
        //Paggination
        $module = Module::getInstanceByName('ets_collections');
        $page = (int)Tools::getValue('page');
        if($page < 1)
            $page =1;
        $totalRecords = (int) Ets_collection_class::getCollections($filter,$having,0,0,'',true);
        $paggination = new Ets_col_paggination_class();            
        $paggination->total = $totalRecords;
        $paggination->url = Validate::isControllerName($controller) ? Context::getContext()->link->getAdminLink($controller).'&page=_page_':'';
        $paggination->limit =  20;
        $totalPages = ceil($totalRecords / $paggination->limit);
        if($page > $totalPages)
            $page = $totalPages;
        $paggination->page = $page;
        $start = $paggination->limit * ($page - 1);
        if($start < 0)
            $start = 0;
        $collections = Ets_collection_class::getCollections($filter,$having, $start,$paggination->limit,$sort,false);
        if($collections)
        {
            foreach($collections as &$collection)
            {
                $collection['total_amount'] = Tools::displayPrice($collection['total_amount']);
                if($collection['image'])
                    $collection['image'] = $module->displayText('','img',null,null,null,null,_PS_IMG_.'col_collection/'.$collection['image']); 
                if($collection['thumb'])
                    $collection['thumb'] = $module->displayText('','img',null,null,null,null,_PS_IMG_.'col_collection/'.$collection['thumb']); 
                $collection['name'] = $module->displayText($collection['name'],'a',null,null,$module->getCollectionLink(array('id_collection'=>$collection['id_ets_col_collection'])),true);
                $hook_displays = Db::getInstance()->executeS('SELECT hook_display FROM `'._DB_PREFIX_.'ets_col_collection_display` WHERE id_ets_col_collection='.(int)$collection['id_ets_col_collection'].' AND active=1');
                $collection['hook_display'] ='';
                if($hook_displays)
                {
                    foreach($hook_displays as $display)
                    {
                        if($display['hook_display']=='home_page')
                            $collection['hook_display'] .= $module->displayText($this->l('Home'),'p');
                        elseif($display['hook_display']=='product_page')
                            $collection['hook_display'] .= $module->displayText($this->l('Product detail page'),'p');
                        elseif($display['hook_display']=='right_column')
                            $collection['hook_display'] .= $module->displayText($this->l('Right column'),'p');
                        elseif($display['hook_display']=='left_column')
                            $collection['hook_display'] .= $module->displayText($this->l('Left column'),'p');
                        elseif($display['hook_display']=='collection_page')
                            $collection['hook_display'] .= $module->displayText($this->l('Collection page'),'p');
                        elseif($display['hook_display']=='custom_hook')
                            $collection['hook_display'] .= $module->displayText($this->l('Custom hook'),'p');
                            
                    }
                }
                if($collection['total_order']==0)
                    $collection['total_order']='--';
                if($collection['views']==0)
                    $collection['views']='--';
                $collection['view_statistic'] = $module->displayText($module->displayText('','i','icon icon-line-chart'),'button','tbn tbn-default tbn-view-statistic',null,Context::getContext()->link->getAdminLink('AdminProductCollections').'&viewStatistic=1&id_collection='.(int)$collection['id_ets_col_collection']);
            }
        }
        $paggination->text =  $this->l('Showing {start} to {end} of {total} ({pages} Pages)');
        $listData = array(
            'name' => 'col_collection',
            'icon' => 'fa fa-bank',
            'actions' => array('view','duplicate','delete'),
            'currentIndex' => Validate::isControllerName($controller) ?  Context::getContext()->link->getAdminLink($controller):'',
            'identifier' => 'id_ets_col_collection',
            'show_toolbar' => true,
            'show_action' => true,
            'title' => $this->l('Collections'),
            'fields_list' => $fields_list,
            'field_values' => $collections,
            'paggination' => $paggination->render(),
            'filter_params' => $module->getFilterParams($fields_list,'col_collection'),
            'show_reset' =>$show_resset,
            'totalRecords' => $totalRecords,
            'sort'=> $sort_post ? $sort_post : 'position',
            'show_add_new'=> true,
            'link_new' => Context::getContext()->link->getAdminLink('AdminProductCollections').'&addCollecion=1', 
            'setting_link' => Context::getContext()->link->getAdminLink('AdminModules').'&configure='.$module->name,
            'bulk_actions' => true,
            'sort_type' => $sort_type,
        ); 
        return $module->renderList($listData);
    }
    public function getViewedProducts($filter='',$having="",$start=0,$limit=12,$order_by='c.position asc',$total=false)
    {
        if($total)
            $sql = 'SELECT COUNT(DISTINCT cp.id_product)';
        else
            $sql ='SELECT cp.id_product,pl.name,colo.total_order,colo.total_amount, colo.total_quantity, cp.views';
        $sql .=' FROM `'._DB_PREFIX_.'ets_col_collection_product` cp
        LEFT JOIN `'._DB_PREFIX_.'product_lang` pl on (cp.id_product=pl.id_product AND pl.id_lang="'.(int)Context::getContext()->language->id.'" AND pl.id_shop="'.(int)Context::getContext()->shop->id.'")
        LEFT JOIN (
            SELECT co.id_ets_col_collection,co.id_product,sum(co.total_price_tax_incl) as total_amount,count(DISTINCT co.id_order) as total_order,sum(quantity) as total_quantity 
            FROM `'._DB_PREFIX_.'ets_col_collection_order` co
            INNER JOIN `'._DB_PREFIX_.'orders` o ON (co.id_order=o.id_order)
            INNER JOIN `'._DB_PREFIX_.'order_state` os ON (os.id_order_state = o.current_state AND os.logable=1)
            GROUP BY co.id_ets_col_collection,co.id_product
        ) colo ON (cp.id_product= colo.id_product AND cp.id_ets_col_collection = colo.id_ets_col_collection)
        WHERE cp.id_ets_col_collection='.(int)$this->id.' AND cp.views >0'.($filter ? $filter:'');
        if(!$total)
        {
            $sql .=' GROUP BY cp.id_product';
            if($having)
                $sql .= ' HAVING 1 '.$having;
            $sql .= ($order_by ? ' ORDER By '.$order_by :'');
            if($limit!==false)
                $sql .= ' LIMIT '.(int)$start.','.(int)$limit;
        }
        if($total)
            return Db::getInstance()->getValue($sql);
        else
        {
            return Db::getInstance()->executeS($sql);
        }
    }
    public function getCollections($filter='',$having="",$start=0,$limit=12,$order_by='c.position asc',$total=false)
    {
        if($total)
            $sql = 'SELECT COUNT(DISTINCT c.id_ets_col_collection)';
        else
            $sql ='SELECT c.id_ets_col_collection,c.date_add,c.active,c.views,cd.hook_display,c.position,cl.name,cl.image,cl.thumb,cl.description,cp.total_product,colo.total_order, colo.total_amount';
        $sql .= ' FROM `'._DB_PREFIX_.'ets_col_collection` c
        LEFT JOIN 
        (
            SELECT co.id_ets_col_collection,sum(co.total_price_tax_incl) as total_amount,count(DISTINCT co.id_order) as total_order 
            FROM `'._DB_PREFIX_.'ets_col_collection_order` co
            INNER JOIN `'._DB_PREFIX_.'orders` o ON (co.id_order=o.id_order)
            INNER JOIN `'._DB_PREFIX_.'order_state` os ON (os.id_order_state = o.current_state AND os.logable=1)
            GROUP BY co.id_ets_col_collection
        )
        colo ON (colo.id_ets_col_collection = c.id_ets_col_collection)
        LEFT JOIN `'._DB_PREFIX_.'ets_col_collection_display` cd ON (cd.id_ets_col_collection=c.id_ets_col_collection AND cd.active=1)
        LEFT JOIN `'._DB_PREFIX_.'ets_col_collection_lang` cl ON (c.id_ets_col_collection = cl.id_ets_col_collection AND cl.id_lang = "'.(int)Context::getContext()->language->id.'")
        LEFT JOIN (
            SELECT id_ets_col_collection,COUNT(DISTINCT id_product) as total_product
            FROM `'._DB_PREFIX_.'ets_col_collection_product` 
            GROUP BY id_ets_col_collection
        ) cp ON (cp.id_ets_col_collection = c.id_ets_col_collection)
        WHERE c.id_shop="'.(int)Context::getContext()->shop->id.'"'.($filter ? $filter:'');
        if(!$total)
        {
            $sql .=' GROUP BY c.id_ets_col_collection ';
            if($having)
                $sql .= ' HAVING 1 '.$having;
            $sql .= ($order_by ? ' ORDER By '.$order_by :'');
            if($limit!==false)
                $sql .= ' LIMIT '.(int)$start.','.(int)$limit;
        }
        if($total)
            return Db::getInstance()->getValue($sql);
        else
        {
            return Db::getInstance()->executeS($sql);
        }
    }
    public static function getCollectionsByHook($hook,$id_collection=0,$has_product=false)
    {
        $context = Context::getContext();
        $sql = 'SELECT c.*,cl.name,cd.* FROM `'._DB_PREFIX_.'ets_col_collection` c
        '.($has_product ? ' INNER JOIN `'._DB_PREFIX_.'ets_col_collection_product` cp ON (c.id_ets_col_collection = cp.id_ets_col_collection)':'').'
        LEFT JOIN `'._DB_PREFIX_.'ets_col_collection_lang` cl ON (c.id_ets_col_collection = cl.id_ets_col_collection AND cl.id_lang="'.(int)$context->language->id.'")
        LEFT JOIN `'._DB_PREFIX_.'ets_col_collection_display` cd ON (c.id_ets_col_collection=cd.id_ets_col_collection AND cd.active=1)
        WHERE c.id_shop="'.(int)$context->shop->id.'" AND c.active=1 AND cd.hook_display="'.pSQL($hook).'"'.($id_collection ? ' AND c.id_ets_col_collection='.(int)$id_collection:'').' GROUP BY c.id_ets_col_collection';
        return Db::getInstance()->executeS($sql);
    }
    public function _renderFormCollection()
    {
        $module = Module::getInstanceByName('ets_collections');
        $id_ets_col_collection = (int)Tools::getValue('id_ets_col_collection');
        $fields_form = array(
			'form' => array(
				'legend' => array(
					'title' =>$id_ets_col_collection ? $this->l('Edit collection'): $this->l('Add collection'),
                    'icon' =>'icon-collection',				
				),
				'input' => array(
                    array(
                        'type'=>'hidden',
                        'name' => 'id_collection',
                    ),					
					array(
						'type' => 'text',
						'label' => $this->l('Collection name'),
						'name' => 'name', 
                        'lang' => true,	
                        'required' => true,
                        'form_group_class' => 'collection_name'			                     
					),
                    array(
						'type' => 'text',
						'label' => $this->l('Meta title'),
						'name' => 'meta_title', 
                        'lang' => true,	
                        'form_group_class' => 'collection_page_display'			                     
					), 
                    array(
						'type' => 'textarea',
						'label' => $this->l('Meta description'),
						'name' => 'meta_description', 
                        'lang' => true,	
                        'rows'=>4,
                        'form_group_class' => 'collection_page_display'			                     
					), 
                    array(
						'type' => 'text',
						'label' => $this->l('Friendly URL'),
						'name' => 'link_rewrite', 
                        'lang' => true,	
                        'form_group_class' => 'collection_page_display collection_link_rewrite',
                        'desc' => $id_ets_col_collection ? sprintf($this->l('Url: %s'),$id_ets_col_collection ? $module->displayText($module->getCollectionLink(array('id_collection'=>$id_ets_col_collection)),'a','link_collection',null,$module->getCollectionLink(array('id_collection'=>$id_ets_col_collection)),true):''):''			                     
					),  
                    array(
						'type' => 'textarea',
						'label' => $this->l('Collection description'),
						'name' => 'description',
                        'lang'=>true, 
                        'form_group_class' => 'collection_description'					                    
					),         
                    array(
						'type' => 'file_lang',
						'label' => $this->l('Banner'),
						'name' => 'image',
                        'imageType' => 'image',
                        'desc_file' => sprintf($this->l('Accepted formats: jpg, png, gif, webp. Limit %sMb. Recommended size: 850x230px'),Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')),
                        'form_group_class' => 'collection_image'
                    ),
                    array(
						'type' => 'file_lang',
						'label' => $this->l('Thumbnail'),
						'name' => 'thumb',
                        'imageType' => 'thumb',
                        'desc_file' => sprintf($this->l('Accepted formats: jpg, png, gif, webp. Limit %sMb. Recommended size: 250x250 px'),Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')),
                        'form_group_class' => 'collection_thumb'
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Status'),
                        'name'=> 'active',
                        'form_group_class' => 'collection_enable',
                        'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('On')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Off')
							)
						),
                    ),
                ),
                'submit' => array(
					'title' => $this->l('Save'),
				),
            ),
		);
        $helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = 'ets_col_collection';
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $module;
		$helper->identifier = 'id_ets_col_collection';
		$helper->submit_action = 'saveCollection';
		$helper->currentIndex = Context::getContext()->link->getAdminLink('AdminProductCollections', false).'&addCollecion=1';
		$helper->token = Tools::getAdminTokenLite('AdminProductCollections');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => Context::getContext()->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
            'PS_ALLOW_ACCENTED_CHARS_URL', (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL'),
			'fields_value' => $this->getCollectionFieldsValues(),
			'languages' => Context::getContext()->controller->getLanguages(),
			'id_language' => Context::getContext()->language->id,
			'image_baseurl' => _PS_IMG_.'col_collection/',
            'img_preview_desktop' => _MODULE_DIR_.$module->name.'/views/img/desktop.png',
            'img_preview_mobile' => _MODULE_DIR_.$module->name.'/views/img/mobile.png',
            'image_del_link' => Context::getContext()->link->getAdminLink('AdminProductCollections').'&editcol_collection=1&id_ets_col_collection='.$id_ets_col_collection.'&deleteimage=1',
            'thumb_del_link' => Context::getContext()->link->getAdminLink('AdminProductCollections').'&editcol_collection=1&id_ets_col_collection='.$id_ets_col_collection.'&deletethumb=1',
            'link' => Context::getContext()->link,
		);            
        return $helper->generateForm(array($fields_form)).Context::getContext()->smarty->fetch(_PS_MODULE_DIR_.'ets_collections/views/templates/hook/popup.tpl');
    }
    public function getCollectionFieldsValues()
    {
        if($id_collection = (int)Tools::getValue('id_ets_col_collection'))
            $collection = new Ets_collection_class($id_collection);
        else
            $collection = new Ets_collection_class();
        $fields = array();
        $fields['id_collection'] = $collection->id;
        $fields['active'] = (int)Tools::getValue('active',$collection->id ? $collection->active:1);
        $languages = Language::getLanguages(false);
        foreach($languages as $language)
        {
            $fields['name'][$language['id_lang']] = Tools::getValue('name_'.$language['id_lang'],$collection->name[$language['id_lang']]);
            $fields['meta_title'][$language['id_lang']] = Tools::getValue('meta_title_'.$language['id_lang'],$collection->meta_title[$language['id_lang']]);
            $fields['meta_description'][$language['id_lang']] = Tools::getValue('meta_description_'.$language['id_lang'],$collection->meta_description[$language['id_lang']]);
            $fields['link_rewrite'][$language['id_lang']] = Tools::getValue('link_rewrite_'.$language['id_lang'],$collection->link_rewrite[$language['id_lang']]);
            $fields['description'][$language['id_lang']] = Tools::getValue('description_'.$language['id_lang'], $collection->description[$language['id_lang']]);
            $fields['image'][$language['id_lang']] = $collection->image[$language['id_lang']];
            $fields['thumb'][$language['id_lang']] = $collection->thumb[$language['id_lang']];
        }
        $fields['list_products'] = $collection->displayListProducts();
        $fields['hook_display'] = $collection->displayFormDisplay();
        return $fields;
    }
    public function displayListProducts()
    {
        Context::getContext()->smarty->assign(
            array(
                'total_products' => Ets_collection_class::getListProducts(' AND colp.id_ets_col_collection="'.(int)$this->id.'"',0,10,'colp.position ASC',true),
                'products' => Ets_collection_class::getListProducts(' AND colp.id_ets_col_collection="'.(int)$this->id.'"',0,false,'colp.position ASC'),
            )
        );
        return Context::getContext()->smarty->fetch(_PS_MODULE_DIR_.'ets_collections/views/templates/hook/list_collection_products.tpl');
    }
    public function getTotalProduct()
    {
        $sql ='SELECT COUNT(DISTINCT id_product) as total_product
            FROM `'._DB_PREFIX_.'ets_col_collection_product` WHERE id_ets_col_collection='.(int)$this->id;
        return Db::getInstance()->getValue($sql);
    }
    public static function getListProducts($filter='',$page = 0, $per_page = 12, $order_by = 'p.id_product asc',$total=false,$full=false,$id_collection=0)
    {
        $page = (int)$page;
        if ($page <= 0)
            $page = 1;
        if($per_page!==false)
        {
            $per_page = (int)$per_page;
            if ($per_page <= 0)
                $per_page = 12;
        }
        $nb_days_new_product = Configuration::get('PS_NB_DAYS_NEW_PRODUCT');
        $id_lang = (int)Context::getContext()->language->id;
        if (!Validate::isUnsignedInt($nb_days_new_product)) {
            $nb_days_new_product = 20;
        }
        $prev_version = version_compare(_PS_VERSION_, '1.6.1.0', '<');
        if(!$total)
        {
            if($full)
            {
                $sql ='SELECT DISTINCT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) AS stock_quantity' . ($prev_version? ' ,IFNULL(pa.id_product_attribute, 0)':' ,MAX(product_attribute_shop.id_product_attribute)') . ' id_product_attribute, pl.`description`, pl.`description_short`, pl.`available_now`,
    				pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, i.`id_image`,
    				il.`legend` as legend, m.`name` AS manufacturer_name,cl.name as default_category,
    				DATEDIFF(product_shop.`date_add`, DATE_SUB("' . date('Y-m-d') . ' 00:00:00",
    				INTERVAL ' . (int)$nb_days_new_product . ' DAY)) > 0 AS new, product_shop.price AS orderprice';
            }
            else
                $sql = 'SELECT DISTINCT p.id_product,pl.name,p.price,p.reference,i.`id_image`,pl.link_rewrite';
            
        }     
        else
            $sql ='SELECT COUNT(DISTINCT p.id_product) ';
        $sql .= ' FROM `'._DB_PREFIX_.'product` p
                '.Shop::addSqlAssociation('product', 'p').
                (!$prev_version?
                    'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (pa.id_product = p.id_product)'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.default_on=1').'':
                    '
                        LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (pa.id_product = p.id_product)
                        LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop ON (pa.`id_product_attribute` = product_attribute_shop.`id_product_attribute` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop='.(int)Context::getContext()->shop->id.')
                    '
                )
                .Product::sqlStock('p', 0, false, Context::getContext()->shop).'
                LEFT JOIN `'._DB_PREFIX_.'ets_col_collection_product` colp ON (colp.id_product=p.id_product '.($id_collection ? ' AND colp.id_ets_col_collection='.(int)$id_collection:'').')
                LEFT JOIN `'._DB_PREFIX_.'product_sale` sale ON (sale.id_product = p.id_product)
                LEFT JOIN `'._DB_PREFIX_.'category` c ON (c.id_category=p.id_category_default)
                LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.id_product=p.id_product)
                LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.id_category = cl.id_category AND cl.id_lang="'.(int)$id_lang.'")
                LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = ' . (int)$id_lang . Shop::addSqlRestrictionOnLang('pl') . ')'.
                ' LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.id_product=p.id_product AND i.cover=1)
                LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')	
                LEFT JOIN `' . _DB_PREFIX_ . 'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer`
                WHERE product_shop.active=1 AND product_shop.`id_shop` = ' . (int)Context::getContext()->shop->id; 
        if($total)
        {
            $sql .= $filter ? $filter :'';
            return Db::getInstance()->getValue($sql);
        }
        {
            $sql .= $filter ? $filter :'';
            $sql .= ' GROUP BY p.id_product'.($order_by ? ' ORDER BY ' . pSQL($order_by): '');
            if($per_page!==false)
               $sql .=' LIMIT ' . (int)($page-1)*$per_page . ',' . (int)$per_page;
        }
        $products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql, true, true);
        if (!$products) {
            return array();
        }
        if (trim($order_by) == 'product_shop.price asc') {
            Tools::orderbyPrice($products, 'asc');
        } elseif (trim($order_by) == 'product_shop.price desc') {
            Tools::orderbyPrice($products, 'desc');
        }
        if(version_compare(_PS_VERSION_, '1.7', '>='))
            $type_image= ImageType::getFormattedName('small');
        else
            $type_image= ImageType::getFormatedName('small');
        if($full)
        {
            $products = Product::getProductsProperties($id_lang, $products);        
            if(version_compare(_PS_VERSION_, '1.7', '>=')) {
                $products = Ets_collections::productsForTemplate($products);
            }
        }
        if($products)
        {
            foreach ($products as &$item) {
                if(!$item['id_image'])
                    $item['id_image'] = Db::getInstance()->getValue('SELECT id_image FROM `'._DB_PREFIX_.'image` WHERE id_product='.(int)$item['id_product']);
                if($item['id_image'])
                    $item['image'] = Context::getContext()->link->getImageLink($item['link_rewrite'], $item['id_image'], $type_image);
                else
                    $item['image'] = Context::getContext()->link->getMediaLink(_PS_IMG_.'p/'.Context::getContext()->language->iso_code.'.jpg');
                $item['price'] = Tools::displayPrice($item['price']);
                $item['link'] =  Context::getContext()->link->getProductLink($item['id_product']);             
            }
        }
        return $products;
    }
    public function addProduct($products)
    {
        if($products)
        {
            foreach($products as $index=>$id_product)
            {
                if(!Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'ets_col_collection_product` WHERE id_product="'.(int)$id_product.'" AND id_ets_col_collection="'.(int)$this->id.'"'))
                {
                    Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'ets_col_collection_product` (id_ets_col_collection,id_product,position) VALUES("'.(int)$this->id.'","'.(int)$id_product.'","'.(int)$index.'")');
                }
                else
                {
                    Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'ets_col_collection_product` SET position="'.(int)$index.'" WHERE id_product="'.(int)$id_product.'" AND id_ets_col_collection="'.(int)$this->id.'"');
                }
            }
            Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_col_collection_view` WHERE id_ets_col_collection='.(int)$this->id.' AND id_product NOT IN ('.implode(',',array_map('intval',$products)).') AND id_product!=0');
            Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_col_collection_product` WHERE id_ets_col_collection='.(int)$this->id.' AND id_product NOT IN ('.implode(',',array_map('intval',$products)).')');
        }
        else 
            $this->deleteAllProduct();
        if(Tools::isSubmit('saveEditCollection'))
            return true;
        else
            die(
                Tools::jsonEncode(
                    array(
                        'success' => $this->l('Updated successfully'),
                    )
                )
            );
    }
    public function addProductView($id_product=0)
    {
        $ip = Tools::getRemoteAddr();
        $viewed = false;
        if(!$id_product || Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'ets_col_collection_product` WHERE id_ets_col_collection='.(int)$this->id.' AND id_product='.(int)$id_product))
        {
            if(!Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'ets_col_collection_view` WHERE id_product="'.(int)$id_product.'" AND id_ets_col_collection="'.(int)$this->id.'" AND ip="'.pSQL($ip).'"'))
            {
                Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'ets_col_collection_view` (id_ets_col_collection,id_product,ip,date_add) VALUES("'.(int)$this->id.'","'.(int)$id_product.'","'.pSQL($ip).'","'.pSQL(date('Y-m-d H:i:s')).'")');
                $viewed = true;
            }elseif(!Ets_collection_class::checkProductViewd($id_product,$this->id))
            {
                Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'ets_col_collection_view` SET date_add="'.pSQL(date('Y-m-d H:i:s')).'" WHERE id_product="'.(int)$id_product.'" AND id_ets_col_collection="'.(int)$this->id.'" AND ip="'.pSQL($ip).'"');
                $viewed = true;
            }
            if($viewed)
            {
                if($id_product)
                    Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'ets_col_collection_product` SET views =views+1 WHERE id_ets_col_collection='.(int)$this->id.' AND id_product='.(int)$id_product);
                else
                {
                    $this->views++;
                    $this->update();
                }
                
            }
        }
    }
    public function checkProductViewd($id_product,$id_collection=0)
    {
        $ip = Tools::getRemoteAddr();
        return Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'ets_col_collection_view` WHERE id_product="'.(int)$id_product.'"'.($id_collection ? ' AND id_ets_col_collection="'.(int)$id_collection.'"':'').' AND ip="'.pSQL($ip).'" AND date_add > "'.pSQL(date('Y-m-d H:i:s', strtotime('-1 HOUR'))).'"');
    }
    public static function addProductOrder($product,$id_order)
    {
        $ip = Tools::getRemoteAddr();
        $collections = Db::getInstance()->executeS('SELECT id_ets_col_collection FROM `'._DB_PREFIX_.'ets_col_collection_view` WHERE id_product="'.(int)$product['product_id'].'" AND ip="'.pSQL($ip).'" AND date_add > "'.pSQL(date('Y-m-d H:i:s', strtotime('-1 HOUR'))).'"');
        if($collections)
        {
            foreach($collections as $collection)
            {
                Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'ets_col_collection_order` (id_ets_col_collection,id_order,id_product,id_product_attribute,quantity,total_price,total_price_tax_incl,date_add) VALUES("'.(int)$collection['id_ets_col_collection'].'","'.(int)$id_order.'","'.(int)$product['product_id'].'","'.(int)$product['product_attribute_id'].'","'.(int)$product['product_quantity'].'","'.(float)Tools::convertPrice($product['total_price_tax_excl'],null,false).'","'.(float)Tools::convertPrice($product['total_price_tax_incl'],null,false).'","'.pSQL(date('Y-m-d H:i:s')).'")');
            }
        }
    }
    public function deleteAllProduct()
    {
        Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_col_collection_product` WHERE id_ets_col_collection='.(int)$this->id);
        Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'ets_col_collection_view` WHERE id_ets_col_collection='.(int)$this->id.' AND id_product!=0');
        return true;
    }
    public static function duplicateCollection($id_collection)
    {
        $collection = new Ets_collection_class($id_collection);
        $module = Module::getInstanceByName('ets_collections');
        if(!Validate::isLoadedObject($collection))
            $module->_errors[] = $module->l('Collection is not valid','ets_collection_class');
        else
        {
            $products = Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'ets_col_collection_product` WHERE id_ets_col_collection='.(int)$id_collection);
            $hook_displays = Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'ets_col_collection_display` WHERE id_ets_col_collection='.(int)$id_collection);
            unset($collection->id);
            $collection->views = 0;
            foreach($collection->name as &$name)
                $name .=' - '.$module->l('Copy','ets_collection_class');
            if($collection->image)
            {
                foreach($collection->image as &$image)
                {
                    if($image)
                    {
                        $image_old = $image;
                        $type = Tools::strtolower(Tools::substr(strrchr($image, '.'), 1));
                        $image = Tools::strtolower(Tools::passwdGen(20,'NO_NUMERIC')).'.'.$type;
                        Tools::copy(_PS_IMG_DIR_.'col_collection/'.$image_old,_PS_IMG_DIR_.'col_collection/'.$image);
                    }
                }
            }
            if($collection->thumb)
            {
                foreach($collection->thumb as &$thumb)
                {
                    if($thumb)
                    {
                        $thumb_old = $thumb;
                        $type = Tools::strtolower(Tools::substr(strrchr($thumb, '.'), 1));
                        $thumb = Tools::strtolower(Tools::passwdGen(20,'NO_NUMERIC')).'.'.$type;
                        Tools::copy(_PS_IMG_DIR_.'col_collection/'.$thumb_old,_PS_IMG_DIR_.'col_collection/'.$thumb);
                    }
                }
            }
            if($collection->add())
            {
                if($products)
                {
                    foreach($products as $product)
                    {
                        if(!Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'ets_col_collection_product` WHERE id_product="'.(int)$product['id_product'].'" AND id_ets_col_collection="'.(int)$collection->id.'"'))
                        {
                            Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'ets_col_collection_product` (id_ets_col_collection,id_product,position) VALUES("'.(int)$collection->id.'","'.(int)$product['id_product'].'","'.(int)$product['position'].'")');
                        }
                    }
                }
                if($hook_displays)
                {
                    foreach($hook_displays as $hook_display)
                    {
                        if(!Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'ets_col_collection_display` WHERE id_ets_col_collection="'.(int)$collection->id.'" AND hook_display="'.pSQL($hook_display['hook_display']).'"'))
                        {
                            Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'ets_col_collection_display` (id_ets_col_collection,hook_display,list_layout,per_row_desktop,per_row_mobile,per_row_tablet,active) VALUES("'.(int)$collection->id.'","'.pSQL($hook_display['hook_display']).'","'.pSQL($hook_display['list_layout']).'","'.(int)$hook_display['per_row_desktop'].'","'.(int)$hook_display['per_row_mobile'].'","'.(int)$hook_display['per_row_tablet'].'","'.(int)$hook_display['active'].'")');
                        }
                    }
                }
                return true;
            }
            else
                $module->_errors[] = $module->l('An error occurred while duplicating the collection','ets_collection_class');
        }
    }
    public function _updateCollectionOrdering($collections)
    {
        $page = (int)Tools::getValue('page',1);
        if($collections)
        {
            foreach($collections as $key=> $id_collection)
            {
                $position = ($page-1)*20 +$key+1;
                Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'ets_col_collection` SET position ="'.(int)$position.'" WHERE id_ets_col_collection='.(int)$id_collection);
            }
            die(
                Tools::jsonEncode(
                    array(
                        'success' => $this->l('Updated successfully'),
                        'page'=>$page
                    )
                )
            );
        }
    }
    public function displayFormDisplay()
    {
        $collection_pages = array(
            'home_page' => array(
                'title' => $this->l('Home'),
                'displays' => $this->id ?  Ets_collection_class::getDisplays($this->id,'home_page'):array(),
            ),
            'product_page' => array(
                'title' => $this->l('Product detail page'),
                'displays' => $this->id ?  Ets_collection_class::getDisplays($this->id,'product_page'):array(),
            ),
            'right_column' => array(
                'title' => $this->l('Right column'),
                'displays' => $this->id ?  Ets_collection_class::getDisplays($this->id,'right_column'):array(),
            ),
            'left_column' => array(
                'title' => $this->l('Left column'),
                'displays' => $this->id ?  Ets_collection_class::getDisplays($this->id,'left_column'):array(),
            ),
            'collection_page' => array(
                'title' => $this->l('Collection page'),
                'displays' => $this->id ?  Ets_collection_class::getDisplays($this->id,'collection_page'):array(),
            ),
            'custom_hook' => array(
                'title' => $this->l('Custom hook'),
                'displays' => $this->id ?  Ets_collection_class::getDisplays($this->id,'custom_hook'):array(),
            ),
        );
        Context::getContext()->smarty->assign(
            array(
                'collection_pages' => $collection_pages,
                'id_collection' => $this->id,
            )
        );
        return Context::getContext()->smarty->fetch(_PS_MODULE_DIR_.'ets_collections/views/templates/hook/tab_display.tpl');
    }
    public static function getDisplays($id_collection,$hook_display)
    {
        return Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'ets_col_collection_display` WHERE id_ets_col_collection='.(int)$id_collection.' AND hook_display ="'.pSQL($hook_display).'"');
    }
    public function addDisplayPages()
    {
        $hook_displays = Tools::getValue('hook_displays');
        $list_layouts = Tools::getValue('list_layouts');
        $per_row_desktops = Tools::getValue('per_row_desktops');
        $per_row_tablets = Tools::getValue('per_row_tablets');
        $per_row_mobiles = Tools::getValue('per_row_mobiles');
        $sort_order = Tools::getValue('sort_order');
        if(!$hook_displays)
            Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'ets_col_collection_display` set active=0 WHERE id_ets_col_collection='.(int)$this->id);
        elseif($sort_order && Ets_collections::validateArray($sort_order) && $hook_displays && Ets_collections::validateArray($hook_displays) && $list_layouts && Ets_collections::validateArray($list_layouts) && $per_row_desktops && Ets_collections::validateArray($per_row_desktops) && $per_row_mobiles && Ets_collections::validateArray($per_row_mobiles) && $per_row_tablets && Ets_collections::validateArray($per_row_tablets))
        {
            foreach(array_keys($hook_displays) as  $hook_display)
            {
                if(isset($list_layouts[$hook_display]) && isset($per_row_desktops[$hook_display]) && isset($per_row_mobiles[$hook_display]) && isset($per_row_tablets[$hook_display]))
                {
                    if(Ets_collection_class::getDisplays($this->id,$hook_display))
                    {
                        Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'ets_col_collection_display` set active=1,list_layout="'.pSQL($list_layouts[$hook_display]).'",per_row_desktop="'.(int)$per_row_desktops[$hook_display].'",per_row_mobile = "'.(int)$per_row_mobiles[$hook_display].'",per_row_tablet="'.(int)$per_row_tablets[$hook_display].'",sort_order="'.(isset($sort_order[$hook_display]) ? pSQL($sort_order[$hook_display]):'default').'" WHERE id_ets_col_collection='.(int)$this->id.' AND hook_display="'.pSQL($hook_display).'"');
                    }
                    else
                    {
                        Db::getInstance()->execute('INSERT INTO `'._DB_PREFIX_.'ets_col_collection_display`(id_ets_col_collection,active,hook_display,list_layout,per_row_desktop,per_row_mobile,per_row_tablet,sort_order) VALUES("'.(int)$this->id.'",1,"'.pSQL($hook_display).'","'.pSQL($list_layouts[$hook_display]).'","'.(int)$per_row_desktops[$hook_display].'","'.(int)$per_row_mobiles[$hook_display].'","'.(int)$per_row_tablets[$hook_display].'","'.(isset($sort_order[$hook_display]) ? pSQL($sort_order[$hook_display]):'default').'")');
                    }
                }
            }
            Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'ets_col_collection_display` set active=0 WHERE id_ets_col_collection='.(int)$this->id.' AND hook_display NOT IN ("'.implode('","',array_map('pSQL',array_keys($hook_displays))).'")');
        }
    }
    public function _renderViewStatistic()
    {
        $fields_list = array(
            'id_product' => array(
                'title' => $this->l('Product ID'),
                'width' => 40,
                'type' => 'text',
                'strip_tag'=> false,
            ),
            'image' => array(
                'title' => $this->l('Image'),
                'width' => 40,
                'type' => 'text',
                'strip_tag'=> false,
            ),
            'name' => array(
                'title' => $this->l('Product name'),
                'width' => 40,
                'type' => 'text',
                'strip_tag'=> false,
            ),
            'total_order' => array(
                'title' => $this->l('Total order'),
                'type' => 'int',
                'strip_tag' => false,
            ),
            'total_quantity' => array(
                'title' => $this->l('Qty'),
                'type' => 'int',
            ),
            'total_amount' => array(
                'title' => $this->l('Total amount'),
                'type' => 'int',
            ),
            'views' => array(
                'title' => $this->l('Total views'),
                'type' => 'int',
            ),
        );
        //Paggination
        $module = Module::getInstanceByName('ets_collections');
        $totalRecords = (int) $this->getViewedProducts('','',0,0,'',true);
        $products = $this->getViewedProducts('','', 0,false,'',false);
        if($products)
        {
            foreach($products as &$product)
            {
                $product['total_amount'] = Tools::displayPrice($product['total_amount']);
                if(!$product['total_order'])
                    $product['total_order'] ='--';
                if(!$product['total_quantity'])
                    $product['total_quantity'] ='--';
                if(!$product['views'])
                    $product['views']='--';
                $product['image'] = ($image = Ets_col_defines::getImageByIdProduct($product['id_product'],'small')) ? $module->displayText('','img',null,null,null,null,$image):'--';
            }
        }
        $listData = array(
            'name' => 'col_statistic',
            'icon' => 'fa fa-bank',
            'actions' => array(),
            'currentIndex' =>Context::getContext()->link->getAdminLink('AdminProductCollections'),
            'identifier' => 'id_product',
            'show_toolbar' => false,
            'show_action' => false,
            'title' => sprintf($this->l('Collections statistic - %s'),$this->name[Context::getContext()->language->id]),
            'fields_list' => $fields_list,
            'field_values' => $products,
            'paggination' => '',
            'filter_params' => '',
            'show_reset' =>false,
            'totalRecords' => $totalRecords,
            'sort'=> '',
            'show_add_new'=> false,
            'link_new' => false, 
            'bulk_actions' => false,
            'sort_type' => '',
        ); 
        return $module->renderList($listData);
    }
    public function l($string)
    {
        return Translate::getModuleTranslation('ets_collections', $string, pathinfo(__FILE__, PATHINFO_FILENAME));
    }
}