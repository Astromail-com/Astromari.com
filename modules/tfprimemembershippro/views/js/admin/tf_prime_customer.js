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
    if ($("#presta-datetimepicker1").length) {
        $("#presta-datetimepicker1").flatpickr({
            dateFormat: "Y-m-d H:i:s",
            enableTime: true,
            maxDate: currentDate
        });
    }

    var xhr = '';
    if ($('#tf_presta_customer').length) {
        $('#tf_presta_customer').multiselect({
            columns: 1,
            placeholder: 'Select Customer(s)',
            search: true,
            selectAll: true
        });
    }

    $(document).on('click', '.presta-load-more', function(){
        var lastCount = $('input[name="presta_customer_last_count"]').val();
        $('.presta_img_container img').show();
        $('.ms-options').addClass('presta_hold');
        $.ajax({
            url: current_controller,
            // type: 'post',
            cache: false,
            dataType: "json",
            data: {
                'ajax': true,
                'action': 'getMoreCustomers',
                'lastCount': lastCount
            },
            success: function(data) {
                $('.presta_img_container img').hide();
                $('.ms-options').removeClass('presta_hold');
                if (data.customers.length !== undefined) {
                    if (data.customers.length > 0) {
                        $('input[name="presta_customer_last_count"]').val(data.currentCount);
                        $.each(data.customers, function(index, value){
                            $('.ms-options ul').append('<li data-search-term="('+value.id_customer+') '+value.firstname+' '+value.lastname+' ('+value.email+')"><label for="ms-opt-20"><input type="checkbox" title="('+value.id_customer+') '+value.firstname+' '+value.lastname+' ('+value.email+')" id="ms-opt-20" value="'+value.id_customer+'">('+value.id_customer+') '+value.firstname+' '+value.lastname+' ('+value.email+')</label></li>');
                            $('#tf_presta_customer').append('<option value="'+value.id_customer+'">'+value.firstname+' '+value.lastname+' ('+value.email+')</option>');
                        });
                    } else {
                        alert(nomorecustomer);
                    }
                }
            }
        });
    });

});
