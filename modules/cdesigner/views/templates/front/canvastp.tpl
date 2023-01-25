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
{extends file='page.tpl'}
{block name="page_content"}
<script type="text/javascript">
	var ok_string = "{l s='OK' mod='cdesigner'}";
	var ok_str = "{l s='OK' mod='cdesigner'}";
	var cancel_str = "{l s='Cancel' mod='cdesigner'}";
</script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}themes/core.js"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/html2canvas.min.js"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/cp-lib-min.js"></script>
<script type="text/javascript" src="{$urls.base_url|escape:'htmlall':'UTF-8'}modules/cdesigner/views/js/tools.js"></script>
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
</style>

<style type="text/css">  
    #cp-device-ori{
        position: absolute !important;
        margin: 0 !important;
    }
    .cp-gridme .sqr{
        background: none;
    }
  	#cp-device-ori > div{
  		width: 100%;
  	}
	.cp-gridme .sqr, .cp-gridme-cover .sqr,
	#cp-device-ori:hover .cp-input-gen pre,
	.img-h {
	    outline: 0 solid rgba(102, 198, 198, 0.24) !important;
	}
	#cp-device-ori, #cp-device-ori-gen{
		max-width: none !important;
	}
	#canvasoutput>div:first-child,
	.sqr .wrap-img-drag .cp-h-v,
	.delete-txt,
	.cp-input-gen .ui-rotatable-handle,
	.ui-resizable-handle,
	.btn-delete-img-cr,
	.ui-rotatable-handle,
	#site-wrapper,
	#page
	{
		display: none !important;
	}
	#canvasoutput .squared{
		position: absolute;
	}
	{if $mask == 'no'}
		#canvasoutput .img-src, #canvasoutput .cp-mask-img{
			visibility: hidden;
		}
	{/if}
	#cp-device-ori,.cp-gridme, .cp-gridme-cover{
		overflow: hidden !important;
	}
    
	#cp-device-ori, #cp-device-ori-prev{
		background: none !important;
	}
	#cp-device-ori:hover .cp-input-gen pre {
	    border: 0px solid  white !important;
	}
    .btn-nav-gen{
        text-align: center;
        padding: 30px 0 80px;
    }
    .btn-nav-gen a{
        display: inline-block;
        margin: 0 10px;
    }
    .img-src{
        visibility: hidden;
        opacity: 0;
    }
    .cp-gridme .sqr{
        background-image: none;
    }
</style>
<span id="out" style="display:none;">{$output|escape:'htmlall':'UTF-8'}</span>
<span id="sz" style="display:none;">{$size|escape:'htmlall':'UTF-8'}</span>
<span id="sd_2" style="display:none;">{$side_2|escape:'htmlall':'UTF-8'}</span>

<div id="canvas-center-wrapper">
	<div id="canvas-center">
		<p style="text-align: center; font-weight: bold; color:#000;margin:30px;">
			{l s='For do not saturate your server with a heavy file, we used a temporary image.' mod='cdesigner'}<br />
			<!--span style="color: #e74c3c">{l s='You may have to right click to the image and select "Save as..." to view downloadable format.' mod='cdesigner'}</span-->
		</p>
		<div id="canvas-output-c" style="text-align: center;"></div>
		<p class="btn-nav-gen">
			<a href="javascript:void(0);" target="_blank" class="btn btn-default blog gen-png"><i class="icon-search"></i> {l s='Download as PNG' mod='cdesigner'}</a>
            <!--a href="javascript:void(0);" target="_blank" class="btn btn-default blog gen-svg"><i class="icon-search"></i> {l s='Download as SVG' mod='cdesigner'}</a-->
            <a href="javascript:void(0);" target="_blank" class="btn btn-default blog gen-pdf"><i class="icon-search"></i> {l s='Download as PDF' mod='cdesigner'}</a>
		</p>
		<form name="submit-formed" action="{$urls_site|escape:'htmlall':'UTF-8'}index.php?fc=module&module=cdesigner&controller=imagedpi" method="post" id="submit-formed" target="_blank">
			<input type="hidden" name="output" id="hidden-canvas" value=""/>
            <input type="hidden" name="output1" id="hidden-canvas2" value=""/>
            <input type="hidden" name="output2" id="hidden-canvas3" value=""/>
            <input type="hidden" name="output3" id="hidden-canvas4" value=""/>
            <input type="hidden" name="type" id="type_b" value=""/>
		</form>
	</div>
</div>
<!-- End Main Bloc -->
{/block}