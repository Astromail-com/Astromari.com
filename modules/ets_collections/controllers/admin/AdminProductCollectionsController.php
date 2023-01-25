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
class AdminProductCollectionsController extends ModuleAdminController
{
    public function __construct()
    {
       parent::__construct();
       $this->context= Context::getContext();
       $this->bootstrap = true;
       $action = Tools::getValue('action');
       if($action=='updateCollectionOrdering' && ($collections = Tools::getValue('col_collection')) && Ets_collections::validateArray($collections))
       {
            Ets_collection_class::getInstance()->_updateCollectionOrdering($collections);
       }
       if(Tools::isSubmit('submitBulkActionCollection') && ($collections = Tools::getValue('col_collection_readed')) && Ets_collections::validateArray($collections))
       {
            $this->_submitBulkActionCollection($collections);
       }
       if(Tools::isSubmit('saveEditCollection'))
       {
            $id_collection = (int)Tools::getValue('id_collection');
            $this->_saveEditCollection($id_collection);
       }
       if(Tools::isSubmit('submitSearchProductConllection'))
       {
            $this->_submitSearchProductConllection();
       }
       if(Tools::isSubmit('saveCollectionInformation'))
       {
            //$this->_saveCollectionInformation();
            $this->validateCollectionInformation();
       }
       if(Tools::isSubmit('submitSaveProductConllection') && ($id_collection = (int)Tools::getValue('id_collection')))
       {
            $collection = new Ets_collection_class($id_collection);
            $selected_products = Tools::getValue('selected_products');
            if(is_array($selected_products) && Ets_collections::validateArray($selected_products))
                $collection->addProduct($selected_products);
            else
            {
                $collection->deleteAllProduct();
                die(
                    Tools::jsonEncode(
                        array(
                            'success' => $this->l('Saved successfully'),
                        )
                    )
                );
            }
       }
       if(Tools::isSubmit('getFormAddProductCollection'))
       {
            $id_collection = (int)Tools::getValue('id_collection');
            die(
                Tools::jsonEncode(
                    array(
                        'form_html' => $this->getFormAddProductCollection($id_collection),
                    )
                )
            );
       }
       if(Tools::isSubmit('change_enabled') && $id_collection = (int)Tools::getValue('id_ets_col_collection'))
       {
            $this->_submitChangeStatus($id_collection);
       }
       if(Tools::isSubmit('deleteimage') && ($id_collection = (int)Tools::getValue('id_ets_col_collection')) && ($id_lang= (int)Tools::getValue('id_lang')))
       {
            $this->_submitDeleteImageConllection($id_collection,$id_lang);
       }
       if(Tools::isSubmit('deletethumb') && ($id_collection = (int)Tools::getValue('id_ets_col_collection')) && ($id_lang= (int)Tools::getValue('id_lang')))
       {
            $this->_submitDeleteThumbConllection($id_collection,$id_lang);
       }
       if(Tools::getValue('del')=='yes' && ($id_collection = (int)Tools::getValue('id_ets_col_collection')))
       {
            $collection = new Ets_collection_class($id_collection);
            if($collection->delete())
            {
                $this->context->cookie->success_message = $this->l('Deleted collection successfully');
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminProductCollections'));
            }
            else
                $this->module->_errors[] = $this->l('An error occurred while deleting the collection');
       }
       if(Tools::isSubmit('duplicatecol_collection') && ($id_collection = (int)Tools::getValue('id_ets_col_collection')))
       {
            if(Ets_collection_class::duplicateCollection($id_collection))
            {
                $this->context->cookie->success_message = $this->l('Duplicated collection successfully');
                Tools::redirectAdmin($this->context->link->getAdminLink('AdminProductCollections'));
            }
       }
       if(Tools::isSubmit('viewStatistic') && Tools::isSubmit('ajax') && ($id_collection = (int)Tools::getValue('id_collection')) && ($collection = new Ets_collection_class($id_collection)) && Validate::isLoadedObject($collection))
       {
            die(
                Tools::jsonEncode(
                    array(
                        'ets_col_body_html'=> $collection->_renderViewStatistic(),
                    )
                )
            );
       }
    }
    public function _submitChangeStatus($id_collection)
    {
        $collection = new Ets_collection_class($id_collection);
        $collection->active = (int)Tools::getValue('change_enabled');
        if($collection->update())
        {
            if($collection->active)
            {
                die(
                    Tools::jsonEncode(
                        array(
                            'href' => $this->context->link->getAdminLink('AdminProductCollections').'&id_ets_col_collection='.$collection->id.'&change_enabled=0&field=active',
                            'title' => $this->l('Click to turn off'),
                            'success' => $this->l('Updated successfully'),
                            'enabled' => 1,
                        )
                    )  
                );
            }
            else
            {
                die(
                    Tools::jsonEncode(
                        array(
                            'href' => $this->context->link->getAdminLink('AdminProductCollections').'&id_ets_col_collection='.$collection->id.'&change_enabled=1&field=active',
                            'title' => $this->l('Click to turn on'),
                            'success' => $this->l('Updated successfully'),
                            'enabled' => 0,
                        )
                    )  
                );
            }
        }
        else
        {
            die(
                Tools::jsonEncode(
                    array(
                        'errors' => $this->l('An error occurred while saving the collection')
                    )
                )
            );
        }
    }
    public function renderList()
    {
        if(Tools::isSubmit('addCollecion') || Tools::isSubmit('editcol_collection'))
        {
            $this->context->smarty->assign(
                array(
                    'ets_col_body_html'=> Ets_collection_class::getInstance()->_renderFormCollection(),
                )
            );
        }elseif(Tools::isSubmit('viewStatistic') && ($id_collection = (int)Tools::getValue('id_collection')) && ($collection = new Ets_collection_class($id_collection)) && Validate::isLoadedObject($collection))
        {
            $this->context->smarty->assign(
                array(
                    'ets_col_body_html'=> $collection->_renderViewStatistic(),
                )
            );
        }
        else
        {
            $this->context->smarty->assign(
                array(
                    'ets_col_body_html'=> Ets_collection_class::getInstance()->_renderCollection(),
                )
            );
        }
        
        $html ='';
        if($this->context->cookie->success_message)
        {
            $html .= $this->module->displayConfirmation($this->context->cookie->success_message);
            $this->context->cookie->success_message ='';
        }
        if($this->module->_errors)
            $html .= $this->module->displayError($this->module->_errors);
        return $html.$this->module->display(_PS_MODULE_DIR_.$this->module->name.DIRECTORY_SEPARATOR.$this->module->name.'.php', 'admin.tpl');
    }
    public function validateCollectionInformation()
    {
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        $languages = Language::getLanguages(false);
        $name_default = Tools::getValue('name_'.$id_lang_default);
        if(!$name_default)
            $this->module->_errors[] = $this->l('Name is required');
        elseif($name_default && !Validate::isCleanHtml($name_default))
            $this->module->_errors[] = $this->l('Name is not valid');
        $description_default = Tools::getValue('description_'.$id_lang_default);
        if($description_default && !Validate::isCleanHtml($description_default))
            $this->module->_errors[] = $this->l('Description is not valid');
        if(!$this->module->_errors)
        {
            $description = array();
            $name = array();
            foreach($languages as $language)
            {
                if(($name[$language['id_lang']] = Tools::getValue('name_'.$language['id_lang'])) && !Validate::isGenericName($name[$language['id_lang']]))
                    $this->module->_errors[] = $this->l('Name is not valid in').' '.$language['iso_code'];
                if(($description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang'])) && !Validate::isCleanHtml($description[$language['id_lang']]))
                    $this->module->_errors[] = $this->l('Description is not valid in').' '.$language['iso_code'];
                if(isset($_FILES['image_'.$language['id_lang']]) && $_FILES['image_'.$language['id_lang']] && isset($_FILES['image_'.$language['id_lang']]['name']) && $_FILES['image_'.$language['id_lang']]['name'])
                {
                    $this->module->validateFile($_FILES['image_'.$language['id_lang']]['name'],$_FILES['image_'.$language['id_lang']]['size'],$this->module->_errors);
                }
                if(isset($_FILES['thumb_'.$language['id_lang']]) && $_FILES['thumb_'.$language['id_lang']] && isset($_FILES['thumb_'.$language['id_lang']]['name']) && $_FILES['thumb_'.$language['id_lang']]['name'])
                {
                    $this->module->validateFile($_FILES['thumb_'.$language['id_lang']]['name'],$_FILES['thumb_'.$language['id_lang']]['size'],$this->module->_errors);
                }
            }
        }
        if($this->module->_errors)
        {
            die(
                Tools::jsonEncode(
                    array(
                        'errors' => $this->module->displayError($this->module->_errors)
                    )
                )
            );
        }
        else
        {
            die(
                Tools::jsonEncode(
                    array(
                        'success' => true,
                    )
                )
            );
        }
        
    }
    public function _saveCollectionInformation()
    {
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        $languages = Language::getLanguages(false);
        $name_default = Tools::getValue('name_'.$id_lang_default);
        if(!$name_default)
            $this->module->_errors[] = $this->l('Name is required');
        elseif($name_default && !Validate::isCleanHtml($name_default))
            $this->module->_errors[] = $this->l('Name is not valid');
        $description_default = Tools::getValue('description_'.$id_lang_default);
        if($description_default && !Validate::isCleanHtml($description_default))
            $this->module->_errors[] = $this->l('Description is not valid');
        if(!$this->module->_errors)
        {
            $description = array();
            $name = array();
            $active = (int)Tools::getValue('active');
            foreach($languages as $language)
            {
                if(($name[$language['id_lang']] = Tools::getValue('name_'.$language['id_lang'])) && !Validate::isGenericName($name[$language['id_lang']]))
                    $this->module->_errors[] = $this->l('Name is not valid in').' '.$language['iso_code'];
                if(($description[$language['id_lang']] = Tools::getValue('description_'.$language['id_lang'])) && !Validate::isCleanHtml($description[$language['id_lang']]))
                    $this->module->_errors[] = $this->l('Description is not valid in').' '.$language['iso_code'];
                if(isset($_FILES['image_'.$language['id_lang']]) && $_FILES['image_'.$language['id_lang']] && isset($_FILES['image_'.$language['id_lang']]['name']) && $_FILES['image_'.$language['id_lang']]['name'])
                {
                    $this->module->validateFile($_FILES['image_'.$language['id_lang']]['name'],$_FILES['image_'.$language['id_lang']]['size'],$this->module->_errors);
                }
                if(isset($_FILES['thumb_'.$language['id_lang']]) && $_FILES['thumb_'.$language['id_lang']] && isset($_FILES['thumb_'.$language['id_lang']]['name']) && $_FILES['thumb_'.$language['id_lang']]['name'])
                {
                    $this->module->validateFile($_FILES['thumb_'.$language['id_lang']]['name'],$_FILES['thumb_'.$language['id_lang']]['size'],$this->module->_errors);
                }
            }
        }
        if(!$this->module->_errors)
        {
            if($id_collection = (int)Tools::getValue('id_collection'))
            {
                $collection = new Ets_collection_class($id_collection);
            }   
            else
            {
                $collection = new Ets_collection_class();
                $collection->id_shop = $this->context->shop->id;
            }
            $collection->active = $active;
            $new_images = array();
            $old_images = array();
            $new_thumbs = array();
            $old_thumbs = array();
            foreach($languages as $language)
            {
                $collection->name[$language['id_lang']] = $name[$language['id_lang']] ? : $name[$id_lang_default];
                $collection->description[$language['id_lang']] = $description[$language['id_lang']] ? : $description[$id_lang_default];
                if(isset($_FILES['image_'.$language['id_lang']]) && $_FILES['image_'.$language['id_lang']] && isset($_FILES['image_'.$language['id_lang']]['name']) && $_FILES['image_'.$language['id_lang']]['name'])
                {
                    $new_images[$language['id_lang']] = $this->module->uploadFile('image_'.$language['id_lang'],$this->module->_errors,'','image');
                    $old_images[$language['id_lang']] = $collection->image[$language['id_lang']];
                    $collection->image[$language['id_lang']] = $new_images[$language['id_lang']];
                }
                elseif(!$collection->id)
                    $collection->image[$language['id_lang']] ='';
                if(isset($_FILES['thumb_'.$language['id_lang']]) && $_FILES['thumb_'.$language['id_lang']] && isset($_FILES['thumb_'.$language['id_lang']]['name']) && $_FILES['thumb_'.$language['id_lang']]['name'])
                {
                    $new_thumbs[$language['id_lang']] = $this->module->uploadFile('thumb_'.$language['id_lang'],$this->module->_errors,'','thumb');
                    $old_thumbs[$language['id_lang']] = $collection->thumb[$language['id_lang']];
                    $collection->thumb[$language['id_lang']] = $new_thumbs[$language['id_lang']];
                }
                elseif(!$collection->id)
                    $collection->thumb[$language['id_lang']] ='';
            }
            if(!$collection->id)
            {
                foreach($languages as $language)
                {
                    if(!$collection->image[$language['id_lang']])   
                        $collection->image[$language['id_lang']] = $collection->image[$id_lang_default];
                    if(!$collection->thumb[$language['id_lang']])   
                        $collection->thumb[$language['id_lang']] = $collection->thumb[$id_lang_default];
                }
            }
            if(!$this->module->_errors)
            {
                if(!$collection->id)
                {
                    if($collection->add())
                    {
                        die(
                            Tools::jsonEncode(
                                array(
                                    'success' => $this->l('Added collection successfully'),
                                    'id_collection' => $collection->id,
                                    'image_del_link' => $this->context->link->getAdminLink('AdminProductCollections').'&editcol_collection=1&id_ets_col_collection='.$collection->id.'&deleteimage=1',
                                    'thumb_del_link' => $this->context->link->getAdminLink('AdminProductCollections').'&editcol_collection=1&id_ets_col_collection='.$collection->id.'&deletethumb=1',
                                    'link_collection' => $this->module->getCollectionLink(array('id_collection'=>$collection->id)),
                                )
                            )
                        );
                    }
                    else
                        $this->module->_errors[] = $this->l('An error occurred while creating the collection');
                }
                elseif($collection->update())
                {
                    if(isset($old_images) && $old_images)
                    {
                        foreach($old_images as $old_image)
                        {
                            if(!in_array($old_image,$collection->image))
                                @unlink(_PS_IMG_DIR_.'col_collection/'.$old_image);
                        }
                    }
                    if(isset($old_thumbs) && $old_thumbs)
                    {
                        foreach($old_thumbs as $old_thumb)
                        {
                            if(!in_array($old_thumb,$collection->thumb))
                                @unlink(_PS_IMG_DIR_.'col_collection/'.$old_thumb);
                        }
                    }
                    die(
                        Tools::jsonEncode(
                            array(
                                'success' => $this->l('Updated collection successfully'),
                                'id_collection' => $collection->id,
                                'image_del_link' => $this->context->link->getAdminLink('AdminProductCollections').'&editcol_collection=1&id_ets_col_collection='.$collection->id.'&deleteimage=1',
                                'thumb_del_link' => $this->context->link->getAdminLink('AdminProductCollections').'&editcol_collection=1&id_ets_col_collection='.$collection->id.'&deletethumb=1',
                                'link_collection' => $this->module->getCollectionLink(array('id_collection'=>$collection->id)),
                            )
                        )
                    );
                }
                else
                    $this->module->_errors[] = $this->l('An error occurred while saving the collection');
            }
        }
        if($this->module->_errors)
        {

            if(isset($new_images) && $new_images)
            {
                foreach($new_images as $new_image)
                {
                    if(!in_array($new_image,$collection->image))
                        @unlink(_PS_IMG_DIR_.'col_collection/'.$new_image);
                }
            }
            if(isset($new_thumbs) && $new_thumbs)
            {
                foreach($new_thumbs as $new_thumb)
                {
                    if(!in_array($new_thumb,$collection->thumb))
                        @unlink(_PS_IMG_DIR_.'col_collection/'.$new_thumb);
                }
            }
            die(
                Tools::jsonEncode(
                    array(
                        'errors' => $this->module->displayError($this->module->_errors)
                    )
                )
            );
        }
    }
    public function getFormAddProductCollection($id_collection)
    {
        $totalRecords = (int)Ets_collection_class::getListProducts(' AND (colp.id_ets_col_collection!="'.(int)$id_collection.'" or colp.id_ets_col_collection is null)',0,0,'',true,false,$id_collection);
        $totalPages = ceil($totalRecords / 10);
        $this->context->smarty->assign(
            array(
                'products' => Ets_collection_class::getListProducts(' AND (colp.id_ets_col_collection!="'.(int)$id_collection.'" or colp.id_ets_col_collection is null)',0,10,'pl.name asc',false,false,$id_collection),
                'selected_products' =>Ets_collection_class::getListProducts(' AND colp.id_ets_col_collection="'.(int)$id_collection.'"',0,false,'colp.position ASC'),
                'total_pages' =>$totalPages, 
                'categories_tree'=> $this->displayProductCategoryTre(Ets_col_defines::getInstance()->getCategoriesTree())
            )
        );
        return $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/form_add_product.tpl');
    }
    public function displayProductCategoryTre($blockCategTree)
    {
        $this->context->smarty->assign(
            array(
                'blockCategTree'=> $blockCategTree,
                'branche_tpl_path_input'=> _PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/category-tree.tpl',
            )
        );
        return $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->module->name.'/views/templates/hook/categories.tpl');
    }
    public function _submitSearchProductConllection()
    {
        $selected_products = Tools::getValue('selected_products');
        $filter = $selected_products && is_array($selected_products) && Ets_collections::validateArray($selected_products,'isInt') ?' AND p.id_product NOT IN ('.implode(',',array_map('intval',$selected_products)).')':'';
        if(($name_product = Tools::getValue('name_product'))!=='' && Validate::isCleanHtml($name_product))
        {
            $filter .=' AND pl.name like "%'.pSQL($name_product).'%"';
        }
        if(($id_category = (int)Tools::getValue('id_category')))
        {
            $filter .=' AND cp.id_category = '.(int)$id_category;
        }
        if(($reference_product = Tools::getValue('reference_product'))!=='' && Validate::isCleanHtml($reference_product))
        {
            $filter .=' AND p.reference like "%'.pSQL($reference_product).'%"';
        }
        if(($price_product_min = Tools::getValue('price_product_min'))!=='' && Validate::isCleanHtml($price_product_min))
        {
            $filter .=' AND p.price >= "'.(float)$price_product_min.'"';
        }
        if(($price_product_max = Tools::getValue('price_product_max'))!=='' && Validate::isCleanHtml($price_product_max))
        {
            $filter .=' AND p.price <= "'.(float)$price_product_max.'"';
        }
        $totalRecords = (int)Ets_collection_class::getListProducts($filter,0,0,'',true,true);
        $paggination = new Ets_col_paggination_class();            
        $paggination->total = $totalRecords;
        $paggination->limit =  10;
        $totalPages = ceil($totalRecords / $paggination->limit);
        if(Tools::isSubmit('totalProductInList') && ($totalProductInList = (int)Tools::getValue('totalProductInList'))  )
        {
            if($totalProductInList%$paggination->limit!=0)
                $page = ceil($totalProductInList/$paggination->limit);
            else
                $page = $totalProductInList/$paggination->limit +1;
        }
        else
        {
            $page = (int)Tools::getValue('page');
            if($page < 1)
                $page =1;
        }
        if($page > $totalPages)
            $page = $totalPages; 
        $products = Ets_collection_class::getListProducts($filter,$page,$paggination->limit,'pl.name asc',false,false);
        die(
            Tools::jsonEncode(
                array(
                    'products' => $products,
                    'load_more' => $page < $totalPages ? $page:'',
                )
            )
        );
    }
    public function _submitDeleteImageConllection($id_collection,$id_lang)
    {
        $errors = '';
        $collection = new Ets_collection_class($id_collection);
        if(!Validate::isLoadedObject($collection))
            $errors = $this->l('Collection is not valid');
        else
        {
            $image = $collection->image[$id_lang];
            $collection->image[$id_lang] = '';
            if($collection->update())
            {
                if(!in_array($image,$collection->image))
                    @unlink(_PS_IMG_DIR_.'col_collection/'.$image);
                die(
                    Tools::jsonEncode(
                        array(
                            'success' => $this->l('Deleted image successfully'),
                        )
                    )
                );
            }
            else
            {
                $errors= $this->l('An error occurred while deleting the image');
            }
        }
        if($errors)
        {
            die(
                Tools::jsonEncode(
                    array(
                        'errors' => $errors,
                    )
                )
            );
        }
    }
    public function _submitDeleteThumbConllection($id_collection,$id_lang)
    {
        $errors = '';
        $collection = new Ets_collection_class($id_collection);
        if(!Validate::isLoadedObject($collection))
            $errors = $this->l('Collection is not valid');
        else
        {
            $thumb = $collection->thumb[$id_lang];
            $collection->thumb[$id_lang] = '';
            if($collection->update())
            {
                if(!in_array($thumb,$collection->thumb))
                    @unlink(_PS_IMG_DIR_.'col_collection/'.$thumb);
                die(
                    Tools::jsonEncode(
                        array(
                            'success' => $this->l('Deleted image successfully'),
                        )
                    )
                );
            }
            else
            {
                $errors= $this->l('An error occurred while deleting the image');
            }
        }
        if($errors)
        {
            die(
                Tools::jsonEncode(
                    array(
                        'errors' => $errors,
                    )
                )
            );
        }
    }
    public function _submitBulkActionCollection($collections)
    {
        $bulk_action_col_collection = Tools::getValue('bulk_action_col_collection');
        if($bulk_action_col_collection=='delete_all')
        {
            if($collections)
            {
                foreach(array_keys($collections) as $id_collection)
                {
                    $collection_class = new Ets_collection_class($id_collection);
                    $collection_class->delete();
                }
                die(
                    Tools::jsonEncode(
                        array(
                            'success' => $this->l('Deleted successfully'),
                        )
                    )
                );
            }
        }elseif($bulk_action_col_collection=='duplicate_all')
        {
            if($collections)
            {
                foreach(array_keys($collections) as $id_collection)
                {
                    Ets_collection_class::duplicateCollection($id_collection);
                }
            }
            die(
                Tools::jsonEncode(
                    array(
                        'success' => $this->l('Duplicated successfully'),
                    )
                )
            );
        }
    }
    public function _saveEditCollection($id_collection)
    {
        if($id_collection)
            $collection = new Ets_collection_class($id_collection);
        else
        {
            $collection = new Ets_collection_class();
            $collection->id_shop = $this->context->shop->id;
        }
        $id_lang_default = Configuration::get('PS_LANG_DEFAULT');
        $languages = Language::getLanguages(false);
        $name_default = Tools::getValue('name_'.$id_lang_default);
        if(!$name_default)
            $this->module->_errors[] = $this->l('Name is required');
        elseif($name_default && !Validate::isGenericName($name_default))
            $this->module->_errors[] = $this->l('Name is not valid');
        elseif($name_default && Tools::strlen($name_default) >200)
            $this->module->_errors[] = $this->l('Name cannot longer than 200 characters');
        $desc_default = Tools::getValue('description_'.$id_lang_default);
        if($desc_default && !Validate::isCleanHtml($desc_default))
            $this->module->_errors[] = $this->l('Description is not valid');
        $meta_title_default = Tools::getValue('meta_title_'.$id_lang_default);
        $meta_description_default = Tools::getValue('meta_description_'.$id_lang_default);
        $link_rewrite_default = Tools::getValue('link_rewrite_'.$id_lang_default);
        if($meta_title_default && !Validate::isCleanHtml($meta_title_default))
            $this->module->_errors[] = $this->l('Meta title is not valid');
        if($meta_description_default && !Validate::isCleanHtml($meta_description_default))
            $this->module->_errors[] = $this->l('Meta description is not valid');
        if($link_rewrite_default && !Validate::isLinkRewrite($link_rewrite_default))
            $this->module->_errors[] = $this->l('Friendly URL is not valid');
        $description = array();
        $name = array();
        $meta_titles = array();
        $meta_descriptions = array();
        $link_rewrites = array();
        if(!$this->module->_errors)
        {
            foreach($languages as $language)
            {
                $id_lang = (int)$language['id_lang'];
                $iso_code = $language['iso_code'];
                if(($name[$id_lang] = Tools::getValue('name_'.$id_lang)) && !Validate::isGenericName($name[$id_lang]))
                    $this->module->_errors[] = sprintf($this->l('Name is not valid in %s'),$iso_code);
                elseif($name[$id_lang] && Tools::strlen($name[$id_lang])>200)
                    $this->module->_errors[] = sprintf($this->l('Name in %s cannot longer than 200 characters'),$iso_code);
                if(($description[$id_lang] = Tools::getValue('description_'.$id_lang)) && !Validate::isCleanHtml($description[$id_lang]))
                    $this->module->_errors[] = sprintf($this->l('Description is not valid in %s'),$iso_code);
                if(($meta_titles[$id_lang] = Tools::getValue('meta_title_'.$id_lang)) && !Validate::isCleanHtml($meta_titles[$id_lang]))
                    $this->module->_errors[] = sprintf($this->l('Meta title is not valid in %s',$language['iso_code']));
                if(($meta_descriptions[$id_lang] = Tools::getValue('meta_description_'.$id_lang)) && !Validate::isCleanHtml($meta_descriptions[$id_lang]))
                    $this->module->_errors[] = sprintf($this->l('Meta description is not valid in %s'),$iso_code);
                if(($link_rewrites[$id_lang] = Tools::getValue('link_rewrite_'.$id_lang)) && !Validate::isLinkRewrite($link_rewrites[$id_lang]))
                    $this->module->_errors[] = sprintf($this->l('Friendly URL is not valid in %s'),$iso_code);
                if(isset($_FILES['image_'.$language['id_lang']]) && $_FILES['image_'.$language['id_lang']] && isset($_FILES['image_'.$language['id_lang']]['name']) && $_FILES['image_'.$language['id_lang']]['name'])
                {
                    $this->module->validateFile($_FILES['image_'.$language['id_lang']]['name'],$_FILES['image_'.$language['id_lang']]['size'],$this->module->_errors);
                }
                if(isset($_FILES['thumb_'.$language['id_lang']]) && $_FILES['thumb_'.$language['id_lang']] && isset($_FILES['thumb_'.$language['id_lang']]['name']) && $_FILES['thumb_'.$language['id_lang']]['name'])
                {
                    $this->module->validateFile($_FILES['thumb_'.$language['id_lang']]['name'],$_FILES['thumb_'.$language['id_lang']]['size'],$this->module->_errors);
                }
            }
        }
        $count_product = Tools::getValue('count_product');
        $hook_display = Tools::getValue('hook_display');
        $active = (int)Tools::getValue('active');
        if($count_product==='0' || ($count_product && !Validate::isUnsignedInt($count_product)))
            $this->module->_errors[] = $this->l('Product count is not valid');
        if($hook_display && !in_array($hook_display,$this->module->hooks_display))
            $this->module->_errors[] = $this->l('Display position is not valid');
        if(!$this->module->_errors)
        {
            $collection->active = $active;
            $new_images = array();
            $old_images = array();
            $new_thumbs = array();
            $old_thumbs = array();
            foreach($languages as $language)
            {
                $id_lang = (int)$language['id_lang'];
                $collection->name[$language['id_lang']] = $name[$language['id_lang']] ? : $name[$id_lang_default];
                $collection->description[$language['id_lang']] = $description[$language['id_lang']] ? : $description[$id_lang_default];
                $collection->meta_title[$id_lang] = $meta_titles[$id_lang] ? : $meta_titles[$id_lang_default];
                $collection->meta_description[$id_lang] = $meta_descriptions[$id_lang] ?: $meta_descriptions[$id_lang_default];
                $collection->link_rewrite[$id_lang] = $link_rewrites[$id_lang] ? : $link_rewrites[$id_lang_default];
                if(isset($_FILES['image_'.$language['id_lang']]) && $_FILES['image_'.$language['id_lang']] && isset($_FILES['image_'.$language['id_lang']]['name']) && $_FILES['image_'.$language['id_lang']]['name'])
                {
                    $new_images[$language['id_lang']] = $this->module->uploadFile('image_'.$language['id_lang'],$this->module->_errors,'','image');
                    $old_images[$language['id_lang']] = $collection->image[$language['id_lang']];
                    $collection->image[$language['id_lang']] = $new_images[$language['id_lang']];
                }
                elseif(!$collection->id)
                    $collection->image[$language['id_lang']] ='';
                if(isset($_FILES['thumb_'.$language['id_lang']]) && $_FILES['thumb_'.$language['id_lang']] && isset($_FILES['thumb_'.$language['id_lang']]['name']) && $_FILES['thumb_'.$language['id_lang']]['name'])
                {
                    $new_thumbs[$language['id_lang']] = $this->module->uploadFile('thumb_'.$language['id_lang'],$this->module->_errors,'','thumb');
                    $old_thumbs[$language['id_lang']] = $collection->thumb[$language['id_lang']];
                    $collection->thumb[$language['id_lang']] = $new_thumbs[$language['id_lang']];
                }
            }
            if(!$this->module->_errors)
            {
                if($collection->id)
                {
                    if($collection->update())
                    {
                        $selected_products = Tools::getValue('selected_products');
                        if((is_array($selected_products) && Ets_collections::validateArray($selected_products)) || !$selected_products)
                        {
                            $collection->addProduct($selected_products);
                        }
                        if(isset($old_images) && $old_images)
                        {
                            foreach($old_images as $old_image)
                            {
                                if(!in_array($old_image,$collection->image))
                                    @unlink(_PS_IMG_DIR_.'col_collection/'.$old_image);
                            }
                        }
                        if(isset($old_thumbs) && $old_thumbs)
                        {
                            foreach($old_thumbs as $old_thumb)
                            {
                                if(!in_array($old_thumb,$collection->thumb))
                                    @unlink(_PS_IMG_DIR_.'col_collection/'.$old_thumb);
                            }
                        }
                    }
                    else
                        $this->module->_errors[] = $this->l('An error occurred while saving the collection');
                }
                elseif($collection->add())
                {
                    $selected_products = Tools::getValue('selected_products');
                    if((is_array($selected_products) && Ets_collections::validateArray($selected_products)) || !$selected_products)
                    {
                        $collection->addProduct($selected_products);
                    }
                    if(isset($old_images) && $old_images)
                    {
                        foreach($old_images as $old_image)
                        {
                            if(!in_array($old_image,$collection->image))
                                @unlink(_PS_IMG_DIR_.'col_collection/'.$old_image);
                        }
                    }
                    if(isset($old_thumbs) && $old_thumbs)
                    {
                        foreach($old_thumbs as $old_thumb)
                        {
                            if(!in_array($old_thumb,$collection->thumb))
                                @unlink(_PS_IMG_DIR_.'col_collection/'.$old_thumb);
                        }
                    }
                }
                else
                    $this->module->_errors[] = $this->l('An error occurred while saving the collection');
                
            }
        }
        if($this->module->_errors)
        {
            if(isset($new_images) && $new_images)
            {
                foreach($new_images as $new_image)
                {
                    if(!in_array($new_image,$collection->image))
                        @unlink(_PS_IMG_DIR_.'col_collection/'.$new_image);
                }
            }
            if(isset($new_thumbs) && $new_thumbs)
            {
                foreach($new_thumbs as $new_thumb)
                {
                    if(!in_array($new_thumb,$collection->thumb))
                        @unlink(_PS_IMG_DIR_.'col_collection/'.$new_thumb);
                }
            }
            die(
                Tools::jsonEncode(
                    array(
                        'errors' => $this->module->displayError($this->module->_errors),
                    )
                )
            );
        }
        else
        {
            $collection->addDisplayPages();
            $this->module->clearCache();
            die(
                Tools::jsonEncode(
                    array(
                        'success' => $this->l('Updated successfully'),
                        'image_del_link' => $this->context->link->getAdminLink('AdminProductCollections').'&editcol_collection=1&id_ets_col_collection='.$collection->id.'&deleteimage=1',
                        'thumb_del_link' => $this->context->link->getAdminLink('AdminProductCollections').'&editcol_collection=1&id_ets_col_collection='.$collection->id.'&deletethumb=1',
                        'link_collection' => $this->module->getCollectionLink(array('id_collection'=>$collection->id)),
                        'id_collection' => $collection->id,
                    )
                )
            );
        }
    }
    
}