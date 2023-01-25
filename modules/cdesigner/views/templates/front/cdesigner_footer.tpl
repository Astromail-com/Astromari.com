{*
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
* @author    Prestaeg <infos@presta.com>
* @copyright Prestaeg
* @version   1.0.0
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

<style>
    {foreach from=$fonts item=item}
        {if $item.woff != ''}
            @font-face {
                font-family: '{$item.title}';
                src: url('{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/upload/{$item.woff2}') format('woff2'),
                     url('{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/upload/{$item.woff}') format('woff');
                font-weight: normal;
                font-style: normal;
            }
        {else}
            @import url("{$item.url_font|escape:'htmlall':'UTF-8'}");
        {/if}
    {/foreach}

    {if $layout == 2 }
      #cp-sel-layout>ul>li:first-child{
        display: none;
      }
    {/if}

    {if ( count($type_layout) == 1 && !'all'|in_array:$type_layout ) ||  $extra_design == 1 }
      #step1{
        display: none !important;
      }
      @media only screen and (max-width: 979px) {
        .navigation-mobile li {
            width: 50% !important; 
        }
      }
    {/if}

     {if $type_perso == 1 && $extra_design == 0}
        #cp-st-3, #step3{
            display: none !important;
        }
     {elseif $type_perso == 2 && $extra_design == 0}
        /*
        #lft-side:after{
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            right: 0;
            background: rgba(255,255,255,.95);
            z-index: 999;
        }*/
        #img-steps,
        #cp-st-1,
        #cp-st-2,
        #step1,
        #step2{
            display: none !important
        }
        #step3{
            display: block !important
        }
     {/if}

     {if $allow_upload == 0 || ($allow_zone == 1 && $extra_design == 1)}
        .cp-btn-more-pic.fileinput-button{
            display: none !important
        }
     {/if}

     {if $allow_help == 0 || $url_demo_video == ''}
        .cp-btn-help{
            display: none !important
        }
     {/if}
</style>
<script type="text/javascript">
    var baseDir = '{$urls.base_url|escape:'htmlall':'UTF-8'}';
    var baseUri = '{$urls.base_url|escape:'htmlall':'UTF-8'}';
    var must_select_layout = "{l s='You must select the layout' mod='cdesigner'}";
    var image_only = "{l s='You must select an image file only' mod='cdesigner'}";
    var max_size = "{l s='Please upload a smaller image, max size is 12 MB' mod='cdesigner'}";
    var reset_design = "{l s='You want to reset your design ?' mod='cdesigner'}";
    var back_string = "{l s='Back' mod='cdesigner'}";
    var ok_string = "{l s='OK' mod='cdesigner'}";
    var ok_str = "{l s='OK' mod='cdesigner'}";
    var crop_pic = "{l s='Crop this picture' mod='cdesigner'}";
    var cancel_str = "{l s='Cancel' mod='cdesigner'}";
    var delete_pic = "{l s='delete this picture' mod='cdesigner'}";
    var on_process = "{l s='Save in process' mod='cdesigner'}";
    var redirection = "{l s='redirection' mod='cdesigner'}";
    var success_save = "{l s='Your design was saved with success' mod='cdesigner'}";
    var error_save = "{l s='You must be connected for you can save your design' mod='cdesigner'}";
    var loading_text = "{l s='Please wait, loading...' mod='cdesigner'}";

    var required_img = "{l s='Please Design Your Product Before Adding to cart' mod='cdesigner'}";
    var required_text = "{l s='Please Fill All Text Before Adding to cart' mod='cdesigner'}";
    var required_img_pre = "{l s='Please Fill All Images Zones Before Adding to cart' mod='cdesigner'}";

    var active_bg = '{$active_bg}';
    var url_demo_video = '{$url_demo_video}';
    var allow_comb = '{$allow_comb}';

    {if $required_field == 1}
        var required_design = 1;
    {else}
        var required_design = 0;
    {/if}
</script>

<link rel="stylesheet" href="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/css/stylesheets/font-awesome.css" type="text/css" media="all">
<link rel="stylesheet" href="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/css/stylesheets/jquery-ui.css" type="text/css" media="all">
<link rel="stylesheet" href="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/css/stylesheets/font.css" type="text/css" media="all">
<link rel="stylesheet" href="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/css/stylesheets/styles.css?v=1.2" type="text/css" media="all">
<link rel="stylesheet" href="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/css/stylesheets/cropper.css" type="text/css" media="all">

