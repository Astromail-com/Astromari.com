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
 *  @author ETS-Soft <contact@etssoft.net>
 *  @copyright  2007-2022 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
$(document).ready(function(){

   $(".ets_ws_product_price").hover(function(){
        if ( $(this).find('.product-description').length > 0 ){
            var des_height = $(this).find('.product-description').height();
            $(this).find('.highlighted-informations').css("bottom", des_height);
        }
   }, function(){
      $('.highlighted-informations').css('bottom', '');
   });
    $(document).on({
        mouseenter: function () {
            if ( $(this).find('.product-description').length > 0 && $(this).find('.bottom_calculated').length <= 0 ){
                var des_height = $(this).find('.product-description').height();
                if ( $(this).find('.product-list-reviews').length > 0){
                    var review_height = $(this).find('.product-list-reviews').height();
                } else {
                    var review_height = 0;
                }
                
                $(this).find('.highlighted-informations').css("bottom", des_height + review_height).addClass('bottom_calculated');
            }
        }
    }, ".product-miniature");
   $(window).resize(function(e){
        $('.highlighted-informations').removeClass('bottom_calculated');
   });
});


