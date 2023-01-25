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
 var ajax_search = false;
 var time_ajax_search = false;
$(document).ready(function(){
    setTimeout(function(){ets_col_close_alert();},3000);
    if($(".open-image").length)
        $(".open-image").fancybox();  
    ets_col_displayFormConfig();
    $(document).on('click','input[name="ETS_COL_DISPLAY_LIST_HOME_PAGE"]',function(){
        ets_col_displayFormConfig();
    });
    if($('select[name="hook_display"]').val()=='custom_hook')
        $('select[name="hook_display"]').next('p.help-block').show();
    else
        $('select[name="hook_display"]').next('p.help-block').hide();
    if($('select[name="hook_display"]').val()=='right_column' || $('select[name="hook_display"]').val()=='left_column' || $('select[name="hook_display"]').val()=='')
        $('.form-group.display_list').hide();
    else
        $('.form-group.display_list').show();
    if($('select[name="hook_display"]').val()=='')
        $('.form-group.count_list').hide();
    else
        $('.form-group.count_list').show();
    if($('.form-group.collection_page_display').length)
    {
        $('.form-group.collection_page_display').each(function(){
            $('.form-display-pages .form-display[data-page="collection_page"] >.row').append($(this).clone());
            $(this).remove();
        });
    }
    if($('.tbn-view-statistic').length)
        $('.tbn-view-statistic').attr('title',View_statistics_text);
    $(document).on('change','#name_'+ets_col_lang_default,function(){
        if(!$('#id_collection').val())
        {
            $('#link_rewrite_'+ets_col_lang_default).val(str2url($(this).val(), 'UTF-8')); 
        }        
        else
        {
            if($('#link_rewrite_'+ets_col_lang_default).val() == '')
                $('#link_rewrite_'+ets_col_lang_default).val(str2url($(this).val(), 'UTF-8'));
        } 
    });
    $(document).on('change','input[type="range"]',function(){
        ets_col_change_range($(this));
    });
    $(document).on('click','.tab-display-pages .tab-display',function(){
        if(!$(this).hasClass('active'))
        {
            var page = $(this).data('page');
            $('.tab-display-pages .tab-display').removeClass('active');
            $(this).addClass('active');
            $('.form-display-pages .form-display').removeClass('active');
            $('.form-display-pages .form-display[data-page="'+page+'"]').addClass('active');
            $('input[type="range"]').each(function(){
                ets_col_change_range($(this)); 
            });
        }    
    });
    $(document).on('change','select[name="hook_display"]',function(){
        if($(this).val()=='custom_hook')
            $(this).next('p.help-block').show();
        else
            $(this).next('p.help-block').hide();
        if($(this).val()=='right_column' || $(this).val()=='left_column' || $(this).val()=='' )
            $('.form-group.display_list').hide();
        else
            $('.form-group.display_list').show();
        if($(this).val()=='')
            $('.form-group.count_list').hide();
        else
            $('.form-group.count_list').show();
    });
    $('.list-collection-products').sortable({ 
		opacity: 0.6,
        handle: ".col-product-sortable",
        cursor: 'move',
		update: function() {	
		},
    	stop: function( event, ui ) {
   		}
	});
    $(document).on('click','button[name="saveCollectionInformation"]',function(e){
        $('.module_error.alert.alert-danger').parent().remove();
        e.preventDefault();
        var $this= $(this);
        if(!$this.hasClass('loading'))
        {
            $this.addClass('loading');
            var formData = new FormData($(this).parents('form').get(0));
            formData.append('ajax', 1);
            formData.append('saveCollectionInformation',1);
            $.ajax({
                url: '',
                data: formData,
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(json){
                    $this.removeClass('loading');
                    if(json.success)
                    {
                        $('.ets_col_tabs .tab').removeClass('active');
                        $('.ets_col_tabs .tab.general').addClass('current_active').addClass('change_tab');
                        $('.ets_col_tabs .tab.product').addClass('active').addClass('change_tab');
                        $('.ets_col_tab_content .tab_content').removeClass('active');
                        $('.ets_col_tab_content .tab_content.product').addClass('active');
                    }
                    if(json.errors)
                    {
                        $('#ets_col_collection_form').before(json.errors);
                    }
                    
                },
                error: function(xhr, status, error)
                {
                    $this.removeClass('loading');            
                }
            });
        }
    }); 
    $(document).on('click','.tab_content.product .btn-back',function(){
        $('.ets_col_tabs .tab').removeClass('active');
        $('.ets_col_tabs .tab.general').addClass('active');
        $('.ets_col_tab_content .tab_content').removeClass('active');
        $('.ets_col_tab_content .tab_content.general').addClass('active');
    });
    $(document).on('click','.tab_content.display .btn-back2',function(){
        $('.ets_col_tabs .tab').removeClass('active');
        $('.ets_col_tabs .tab.product').addClass('active').removeClass('current_active');
        $('.ets_col_tab_content .tab_content').removeClass('active');
        $('.ets_col_tab_content .tab_content.product').addClass('active');
    });
    $(document).on('change','input[type="file"].image,input[type="file"].thumb',function(){
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif','webp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) != -1) {
            ets_col_readCollectionImageURL(this);            
        }
        else
        {
            $(this).val('');
            alert(ets_col_invalid_file);
        }
    });
    $(document).on('click','.delete_collection_image',function(e){
        e.preventDefault(); 
        if(!$(this).hasClass('active'))
        {
            if(confirm(confirm_delete_image))
            {
                var $this = $(this);
                if($this.attr('href')!='')
                {
                    $this.addClass('active');
                    $.ajax({
                        url: $this.attr('href'),
                        data: '',
                        type: 'post',
                        dataType: 'json',                
                        success: function(json){ 
                            $this.removeClass('active');
                            if(json.errors)
                            {
                                $.growl.error({ message: json.errors });
                            }   
                            if(json.success)
                            {
                                $.growl.notice({ message: json.success });
                                $this.parent().next('.uploaded_img_wrapper').show(); 
                                $this.parent().parent().find('.image').val('');
                                $this.parent().parent().find('input[name="filename"]').val('');
                                $this.parent().remove();
                            }                                  
                        },
                        error: function(error)
                        {                                      
                            $this.removeClass('active');
                        }
                    });
                }
                else
                {
                    $this.parent().next('.uploaded_img_wrapper').show(); 
                    $this.parent().parent().find('.image').val('');
                    $this.parent().parent().find('input[name="filename"]').val('');
                    $this.parent().remove();
                }
                
                
            }
        }
    });
    $(document).on('click','.btn_add_product_to_collection',function(e){
        e.preventDefault(); 
        $(this).addClass('loading');
        $.ajax({
            url: '',
            data: {
                'getFormAddProductCollection': true,
                'id_collection' :$('#id_collection').val(),
            },
            type: 'post',
            dataType: 'json',   
            success: function (res) {
                $('.ets_collection_popup').addClass('show');
                $('#block-form-add-new-products').html(res.form_html);
                $('#list_selected_products').sortable({ 
            		opacity: 0.6,
                    handle: ".col-product-sortable",
                    cursor: 'move',
            		update: function() {	
            		},
                	stop: function( event, ui ) {
               		}
            	});
                $('.block_product_no_selected').animate({scrollTop: 0})
                $('.block_product_no_selected .product-wrapper').scroll(function(){
                    console.log('scroll='+$(this).scrollTop()+'height='+$(this).height());
                    if($(this).scrollTop()>=$(this).height()-50)
                    {
                        ets_col_loadmoreProducts();
                    }    
                });
                $('.btn_add_product_to_collection').removeClass('loading');
            }
        });
    });
    $(document).on('click','.tbn-view-statistic',function(e){
        e.preventDefault(); 
        var $this = $(this);
        $this.addClass('loading');
        ajax_url = $this.attr('href');
        $.ajax({
            url: ajax_url,
            data: {
                'ajax': true
            },
            type: 'post',
            dataType: 'json',   
            success: function (res) {
                if(!$('#block-statistic-products').length)
                {
                    $html = '<div class="statistic ets_collection_popup show">';
                        $html +='<div class="popup_content table">';
                            $html +='<div class="popup_content_tablecell">';
                                $html +='<div class="popup_content_wrap" style="position: relative">';
                                    $html +='<span class="close_popup" title="'+Close_text+'">+</span>';
                                    $html +='<div id="block-statistic-products" class="defaultForm form-horizontal">'
                                    $html +='</div>';
                                $html +='</div>'
                            $html +='</div>';
                        $html +='</div>';
                    $html +='</div>';
                    $('.row .panel.ets_collection-panel').after($html);
                }
                $('.ets_collection_popup').addClass('show');
                $('#block-statistic-products').html(res.ets_col_body_html);
                $this.removeClass('loading');
            }
        });
    });
    $(document).on('click','.close_popup,button[name="btnCancelProductConllection"]',function(){
        $('.ets_collection_popup').removeClass('show');
        $('#block-form-add-new-products').html('');
    });
    $(document).mouseup(function (e){
        if($('.statistic.ets_collection_popup').length)
        {
            if (!$('.statistic.ets_collection_popup .popup_content_wrap').is(e.target) && $('.statistic.ets_collection_popup .popup_content_wrap').has(e.target).length === 0)
            {
                $('.statistic.ets_collection_popup').removeClass('show');
            }
        }
        
    });
    $(document).keyup(function(e) { 
        if(e.keyCode == 27) {
            if($('.statistic.ets_collection_popup').length)
            {
                $('.statistic.ets_collection_popup').removeClass('show');
            }
        }
    });
    $(document).on('click','.btn-action-add-product',function(e){
        e.preventDefault(); 
        ets_col_addProductCollection(this);
    });
    $(document).on('click','.add_all_product_collection',function(e){
        e.preventDefault(); 
        if($('.btn-action-add-product').length)
        {
            $('.btn-action-add-product').each(function(){
               ets_col_addProductCollection(this); 
            });
        }
    });
    $(document).on('click','#list_selected_products .btn-action-delete-product',function(e){
        e.preventDefault(); 
        ets_col_deleteProductCollection(this);
    });
    $(document).on('click','.delete_all_product_collection',function(e){
        e.preventDefault(); 
        if($('#list_selected_products .btn-action-delete-product').length)
        {
            $('#list_selected_products .btn-action-delete-product').each(function(){
                ets_col_deleteProductCollection(this);
            });
        }
    });
    $(document).on('click','.list-collection-products .btn-action-delete-product',function(e){
        e.preventDefault(); 
        $(this).parent().remove();
        if($('.list-collection-products .product-item').length==0)
        {
            $('.tab_content.product .no-products').show();
            $('.tab_content.product .has-products').hide();
        }
        $('.tab_content.product .badge').html($('.list-collection-products .product-item').length);
    });
    $(document).on('click','button[name="btnSubmitSaveProductConllection"]',function(e){
       e.preventDefault(); 
       var $this = $(this);
       $('.module_error.alert.alert-danger').parent().remove();
       $('.tab_content .has-products .list-collection-products').html('');
        if($('#list_selected_products .product-item').length)
        {
            $('#list_selected_products .product-item').each(function(){
                $('.tab_content .has-products .list-collection-products').append($(this).clone());
            });
        }
        $('.ets_collection_popup').removeClass('show');
        $('.tab_content.product .badge').html($('.list-collection-products .product-item').length);
        if($('.list-collection-products .product-item').length==0)
        {
            $('.tab_content.product .no-products.ets_col_no_product').show();
            $('.tab_content.product .has-products').hide();
        }
        else
        {
            $('.tab_content.product .no-products').hide();
            $('.tab_content.product .has-products').show();
        }
    });
    $(document).on('click','button[name="saveEditCollection"]',function(e){
        e.preventDefault(); 
        $('.module_error.alert.alert-danger').parent().remove();
        var $this = $(this);
        if(!$(this).hasClass('loading'))
        {
            $this.addClass('loading');
            var formData = new FormData($(this).parents('form').get(0));
            formData.append('ajax', 1);
            formData.append('saveEditCollection',1);
            $.ajax({
                url: '',
                data: formData,
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(json){
                    $this.removeClass('loading');
                    if(json.success)
                    {
                        $.growl.notice({ message: json.success });
                        $('#id_collection').val(json.id_collection);
                        if($('.ets_col_upload_img.thumb').length)
                        {
                           $('.ets_col_upload_img.thumb').each(function(){
                                var id_lang = $(this).data('id-lang');
                                if($(this).find('.delete_collection_image').length)
                                   $(this).find('.delete_collection_image').attr('href',json.thumb_del_link+'&id_lang='+id_lang);
                                    
                           }); 
                        }
                        if($('.ets_col_upload_img.image').length)
                        {
                           $('.ets_col_upload_img.image').each(function(){
                                var id_lang = $(this).data('id-lang');
                                if($(this).find('.delete_collection_image').length)
                                   $(this).find('.delete_collection_image').attr('href',json.image_del_link+'&id_lang='+id_lang);
                           }); 
                        }
                        if($('.form-group.collection_link_rewrite .link_collection').length)
                        {
                            $('.form-group.collection_link_rewrite .link_collection').attr('href',json.link_collection).html(json.link_collection);
                        }
                        else
                        {
                            $('.form-group.collection_link_rewrite >.col-lg-9').append('<p class="help-block">URL: <a class="link_collection" href="'+json.link_collection+'" target="_blank">'+json.link_collection+'</a></p>');
                        }
                    }
                    if(json.errors)
                    {
                        $('#ets_col_collection_form').before(json.errors);
                    }
                },
                error: function(xhr, status, error)
                {
                    $this.removeClass('loading');            
                }
            });
        }
    });
    $(document).on('click','button[name="saveCollectionProduct"]',function(e){
        e.preventDefault(); 
        var $this = $(this);
        $('.ets_col_tabs .tab').removeClass('active');
        $('.ets_col_tabs .tab.product').addClass('current_active').addClass('change_tab');
        $('.ets_col_tabs .tab.display').addClass('active').addClass('change_tab');
        $('.ets_col_tab_content .tab_content').removeClass('active');
        $('.ets_col_tab_content .tab_content.display').addClass('active');
        $('input[type="range"]').each(function(){
            ets_col_change_range($(this)); 
        });
    });
    $(document).on('click','.list-col_collection .list-action',function(){
        if(!$(this).hasClass('disabled'))
        {            
            $(this).addClass('disabled');
            var $this= $(this);
            $.ajax({
                url: $(this).attr('href')+'&ajax=1',
                data: {},
                type: 'post',
                dataType: 'json',                
                success: function(json){ 
                    if(json.success)
                    {
                        if(json.enabled=='1')
                        {
                            $this.removeClass('action-disabled').addClass('action-enabled');
                            //$this.html('<span class="action_field_content"><i class="icon-check"></i></span>');
                        }                        
                        else
                        {
                            $this.removeClass('action-enabled').addClass('action-disabled');
                            //$this.html('<span class="action_field_content"><i class="icon-remove"></i></span>');
                        }
                        $this.attr('href',json.href);
                        $this.removeClass('disabled');
                        if(json.title)
                            $this.attr('title',json.title); 
                        $.growl.notice({ message: json.success }); 
                    }
                    if(json.errors)
                        $.growl.error({message:json.errors});
                        
                                                                
                },
                error: function(error)
                {                                      
                    $this.removeClass('disabled');
                }
            });
        }
        return false;
    });
    if ($(".ets_col_datepicker input").length > 0) {
        $('.hasDatepicker').removeClass('hasDatepicker');
		$(".ets_col_datepicker input").datepicker({
			dateFormat: 'yy-mm-dd',
		});
	}
    $(document).on("keypress", '.block_search input', function (e) {
        var code = e.keyCode || e.which;
        if(time_ajax_search)
            clearTimeout(time_ajax_search);
        if (code == 13) {
            ets_col_searchProducts();
        }
        else
        {
            time_ajax_search = setTimeout(function(){ets_col_searchProducts();},3000);
        }
    });
    $(document).on('change','.block_search input',function(){
         if(time_ajax_search)
            clearTimeout(time_ajax_search);
         ets_col_searchProducts();
    });
    $(document).on('click','.btn-clear-filter',function(e){
        e.preventDefault(); 
        $('.block_search input[type="text"]').val('');
        if($('.block_search input[name="id_category"]:checked').length)
        {
            $('#product_catalog_category_tree_filter_reset').click();
            $('#product_catalog_category_tree_filter .btn-outline-secondary').html(Search_by_category);
            $('#tree-categories').removeClass('show');
        }
        if(time_ajax_search)
            clearTimeout(time_ajax_search);
        ets_col_searchProducts();
    });
    $(document).on('click','#product_catalog_category_tree_filter .btn-outline-secondary',function(){
        $(this).next("#tree-categories").toggleClass('show');
    });
    $(document).on('click','.category-tree .label',function(){
        $(this).parent().parent().next('.children').toggle();
        $(this).parent().toggleClass('opend');
    });
    $(document).mouseup(function (e)
    {
        if($('#product_catalog_category_tree_filter #tree-categories').length >0)
        {
           if (!$('#product_catalog_category_tree_filter #tree-categories').is(e.target)&& $('#product_catalog_category_tree_filter #tree-categories').has(e.target).length === 0 && !$('.ui-datepicker').is(e.target) && $('.ui-datepicker').has(e.target).length === 0 && !$('.alert').is(e.target) && $('.alert').has(e.target).length === 0)
           {
                $('#product_catalog_category_tree_filter #tree-categories').hide();
           } 
        }
    });
    $(document).on('click','#tree-categories .category',function(){
        $('#product_catalog_category_tree_filter #tree-categories').hide();
        if($(this).val()!=0)
        {
            $('#product_catalog_category_tree_filter .btn-outline-secondary').html(Search_by_category +' ('+$(this).prev('.label').html()+')');
        }
        else
            $('#product_catalog_category_tree_filter .btn-outline-secondary').html(Search_by_category);
    });
    $(document).on('click','#product_catalog_category_tree_filter_expand',function(){
        $('.category-tree .children').show();
        $('.category-tree .has-child >span').addClass('opend');
    });
    $(document).on('click','#product_catalog_category_tree_filter_collapse',function(){
        $('.category-tree .children').hide();
        $('.category-tree .has-child >span').removeClass('opend');
    });
    $(document).on('click','.ets_col_tabs .change_tab',function(){
        var tab= $(this).data('tab');
        $('.ets_col_tabs .change_tab').removeClass('active').removeClass('current_active'); 
        $('.ets_col_tab_content .tab_content').removeClass('active');
        $('.ets_col_tabs .change_tab.'+tab).addClass('active'); 
        $('.ets_col_tab_content .tab_content.'+tab).addClass('active');
        if(tab=='product')
            $('.ets_col_tabs .change_tab.general').addClass('current_active');
        if (tab=='display')
        {
            $('.ets_col_tabs .change_tab.general,.ets_col_tabs .change_tab.product').addClass('current_active');
            if($('input[type="range"]').length)
            {
                $('input[type="range"]').each(function(){
                    ets_col_change_range($(this)); 
                });
            }
        }
            
    });
    $(document).on('click','.preview_collection_tab .colleciton_tab',function(){
        $('.preview_collection_tab .colleciton_tab').removeClass('active');
        $(this).addClass('active');
        $('.preview_collection_content .colleciton_content').removeClass('active');
        $('.preview_collection_content .colleciton_content.'+$(this).data('tab')).addClass('active');
    });
    $('.col_collection_readed_all').click(function(){
        if (this.checked) {
           $('.col_collection_readed').prop('checked', true);
        } else {
            $('.col_collection_readed').prop('checked', false);
        } 
        ets_col_displayBulkActionCollection();
    });
    $(document).on('click','.col_collection_readed',function(){
        if(this.checked){
            if($('.col_collection_readed').length== $('.col_collection_readed:checked').length)
                $('.col_collection_readed_all').prop('checked', true);
        }
        else
        {
            $('.col_collection_readed_all').prop('checked', false);
        }
        ets_col_displayBulkActionCollection();
    });
    $(document).on('change','#bulk_action_col_collection',function(){
        if($(this).val()=='')
            return false;
        if($('#bulk_action_col_collection').val()=='delete_all')
            var result = confirm(confirm_delete_all_collection);
        else
            var result = confirm(confirm_duplicate_all_collection);
        if(!result)
        {
            $(this).val('');
            return false;
        } 
        $('body').addClass('lc_loading');
        var formData = new FormData($(this).parents('form').get(0));
        formData.append('submitBulkActionCollection', 1);
        $.ajax({
            url: '',
            data: formData,
            type: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(json){
                $('body').removeClass('lc_loading');
                if(json.success)
                {
                    $.growl.notice({ message: json.success }); 
                    location.reload();
                }
                if(json.errors)
                    $.growl.error({message:json.errors});
            },
            error: function(xhr, status, error)
            {
                $('body').removeClass('lc_loading');
                var err = eval("(" + xhr.responseText + ")");     
                alert(err.Message);               
            }
        });
    });
    $(document).on("keypress", 'form input', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });
    if($('#list-col_collection').length)
    {
        var $myCollection = $("#list-col_collection");
    	$myCollection.sortable({
    		opacity: 0.6,
            handle: ".dragHandle",
    		update: function() {
    			var order = $(this).sortable("serialize") + "&action=updateCollectionOrdering";						
                $.ajax({
        			type: 'POST',
        			headers: { "cache-control": "no-cache" },
        			url: '',
        			async: true,
        			cache: false,
        			dataType : "json",
        			data:order,
        			success: function(jsonData)
        			{
                        if(jsonData.success)
                        {
                            $.growl.notice({ message: jsonData.success });
                            var i=1;
                            $('.dragGroup span').each(function(){
                                $(this).html(i+(jsonData.page-1)*20);
                                i++;
                            });
                        }
                        if(jsonData.errors)
                        {
                            $.growl.error({message:jsonData.errors});
                            $myCollection.sortable("cancel");
                        }
                    }
        		});
    		},
        	stop: function( event, ui ) {
       		}
    	});
    }
});
function ets_col_displayBulkActionCollection(){
    if($('.col_collection_readed:checked').length )
    {
        $('#bulk_action_col_collection').show();
    }
    else
    {
        $('#bulk_action_col_collection').hide();
    }
}
function ets_col_readCollectionImageURL(input)
{
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if($(input).parents('.ets_col_upload_img').find('.collection_image').length <= 0)
            {
                $(input).parents('.ets_col_upload_img').prepend('<div class="collection_image"><img class="ets_col_collection_image" src="'+e.target.result+'" width="160px"><a class="btn btn-default delete_collection_image" href="" title="'+Delete_text+'"><i class="icon-trash"></i></a></div>');
            }
            else
            {
                $(input).parents('.ets_col_upload_img').find('.collection_image .ets_col_collection_image').attr('src',e.target.result);
            }
            $(input).parent().find('.uploaded_img_wrapper').hide();                          
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function ets_col_addProductCollection(element)
{
    var id_product = $(element).data('id');
    if(!$('#list_selected_products .product-item[data-id="'+id_product+'"]').length)
    {
        if($('#list_selected_products .no_selected_product').length)
        {
            $('#list_selected_products .no_selected_product').hide();
        }
        var $html = '<div id="products-'+id_product+'" class="product-item" data-id="'+id_product+'">';
        $html +='<input type="hidden" name="selected_products[]" value="'+id_product+'" />';
        $html +='<div class="product-content"><div class="col-product-sortable" title="'+Move_text+'">'+Move_text+'</div>'+$(element).prev('.product-content').html()+'</div>';
        $html +='<button class="btn btn-default action btn-action-delete-product" data-id="'+id_product+'" title="'+Delete_product_text+'">'+Delete_text+'</button>';
        $html += '</div>';
        $('#list_selected_products').append($html);
        $('#list_selected_products').sortable({ 
    		opacity: 0.6,
            handle: ".col-product-sortable",
            cursor: 'move',
    		update: function() {	
    		},
        	stop: function( event, ui ) {
       		}
    	});
    }
    $(element).parent().remove();
    var total_product = $('.block_product_no_selected .product-item').length;
    if(total_product <=5)
        ets_col_loadmoreProducts();
    var total_product_selected = $('.block_product_selected .product-item').length;
    $('.block_product_no_selected .panel-heading .badge').html(total_product+' '+(total_product >1 ? products_text : product_text));
    $('.block_product_selected .panel-heading .badge').html(total_product_selected+' '+(total_product_selected >1 ? products_text : product_text));
    if(total_product==0 && $('.block_product_no_selected .load_more').length==0)
        $('.block_product_no_selected .alert-warning.no_product').show();
}
function ets_col_deleteProductCollection(element)
{
    var id_product = $(element).data('id');
    if($('.btn-action-add-product[data-id="'+id_product+'"]').length)
    {
        $('.btn-action-add-product[data-id="'+id_product+'"]').show();
        $(element).parent().remove();
    }
    else{
        var $html = '<div class="product-item">';
        $html +='<div class="product-content">'+$(element).prev('.product-content').html()+'</div>';
        $html +='<button class="btn btn-default action btn-action-add-product" data-id="'+id_product+'" title="'+Add_text+'">'+Add_text+'</button>';
        $html += '</div>';
        $('.block_product_no_selected .product-wrapper').append($html);
        $('.block_product_no_selected .product-wrapper .col-product-sortable').remove();
        $(element).parent().remove();
        $('.block_product_no_selected .alert-warning.no_product').hide();
    }
    if(!$('#list_selected_products .product-item').length)
    {
        $('#list_selected_products .no_selected_product').show();
    }
    var total_product = $('.block_product_no_selected .product-item').length;
    var total_product_selected = $('.block_product_selected .product-item').length;
    $('.block_product_no_selected .panel-heading .badge').html(total_product+' '+(total_product >1 ? products_text : product_text));
    $('.block_product_selected .panel-heading .badge').html(total_product_selected+' '+(total_product_selected >1 ? products_text : product_text));
}
function ets_col_loadmoreProducts()
{
    if($('.block_product_no_selected .load_more.hide').length)
    {
        var page = parseInt($('.block_product_no_selected .load_more.hide').data('page'))+1;
        $('.block_product_no_selected .load_more.hide').removeClass('hide');
        $.ajax({
            url: '',
            data: $('#list_selected_products :input').serialize()+'&id_collection='+$('#id_collection').val()+'&submitSearchProductConllection=1&'+$('.block_search :input').serialize()+'&page='+page+'&totalProductInList='+$('.block_product_no_selected .product-item').length,
            type: 'post',
            dataType: 'json',                
            success: function(json){ 
                $('.block_product_no_selected .load_more').remove();
                if(json.products)
                {
                    $(json.products).each(function(){
                        var $html = '<div class="product-item">';
                            $html +='<div class="product-content">';
                                 $html +='<div class="image">';
                                    $html +='<img src="'+this.image+'">';
                                 $html +='</div>';   
                                 $html +='<div class="">';
                                    $html +='<div class="product-name"><a href="'+this.link+'" target="_blank"> '+this.name+'</a></div>';
                                    $html +='<div class="product-ref">'+this.reference+'</div>';
                                    $html +='<div class="product-price">'+this.price+'</div>';
                                 $html +='</div>';
                            $html += '</div>';
                            $html +='<button title="'+Add_text+'" class="btn btn-default action btn-action-add-product" data-id="'+this.id_product+'" '+($('#list_selected_products .product-item[data-id="'+this.id_product+'"]').length ? ' style="display:none"':'')+'>'+Add_text+'</button>';
                        $html += '</div>';
                        if($('.block_product_no_selected .product-wrapper .btn-action-add-product[data-id="'+this.id_product+'"]').length==0 && $('#list_selected_products .product-item[data-id="'+this.id_product+'"]').length==0)
                            $('.block_product_no_selected .product-wrapper').append($html);
                    });
                }
                if(json.load_more)
                     $('.block_product_no_selected .product-wrapper').append('<div class="load_more hide" data-page="'+json.load_more+'">'+Load_more_text+'</div>');   
                var total_product = $('.block_product_no_selected .product-item').length;
                var total_product_selected = $('.block_product_selected .product-item').length;
                $('.block_product_no_selected .panel-heading .badge').html(total_product+' '+(total_product >1 ? products_text : product_text));
                $('.block_product_selected .panel-heading .badge').html(total_product_selected+' '+(total_product_selected >1 ? products_text : product_text));    
                if(total_product==0)
                    $('.block_product_no_selected .alert-warning.no_product').show();   
                else
                   $('.block_product_no_selected .alert-warning.no_product').hide();                     
            },
            error: function(error)
            {                                      
            }
        });
    }
}
function ets_col_searchProducts()
{
    if(ajax_search)
            ajax_search.abort();
    ajax_search = $.ajax({
        url: '',
        data: $('#list_selected_products :input').serialize()+'&id_collection='+$('#id_collection').val()+'&submitSearchProductConllection=1&'+$('.block_search :input').serialize(),
        type: 'post',
        dataType: 'json',                
        success: function(json){  
            $('.block_product_no_selected .product-wrapper').html('');
            if(json.products)
            {
                $(json.products).each(function(){
                    var $html = '<div class="product-item">';
                        $html +='<div class="product-content">';
                             $html +='<div class="image ssu">';
                                $html +='<img src="'+this.image+'">';
                             $html +='</div>';   
                             $html +='<div class="">';
                                $html +='<div class="product-name"><a href="'+this.link+'" target="_blank"> '+this.name+'</a></div>';
                                $html +='<div class="product-ref">'+this.reference+'</div>';
                                $html +='<div class="product-price">'+this.price+'</div>';
                             $html +='</div>';
                        $html += '</div>';
                        $html +='<button title="'+Add_text+'" class="btn btn-default action btn-action-add-product" data-id="'+this.id_product+'" '+($('#list_selected_products .product-item[data-id="'+this.id_product+'"]').length ? ' style="display:none"':'')+'>'+Add_text+'</button>';
                    $html += '</div>';
                    $('.block_product_no_selected .product-wrapper').append($html);
                });
            }
            else
                $('.block_product_no_selected .product-wrapper').html('<div class="alert alert-warning no_product">'+no_product_in_collection+'</div>');
            if(json.load_more)
                $('.block_product_no_selected .product-wrapper').append('<div class="load_more hide" data-page="'+json.load_more+'">'+Load_more_text+'</div>');   
            var total_product = $('.block_product_no_selected .product-item').length;
            var total_product_selected = $('.block_product_selected .product-item').length;
            $('.block_product_no_selected .panel-heading .badge').html(total_product+' '+(total_product >1 ? products_text : product_text));
            $('.block_product_selected .panel-heading .badge').html(total_product_selected+' '+(total_product_selected >1 ? products_text : product_text));   
            if(total_product==0)
                $('.block_product_no_selected .no_product').show();
            else
                $('.block_product_no_selected .no_product').hide();                        
        },
        error: function(error)
        {                                      
        }
    });
}
function ets_col_close_alert()
{
    $('.module_confirmation.alert.alert-success').parent('.bootstrap').remove();
    $('.module_error.alert').parent('.bootstrap').remove();
}
function ets_col_change_range($range)
{
    if($range.val()<=1){
        $range.next('.range_new').next('.input-group-unit').html($range.val());   
    }
    else
    {
        $range.next('.range_new').next('.input-group-unit').html($range.val());
    }
    var newPoint = ($range.val() - $range.attr("min")) / ($range.attr("max") - $range.attr("min"));
    var offset = -1;
    var  percent = ( $range.val() / $range.attr("max") )*100;
    
    $range.next('.range_new').find('.range_new_run').css({width: percent+'%'});
    $range.next('.range_new').next('.input-group-unit').css({left: percent+'%'});
    /**/
    var range = $range,value = range.next().next('.input-group-unit');
    var max = range.attr('max');
    var min = range.attr('min');
    var beginvalue = range.value;
    //range.next('.range_new').find('.range_new_run').css('width', percent + '%');
    range.on('input', function(){
      value.html(this.value);
      var current_value = this.value;
      var max = range.attr('max'),
                    min = range.attr('min'),
                    percent = (current_value / max) * 100;
      range.next('.range_new').find('.range_new_run').css('width', percent + '%');
      range.next('.range_new').next('.input-group-unit').css({left: percent+'%'});
    });
    /**/
}
function ets_col_displayFormConfig()
{
    if($('input[name="ETS_COL_DISPLAY_LIST_HOME_PAGE"]').length)
    {
        if($('input[name="ETS_COL_DISPLAY_LIST_HOME_PAGE"]:checked').val()==1)
        {
            $('.form-group.col_display_home_page').show();
        }
        else
        {
            $('.form-group.col_display_home_page').hide();
        }
    }
}