/**
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
* @author    Prestaeg <CdesignerC@gmail.com>
* @copyright Prestaeg
* @version   1.0.0
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/
/** Custom Functions  **/
  'use strict';
  var _doc = $(document),
      infos = '',
      infos_data = '',

      CdesignerC = {
        name : 'CdesignerC',
        version : '1.0.0',
        path_to_modules: ( (typeof prestashop.urls === 'undefined') ? '/' : prestashop.urls.base_url)  + 'modules/cdesigner/', 

        documentReady:function(){
            if ( $('.cart-overview .cart-items')[0] || $('#order-items')[0] || $('#order-detail-content .cart_item')[0] || $('.ps_back-office #table-product tr')[0] ) CdesignerC.getInfoCombinationC(); 
            if ( $('.order-product-customization')[0] ) {
            	CdesignerC.getInfoOutputData();
            }

            if ( $('.ps_back-office #product_form')[0] ) CdesignerC.hideCustomProduct();
            CdesignerC.hideQtyProduct();
            CdesignerC.calculator();
        },

        //Check Existing Combination
		checkCombination:function(ipa){
			var id;
			$.each( infos, function( i, item ) {
				if( ipa != 0 )
		    	 if( ipa == item.id_combination )
		    	 	id = item.id_custom_output;
		    });
		    return id;
		},

		//get Info For Order
		getInfoOrder:function(id){
			var data;
			$.each( infos_data, function( i, item ) {
		    	 if( parseInt(id) == parseInt(item.key_product_output) )
		    	 	data = item;
		    });
		    return data;
		},

		changeProcessImage: function(){
		    var data_id,
				data_split, 
				data_id_product,
				id_output;

				if ( $('.cart-overview .cart-items .cart-item')[0])
					$('.cart-overview .cart-items .cart-item').each(function(){
						data_split = $(this).find('.value').text().split("cc_");
						if( !$(this).find('.product-image').find('.remove-me-order')[0] &&  data_split[1] != '' && $(this).find('.value').text().indexOf('cc_') != -1 ) {
							$(this).find('.product-image').html('<img src="'+CdesignerC.path_to_modules + 'views/img/files/canvas/_' +  $.trim(data_split[1]) + '.png'+'" class="remove-me-order" />');
							$(this).find('.product-line-grid-body>a').hide();
						}
					});

				if ( $('#order-items')[0] )
					$('.order-confirmation-table .order-line').each(function(){
						data_split = $(this).find('.value').text().split("cc_");
						if( !$(this).find('.image').find('.remove-me-order')[0] &&  data_split[1] != '' && $(this).find('.value').text().indexOf('cc_') != -1 ) {
							$(this).find('.image').html('<img src="'+CdesignerC.path_to_modules + 'views/img/files/canvas/_' +  $.trim(data_split[1]) + '.png'+'" class="remove-me-order" />');
							$(this).find('.customizations').hide();
						}
					});
		},

		//Change Image Cart
		changeImgCart:function(){
			var self = this;
            CdesignerC.changeProcessImage();
			$(document).ajaxComplete(function(){
				CdesignerC.changeProcessImage();
				setTimeout(function(){
					CdesignerC.changeProcessImage();
				},2000);
			});
			infos = '';
		},  

        //get Info Combination Product
		getInfoCombinationC:function(){
			$.ajax({
			  type: 'POST',
			  url: '../index.php?fc=module&module=cdesigner&controller=traitement',
			  data: {
			  	state : 3,
			  	id_input : 25345,
				id_output : 25335
			  },
			  dataType: 'json',
			  success: function(data) {
				infos = data;
				if( $('.ps_back-office  #table-product tr')[0] ) CdesignerC.hideCustomProduct();
				else 											 CdesignerC.changeImgCart();
			  }
			});
		},

		hideCustomProduct:function(){
			var id,prod,res;
			$('.productTabs .list-group #link-Combinations').bind('click', function(event) {
				setTimeout(function(){
					 $('#table-combinations-list tr').each(function(index, el) {
						prod = $(this).find('td').eq(3).text();
						res = prod.indexOf('cc_');
						//if( res > -1) $(this).remove();
					});
				},800);
			});
			infos = '';
		},
		hideQtyProduct:function(){
			var prod;
			$('.productTabs .list-group #link-Quantities').bind('click', function(event) {
				setTimeout(function(){
					$('#product-quantities .table tr').each(function(index, el) {
						prod = $(this).find('td').eq(0).children('span').text();
						//if( prod == 99) $(this).closest('tr').remove();
					});
				},1200);
			});
		},


		//get Info Data Product
		getInfoOutputData:function(){
			$.ajax({
			  type: 'POST',
			  url: '/index.php?fc=module&module=cdesigner&controller=traitement',
			  data: {
			  	state : 4,
			  	id_input : 25345,
				id_output : 25335
			  },
			  dataType: 'json',
			  success: function(data) {
				infos_data = data;
				CdesignerC.changeProductOrder();
			  }
			});
		},

		calculator:function(){
			$(document).on('keyup', '#wx', function(event) {
				var $self = $(this);
				var $val = $(this).val();
				var $val_orig = $(this).closest('.modal-dialog').find('.ow').text();
				var $number = 0;
				var $data = 0;
				$(this).closest('.modal-dialog').find('.c_ws').each(function(index, el) {
					$data = $(this).data('res');
					$number = Math.round( ( ($data * $val ) / $val_orig ) * 100) / 100;
					$(this).text($number);
				});
			});
 
			$(document).on('keyup', '#hx', function(event) {
				var $self = $(this);
				var $val = $(this).val();
				var $val_orig = $(this).closest('.modal-dialog').find('.oh').text();
				var $number = 0;
				var $data = 0;
				$(this).closest('.modal-dialog').find('.c_hs').each(function(index, el) {
					$data = $(this).data('res');
					$number = Math.round( ( ($data * $val ) / $val_orig ) * 100) / 100;
					$(this).text($number);
				});
			});

			$(document).on('click', '.gen-canvas-f', function(event) {
				event.preventDefault();
				var $str_size = $(this).closest('.jumbotron').find('.size-c').val();
				var $str_mask = $(this).closest('.jumbotron').find('.mask-c').val();
				var $str_url = $(this).closest('.jumbotron').find('.string-url').text();
				var $str_output = $(this).closest('.jumbotron').find('.string-output').text();
				$('body').append('<form method="post" target="_blank" class="form-sq" action="'+$str_url+'">\
									<input type="hidden" name="s" value="'+$str_size+'"/>\
									<input type="hidden" name="mask" value="'+$str_mask+'"/>\
									<input type="hidden" name="output" value="'+$str_output+'" />\
								</form>');
				$('.form-sq').submit();
				$('.form-sq').remove();
			});

			$(document).on('click', '.canvas-2-gen', function(event) {
				event.preventDefault();
				var $str_size = $(this).closest('.jumbotron').find('.size-c').val();
				var $str_url = $(this).closest('.jumbotron').find('.string-url').text();
                var $str_mask = $(this).closest('.jumbotron').find('.mask-c').val();
				var $str_output = $(this).closest('.jumbotron').find('.string-output').text();
				$('body').append('<form method="post" target="_blank" class="form-sq" action="'+$str_url+'">\
									<input type="hidden" name="s" value="'+$str_size+'"/>\
									<input type="hidden" name="side_2" value="30"/>\
                                    <input type="hidden" name="mask" value="'+$str_mask+'"/>\
									<input type="hidden" name="output" value="'+$str_output+'" />\
								</form>');
				$('.form-sq').submit();
				$('.form-sq').remove();
			});
		},

		changeProductOrder:function(){
			var data_id,
				data_split, 
				data_id_product,
				$link,size,font,img,img_str, img_output,size_2,font_2,img_2,img_str_2, img_output_2,id_output;
			img_output_2 = '';
			img_output = '';
			if ( $('.order-product-customization')[0] )
				var $i = 0;
				var text_information = '';
				var text_information_2 = '';
				var rotate = ''; 
				var headfilter ='<div class="table-responsive-row clearfix"><table class="table">\
									 <tr class="nodrag nodrop filter row_hover">\
										<th style="text-aling:center">\
											<b>--</b>\
										</th>\
										<th colspan="2">\
											<div class="input-group">\
												<input type="text" id="wx" placeholder="width"/>\
												<span class="input-group-addon">cm </span>\
											</div>\
										</th>\
										<th colspan="2">\
											<div class="input-group">\
												<input type="text" id="hx" placeholder="height"/>\
												<span class="input-group-addon">cm </span>\
											</div>\
										</th>\
										<th style="text-alin:center">\
											<b>--</b>\
										</th>\
									</tr>';
				var headtxt = '<tr><th>\
										<b>Text</b>\
									</th>\
									<th>\
										<b>Size(W/H)</b>\
									</th>\
									<th>\
										<b>Position(T/L)</b>\
									</th>\
									<th>\
										<b>Rotate</b>\
									</th>\
									<th>\
										<b>Font-family</b>\
									</th>\
									<th>\
										<b>Color</b>\
									</th>\
								</tr>';
				var side_1 = '<tr><th colspan="6"><h3 style="text-align:center; margin:0;"><b>Side 1</b></h3></th>';
				var side_2 = '<tr><th colspan="6"><h3 style="text-align:center; margin:0;"><b>Side 2</b></h3></th>';
				var headtxt_2 = '<tr><th>\
										<b>Text</b>\
									</th>\
									<th>\
										<b>Size(W/H)</b>\
									</th>\
									<th>\
										<b>Position(T/L)</b>\
									</th>\
									<th>\
										<b>Rotate</b>\
									</th>\
									<th>\
										<b>Font-family</b>\
									</th>\
									<th>\
										<b>Color</b>\
									</th>\
								</tr>'; 
				var foottxt = '</table></div>';
				
				$('.order-product-customization').each(function(){
					$(this).find('.border-top-0.text-muted p strong').remove();
					$(this).find('.border-top-0.text-muted p').hide();
					data_id = $(this).find('.border-top-0.text-muted p').text();  
					data_split = data_id.split("cc_");
					text_information = '';
					if( !isNaN( data_split[1]) )
					{
						data_id_product = CdesignerC.getInfoOrder( data_split[1] );
						if( !$.isEmptyObject(data_id_product) )
						{
							size = data_id_product.size_canvas.split('|');
							font = ( data_id_product.font_canvas != null ) ? data_id_product.font_canvas.split(';') : "";
							img = ( data_id_product.img_canvas != null ) ? data_id_product.img_canvas.split(';') : "";

							size_2 = data_id_product.size_canvas_2.split('|');
							font_2 = ( data_id_product.font_canvas_2 != null ) ? data_id_product.font_canvas_2.split(';') : "";
							img_2 = ( data_id_product.img_canvas_2 != null ) ? data_id_product.img_canvas_2.split(';') : "";

							if( font[0] != ''){
								var frag_text = '';
								text_information = '';
								$.each( font, function( i, value ) {
									frag_text = value.split('|');
									if(frag_text[0] !='' )
										text_information += '\
											<tr>\
												<td style="color:'+frag_text[2]+'">'+frag_text[0]+'</td>\
												<td><span class="c_ws" data-res="'+Math.round( frag_text[3] * 100) / 100+'">'+Math.round( frag_text[3] * 100) / 100+'</span>cm / <span class="c_hs" data-res="'+Math.round( frag_text[4] * 100) / 100+'">'+Math.round( frag_text[4] * 100) / 100+'</span>cm</td>\
												<td><span class="c_hs" data-res="'+Math.round( frag_text[5]* 100) / 100+'">'+Math.round( frag_text[5] * 100) / 100+'</span>cm / <span class="c_ws" data-res="'+Math.round( frag_text[6] * 100) / 100+'">'+Math.round( frag_text[6] * 100) / 100+'</span>cm<br /></td>\
												<td>'+frag_text[7]+'(deg)</td>\
												<td>'+frag_text[1]+'</td>\
												<td>'+frag_text[2]+'</td>\
											</tr>';
								});
							}
								
							img_output = '<tr>\
											<th>\
												<b>Image</b>\
											</th>\
											<th>\
												<b>Size(W/H)</b>\
											</th>\
											<th>\
												<b>Position(T/L)</b></th>\
											<th>\
												<b>Rotate</b>\
											</th>\
											<th>\
												<b>--</b>\
											</th>\
											<th>\
												<b>--</b>\
											</th>\
										</tr>';
							$.each( img, function( i, item ) {
						    	img_str = item.split('|');
					    		if( img_str != '' )
					    		{
					    			img_output += '\
											<tr>\
												<td><div class="thumbnail"><img src="'+img_str[0]+'" width="50px"/></div></td>\
												<td><span class="c_ws" data-res="'+img_str[1]+'">'+img_str[1]+'</span>cm x <span class="c_hs" data-res="'+img_str[2]+'">'+img_str[2]+'</span>cm</td>\
												<td><span class="c_hs" data-res="'+img_str[3]+'">'+img_str[3]+'</span>cm / <span class="c_ws" data-res="'+img_str[4]+'">'+img_str[4]+'</span>cm</td>\
												<td>'+img_str[5]+'(deg)</td>\
												<td>\
													<a class="btn btn-outline-secondary" href="'+img_str[0]+'" target="_blank">\
														<i class="icon-search"></i> View\
													</a>\
												</td>\
												<td>--</td>\
											</tr>';
					    		}
						    });

							//Side 2
						    if( font_2[0] != ''){
								var frag_text_2 = '';
								text_information_2 = '';
								$.each( font_2, function( i, value ) {
									frag_text_2 = value.split('|');
									if(frag_text_2[0] !='' )
										text_information_2 += '\
											<tr>\
												<td style="color:'+frag_text_2[2]+'">'+frag_text_2[0]+'</td>\
												<td><span class="c_ws" data-res="'+Math.round( frag_text_2[3] * 100) / 100+'">'+Math.round( frag_text_2[3] * 100) / 100+'</span>cm / <span class="c_hs" data-res="'+Math.round( frag_text_2[4] * 100) / 100+'">'+Math.round( frag_text_2[4] * 100) / 100+'</span>cm</td>\
												<td><span class="c_hs" data-res="'+Math.round( frag_text_2[5]* 100) / 100+'">'+Math.round( frag_text_2[5] * 100) / 100+'</span>cm / <span class="c_ws" data-res="'+Math.round( frag_text_2[6] * 100) / 100+'">'+Math.round( frag_text_2[6] * 100) / 100+'</span>cm<br /></td>\
												<td>'+frag_text_2[7]+'(deg)</td>\
												<td>'+frag_text_2[1]+'</td>\
												<td>'+frag_text_2[2]+'</td>\
											</tr>';
								});
							}
								
							img_output_2 = '<tr>\
											<th>\
												<b>Image</b>\
											</th>\
											<th>\
												<b>Size(W/H)</b>\
											</th>\
											<th>\
												<b>Position(T/L)</b></th>\
											<th>\
												<b>Rotate</b>\
											</th>\
											<th>\
												<b>--</b>\
											</th>\
											<th>\
												<b>--</b>\
											</th>\
										</tr>';
							$.each( img_2, function( i, item ) {
						    	img_str_2 = item.split('|');
					    		if( img_str_2 != '' )
					    		{
					    			img_output_2 += '\
											<tr>\
												<td><div class="thumbnail"><img src="'+img_str_2[0]+'" width="50px"/></div></td>\
												<td><span class="c_ws" data-res="'+img_str_2[1]+'">'+img_str_2[1]+'</span>cm x <span class="c_hs" data-res="'+img_str_2[2]+'">'+img_str_2[2]+'</span>cm</td>\
												<td><span class="c_hs" data-res="'+img_str_2[3]+'">'+img_str_2[3]+'</span>cm / <span class="c_ws" data-res="'+img_str_2[4]+'">'+img_str_2[4]+'</span>cm</td>\
												<td>'+img_str_2[5]+'(deg)</td>\
												<td>\
													<a class="btn btn-outline-secondary" href="'+img_str_2[0]+'" target="_blank">\
														<i class="icon-search"></i> View\
													</a>\
												</td>\
												<td>--</td>\
											</tr>';
					    		}
						    });

							var side_2_canvas = '';
							if( text_information_2 != '' ) text_information_2 = headtxt_2 + text_information_2;
							var size_canvas_2 = '';
							var btn_generate_2 = '';
							if( size_2[0] != '' ) {
								var size_canvas_2 = '<b>Size in screen side 2 : </b> <span>'+Math.round( size_2[0] * 100) / 100+'</span>cm x <span>'+Math.round( size_2[1] * 100) / 100+'</span>cm';
								side_2_canvas = side_2 + text_information_2 + img_output_2;
								btn_generate_2 = '<p style="text-align:center; clear:both;">\
														<a class="btn btn-outline-secondary canvas-2-gen" href="javascript:void(0)" >\
															<i class="icon-search"></i> Image ready to print side 2\
														</a>\
													</p>';
							}
							if( text_information != '' ) text_information = headtxt + text_information;
							$link = CdesignerC.path_to_modules + 'views/img/files/canvas/_' +  $.trim(data_split[1]) + '_.png';
							$(this).find('td').eq(0).html('<img src="'+CdesignerC.path_to_modules + 'views/img/files/canvas/_' +  $.trim(data_split[1]) + '.png" style="height : 60px !important;" class="imgm img-thumbnail"/>&nbsp;\
								<a href="#" data-toggle="modal" data-target="#myModal'+$i+'" class="btn btn-outline-secondary" style="margin:3px 0">\
									<i class="icon-search"></i> About design\
								</a>\
								<div class="modal fade" id="myModal'+$i+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
								<div class="modal-dialog">\
									<div class="modal-content">\
										<div class="modal-header">\
											<h5 class="modal-title" id="myModalLabel">Custom design informaiton</h5>\
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">\
												<span aria-hidden="true">&times;</span>\
											</button>\
										</div>\
										<div class="modal-body" style="overflow:hidden">\
											<div class="jumbotron" style="overflow:hidden">\
												<div class="col-sm-6">\
													<div class="thumbnail">\
														<img src="'+CdesignerC.path_to_modules + 'views/img/files/canvas/_' +  data_split[1] + '.png" class="img-responsive" style="max-height:300px;" />\
														<div class="caption text-center">\
															<a class="btn btn-outline-secondary" href="'+CdesignerC.path_to_modules + 'views/img/files/canvas/_' +  data_split[1] + '.png" target="_blank">\
																<i class="icon-search"></i> View\
															</a>\
														</div>\
													</div>\
												</div>\
												<div class="col-sm-6">\
													<label class="control-label col-lg-6" for="scale" style="position:relative;top:2px;"> Quality </label>\
													<div class="col-lg-6" style="margin-bottom:15px;">\
														<select name="size-c" class="size-c">\
															<!--option value="72">72DPI (≃'+ Math.round( size[0] * 100) / 100 +' CM)</option-->\
															<option value="2">144DPI</option>\
															<option value="4">300DPI</option>\
														</select>\
													</div>\
													<label class="control-label col-lg-6" for="scale" style="position:relative;top:2px; clear:both"> Design with mask </label>\
													<div class="col-lg-6">\
														<select name="mask-c" class="mask-c">\
															<option value="no">No</option>\
															<option value="yes">Yes</option>\
														</select>\
													</div>\
													<span class="string-url" style="display:none;">/index.php?fc=module&module=cdesigner&controller=canvasoutput</span>\
													<span class="string-output" style="display:none;">'+data_split[1]+'"</span>\
													<p style="text-align:center; clear:both; padding-top:15px;">\
														<a class="btn btn-outline-secondary gen-canvas-f" href="javascript:void(0)" >\
															<i class="icon-search"></i> Image ready to print side 1\
														</a>\
													</p>\
													'+ btn_generate_2 +'\
												</div>\
											</div>\
								<div class="clear:both;width:100%;">\
									<b style="font-size:16px; color:#28a6c6; display:block; clear;both">Information about the custom design : </b><br />\
									<b>Size in screen side 1 : </b> <span class="ow">'+Math.round( size[0] * 100) / 100+'</span>cm x <span class="oh">'+Math.round( size[1] * 100) / 100+'</span>cm<br />\
									'+ size_canvas_2 +'<br />\
									<br /><p><sup>(*)</sup>Please fill into the textfield(Width / Height) your real canvas size(CM), the plugin will set automatically the size and position for each design element for you can get the correct information if you need to create the design manually.</p>\
									'+headfilter + side_1 + text_information + img_output + side_2_canvas +  foottxt+'\
								</div>\
								</div>\
								<div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button></div></div></div></div>');
						} 
						$i++;
					}
				});

			infos_data = '';
		}
    }
    /** Call Functions on Document.Ready **/
    _doc.ready(CdesignerC.documentReady);

/** End Custom Functions  **/

