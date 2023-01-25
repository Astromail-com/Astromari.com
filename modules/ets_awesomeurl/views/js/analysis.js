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
 
var etsAWU = {
    activeControllers: [
        'AdminCmsContent',
        'AdminMeta',
        'AdminCategories',
        'AdminManufacturers',
        'AdminSuppliers',
        'AdminProducts'],
    checkInputMetaTemplate: function (id_lang) {
        var prefix = etsAWU.prefixInput();

        if($(prefix.meta_title+id_lang).length){
            if($(prefix.meta_title+id_lang).parent().find('.ETS_AWU_tmp_input').length)
                $(prefix.meta_title+id_lang).closest('.form-group').addClass('disable_codeseo');
            else
                $(prefix.meta_title+id_lang).closest('.form-group').removeClass('disable_codeseo');
        }
        if($(prefix.meta_desc+id_lang).length){
            if($(prefix.meta_desc+id_lang).parent().find('.ETS_AWU_tmp_input').length)
                $(prefix.meta_desc+id_lang).closest('.form-group').addClass('disable_codeseo');
            else
                $(prefix.meta_desc+id_lang).closest('.form-group').removeClass('disable_codeseo');
        }
        if($('#ETS_AWU_meta_title_'+id_lang).length){
            if($('#ETS_AWU_meta_title_'+id_lang).parent().find('.ETS_AWU_tmp_input').length)
                $('#ETS_AWU_meta_title_'+id_lang).closest('.form-group').addClass('disable_codeseo');
            else
                $('#ETS_AWU_meta_title_'+id_lang).closest('.form-group').removeClass('disable_codeseo');
        }
        if($('#ETS_AWU_meta_description_'+id_lang).length){
            if($('#ETS_AWU_meta_description_'+id_lang).parent().find('.ETS_AWU_tmp_input').length)
                $('#ETS_AWU_meta_description_'+id_lang).closest('.form-group').addClass('disable_codeseo');
            else
                $('#ETS_AWU_meta_description_'+id_lang).closest('.form-group').removeClass('disable_codeseo');
        }
    },
    prefixInput: function () {
        var prefix = {
            meta_title: '',
            meta_desc: '',
            link_rewrite: '',
            content: '',
            title: '',
            short_desc: '',
            price: '',
            category: ''

        };
        if (ETS_AWU_CONTROLLER == 'AdminProducts') {
            prefix.meta_title = '#form_step5_meta_title_';
            prefix.title = '#form_step1_name_';
            prefix.meta_desc = '#form_step5_meta_description_';
            prefix.link_rewrite = '#form_step5_link_rewrite_';
            prefix.content = '#form_step1_description_';
            prefix.short_desc = '#form_step1_description_short_';
            prefix.price = '#form_step2_price_ttc';
            prefix.category = 'input[name="ignore"][class="default-category"]';
        } else if (ETS_AWU_CONTROLLER == 'AdminCmsContent') {
            if (ETS_AWU_IS_CMS_CATEGORY) {
                prefix.meta_title = ETS_AWU_DEFINED.is176 ? '#cms_page_category_meta_title_' : '#meta_title_';
                prefix.meta_desc = ETS_AWU_DEFINED.is176 ? '#cms_page_category_meta_description_' : '#meta_description_';
                prefix.link_rewrite = ETS_AWU_DEFINED.is176 ? '#cms_page_category_friendly_url_' : '#link_rewrite_';
                prefix.content = ETS_AWU_DEFINED.is176 ? '#cms_page_category_description_' : '#description_';
                prefix.short_desc = ETS_AWU_DEFINED.is176 ? '#cms_page_category_description_' : '#description_';
                prefix.title = ETS_AWU_DEFINED.is176 ? '#cms_page_category_name_' : '#name_';
            } else {
                prefix.meta_title = ETS_AWU_DEFINED.is176 ? '#cms_page_meta_title_' : '#head_seo_title_';
                prefix.meta_desc = ETS_AWU_DEFINED.is176 ? '#cms_page_meta_description_' : '#meta_description_';
                prefix.link_rewrite = ETS_AWU_DEFINED.is176 ? '#cms_page_friendly_url_' : '#link_rewrite_';
                prefix.content = ETS_AWU_DEFINED.is176 ? '#cms_page_content_' : '#content_';
                prefix.title = ETS_AWU_DEFINED.is176 ? '#cms_page_title_' : '#name_';
                prefix.category = ETS_AWU_DEFINED.is176 ? 'input[name="cms_page[page_category_id]"]' : 'select[name="id_cms_category"]';
            }

        } else if (ETS_AWU_CONTROLLER == 'AdminMeta') {

            prefix.meta_title = ETS_AWU_DEFINED.is176 ? '#meta_page_title_' : '#title_';
            prefix.title = ETS_AWU_DEFINED.is176 ? '#meta_page_title_' : '#title_';
            prefix.meta_desc = ETS_AWU_DEFINED.is176 ? '#meta_meta_description_' : '#description_';
            prefix.short_desc = ETS_AWU_DEFINED.is176 ? '' : '';
            prefix.link_rewrite = ETS_AWU_DEFINED.is176 ? '#meta_url_rewrite_' : '#url_rewrite_';
            prefix.content = ETS_AWU_DEFINED.is176 ? '' : '';
        } else if (ETS_AWU_CONTROLLER == 'AdminCategories') {
            if ($('form[name=root_category]').length) {
                prefix.title = ETS_AWU_DEFINED.is176 ? '#root_category_name_' : '#name_';
                prefix.meta_title = ETS_AWU_DEFINED.is176 ? '#root_category_meta_title_' : '#meta_title_';
                prefix.meta_desc = ETS_AWU_DEFINED.is176 ? '#root_category_meta_description_' : '#meta_description_';
                prefix.link_rewrite = ETS_AWU_DEFINED.is176 ? '#root_category_link_rewrite_' : '#link_rewrite_';
                prefix.content = ETS_AWU_DEFINED.is176 ? '#root_category_description_' : '#description_';
                prefix.short_desc = ETS_AWU_DEFINED.is176 ? '#root_category_description_' : '#description_';
            } else {
                prefix.title = ETS_AWU_DEFINED.is176 ? '#category_name_' : '#name_';
                prefix.meta_title = ETS_AWU_DEFINED.is176 ? '#category_meta_title_' : '#meta_title_';
                prefix.meta_desc = ETS_AWU_DEFINED.is176 ? '#category_meta_description_' : '#meta_description_';
                prefix.link_rewrite = ETS_AWU_DEFINED.is176 ? '#category_link_rewrite_' : '#link_rewrite_';
                prefix.content = ETS_AWU_DEFINED.is176 ? '#category_description_' : '#description_';
                prefix.short_desc = ETS_AWU_DEFINED.is176 ? '#category_description_' : '#description_';
            }

        } else if (ETS_AWU_CONTROLLER == 'AdminManufacturers') {

            prefix.title = ETS_AWU_DEFINED.is176 ? '#manufacturer_name_' : '#name_';
            prefix.meta_title = ETS_AWU_DEFINED.is176 ? '#manufacturer_meta_title_' : '#meta_title_';
            prefix.meta_desc = ETS_AWU_DEFINED.is176 ? '#manufacturer_meta_description_' : '#meta_description_';
            prefix.link_rewrite = ETS_AWU_DEFINED.is176 ? '#manufacturer_link_rewrite_' : '#link_rewrite_';
            prefix.content = ETS_AWU_DEFINED.is176 ? '#manufacturer_description_' : '#description_';
            prefix.short_desc = ETS_AWU_DEFINED.is176 ? '#manufacturer_short_description_' : '#short_description_';
        } else if (ETS_AWU_CONTROLLER == 'AdminSuppliers') {

            prefix.title = ETS_AWU_DEFINED.isSf ? '#supplier_name_' : '#name_';
            prefix.meta_title = ETS_AWU_DEFINED.isSf ? '#supplier_meta_title_' : '#meta_title_';
            prefix.meta_desc = ETS_AWU_DEFINED.isSf ? '#supplier_meta_description_' : '#meta_description_';
            prefix.link_rewrite = ETS_AWU_DEFINED.isSf ? '#link_rewrite_' : '#link_rewrite_';
            prefix.content = ETS_AWU_DEFINED.isSf ? '#supplier_description_' : '#description_';
            prefix.short_desc = ETS_AWU_DEFINED.isSf ? '#supplier_description_' : '#description_';
        }

        return prefix;
    },
}
$(document).ready(function(){
   $(document).on('click', '.translatable-field ul.dropdown-menu>li>a', function () {
        if ($('.ets_seotop1_step_seo').length) {
            var id_lang = $(this).attr('href').replace(/javascript:hideOtherLanguage\(|\);/g, '');

            $('.ets_seotop1_step_seo .multilang-field.lang-' + id_lang).removeClass('hide');
            $('.ets_seotop1_step_seo .multilang-field:not(.lang-' + id_lang + ')').addClass('hide');

            ETS_AWU_LANG_ID_ACTIVE = id_lang;
            etsAWU.checkInputMetaTemplate(id_lang);
        }
    });

    $(document).on('click', '.js-ets-seo-btn-group-lang a', function () {

        var id_lang = $(this).attr('href').replace(/javascript:hideOtherLanguage\(|\);/g, '');

        $('.ets_seotop1_step_seo .multilang-field.lang-' + id_lang).removeClass('hide');
        $('.ets_seotop1_step_seo .multilang-field:not(.lang-' + id_lang + ')').addClass('hide');

        ETS_AWU_LANG_ID_ACTIVE = id_lang;
        etsAWU.checkInputMetaTemplate(id_lang);
    }); 
    $(document).on('change', '.ets_awu_advanced_select2', function () {
        var data = $(this).val();
        $(this).parent().find('.ets-seo-select2-value').val(data.toString());
    });
    $(document).on('click', '.locale-input-group .js-locale-item', function () {
        var id_lang = ETS_AWU_LANGUAGES[$(this).attr('data-locale')];
        if ($('#form_switch_language').length) {
            var locale = $(this).attr('data-locale');
            $('#form_switch_language option[value="' + locale + '"]').prop('selected', true);
            $('#form_switch_language').change();
            $('.js-locale-btn').html(locale);
            ETS_AWU_LANG_ID_ACTIVE = id_lang;
            etsAWU.checkInputMetaTemplate(id_lang);
            return;
        }
        if (etsAWU.activeControllers.indexOf(ETS_AWU_CONTROLLER) !== -1) {
            $('.ets_seotop1_step_seo .multilang-field.lang-' + id_lang).removeClass('hide');
            $('.ets_seotop1_step_seo .multilang-field:not(.lang-' + id_lang + ')').addClass('hide');

            ETS_AWU_LANG_ID_ACTIVE = id_lang;
            etsAWU.checkInputMetaTemplate(id_lang);
        }
    });
});