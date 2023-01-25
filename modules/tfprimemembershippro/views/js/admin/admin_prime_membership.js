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
    $("#tf_prime_img").change(function(){
        readURL(this);
	});

	if ($('input[name="TF_PRIME_PRODUCT_COMPARISON"]:checked').val() == 1) {
		$('.presta_plan_comparison').show('slow');
	} else {
		$('.presta_plan_comparison').hide('slow');
	}

	$(document).on('change', 'input[name="TF_PRIME_PRODUCT_COMPARISON"]', function(){
		if ($(this).val() == 1) {
			$('.presta_plan_comparison').show('slow');
		} else {
			$('.presta_plan_comparison').hide('slow');
		}
	});

	if ($('input[name="TF_PRIME_PRO_EMAIL_ADMIN"]:checked').val() == 1) {
		$('.presta_prime_admin_mail').show('slow');
	} else {
		$('.presta_prime_admin_mail').hide('slow');
	}

	$(document).on('change', 'input[name="TF_PRIME_PRO_EMAIL_ADMIN"]', function(){
		if ($(this).val() == 1) {
			$('.presta_prime_admin_mail').show('slow');
		} else {
			$('.presta_prime_admin_mail').hide('slow');
		}
	});

	if ($('input[name="TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER"]:checked').val() == 1) {
		$('.presta_prime_warning_mail').show('slow');
	} else {
		$('.presta_prime_warning_mail').hide('slow');
	}

	$(document).on('change', 'input[name="TF_PRIME_PRO_EMAIL_WARNING_CUSTOMER"]', function(){
		if ($(this).val() == 1) {
			$('.presta_prime_warning_mail').show('slow');
		} else {
			$('.presta_prime_warning_mail').hide('slow');
		}
	});

	if ($('input[name="TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER"]:checked').val() == 1) {
		$('.presta_prime_warning_display').show('slow');
	} else {
		$('.presta_prime_warning_display').hide('slow');
	}

	$(document).on('change', 'input[name="TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER"]', function(){
		if ($(this).val() == 1) {
			$('.presta_prime_warning_display').show('slow');
		} else {
			$('.presta_prime_warning_display').hide('slow');
		}
	});

	if ($('input[name="TF_PRIME_PRO_MEMBERSHIP_APPROVAL"]:checked').val() == 1) {
		$('.presta_prime_order_status').hide('slow');
	} else {
		$('.presta_prime_order_status').show('slow');
	}

	$(document).on('change', 'input[name="TF_PRIME_PRO_MEMBERSHIP_APPROVAL"]', function(){
		if ($(this).val() == 1) {
			$('.presta_prime_order_status').hide('slow');
		} else {
			$('.presta_prime_order_status').show('slow');
		}
	});

	$(document).on('change', 'input[name="TF_PRIME_PRO_ADVERTISEMENT"]', function(){
		if ($(this).val() == 1) {
			$('.presta_cms').show('slow');
		} else {
			$('.presta_cms').hide('slow');
		}
	});

	if ($('input[name="TF_PRIME_PRO_ADVERTISEMENT"]:checked').val() == 1) {
		$('.presta_cms').show('slow');
	} else {
		$('.presta_cms').hide('slow');
	}

	$(document).on('change', 'input[name="TF_PRIME_PRO_REDIRECT_LIST"]', function(){
		if ($(this).val() != 1) {
			$('.presta_cms_page').show('slow');
		} else {
			$('.presta_cms_page').hide('slow');
		}
	});

	if ($('input[name="TF_PRIME_PRO_REDIRECT_LIST"]:checked').val() != 1) {
		$('.presta_cms_page').show('slow');
	} else {
		$('.presta_cms_page').hide('slow');
	}

    $('select#presta_lang').on('change', function(){
        var idLang = $(this).val();
        // alert(idLang);
        $('.presta_multilang_text_field_all').hide();
        $('.presta_multilang_text_field_'+idLang).show();
    });
    // $(".presta_tax_rule").select2();
});

function readURL(input) {
	if (input.files && input.files[0]) {
		var file = input.files[0];
		var fileType = file["type"];
		var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
		if ($.inArray(fileType, validImageTypes) < 0) {
			document.getElementById("tf_prime_img").value = "";
			$('div.tf_img_preview img').attr('src', '');
			$('.tf_img_preview').hide();
			alert(imgError);
			return false;
		}

		var reader = new FileReader();

		reader.onload = function (e) {
			$('div.tf_img_preview img').attr('src', e.target.result);
			$('.tf_img_preview').show();
			$('.tf_prime_img_list').hide();
		}

		reader.readAsDataURL(input.files[0]);
	}
}


//for multilang fields
function showLangField(lang_iso_code, id_lang)
{
	$('.presta_caret').html(lang_iso_code + ' <span class="caret" style="margin-left:5px;"></span>');

	$('.presta_main_div').hide();
	$('.presta_current_div_'+id_lang).show();
}
