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
$(document).ready(function(){
   $(document).on('click','.block-list-collecion-products .paggination a',function(e){
        e.preventDefault();
        var url_ajax = $(this).attr('href');
        $('body').addClass('loading');
        $.ajax({
            url: url_ajax,
            data: {
                ajax:1,
                product_search : $('input[name="product_search"]').val(),
            },
            type: 'post',
            dataType: 'json',                
            success: function(json){    
                $('.block-list-collecion-products').html(json.product_list);  
                $('.ets_col_block-search').removeClass('loading');  
                $('body').removeClass('loading');                       
            },
            error: function(error)
            {  
                $('.ets_col_block-search').removeClass('loading');  
                $('body').removeClass('loading');  
            }
        });
   }); 
   $(document).on('keyup','.ets_col_collection_main_detail  input[name="product_search"]',function(e){
        if(e.keyCode==13)
        {
            $('.ets_col_block-search').addClass('loading');
            $.ajax({
                url: '',
                data: {
                    ajax:1,
                    product_search : $('input[name="product_search"]').val(),
                },
                type: 'post',
                dataType: 'json',                
                success: function(json){ 
                    if($('input[name="product_search"]').val()!='')
                        $('input[name="product_search"]').next('i').addClass('loaded');
                    else    
                        $('input[name="product_search"]').next('i').removeClass('loaded');
                    $('.block-list-collecion-products').html(json.product_list);   
                    $('.ets_col_block-search').removeClass('loading');            
                },
                error: function(error)
                {   
                    $('.ets_col_block-search').removeClass('loading');  
                }
            });
        }
   }); 
   $(document).on('click','.ets_col_block-search i.loaded',function(e){
        $('input[name="product_search"]').next('i').removeClass('loaded');
        $('input[name="product_search"]').val('');
        $('.ets_col_block-search').addClass('loading');
        $.ajax({
            url: '',
            data: {
                ajax:1,
                product_search : $('input[name="product_search"]').val(),
            },
            type: 'post',
            dataType: 'json',                
            success: function(json){    
                $('.block-list-collecion-products').html(json.product_list);        
                $('.ets_col_block-search').removeClass('loading');         
            },
            error: function(error)
            {    
                $('.ets_col_block-search').removeClass('loading'); 
            }
        });
   });
   $(document).on('click','.load_more_collections',function(e){
        e.preventDefault();
        var page = $(this).data('page');
        $.ajax({
            url: '',
            data: {
                next_page:page,
                submitLoadmoreCollections : 1,
            },
            type: 'post',
            dataType: 'json',                
            success: function(json){    
                $('.load_more_collections').remove();
                $('.block-collections_left ul').append(json.list_collections);                      
            },
            error: function(error)
            {      
            }
        });
   });
   
});