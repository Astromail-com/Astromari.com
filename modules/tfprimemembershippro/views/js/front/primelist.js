/**
* 2008-2022 Prestaworld
*
* NOTICE OF LICENSE
*
* The source code of this module is under a commercial license.
* Each license is unique and can be installed and used on only one website.
* Any reproduction or representation total or partial of the module, one or more of its components,
* by any means whatsoever, without express permission from us is prohibited.
*
* DISCLAIMER
*
* Do not alter or add/update to this file if you wish to upgrade this module to newer
* versions in the future.
*
* @author    prestaworld
* @copyright 2008-2022 Prestaworld
* @license https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
* International Registered Trademark & Property of prestaworld
*/

$(document).ready(function(){
    $(document).on('click', '#presta_features', function(){
        var plan_img = $(this).attr('data-plan-img');
        var plan_name = $(this).attr('data-name');
        var plan_features = $(this).attr('data-features').split(",");
        var plan_duration = $(this).attr('data-duration');
        var plan_type = $(this).attr('data-plan-type');
        var plan_price = $(this).attr('data-plan-price');
        var plan_purchase_url = $(this).attr('data-purchase-url');
        $('.presta-modal-plan-img').empty();
        $('.presta-modal-plan-img').append('<img src="'+plan_img+'" width="150" height="159"/>');
        $('.presta-plan-name').text(plan_name);
        $('.presta-prime-features').empty();
        if (plan_duration == 1) {
            $('#presta_duration').text(plan_duration+' '+plan_type);
        } else {
            $('#presta_duration').text(plan_duration+' '+plan_type+'(s)');
        }
        $('#presta_price').text(plan_price);
        var count = 0;
        $.each(plan_features,function(i){
            $('.presta-prime-features').append('<li>'+plan_features[i]+'</li>');
            count++;
         });
        $('.presta-features-count').text(count);
        $('.presta-modal-purchase-btn').attr("href", plan_purchase_url);
        $('#prestaModal').modal();
    });
});