<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}themes/core.js"></script> 
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/es6-promise.auto.js"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/html2canvas.min.js?v=1.0.1"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/cp-lib-min.js"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/rotate.js"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/touch.punch.js"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/load-image.all.min.js"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/cdesigner.js?v=1.0.6"></script>
<span id="product-ids" style="display:none">{$id_product}</span>
<div id="wrap-phone-dup">
    <div id="wrap-phone" {if $extra_design == 1 } class="pre-design{if $allow_zone == 1} allow-zone{/if}"{/if}>
        <div id="head-cdes">
            <h3>
                <img src="{$shop.logo}" />
                <!--img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/logo_c_black.png" /-->
            </h3>
            <a href="" class="btn-close-pl" id="back-c-home">
                <samp>
                    <span>{l s='Back to the website' mod='cdesigner'}</span> <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/close.png"></samp></i>
                </samp>
            </a>
        </div>  
        {if $allow_help == '1' && $url_demo_video != ''}
            <a href="javascript:void(0);" class="cp-btn-help" title="{l s='How it works ?' mod='cdesigner'}" data-video="{$url_demo_video}">
                <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/question.png" /></samp>
                <span>{l s='Help' mod='cdesigner'}</span>
            </a>
        {/if}
        <!-- Link to Step -->
        <ul id="cp-link-step">
            <li id="cp-st-1" class="cp-active cp-current-step">
                <a href="javascript:void(0)">
                    <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/step1.png"></samp>
                    <span>{l s='Layouts' mod='cdesigner'}</span>
                </a>
            </li>
            <li id="cp-st-2">
                <a href="javascript:void(0)">
                    <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/step2.png"></samp>
                    <span>{l s='Photos' mod='cdesigner'}</span>
                </a>
            </li>
            <li id="cp-st-3">
                <a href="javascript:void(0)">
                    <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/step3.png"></samp>
                    <span>{l s='Text' mod='cdesigner'}</span>
                </a>
            </li>
        </ul>
        <!-- End Link to Step -->
        <div id="lft-side">
            <a href="javascript:void(0)" class="btn-close-mobile"><i class="fa fa-times" aria-hidden="true"></i><span>{l s='Back to your design' mod='cdesigner'}</span></a>
            <a href="javascript:void(0)" class="btn-close-mobile for-bottom">{l s='OK' mod='cdesigner'}</i></a>
            <div id="cp-ct-step">
                <!-- Start Screen -->
                <div class="start" id="step1">
                    <p class="cp-title">{l s='Choose your layout' mod='cdesigner'}</p>
                    <div class="wr-dev-choice">
                        <div class="wr-dev-choice-helper">
                            <!-- Bloc Select layout -->
                            <div id="cp-sel-layout">
                                <ul>
                                    {foreach from=$layout item=item}
                                        {if $item|in_array:$type_layout || 'all'|in_array:$type_layout}
                                            {if $item == 'free'}
                                                <li>
                                                    <a href="" class="free-layout"><img src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/free.png"/></a>
                                                </li>
                                            {else}
                                                <li>
                                                    <a href="" class="cp-choose-grid-button"><img src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/config/layout/{$item|escape:'htmlall':'UTF-8'}/grid.png"/><span class="title-find" style="display:none">{$item|escape:'htmlall':'UTF-8'}</span></a>
                                                </li>
                                            {/if}
                                        {/if}
                                    {/foreach}
                                </ul>
                            </div>
                            <!-- End Bloc Select layout -->
                        </div>
                    </div>
                </div>
                <!-- End Start Screen -->
                <div id="step2" style="display:none;">
                    <p class="cp-title">{l s='Add your photos' mod='cdesigner'}</p>
                    <div class="wr-dev-choice">
                        <div class="wr-dev-choice-helper">
                            <div id="cp-sel-Photos">
                                <div class="float-link">
                                        <a href="javascript:void(0);" title="{l s='Import from your computer' mod='cdesigner'}" class="cp-btn-more-pic fileinput-button">
                                        <span id="cp-img-lo-w">
                                            <i class="fa fa-refresh fa-spin" id="cp-img-lo"></i>
                                            <span class="cp-loader-number"></span>
                                        </span>
                                        <img src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/btn_upload.png" class="file-upload-img" />
                                        <samp>{l s='Browse Your Photos' mod='cdesigner'}</samp>
                                        <input id="fileupload" type="file" name="files[]" accept="image/*" multiple>
                                        <input type="hidden" class="cp-token" value="">
                                    </a>
                                    {if isset($client_id) & !empty($client_id) & $active_item == 1 }
                                    <a href="javascript:void(0);" id="btn-instagram" class="cp-btn-more-pic" title="{l s='Import Your Photos from Instagram' mod='cdesigner'}">
                                        <img src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/btn_facebook.png" />
                                    </a>
                                    {/if}
                                    
                                    {if isset($app_id) & !empty($app_id) & $active_item_face == 1 }
                                    <a href="javascript:void(0);" id="btn-facebook" class="cp-btn-more-pic" title="{l s='Import Your Photos from Facebook' mod='cdesigner'}" onclick="checkLoginState()">
                                        <img src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/btn_facebook.png" />
                                    </a>
                                    {/if}
                                </div>
                                
                                <div class="jscroll lst-img">
                                    <div class="hide load-img-gallery">
                                        {assign var=value_tag_glob value=""}
                                        {foreach from=$images_def item=item}
                                            {if $item.id_img|in_array:$type_image || 'all'|in_array:$type_image}
                                                {assign var=value_tag value=$item.tags}
                                                {assign value_tag_glob value=$value_tag_glob|cat:";"|cat:$item.tags|lower}
                                                <span data-id="$item.id_img" data-class="{foreach from=$value_tag item=tag} {$tag|lower|replace:' ':''} {/foreach}">{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/upload/{$item.image|escape:'htmlall':'UTF-8'}</span>
                                            {/if}
                                        {/foreach}
                                    </div>

                                    <div class="lst-tags">
                                        {assign var=value_tags value=";"|explode:$value_tag_glob}
                                        {foreach from=$tags_image item=value}
                                            {if $value[1] != '' && $value[1]|in_array:$value_tags}
                                                <a href="" id="{$value[1]|lower|replace:' ':''|escape:'htmlall':'UTF-8'}" data-tagid="{$value[0]|escape:'htmlall':'UTF-8'}">{$value[1]|escape:'htmlall':'UTF-8'}</a>
                                            {/if}
                                        {/foreach}
                                        <a href="javascript:void(0)" id="from-desktop" style="display:none;"><i class="fa fa-picture-o"></i>{l s='From Desktop' mod='cdesigner'}</a>
                                        <a href="javascript:void(0)" id="from-instagram" style="display:none;"><i class="fa fa-instagram"></i>{l s='Instagram' mod='cdesigner'}</a>
                                        <a href="javascript:void(0)" id="from-facebook" style="display:none;"><i class="fa fa-facebook" aria-hidden="true"></i>{l s='Facebook' mod='cdesigner'}</a>
                                    </div>

                                    <ul>
                                        {foreach from=$images_def item=item}
                                            {if $item.id_img|in_array:$type_image || 'all'|in_array:$type_image}
                                                {assign var=value_tag value=";"|explode:$item.tags}
                                                <li class="{foreach from=$value_tag item=tag} {$tag|lower|replace:' ':''} {/foreach}"><a href="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/upload/{$item.image|escape:'htmlall':'UTF-8'}"><span class="on-process-load"></span><img dssrc="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/upload/_thumb_{$item.image|escape:'htmlall':'UTF-8'}"><i class="fa fa-plus"></i></a></li>
                                            {/if}
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="step3" style="display:none;">
                    <p class="cp-title">{l s='Write Your Text' mod='cdesigner'}</p>
                    <!--div id="text-mobile"></div-->
                    <div id="cp-sel-Text">
                        <a href="" class="show-text-mobile" title="{l s='Show Text Edit' mod='cdesigner'}">
                            <img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/icon_3.png">
                        </a>
                        <!--span class="title-txt">{l s='Add Your Text' mod='cdesigner'}</span-->
                        <div id="cp-textarea-wrap">
                            <div id="cp-textarea">  
                                <div class="combo-typo">
                                    <a href="" class="selected-typo"><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/arrow_select.png"> <span>{l s='Typography' mod='cdesigner'}</span></a>
                                    <ul class="cp-list-font">
                                        {assign var=val value=1}
                                        {foreach from=$fonts item=item}
                                            {if $item.id_font|in_array:$fonts_array || 'all'|in_array:$fonts_array}
                                                {if $val == 1}
                                                    <li><a id="{$item.title|escape:'htmlall':'UTF-8'}" style="font-family:{$item.title|escape:'htmlall':'UTF-8'}" class="active" href="javascript:void(0)">
                                                        {$item.title|escape:'htmlall':'UTF-8'}
                                                    </a>
                                                    </li>
                                                {else}
                                                    <li>
                                                        <a id="{$item.title|escape:'htmlall':'UTF-8'}" style="font-family:{$item.title|escape:'htmlall':'UTF-8'}" href="javascript:void(0)">
                                                        {$item.title|escape:'htmlall':'UTF-8'}
                                                        </a>
                                                    </li>
                                                {/if}
                                                {assign var=val value=$val+1}
                                            {/if}
                                        {/foreach}
                                    </ul>
                                </div>
                                <textarea class="cp-input-txt" placeholder="{l s='Enter text here ...' mod='cdesigner'}"></textarea>
                                <div class="blc-bas">
                                    <div class="cp-list-color">
                                        <a href="" class="ico-col">
                                            <svg version="1.1" id="Gradient" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="256.0002" y1="18" x2="256.0002" y2="497.6127" gradientTransform="matrix(1 0 0 -1 0 514)">
                                                <stop  offset="0" style="stop-color:#27C1E6"/>
                                                <stop  offset="0.5" style="stop-color:#C275E9"/>
                                                <stop  offset="1" style="stop-color:#F2515D"/>
                                            </linearGradient>
                                            <path class="st0" d="M224,216c-39.8,0-72,32.2-72,72s32.2,72,72,72s72-32.2,72-72C296,248.3,263.7,216,224,216z M224,344
                                                c-30.9,0-56-25.1-56-56s25.1-56,56-56s56,25.1,56,56C280,318.9,254.9,344,224,344z M491.1,78.1l-7.4-3.1l6.1-14.8
                                                c6.5-16.4-1.5-35-17.9-41.6c-16.1-6.4-34.4,1.2-41.3,17.1l-6.1,14.8l-7.4-3.1c-4.1-1.7-8.8,0.2-10.5,4.3c0,0,0,0,0,0l-12.2,29.6
                                                c-1.7,4.1,0.2,8.8,4.3,10.5l7.4,3.1l-15.3,37l-8.7,21.1c-17.7-20.7-39.2-37.7-63.4-50.1C289.5,87.7,257,79.9,224,80
                                                C109.3,80,16,173.3,16,288s93.3,208,208,208s208-93.3,208-208c0-21.7-3.4-43.3-10.1-64c0.2-0.4,0.3-0.7,0.5-1.1l27.5-66.5l15.3-37
                                                l7.4,3.1c4.1,1.7,8.8-0.2,10.4-4.3c0,0,0,0,0,0l12.2-29.6C497.1,84.5,495.1,79.8,491.1,78.1L491.1,78.1z M445.5,41.9
                                                c3.2-8.2,12.5-12.3,20.7-9c8.2,3.2,12.3,12.5,9,20.7c-0.1,0.2-0.1,0.4-0.2,0.5l-6.1,14.8l-29.6-12.2L445.5,41.9z M375.2,169.7
                                                l-11.9,28.7l-39.7,22.9c-12.7-18.9-30.4-33.8-51.2-43l24.7-67.8c4.8,2,9.6,4.2,14.3,6.6C336.2,129.8,358,147.7,375.2,169.7z
                                                 M363.9,218l-5.4,13c-5.2,12.2,0.5,26.3,12.7,31.5c12.2,5.2,26.3-0.5,31.5-12.7c0.1-0.1,0.1-0.3,0.2-0.4l5.4-13
                                                c0.2-0.1,0.5-0.2,0.7-0.3c7,25.2,8.9,51.5,5.4,77.4l-71-12.5c0.5-4.3,0.7-8.6,0.7-12.9c0-18.4-4.2-36.5-12.3-52.9l31.7-18.3
                                                C363.5,217.2,363.7,217.6,363.9,218L363.9,218z M216,407.7v72.1c-39.6-1.6-77.8-15.5-109.1-39.8l46.3-55.2
                                                C171.5,398.3,193.3,406.2,216,407.7L216,407.7z M232,407.7c22.7-1.5,44.5-9.4,62.8-22.9l46.3,55.2c-31.4,24.3-69.5,38.2-109.1,39.8
                                                V407.7z M224,392c-57.4,0-104-46.6-104-104s46.6-104,104-104s104,46.6,104,104C327.9,345.4,281.4,391.9,224,392z M282.1,104.9
                                                l-24.7,67.8c-21.8-6.3-45-6.3-66.9,0L165.9,105C203.7,93,244.3,93,282.1,104.9z M150.9,110.5l24.7,67.8c-20.8,9.2-38.5,24.1-51.2,43
                                                l-62.4-36C83.2,151.7,114.3,125.7,150.9,110.5z M53.9,199l62.4,36c-8.1,16.5-12.3,34.6-12.3,52.9c0,4.3,0.2,8.6,0.7,12.9l-71,12.5
                                                C32.6,305,32,296.5,32,288C32,257,39.5,226.5,53.9,199L53.9,199z M36.5,329.2l71-12.5c5.5,22.1,17.1,42.1,33.5,57.9l-46.3,55.2
                                                C65.3,403,45,367.9,36.5,329.2z M353.4,429.7l-46.3-55.2c16.4-15.7,28-35.8,33.5-57.9l71,12.5C403,367.9,382.7,403,353.4,429.7
                                                L353.4,429.7z M407.7,216.7c-1.1,2.6-3.5,4.5-6.3,4.9c-2.8,0.4-5.3,2.2-6.3,4.9l-7,16.8c-1.6,4.1-6.3,6.1-10.4,4.5
                                                c-4.1-1.6-6.1-6.3-4.5-10.4c0-0.1,0.1-0.2,0.1-0.3l6.9-16.8c1.1-2.6,0.7-5.7-1-7.9c-1.7-2.3-2.1-5.3-1-7.9l24.5-59.1l29.6,12.2
                                                L407.7,216.7z M438.3,142.8l-29.6-12.2L421,101l29.6,12.2L438.3,142.8z M471.4,104.6l-59.1-24.5l6.1-14.8l59.1,24.5L471.4,104.6z"/>
                                            </svg>
                                        </a>
                                        <ul>
                                            {foreach from=$colors item=item}
                                                {if $item.id_color|in_array:$type_color || 'all'|in_array:$type_color}
                                                    <li>
                                                        <a id="{$item.color|escape:'htmlall':'UTF-8'}" style="border-color:#{$item.color|escape:'htmlall':'UTF-8'}" href="javascript:void(0)"></a>
                                                    </li>  
                                                {/if}
                                            {/foreach}
                                        </ul>
                                    </div>
                                    <ul id="cp-size-txt">
                                      <li><a id="s-t" class="moins-t s-t s-t-p active" href="javascript:void(0)"><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/sm.png"></a></li>
                                      <li><a id="m-t" class="m-t m-t-p" href="javascript:void(0)"><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/sp.png"></a></li>
                                      <!--li><a id="g-t" class="g-t g-t-p" href="javascript:void(0)">{l s='A' mod='cdesigner'}</a></li-->
                                    </ul>
                                    <ul id="cp-align-txt">
                                      <li><a class="a-right"  href="javascript:void(0)"><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/ar.png"></a></li>
                                      <li><a class="a-center"  href="javascript:void(0)"><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/ac.png"></a></li>
                                      <li><a class="a-left" href="javascript:void(0)"><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/al.png"></a></li>
                                    </ul>
                                </div>
                                <a href="" class="new-txt" title="{l s='Clear the textarea and create a new text' mod='cdesigner'}">{l s='New text' mod='cdesigner'}</a>
                                <a href="" class="add-txt" title="{l s='Add your text to the design' mod='cdesigner'}">{l s='Add' mod='cdesigner'}</a>
                                <a href="" class="save-txt" title="{l s='Save your text to the design' mod='cdesigner'}" style="display:none">{l s='Save' mod='cdesigner'}</a>
                                <span class="cp-token" style="display:none;">c_{$id_product|escape:'htmlall':'UTF-8'}</span>
                                <span id="link-opc" style="display:none;">{$link->getPageLink('cart', true)|escape:'htmlall':'UTF-8'}?action=show</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="cp-add-cart">
                <p class="prix-q"><span class="odometer"></span></p>
                <a href="javascript:void(0);" class="cp-btn-save">{l s='ADD TO CART' mod='cdesigner'}</a>
            </div>
        </div>
        <div id="center-side">
            {if $extra_active_2 == 1}
                <div class="switcher switcher-desktop">
                    <a href="" class="side-1 active" title="{l s='Front' mod='cdesigner'}"><span>{l s='Front' mod='cdesigner'}</span><img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image|escape:'htmlall':'UTF-8'}" alt=""/></a>
                    <a href="" class="side-2" title="{l s='Back' mod='cdesigner'}"><span>{l s='Back' mod='cdesigner'}</span><img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image_2|escape:'htmlall':'UTF-8'}" alt=""/></a>
                </div>
            {/if}
            <div id="cp-phone">
                <div class="cp-info-dev">
                    <span class="cp-title">{$name_product|escape:'htmlall':'UTF-8'}</span>
                </div>
                <div id="cp-add-cart-mobile">
                    <a class="cp-btn-save" href="javascript:void(0);">{l s='ADD TO CART' mod='cdesigner'}</a>
                </div>
                {if $extra_active_2 == 1}
                    <div class="switcher switcher-mobile">
                        <a href="" class="side-1 active" title="{l s='Front' mod='cdesigner'}"><img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image|escape:'htmlall':'UTF-8'}" alt=""/></a>
                        <a href="" class="side-2" title="{l s='Back' mod='cdesigner'}"><img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image_2|escape:'htmlall':'UTF-8'}" alt=""/></a>
                    </div>
                {/if}
                <!-- Bloc Selected Device -->
                <div id="cp-sel-Device">
                    <div id="cp-device-ori" class="cp-device-ori">
                        <div id="side-1" class="currentspace">
                            {if $extra_image != ''}
                                <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image|escape:'htmlall':'UTF-8'}" alt="" class="img-src"/>
                            {/if}
                            <div class="cp-mask-img">
                                <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_mask|escape:'htmlall':'UTF-8'}" alt="" />
                            </div>
                            <div class="cp-gridme" id="cp-gridme"></div>
                            <div class="cp-gridme-cover"></div>
                            {if $extra_design != 1}
                            <style type="text/css">
                                #side-1 .cp-gridme, #side-1 .cp-gridme-cover {
                                    height: {$bottom_1|escape:'htmlall':'UTF-8'}% !important;
                                    left: {$left_1|escape:'htmlall':'UTF-8'}% !important;
                                    width: {$right_1|escape:'htmlall':'UTF-8'}% !important;
                                    top: {$top_1|escape:'htmlall':'UTF-8'}% !important;
                                }
                                {if $right_1 < 100 || $bottom_1 < 100 }
                                    .cp-gridme{
                                      outline: .5px dashed #000;
                                    }
                                {/if}
                            </style>
                            {/if}
                        </div>
                        {if $extra_active_2 == 1}
                            <div id="side-2" style="display:none">
                                {if $extra_image_2 != ''}
                                    <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image_2|escape:'htmlall':'UTF-8'}" alt="" class="img-src"/>
                                {/if}
                                <div class="cp-mask-img">
                                    <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_mask_2|escape:'htmlall':'UTF-8'}" alt="" />
                                </div>
                                <div class="cp-gridme"></div>
                                <div class="cp-gridme-cover"></div>
                                {if $extra_design != 1}
                                <style type="text/css">
                                    #side-2 .cp-gridme, #side-2 .cp-gridme-cover {
                                        height: {$bottom_2|escape:'htmlall':'UTF-8'}% !important;
                                        left: {$left_2|escape:'htmlall':'UTF-8'}% !important;
                                        width: {$right_2|escape:'htmlall':'UTF-8'}% !important;
                                        top: {$top_2|escape:'htmlall':'UTF-8'}% !important;
                                    }
                                </style>
                                {/if}
                            </div>
                        {/if}

                        <div class="clear"></div>
                    </div>
                </div>
                <!-- End Bloc Selected Device -->

                <!--ul class="navigation-btn">
                    <li><a href="javascript:void(0);" class="rotate-left"><i class="fa fa-undo"></i></a></li>
                    <li><a href="javascript:void(0);" class="rotate-right"><i class="fa fa-repeat"></i></a></li>
                    <li><a href="javascript:void(0);" class="delete-img-dash"><i class="fa fa-trash-o"></i></a></li>
                </ul-->
            </div>
            {if $allow_comb == 1}
                <a href="" class="update-opt"><samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/settings.png"></samp><span>{l s='Update Attributes' mod='cdesigner'}</span></a>
                <div class="list-combination-data">
                    <div>
                        <form class="clone-form-comb"></form>
                        <a href="javascript:void(0)" class="done-combi"><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/done.png"></a>
                    </div>
                </div>
            {/if}  
            {if $allow_help == '1' && $url_demo_video != ''}
                <a href="javascript:void(0);" class="cp-btn-help mobile-only-help" title="{l s='How it works ?' mod='cdesigner'}" data-video="{$url_demo_video}">
                    <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/question.png" /></samp>
                </a>
            {/if}
            <div class="cp-btn-action">
                <a href="javascript:void(0)" class="cp-btn-shuffle"><span>{l s='Shuffle' mod='cdesigner'}</span> <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/btn_random.png"></samp></a>
                <a href="javascript:void(0)" class="cp-btn-reset"><span>{l s='Reset' mod='cdesigner'}</span> <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/reset.png"></samp></a>
            </div>
        </div>
        <ul class="navigation-mobile">
            <li id="layout-model">
                <a href="javascript:void(0)" class="step1">
                    <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/step1.png"></samp>
                    <span>{l s='Layouts' mod='cdesigner'}</span>
                </a>
            </li>
            <li id="img-steps">
                <a href="javascript:void(0)" class="step2">
                    <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/step2.png"></samp>
                    <span>{l s='Photos' mod='cdesigner'}</span>
                </a>
            </li>
            <li id="txt-steps">
                <a href="javascript:void(0)" class="step3">
                    <samp><img src="{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/step3.png"></samp>
                    <span>{l s='Text' mod='cdesigner'}</span>
                </a>
            </li>  
        </ul>
        <!-- Bloc Crop Image -->
        <div id="cp-crop-image"><div id="cp-cropit-me"></div></div>
        <i class="fa fa-apple" id="load-me" style="opacity:0;filter:alpha(opacity=0)"></i>
        <!-- End Bloc Crop Image -->
        <span style="display:none">{l s='Design me' mod='cdesigner'}</span>

        {if isset( $rate_tax ) }
            <input type="hidden" name="data_rate" value="{$rate_tax}">
            <input type="hidden" name="pps" value="{($price_per_side + ( $price_per_side * ( $rate_tax  / 100 ) ) ) * 3333}">
            <input type="hidden" name="ppi" value="{($price_per_image+ ( $price_per_image * ( $rate_tax  / 100 ) ) ) * 3333}">
            <input type="hidden" name="ppt" value="{($price_per_text+ ( $price_per_text * ( $rate_tax  / 100 ) ) ) * 3333}">
        {else}
            <input type="hidden" name="data_rate" value="0">
            <input type="hidden" name="pps" value="{$price_per_side * 3333}">
            <input type="hidden" name="ppi" value="{$price_per_image * 3333}">
            <input type="hidden" name="ppt" value="{$price_per_text * 3333}">
        {/if}
        <input type="hidden" id="design_pre" value="{$design_pre}">
        <input type="hidden" id="design_pre_2" value="{$design_pre_2}">
    </div>
    <form method="post" action="{$urls.base_url|escape:'htmlall':'UTF-8'}index.php?fc=module&module=cdesigner&controller=storedata" id="form-submited">
        <input type="hidden" name="link" id="cd-link">
        <input type="hidden" name="id" id="cd-id">
        <input type="hidden" name="output" id="cd-output">
    </form>
