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
(function($){
    /** Plugin Constructor **/
    var Cdesigner=function(selector,options){
        this.$elem=$(selector);
        this.$options=options;
    }

    /** Plugin Prototype **/
    Cdesigner.prototype = {
        defaults:{
            path_to_modules: baseDir +'modules/cdesigner/', //Path To Theme
            easing: 'easeInOutQuad' //Custom Transition
        },
        // Init Plugin
        init:function(){
            this.setting=$.extend({}, this.defaults, this.options);
            this.chooseDevice(); //Call Function Choose Device
            this.loadLayout(); //Call Function Load Layout
            this.chooseLayout(); //Call Function Choose Layout
            this.putImageToDevice(); //Call Function Put Image Into Device
            this.getShuffleImg(); //Call Function Shuffle Image
            this.resetImg(); //Call Function Shuffle Image
            this.uploadOtherImg(); //Call Function Upload New Image
            this.putTextDevice(); //Call Function Put Text Into Device
            this.cropImg(); //Call Function Crop Image
            this.deleteImg(); //Call Function Delete Image From Device
            this.getCanvasDevice(); //Call Function Get Canvas From Html Code
            this.chooseModel();  //Call Function Choose Model
            this.getActiveLinkStep();
            this.eventModuleExtra();
            this.initPosition();
            this.searchPhone();
            this.switchRverso();
            this.insertCropit();
            this.mobileText();
            this.mobileMenu();
            this.navigationFree();
            this.savePreprocessData();
            this.zoomPage();
            this.zoneKeyUp();
            this.selectPredefinedDesign();
        },
        zoneKeyUp:function(){
            var self = this;
            $(document).on('keyup','.zone-edit-area',function(e){
                $(this).attr('value', $(this).val() );
                self.copyHtmlGrid();
            });
        },
        loopArray: function( $txt, $aarray){
            var $flag = false
            $aarray.forEach(function($value){
                if( parseInt($txt) == parseInt($value) )
                    $flag = true;
            });

            return $flag;
        },
        selectPredefinedDesign:function(){
            var self = this;
            $(document).on('click','.pre-design .cp-gridme-cover .sqr',function(e){
                var $tags = $(this).attr('data-tags');
                $tags = $tags.split('=+');
                
                if( $('.allow-zone')[0] ) {
                    $('.lst-tags>a[data-tagid='+$tags[0]+']').trigger('click');
                } else {
                    $('.lst-tags>a').removeClass('disabled');
                    if( $tags[0] != '' && parseInt( $tags[0] ) != 0 ) {
                        $('.lst-tags>a').removeClass('choosen').addClass('disabled');
                        $('.lst-tags>a').each(function(){
                             var $itag = parseInt( $(this).attr('data-tagid') );
                             if( self.loopArray( $itag, $tags) && !isNaN($itag) ) {
                                $(this).removeClass('disabled').addClass('choosen');
                             }
                        });
                        $('.lst-tags>a.choosen').eq(0).trigger('click');
                    }
                }

                $('#lft-side').removeClass('no-img-filter');
                $('.cp-input-gen.current-txt').removeClass('current-txt');
                $('#cp-link-step>li').removeClass('cp-current-step').removeClass('cp-active');
                $('#cp-st-2').addClass('cp-current-step');
                $('#cp-st-2').addClass('cp-active');
                $('#cp-ct-step>div').hide();
                $('#step2').show();
            });

            $(document).on('click','.pre-design .cp-input-gen',function(e){
                $('#lft-side').removeClass('no-img-filter');
                var $font = $(this).find('pre').attr('data-afont');
                var $color = $(this).find('pre').attr('data-acolor');

                var $abreak = $(this).find('pre').attr('data-abreak');
                var $afontsize = $(this).find('pre').attr('data-afontsize');
                var $afontalignement = $(this).find('pre').attr('data-afontalignement');

                if( $font == 'yes') 
                    $('.combo-typo').show();
                else 
                    $('.combo-typo').hide();

                if( $color == 'yes') 
                    $('.cp-list-color').show();
                else 
                    $('.cp-list-color').hide();


                if( $abreak == 'yes') 
                    $('.current-txt .wr-pre').addClass('force-break');
                else 
                    $('.current-txt .wr-pre').removeClass('force-break');


                if( $afontsize == 'yes') 
                    $('.pre-design #cp-size-txt').attr('style','display:block !important;');
                else 
                    $('.pre-design #cp-size-txt').attr('style','display:none !important;');


                if( $afontalignement == 'yes') 
                    $('.pre-design #cp-align-txt').attr('style','display:block !important;');
                else 
                    $('.pre-design #cp-align-txt').attr('style','display:none !important;');

                
                $('#cp-sel-Text').show();
                //$('#lft-side').addClass('no-img-filter');
                $('.cp-cibled-row').removeClass('cp-cibled-row');

                $('#cp-link-step>li').removeClass('cp-current-step').removeClass('cp-active');
                $('#cp-st-3').addClass('cp-current-step');
                $('#cp-st-3').addClass('cp-active');

                $('#cp-ct-step>div').hide();
                $('#step3').show();
            });
        },
        savePreprocessData:function(){
            var self = this;
            $(document).on('click','.cp-btn-save-prec',function(e){
                var $size_row=$('#cp-gridme .sqr').size();
                var $size_img=$('#cp-gridme .wrap-img-drag').size();
                $('body').append('<div class="overlay-bg"><div class="loader-canvas"><span class="progress-title">'+on_process+'</span><div class="progress"></div><p class="progress-txt"></p></div></div>');
                $('html,body').animate({scrollTop:0},500);
                $('.overlay-bg').fadeIn('pretty',function(){
                    $('#cp-gridme .sqr .wrap-img-drag img').show();
                    $('#cp-device-ori-to-print #side-1').show();
                    $('#cp-device-ori-to-print #side-2').hide();
                    $('.currentspace').removeClass('currentspace');
                    $('#side-1').addClass('currentspace');
                    $('#cp-device-ori').addClass('no-bg-gen');
                    $('body').append( '<div id="cp-device-ori-to-print"><div id="cp-device-ori" class="no-phone no-bg-gen">'  + $('#cp-device-ori').html() + '</div></div>');
                    $('#cp-device-ori-to-print #cp-device-ori').width( $('#cp-sel-Device #cp-device-ori').width());
                    $('body').append( '<div id="cp-device-ori-to-show"><div id="cp-device-ori" class="no-bg-gen">'  + $('#cp-device-ori').html() + '</div></div>');
                    $('#cp-device-ori-to-show #cp-device-ori').width( $('#cp-sel-Device #cp-device-ori').width());
                    self.centerImg();
                    $('html,body').animate({scrollTop:0},0);
                    if (!Date.now) {
                        Date.now = function() { return new Date().getTime(); }
                    }
                    var $date_now = parseInt(Date.now());

                    html2canvas([document.getElementById('cp-device-ori-to-show')], {
                        proxy: document.location.origin+'/modules/cdesigner/api/html2canvasproxy.php',
                        scale: 1,
                        onrendered: function(canvas) {
                            var url_to_print = canvas.toDataURL("image/png");
                            var url_clean = url_to_print.replace('data:image/png;base64,','');
                            $.ajax({
                              xhr: function()
                              {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt){
                                  if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                     $('.loader-canvas .progress').width(percentComplete+'%');
                                     $('.loader-canvas .progress-txt').text(parseInt(percentComplete)+'%');
                                  }
                                }, false);
                                return xhr;
                              },
                              type: 'POST',
                              url: baseUri+'index.php?fc=module&module=cdesigner&controller=save',
                              data: {
                                token : prestashop.static_token,
                                id_img : $date_now,
                                img : url_clean
                              },
                              success: function(data){
                                    if( !$('body').hasClass('user-logged-succed') )
                                    {
                                        $.ajax({
                                          type: 'POST',
                                          url: window.baseUri + 'index.php?fc=module&module=cdesigner&controller=storedatapre',
                                          data: {
                                            id : $('#cp-device-ori-to-print').html(),
                                            link : $('#link-opc').text() ,
                                            output : $date_now,
                                            prod : $('.cp-token').text().substr(2)
                                          },
                                          success: function(data) {
                                            $('#cp-gridme .sqr .wrap-img-drag img').hide();
                                            $('#cp-device-ori').removeClass('no-bg-gen');
                                            $('#cp-device-ori-to-print, #cp-device-ori-to-show').remove();
                                            $('.overlay-bg').fadeOut('pretty',function(){
                                                $('.overlay-bg').remove();
                                                alertify.alert( error_save );
                                                document.location = '/login?back='+data+'&from_custom=1&idproduct='+$('.cp-token').text().substr(2)+'&output='+$date_now;  
                                            });
                                          }
                                        });
                                    }
                                    else{
                                        $.ajax({
                                          type: 'POST',
                                          url: window.baseUri + 'index.php?fc=module&module=cdesigner&controller=traitement',
                                          data: {
                                            id : $('#cp-device-ori-to-print').html(),
                                            link : $('#link-opc').text(),
                                            id_output : $date_now,
                                            state : 6,
                                            id_input : $('.cp-token').text().substr(2)
                                          },
                                          success: function(data) {
                                            $('#cp-gridme .sqr .wrap-img-drag img').hide();
                                            $('#cp-device-ori').removeClass('no-bg-gen');
                                            $('#cp-device-ori-to-print,#cp-device-ori-to-show').remove();
                                            $('.overlay-bg').fadeOut('pretty',function(){
                                                $('.overlay-bg').remove();
                                                alertify.alert( success_save );
                                            });
                                          }
                                        });
                                    }
                                }
                            });
                        }
                    });
                });
                e.preventDefault();
            });
        },

        zoomPage:function(){
            $(document).on('click','.cp-gridme-cover',function() {
                    if( !$('.anywere')[0] ) $(this).addClass('someone-selected');
            });
            $(document).on('click','.zoom-ino',function() {
                $('#center-side').attr('style','margin-top:30px;-moz-transform: scale(2.2);-webkit-transform: scale(2.2);-o-transform: scale(2.2);transform: scale(2.2);position:relative;z-index:100;');
                $('#wrap-phone-pop').append('<a href="javascript:void(0);" class="zoom-outo"><i class="fa fa-search-minus" aria-hidden="true"></i>ZOOM Out</a>');
                $('#wrap-phone').append('<div class="over-helper"></div>');
                $('.zoom-outo').show();
                $('.zoom-ino').hide();
                return false;
            });

            $(document).on('click','.zoom-outo',function() {
                $('#center-side').attr('style','display:block');
                $('.over-helper,.zoom-outo').remove();
                $('.zoom-outo').hide();
                $('.zoom-ino').show();
                return false;
            });
        },

        // Add Cropit Block
        insertCropit:function(){
            var self = this;
            //$('body').append('<div id="cp-crop-image"><div id="cp-cropit-me"></div></div>');
            $('.lst-tags a').eq(0).addClass('active');
            self.findTags();
            $(document).on('click','.lst-tags a',function(e){
                $('.lst-tags a').removeClass('active');
                $(this).addClass('active');
                self.findTags();
                self.loadActiveImg();
                return false;
            });
            $(document).on('click','#s-t',function(){
                $('.current-txt pre').css('font-size', ( parseInt( $('.current-txt pre').css('font-size') ) - 4 ) + 'px' );
                if( $('.pre-design')[0] ) {
                    $('.current-txt pre').css('line-height', ( parseInt( $('.current-txt pre').css('font-size') ) - 4 ) + 'px' );
                }
                if( $(window).width() < 980 )
                    $('.cp-input-txt').css('font-size', ( parseInt( $('.current-txt pre').css('font-size') ) - 4 ) + 'px' );
                return false;
            });

            $(document).on('click','#m-t',function(){
                $('.current-txt pre').css('font-size', ( parseInt( $('.current-txt pre').css('font-size') ) + 4 ) + 'px' );
                if( $('.pre-design')[0] ) {
                    $('.current-txt pre').css('line-height', ( parseInt( $('.current-txt pre').css('font-size') ) + 4 ) + 'px' );
                }
                
                if( $(window).width() < 980 )
                    $('.cp-input-txt').css('font-size', ( parseInt( $('.current-txt pre').css('font-size') ) + 4 ) + 'px' );
                return false;
            });
        },

        findTags:function(){
            $('.lst-img li').hide();
            $('.lst-tags a.active').closest('.lst-img').find('li.'+$('.lst-tags a.active').attr('id')).fadeIn('pretty');
        },

        navigationFree:function(){
            var self = this;
            $('.zoom-in').click(function(){
                var w = parseInt( $('.squared.selected .img-h').width() );
                var h = parseInt( $('.squared.selected .img-h').height() );
                var l = parseInt( $('.squared.selected').css('left') );
                var t = parseInt( $('.squared.selected').css('top') );

                var w_r = parseInt( w + ( w * 0.2 ) );
                var h_r = parseInt( h + ( h * 0.2 ) );

                var l_r = parseInt( l - ( w * 0.1 * -1 ) );
                var t_r = parseInt( t - ( h * 0.1 * -1 ) );

                $('.squared.selected .img-h').css({'width': w_r +'px', 'height': h_r +'px' });
                $('.squared.selected').css({'left': l_r +'px', 'top': t_r +'px' });

                return false;
            });

            $('.zoom-out').click(function(){
                var w = parseInt( $('.squared.selected .img-h').width() );
                var h = parseInt( $('.squared.selected .img-h').height() );
                var l = parseInt( $('.squared.selected').css('left') );
                var t = parseInt( $('.squared.selected').css('top') );

                var w_r = parseInt( w - ( w * 0.2 ) );
                var h_r = parseInt( h - ( h * 0.2 ) );

                var l_r = parseInt( l + ( w * 0.1 ) * (-1) );
                var t_r = parseInt( t + ( h * 0.1  ) * (-1) );

                $('.squared.selected .img-h').css({'width': w_r +'px', 'height': h_r +'px' });
                $('.squared.selected').css({'left': l_r +'px', 'top': t_r +'px' });

                return false;
            });

            var orientation = 0;
            $(document).on('click', '.rotate-left', function(){
            //$('.rotate-left').click(function(){
                orientation -= 2;
                orientation = ( parseInt(orientation) < 0) ? 8 : orientation;
                self.executeRotate(orientation);
                return false;
            });

            $(document).on('click', '.rotate-right', function(){
            //$('.rotate-right').click(function(){
                orientation += 2;
                orientation = ( parseInt(orientation) > 8) ? 0 : orientation;
                self.executeRotate(orientation);
                return false;
            });

            $('.delete-img-dash').click(function(){
                $('.cp-gridme-cover .squared.selected').remove();
                self.copyHtmlGrid();
                //$('.navigation-btn').hide();
                return false;
            }); 
        },

        executeRotate:function(orientation){
            var self = this;
            var $elements = '';
            var imageUrl = $('.squared.selected').find('.img-h').attr('src');
            var w = $('.squared.selected .ui-wrapper').width();
            var h = $('.squared.selected .ui-wrapper').height();
            $('.currentspace .cp-gridme *').remove();
            $('.currentspace').addClass('still-load');
            $('.squared.selected').append('<div class="on-process-load"></div>');
            $('.squared.selected .img-rotate').remove();
            $('.navigation-btn').addClass('on-load');

            if( orientation == 0) { 
                $elements = ".squared.selected .img-h";
                $('.squared.selected').removeClass('with-rotate');
            } else {
                $elements = ".squared.selected .img-rotate";
                $('.squared.selected').addClass('with-rotate');
            }
            
            if( orientation > 0 ) {
                var image = new Image();
                image.src = imageUrl;
                image.onload = function() {
                    loadImage(
                    imageUrl,
                    function (img) {
                        if(img.type === "error") {
                            console.log("Error loading image " + imageUrl);
                        } else {
                            var fileExtension = imageUrl.substr( (imageUrl.lastIndexOf('.') + 1) );
                            fileExtension = ( fileExtension == 'jpg') ? 'jpeg' : fileExtension;
                            $('.squared.selected .ui-wrapper').append('<img src="'+img.toDataURL("image/"+fileExtension)+'" class="img-rotate"/>');
                            $('.still-load').removeClass('still-load');
                            $('.squared .on-process-load').remove();
                            $('.navigation-btn').removeClass('on-load');
                        }
                    },  
                    {
                        maxWidth: image.naturalWidth,
                        maxHeight: image.naturalHeight,
                        canvas: false,
                        contain: true,
                        crossOrigin: "Anonymous",
                        orientation: orientation
                    }
                );
                }
            }
        
            var data_ratio = $( ".squared.selected" ).attr('data-ratio');
            var ws = 0;
            var hs = 0;
            if( orientation == 6 || orientation == 8 )
            {
                if( data_ratio == '16:9' ) {
                    if( w > h ) {
                        ws = h;
                        hs = w;
                    } else {
                        ws = w;
                        hs = h;
                    }
                } else if (data_ratio == '9:16' ){
                    if( w < h ) {
                        ws = h;
                        hs = w;
                    } else {
                        ws = w;
                        hs = h;
                    }
                } else {
                    ws = w;
                    hs = h;
                }

            } else {
                if( data_ratio == '16:9' ) {
                    if( w < h ) {
                        ws = h;
                        hs = w;
                    } else {
                        ws = w;
                        hs = h;
                    }
                } else if (data_ratio == '9:16' ){
                    if( w > h ) {
                        ws = h;
                        hs = w;
                    } else {
                        ws = w;
                        hs = h;
                    }
                } else {
                    ws = w;
                    hs = h;
                }
            }
            $( ".squared.selected .img-rotate, .squared.selected .ui-wrapper, .squared.selected .img-h" ).css({'width':ws + 'px', 'height':hs + 'px'});
            setTimeout(function(){
                $( '.squared.selected .img-h' ).resizable({
                  aspectRatio: ws / hs,
                  create: function( event, ui ) { 
                    self.copyHtmlGrid();
                  },
                  resize: function(event, ui){
                    self.copyHtmlGrid();
                  },
                  stop:function(){
                    self.copyHtmlGrid();
                  }
                });
                self.copyHtmlGrid();
            }, 1000); 

            setTimeout(function(){
               if( $('.squared .on-process-load')[0]) $('.squared .on-process-load').remove();
               if( $('.navigation-btn.on-load')[0]) $('.navigation-btn').removeClass('on-load');
               if( $('.still-load')[0]) $('.still-load').removeClass('still-load');
            }, 4000); 
        },

        mobileText:function(){
            $('.show-text-mobile').click(function(){
                $('#right-side').toggleClass('opened');
                return false;
            });
        },

        mobileMenu:function(){
            $('.navigation-mobile a').click(function(){
                $('.list-combination-data').hide();
                $('.navigation-mobile li').removeClass('active');
                $(this).parent().addClass('active');
                $('#lft-side').addClass('show-me');
                $('#cp-ct-step>div').hide();
                $('#cp-ct-step #'+ $(this).attr('class') ).fadeIn('pretty');
                $('.new-txt').trigger('click');
                if( $(this).hasClass('step3') ){
                    $('#wrap-phone-pop').animate({scrollTop:0},10);
                    $('#right-side').addClass('opened');
                }
                else{
                    $('#right-side').removeClass('opened');
                }
                return false;
            });
            $('.btn-close-mobile, .save-txt').click(function(){
                $('.navigation-mobile li').removeClass('active');
                $('#lft-side').removeClass('show-me');
                $('#right-side').removeClass('opened');
                $('.save-txt').hide();
                $('.cp-list-color ul').fadeOut('pretty');
                $('.ico-col').removeClass('active');
                return false;
            });

            $(document).on('click','.sqr',function() {
                if( $(window).width() < 980 ) {
                    $('#lft-side').addClass('show-me');
                    $('#cp-ct-step>div').hide();
                    $('#cp-ct-step #step2').fadeIn('pretty');
                    $('#right-side').removeClass('opened');
                }
            });

            $(document).on('click','.cp-input-gen',function() {
                if( $(window).width() < 980 ) {
                    $('#lft-side').addClass('show-me');
                    $('#cp-ct-step>div').hide();
                    $('#cp-ct-step #step3').fadeIn('pretty');
                    $('#wrap-phone-pop').animate({scrollTop:0},10);
                    $('#right-side').addClass('opened');
                    $('.add-txt').hide();
                    $('.save-txt').show();
                }
            });
        },

        showSquare:function(){
            /*
            $(document).on('hover','.anywere .cp-gridme-cover',function(){
                $('.anywere .cp-gridme-cover,.anywere .cp-gridme-cover .squared').css('');
            });
            
            $('.anywere #cp-device-ori').hover(function(){
                $('.anywere .cp-gridme-cover,.anywere .cp-gridme-cover .squared').css('visibility','visible');
            },function(){
                setTimeout(function(){
                    $('.anywere .cp-gridme-cover,.anywere .cp-gridme-cover .squared').css('visibility','hidden');
                },10000);
            });
            */
        },

        switchRverso:function(){
            $(document).on('click','.switcher a',function(e){
                $('.switcher a').removeClass('active');
                $('.cp-btn-action').hide();
                $(this).addClass('active');
                $('.current-txt').removeClass('current-txt');
                $('.cp-input-txt').val('');
                $('.new-txt').fadeOut('fast');
                $('.add-txt').show();
                $('.cp-list-color>ul').fadeOut('fast');
                $('.ico-col').removeClass('active');
                $('#cp-device-ori>div').removeClass('currentspace');
                if( $(this).index() == 1 )
                {
                    $('#side-2').addClass('currentspace');
                    $('#side-2').fadeIn('pretty');
                    $('#side-1').hide();
                }
                else{
                    $('#side-1').addClass('currentspace');
                    $('#side-1').fadeIn('pretty');
                    $('#side-2').hide();
                }
                if( !$('.currentspace').hasClass('anywere') )  $('.cp-btn-action').show();
  
                if( $('.currentspace .cp-gridme-cover').html() == '' && !$('.currentspace').hasClass('anywere') ) {
                    $('#cp-ct-step>div').hide();
                    $('#cp-link-step>li').removeClass('cp-current-step');
                    $('#cp-st-1').addClass('cp-active cp-current-step');
                    $('#step1').show();
                } else {
                    $('#cp-ct-step>div').hide();
                    $('#cp-link-step>li').removeClass('cp-current-step');
                    $('#cp-st-2').addClass('cp-active cp-current-step');
                    $('#step2').show();
                }
  
                if( $('.pre-design')[0] ) {
                    if( $('#cp-link-step .cp-active').attr('id') == 'cp-st-3' ) {
                        $('#cp-st-3 a').trigger('click');
                    } else if( $('#cp-link-step .cp-active').attr('id') == 'cp-st-2' ) { 
                        $('#cp-st-2 a').trigger('click');
                    }
                }

                return false;
            });
        },
        adjustFont:function($nativeW, $value){
            var $width_zone_native = $nativeW;
            var $font_size = $value;
            var $width_zone = $('.currentspace').width();
            return ($width_zone * $font_size) / $width_zone_native;
        },
        initFont:function(){
            var $design = $('#design_pre').val();
            var $design_pre = $design.split('|');
            var $nativeW = $design_pre[0];

            var $design_2 = $('#design_pre_2').val();
            var $design_pre_2 = $design_2.split('|');
            var $nativeW_2 = $design_pre_2[0];

            $('#side-1 .cp-input-gen').each( function(){
                var $size = parseFloat( $(this).find('pre').attr('native-size'));
                $(this).find('pre').css('font-size', self.adjustFont($nativeW, $size) + 'px');
                $(this).find('pre').css('line-height', self.adjustFont($nativeW, $size) + 'px');
            });

            $('#side-2 .cp-input-gen').each( function(){
                var $size = parseFloat( $(this).find('pre').attr('native-size'));
                $(this).find('pre').css('font-size', self.adjustFont($nativeW_2, $size) + 'px');
                $(this).find('pre').css('line-height', self.adjustFont($nativeW_2, $size) + 'px');
            });
        },
        timerLoader: function(l){
            var self = this;
            l++
            $('.txt-load').text(l+'%');
            $('#loader-start span').width(l+'%');
            if( l < 100 )
                setTimeout( function(){
                    self.timerLoader(l);
                }, 20);
        },
        loadActiveImg:function(){
            var $ids = $('.lst-tags .active').attr('id');
            $('.lst-img ul li.'+$ids).each(function(){
                var $this = $(this);
                if( $(this).attr('dssrc') != '' && $(this).attr('dssrc') != 'undefined') {
                    $(this).find('img').attr('src', $(this).find('img').attr('dssrc') ).on('load', function() {
                       $this.find('a').attr('style','background-image:url("'+ $this.find('img').attr('src')+'")');
                       $this.find('.on-process-load').remove();
                       $(this).remove();
                    });
                }
            });
        },
        updateBackground: function(){
            if( active_bg == '1') {
                var $src_img = $('.js-qv-mask .thumb-container .thumb.js-thumb').attr('data-image-large-src');
                $('#side-1 .img-src').attr('src', $src_img);
                if( $('#side-2 .img-src')[0] ) {
                    var $src_img_2 = $('.js-qv-mask .thumb-container:last .thumb.js-thumb').attr('data-image-large-src');
                    $('#side-2 .img-src').attr('src', $src_img_2);
                    $('.switcher .side-1 img').attr('src', $src_img);
                    $('.switcher .side-2 img').attr('src', $src_img_2);
                }
                
            } 
        },
        // Select Device
        chooseDevice:function(){
            var self=this;
            $(document).on('click','.cp-get-canvas',function(e){
                $('#lft-side,#right-side').hide();
                $('html,body').animate({scrollTop:0},500);
                //$('#cp-ct-step>div').hide();
                
                $('#wrap-phone').append('<div class="cp-loader" style="position:fixed;left:0;top:0;right:0;bottom:0;z-index:900000;"><div style="position:absolute;left:0;top:0;bottom:0;right:0;background:#fff; opacity:1;filter:alpha(opacity=100);"></div><div style="position:absolute; left:50%; top:50%; -ms-transform: translate(-50%,-50%); -webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);"><span class="txt-load"></span><div style="width:100px;height:17px;margin:0 auto 5px;" id="loader-start"><span class="spin-c" style="display: block;height: 14px;width: 1px;"></span></div><p style="font-weight: bold;font-size: 14px;color: #000;text-align: center;">'+loading_text+'</p></div></div>');
                $('.cp-layout').css({'top':'20px','opacity':0});
                $('#cp-phone').css({'margin-top':'-15px','opacity':0});
                $('#wrap-phone-pop').fadeIn('pretty');
                //$('.prix-q span').html( '<span class="odometer">'+ $('.current-price>span[itemprop=price]').attr('content') +'</span> '+ prestashop.currency.sign);
                $('.prix-q span').html( $('.current-price>span[itemprop=price]').attr('content') );
                $('.sign-cur').remove();
                $('.prix-q').append( '<samp class="sign-cur">'+prestashop.currency.sign+'</samp>' );
                self.loadActiveImg();
                self.timerLoader(1);
                setTimeout(function(){
                    $('body').addClass('ovhidden');
                    if( $(window).width() > 1023 ) {
                        $('.cp-mask-img>img, .img-src').css( 'max-height', ( $('#wrap-phone').height() - 200 ) + 'px' );
                    }

                    $('.cp-loader').fadeOut('fast', function() {
                        $('.cp-loader').remove();
                        $('.cp-layout').animate({'top':'0','opacity':1},400);
                        $('#cp-phone').animate({'margin-top':'0','opacity':1},800);
                        $('#lft-side,#right-side').fadeIn('pretty');
                    });
                    if ( $('.pre-design')[0] ) {
                        self.initFont();
                        $(window).resize(function(){
                            self.initFont();
                        });
                    }
                    self.updateBackground();
                    self.adjustRealPrice();
                },3000);
                return false;
            });
            $(document).on('click','.update-opt',function(e){
                if( allow_comb == '1') {
                    var $combinations_product = $('#add-to-cart-or-refresh .product-variants').html();
                    if( $.trim( $combinations_product ) != '' ) {
                        $('.list-combination-data>div>form.clone-form-comb').html( $combinations_product );
                    }
                    else 
                        $('.update-opt').hide();

                    $('.list-combination-data').fadeIn('pretty');
                }
                return false;
            });

            $(document).on('change','form.clone-form-comb select',function(e){
                var $ids = $(this).attr('id');
                var $val = $(this).val();
                $('.product-variants #'+ $ids).val( $val );
                $('.product-variants select').trigger('change');
                return false;
            });

            $(document).on('click','form.clone-form-comb input[type=radio]',function(e){
                var $ids = $(this).attr('name');
                var $val = $(this).val();
                $('.product-variants input[name="'+$ids+'"][value='+parseInt($val)+']').prop("checked", true);
                $('.product-variants input[type=radio]').trigger('change');
            });

            $(document).on('click','.done-combi',function(e){
                self.getLoader();
                setTimeout( function() {
                    self.updateBackground();
                    self.adjustRealPrice();
                    $('.cp-loader').remove();
                    $('.list-combination-data').fadeOut('pretty');
                    self.adjustRealPrice();
                }, 1500);
                return false;
            });
            //Help Button
            $(document).on('click','.cp-btn-help',function(e){
                var $ids = $(this).attr('data-video');
                var $video = "https://www.youtube.com/embed/" + $ids + "?enablejsapi=1";
                alertify.alert('<div class="video-presentation"><iframe src="'+$video+'" style="width:800px; height:450px"></iframe></div>');
                return false;
            });

            $(document).on('click','.alertify-cover',function(e){
                $('#alertify-ok').trigger('click');
            });

            $(document).on('click','#alertify-ok',function(e){
                setTimeout( function(){
                    $('#alertify, #alertify-cover').remove();
                }, 1000);
            });
        },

        dragImg: function(){
            var self = this;
            $('.jscroll a').pep({
              droppable: '.cp-gridme-cover .sqr',
              useCSSTranslation: false,
              revert: true,
              initiate: function(){
                this.$el.addClass('smallest');
              },
              start:function(){
                    this.$el.unbind('click').bind('click',function(){
                        return false;
                    });
              },
              stop:function(){
                $('.cp-gridme-cover .pep-dpa').eq(0).html('<span class="wrap-img-drag" style="background-image:url('+this.$el.attr("href")+');"><img src="'+this.$el.attr("href")+'" alt=""/><samp class="cp-h-v"><a href="javascript:void(0);" class="fa-stack fa-lg cp-modify" title="'+crop_pic+'"><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></a><a  title="'+delete_pic+'" href="javascrip:void(0);" class="fa-stack fa-lg cp-delete-fast"><i class="fa fa-trash-o"></i></a></samp></span>');
                $('.cp-gridme-cover .pep-dpa').eq(0).find('.sqr').css('visibility','visible');
                $('.cp-gridme-cover .pep-dpa').eq(0).find('.wrap-img-drag').addClass('no-visible');
                $('.cp-gridme-cover .pep-dpa').eq(0).find('.sqr').css('visibility','hidden');
                $('.cp-gridme-cover .pep-dpa').eq(0).find('.sqr').removeClass('cp-cibled-row');
                self.copyHtmlGrid();
                this.$el.removeClass('smallest');
                var $this = this;
                setTimeout(function(){
                    $this.$el.unbind('click').bind('click', function(event) {
                        var $inc=0;
                        var $this=$(this);
                        self.$elem.find('.cp-gridme *').remove();
                        if( self.$elem.find('.cp-cibled-row')[0] )
                        {
                            self.$elem.find('.cp-cibled-row').html('<span class="wrap-img-drag" style="background-image:url('+$this.attr("href")+');"><img src="'+$this.attr("href")+'" alt=""/><samp class="cp-h-v"><a href="javascript:void(0);" class="fa-stack fa-lg cp-modify" title="'+crop_pic+'"><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></a><a  title="'+delete_pic+'" href="javascrip:void(0);" class="fa-stack fa-lg cp-delete-fast"><i class="fa fa-trash-o"></i></a></samp></span>');
                            self.$elem.find('.sqr').css('visibility','visible');
                            self.$elem.find('.wrap-img-drag').addClass('no-visible');
                            self.$elem.find('.sqr').css('visibility','hidden');
                            self.$elem.find('.sqr').removeClass('cp-cibled-row');
                            self.copyHtmlGrid();
                        }
                        else if( self.$elem.find('.sqr')[0] )
                        {
                            self.$elem.find('.sqr').css('visibility','visible');
                            self.$elem.find('.sqr').each(function(index, val) {
                                var $is_fill=$.trim($(this).html());
                                if( ( !$is_fill || $is_fill=='undefined' || $is_fill==''  )  && $inc==0 )

                                {

                                    var $this_e=$(this);

                                    $(this).html('<span class="wrap-img-drag" style="background-image:url('+$this.attr("href")+');"><img src="'+$this.attr("href")+'" alt=""/><samp class="cp-h-v"><a href="javascript:void(0);" class="fa-stack fa-lg cp-modify"  title="'+crop_pic+'"><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></a><a href="javascrip:void(0);" class="fa-stack fa-lg cp-delete-fast" title="'+delete_pic+'"><i class="fa fa-trash-o"></i></a></samp></span>');

                                    $this_e.find('.wrap-img-drag').addClass('no-visible');

                                    self.$elem.find('.sqr').css('visibility','hidden');

                                    $(this).removeClass('cp-cibled-row');

                                    $inc+=1;

                                }

                            });
                            self.copyHtmlGrid();
                        }
                        else{
                            alertify.alert(must_select_layout);
                        }
                        return false;
                    });

                },1000);
              }
            });
        },

        // Select Model
        chooseModel:function(){
            var self=this;
            $(document).on('click','.cp-model a',function(e){
                var $this = $(this);
                var $name_img_mask = $(this).find('span.img-find-mask').text();
                self.$elem.find('.cp-price').text($(this).find('.price-prod').text());
                self.$elem.find('.cp-token').val($(this).attr('id'));
                self.getLoader();
                self.$elem.find('.cp-mask-img').children('img').attr('src',$name_img_mask);
                self.$elem.find('.cp-model a').removeClass('active');
                $this.addClass('active');
                setTimeout(function(){
                        $('#cp-st-2').removeClass('cp-current-step');
                        $('#cp-st-3').addClass('cp-active cp-current-step');
                        $('#step2').hide();
                        $('#step3').fadeIn('pretty');
                        $('.cp-loader').fadeOut('fast', function() {
                            $('.cp-loader').remove();
                        });
                    },1000);
            });
            return false;
        },

        // Select Layout
        chooseLayout:function(){
            var self=this;
            $(document).on('click','.free-layout',function(e){
                self.$elem.find('.currentspace').append(self.getLoader());
                self.$elem.find('.currentspace .cp-gridme').html(' ');
                $('.currentspace').addClass('anywere');
                $('.currentspace .cp-gridme-cover *, .currentspace .cp-gridme *').remove();
                self.$elem.find('#cp-sel-layout a').removeClass('active');
                jQuery(this).addClass('active');
                setTimeout(function(){
                    $('.cp-btn-action').hide();
                    $('#cp-st-1').removeClass('cp-current-step');
                    $('#cp-st-2').addClass('cp-current-step');
                    $('#step1').hide();
                    $('#step2').fadeIn('pretty');
                    self.$elem.find('#cp-sel-Text').show();
                    self.adjustRealPrice();
                    $('.cp-loader').fadeOut('fast', function() {
                        $('.cp-loader').remove();
                    });
                },500);
                return false;
            });

            $(document).on('click','.cp-choose-grid-button',function(e){
                var $name_txt_grid=$(this).find('span.title-find').text();
                if( $(window).width() < 980 )
                    $('body').append('<div class="cp-loader" style="position:absolute;left:0;top:0;right:0;bottom:0;z-index:9999999999;"><div style="position:absolute;left:0;top:0;bottom:0;right:0;background:#fff; opacity:0;filter:alpha(opacity=0);"></div><div class="lds-ring" style="position:absolute;top:50%;left:50%;margin:-22px 0 0 -22px;"><div></div><div></div><div></div><div></div></div></div>');
                else 
                    self.getLoader();

                self.$elem.find('.currentspace .cp-gridme').html(' ');
                self.$elem.find('#cp-sel-layout a').removeClass('active');
                $('.currentspace').removeClass('anywere');
                jQuery(this).addClass('active');
                $.ajax({
                    url: self.setting.path_to_modules+'views/img/config/layout/'+$name_txt_grid+'/grid.html',
                    context: document.body
                }).done(function(data) {
                    self.$elem.find('.currentspace .cp-gridme, .currentspace .cp-gridme-cover').html(data);
                    setTimeout(function(){
                        $('.cp-btn-action').fadeIn('slow');
                        $('#cp-st-1').removeClass('cp-current-step');
                        $('#cp-st-2').addClass('cp-active cp-current-step');
                        $('#step1').hide();
                        $('#step2').fadeIn('pretty');
                        self.$elem.find('#cp-sel-Text').show();
                        $('.cp-loader').fadeOut('fast', function() {
                            $('.cp-loader').remove();
                        });
                        $('.navigation-mobile li').removeClass('active');
                        $('.navigation-mobile li a.step2').parent().addClass('active');
                    },1000);
                });
                e.preventDefault();

            });

        },

        // Load Device
        initPosition:function(){
            $('#cp-input-gen').css({'left':'40px','top':'100px'});
            $('#load-me').fadeOut('pretty',function(){
                $('#load-me').remove();
            });
            // Call Data From Apple Json File
            //this.loadDeviceFromJson(this.setting.path_to_modules+'config/device/data_apple.json','#cp-apple-dev .cp-device');
            // Call Data From Android Json File
            //this.loadDeviceFromJson(this.setting.path_to_modules+'config/device/data_android.json','#cp-android-dev .cp-device');
        },
        // Load Data Device From Json File
        loadDeviceFromJson:function(path_file,selector_bloc){

            var self=this;

            $.getJSON(path_file, function(data) {

                var $html_tags='';

                var $i=0;

                $.each(data.d, function(index, val) {

                     $html_tags='<li><a href="" class="cp-choose-dev-button"><img src="'+self.setting.path_to_modules+'config/device/thumbnail/'+val[0]+'" alt=""><span class="tit-prod">'+index+'</span><span style="display:none;" class="img-find-mask">'+val[1]+'</span><span style="display:none;" class="img-find">'+val[2]+'</span></a></li>';

                     $(selector_bloc).append($html_tags);

                     $i++;

                });

            });

        },
        // Load Data Device From Json File
        eventModuleExtra:function(){
            var self = this;
            $(document).on('click','.selected-typo', function(event) {
                $(this).toggleClass('active');
                $('.cp-list-font').fadeToggle('fast');
                $('.ico-col').removeClass('active');
                $('.cp-list-color ul').hide();
                return false;
            });

            $(document).on('click','.ico-col', function(event) {
                $('.selected-typo').removeClass('active');
                $('.cp-list-font').hide();
                $(this).toggleClass('active');
                $('.cp-list-color ul').fadeToggle('fast');
                return false;
            });

            $(document).on('click','#cp-align-txt a', function(event) {
                if( $(this).hasClass('a-left') ) $('.current-txt pre').css('text-align','left');
                else if( $(this).hasClass('a-right') ) $('.current-txt pre').css('text-align','right');
                else if( $(this).hasClass('a-center') ) $('.current-txt pre').css('text-align','center');
                return false;
            });
        },

        // Load Layout From Json
        loadLayout:function(){
            var self=this;
            /*
            $.getJSON(self.setting.path_to_modules+'views/img/config/layout/data.json', function(data) {
                var $html_tags='<li><a href="" class="free-layout" title="free layout"><img src="'+self.setting.path_to_modules+'views/img/free.png"/></a></li>';
                $.each(data.d, function(index,val) {
                     $html_tags+='<li><a href="" class="cp-choose-grid-button"><img src="'+self.setting.path_to_modules+'views/img/config/layout/'+val+'/grid.png"/><span class="title-find" style="display:none">'+val+'</span></a></li>';
                });
                self.$elem.find('#cp-sel-layout').children('ul').append($html_tags);
            });
            */
        },



        // Upload Other Image

        uploadOtherImg:function(){
            var url = baseUri+'index.php?fc=module&module=cdesigner&controller=uploadfront'; //url to upload image
            var self=this;
            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                add: function (e, data) {

                    var runUpload = true;

                    var uploadFile = data.files[0];

                    if (!(/\.(gif|jpg|png|tiff|png|jpeg|GIF|JPG|PNG|TIFF|JPEG)$/i).test(uploadFile.name)) {

                        alertify.alert(image_only);

                        runUpload = false;

                    }

                    else if (uploadFile.size > 12000000) { // 4mb

                        alertify.alert(max_size);

                        runUpload = false;

                    }

                    if (runUpload == true) {

                        $('#cp-img-lo-w').show();

                        $('.cp-loader-number').text(' ');

                        data.submit();

                    }

                },

                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        var $this
                        $('#cp-sel-Photos ul').prepend('<li class="from-desktop"><a href="'+file.url+'" style="background-image:url('+file.thumbnailUrl+');"><span class="on-process-load"></span><i class="fa fa-plus"></i></a></li>');
                        $('.from-desktop').eq(0).find('a').trigger('click');
                        $('<img/>').attr('src', file.url).on('load', function() {
                           $(this).remove();
                           $('.from-desktop .on-process-load').remove();
                        });

                    });
                },

                progressall: function (e, data) {

                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    $('.cp-loader-number').text(progress + '%');

                },
                stop:function(){
                    setTimeout(function(){
                        $('#cp-img-lo-w').fadeOut('slow');
                        $('.cp-loader-number').text(' ');
                        $('.lst-tags a').removeClass('active');
                        $('#from-desktop').show();
                        $('#from-desktop').addClass('active');
                        self.findTags();

                    },1000);

                }

            });

        },


        // Add Image To Device

        putImageToDevice:function(){
            var $is_fill='';
            var $inc=0;
            var self=this;
            var src_img;
            var $this;
            var $now;
            var width_img;
            var height_img;
            var params;

            $(document).on('click','.btn-delete-img-cr', function(event) {
                $(this).closest('.squared').remove();
                self.copyHtmlGrid();
                //$('.navigation-btn').hide();
                return false;
            });
            $(document).on('click','.order-by-slice', function(event) {
                var max = 0;
                var value = 0;
                $('.squared').each(function(){
                    value = parseInt($(this).css('z-index'));
                    if(value > max ) max = value;
                });
                $(this).closest('.squared').css('z-index',parseInt(max+1) ) ;
                self.copyHtmlGrid();
                event.preventDefault();
            });
            //Add Image To Row
            $(document).on('click','#cp-sel-Photos ul li a', function(event) {
                event.preventDefault();
                Date.now = function() { return new Date().getTime(); }
                var $now = Math.floor(Date.now() / 1000);

                self.$elem.find('.currentspace').append(self.getLoader());
                if( $('.currentspace').hasClass('anywere') )
                {
                    if( $(window).width() < 980  )
                        $('body').append('<img src="'+$(this).attr("href")+'" id="tmp-img" style="visibility:hidden; height:130px;"/>');
                    else
                        $('body').append('<img src="'+$(this).attr("href")+'" id="tmp-img" style="visibility:hidden; width:130px;"/>');
                    var $this = $(this);
                    $('#tmp-img').load(function(){
                        var hs = parseInt($('#tmp-img').height());
                        var ws = parseInt( $('#tmp-img').width() );
                        $('#tmp-img').remove();

                        var max = 0;
                        var value = 0;
                        $('.squared').each(function(){
                            value = parseInt($(this).css('z-index'));
                            if(value > max ) max = value;
                        });
                        var ratio = '';
                        if( ws > hs ) ratio = '16:9';
                        else if ( ws < hs ) ratio = '9:16';
                        else ratio = '1:1';

                        $('.currentspace .cp-gridme-cover').append('<div class="squared v_'+$now+'" data-ratio="'+ ratio +'" style="display:inline-block;left:15%;top:15%;z-index:'+parseInt(max+1)+'">\
                          <img data-embeded="auto" src="'+$this.attr("href")+'" class="img-h" style="width:'+ws+'px;height:'+hs+'px;"/>\
                          <a href="" class="btn-delete-img-cr"></a><a href="" class="order-by-slice"></a>\
                          <ul class="navigation-btn">\
                                <li><a href="javascript:void(0);" class="rotate-left"><i class="fa fa-undo"></i></a></li>\
                                <li><a href="javascript:void(0);" class="rotate-right"><i class="fa fa-repeat"></i></a></li>\
                                <!--li><a href="javascript:void(0);" class="delete-img-dash"><i class="fa fa-trash-o"></i></a></li-->\
                            </ul>\
                        </div>');

                        self.copyHtmlGrid();
  
                        $( ".v_"+$now+" .img-h" ).load(function() {
                            width_img = $( ".v_"+$now+" .img-h" ).width();
                            height_img = $( ".v_"+$now+" .img-h" ).height();
                            $( ".v_"+$now+" .img-h" ).resizable({
                                  aspectRatio: width_img / height_img,
                                  //containment: "#cp-sel-Device",
                                  create: function( event, ui ) { 
                                    self.copyHtmlGrid();
                                  },
                                  resize: function(event, ui){
                                    self.copyHtmlGrid();
                                  },
                                  stop:function(){
                                    self.copyHtmlGrid();
                                  }
                            });
                            $('.cp-loader').fadeOut('fast', function() {
                                $('.cp-loader').remove();
                            });
                        });
                        
                        $( ".v_"+$now ).draggable({
                        //containment: "#cp-sel-Device",
                          drag:function(){
                            $('.currentspace .cp-gridme *').remove();
                            $('.squared.selected').removeClass('selected');
                            $(this).addClass('selected');
                            $('.currentspace .cp-gridme-cover').addClass('someone-selected');
                            //$('.navigation-btn').fadeIn('pretty');
                          },
                          stop:function(){
                            self.copyHtmlGrid();
                          },
                          scroll: false
                        });

                        /*
                        params = {
                            start: function(event, ui) {
                                self.copyHtmlGrid();
                            },
                            rotate: function(event, ui) {
                                $('.currentspace  .cp-gridme *').remove();
                            },
                            stop: function(event, ui) {
                                self.copyHtmlGrid();
                            },
                            scroll: false
                        };*/
                        //$( ".v_"+$now ).rotatable(params);
                        
                    });
                }
                else
                {
                    $inc=0;
                    $this=$(this);
                    $('body').append('<img src="'+$(this).attr("href")+'" id="tmp-img" style="visibility:hidden;"/>');
                    self.$elem.find('.currentspace .cp-gridme *').remove();

                    if( $('.allow-zone')[0] ) {
                        var $tags = $('.lst-tags>a.active').attr('data-tagid');
                        $('.currentspace .sqr').removeClass('cp-cibled-row');
                        $('.currentspace .sqr[data-tags='+$tags+']').addClass('cp-cibled-row');
                    } 

                    if( self.$elem.find('.currentspace .cp-cibled-row')[0] )
                    {
                        self.$elem.find('.currentspace .cp-cibled-row').addClass('filledm');  //arecop

                        self.$elem.find('.currentspace .cp-cibled-row').html('<span class="wrap-img-drag" style="background-image:url(\''+$this.attr("href")+'\');"><img data-embeded="auto" src="'+$this.attr("href")+'" alt=""/><samp class="cp-h-v"><a href="javascript:void(0);" class="fa-stack fa-lg cp-modify" title="'+crop_pic+'"><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></a><a  title="'+delete_pic+'" href="javascrip:void(0);" class="fa-stack fa-lg cp-delete-fast"><i class="fa fa-trash-o"></i></a></samp></span>');
                        self.$elem.find('.currentspace .sqr').css('visibility','visible');
                        self.$elem.find('.currentspace .wrap-img-drag').addClass('no-visible');
                        self.$elem.find('.currentspace .sqr').css('visibility','hidden');
                        if( !$('.pre-design')[0] ) 
                            self.$elem.find('.currentspace .sqr').removeClass('cp-cibled-row');
                        
                        self.copyHtmlGrid();
                    }
                    else if( self.$elem.find('.sqr')[0] )
                    {
                        self.$elem.find('.currentspace .sqr').css('visibility','visible');
                        self.$elem.find('.currentspace .sqr').each(function(index, val) {
                            $is_fill=$.trim($(this).html());
                            if( ( !$is_fill || $is_fill=='undefined' || $is_fill=='' ||  self.$elem.find('.currentspace .cp-gridme-cover .sqr').size() == 1 )  && $inc==0 )
                            {
                                var $this_e=$(this);

                                $(this).addClass('filledm'); //arecop

                                $(this).html('<span class="wrap-img-drag" style="background-image:url(\''+$this.attr("href")+'\');"><img src="'+$this.attr("href")+'" alt=""/><samp class="cp-h-v"><a href="javascript:void(0);" class="fa-stack fa-lg cp-modify"  title="'+crop_pic+'"><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></a><a href="javascrip:void(0);" class="fa-stack fa-lg cp-delete-fast" title="'+delete_pic+'"><i class="fa fa-trash-o"></i></a></samp></span>');

                                $this_e.find('.wrap-img-drag').addClass('no-visible');

                                self.$elem.find('.currentspace  .sqr').css('visibility','hidden');

                                $(this).removeClass('cp-cibled-row');

                                $inc+=1;

                            }

                        });

                        self.copyHtmlGrid();

                    }
                    else{
                        alertify.alert(must_select_layout);
                    }

                    $('#tmp-img').load(function(){
                        $('.cp-loader').fadeOut('fast', function() {
                            $('.cp-loader').remove();
                            $('#tmp-img').remove();
                        });
                    });
                }

                if( $(window).width() < 980 ){
                    $('.navigation-mobile li').removeClass('active');
                    $('#lft-side').removeClass('show-me');
                }

                self.adjustRealPrice();
                return false;

            });



            self.$elem.find('#cp-sel-Photos ul li a').each(function(index, val) {

                src_img=$(this).children('img').attr('src');

                $(this).attr('href',src_img).css('background-image','url('+src_img+')');

            });

            //Select Row
            $(document).on('click','.sqr', function(e) {
                //var $txt=$.trim($(this).html());
                if( !$(this).hasClass('cp-cibled-row') ) 
                    self.$elem.find('.sqr').removeClass('cp-cibled-row');
                
                if( $('.pre-design')[0])
                    $(this).addClass('cp-cibled-row');
                else {
                    $(this).toggleClass('cp-cibled-row');
                    $('#cp-link-step>li').removeClass('cp-current-step').removeClass('cp-active');
                    $('#cp-st-2').addClass('cp-current-step');
                    $('#cp-st-2').addClass('cp-active');

                    $('#cp-ct-step>div').hide();
                    $('#step2').show();
                }

                self.copyHtmlGrid();
                e.preventDefault();

            });
        },

        // Delete Image
        deleteImg:function(){
            var self=this;
            $(document).on('click','#cp-btn-delete',function(e){
                $('.cp-wpreviw').closest('.sqr').removeClass('filledm'); //arecop

                self.$elem.find('#cp-sel-Text').show();
                $('.cp-wpreviw').closest('span').remove();
                
                self.$elem.find('#cp-crop-image').hide();
                self.$elem.find('#cp-cropit-me *').remove();
                self.copyHtmlGrid();
                e.preventDefault();
            });

            $(document).on('click','.cp-delete-fast',function(e){

                $(this).closest('.sqr').removeClass('filledm'); //arecop

                $(this).closest('span').remove();

                self.copyHtmlGrid();

                e.preventDefault();

            });

        },



        // Crop Image
        cropImg:function(){
            var one;
            var self=this;
            $(document).on('click','.cp-gridme-cover .cp-modify',function(e){
                $('#cp-link-step>li').removeClass('cp-current-step').removeClass('cp-active');
                $('#cp-st-2').addClass('cp-current-step');
                $('#cp-st-2').addClass('cp-active');

                $('#cp-ct-step>div').hide();
                $('#step2').show();

                self.getLoader();
                $('#cp-crop-image').append('<div class="cp-loader" style="position:absolute;left:0;top:0;right:0;bottom:0;z-index:90000;"><div style="position:absolute;left:0;top:0;bottom:0;right:0;background:#fff;"></div><div class="lds-ring" style="position:absolute;top:50%;left:50%;margin:-22px 0 0 -22px;"><div></div><div></div><div></div><div></div></div></div>');
                var $this = $(this);
                self.$elem.find('#cp-crop-image').fadeIn('pretty', function(){
                    $this.closest('.wrap-img-drag').find('img').wrap('<samp class="cp-wpreviw preview"><samp>');
                    var $img = $this.closest('.wrap-img-drag').find('img').attr('src');
                            $('#cp-cropit-me').html('<div class="cp-preview" id="cp-main"><div id="cp-device-ori-prev"></div></div><div class="eg-wrapper img-container">\
            \
                                                       <img class="cropper" src="'+$img+'" alt="">\
            \
                                                    </div>\
            \
                                                    <div class="eg-button" id="actions">\
                                                      <div class="docs-buttons">\
                                                        <!--a href="javascript:void(0);" id="reset" title="reset"><span class="fa-stack fa-lg"><i class="fa fa-refresh fa-stack-2x"></i></span></a-->\
            \
                                                        <a href="javascript:void(0);" id="zoomIn" data-method="zoom" data-option="0.1" title="zoom in"><span class="fa-stack fa-lg"><i class="fa fa-search-plus fa-stack-2x"></i></span></a>\
            \
                                                        <a href="javascript:void(0);" id="zoomOut" data-method="zoom" data-option="-0.1"  title="zoom out"><span class="fa-stack fa-lg"><i class="fa fa-search-minus fa-stack-2x"></i></span></a>\
                                                        <a href="javascript:void(0);" id="rotateLeft"  data-method="rotate" data-option="-90" title="rotate left"><span class="fa-stack fa-lg"><i class="fa fa-undo fa-stack-2x"></i></span></a>\
            \
                                                        <a href="javascript:void(0);" id="rotateRight" data-method="rotate" data-option="90"  title="rotate right"><span class="fa-stack fa-lg"><i class="fa fa-repeat fa-stack-2x"></i></span></a>\
                                                        <a id="cp-btn-delete" href="javascript:void(0);"><span class="fa-stack fa-lg"><i class="fa fa-trash-o fa-stack-2x"></i></span></a><a class="cp-btn-cancel" href="javascript:void(0);">'+back_string+'</a><a class="cl-validate-crop" href="javascript:void(0);">'+ok_string+'</a>\
                                                       </div>\
                                                    </div>\
            \
                                                    ');
                    self.$elem.find('.cp-preview #cp-device-ori-prev').html($('#cp-device-ori').html());

                    $(' #cp-device-ori-prev .currentspace .cp-gridme').html( $(' #cp-device-ori-prev .currentspace .cp-gridme-cover').html());

                    var wd = $this.closest('.sqr').width() / 2;
                    var hd = $this.closest('.sqr').height() / 2;
                    var ratio = wd / hd;
                    setTimeout(function(){
                        var container = document.querySelector('.img-container');
                        var image = container.getElementsByTagName('img').item(0);
                        var options = {
                            aspectRatio: ratio,
                            preview: ".preview",
                            dragMode: "move",
                            viewMode: 1
                          };
                        var cropper = new Cropper(image, options);
                        var actions = document.getElementById('actions');
                        actions.querySelector('.docs-buttons').onclick = function (event) {
                            var e = event || window.event;
                            var target = e.target || e.srcElement;
                            var cropped;
                            var result;
                            var input;
                            var data;

                            if (!cropper) {
                              return;
                            }

                            while (target !== this) {
                              if (target.getAttribute('data-method')) {
                                break;
                              }

                              target = target.parentNode;
                            }

                            if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
                              return;
                            }

                            data = {
                              method: target.getAttribute('data-method'),
                              target: target.getAttribute('data-target'),
                              option: target.getAttribute('data-option') || undefined,
                              secondOption: target.getAttribute('data-second-option') || undefined
                            };

                            cropped = cropper.cropped;

                            if (data.method) {
                              if (typeof data.target !== 'undefined') {
                                input = document.querySelector(data.target);

                                if (!target.hasAttribute('data-option') && data.target && input) {
                                  try {
                                    data.option = JSON.parse(input.value);
                                  } catch (e) {
                                    console.log(e.message);
                                  }
                                }
                              }

                              switch (data.method) {
                                case 'rotate':
                                  if (cropped && options.viewMode > 0) {
                                    cropper.clear();
                                  }

                                  break;

                                case 'getCroppedCanvas':
                                  try {
                                    data.option = JSON.parse(data.option);
                                  } catch (e) {
                                    console.log(e.message);
                                  }

                                  if (uploadedImageType === 'image/jpeg') {
                                    if (!data.option) {
                                      data.option = {};
                                    }

                                    data.option.fillColor = '#fff';
                                  }

                                  break;
                              }

                              result = cropper[data.method](data.option, data.secondOption);

                              switch (data.method) {
                                case 'rotate':
                                  if (cropped && options.viewMode > 0) {
                                    cropper.crop();
                                  }

                                  break;

                                case 'scaleX':
                                case 'scaleY':
                                  target.setAttribute('data-option', -data.option);
                                  break;

                                case 'getCroppedCanvas':
                                  if (result) {
                                    // Bootstrap's Modal
                                    $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                                    if (!download.disabled) {
                                      download.download = uploadedImageName;
                                      download.href = result.toDataURL(uploadedImageType);
                                    }
                                  }

                                  break;

                                case 'destroy':
                                  cropper = null;

                                  if (uploadedImageURL) {
                                    URL.revokeObjectURL(uploadedImageURL);
                                    uploadedImageURL = '';
                                    image.src = originalImageURL;
                                  }

                                  break;
                              }

                              if (typeof result === 'object' && result !== cropper && input) {
                                try {
                                  input.value = JSON.stringify(result);
                                } catch (e) {
                                  console.log(e.message);
                                }
                              }
                            }
                          };
                          $('.cp-loader').fadeOut('pretty', function(){
                                $('.cp-loader').remove();
                          });
                        return false;
                    },500);
                });
            });
            $(document).on('click', '.cl-validate-crop', function() {

                //self.$elem.find('#cp-sel-Text').show();

                $('.cp-wpreviw').closest('span').css('background-image','none');

                $('.cp-wpreviw img').addClass('cp-show-a-crop');

                $('.cp-wpreviw img').unwrap();

                self.copyHtmlGrid();

                self.$elem.find('#cp-crop-image').hide();

                self.$elem.find('#cp-cropit-me *').remove();
                $('.btn-close-mobile').trigger('click');

                return false;

            });



            $(document).on('click', '.cp-btn-cancel', function() {

                self.$elem.find('#cp-sel-Text').show();

                $('.cp-wpreviw img').unwrap();

                self.$elem.find('#cp-crop-image').hide();

                self.$elem.find('#cp-cropit-me *').remove();
                $('.btn-close-mobile').trigger('click');

                return false;

            });
        },
        // Process Step Text
        getText:function(){ 
            if( $.trim($('.cp-input-txt').val()) != '' ){
                var txt_clean = $('.cp-input-txt').val().replace(/([\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, '');
                var $val_txt=$.trim( txt_clean );
                var $font = ( !$('.cp-list-font a.active')[0] ) ? $('.cp-list-font a').eq(0).attr('id') : $('.cp-list-font a.active').attr('id');
                var $color = ( !$('.cp-active-color-t')[0] ) ? '#'+$('.cp-list-color ul li').eq(0).find('a').attr('id') : '#'+$('.cp-active-color-t').attr('id');
                var $taille = $('#cp-size-txt .active').attr('id');
                var $classes= $taille;
                var $widthS = $('.currentspace').width();
                var $heightS = $('.currentspace').height();
                if (!Date.now) {
                    Date.now = function() { return new Date().getTime(); }
                }
                var $date_now = parseInt(Date.now() / 1000);
                var $stop = parseFloat( ($('.currentspace .cp-gridme').position().top  * 100 ) / $heightS ) + 30; 
                var $sleft = parseFloat( ($('.currentspace .cp-gridme').position().left * 100) / $widthS ) + 20; 
                $('.currentspace').append('<div id="cp-input-gen_'+$date_now+'" class="current-txt cp-input-gen" style="top:'+$stop+'%;left:'+$sleft+'%"><pre></pre><a href="" class="delete-txt"></a></div>');
                //$('#cp-input-gen_'+$date_now+' pre').attr('class',$classes);
                $('#cp-input-gen_'+$date_now+' pre').css({'color':$color, 'font-family' : $font});
                $('#cp-input-gen_'+$date_now+' pre').text($val_txt);
                $('#cp-input-gen_'+$date_now+' pre').data('color',$color);

                $('.new-txt').fadeIn('pretty');
                $('.add-txt').hide();

                if( $(window).width() < 980 ) { 
                    $('.cp-input-txt').css({'font-family' : $font, 'color' :$color, 'font-size' : $classes });
                    $('.save-txt').fadeIn('pretty');
                    $('.add-txt').hide();
                }
                
                $('.cp-input-gen').each(function(){
                    var $thiss = $(this);
                    $(this).draggable({
                      containment: ".currentspace .cp-gridme",  
                      drag:function(){
                        $('.cp-input-gen').removeClass('current-txt');
                        $(this).addClass('current-txt');
                        $('.cp-input-gen').removeClass('current-txt');
                        $(this).addClass('current-txt');
                        $('.cp-input-txt').val($(this).find('pre').text());
                        $('.new-txt').fadeIn('pretty');
                        $('.add-txt').hide();

                        if( $(window).width() < 980 ) {
                            $('.save-txt').fadeIn('pretty');
                        }

                        var get_font = $(this).find('pre').css('font-family');
                        var get_font_2 = get_font.replace(/"/g, '');
                        var get_color = $(this).find('pre').data('color');
                        var get_size = $(this).find('pre').attr('class');

                        //$('.cp-list-font a').removeClass('active');
                        $('.selected-typo span').text(get_font);
                        
                        $('#'+get_font_2).addClass('active');

                        $('.cp-list-color ul a').removeClass('cp-active-color-t');
                        $(get_color).addClass('cp-active-color-t');

                        $('#cp-size-txt a').removeClass('active');
                        $('#'+get_size).addClass('active');
                      },
                      stop:function(){
                        var $left = parseFloat( $thiss.css('left') );
                        var $top = parseFloat( $thiss.css('top') );
                        var $fleft = ($left * 100) / $widthS;
                        var $ftop = ($top * 100) / $heightS;
                        $thiss.css({'left' : $fleft + '%', 'top' : $ftop + '%'});
                      },
                      scroll: false
                    });
                    $(this).rotatable();
                });

            }
        },

        // Process Step Current Text
        getCurrentText:function(){
            if( $.trim($('.cp-input-txt').val()) != '' || $('.pre-design')[0] ){
                var $val_txt=$.trim($('.cp-input-txt').val());
                var $font=$('.cp-list-font a.active').attr('id');
                var $color='#'+ $('.cp-active-color-t').attr('id');
                var $taille=$('#cp-size-txt .active').attr('id');
                var $classes= $taille;
                var $classes_p= ' cp-input-gen current-txt';
                $('.current-txt').attr('class',$classes_p);
                $('.current-txt pre').attr('class',$classes);
                $('.current-txt pre').css({'color':$color, 'font-family' : $font});
                $('.current-txt pre').text($val_txt);
                $('.current-txt pre').data('color',$color);

                if( $(window).width() < 980 ) { 
                    $('.cp-input-txt').css({'font-family' : $font, 'color' : $color, 'font-size' : $classes });
                }
                if( $('.current-txt')[0] ) this.adjustRealPrice(); 
            }
        },

        // Put Text Into Device
        putTextDevice:function(){
            var self=this;
            $('.add-txt').click(function(){
                $('.current-txt').removeClass('current-txt');
                if( $.trim($('.cp-input-txt').val()) != '' )
                {
                    
                    self.getLoader();
                    self.getText();

                    if( $(window).width() < 980 ){
                        $('.navigation-mobile li').removeClass('active');
                        $('#lft-side').removeClass('show-me');
                        $('#right-side').removeClass('opened');
                    }

                    setTimeout(function(){
                        $('.cp-loader').remove();
                    }, 1200);
                }
                self.adjustRealPrice();
                return false;
            });

            var get_font, get_color, get_size, get_size_n, get_color_n;
            $(document).on('click','.cp-input-gen',function(){
                get_color_n = get_font = get_color = get_size = get_size_n = '';
                $('.cp-input-gen').removeClass('current-txt');
                $(this).addClass('current-txt');
                $('.cp-input-txt').val($(this).find('pre').text());
                $('.new-txt').fadeIn('pretty');
                $('.add-txt').hide();

                get_font = $(this).find('pre').css('font-family');
                get_color = $(this).find('pre').data('color');
                get_size = $(this).find('pre').attr('class');
                get_size_n = $(this).find('pre').css('font-size');
                get_color_n = $(this).find('pre').css('color');

                $('.cp-list-font a').removeClass('active');
                $('.selected-typo span').text(get_font);
                //$('#'+get_font).addClass('active');

                $('.cp-list-color ul a').removeClass('cp-active-color-t');
                //$('#'+get_color).addClass('cp-active-color-t');

                $('#cp-size-txt a').removeClass('active');
                $('#'+get_size).addClass('active');
                $('.cp-list-color > a svg').css('fill', get_color_n );
                if( $(window).width() < 980 ){ 
                    $('.cp-input-txt').css({'font-family' : get_font, 'color' : get_color_n, 'font-size' : get_size_n });
                }

                $('#cp-sel-Text').show();
                $('.cp-cibled-row').removeClass('cp-cibled-row');

                $('#cp-link-step>li').removeClass('cp-current-step').removeClass('cp-active');
                $('#cp-st-3').addClass('cp-current-step');
                $('#cp-st-3').addClass('cp-active');

                $('#cp-ct-step>div').hide();
                $('#step3').show();
                //return false;
            });

            $(document).on('click','.new-txt',function(e){
                $('.current-txt').removeClass('current-txt');
                $('.cp-input-txt').val('');
                $('.cp-input-txt').attr('style','');
                $(this).fadeOut('fast');
                $('.cp-list-color>ul').fadeOut('fast');
                $('.ico-col').removeClass('active');
                $('.save-txt').hide();
                $('.add-txt').show();
                return false;
            });

            $(document).on('keyup','.cp-input-txt',function(){
                self.getCurrentText();
                if( $('.pre-design')[0] ) {
                    var $limit = parseInt( $('.cp-input-gen.current-txt pre').attr('data-limit') );
                    if( $limit > 0) {
                        var str = $(this).val();
                        if( str.length > $limit ) { 
                            str = str.substring(0,$limit);
                            $(this).val(str);
                            $('.cp-input-gen.current-txt pre').text(str);
                        }
                    }
                }
                return false;
            });

            $(document).on('click','.delete-txt',function(){
                if( $(this).closest('.cp-input-gen').hasClass('current-txt') )
                {
                    $('.new-txt').trigger('click');
                    /*$('.cp-input-txt').val('');
                    $('.new-txt').fadeOut('fast');
                    $('.add-txt').show();
                    */
                }
                
                $(this).closest('.cp-input-gen').remove();
                self.adjustRealPrice();
                return false;
            });

            $(document).on('click','.cp-list-font a',function(){
                $('.cp-list-font a').removeClass('active');
                $(this).addClass('active');
                self.getCurrentText();
                $('.selected-typo').removeClass('active');
                $('.cp-list-font').fadeOut('fast');
                $('.selected-typo span').text( $(this).text() );
                return false;
            });

            $(document).on('click','.cp-list-color ul a',function(){
                $('.cp-list-color ul a').removeClass('cp-active-color-t');
                $(this).addClass('cp-active-color-t');
                $('.cp-list-color > a svg').css('fill', '#' + $(this).attr('id') );
                self.getCurrentText();

                
                if( $(window).width() < 980 ){
                    $('.cp-list-color ul').fadeOut('pretty');
                    $('.ico-col').removeClass('active');
                }
                return false;

            });

            $(document).on('click','#cp-size-txt a',function(){
                $('#cp-size-txt a').removeClass('active');
                $(this).addClass('active');
                self.getCurrentText();
                return false;
            });
        },

        // Copy Code From Grid
        copyHtmlGrid:function(){
            this.$elem.find('#side-1 .cp-gridme').html(this.$elem.find('#side-1 .cp-gridme-cover').html());
            this.$elem.find('#side-2 .cp-gridme').html(this.$elem.find('#side-2 .cp-gridme-cover').html());
            this.adjustRealPrice();
        },

        drawRotatedImage:function(image, x, y, w, h, angle, ctx) { 
            var TO_RADIANS = Math.PI/180; 
            ctx.save(); 
            ctx.translate(x, y);
            ctx.translate(parseInt(w/2), parseInt(h/2));
            ctx.rotate(angle * TO_RADIANS);
            ctx.drawImage(image, -parseInt(w/2), -parseInt(h/2), w, h);
            ctx.restore(); 
        },

        loadSprite:function(src) {
            var deferred = $.Deferred();
            var sprite = new Image();
            sprite.onload = function() {
                deferred.resolve();
            };
            sprite.src = src;
            return deferred.promise();
        },

        getFreeImage:function(){
            var img = [];
            var self = this;
            $('#cp-device-ori .cp-gridme .squared').each(function(index,val) {
                var $value_rotate = parseInt( self.getRotationDegrees( $(this) ) ); 
                var w = parseInt( $(this).find('.img-h').width() );
                var h = parseInt(  $(this).find('.img-h').height() );
                var t = parseInt( $(this).css('top') );
                var l = parseInt( $(this).css('left') );
                var z = parseInt( $(this).css('z-index') );
                var s =  $(this).find('.img-h').attr('src');
                $.ajax({
                      type: 'POST',
                      url: baseUri+'index.php?fc=module&module=cdesigner&controller=traitement',
                      data: {
                        state : 5,
                        id_input : 123,
                        id_output : 234,
                        loc : s,
                        rotate : $value_rotate
                      }, 
                      success: function(data) {
                        document.body.appendChild(data);
                      }
                });
                //img.push({ z:z, w:w , h:h, t:t , l:l, s:s, r: $value_rotate});
            });
            //img.sort(function(a,b) {return (a.z > b.z) ? 1 : ((b.z > a.z) ? -1 : 0);} );
            //return img;
        },

        createRotatedImage:function(img, angle) {
             angle = (angle == 'N') ?  -Math.PI/2 :
                     (angle == 'S') ?   Math.PI/2 :
                     (angle == 'W') ?   Math.PI   :
                      angle ;

            
             var newCanvas = document.createElement('canvas');
             newCanvas.width  = img.width  ;
             newCanvas.height = img.height ;
             var newCtx = newCanvas.getContext('2d') ;
             newCtx.save();
             newCtx.translate ( img.width / 2, img.height / 2) ;
             newCtx.rotate  (angle);
             newCtx.drawImage ( img, - img.width / 2, - img.height / 2) ; 
             newCtx.restore();
        },

        // Get Canvas Device From Step One
        getCanvasDevice:function(){
            var self=this;
            $(document).on('click','.cp-btn-save',function(e){
                var $size_row=$('.cp-gridme .sqr').size();
                var $size_img=$('.cp-gridme .wrap-img-drag').size();

                if( required_design == 1 ) {
                    if( $('.pre-design')[0] ) {
                        if( $size_row != $size_img ) {
                            alertify.alert( required_img_pre );
                            return false;
                        }

                        var stop = 0;
                        $('.cp-input-gen').each( function(){
                            var $txt = $(this).find('pre').text();
                            var $default = $(this).attr('data-default');
                            if( $.trim( $txt ) == '' || $txt == $default ) {
                                alertify.alert( required_text );
                                stop = 1;
                            }
                        });

                        if( stop == 1 ) 
                            return false;
                    } else {
                        if( ( $size_row != $size_img || $.trim( $('#cp-gridme').html() )  == '') 
                            && !$('.cp-input-gen')[0] ) {

                            alertify.alert( required_img );
                            return false;
                        }
                    }
                }
                $('img').removeAttr('loading');
                $('body').append('<div class="overlay-bg"><div class="loader-canvas"><span class="progress-title">'+on_process+'</span><div class="progress"></div><p class="progress-txt"></p></div></div>');
                $('.overlay-bg').width( $(window).width() );
                $('html,body').animate({scrollTop:0},500);
                $('.cp-gridme-cover').remove();
                $('.overlay-bg').fadeIn('pretty',function(){
                    $('.cp-gridme .sqr .wrap-img-drag img').show();
                    $('#cp-device-ori').addClass('no-bg-gen'); 
                      
                    $('body').append( '<div id="cp-device-ori-to-print"><div id="cp-device-ori" class="no-phone no-bg-gen">'  + $('#cp-device-ori').html() + '</div></div>');
                    $('#cp-device-ori-to-print #cp-device-ori').width( $('#cp-sel-Device #cp-device-ori').width() );  

                    self.centerImg_print();
                    $('html,body').animate({scrollTop:0},0);

                    if (!Date.now) {
                        Date.now = function() { return new Date().getTime(); }
                    }
                    var $date_now = parseInt(Date.now() / 1000);
                    $('body').append( '<div id="cp-device-ori-to-show"><div id="cp-device-ori" class="no-bg-gen">'  + $('#cp-device-ori').html() + '</div></div>');
                    if( $('#side-2')[0] ){
                        $('#side-1,#side-2').show();
                        var wo_1 = $('#side-1').width();
                        var wo_2 = $('#side-2').width();
                        $('#cp-device-ori-to-show #side-1').width( parseFloat(wo_1) );
                        $('#cp-device-ori-to-show #side-2').width( parseFloat(wo_2) );
                        $('#cp-device-ori-to-show #cp-device-ori').width( parseFloat(wo_1 + wo_2) );
                        self.centerImg();
                        self.storeProduct_2($date_now);  
                    }else{
                        $('#cp-device-ori-to-show #cp-device-ori').width( $('#cp-sel-Device #cp-device-ori').width());
                        self.centerImg();
                        self.storeProduct($date_now);
                    }

                    if( $('.pre-design')[0] ) {
                        $('#cp-device-ori-to-print #cp-device-ori').addClass('pre-design');
                        $('#cp-device-ori-to-show #cp-device-ori').addClass('pre-design');
                    }

                    self.createCombination($date_now);
                });
                e.preventDefault();
            });

            $(document).on('click','.squared',function(e){
                e.stopPropagation();
                $('.currentspace .squared').removeClass('selected');
                $(this).addClass('selected');
                $('.currentspace .cp-gridme-cover').addClass('someone-selected');
                $('#cp-link-step>li').removeClass('cp-current-step').removeClass('cp-active');
                $('#cp-st-2').addClass('cp-current-step');
                $('#cp-st-2').addClass('cp-active');

                $('#cp-ct-step>div').hide();
                $('#step2').show();
                //$('.navigation-btn').fadeIn('pretty');
            });

            $('html').click(function(e) {
                if( !$(e.target).hasClass('still-load') && !$(e.target).closest('.navigation-btn')[0] ) {
                    $('.currentspace .squared').removeClass('selected');
                    $('.currentspace .cp-gridme-cover').removeClass('someone-selected');
                    //$('.navigation-btn').fadeOut('pretty');
                }

                /*
                if( $('.pre-design')[0] )  {
                    if( $(window).width() > 767 ) {
                        if( !$(e.target).closest('#lft-side')[0] ) {
                            $('.cp-cibled-row').removeClass('cp-cibled-row');
                                $('#lft-side').addClass('no-img-filter');
                        }

                        if( !$(e.target).closest('#cp-textarea')[0] && !$(e.target).hasClass('cp-input-gen') ) {
                            $('.cp-input-gen.current-txt').removeClass('current-txt');
                            $('#cp-sel-Text').hide();
                        }
                    }
                }
                */
  
                if( $(window).width() < 980  && !$(e.target).closest('#cp-textarea')[0] && !$(e.target).hasClass('cp-input-gen') ) { 
                    $('.cp-input-gen').removeClass('current-txt');
                }

            });
        },

        getRotationDegrees : function (obj) {
            var matrix = obj.css("-webkit-transform") ||
            obj.css("-moz-transform")    ||
            obj.css("-ms-transform")     ||
            obj.css("-o-transform")      ||
            obj.css("transform");
            if(matrix !== 'none') {
                var values = matrix.split('(')[1].split(')')[0].split(',');
                var a = values[0];
                var b = values[1];
                var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
            } else { var angle = 0; }
            return (angle < 0) ? angle + 360 : angle;
        },

        //Store Custom Product
        storeProduct:function(output){
            var token = $('.cp-token').text().substr(2);
            var self = this;
            //size canvas
            var width_canvas = Math.round( parseFloat($('#wrap-phone #cp-sel-Device #cp-device-ori .currentspace').width()) * 0.0264583 * 100) / 100;
            var height_canvas = Math.round( parseFloat($('#wrap-phone #cp-sel-Device #cp-device-ori .currentspace').height()) * 0.0264583 * 100) / 100;
            var strcanvas = width_canvas+ '|'+ height_canvas;

            //text canvas
            var strfont = '';
            $('#cp-device-ori-to-show #cp-device-ori .currentspace .cp-input-gen').each(function(index, el) {
                var text = $(this).find('pre').text();
                var color = $(this).find('pre').css('color');
                var font = $(this).find('pre').css('font-family');
                var wfont = Math.round( parseFloat($(this).find('pre').width()) * 0.0264583 * 100) / 100;
                var hfont = Math.round( parseFloat($(this).find('pre').height()) * 0.0264583 * 100) / 100;
                var tfont = Math.round( parseFloat($(this).position().top) * 0.0264583 * 100) / 100;
                var lfont = Math.round( parseFloat($(this).position().left) * 0.0264583 * 100) / 100;
                var rotate = self.getRotationDegrees( $(this) ); //$(this).css('transform');
                strfont += text + '|' + font + '|' + color + '|' + wfont + '|' + hfont + '|' + tfont + '|' + lfont  + '|' + rotate + ';';
            });
            
            var strimg = '';

            if( $('.currentspace').hasClass('anywere')){
                $('#wrap-phone #cp-sel-Device #cp-device-ori .currentspace .cp-gridme .squared').each(function(index, el) {
                    var img = $(this).find('.img-h').attr('src');
                    var w = Math.round( parseFloat($(this).width()) * 0.0264583 * 100 ) / 100;
                    var h = Math.round( parseFloat($(this).height()) * 0.0264583 * 100 ) / 100;
                    var t = Math.round( parseFloat( $(this).css('top').replace("px", "") ) * 0.0264583 * 100) / 100;
                    var l = Math.round( parseFloat( $(this).css('left').replace("px", "") ) * 0.0264583 * 100) / 100;
                    var r = self.getRotationDegrees( $(this) );//$(this).css('transform');
                    strimg += img + '|' + w + '|' + h + '|' + t + '|' + l + '|' + r + ';';
                });
            }
            else{
                $('#wrap-phone #cp-sel-Device #cp-device-ori .currentspace .cp-gridme .sqr ').each(function(index, el) {
                    var img = $(this).find('.wrap-img-drag').children('img').attr('src');
                    var w = Math.round( parseFloat($(this).width()) * 0.0264583 * 100 ) / 100;
                    var h = Math.round( parseFloat($(this).height()) * 0.0264583 * 100 ) / 100;
                    var t = Math.round( parseFloat($(this).position().top) * 0.0264583 * 100 ) / 100;
                    var l = Math.round( parseFloat($(this).position().left) * 0.0264583 * 100 ) / 100;
                    var r = 0;
                    strimg += img + '|' + w + '|' + h + '|' + t + '|' + l + '|' + r + ';';
                });
            }

            var strdesign = '';

            $.ajax({
              type: 'POST',
              url: baseUri+'index.php?fc=module&module=cdesigner&controller=traitement',
              data: {
                state : 1,
                id_input : token,
                id_output : output,
                scanvas : strcanvas,
                sfont : strfont,
                simg : strimg,
                sdesign : strdesign
              }
            });
        },

        //Store Custom Product
        storeProduct_2:function(output){
            var token = $('.cp-token').text().substr(2);
            var self = this;
            //size canvas
            var width_canvas = Math.round( parseFloat($('#wrap-phone #cp-sel-Device #cp-device-ori #side-1').width()) * 0.0264583 * 100) / 100;
            var height_canvas = Math.round( parseFloat($('#wrap-phone #cp-sel-Device #cp-device-ori #side-1').height()) * 0.0264583 * 100) / 100;
            
            var width_canvas_2 = Math.round( parseFloat($('#wrap-phone #cp-sel-Device #cp-device-ori #side-2').width()) * 0.0264583 * 100) / 100;
            var height_canvas_2 = Math.round( parseFloat($('#wrap-phone #cp-sel-Device #cp-device-ori #side-2').height()) * 0.0264583 * 100) / 100;
            

            var strcanvas = width_canvas+ '|'+ height_canvas;
            var strcanvas_2 = width_canvas_2+ '|'+ height_canvas_2;

            //text canvas
            var strfont = '';
            var strfont_2 = '';
            $('#cp-device-ori-to-show #cp-device-ori #side-1 .cp-input-gen').each(function(index, el) {
                var text = $(this).find('pre').text();
                var color = $(this).find('pre').css('color');
                var font = $(this).find('pre').css('font-family');
                var wfont = Math.round( parseFloat($(this).find('pre').width()) * 0.0264583 * 100) / 100;
                var hfont = Math.round( parseFloat($(this).find('pre').height()) * 0.0264583 * 100) / 100;
                var tfont = Math.round( parseFloat($(this).position().top) * 0.0264583 * 100) / 100;
                var lfont = Math.round( parseFloat($(this).position().left) * 0.0264583 * 100) / 100;
                var rotate = self.getRotationDegrees( $(this) ); //$(this).css('transform');
                strfont += text + '|' + font + '|' + color + '|' + wfont + '|' + hfont + '|' + tfont + '|' + lfont  + '|' + rotate + ';';
            });

            $('#cp-device-ori-to-show #cp-device-ori #side-2 .cp-input-gen').each(function(index, el) {
                var text_2 = $(this).find('pre').text();
                var color_2 = $(this).find('pre').css('color');
                var font_2 = $(this).find('pre').css('font-family');
                var wfont_2 = Math.round( parseFloat($(this).find('pre').width()) * 0.0264583 * 100) / 100;
                var hfont_2 = Math.round( parseFloat($(this).find('pre').height()) * 0.0264583 * 100) / 100;
                var tfont_2 = Math.round( parseFloat($(this).position().top) * 0.0264583 * 100) / 100;
                var lfont_2 = Math.round( parseFloat($(this).position().left) * 0.0264583 * 100) / 100;
                var rotate_2 = self.getRotationDegrees( $(this) ); //$(this).css('transform');
                strfont_2 += text_2 + '|' + font_2 + '|' + color_2 + '|' + wfont_2 + '|' + hfont_2 + '|' + tfont_2 + '|' + lfont_2  + '|' + rotate_2 + ';';
            });
            
            var strimg = '';
            var strimg_2 = '';

            if( $('#side-1').hasClass('anywere')){
                $('#wrap-phone #cp-sel-Device #cp-device-ori #side-1 .cp-gridme .squared').each(function(index, el) {
                    var img = $(this).find('.img-h').attr('src');
                    var w = Math.round( parseFloat($(this).width()) * 0.0264583 * 100 ) / 100;
                    var h = Math.round( parseFloat($(this).height()) * 0.0264583 * 100 ) / 100;
                    var t = Math.round( parseFloat( $(this).css('top').replace("px", "") ) * 0.0264583 * 100) / 100;
                    var l = Math.round( parseFloat( $(this).css('left').replace("px", "") ) * 0.0264583 * 100) / 100;
                    var r = self.getRotationDegrees( $(this) );//$(this).css('transform');
                    strimg += img + '|' + w + '|' + h + '|' + t + '|' + l + '|' + r + ';';
                });
            }
            else{
                $('#wrap-phone #cp-sel-Device #cp-device-ori #side-1 .cp-gridme .sqr ').each(function(index, el) {
                    var img = $(this).find('.wrap-img-drag').children('img').attr('src');
                    var w = Math.round( parseFloat($(this).width()) * 0.0264583 * 100 ) / 100;
                    var h = Math.round( parseFloat($(this).height()) * 0.0264583 * 100 ) / 100;
                    var t = Math.round( parseFloat($(this).position().top) * 0.0264583 * 100 ) / 100;
                    var l = Math.round( parseFloat($(this).position().left) * 0.0264583 * 100 ) / 100;
                    var r = 0;
                    strimg += img + '|' + w + '|' + h + '|' + t + '|' + l + '|' + r + ';';
                });
            }

            if( $('#side-2').hasClass('anywere')){
                $('#wrap-phone #cp-sel-Device #cp-device-ori #side-2 .cp-gridme .squared').each(function(index, el) {
                    var img_2 = $(this).find('.img-h').attr('src');
                    var w_2 = Math.round( parseFloat($(this).width()) * 0.0264583 * 100 ) / 100;
                    var h_2 = Math.round( parseFloat($(this).height()) * 0.0264583 * 100 ) / 100;
                    var t_2 = Math.round( parseFloat( $(this).css('top').replace("px", "") ) * 0.0264583 * 100) / 100;
                    var l_2 = Math.round( parseFloat( $(this).css('left').replace("px", "") ) * 0.0264583 * 100) / 100;
                    var r_2 = self.getRotationDegrees( $(this) );//$(this).css('transform');
                    strimg_2 += img_2 + '|' + w_2 + '|' + h_2 + '|' + t_2 + '|' + l_2 + '|' + r_2 + ';';
                });
            }
            else{
                $('#wrap-phone #cp-sel-Device #cp-device-ori #side-2 .cp-gridme .sqr ').each(function(index, el) {
                    var img_2 = $(this).find('.wrap-img-drag').children('img').attr('src');
                    var w_2 = Math.round( parseFloat($(this).width()) * 0.0264583 * 100 ) / 100;
                    var h_2 = Math.round( parseFloat($(this).height()) * 0.0264583 * 100 ) / 100;
                    var t_2 = Math.round( parseFloat($(this).position().top) * 0.0264583 * 100 ) / 100;
                    var l_2 = Math.round( parseFloat($(this).position().left) * 0.0264583 * 100 ) / 100;
                    var r_2 = 0;
                    strimg_2 += img_2 + '|' + w_2 + '|' + h_2 + '|' + t_2 + '|' + l_2 + '|' + r_2 + ';';
                });
            }

            var strdesign = '';
            var strdesign_2 = '';

            $.ajax({
              type: 'POST',
              url: baseUri+'index.php?fc=module&module=cdesigner&controller=traitement',
              data: {
                state : 1,
                id_input : token,
                id_output : output,
                scanvas : strcanvas,
                sfont : strfont,
                simg : strimg,
                sdesign : strdesign,
                scanvas_2 : strcanvas_2,
                sfont_2 : strfont_2,
                simg_2 : strimg_2,
                sdesign_2 : strdesign_2
              }
            });
        },
        adjustRealPrice: function(){
            var total_side = 0;
            if( ( 
                   ( $('#cp-sel-Device #side-2 .cp-gridme .sqr').html() != undefined && $('#cp-sel-Device #side-2 .cp-gridme .sqr').html() != '' )  
                || ( $('#cp-sel-Device #side-2 .cp-gridme .squared').html() != undefined ) 
                || ( $('#cp-sel-Device #side-2 .cp-input-gen').html() != undefined) 
                ) 
                && 
                ( 
                   ( $('#cp-sel-Device #side-1 .cp-gridme .sqr').html() != undefined && $('#cp-sel-Device #side-1 .cp-gridme .sqr').html() != '' ) 
                || ( $('#cp-sel-Device #side-1 .cp-gridme .squared').html() != undefined ) 
                || ( $('#cp-sel-Device #side-1 .cp-input-gen').html() != undefined) ) 
                )
            {
                total_side = parseFloat( $('[name=pps]').val() ) / 3333;
            }

            var price_img = 0;
            $('#cp-sel-Device #cp-device-ori .cp-gridme img').each(function(){
                price_img += parseFloat( $('[name=ppi]').val() / 3333 )
            });
            var price_text = 0;
            $('#cp-sel-Device #cp-device-ori .cp-input-gen').each(function(){
                var def = $.trim( $(this).attr('data-default') ).toLowerCase();
                var txt = $.trim( $(this).find('pre').text() ).toLowerCase();
                if( def != txt)
                    price_text += txt.length * parseFloat( $('[name=ppt]').val() / 3333 );
            });
            $('.prix-q span').html( ( parseFloat($('.current-price>span[itemprop=price]').attr('content')) + total_side + price_img + price_text).toFixed(2) );
        },
        //Create combination Of Product
        createCombination:function(output){
            var token = $('.cp-token').text().substr(2);
            var self = this;
            var total_side = '';
            if( ( 
                   ( $('#cp-sel-Device #side-2 .cp-gridme .sqr').html() != undefined && $('#cp-sel-Device #side-2 .cp-gridme .sqr').html() != '' )  
                || ( $('#cp-sel-Device #side-2 .cp-gridme .squared').html() != undefined ) 
                || ( $('#cp-sel-Device #side-2 .cp-input-gen').html() != undefined) 
                ) 
                && 
                ( 
                   ( $('#cp-sel-Device #side-1 .cp-gridme .sqr').html() != undefined && $('#cp-sel-Device #side-1 .cp-gridme .sqr').html() != '' ) 
                || ( $('#cp-sel-Device #side-1 .cp-gridme .squared').html() != undefined ) 
                || ( $('#cp-sel-Device #side-1 .cp-input-gen').html() != undefined) ) 
                )
            {
                total_side = '<input type="hidden" name="sss" value="'+$('[name=pps]').val()+'"/>';
            }

            var total_image = '';
            var price_img = 0;
            $('#cp-sel-Device #cp-device-ori .cp-gridme img').each(function(){
                price_img += parseFloat( $('[name=ppi]').val() )
            });
            total_image = '<input type="hidden" name="ssi" value="'+price_img+'"/>';

            var total_text = '';
            var price_text = 0;
            $('#cp-sel-Device #cp-device-ori .cp-input-gen').each(function(){
                if( $.trim( $(this).find('pre').text() ) != '' && $.trim( $(this).find('pre').text() ) != $.trim( $(this).attr('data-default') ) )
                price_text += $(this).find('pre').text().length * parseFloat( $('[name=ppt]').val() );
            });
            total_text = '<input type="hidden" name="sst" value="'+price_text+'"/>';


            $('.product-customization form').append('<input type="hidden" name="id_input" value="'+token+'"/>\
                <input type="hidden" name="id_output" value="'+output+'"/>\
                <input type="hidden" name="data_rate" value="'+$('input[name=data_rate]').val()+'"/>\
                <input type="hidden" name="token" value="'+prestashop.static_token+'"/>\
                <input type="hidden" name="state" value="2"/>'+total_side+total_image+total_text);
            $('.product-customization-item .product-message').each(function(){
                $(this).val( 'cc_'+output );
            });
            $.ajax({
              type: 'POST',
              url: baseUri+'index.php?fc=module&module=cdesigner&controller=traitement',
              data: $('.product-customization form').serialize(),
              success: function(data) {
                var id = data.split(":");
                var idp = id[1];
                var ipa = id[0];
                //$('#add-to-cart-or-refresh').append('<input type="hidden" name="id_customization" value="'+ipa+'" id="product_customization_id">');
                $('#product_customization_id').val( ipa );
                self.createImgToPrint('cp-device-ori-to-print','',output,ipa,idp);
              }
            });
        },

        //Add To Cart
        addTocart:function(output,ipa,idp){
            var self = this;
            var urlimg = '';
            var $form = $('#add-to-cart-or-refresh');
            var query = $form.serialize() + '&add=1&action=update';
            var actionURL = $form.attr('action');

            $.post(actionURL, query, null, 'json').then(function (resp) {
               self.changeLastImgAdded(output);
            }).fail(function (resp) {}); 
        },

        //Change Last Img Added To Cart
        changeLastImgAdded:function(output){
            $('.progress-title').text(redirection);
            //For HTTPS USER
            $.ajax({
              type: 'POST',
              url: window.baseUri + 'index.php?fc=module&module=cdesigner&controller=storedata',
              data: {
                id : btoa( encodeURIComponent($('#cp-device-ori-to-print').html() ) ),
                //id : btoa( encodeURIComponent($('#cp-device-ori-to-print').html() ) ),
                link : $('#link-opc').text() ,
                output : output
              },
              success: function(data) {
                document.location = $('#link-opc').text();
              }
            });

        },
        pipedAjaxRequests: function (urls, callback) {
         var responses = {};
         
         var promise = $.Deferred().resolve();
         _.each(urls, function (url) {
              promise = promise.pipe(function () {
                return $.get(url);
              }).done(function (response) {
                responses[url] = response;
              });
         });
         
         promise.done(function () {
            callback(responses);
         }).fail(function (err) {
            callback(responses, err);
         });
        },

        runAjaxOld: function(){
            var results = [],
                deferred,
                deferreds = [];

            $('#cp-device-ori-to-print .with-rotate').each(function(key){
                var url_img = $(this).find('.img-rotate').attr('src');
                var extension = undefined;
                var lowerCase = url_img.toLowerCase();
                if (lowerCase.indexOf("png") !== -1) extension = "png"
                else if (lowerCase.indexOf("jpg") !== -1 || lowerCase.indexOf("jpeg") !== -1)
                    extension = "jpg"
                else extension = "tiff";

                var url_clear_img = url_img.replace('data:image/'+extension+';base64,','');
                $(this).find('.img-rotate').attr('id','qs-'+key);

                deferred = $.ajax({
                            type: 'POST',
                            url: baseUri+'index.php?fc=module&module=cdesigner&controller=saverotate',
                              data: {
                                token : prestashop.static_token,
                                img : url_clear_img,
                                ext: extension
                              },
                            success: function(data) {
                                $('#qs-'+key).attr('src', window.baseUri + data);
                            }
                        });
                deferreds.push(deferred);
            });

            deferred = $.ajax({
                          xhr: function()
                          {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt){
                              if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                 $('.loader-canvas .progress').width(percentComplete+'%');
                                 $('.loader-canvas .progress-txt').text(parseInt(percentComplete)+'%');
                              }
                            }, false);
                            return xhr;
                          },
                          type: 'POST',
                          url: baseUri+'index.php?fc=module&module=cdesigner&controller=save',
                          data: {
                            token : prestashop.static_token,
                            id_img : $date_now,
                            img : url_clean
                          }
                        });

            deferreds.push(deferred);

            $.when.apply($, deferreds).then(function() {
                $('.cp-gridme .sqr .wrap-img-drag img').hide();
                $('#cp-device-ori').removeClass('no-bg-gen');
                $('#cp-input-gen').html('');
                self.$elem.find('.sqr *').remove();
                self.$elem.find('.sqr').removeClass('cp-cibled-row');
                self.addTocart($date_now,ipa,idp);
            });
        },

        runAjax: function(){
            $('#cp-device-ori-to-print .with-rotate').each(function(key){
                var url_img = $(this).find('.img-rotate').attr('src');
                var url_clear_img = url_img.replace('data:image/png;base64,','').replace('data:image/jpg;base64,','');
                $(this).find('.img-rotate').attr('id','qs-'+key);
                return $.ajax({
                            type: 'POST',
                            url: baseUri+'index.php?fc=module&module=cdesigner&controller=saverotate',
                              data: {
                                token : prestashop.static_token,
                                img : url_clear_img
                              },
                            success: function(data) {
                                $('#qs-'+key).attr('src', window.baseUri + data);
                            }
                        });
            })
        }, 
        //CreateImgToPrint
        createImgToPrint:function(id,url_img,$date_now,ipa,idp){
            var self=this;
            $('html,body').animate({scrollTop:0},1);
            //$('.cp-gridme-cover').removeClass('someone-selected');
            $('.cp-gridme-cover').remove();
            /*
            html2canvas([document.getElementById('cp-device-ori-to-show')], {
                proxy: document.location.origin+'/modules/cdesigner/api/html2canvasproxy.php',
                scale: 1,
                onrendered: function(canvas) {
            */

            html2canvas(document.querySelector("#cp-device-ori-to-show"), {
                proxy: document.location.origin+'/modules/cdesigner/api/html2canvasproxy.php',
                scale: 1,  
            }).then( function(canvas) {
                    //document.body.appendChild(canvas);
                    //$('#cp-device-ori-gen,#cp-device-ori-to-print').remove();
                    var url_to_print = canvas.toDataURL("image/png");
                    var url_clean = url_to_print.replace('data:image/png;base64,','');
                    
                    if( $('#cp-device-ori-to-print .with-rotate')[0] ) {
                        
                var results = [],
                deferred,
                deferreds = [];

                $('#cp-device-ori-to-print .with-rotate').each(function(key){
                        var url_img = $(this).find('.img-rotate').attr('src');
                        var extension = undefined;
                        var lowerCase = url_img.toLowerCase();
                        if (lowerCase.indexOf("/png;") != -1) extension = "png"
                        else if (lowerCase.indexOf("/jpg;") != -1 || lowerCase.indexOf("/jpeg;") != -1)
                            extension = "jpeg"
                        else extension = "tiff";

                        var url_clear_img = url_img.replace('data:image/'+extension+';base64,','');
                        $(this).find('.img-rotate').attr('id','qs-'+key);

                        deferred = $.ajax({
                                    type: 'POST',
                                    url: baseUri+'index.php?fc=module&module=cdesigner&controller=saverotate',
                                      data: {
                                        token : prestashop.static_token,
                                        img : url_clear_img,
                                        ext: extension
                                      },
                                    success: function(data) {
                                        $('#qs-'+key).attr('src', window.baseUri + data);
                                    }
                                });
                        deferreds.push(deferred);
                    });

                        deferred = $.ajax({
                                      xhr: function()
                                      {
                                        var xhr = new window.XMLHttpRequest();
                                        xhr.upload.addEventListener("progress", function(evt){
                                          if (evt.lengthComputable) {
                                            var percentComplete = (evt.loaded / evt.total) * 100;
                                             $('.loader-canvas .progress').width(percentComplete+'%');
                                             $('.loader-canvas .progress-txt').text(parseInt(percentComplete)+'%');
                                          }
                                        }, false);
                                        return xhr;
                                      },
                                      type: 'POST',
                                      url: baseUri+'index.php?fc=module&module=cdesigner&controller=save',
                                      data: {
                                        token : prestashop.static_token,
                                        id_img : $date_now,
                                        img : url_clean
                                      }
                                    });

                        deferreds.push(deferred);

                        $.when.apply($, deferreds).then(function() {
                            $('.cp-gridme .sqr .wrap-img-drag img').hide();
                            $('#cp-device-ori').removeClass('no-bg-gen');
                            $('#cp-input-gen').html('');
                            self.$elem.find('.sqr *').remove();
                            self.$elem.find('.sqr').removeClass('cp-cibled-row');
                            self.addTocart($date_now,ipa,idp);
                        });
                    }
                    else {
                        $.ajax({
                          xhr: function()
                          {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt){
                              if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                 $('.loader-canvas .progress').width(percentComplete+'%');
                                 $('.loader-canvas .progress-txt').text(parseInt(percentComplete)+'%');
                              }
                            }, false);
                            return xhr;
                          },
                          type: 'POST',
                          url: baseUri+'index.php?fc=module&module=cdesigner&controller=save',
                          data: {
                            token : prestashop.static_token,
                            id_img : $date_now,
                            img : url_clean
                          },
                          success: function(data){
                            $('.cp-gridme .sqr .wrap-img-drag img').hide();
                            $('#cp-device-ori').removeClass('no-bg-gen');
                            $('#cp-input-gen').html('');
                            self.$elem.find('.sqr *').remove();
                            self.$elem.find('.sqr').removeClass('cp-cibled-row');
                            self.addTocart($date_now,ipa,idp);
                          }
                        }); 
                    }
                }
            );
        },
        // Align Image On Grid
        centerImg:function(){
            var counter = 300;
            $('#cp-device-ori-to-show .cp-gridme .wrap-img-drag').each(function(index,val) {
                if( ! $(this).children('img').hasClass('cp-show-a-crop') )
                {
                    $(this).children('img').attr('id','cp_img_'+counter);
                    imgCoverEffect(document.getElementById('cp_img_'+counter), {
                      alignX: 'center',
                      alignY: 'middle'
                    });
                    counter++;
                }
            });
        },
        centerImg_print:function(){
            var counter = 600;
            $('#cp-device-ori-to-print .cp-gridme .wrap-img-drag').each(function(index,val) {
                if( ! $(this).children('img').hasClass('cp-show-a-crop') )
                {
                    $(this).children('img').attr('id','cp_img_'+counter);
                    imgCoverEffect(document.getElementById('cp_img_'+counter), {
                      alignX: 'center',
                      alignY: 'middle'
                    });
                    counter++;
                }
            });
        },
        searchPhone:function(){
            $('.searchphone input').keyup(function() {
                var $word = $(this).val();
                var $list = '';
                if( $(this).val() != '' )
                {
                    $('#step1 .cp-row .cp-device>li').each(function(index, el) {
                        if( $(this).find('.tit-prod').text().toLowerCase().indexOf($word.toLowerCase()) != -1 )
                            $list += '<li>'+$(this).html()+'</li>';
                    });
                    if($list == '') $list = '<li><p class="text-center" style="padding:5px 0 10px;">Phone no longer availabe</p></li>'
                    $('#search-bloc ul').html($list);
                    $('.cp-row').hide();
                    $('#search-bloc').show();
                }else{
                    $('.cp-row').show();
                    $('#search-bloc').hide();
                }
            });
        },
        // Reset Data
        resetImg:function(){

            var self=this;

            $(document).on('click','.cp-btn-reset',function(e){

                if( $('.wrap-img-drag')[0] )

                {
                    alertify.confirm(reset_design, function (e) {
                        if (e) {
                            $('.currentspace .sqr *').remove();
                            $('.currentspace .sqr').removeClass('cp-cibled-row');
                            $('.currentspace .sqr').removeClass('filledm'); //arecop
                            self.adjustRealPrice();
                            $('.currentspace .cp-input-gen').remove();
                            $('.cp-input-txt').val('');
                            $('.new-txt').fadeOut('fast');
                            $('.add-txt').show();
                        }

                    });

                }

                e.preventDefault();

            });

        },



        // Shuffle Image

        getShuffleImg:function(){

            var $tab_u_img;

            var self=this;

            $(document).on('click','.cp-btn-shuffle',function(e){

                self.$elem.find('.cp-gridme *').remove();

                self.$elem.find('.sqr *').remove();

                self.$elem.find('.sqr').css('visibility','visible');

                $tab_u_img=[''];

                self.$elem.find('#cp-sel-Photos ul li a').each(function(index, val) {

                    $tab_u_img[index]=$(this).attr('href');

                });

                self.$elem.find('.cp-cibled-row').removeClass('cp-cibled-row');

                $tab_u_img=self.shuffleData($tab_u_img);

                var $inc=0;

                self.$elem.find('.sqr').each(function(index, val) {

                    var $this_e=$(this);

                    if($inc==$tab_u_img.length) {

                        $inc=0;

                        $tab_u_img=self.shuffleData($tab_u_img);

                    }

                    $(this).html('<span class="wrap-img-drag" style="background-image:url(\''+$tab_u_img[$inc]+'\');"><img src="'+$tab_u_img[$inc]+'" alt=""/><samp class="cp-h-v"><a href="javascript:void(0);" class="fa-stack fa-lg cp-modify"  title="'+crop_pic+'"><i class="fa fa-pencil fa-stack-1x fa-inverse"></i></a><a  title="'+delete_pic+'" href="javascrip:void(0);" class="fa-stack fa-lg cp-delete-fast"><i class="fa fa-trash-o"></i></a></samp></span>');

                    $inc++;

                    $this_e.find('.wrap-img-drag').addClass('no-visible');

                    self.$elem.find('.sqr').css('visibility','hidden');

                });

                self.copyHtmlGrid();

                e.preventDefault();

            });

        },

        // Shuffle Data
        shuffleData:function(o) {
            for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
            return o;
        },
        // Get Loader
        getLoader:function(){
            $('#wrap-phone').append('<div class="cp-loader" style="position:absolute;left:0;top:0;right:0;bottom:0;z-index:90000;"><div style="position:absolute;left:0;top:0;bottom:0;right:0;background:#fff; opacity:0;filter:alpha(opacity=0);"></div></div>');
            $('#center-side').append('<div class="cp-loader" style="position:absolute;left:0;top:0;right:0;bottom:0;z-index:90000;"><div style="position:absolute;left:0;top:0;bottom:0;right:0;background:#fff; opacity:0;filter:alpha(opacity=0);"></div><div class="lds-ring" style="position:absolute;top:50%;left:50%;margin:-22px 0 0 -22px;"><div></div><div></div><div></div><div></div></div></div>');
        },
        // Select Title Of Step
        getActiveTitle:function(index){
            var $tag_li=this.$elem.find('#cp-title-step').children('li');
            $tag_li.removeClass('cp-show');
            $tag_li.eq(index).addClass('cp-show');
        },
        centerImgBigReso:function(){
            $('#cp-device-ori-to-print .wrap-img-drag').each(function(index,val) {
                if( ! $(this).children('img').hasClass('cp-show-a-crop') )
                {
                    $(this).children('img').attr('id','cp_img_'+index);
                    imgCoverEffect(document.getElementById('cp_img_'+index), {
                      alignX: 'center',
                      alignY: 'middle'
                    });
                }
            });

            var $elem = $('#cp-device-ori-to-print .cp-input-gen');
            $elem.each(function(index, el) {
                var left = $(this).position().left * 2;
                var top = $(this).position().top * 2;
                var font = parseInt($(this).find('pre').css('font-size')) * 2;
                $(this).css({'top':top +'px', 'left':left +'px'});
                $(this).find('pre').css({'font-size':font +'px'});
            });

            $('#cp-device-ori-to-print .cp-show-a-crop').each(function(){
                var height = $(this).height() * 2;
                var width = $(this).width() * 2;
                var marginLeft = parseInt( $(this).css('margin-left') ) * 2;
                var marginTop = parseInt( $(this).css('margin-top') ) * 2;
                $(this).css({
                    'width' : width + 'px',
                    'height' : height + 'px',
                    'margin-left' : marginLeft + 'px',
                    'margin-top' : marginTop + 'px',
                });
            }); 
            
            var left_p;
            var top_p;
            var height_p;
            var width_p;

            if( $('.currentspace').hasClass('anywere') ){
                $('#cp-device-ori-to-print .cp-gridme .squared').each(function(){
                    left_p = parseFloat( $(this).css('left').replace("px", "") ) * 2;
                    top_p = parseFloat( $(this).css('top').replace("px", "") ) * 2;
                    height_p = $(this).height() * 2;
                    width_p = $(this).width() * 2;
                    $(this).css({
                        'width' : width_p + 'px',
                        'height' : height_p + 'px',
                        'left' : left_p + 'px',
                        'top' : top_p + 'px',
                    });
                    $(this).find('.ui-wrapper').css({
                        'width' : width_p + 'px',
                        'height' : height_p + 'px',
                    });
                    $(this).find('.img-h').css({
                        'width' : width_p + 'px',
                        'height' : height_p + 'px',
                    });
                });
            }
        },



        // Active Link To Step

        getActiveLinkStep:function(){
            var self = this;
            $(document).on('click','#cp-link-step li a',function(e){
                var id = $(this).parent().attr('id').substr(6,1);
                $('#cp-link-step li').removeClass('cp-current-step')
                $(this).parent().addClass('cp-current-step');
                $('#cp-ct-step>div').hide();
                $('.list-combination-data').fadeOut('fast');
                $('#step'+id).show();
                if( $('.pre-design')[0] ) {
                    if( parseInt(id) == 2 ) {
                        $('.currentspace .cp-gridme-cover .sqr').eq(0).trigger('click');
                    } else if( parseInt(id) == 3 ) { 
                        $('.currentspace .cp-input-gen').eq(0).trigger('click');
                    }
                }
                return false;
            });
        },
        // Current Link To Step

        getCurrentLink:function(index){

            var $tag_li=this.$elem.find('#cp-link-step').children('li');

            $tag_li.removeClass('cp-current-step');

            $tag_li.eq(index).addClass('cp-current-step');

        },



        // Custom Transition

        easing:function(){

            $.easing.custom = function (x, t, b, c, d) {

            var s = 1.70158;

            if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;

            return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;

            }

            jQuery.extend( jQuery.easing,

            {

                def: 'easeOutQuad',

                swing: function (x, t, b, c, d) {

                    return jQuery.easing[jQuery.easing.def](x, t, b, c, d);

                },

                easeInQuad: function (x, t, b, c, d) {

                    return c*(t/=d)*t + b;

                },

                easeOutQuad: function (x, t, b, c, d) {

                    return -c *(t/=d)*(t-2) + b;

                },

                easeInOutQuad: function (x, t, b, c, d) {

                    if ((t/=d/2) < 1) return c/2*t*t + b;

                    return -c/2 * ((--t)*(t-2) - 1) + b;

                },

                easeInCubic: function (x, t, b, c, d) {

                    return c*(t/=d)*t*t + b;

                },

                easeOutCubic: function (x, t, b, c, d) {

                    return c*((t=t/d-1)*t*t + 1) + b;

                },

                easeInOutCubic: function (x, t, b, c, d) {

                    if ((t/=d/2) < 1) return c/2*t*t*t + b;

                    return c/2*((t-=2)*t*t + 2) + b;

                },

                easeInQuart: function (x, t, b, c, d) {

                    return c*(t/=d)*t*t*t + b;

                },

                easeOutQuart: function (x, t, b, c, d) {

                    return -c * ((t=t/d-1)*t*t*t - 1) + b;

                },

                easeInOutQuart: function (x, t, b, c, d) {

                    if ((t/=d/2) < 1) return c/2*t*t*t*t + b;

                    return -c/2 * ((t-=2)*t*t*t - 2) + b;

                },

                easeInQuint: function (x, t, b, c, d) {

                    return c*(t/=d)*t*t*t*t + b;

                },

                easeOutQuint: function (x, t, b, c, d) {

                    return c*((t=t/d-1)*t*t*t*t + 1) + b;

                },

                easeInOutQuint: function (x, t, b, c, d) {

                    if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;

                    return c/2*((t-=2)*t*t*t*t + 2) + b;

                },

                easeInSine: function (x, t, b, c, d) {

                    return -c * Math.cos(t/d * (Math.PI/2)) + c + b;

                },

                easeOutSine: function (x, t, b, c, d) {

                    return c * Math.sin(t/d * (Math.PI/2)) + b;

                },

                easeInOutSine: function (x, t, b, c, d) {

                    return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;

                },

                easeInExpo: function (x, t, b, c, d) {

                    return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;

                },

                easeOutExpo: function (x, t, b, c, d) {

                    return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;

                },

                easeInOutExpo: function (x, t, b, c, d) {

                    if (t==0) return b;

                    if (t==d) return b+c;

                    if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;

                    return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;

                },

                easeInCirc: function (x, t, b, c, d) {

                    return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;

                },

                easeOutCirc: function (x, t, b, c, d) {

                    return c * Math.sqrt(1 - (t=t/d-1)*t) + b;

                },

                easeInOutCirc: function (x, t, b, c, d) {

                    if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;

                    return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;

                },

                easeInElastic: function (x, t, b, c, d) {

                    var s=1.70158;var p=0;var a=c;

                    if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;

                    if (a < Math.abs(c)) { a=c; var s=p/4; }

                    else var s = p/(2*Math.PI) * Math.asin (c/a);

                    return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;

                },

                easeOutElastic: function (x, t, b, c, d) {

                    var s=1.70158;var p=0;var a=c;

                    if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;

                    if (a < Math.abs(c)) { a=c; var s=p/4; }

                    else var s = p/(2*Math.PI) * Math.asin (c/a);

                    return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;

                },

                easeInOutElastic: function (x, t, b, c, d) {

                    var s=1.70158;var p=0;var a=c;

                    if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);

                    if (a < Math.abs(c)) { a=c; var s=p/4; }

                    else var s = p/(2*Math.PI) * Math.asin (c/a);

                    if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;

                    return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;

                },

                easeInBack: function (x, t, b, c, d, s) {

                    if (s == undefined) s = 1.70158;

                    return c*(t/=d)*t*((s+1)*t - s) + b;

                },

                easeOutBack: function (x, t, b, c, d, s) {

                    if (s == undefined) s = 1.70158;

                    return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;

                },

                easeInOutBack: function (x, t, b, c, d, s) {

                    if (s == undefined) s = 1.70158;

                    if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;

                    return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;

                },

                easeInBounce: function (x, t, b, c, d) {

                    return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;

                },

                easeOutBounce: function (x, t, b, c, d) {

                    if ((t/=d) < (1/2.75)) {

                        return c*(7.5625*t*t) + b;

                    } else if (t < (2/2.75)) {

                        return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;

                    } else if (t < (2.5/2.75)) {

                        return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;

                    } else {

                        return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;

                    }

                },

                easeInOutBounce: function (x, t, b, c, d) {

                    if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;

                    return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;

                }

            });

        }

    };

    /** Define Plugin Jquery **/
    $.fn.Cdesigner = function(options) {
        return this.each(function() {
            new Cdesigner(this, options).init();
        });
    };
})( jQuery);

$(document).ready(function($) {
    $('#wrap-phone').Cdesigner();
});