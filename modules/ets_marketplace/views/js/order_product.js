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
$(document).ready(function(){
    if($('body.adminorders').length >0 && $('.ets_mp_extra_product_order').length)
    {
        if($('.panel.kpi-container').length)
            $('.panel.kpi-container').after($('.ets_mp_extra_product_order').html());
        if($('#order-view-page').length)
            $('#order-view-page').before($('.ets_mp_extra_product_order').html())
        $('.ets_mp_extra_product_order').html('');
    }
    if($('body.adminproducts').length >0 && $('.ets_mp_extra_product_order').length)
    {
        $('form .product-header').before($('.ets_mp_extra_product_order').html());
        $('#content .bootstrap .page-head').after($('.ets_mp_extra_product_order').html());
        $('.ets_mp_extra_product_order').html('');
    }
    if($('#field-disabled').length)
        $('#field-disabled').removeAttr('disabled');
});