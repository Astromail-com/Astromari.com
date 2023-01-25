/**
 * 2007-2023 ETS-Soft
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
 *  @copyright  2007-2023 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
$(document).on('click','.ets-mod-cats > li',function(){
    if(!$(this).hasClass('active'))
    {
        $('.ets-mod-cats > li').removeClass('active');
        $(this).addClass('active');
        $('.ets-mod-list > li').addClass('hidden');
        $('.ets-mod-list > li.cat-'+$(this).attr('data-id')).removeClass('hidden');
        var cattext = $(this).html();
        $('.ets-mod-cats_mobile h4').html(cattext);
        $(this).parent('.ets-mod-cats').removeClass('active');
    }
});
$(document).on('click','.ets-mod-cats_mobile h4',function(){
    $('.ets-mod-cats').toggleClass('active');
});
$(document).ready(function(){
    $(document).keyup(function(e) {
         if (e.key === "Escape") {
            $('.ets-mod').addClass('hidden');
            $('body').removeClass('other-modules-loaded');
        }
    });

});
function stickytableft(){
    var sticky_navigation_offset_top = $('.ets-body').offset().top;
    var sticky_navigation = function(){
        var scroll_top = $('.ets-mod').scrollTop();
        var tab_width = $('.ets-mod-cats').width();
        $('.ets-mod-cats').width(tab_width);
        if (scroll_top > sticky_navigation_offset_top) {
            $('.ets-mod-left').addClass('scroll_heading');
        } else {
            $('.ets-mod-left').removeClass('scroll_heading');
        }
    };
    sticky_navigation();
    $('.ets-mod').scroll(function() {
        sticky_navigation();
    });
}