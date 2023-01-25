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


$(document).ready(function(){
    $( ".zone-select-1" ).resizable({
        //containment:'#preview-1',  
        resize: function(event, ui){
            updateKeyup();
            $('#preview-2').removeClass('current');
            $('#preview-1').addClass('current');
        },
        stop:function(){
            updateKeyup();
            $('#preview-2').removeClass('current');
            $('#preview-1').addClass('current');
        }
    });
    
    $( ".zone-select-1" ).draggable({
      scroll: false,
      drag: function(){
        updateKeyup();
        $('#preview-2').removeClass('current');
        $('#preview-1').addClass('current');
      },
      stop:function(){ 
        updateKeyup();
        $('#preview-2').removeClass('current');
        $('#preview-1').addClass('current');
      }
    });

    $( ".zone-select-2" ).resizable({
        //containment:'#preview-1',  
        resize: function(event, ui){
            updateKeyup_1();
            $('#preview-1').removeClass('current');
            $('#preview-2').addClass('current');
        },
        stop:function(){
            updateKeyup_1();
            $('#preview-1').removeClass('current');
            $('#preview-2').addClass('current');
        }
    });
    

    $('.zone-select-1,.zone-select-2').click(function(){
        $('.case').removeClass('current');
        $(this).addClass('current');
    });

    $( ".zone-select-2" ).draggable({
      scroll: false,
      drag: function(){
        updateKeyup_1();
        $('#preview-1').removeClass('current');
        $('#preview-2').addClass('current');
      },
      stop:function(){ 
        updateKeyup_1();
        $('#preview-1').removeClass('current');
        $('#preview-2').addClass('current');
      }
    });

    $('.zone-area-1,.zone-area-2').focus(function(){
        $('.case').removeClass('current');
    });

    $('.zone-area-1').keyup(function(){
        $('.case').removeClass('current');
        var $value = ( $(this).val() != '' ) ? $(this).val() : '0';
        if( $(this).attr('id') == 'z_top_1' ) {
            $('.zone-select-1').css('top',parseFloat( $value ) + '%' );
        } else if ( $(this).attr('id') == 'z_bottom_1' ) {
            $('.zone-select-1').css('height',parseFloat( $value  )+ '%' );
        } else if ( $(this).attr('id') == 'z_left_1' ) {
            $('.zone-select-1').css('left',parseFloat( $value ) + '%' );
        } else if ( $(this).attr('id') == 'z_right_1' ) {
            $('.zone-select-1').css('width', parseFloat( $value ) + '%' );
        }
        $('#zone-1').val( parseFloat( ( $('#z_top_1').val() != '') ? $('#z_top_1').val() : '0' ) + ';' + parseFloat( ( $('#z_left_1').val() != '') ? $('#z_left_1').val() : '0' ) + ';' + parseFloat( ( $('#z_right_1').val() != '') ? $('#z_right_1').val() : '0' ) + ';' + parseFloat( ( $('#z_bottom_1').val() != '') ? $('#z_bottom_1').val() : '0' ) + ';'  );
        $('#helper-id').val('1');
    });

    $('.zone-area-2').keyup(function(){
        $('.case').removeClass('current');
        var $value = ( $(this).val() != '' ) ? $(this).val() : '0';
        if( $(this).attr('id') == 'z_top_2' ) {
            $('.zone-select-2').css('top',parseFloat( $value ) + '%' );
        } else if ( $(this).attr('id') == 'z_bottom_2' ) {
            $('.zone-select-2').css('height',parseFloat( $value  )+ '%' );
        } else if ( $(this).attr('id') == 'z_left_2' ) {
            $('.zone-select-2').css('left',parseFloat( $value ) + '%' );
        } else if ( $(this).attr('id') == 'z_right_2' ) {
            $('.zone-select-2').css('width', parseFloat( $value ) + '%' );
        }
        $('#zone-2').val( parseFloat( ( $('#z_top_2').val() != '') ? $('#z_top_2').val() : '0' ) + ';' + parseFloat( ( $('#z_left_2').val() != '') ? $('#z_left_2').val() : '0' ) + ';' + parseFloat( ( $('#z_right_2').val() != '') ? $('#z_right_2').val() : '0' ) + ';' + parseFloat( ( $('#z_bottom_2').val() != '') ? $('#z_bottom_2').val() : '0' ) + ';'  );
        $('#helper-id').val('1');
    });

    var $design = $('#design_pre').val();
    var $design_2 = $('#design_pre_2').val();
    if( $design != '' ) {
        var $design_pre = $design.split('|');
        var $nativeW = $design_pre[0];
        var $nativeH = $design_pre[3];
        var $imgs = $design_pre[1].split(';');
        var $texts = $design_pre[2].split(';');

        var $i=0;
        $imgs.forEach(function(element){
            var elements = element.split(':::');
            var $w = getPercent( $nativeW ,elements[0] );
            var $h = getPercent( $nativeH ,elements[1] );
            var $l = getPercent( $nativeW ,elements[2] );
            var $t = getPercent( $nativeH ,elements[3] );
            var $r = elements[4];
            var $tags = elements[5];
            if( $w > 0) writeImage($l,$t,$w,$h,$r,$i,'side-1', $tags);
            $i++;
        });

        $texts.forEach(function(element){
            var elements = element.split(':::');
            var $text = elements[0];
            var $w = getPercent( $nativeW ,elements[1] );
            var $h = getPercent( $nativeH ,elements[2] );
            var $l = getPercent( $nativeW ,elements[3] );
            var $t = getPercent( $nativeH ,elements[4] );
            var $size = elements[5];
            var $color = elements[6];
            var $font = elements[7];
            var $align = elements[8];
            var $r = elements[9];
            var $id_font = elements[10];
            var $valign = elements[11];
            var $acolor = elements[12];
            var $afont = elements[13];
            var $alimit = elements[14];

            var $abreak = elements[15];
            var $afontsize = elements[16];
            var $afontalignement = elements[17];

            if( $w > 0)  writeText($l,$t,$w,$h,$r,$size,$color,$font,$align,$text,$id_font,$i,$valign,$acolor,$afont,$alimit,'side-1', $abreak, $afontsize, $afontalignement);
            $i++;
        });
    }

    if( $design_2 != '' ) {
        var $design_pre_2 = $design_2.split('|');
        var $nativeW_2 = $design_pre_2[0];
        var $nativeH_2 = $design_pre_2[3];
        var $imgs = $design_pre_2[1].split(';');
        var $texts = $design_pre_2[2].split(';');

        var $i=0;
        $imgs.forEach(function(element){
            var elements = element.split(':::');
            var $w = getPercent( $nativeW_2 ,elements[0] );
            var $h = getPercent( $nativeH_2 ,elements[1] );
            var $l = getPercent( $nativeW_2 ,elements[2] );
            var $t = getPercent( $nativeH_2 ,elements[3] );
            var $r = elements[4];
            var $tags = elements[5];
            if( $w > 0) writeImage($l,$t,$w,$h,$r,$i,'side-2', $tags);
            $i++;
        });

        $texts.forEach(function(element){
            var elements = element.split(':::');
            var $text = elements[0];
            var $w = getPercent( $nativeW_2 ,elements[1] );
            var $h = getPercent( $nativeH_2 ,elements[2] );
            var $l = getPercent( $nativeW_2 ,elements[3] );
            var $t = getPercent( $nativeH_2 ,elements[4] );
            var $size = elements[5];
            var $color = elements[6];
            var $font = elements[7];
            var $align = elements[8];
            var $r = elements[9];
            var $id_font = elements[10];
            var $valign = elements[11];
            var $acolor = elements[12];
            var $afont = elements[13];
            var $alimit = elements[14];

            var $abreak = elements[15];
            var $afontsize = elements[16];
            var $afontalignement = elements[17];

            if( $w > 0)  writeText($l,$t,$w,$h,$r,$size,$color,$font,$align,$text,$id_font,$i,$valign,$acolor,$afont,$alimit,'side-2', $abreak, $afontsize, $afontalignement);
            $i++;
        });  
    }

    $('#new-photos').bind('click',function(e){
        var $href = $('.switcher-mode a.active').attr('href');
        var $side = ( $href == 'zone-mask-work-down' ) ? 'side-1' : 'side-2';
        writeImage('20','20','20','15','0',0, $side);
        storeData();
        return false;
    });

    $('#new-text').bind('click',function(e){ 
        var $href = $('.switcher-mode a.active').attr('href');  
        var $side = ( $href == 'zone-mask-work-down' ) ? 'side-1' : 'side-2';
        writeText('20','20','20','10','0','16px','#000','Dancing Script','center','Text Area','1',0,'center','yes', 'yes',0, $side,'no','no','no');
        storeData();
        return false;
    });
    
    $(document).on('click', '.btn-dup-zone', function(e){ 
        var $parent_item = $(this).closest('.zone-img');
        $parent_item.removeClass('active');
        var $now = Math.floor(Date.now() / 1000) + '-duplicated';
        $parent_item.clone().appendTo( $parent_item.parent() ).
        addClass( "i_"+ $now ).addClass('active').
        removeClass( $parent_item.attr('data-helpc') ).
        attr('data-helpc',"i_"+ $now);

        $(".i_"+$now ).css('top','+=40');
        $(".i_"+$now+" .ui-resizable-handle, .i_"+$now+" .ui-rotatable-handle").remove();

        if( $parent_item.hasClass('z-t') ) {
            $( ".i_"+$now ).resizable({
                resize: function(event, ui){
                    $( ".i_"+$now ).find('.w-i').val( $( ".i_"+$now ).width() );
                    $( ".i_"+$now ).find('.h-i').val( $( ".i_"+$now ).height() );
                },
                stop: function(){
                    $( ".i_"+$now ).find('.w-i').val( $( ".i_"+$now ).width() );
                    $( ".i_"+$now ).find('.h-i').val( $( ".i_"+$now ).height() );
                    storeData();
                }
            });
            $( ".i_"+$now ).draggable({
              //containment: "#zone-mask-work",
              scroll: false,
              drag: function(){
                 writeTodash($now);
                 $( ".i_"+$now ).find('.l-i').val( $( ".i_"+$now ).position().left );
                 $( ".i_"+$now ).find('.t-i').val( $( ".i_"+$now ).position().top );
              },
              stop:function(){ 
                 writeTodash($now);
                 storeData();
                 $( ".i_"+$now ).find('.l-i').val( $( ".i_"+$now ).position().left );
                 $( ".i_"+$now ).find('.t-i').val( $( ".i_"+$now ).position().top );
              }
            });
            params = {
                scroll: false,
                wheelRotate: false,
                rotate: function(){
                    $( ".i_"+$now ).find('.r-i').val( getRotationDegrees( $( ".i_"+$now ) ) );
                },
                stop: function(){
                    storeData();
                    $( ".i_"+$now ).find('.r-i').val( getRotationDegrees( $( ".i_"+$now ) ) );
                }
            };
            $( ".i_"+$now ).rotatable(params);
            $( ".i_"+$now ).click(function(){
                writeTodash($now);
            });

            $( ".i_"+$now ).find('.w-i').val('-');
            $( ".i_"+$now ).find('.h-i').val('-');

            $( ".i_"+$now ).find('.l-i').val('-');
            $( ".i_"+$now ).find('.t-i').val('-');
        } else {
            $( ".i_"+$now ).resizable({
                  resize: function(event, ui){
                        $( ".i_"+$now ).find('.w-i').val( $( ".i_"+$now ).width() );
                        $( ".i_"+$now ).find('.h-i').val( $( ".i_"+$now ).height() );
                        writeTodashImg( $now );
                        //storeData();
                  },
                  stop:function(){
                        $( ".i_"+$now ).find('.w-i').val( $( ".i_"+$now ).width() );
                        $( ".i_"+$now ).find('.h-i').val( $( ".i_"+$now ).height() );
                        writeTodashImg( $now );
                        storeData();
                  }
            });
            
            $( ".i_"+$now ).draggable({
              scroll: false,
              wheelRotate: false,
              drag: function(){
                $('.panel-txt').hide();
                writeTodashImg( $now );
                //storeData();
                resetCurrentImg($now);
                $( ".i_"+$now ).find('.l-i').val( $( ".i_"+$now ).position().left );
                $( ".i_"+$now ).find('.t-i').val( $( ".i_"+$now ).position().top );
              },
              stop:function(){ 
                 $('.panel-txt').hide();
                 writeTodashImg( $now );
                 storeData();
                 $( ".i_"+$now ).find('.l-i').val( $( ".i_"+$now ).position().left );
                 $( ".i_"+$now ).find('.t-i').val( $( ".i_"+$now ).position().top );
              }
            });

            params = {
                scroll: false,
                wheelRotate: false,
                rotate: function(){
                    $( ".i_"+$now ).find('.r-i').val( getRotationDegrees( $( ".i_"+$now ) ) );
                },
                stop: function(){  
                    storeData();
                    $( ".i_"+$now ).find('.r-i').val( getRotationDegrees( $( ".i_"+$now ) ) );
                }
            };

            $( ".i_"+$now ).rotatable(params);

            $( ".i_"+$now ).click(function(){
                writeTodashImg( $now );
                resetCurrentImg($now);
            });

            $( ".i_"+$now ).find('.w-i').val('-');
            $( ".i_"+$now ).find('.h-i').val('-');

            $( ".i_"+$now ).find('.l-i').val('-');
            $( ".i_"+$now ).find('.t-i').val('-');
        }
        storeData();
        return false;
    });
    
    $('#clear-design').bind('click',function(e){ 
        $('.z-t,.z-i').remove();
        $('.panel-txt').hide();
        $('.panel-txt-img').hide();
        storeData();
        return false;
    }); 

    function getPercent($nativeW , $value) {
        return  ($value / $nativeW) * 100;
    }

    function updateKeyup() {
        var $top = $('.zone-select-1').css('top');
        var $left = $('.zone-select-1').css('left');
        var $width = $('.zone-select-1').width();
        var $height = $('.zone-select-1').height();
        var $width_native = $('#preview-1').closest('.preview-area').width();
        var $height_native = $('#preview-1').closest('.preview-area').height();

        $top = ( $top.indexOf('px') != -1 ) ? ( ( parseFloat($top) / $height_native ) * 100) : parseFloat($top);
        $left = ( $left.indexOf('px') != -1 ) ? ( ( parseFloat($left) / $width_native ) * 100) : parseFloat($left);
        $width = ( parseFloat($width) / $width_native ) * 100;
        $height = ( parseFloat($height) / $height_native ) * 100;
        
        $('#z_top_1').val($top.toFixed(2));
        $('#z_left_1').val($left.toFixed(2))
        $('#z_right_1').val($width.toFixed(2))
        $('#z_bottom_1').val($height.toFixed(2))

        $('#zone-1').val( $top.toFixed(2) + ';' + $left.toFixed(2) + ';' + $width.toFixed(2) + ';' + $height.toFixed(2) + ';'  );
        $('#helper-id').val('1');
    }

    function updateKeyup_1() {
        var $top = $('.zone-select-2').css('top');
        var $left = $('.zone-select-2').css('left');
        var $width = $('.zone-select-2').width();
        var $height = $('.zone-select-2').height();
        var $width_native = $('#preview-2').closest('.preview-area').width();
        var $height_native = $('#preview-2').closest('.preview-area').height();

        $top = ( $top.indexOf('px') != -1 ) ? ( ( parseFloat($top) / $height_native ) * 100) : parseFloat($top);
        $left = ( $left.indexOf('px') != -1 ) ? ( ( parseFloat($left) / $width_native ) * 100) : parseFloat($left);
        $width = ( parseFloat($width) / $width_native ) * 100;
        $height = ( parseFloat($height) / $height_native ) * 100;
        
        $('#z_top_2').val($top.toFixed(2));
        $('#z_left_2').val($left.toFixed(2))
        $('#z_right_2').val($width.toFixed(2))
        $('#z_bottom_2').val($height.toFixed(2))

        $('#zone-2').val( $top.toFixed(2) + ';' + $left.toFixed(2) + ';' + $width.toFixed(2) + ';' + $height.toFixed(2) + ';'  );
        $('#helper-id').val('1');
    }

    function resetCurrentImg($now){
        $('.z-t, .z-i').removeClass('active');
        $( ".i_"+$now +"").addClass('active');
        if( $( ".i_"+$now +"").hasClass('z-i') ) $('.panel-txt').hide();

        $('.panel-txt-img').show();
    }

    function writeImage($l,$t,$w,$h,$r,$i,$side, tags) {
        Date.now = function() { return new Date().getTime(); }
        var $now = Math.floor(Date.now() / 1000) + $i;
        $now = $now +'-'+$side;
        var $selector = ( $side == 'side-2' ) ? '.zone-mask-work-down-2' : '.zone-mask-work-down';
        $($selector).append('<div data-tags="'+tags+'" data-helpc="i_'+$now+'"  class="zone-img i_'+$now+' z-i" style="display:inline-block;left:'+$l+'%;top:'+$t+'%;width:'+$w+'%;height:'+$h+'%;transform: rotate('+$r+'deg);-webkit-transform: rotate('+$r+'deg);-o-transform: rotate('+$r+'deg);">\
            <span>'+img_txt+'</span><label class="input-img">W: <input type="text" class="w-i" value="'+$w+'"/>px</label><label class="input-img h-i-w">H: <input type="text" class="h-i" value="'+$h+'"/>px</label><label class="input-img t-i-w">T: <input type="text" class="t-i" value="'+$t+'"/>px</label><label class="input-img l-i-w">L: <input type="text" class="l-i" value="'+$l+'"/>px</label><label class="input-img r-i-w">R: <input type="text" class="r-i" value="'+$r+'"/>deg</label><a href="" class="btn-delete-zone" title="Delete" ></a><a href="#" class="btn-dup-zone" title="Duplicate" ></a>\
            </div>');
        $( ".i_"+$now ).resizable({
              resize: function(event, ui){
                    $( ".i_"+$now ).find('.w-i').val( $( ".i_"+$now ).width() );
                    $( ".i_"+$now ).find('.h-i').val( $( ".i_"+$now ).height() );
                    $('.panel-txt').hide();
                    $('.panel-txt-img').show();
                    //storeData();
              },
              stop:function(){
                    $( ".i_"+$now ).find('.w-i').val( $( ".i_"+$now ).width() );
                    $( ".i_"+$now ).find('.h-i').val( $( ".i_"+$now ).height() );
                    $('.panel-txt').hide();
                    $('.panel-txt-img').show();
                    storeData();
              }
        });
        
        $( ".i_"+$now ).draggable({
          scroll: false,
          drag: function(){
            $('.panel-txt').hide();
            $('.panel-txt-img').show();
            //storeData();
            writeTodashImg($now);
            resetCurrentImg($now);
            $( ".i_"+$now ).find('.l-i').val( $( ".i_"+$now ).position().left );
            $( ".i_"+$now ).find('.t-i').val( $( ".i_"+$now ).position().top );
          },
          stop:function(){ 
             $('.panel-txt').hide();
             $('.panel-txt-img').show();
             writeTodashImg($now);
             storeData();
             $( ".i_"+$now ).find('.l-i').val( $( ".i_"+$now ).position().left );
             $( ".i_"+$now ).find('.t-i').val( $( ".i_"+$now ).position().top );
          }
        });

        params = {
            scroll: false,
            wheelRotate: false,
            rotate: function(){
                writeTodashImg($now);
                $( ".i_"+$now ).find('.r-i').val( getRotationDegrees( $( ".i_"+$now ) ) );
            },
            stop: function(){
                writeTodashImg($now);
                storeData();
                $( ".i_"+$now ).find('.r-i').val( getRotationDegrees( $( ".i_"+$now ) ) );
            }
        };
        $( ".i_"+$now ).rotatable(params);

        $( ".i_"+$now ).click(function(){
            writeTodashImg($now);
            resetCurrentImg($now);
        });

        $( ".i_"+$now ).find('.w-i').val('-');
        $( ".i_"+$now ).find('.h-i').val('-');

        $( ".i_"+$now ).find('.l-i').val('-');
        $( ".i_"+$now ).find('.t-i').val('-');
    }
 
    function writeText($l,$t,$w,$h,$r,$size,$color,$font,$align,$text,$id_font,$i,$valign, $acolor, $afont, $alimit, $side, $abreak, $afontsize, $afontalignement){
        Date.now = function() { return new Date().getTime(); }
        var $now = Math.floor(Date.now() / 1000) + $i;
        $now = $now +'-'+$side;
        var $selector = ( $side == 'side-2' ) ? '.zone-mask-work-down-2' : '.zone-mask-work-down';
        $($selector).append('<div data-helpc="i_'+$now+'" class="zone-img i_'+$now+' z-t" style="display:inline-block;left:'+$l+'%;top:'+$t+'%;width:'+$w+'%;height:'+$h+'%;transform: rotate('+$r+'deg);-webkit-transform: rotate('+$r+'deg);-o-transform: rotate('+$r+'deg);">\
            <pre id_font="'+$id_font+'" data-valign="'+$valign+'" data-limit="'+$alimit+'" data-acolor="'+$acolor+'" data-abreak="'+$abreak+'" data-afontalignement="'+$afontalignement+'" data-afontsize="'+$afontsize+'"  data-afont="'+$afont+'" style="text-align:'+$align+';font-family:'+$font+';color:'+$color+';font-size:'+$size+'px;line-height:'+$size+'px;">'+$text+'</pre><label class="input-img">W: <input type="text" class="w-i" value="'+$w+'"/>px</label><label class="input-img h-i-w">H: <input type="text" class="h-i" value="'+$h+'"/>px</label><label class="input-img t-i-w">T: <input type="text" class="t-i" value="'+$t+'"/>px</label><label class="input-img l-i-w">L: <input type="text" class="l-i" value="'+$l+'"/>px</label><label class="input-img r-i-w">R: <input type="text" class="r-i" value="'+$r+'"/>deg</label><a href="" class="btn-delete-zone" title="Delete" ></a><a href="#" title="Duplicate" class="btn-dup-zone"></a>\
            </div>');
        $( ".i_"+$now ).resizable({
            resize: function(event, ui){
                $( ".i_"+$now ).find('.w-i').val( $( ".i_"+$now ).width() );
                $( ".i_"+$now ).find('.h-i').val( $( ".i_"+$now ).height() );
            },
            stop: function(){
                $( ".i_"+$now ).find('.w-i').val( $( ".i_"+$now ).width() );
                $( ".i_"+$now ).find('.h-i').val( $( ".i_"+$now ).height() );
                storeData();
            }
        });
        $( ".i_"+$now ).draggable({
          //containment: "#zone-mask-work",
          scroll: false,
          drag: function(){
             writeTodash($now);
             $( ".i_"+$now ).find('.l-i').val( $( ".i_"+$now ).position().left );
             $( ".i_"+$now ).find('.t-i').val( $( ".i_"+$now ).position().top );
          },
          stop:function(){ 
             writeTodash($now);
             storeData();
             $( ".i_"+$now ).find('.l-i').val( $( ".i_"+$now ).position().left );
             $( ".i_"+$now ).find('.t-i').val( $( ".i_"+$now ).position().top );
          }
        });
        params = {
            scroll: false,
            wheelRotate: false,
            rotate: function(){
                $( ".i_"+$now ).find('.r-i').val( getRotationDegrees( $( ".i_"+$now ) ) );
            },
            stop: function(){
                storeData();
                $( ".i_"+$now ).find('.r-i').val( getRotationDegrees( $( ".i_"+$now ) ) );
            }
        };
        $( ".i_"+$now ).rotatable(params);
        $( ".i_"+$now ).click(function(){
            writeTodash($now);
        });

        $( ".i_"+$now ).find('.w-i').val('-');
        $( ".i_"+$now ).find('.h-i').val('-');

        $( ".i_"+$now ).find('.l-i').val('-');
        $( ".i_"+$now ).find('.t-i').val('-');
    }

    function getRotationDegrees (obj) {
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
    }

    function writeTodash($now) {
         $('.z-t pre').removeClass('current');
         $('.z-t, .z-i').removeClass('active');
         $('.panel-txt').show();
         $('.panel-txt-img').hide();
         var $size = parseFloat( $( ".i_"+$now +" pre").css('font-size') ); 
         var $color = $( ".i_"+$now +" pre").css('color');
         var $align = $( ".i_"+$now +" pre").css('text-align');
         var $valign = $( ".i_"+$now +" pre").attr('data-valign');
         var $acolor = $( ".i_"+$now +" pre").attr('data-acolor');
         var $afont = $( ".i_"+$now +" pre").attr('data-afont');

         var $abreak = $( ".i_"+$now +" pre").attr('data-abreak');
         var $afontsize = $( ".i_"+$now +" pre").attr('data-afontsize');
         var $afontalignement = $( ".i_"+$now +" pre").attr('data-afontalignement');

         var $font_pred = $( ".i_"+$now +" pre").attr('id_font');
         var $limit_pred = $( ".i_"+$now +" pre").attr('data-limit');

         if( $size && $color ) {
            $('#cp-textarea input[value='+ $font_pred+']').prop( 'checked', true );
            $('input[name=align_predefined][value='+ $align+']').prop( 'checked', true );
            $('input[name=valign_predefined][value='+ $valign+']').prop( 'checked', true );
            $('input[name=acolor_predefined][value='+ $acolor+']').prop( 'checked', true );
            $('input[name=afont_predefined][value='+ $afont+']').prop( 'checked', true );

            $('input[name=abreak_predefined][value='+ $abreak+']').prop( 'checked', true );
            $('input[name=afontsize_predefined][value='+ $afontsize+']').prop( 'checked', true );
            $('input[name=afontalignement_predefined][value='+ $afontalignement+']').prop( 'checked', true );

            $('.cp-input-txt').val( $( ".i_"+$now +" pre").text() );
            $('input[name=size_predefined]').val( $size );
            $('input[name=letter_predefined]').val( $limit_pred );
            $('input[name=color_predefined]').css('background-color', $color );
            $('input[name=color_predefined]').val( $color );
            $( ".i_"+$now +" pre").addClass('current');
            $( ".i_"+$now +"").addClass('active');
         }
    }

    function writeTodashImg($now) {
        var $tags_pred = $( ".i_"+$now).attr('data-tags');
         $.each( $("input[name='tags_predefined']"), function(){
            $(this).prop( 'checked', false )
         });

        $tags_pred = $tags_pred.split('=+');
        $tags_pred.forEach(function( $val ){
            if( $val != '' )
                $('#cp-tags input[value='+ $val+']').prop( 'checked', true );
        });
    }
    
    function getFromdashImg() {
        var tags = [];
        $.each( $("input[name='tags_predefined']:checked"), function(){
            tags.push( $(this).val() );
        });
        tags = tags.join('=+');
        $('.z-i.active').attr("data-tags", tags);
    }

    function getFromdash() {
         var size = $( "input[name=size_predefined]").val();
         var limit = $( "input[name=letter_predefined]").val();
         var color = $( "input[name=color_predefined]").css('background-color');
         var font_pred = $.trim($( "input[name=fonts_predefined]:checked").closest('label').text());
         var align_pred = $.trim($( "input[name=align_predefined]:checked").val());
         var valign_pred = $.trim($( "input[name=valign_predefined]:checked").val());
         var acolor = $.trim($( "input[name=acolor_predefined]:checked").val());
         var afont = $.trim($( "input[name=afont_predefined]:checked").val());

         var abreak = $.trim($( "input[name=abreak_predefined]:checked").val());
         var afontsize = $.trim($( "input[name=afontsize_predefined]:checked").val());
         var afontalignement = $.trim($( "input[name=afontalignement_predefined]:checked").val());

         var id_font_pred = $.trim($( "input[name=fonts_predefined]:checked").val());
         var text = $( ".cp-input-txt").val();
         $('.z-t .current').attr('style','font-size:'+size+'px;color: '+color+';font-family: '+font_pred+'; text-align:'+align_pred+'');
         $('.z-t .current').attr("id_font", id_font_pred);
         $('.z-t .current').attr("data-valign", valign_pred);
         $('.z-t .current').attr("data-acolor", acolor);
         $('.z-t .current').attr("data-afont", afont);
         $('.z-t .current').attr("data-limit", limit);

         $('.z-t .current').attr("data-abreak", abreak);
         $('.z-t .current').attr("data-afontsize", afontsize);
         $('.z-t .current').attr("data-afontalignement", afontalignement);

         $('.z-t .current').text( text );
    }

    function storeData() {
        var $width_space = $('.zone-mask-work-down').width();
        var $height_space = $('.zone-mask-work-down').height();

        var $width_space_2 = $('.zone-mask-work-down-2').width();
        var $height_space_2 = $('.zone-mask-work-down-2').height();

        var $img = '';
        var $txt = '';
        var design = '';
        var $img_2 = '';
        var $txt_2 = '';
        var design_2 = '';

        $('.zone-mask-work-down .z-i').each(function(){
            var $w = $(this).outerWidth();
            var $h = $(this).outerHeight();
            console.log($(this).attr('class') + '//' + $w + '//' + $h);
            var $l = parseFloat( $(this).position().left );
            var $t = parseFloat( $(this).position().top );
            var $r = getRotationDegrees($(this));
            var $tags = $(this).attr('data-tags');
            if( $r != 0 ) {
                var $r_s = $r;
                $r = 0;
                $(this).css('transform', 'rotate('+$r+'deg)');
                $l = parseFloat( $(this).css('left') );
                $t = parseFloat( $(this).css('top') );
                $(this).attr('style', 'display:inline-block;left:'+$l+'px;top:'+$t+'px;width:'+$w+'px;height:'+$h+'px;transform: rotate('+$r_s+'deg);-webkit-transform: rotate('+$r_s+'deg);-o-transform: rotate('+$r_s+'deg);');
                $r = $r_s;
            }

            $img+= $w+':::'+$h+':::'+$l+':::'+$t+':::'+$r+':::'+$tags+';';
        });
 
        $('.zone-mask-work-down .z-t').each(function(){
            var $w = $(this).outerWidth();
            var $h = $(this).outerHeight();
            var $l = parseFloat( $(this).position().left );
            var $t = parseFloat( $(this).position().top );
            var $r = getRotationDegrees($(this));
            var $size = parseFloat( $(this).find('pre').css('font-size') );
            var $color = $(this).find('pre').css('color');
            var $font = $(this).find('pre').css('font-family').replace(/"/g,'').replace(/'/g,""); 
            var $align = $(this).find('pre').css('text-align');
            var $text = $(this).find('pre').text();
            var $id_font = $(this).find('pre').attr('id_font');
            var $valign = $(this).find('pre').attr('data-valign');
            var $acolor = $(this).find('pre').attr('data-acolor');
            var $afont = $(this).find('pre').attr('data-afont');  
            var $limit = $(this).find('pre').attr('data-limit');

            var $abreak = $(this).find('pre').attr('data-abreak');
            var $afontsize = $(this).find('pre').attr('data-afontsize');
            var $afontalignement = $(this).find('pre').attr('data-afontalignement');

            if( $r != 0 ) {
                var $r_s = $r;
                $r = 0;
                $(this).css('transform', 'rotate('+$r+'deg)');
                $l = parseFloat( $(this).css('left') );
                $t = parseFloat( $(this).css('top') );
                $(this).attr('style', 'display:inline-block;left:'+$l+'px;top:'+$t+'px;width:'+$w+'px;height:'+$h+'px;transform: rotate('+$r_s+'deg);-webkit-transform: rotate('+$r_s+'deg);-o-transform: rotate('+$r_s+'deg);');
                $r = $r_s;
            }

            $txt+= $text+':::'+$w+':::'+$h+':::'+$l+':::'+$t+':::'+$size+':::'+$color+':::'+$font+':::'+$align+':::'+$r+':::'+$id_font+':::'+$valign+':::'+$acolor+':::'+$afont+':::'+$limit+':::'+$abreak+':::'+$afontsize+':::'+$afontalignement+';';
        });

        $('.zone-mask-work-down-2 .z-i').each(function(){
            var $w = $(this).outerWidth();
            var $h = $(this).outerHeight();
            var $l = parseFloat( $(this).position().left );
            var $t = parseFloat( $(this).position().top );
            var $r = getRotationDegrees($(this));
            var $tags = $(this).attr('data-tags');

            if( $r != 0 ) {
                var $r_s = $r;
                $r = 0;
                $(this).css('transform', 'rotate('+$r+'deg)');
                $l = parseFloat( $(this).css('left') );
                $t = parseFloat( $(this).css('top') );
                $(this).attr('style', 'display:inline-block;left:'+$l+'px;top:'+$t+'px;width:'+$w+'px;height:'+$h+'px;transform: rotate('+$r_s+'deg);-webkit-transform: rotate('+$r_s+'deg);-o-transform: rotate('+$r_s+'deg);');
                $r = $r_s;
            }

            $img_2+= $w+':::'+$h+':::'+$l+':::'+$t+':::'+$r+':::'+$tags+';';
        }); 
 
        $('.zone-mask-work-down-2 .z-t').each(function(){
            var $w = $(this).outerWidth();
            var $h = $(this).outerHeight();
            var $l = parseFloat( $(this).position().left );
            var $t = parseFloat( $(this).position().top );
            var $r = getRotationDegrees($(this));
            var $size = parseFloat( $(this).find('pre').css('font-size') );
            var $color = $(this).find('pre').css('color');
            var $font = $(this).find('pre').css('font-family').replace(/"/g,'').replace(/'/g,""); 
            var $align = $(this).find('pre').css('text-align');
            var $text = $(this).find('pre').text();
            var $id_font = $(this).find('pre').attr('id_font');
            var $valign = $(this).find('pre').attr('data-valign');
            var $acolor = $(this).find('pre').attr('data-acolor');
            var $afont = $(this).find('pre').attr('data-afont');
            var $limit = $(this).find('pre').attr('data-limit');

            var $abreak = $(this).find('pre').attr('data-abreak');
            var $afontsize = $(this).find('pre').attr('data-afontsize');
            var $afontalignement = $(this).find('pre').attr('data-afontalignement');

            if( $r != 0 ) {
                var $r_s = $r;
                $r = 0;
                $(this).css('transform', 'rotate('+$r+'deg)');
                $l = parseFloat( $(this).css('left') );
                $t = parseFloat( $(this).css('top') );
                $(this).attr('style', 'display:inline-block;left:'+$l+'px;top:'+$t+'px;width:'+$w+'px;height:'+$h+'px;transform: rotate('+$r_s+'deg);-webkit-transform: rotate('+$r_s+'deg);-o-transform: rotate('+$r_s+'deg);');
                $r = $r_s;
            }

            $txt_2+= $text+':::'+$w+':::'+$h+':::'+$l+':::'+$t+':::'+$size+':::'+$color+':::'+$font+':::'+$align+':::'+$r+':::'+$id_font+':::'+$valign+':::'+$acolor+':::'+$afont+':::'+$limit+':::'+$abreak+':::'+$afontsize+':::'+$afontalignement+';';
        });

        design = $width_space + '|' + $img + '|' + $txt + '|' + $height_space;
        design_2 = $width_space_2 + '|' + $img_2 + '|' + $txt_2 + '|' + $height_space_2;

        $('#design_pre').val( design );
        $('#design_pre_2').val( design_2 );
        $('#helper-id').val('1');
    }

    $(document).on('click','.zone-mask-work-down', function(e){
        if( !$(e.target).closest('.zone-img')[0] )
            $('.zone-img').removeClass('active');
    });

    $(document).on('keydown', function(e){
        if( jQuery('.zone-img.active')[0] ) {
            switch(e.which) {
                case 37: {
                    e.preventDefault(); //Prevent default action for keys
                    jQuery('.zone-img.active').css('left', parseFloat(jQuery('.zone-img.active').css('left')) - 1 + 'px');
                    $( '.zone-img.active' ).find('.l-i').val( $( '.zone-img.active' ).position().left );
                    $( '.zone-img.active' ).find('.t-i').val( $( '.zone-img.active' ).position().top );
                    storeData();
                    break;
                }
                case 38: {
                    e.preventDefault();
                    jQuery('.zone-img.active').css('top', parseFloat(jQuery('.zone-img.active').css('top')) - 1 + 'px');
                    $( '.zone-img.active' ).find('.l-i').val( $( '.zone-img.active' ).position().left );
                    $( '.zone-img.active' ).find('.t-i').val( $( '.zone-img.active' ).position().top );
                    storeData();
                    break;
                }
                case 39: {
                    e.preventDefault();
                    jQuery('.zone-img.active').css('left', parseFloat(jQuery('.zone-img.active').css('left')) + 1 + 'px');
                    $( '.zone-img.active' ).find('.l-i').val( $( '.zone-img.active' ).position().left );
                    $( '.zone-img.active' ).find('.t-i').val( $( '.zone-img.active' ).position().top );
                    storeData();
                    break;
                }
                case 40: {
                    e.preventDefault();
                    jQuery('.zone-img.active').css('top', parseFloat(jQuery('.zone-img.active').css('top')) + 1 + 'px');
                    $( '.zone-img.active' ).find('.l-i').val( $( '.zone-img.active' ).position().left );
                    $( '.zone-img.active' ).find('.t-i').val( $( '.zone-img.active' ).position().top );
                    storeData();
                    break;
                }
            }
        } else if( jQuery('.list-tab li').eq(1).find('a').hasClass('active') && $('.case').hasClass('current') ) {
            switch(e.which) {
                case 37: {
                    e.preventDefault();
                    jQuery('.case.current').css('left', parseFloat(jQuery('.case.current').css('left')) - 1 + 'px');
                    if( $('#preview-2').hasClass('current') ) 
                        updateKeyup_1();
                    else 
                        updateKeyup();
                    break;
                }
                case 38: {
                    e.preventDefault();
                    jQuery('.case.current').css('top', parseFloat(jQuery('.case.current').css('top')) - 1 + 'px');
                    if( $('#preview-2').hasClass('current') ) 
                        updateKeyup_1();
                    else 
                        updateKeyup();
                    break;
                }
                case 39: {
                    e.preventDefault();
                    jQuery('.case.current').css('left', parseFloat(jQuery('.case.current').css('left')) + 1 + 'px');
                    if( $('#preview-2').hasClass('current') ) 
                        updateKeyup_1();
                    else 
                        updateKeyup();
                    break;
                }
                case 40: {
                    e.preventDefault();
                    jQuery('.case.current').css('top', parseFloat(jQuery('.case.current').css('top')) + 1 + 'px');
                    if( $('#preview-2').hasClass('current') ) 
                        updateKeyup_1();
                    else 
                        updateKeyup();
                    break;
                }
            }
        }
    });

    $(document).on('keyup','.cp-input-txt, input[name=size_predefined], input[name=color_predefined], input[name=letter_predefined]', function(){
        getFromdash();
        $('#helper-id').val('1');
        storeData();
    }); 

    $('input[name=color_predefined]').on('change', function() {
        if( $(this).val() != '' ) {
            getFromdash();
            $('#helper-id').val('1');
            storeData();
        }
    });
    
    $(document).on('click','#cp-textarea .col-lg-8 label,.align-link .font-wa, .vlign-link .font-wa', function(){
        getFromdash();
        $('#helper-id').val('1');
        storeData();
    });

    $(document).on('click','#cp-tags .col-lg-8 label', function(){
        getFromdashImg();
        $('#helper-id').val('1');
        storeData();
    });

    $(document).on('click','.switcher-mode a', function(){
        var href = $(this).attr('href');
        $('.z-t, .z-i, .switcher-mode a').removeClass('active');
        $(this).addClass('active');

        $('.zone-mask-work-down, .zone-mask-work-down-2').css('visibility','hidden');
        $('.zone-mask-work-down, .zone-mask-work-down-2').css('z-index','-1');
        $('.'+href).css('z-index','1');
        $('.'+href).css('visibility','visible').show();
        return false;
    });

    $(document).on('keyup','.w-i', function(){
        $(this).closest('.zone-img').width( $(this).val() );
        $('#helper-id').val('1');
        storeData();
    });

    $(document).on('keyup','.r-i', function(){
        $(this).closest('.zone-img').css("transform", 'rotate('+$(this).val() + 'deg)' );
        $(this).closest('.zone-img').css("-moz-transform", 'rotate('+$(this).val() + 'deg)' );
        $(this).closest('.zone-img').css("-ms-transform", 'rotate('+$(this).val() + 'deg)' );
        $(this).closest('.zone-img').css("-o-transform", 'rotate('+$(this).val() + 'deg)' );
        $(this).closest('.zone-img').css("-webkit-transform", 'rotate('+$(this).val() + 'deg)' ); 
        $('#helper-id').val('1'); 
        storeData();
    });

    $(document).on('keyup','.t-i', function(){
        $(this).closest('.zone-img').css( 'top' , $(this).val()+'px' );
        $('#helper-id').val('1');
        storeData();
    });

    $(document).on('keyup','.l-i', function(){
        $(this).closest('.zone-img').css( 'left' , $(this).val()+'px' );
        $('#helper-id').val('1');
        storeData();
    });

    $(document).on('keyup','.h-i', function(){
        $(this).closest('.zone-img').height( $(this).val() );
        $('#helper-id').val('1');
        storeData();
    });

    $(document).on('click','.btn-delete-zone', function(){
        $(this).closest('.zone-img').remove();
        storeData();
        return false;
    });

    $('.additional-price').keyup(function(){
        $('#helper-id').val('1');
    });

    $('.radiobtn').bind('click',function(e){
       if( $(this).attr('id') == 'active_item_on') {
            jQuery("#extra_active").val('1');
            jQuery("#enabled_clicked").val('1');
            $('#show-block').slideDown('pretty');

            jQuery('.form-horizontal.product-page').append('<input type="hidden" value="1" id="custom_field_me" name="form[step6][custom_fields][0][type]">');
            jQuery('.form-horizontal.product-page').append('<input type="hidden" value="Custom product" id="custom_text_me" name="form[step6][custom_fields][0][label][1]">');

        }
       else {
            jQuery("#extra_active").val('0');
            jQuery("#enabled_clicked").val('0');
            $('#show-block').slideUp('pretty');
            $('#custom_field_me, #custom_text_me').remove();
            $('#custom_fields .customFieldCollection *').remove(); 
       }
       $('#helper-id').val('1');
    });

    $('.radiobtn-1').bind('click',function(e){
       if( $(this).attr('id') == 'active_design_on') {
            jQuery("#extra_design").val('1');
            $('.space-work').slideDown('pretty');
        }
       else {
            jQuery("#extra_design").val('0');
            $('.space-work').slideUp('pretty');
       }
       $('#helper-id').val('1');
    });

    $('.radiobtn-30').bind('click',function(e){
       if( $(this).attr('id') == 'active_bg_on') {
            jQuery("#active_bg").val('1');
        }
       else {
            jQuery("#active_bg").val('0');
       }
       $('#helper-id').val('1');
    });

    $('.selector-in-3').bind('click',function(e){
       if( $(this).attr('id') == 'des-1') {
            jQuery("#extra_design").val('1');
            $('.space-work').slideDown('pretty');
        }
       else {
            jQuery("#extra_design").val('0');
            $('.space-work').slideUp('pretty');
       }
       $('#helper-id').val('1');
    });
    

    $('.btn-tab').bind('click',function(e){
       var $ids = $(this).attr('href');
       $('.tabs-sm').hide();
       $('.btn-tab').removeClass('active');
       $(this).addClass('active');
       $($ids).fadeIn('pretty');
       $('.zone-img.active').removeClass('active');
       return false;
    });

    $('#extra_image-selectbutton').click(function(e){
        $('#extra_image').trigger('click');
        $('#helper-id').val('1');
    });

    $('#tperso').change(function(e){
        $('#helper-id').val('1');
    });

    $('#extra_image').change(function(e){
        var val = $(this).val();
        var file = val.split(/[\\/]/);
        $('#extra_image-name').val(file[file.length-1]);
    });

    $('#extra_mask-selectbutton').click(function(e){
        $('#extra_mask').trigger('click');
        $('#helper-id').val('1');
    });

    $('#extra_mask').change(function(e){
        var val = $(this).val();
        var file = val.split(/[\\/]/);
        $('#extra_mask-name').val(file[file.length-1]);
    });

    /* Side Two */
    $('.font-wa, .switchers .switch-input').bind('click',function(e){
       $('#helper-id').val('1');
    });  

    $('.selector-in-1').bind('click',function(e){
       if( $(this).attr('id') == 'cd-1' ||  $(this).attr('id') == 'active_item_on_1') {
            jQuery("#extra_active_2").val('1');
            $('#show-block-2').slideDown('pretty');
            $('.switcher-mode').show();
        }
       else {
            jQuery("#extra_active_2").val('0');
            $('#show-block-2').slideUp('pretty');
            $('.switcher-mode,.zone-mask-work-down-2').hide();
            $('.zone-mask-work-down').show();
       }
       $('#helper-id').val('1');
    });

    $('#extra_image_2-selectbutton').click(function(e){
        $('#extra_image_2').trigger('click');
        $('#helper-id').val('1');
    });

    $('#extra_image_2').change(function(e){
        var val = $(this).val();
        var file = val.split(/[\\/]/);
        $('#extra_image_2-name').val(file[file.length-1]);
    });
    $('#extra_mask_2-selectbutton').click(function(e){
        $('#extra_mask_2').trigger('click');
        $('#helper-id').val('1');
    });
    $('#extra_mask_2').change(function(e){
        var val = $(this).val();
        var file = val.split(/[\\/]/);
        $('#extra_mask_2-name').val(file[file.length-1]);
    });
    $('#fileupload').fileupload({
        url: url,  
        dataType: 'json',
        add: function (e, data) {
            var runUpload = true;
            var uploadFile = data.files[0];
            if (!(/\.(gif|jpg|png|tiff|png|jpeg|gif|JPG|PNG|TIFF|JPEG|GIF)$/i).test(uploadFile.name)) {
                alertify.alert("You must select an image file only");
                runUpload = false;
            }
            else if (uploadFile.size > 30000000) { // 30mb
                alertify.alert("Please upload a smaller image, max size is 30 MB");
                runUpload = false;
            }

            if (runUpload == true) {
                    $('#upload_process').text(' ');
                data.submit();
                $('#spin_1').show();
            }
        },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('#upload_image').html('<img src="'+file.url+'" alt="" style="border: 1px solid #bbcdd2;padding:5px;max-height:80px;"/>');
                $('#upload_url').val(file.name);
                $('.mask-worker-1 .img-over').remove();
                $('.mask-worker-1 .zone-mask-work-down').append('<img src="'+file.url+'" alt="" style="max-width:100%" class="img-over"/>');
                $('.zone-mask-work-down .no-background').remove();  
                $('.bg-preview-1').attr('src', $('#upload_image>img').attr('src'));
            });
            $('#helper-id').val('1');
            $('#spin_1').hide();
        },
        progressall: function (e, data) {
            $('.panel-footer').hide();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#upload_process').html('<i class="fa fa-spinner fa-spin fa-fw"></i> '+progress + '%');
        },

        stop:function(){
            setTimeout(function(){
                    $('#upload_process').text(' ');
                    $('.panel-footer').fadeIn('pretty');
            },1000);
        }
    });

    $('#fileupload_1').fileupload({
        url: url,
        dataType: 'json',
        add: function (e, data) {
            var runUpload = true;
            var uploadFile = data.files[0];
            if (!(/\.(gif|jpg|png|tiff|png|jpeg|gif|JPG|PNG|TIFF|JPEG|GIF)$/i).test(uploadFile.name)) {
                alertify.alert("You must select an image file only");
                runUpload = false;
            }
            else if (uploadFile.size > 30000000) { // 4mb
                alertify.alert("Please upload a smaller image, max size is 30 MB");
                runUpload = false;
            }

            if (runUpload == true) {
                $('#upload_process_1').text(' ');
                data.submit();
                $('#spin_2').show();
            }
        },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('#upload_image_1').html('<img src="'+file.url+'" alt="" style="border: 1px solid #bbcdd2;padding:5px;max-height:80px;"/>')
                $('#upload_url_1').val(file.name);
                $('#spin_2').hide();
                $('.bg-preview-1').attr('src', $('#upload_image>img').attr('src'));
                $('.mask-preview-1').attr('src', file.url);
                $('#zone-upload-1').fadeIn('slow');
                $('.mask-worker-1 .mask-over').remove();
                $('.mask-worker-1 .zone-mask-work-down').append('<img src="'+file.url+'" alt="" style="max-width:100%" class="mask-over"/>');
            });
            $('#helper-id').val('1');
        },
        progressall: function (e, data) {
            $('.panel-footer').hide();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#upload_process_1').html('<i class="fa fa-spinner fa-spin fa-fw"></i> '+progress + '%');
        },

        stop:function(){
            setTimeout(function(){
                    $('#upload_process_1').text(' ');
                    $('.panel-footer').fadeIn('pretty');

            },1000);

        }
    });

    $('#fileupload_s2').fileupload({
        url: url,
        dataType: 'json',
        add: function (e, data) {
            var runUpload = true;
            var uploadFile = data.files[0];
            if (!(/\.(gif|jpg|png|tiff|png|jpeg|gif|JPG|PNG|TIFF|JPEG|GIF)$/i).test(uploadFile.name)) {
                alertify.alert("You must select an image file only");
                runUpload = false;
            }
            else if (uploadFile.size > 30000000) { // 30mb
                alertify.alert("Please upload a smaller image, max size is 30 MB");
                runUpload = false;
            }

            if (runUpload == true) {
                    $('#upload_process').text(' ');
                data.submit();
                $('#spin_1_s2').show();
            }
        },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('#upload_image_s2').html('<img src="'+file.url+'" alt="" style="border: 1px solid #bbcdd2;padding:5px;max-height:80px;"/>');
                $('#upload_url_s2').val(file.name);
                $('.bg-preview-2').attr('src', $('#upload_image_s2>img').attr('src'));
                $('.mask-preview-2').attr('src', file.url);
                $('#zone-upload-2').fadeIn('slow');

                $('.mask-worker-1 .img-over-2').remove();
                $('.mask-worker-1 .zone-mask-work-down-2').append('<img src="'+file.url+'" alt="" style="max-width:100%" class="img-over-2"/>');
                $('.switcher-mode').show();
    
            });
            $('#helper-id').val('1');
            $('#spin_1_s2').hide();
        },
        progressall: function (e, data) {
            $('.panel-footer').hide();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#upload_process_s2').html('<i class="fa fa-spinner fa-spin fa-fw"></i> '+progress + '%');
        },

        stop:function(){
            setTimeout(function(){
                    $('#upload_process_s2').text(' ');
                    $('.panel-footer').fadeIn('pretty');
            },1000);

        }
    });

    $('#fileupload_1_s2').fileupload({
        url: url,
        dataType: 'json',
        add: function (e, data) {
            var runUpload = true;
            var uploadFile = data.files[0];
            if (!(/\.(gif|jpg|png|tiff|png|jpeg|gif|JPG|PNG|TIFF|JPEG|GIF)$/i).test(uploadFile.name)) {
                alertify.alert("You must select an image file only");
                runUpload = false;
            }
            else if (uploadFile.size > 30000000) { // 4mb
                alertify.alert("Please upload a smaller image, max size is 30 MB");
                runUpload = false;
            }

            if (runUpload == true) {
                $('#upload_process_1_s2').text(' ');
                data.submit();
                $('#spin_2_s2').show();
            }
        },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('#upload_image_1_s2').html('<img src="'+file.url+'" alt="" style="border: 1px solid #bbcdd2;padding:5px;max-height:80px;"/>')
                $('#upload_url_1_s2').val(file.name);
                $('#spin_2_s2').hide();

                $('.bg-preview-2').attr('src', $('#upload_image_s2>img').attr('src'));
                $('.mask-preview-2').attr('src', file.url);

                $('.mask-worker-1 .mask-over-2').remove();
                $('.mask-worker-1 .zone-mask-work-down-2').append('<img src="'+file.url+'" alt="" style="max-width:100%" class="mask-over-2"/>');
                $('.zone-mask-work-down-2 .no-background').remove();
            });
            $('#helper-id').val('1');
        },
        progressall: function (e, data) {
            $('.panel-footer').hide();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#upload_process_1_s2').html('<i class="fa fa-spinner fa-spin fa-fw"></i> '+progress + '%');
        },

        stop:function(){
            setTimeout(function(){
                    $('#upload_process_1_s2').text(' ');
                    $('.panel-footer').fadeIn('pretty');
            },1000);

        } 
    });
});