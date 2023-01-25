{*
* 2007-2021 ETS-Soft
*
* NOTICE OF LICENSE
*
* This file is not open source! Each license that you purchased is only available for 1 wesite only.
* If you want to use this file on more websites (or projects), you need to purchase additional licenses.
* You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please, contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2021 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{extends file="helpers/form/form.tpl"}
{block name="input"}
{if $input.type == 'file_lang'}
    {if $languages|count > 1}
      <div class="form-group">
    {/if}
    	{foreach from=$languages item=language}
    		{if $languages|count > 1}
    			<div class="translatable-field lang-{$language.id_lang|intval}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
                <div class="col-lg-9">
    		{/if}
    			
                    <div class="ets_col_upload_img {$input.name|escape:'html':'UTF-8'}" data-id-lang="{$language.id_lang|intval}">
                        {if isset($fields_value[$input.name]) && $fields_value[$input.name] && $fields_value[$input.name][$language.id_lang]}
                            <div class="col-lg-12 uploaded_img_wrapper">
                        		<a class="col_image open-image" href="{$image_baseurl|escape:'html':'UTF-8'}{$fields_value[$input.name][$language.id_lang]|escape:'html':'UTF-8'}">
                                <img class="ets_col_collection_image" title="{l s='Click to see full size image' mod='ets_collections'}" style="display: inline-block; max-width: 200px;" src="{$image_baseurl|escape:'html':'UTF-8'}{$fields_value[$input.name][$language.id_lang]|escape:'html':'UTF-8'}" /></a>
                                <a class="btn btn-default del_image delete_collection_image" href="{if $input.name=='image'}{$image_del_link|escape:'html':'UTF-8'}{else}{$thumb_del_link|escape:'html':'UTF-8'}{/if}&id_lang={$language.id_lang|intval}" title="{l s='Delete' mod='ets_collections'}">
                                    <i class="icon-trash"></i>
                                </a>
                            </div>
        				{/if}
                        <span class="ets_col_upload_icon">
                            <svg viewBox="0 0 2048 1792" xmlns="http://www.w3.org/2000/svg"><path d="M704 576q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm1024 384v448h-1408v-192l320-320 160 160 512-512zm96-704h-1600q-13 0-22.5 9.5t-9.5 22.5v1216q0 13 9.5 22.5t22.5 9.5h1600q13 0 22.5-9.5t9.5-22.5v-1216q0-13-9.5-22.5t-22.5-9.5zm160 32v1216q0 66-47 113t-113 47h-1600q-66 0-113-47t-47-113v-1216q0-66 47-113t113-47h1600q66 0 113 47t47 113z"/></svg>
                        </span>
                        <input id="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}" type="file" name="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}" class="hide {$input.name|escape:'html':'UTF-8'}" />
        				<div class="dummyfile input-group">
        					<input id="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}-name" type="text" name="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}" readonly="true" class="{$input.name|escape:'html':'UTF-8'}" />
        				</div>
                        <div class="ets_col_upload_note">
                            <span class="ets_col_upload_img_note">{l s='Select file' mod='ets_collections'}</span>
                            <span class="ets_col_upload_img_size">{if isset($input.desc_file) && $input.desc_file}{$input.desc_file|escape:'html':'UTF-8'}{else}{l s='Accepted formats: jpg, png, gif, webp. Limit' mod='ets_collections'} {Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')|escape:'html':'UTF-8'}Mb{/if}</span>
        			    </div>
                    </div>
                
    		{if $languages|count > 1}
            </div>
    			<div class="col-lg-2">
    				<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
    					{$language.iso_code|escape:'html':'UTF-8'}
    					<span class="caret"></span>
    				</button>
    				<ul class="dropdown-menu">
    					{foreach from=$languages item=lang}
    					   <li><a href="javascript:hideOtherLanguage({$lang.id_lang|intval});" tabindex="-1">{$lang.name|escape:'html':'UTF-8'}</a></li>
    					{/foreach}
    				</ul>
    			</div>
    		{/if}
    		{if $languages|count > 1}
    			</div>
    		{/if}
    		<script>
    		$(document).ready(function(){
    			$("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}-selectbutton").click(function(e){
    				$("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}").trigger('click');
    			});
                $("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}-name").click(function(e){
    				$("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}").trigger('click');
    			});
    			$("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}").change(function(e){
    				var val = $(this).val();
    				var file = val.split(/[\\/]/);
    				$("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}-name").val(file[file.length-1]);
    			});
    		});
    	</script>
    	{/foreach}
    {if $languages|count > 1}
      </div>
    {/if}
{elseif $input.type == 'switch'}
    {if $table=='ets_col_collection'}
	<span class="switch prestashop-switch fixed-width-lg">
		{foreach $input.values as $value}
		<input type="radio" name="{$input.name|escape:'html':'UTF-8'}"{if $value.value == 1} id="{$input.name|escape:'html':'UTF-8'}_on"{else} id="{$input.name|escape:'html':'UTF-8'}_off"{/if} value="{$value.value|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if}{if (isset($input.disabled) && $input.disabled) or (isset($value.disabled) && $value.disabled)} disabled="disabled"{/if}/>
		{/foreach}
        {foreach $input.values as $value}
    		{strip}
    		<label {if $value.value == 1} for="{$input.name|escape:'html':'UTF-8'}_on"{else} for="{$input.name|escape:'html':'UTF-8'}_off"{/if}>
    				{$value.label|escape:'html':'UTF-8'}
    		</label>
    		{/strip}
		{/foreach}
		<a class="slide-button btn"></a>
	</span>
    {else}  
        {$smarty.block.parent}
    {/if}
{else}
    {$smarty.block.parent}
{/if}
{/block}
{block name="input_row"}
    {if $input.name=='description'}
        <div class="preview_collection_block">            
            <div class="preview_collection_title">{l s='Preview' mod='ets_collections'}</div>
            <div class="preview_collection_block_content">
                <span class="preview_collection_arrow"></span>
                <div class="preview_collection_tab">
                    <div class="title">{l s='Collection page' mod='ets_collections'}</div>
                    <div class="preview_collection_tab_right">
                        <div class="colleciton_tab desktop active" data-tab="desktop">{l s='Desktop' mod='ets_collections'}</div>
                        <div class="colleciton_tab mobile" data-tab="mobile">{l s='Mobile' mod='ets_collections'}</div>
                    </div>
                </div>
                <div class="preview_collection_content">
                    <div class="colleciton_content desktop active" data-tab="desktop">
                        <img src="{$img_preview_desktop|escape:'html':'UTF-8'}" />
                    </div>
                    <div class="colleciton_content mobile" data-tab="mobile">
                        <img src="{$img_preview_mobile|escape:'html':'UTF-8'}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    {/if}
    {if $input.name=='name'}
        <div class="row">{*begin*}
        <div class="ets_col_tabs">{*start tab*}
            <ul>
                <li data-tab="general" class="tab general active{if isset($fields_value['id_collection']) && $fields_value['id_collection']} change_tab{/if}"><span>1</span> {l s='General information' mod='ets_collections'}</li>
                <li data-tab="product" class="tab product{if isset($fields_value['id_collection']) && $fields_value['id_collection']} change_tab{/if}"><span>2</span> {l s='List of products' mod='ets_collections'}</li>
                <li data-tab="display" class="tab display{if isset($fields_value['id_collection']) && $fields_value['id_collection']} change_tab{/if}"><span>3</span> {l s='Display' mod='ets_collections'}</li>
            </ul>
        </div> {*end tab*}
        <div class="ets_col_tab_content">{*start content*}
            <div class="tab_content general active"> {*start general*}
                <div class="panel-heading">
                    {l s='General information' mod='ets_collections'}
                </div>
    {/if}
                {$smarty.block.parent}
    {if $input.name=='active'}
            <div class="ets_collection_content_footer">
                    <button class="btn btn-default pull-right btn-continue" type="button" name="saveCollectionInformation"><i class="process-icon-next"></i> {l s='Continue' mod='ets_collections'}</button>
            </div>
            </div>{*end general*}
            <div class="tab_content product">{*start product-list*}
                {$fields_value.list_products nofilter}
                <div class="ets_collection_content_footer">
                    <button class="btn btn-default pull-left btn-back" type="button"><i class="process-icon-back"></i> {l s='Back' mod='ets_collections'}</button>
                    <button class="btn btn-default pull-right btn-save" type="button" name="saveCollectionProduct"><i class="process-icon-next"></i> {l s='Continue' mod='ets_collections'}</button>
                </div>
            </div>{*end product-list*}
            <div class="tab_content display"> {*start display*}
                <div class="panel-heading">
                    {l s='Display' mod='ets_collections'}
                </div>
                {$fields_value['hook_display'] nofilter}
    {/if}
    {if $input.name=='active'}
            <div class="ets_collection_content_footer">
                <button class="btn btn-default pull-left btn-back2" type="button"><i class="process-icon-back"></i> {l s='Back' mod='ets_collections'}</button>
                <button class="btn btn-default pull-right" type="button" name="saveEditCollection"><i class="process-icon-save"></i> {l s='Save' mod='ets_collections'}</button>
            </div>
            </div>{*end display*}
        </div>{*end content*}
    </div>{*end*}
    {/if}
    {if $input.name=='ETS_COL_CACHE_LIFETIME'}
        <div class="form-group">
            <label class="control-label {if isset($ps1780) && $ps1780}col-lg-4{else}col-lg-3{/if}">
            </label>
            <div class="col-lg-2">
                <button type="submit" name="btnclearCache" class="ets_col_clear_cache btn btn-default">
                    <i class="icon icon-eraser"></i>
                    <span class="a_text">{l s='Clear cache' mod='ets_collections'}</span>
                </button>
            </div>
        </div>
     {/if}
{/block}
{block name="footer"}
    {if $table=='ets_col_collection'}
        &nbsp;
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
{block name="legend"}
    {if $table=='ets_col_collection'}
    	<div class="panel-heading">
    		{if isset($field.image) && isset($field.title)}<img src="{$field.image|escape:'html':'UTF-8'}" alt="{$field.title|escape:'html':'UTF-8'}" />{/if}
    		{if isset($field.icon)}<i class="{$field.icon|escape:'html':'UTF-8'}"></i>{/if}
    		{$field.title|escape:'html':'UTF-8'}
            <a class="black_to_list" href="{$link->getAdminLink('AdminProductCollections')|escape:'html':'UTF-8'}"><i class="icon-long-arrow-left"></i> {l s='Back to list' mod='ets_collections'}</a>
    	</div>
     {else}
        
        <div class="panel-heading">
    		{if isset($field.image) && isset($field.title)}<img src="{$field.image|escape:'html':'UTF-8'}" alt="{$field.title|escape:'html':'UTF-8'}" />{/if}
    		{if isset($field.icon)}<i class="{$field.icon|escape:'html':'UTF-8'}"></i>{/if}
    		{$field.title|escape:'html':'UTF-8'}
            <span class="panel-heading-action">          
                <a class="list-toolbar-btn" href="{$link->getAdminLink('AdminProductCollections')|escape:'html':'UTF-8'}">
                    <span data-placement="top" data-html="true" data-original-title="{l s='Back to list' mod='ets_collections'}" class="label-tooltip" data-toggle="tooltip" title="">
        				<i class="icon-long-arrow-left"></i>
                    </span>
                </a>                         
                <a class="list-toolbar-btn add_new_link" href="{$link->getAdminLink('AdminProductCollections')|escape:'html':'UTF-8'}&addCollecion=1">
                    <span data-placement="top" data-html="true" data-original-title="{l s='Add new' mod='ets_collections'}" class="label-tooltip" data-toggle="tooltip" title="">
        				<i class="process-icon-new"></i>
                    </span>
                </a>            
            </span>
    	</div>
    {/if}
{/block}