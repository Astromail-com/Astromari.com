/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/


'use strict';

jQuery(document).ready(function($) {
	//jQuery('body').html(' ');
	var $output = $('#out').text();
	var $size = $('#sz').text();
	var $side_2 = parseInt( $('#sd_2').text() );
	
	$('#canvasoutput').append('<div class="cp-loader" style="position:absolute;left:0;top:0;right:0;bottom:0;z-index:90000;"><div style="position:absolute;left:0;top:0;bottom:0;right:0;background:#464646; opacity:0.97;filter:alpha(opacity=97);"></div><i class="fa fa-spinner fa-spin fa-fw" style="position:absolute;top:50%;left:50%;margin:-80px 0 0 -32px;color:##28a6c6;font-size:45px;"></i></div>');
	$.ajax({
		url: prestashop.urls.base_url +'modules/cdesigner/views/img/files/tpl/tp_'+$output+'.html',
		method: "POST",
		dataType: "html"
	}).done(function(data) {
		data = decodeURIComponent(data);
		$('body').append('<div id="dived" style="display:none;"></div><div id="cp-device-ori-to-print-sub"></div><img src="/modules/cdesigner/views/img/files/canvas/_'+$output+'.png" id="tmp_im" />');
		$('#tmp_im').load(function(){
			$("#dived").html(data);
			$('#cp-device-ori-to-print-sub').html( $("#dived").html() );
			var $wi = $('#tmp_im').width();
			if( $('#side-2')[0] ){
				$wi = parseFloat( $wi / 2);
			}
			$("#dived").remove();
			$('#cp-device-ori').width( $wi );
			$("#tmp_im").remove();
			if( $side_2 == 30 ) {
				$('#side-1').hide();
				$('#side-2').show();
			}else{
				$('#side-2').hide();
				$('#side-1').show();
			}
			 $('.no-phone').removeClass('no-phone');
			 $('.no-bg-gen').removeClass('no-bg-gen');
			setTimeout(function() {
				$('#canvasoutput').append( $('#canvas-center-wrapper').html() );
				$('#cp-device-ori-to-print-sub .wrap-img-drag, #cp-device-ori-to-print-sub .wrap-img-drag img').show();
				$('#cp-device-ori-to-print-sub .wrap-img-drag').each(function(index,val) {
					if( ! $(this).children('img').hasClass('cp-show-a-crop') )
					{
						$(this).children('img').attr('id','cp_img_'+index);
						imgCoverEffect(document.getElementById('cp_img_'+index), {
						  alignX: 'center',
						  alignY: 'middle'
						});
					}
				});
				/*
				html2canvas([document.getElementById('cp-device-ori')], {
					proxy: document.location.origin+'/modules/cdesigner/api/html2canvasproxy.php',
					scale: $size,
					onrendered: function(canvas) {
				*/
				html2canvas(document.querySelector("#cp-device-ori"), {
	                proxy: document.location.origin+'/modules/cdesigner/api/html2canvasproxy.php',
	                scale: $size,
	                allowTaint: true, 
					useCORS: true, 
					backgroundColor: "rgba(0,0,0,0)"
	            }).then( function(canvas) {
						$('.cp-loader,#cp-device-ori-to-print-sub,#canvasoutput>main').remove();
						//$('.cp-loader').remove();
						$('#canvasoutput #canvas-center #canvas-output-c').append(canvas);
						$('#hidden-canvas').val(canvas.toDataURL("image/png"));
						//$('.gen-png').attr('href', canvas.toDataURL("image/png") );
						canvas.toBlob(function(blob) {
						  var url = URL.createObjectURL(blob);
						  $('.gen-png').attr('href', url );
						});
					}
				);
			},6000);
		});
		
	});

	$(document).on('click', '.gen-svg', function(event) {
		$('#type_b').val('2');
		document.getElementById("submit-formed").submit();
		return false;
	});

	$(document).on('click', '.gen-pdf', function(event) {
		//$('#type_b').val('1');
		document.getElementById("submit-formed").submit();
		//var $data = $('#submit-formed').serialize();
		/*
		var formData = new FormData(); 
		//var blob = dataURItoBlob(  )
		formData.append( 'data_img', $('#hidden-canvas').val().replace('data:image/jpeg;base64,', '') );  
		$.ajax({
          type: 'POST',
          url: 'index.php?fc=module&module=cdesigner&controller=imagedpi',
          data: formData,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    	  processData: false,
          success: function(data) {
            window.location = '/PSR05/modules/cdesigner/views/img/files/canvas/_tempoimg_300_dpi.pdf';
          }
        });
        */
		return false;
	});
});