</div>
{if isset($smarty.get.design) &&  $smarty.get.design != '' }
    <script>
            jQuery(document).ready(function($) {
                $.ajax({
                    url: '/modules/cdesigner/views/img/files/tpl/tp_{$smarty.get.design}.html',
                    method: "POST",
                    dataType: "html"
                }).done(function(data) {
                    $('body').append('<div id="dived-1" style="display:none;"></div>');
                    $("#dived-1").html(data);
                    $('#cp-device-ori').html( $("#dived-1").text() );
                    $('#side-1').unwrap('<div></div>');
                    //$('#side-2').unwrap('<div></div>');
                    $("#dived-1").remove();
                    $('.ui-resizable').removeClass('ui-resizable');
                    $('div.ui-resizable-handle').remove();
                    $('.img-h').unwrap('<div></div>');
                    $('.squared').each(function(index, el) {
                            $('#side-1').attr('class','currentspace anywere');
                            width_img = $(this).find(".img-h" ).width();
                            height_img = $(this).find(".img-h" ).height();
                            
                            $(this).find(".img-h" ).resizable({
                                  containment: "#cp-sel-Device",
                                  create: function( event, ui ) {
                                    $('#side-1 .cp-gridme').html($('#side-1 .cp-gridme-cover').html());
                                    $('#side-2 .cp-gridme').html($('#side-2 .cp-gridme-cover').html());
                                  },
                                  resize: function(event, ui){
                                    $('#side-1 .cp-gridme').html($('#side-1 .cp-gridme-cover').html());
                                    $('#side-2 .cp-gridme').html($('#side-2 .cp-gridme-cover').html());
                                  },
                                  stop:function(){
                                    $('#side-1 .cp-gridme').html($('#side-1 .cp-gridme-cover').html());
                                    $('#side-2 .cp-gridme').html($('#side-2 .cp-gridme-cover').html());
                                  }
                            });

                            $(this).draggable({
                              containment: "#cp-sel-Device",
                              drag:function(){
                                $('.currentspace .cp-gridme *').remove();
                                $(this).addClass('selected');
                                $('.currentspace .cp-gridme-cover').addClass('someone-selected');
                              },
                              stop:function(){
                                $('#side-1 .cp-gridme').html($('#side-1 .cp-gridme-cover').html());
                                    $('#side-2 .cp-gridme').html($('#side-2 .cp-gridme-cover').html());
                              },
                              scroll: false
                            });

                            params = {
                                start: function(event, ui) {
                                    $('#side-1 .cp-gridme').html($('#side-1 .cp-gridme-cover').html());
                                    $('#side-2 .cp-gridme').html($('#side-2 .cp-gridme-cover').html());
                                },
                                rotate: function(event, ui) {
                                    //self.copyHtmlGrid();
                                    $('.currentspace  .cp-gridme *').remove();
                                },
                                stop: function(event, ui) {
                                    $('#side-1 .cp-gridme').html($('#side-1 .cp-gridme-cover').html());
                                    $('#side-2 .cp-gridme').html($('#side-2 .cp-gridme-cover').html());
                                },
                            };
                            $(this).rotatable(params);
                        });

                    $('.cp-input-gen').each(function(index, el) {
                        $(this).draggable({
                          drag:function(){},
                          stop:function(){},
                          scroll: false
                        });
                        $(this).rotatable();
                    });
                    $('#wrap-phone-pop').fadeIn('pretty');
                });
            });
        </script>
{/if}
{if ( count($type_layout) == 1 && !'all'|in_array:$type_layout ) ||  $extra_design == 1}
    <script>
        $('#cp-st-1').remove();
        $('#layout-model').remove();
        $('#cp-st-2').addClass('cp-current-step').addClass('cp-active');
        $('#step2').show();
    </script>
{/if}
{if count($type_layout) == 1 && $type_layout[0] == 'free' && $extra_design != 1}
    <script>
        $('#side-1,#side-2').addClass('anywere');
    </script>
{/if}

