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

$(document).ready(function() {
    $('input[name="product-quantity-spin"]').each(function(){
        if (typeof tf_prime_pro_product_id !== 'undefined') {
            if ($(this).attr('data-product-id') == tf_prime_pro_product_id) {
                $(this).attr('disabled', 'disabled');
                $(this).parent('.bootstrap-touchspin').find('.input-group-btn-vertical').remove();
            }
        }
    });
});
