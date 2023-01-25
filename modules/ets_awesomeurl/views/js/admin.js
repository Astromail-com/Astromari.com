/**
 * 2007-2022 ETS-Soft
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
 *  @copyright  2007-2022 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

var etsAwuAdmin = {
    changeDescRewriteRule: function ($this) {
        if(ETS_AWU_LINK_REWRITE_RULES)
        {
            Object.keys(ETS_AWU_LINK_REWRITE_RULES).forEach(function(key){
                var desc = parseInt($this.val()) == 1 ? ETS_AWU_LINK_REWRITE_RULES[key]['desc_new_rule'] : ETS_AWU_LINK_REWRITE_RULES[key]['desc_rule'];
                if(ETS_AWU_IS_SF)
                {
                    $('#meta_settings_form_url_schema_'+key).closest('.form-group').find('.form-text').html(desc);
                }
                else{
                    $('input[name="PS_ROUTE_'+key+'"]').closest('.form-group').find('.help-block').html(desc);
                }
            });

        }
    },
    onChangeSitemapOptions: function(){
        var count = 0;
        var input = $('input[name="ETS_AWU_SITEMAP_OPTION[]"]');
        input.each(function(){
            if($(this).is(':checked') && $(this).val() != 'all'){
                count++;
            }
        });
        if(count == (input.length - 1)){
            //input.prop('disabled', true);
            $('input[name="ETS_AWU_SITEMAP_OPTION[]"][value="all"]').prop('checked', true);
            //$('input[name="ETS_AWU_SITEMAP_OPTION[]"][value="all"]').prop('disabled', false);

        }
        else{
            $('input[name="ETS_AWU_SITEMAP_OPTION[]"][value="all"]').prop('checked', false);
        }
    },
};
$(document).ready(function () {
    $(document).on('change', 'input[name=ETS_AWU_ENABLE_REMOVE_ID_IN_URL]', function(){
        etsAwuAdmin.changeDescRewriteRule($(this));
        if(typeof ETS_AWU_LINK_REWRITE_RULES === 'undefined'){
            return false;
        }
        var inputRuleDefine = {};
        console.log('..........');
        console.log(ETS_AWU_IS_SF);
        if(ETS_AWU_IS_SF)
        {
            inputRuleDefine = {
                product: $('#meta_settings_url_schema_form_product_rule').length ?  $('#meta_settings_url_schema_form_product_rule') :  $('#meta_settings_form_url_schema_product_rule'),
                category: $('#meta_settings_url_schema_form_category_rule').length ?  $('#meta_settings_url_schema_form_category_rule') :   $('#meta_settings_form_url_schema_category_rule'),
                layered: $('#meta_settings_form_url_schema_layered_rule').length ?  $('#meta_settings_form_url_schema_layered_rule') :   $('#meta_settings_form_url_schema_layered_rule'),
                supplier: $('#meta_settings_url_schema_form_supplier_rule').length ?  $('#meta_settings_url_schema_form_supplier_rule') :   $('#meta_settings_form_url_schema_supplier_rule'),
                manufacturer: $('#meta_settings_url_schema_form_manufacturer_rule').length ?  $('#meta_settings_url_schema_form_manufacturer_rule') :   $('#meta_settings_form_url_schema_manufacturer_rule'),
                cms: $('#meta_settings_url_schema_form_cms_rule').length ?  $('#meta_settings_url_schema_form_cms_rule') :   $('#meta_settings_form_url_schema_cms_rule'),
                cms_category: $('#meta_settings_url_schema_form_cms_category_rule').length ?  $('#meta_settings_url_schema_form_cms_category_rule') :   $('#meta_settings_form_url_schema_cms_category_rule'),
                module: $('#meta_settings_url_schema_form_module').length ?  $('#meta_settings_url_schema_form_module') :   $('#meta_settings_form_url_schema_module'),
            };
        }
        else{
            inputRuleDefine = {
                product: $('input[name=PS_ROUTE_product_rule]'),
                category: $('input[name=PS_ROUTE_category_rule]'),
                layered: $('input[name=PS_ROUTE_layered_rule]'),
                supplier: $('input[name=PS_ROUTE_supplier_rule]'),
                manufacturer: $('input[name=PS_ROUTE_manufacturer_rule]'),
                cms: $('input[name=PS_ROUTE_cms_rule]'),
                cms_category: $('input[name=PS_ROUTE_cms_category_rule]'),
                module: $('input[name=PS_ROUTE_module]'),
            };
        }
        if ($(this).val() == 1) {
            Object.keys(inputRuleDefine).forEach(function(key){
                var keyRule = key == 'module' ? key : key + '_rule';
                inputRuleDefine[key].val(ETS_AWU_LINK_REWRITE_RULES[keyRule].new_rule);
            });
        }
        else{
            Object.keys(inputRuleDefine).forEach(function(key){
                var keyRule = key == 'module' ? key : key + '_rule';
                inputRuleDefine[key].val(ETS_AWU_LINK_REWRITE_RULES[keyRule].rule);
                inputRuleDefine[key].val(ETS_AWU_LINK_REWRITE_RULES[keyRule].rule);
            });
        }
    });
    $(document).on('change', '.js-ets-seo-checkall', function(){
       var inputName = $(this).attr('name');
       if($(this).is(':checked'))
       {
           $('input[name="'+inputName+'"]').prop('checked', true);
       }
       else {
           $('input[name="'+inputName+'"]').prop('checked', false);
       }
    });
    $(document).on('click','#category-seo-setting-tab',function(){
        $('.form-group.row.type-custom_content ').hide();
    });
    $(document).on('click','#category-seo-content-tab',function(){
        $('.form-group.row.type-custom_content ').show();
    });
    etsAwuAdmin.onChangeSitemapOptions();
    $(document).on('change', 'input[name="ETS_AWU_SITEMAP_OPTION[]"]', function(){
        etsAwuAdmin.onChangeSitemapOptions();
    });
    $(document).on('click','.ets_seo_extra_tabs a.js-ets-seo-tab-customize',function(){
        var active_tab = $(this).attr('href');
        if ( active_tab == '#ets_seo_setting_tabs' ){
            $('.js-ets-seo-tab-content').removeClass('active');
            $('.js-ets-seo-tab-setting').addClass('active');
        }
        if ( active_tab == '#ets_seo_content_tabs' ){
            $('.js-ets-seo-tab-content').addClass('active');
            $('.js-ets-seo-tab-setting').removeClass('active');
        }
        $('.form-group.row.type-custom_content ').hide();
    });
    if ( IS16 == '1' || IS16 == true){
        $('body').addClass('pres_v16');
    }
});
$(window).on('load', function(){
    setTimeout(function(){
        if (jQuery().select2){

            $('.js-ets-seo-select2').select2();
        }
    }, 500);
});