{if ( count($type_layout) == 1 && !'all'|in_array:$type_layout ) && $type_layout[0] != 'free'}
    <script>
        $.ajax({
            url: '{$urls_site|escape:"htmlall":"UTF-8"}modules/cdesigner/views/img/config/layout/{$type_layout[0]}/grid.html',
            context: document.body
        }).done(function(data) {
            $('.cp-gridme, .cp-gridme-cover').html(data);
            setTimeout(function(){
                $('.cp-btn-action').fadeIn('slow');
                $('#cp-st-1').removeClass('cp-current-step');
                $('#cp-st-2').addClass('cp-active cp-current-step');
                $('#step1').hide();
                $('#step2').fadeIn('pretty');
                $('#cp-sel-Text').show();
                //self.dragImg();
                $('.cp-loader').fadeOut('fast', function() {
                    $('.cp-loader').remove();
                });
                $('.navigation-mobile li').removeClass('active');
                $('.navigation-mobile li a.step2').parent().addClass('active');
            },1000);
        });
    </script>
{/if}

<style type="text/css">
    .product-customization,
    .product-add-to-cart .add-to-cart{
        display: none !important;
    }
</style>
<script>
    function adjustFont($nativeW, $value){
        var $width_zone_native = $nativeW;
        var $font_size = $value;
        var $width_zone = $('.currentspace').width();
        return ($width_zone * $font_size) / $width_zone_native;
    }

    function writeImage($l,$t,$w,$h,$r,$i,$side,$tags) {
        var $side = ( $side == 'side-2' ) ? '#side-2' : '#side-1';
        $tags = ( !isNaN($tags) ) ? $tags : 0;
        $($side + ' .cp-gridme-cover .w-sqr').append('<div class="sqr" data-tags="'+$tags+'" style="display:inline-block;left:'+$l+'%;top:'+$t+'%;width:'+$w+'%;height:'+$h+'%;transform: rotate('+$r+'deg);-webkit-transform: rotate('+$r+'deg);-o-transform: rotate('+$r+'deg);"></div>');
    }

    function writeText($l,$t,$w,$h,$r,$size,$color,$font,$align,$text,$id_font,$i,$valign, $acolor, $afont, $alimit, $side, $abreak, $afontsize,$afontalignement){
        var $font = $font.replace(/"/g, '');
        var $side = ( $side == 'side-2' ) ? '#side-2' : '#side-1';
        $($side).append('<div class="cp-input-gen" style="display:inline-block;left:'+$l+'%;top:'+$t+'%;width:'+$w+'%;height:'+$h+'%;transform: rotate('+$r+'deg);-webkit-transform: rotate('+$r+'deg);-o-transform: rotate('+$r+'deg);" data-default="'+$text+'">\
            <div class="wr-pre"><pre id_font="'+$id_font+'" data-valign="'+$valign+'" data-acolor="'+$acolor+'"  data-color="'+$color+'"  data-limit="'+$alimit+'" data-afont="'+$afont+'" style="text-align:'+$align+';font-family:'+$font+';color:'+$color+';font-size:'+$size+'px;line-height:'+$size+'px" native-size="'+$size+'" data-abreak="'+$abreak+'" data-afontalignement="'+$afontalignement+'" data-afontsize="'+$afontsize+'">'+$text+'</pre></div>\
            </div>');
    }

    function getPercent($nativeW , $value) {
        return  ($value / $nativeW) * 100;
    }

    $(document).ready(function($) {
        $('.product-customization').hide();

        if( $(window).width() > 1023 ) {
            $('#wrap-phone,#center-side, #lft-side').height( $(window).height() - 75 );
            $('#wrap-phone').height( $(window).height() );
            $('.cp-mask-img>img, .img-src').css( 'max-height', ( $('#wrap-phone').height() - 200 ) + 'px' );
        } 

        if( $(window).width() > 1140 ) {
            $('#center-side').width( $(window).width() - 540 );
        } else if( $(window).width() > 979 ) {
            $('#center-side').width( $(window).width() - 440 );
        }

        $(window).resize(function(){
            if( $(window).width() > 1023 ) {
                $('#wrap-phone,#center-side, #lft-side').height( $(window).height() - 75 );
                $('#wrap-phone').height( $(window).height() );
                $('.cp-mask-img>img, .img-src').css( 'max-height', ( $('#wrap-phone').height() - 200 ) + 'px' );
            } 

            if( $(window).width() > 1140 ) {
                $('#center-side').width( $(window).width() - 540 );
            } else if( $(window).width() > 979 ) {
                $('#center-side').width( $(window).width() - 440 );
            }
        }); 

        var $design = $('#design_pre').val();
        var $design_2 = $('#design_pre_2').val();
        if( $('#wrap-phone').hasClass('pre-design') ) {
            $('body').addClass('pre-design');
            var $design_pre = $design.split('|');
            var $nativeW = $design_pre[0];
            var $nativeH = $design_pre[3];
            var $imgs = $design_pre[1].split(';');
            var $texts = $design_pre[2].split(';');

            var $design_pre_2 = $design_2.split('|');
            var $nativeW_2 = $design_pre_2[0];
            var $nativeH_2 = $design_pre_2[3];
            var $imgs_2 = $design_pre_2[1].split(';');
            var $texts_2 = $design_pre_2[2].split(';');

            var $i=0;
            if( $imgs[0] != '') {
                $('#side-1 .cp-gridme-cover').html('<div class="container-fluid w-sqr"></div>');
            }
            $imgs.forEach(function(element){
                var elements = element.split(':::');
                var $w = getPercent( $nativeW ,elements[0] );
                var $h = getPercent( $nativeH ,elements[1] );
                var $l = getPercent( $nativeW ,elements[2] );
                var $t = getPercent( $nativeH ,elements[3] );
                var $r = elements[4];
                var $tags = elements[5];
                if( $w > 0) writeImage($l,$t,$w,$h,$r,$i,'',$tags);
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

            //var $i=0;
            if( $imgs_2[0] != '') {
                $('#side-2 .cp-gridme-cover').html('<div class="container-fluid w-sqr"></div>');
            }
            $imgs_2.forEach(function(element){
                var elements = element.split(':::');
                var $w = getPercent( $nativeW_2 ,elements[0] );
                var $h = getPercent( $nativeH_2 ,elements[1] );
                var $l = getPercent( $nativeW_2 ,elements[2] );
                var $t = getPercent( $nativeH_2 ,elements[3] );
                var $r = elements[4];
                var $tags = elements[5];
                if( $w > 0) writeImage($l,$t,$w,$h,$r,$i,'side-2',$tags);
                $i++;
            });

            $texts_2.forEach(function(element){
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

            $('#side-1 .cp-gridme').html($('#side-1 .cp-gridme-cover').html());
            $('#side-2 .cp-gridme').html($('#side-2 .cp-gridme-cover').html());

            //$('#lft-side').addClass('no-img-filter');

            $('#cp-link-step>li, #cp-ct-step>div').hide();

            if( $('.cp-input-gen')[0] ) {
                $('#cp-st-3').show();
                if( !$('.cp-gridme-cover .sqr')[0] ) {
                    $('#step3').show();
                    $('#cp-st-3').addClass('cp-current-step cp-active');
                }  

            }
            if( $(window).width() > 979 ) {
                $('.cp-input-gen').eq(0).trigger('click');
                if( $('.cp-gridme-cover .sqr')[0] ) {
                    $('#cp-st-2').addClass('cp-current-step cp-active').show();
                    $('#step2').show();
                }
                $('.cp-gridme-cover .sqr').eq(0).trigger('click');
            }
        }

        if( $('.add .add-to-cart').prop('disabled') )
           $('.cp-get-canvas').attr('disabled',true);


        var body = document.querySelector('#add-to-cart-or-refresh');
        var observer = new MutationObserver(function(mutations) {
           mutations.forEach(function(mutation) {
               if( $('.add .add-to-cart').prop('disabled') )
                 $('.cp-get-canvas').attr('disabled',true);
               else
                 $('.cp-get-canvas').attr('disabled',false);

                if( !$('.cp-get-canvas')[0] )
                    $("<button class='cp-get-canvas btn btn-primary'>{l s='Design me' mod='cdesigner'}</button>").insertAfter('.product-add-to-cart .add-to-cart');

                if( allow_comb == '1') {
                    var $combinations_product = $('#add-to-cart-or-refresh .product-variants').html();
                    if( $.trim( $combinations_product ) != '' ) {
                        $('.list-combination-data>div>form.clone-form-comb').html( $combinations_product );
                    }
                    else 
                        $('.update-opt').hide();
                }
           });
        }); 
        observer.observe( body, { childList: true , attributes: true }); 
    });
    
    $(document).on('click','#btn-instagram',function(){
        window.open("https://api.instagram.com/oauth/authorize?client_id={$client_id|escape:'htmlall':'UTF-8'};redirect_uri={$redirect_URI|escape:'htmlall':'UTF-8'};scope=basic;response_type=code", "myWindow","menubar=no, status=no, scrollbars=no, menubar=no, width=400, height=300");
         return false;
    });

    $("<button class='cp-get-canvas btn btn-primary'>{l s='Design me' mod='cdesigner'}</button>").insertAfter('.product-add-to-cart .add-to-cart');
    $('body').append('<div id="wrap-phone-pop">'+$('#wrap-phone-dup').html()+'</div>');
    $('#wrap-phone-dup').remove();
    $('.overlay,.btn-close-pl').bind('click',function(){
         $('.overlay,#wrap-phone-pop').fadeOut('pretty', function() {
            $('.overlay').remove();
         });
         $('body').removeClass('ovhidden');
         $('.list-combination-data').hide();
         return false;
    });
    window.fbAsyncInit = function() {
        FB.init({
          appId      : "{$app_id|escape:'htmlall':'UTF-8'}", 
          cookie     : true,
          xfbml      : true,
          version    : 'v3.2'
        });
    };

    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            $('#btn-facebook').remove();
            var uid = response.authResponse.userID;
            var accessToken = response.authResponse.accessToken;
            $.ajax({
                url: "https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id={$app_id|escape:'htmlall':'UTF-8'}&client_secret={$secret_id|escape:'htmlall':'UTF-8'}&fb_exchange_token=" + accessToken,
                    method: "GET"
            }).done( function(data) {

                var $accesslong = data.access_token;
                FB.api("/me/albums", function(wrap) {
                    $.each(wrap.data, function(index, value) {
                        getPhotosForAlbumId(value.id, $accesslong);
                   });
                });
            });
            
        } else if (response.status === 'not_authorized') {
           alert("{l s='You are not allowed to connect, please contact the administrator' mod='cdesigner'}");
        } else {
           alert("{l s='Please connect to the facebook' mod='cdesigner'}");
        }
    }
</script>   

{literal}
    <script>
        function getPhotosAlbum(value){
            FB.api("/"+value, function(response_1) {
                FB.api("/"+value+"/picture", function(pic) {
                    $('#from-facebook .cp-loader').remove();
                    $('#from-facebook .category-a').append('<a id="'+value+'" class="album-category" href="javascript:void(0)" style="background:url('+pic.data.url+')"><i class="fa fa-picture-o"></i><span class="name-of-album-f">'+response_1.name+'</span></a>');
                    $('#from-facebook .category-a').show();
                }); 
            });
            
        }

        function getPhotosForAlbumId( value, token ) {
            FB.api("/"+value+"/photos", function(response) {
              var photos = response.data;
              $.each(photos, function(index, photo) {
                  $('.lst-img ul').prepend('<li class="from-facebook"><a href="https://graph.facebook.com/'+photo.id+'/picture?type=normal&access_token='+token+'" style="background:url(https://graph.facebook.com/'+photo.id+'/picture?type=normal&access_token='+token+')" class="'+value+' photo-alb freely-link"><i class="fa fa-plus"></i></a></li>');
              });
              jQuery('.lst-tags a').removeClass('active');
              jQuery('#from-facebook').show();
              jQuery('#from-facebook').addClass('active');
              jQuery('.lst-img li').hide();
              jQuery('.lst-tags a.active').closest('.lst-img').find('li.'+ jQuery('.lst-tags a.active').attr('id')).fadeIn('pretty');
          });
        }

        function checkLoginState() {
            FB.login(function(response) {
              statusChangeCallback(response);
            }, {scope: 'public_profile,email,user_photos'});
        }
        
        (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        </script>
{/literal}

{if $logged}
    <script type="text/javascript">
        $('body').addClass('user-logged-succed');
    </script>
{/if}

{if $type_perso == 2 && $extra_design == 0}
    <script type="text/javascript">
        $('#cp-st-3').addClass('cp-active cp-current-step-force')
    </script>
{/if}

<style type="text/css">
    {if $main_color != ''}
        #lft-side .cp-btn-more-pic:hover,
        .cp-btn-more-pic:hover,
        #cp-content .cp-list-color .bleu,
        .alertify-button-ok:hover,
        #cdesigner .cp-info-dev .cp-title:after,
        .cp-h-v a,
        .cp-list-font a:hover,
        #cp-add-cart a:hover,
        .cp-list-color a span,
         #cp-add-cart-mobile .cp-btn-save,
         .add-txt:hover, .new-txt:hover,
        .eg-button a{
          background-color: {$main_color} !important;
        }

        .ui-rotatable-handle,
        .ui-resizable-se,
        .btn-delete-img-cr,.order-by-slice,
        .add-txt:hover, .new-txt:hover,
        .btn-close-mobile,
        .delete-txt,
        #first-title,
        .spin-c,
        .navigation-btn li a{
            background-color: {$main_color};
        }

        .pre-design .current-txt,
        .cp-gridme-cover .cp-cibled-row,
        .pre-design .cp-cibled-row{
          outline-color: {$main_color} !important;
        }

        .lds-ring div{
            border-color: {$main_color} transparent transparent transparent;
        }

        #cp-sel-Photos li:hover,
        .cp-btn-help:hover samp,
        .lst-tags a:hover, .lst-tags a.active,
        #loader-start,
        .alertify-button-ok:hover,
        .switcher a.active,
        .switcher a:hover,
        .lst-tags a:hover,
        .lst-tags a.active,
        #cp-size-txt li a:hover,#cp-align-txt li a:hover, .cp-list-color > a:hover,
        .cp-model li a.active,
        .cp-device li a:hover,
        .cp-device li a:hover, #cp-sel-layout li a:hover,.cp-device li a.active, #cp-sel-layout li a.active,
        .alertify,
        #cp-link-step li a:hover samp,
        #cp-link-step .cp-current-step a samp,
        #cp-link-step .cp-current-step a,
        #cp-link-step .cp-current-step-force a samp,
        #cp-link-step .cp-current-step-force a,
        .navigation-mobile  .cp-current-step-force a samp,
        .navigation-mobile  .cp-current-step-force a,
        .list-combination-data .input-color:checked + span, 
        .list-combination-data .input-color:hover + span, 
        .list-combination-data .input-radio:checked + span, 
        .list-combination-data .input-radio:hover + span,
        .navigation-mobile  .active a samp,
        .done-combi:hover,
        .navigation-mobile  .active a{
            border-color: {$main_color} !important;
        }
        .bleu,
        .extra,
        .spin-load,
        .cp-brand,
        .txt-load,
        .cp-brand samp,
        .cp-btn-action a:hover, .cp-btn-action a:hover i {
          color: {$main_color} !important;
        }
        .alertify-button:focus {
          squared-shadow: 0 0 15px {$main_color};
        }
    {/if}
</style>
<!-- End Main Bloc -->