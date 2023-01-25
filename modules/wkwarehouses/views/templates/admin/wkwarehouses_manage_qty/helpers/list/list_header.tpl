{*
* This file is part of the 'Wk Warehouses Management For Prestashop 1.7' module feature.
* Developped by Khoufi Wissem (2018).
* You are not allowed to use it on several site
* You are not allowed to sell or redistribute this module
* This header must not be removed
*
*  @author    KHOUFI Wissem - K.W
*  @copyright Khoufi Wissem
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}
{extends file="helpers/list/list_header.tpl"}

{block name=override_header}
{$warning_messages_html}{* HTML CONTENT *}

{if $show_quantities == false}
    <div class="alert alert-warning">
        <p>{l s='It is not possible to manage quantities when:' mod='wkwarehouses'}</p>
        <ul>
            <li>{l s='You are currently managing all of your shops' mod='wkwarehouses'}.</li>
            <li>{l s='You are currently managing a group of shops where quantities are not shared between every shop in this group' mod='wkwarehouses'}.</li>
            <li>{l s='You are currently managing a shop that is in a group where quantities are shared between every shop in this group' mod='wkwarehouses'}.</li>
        </ul>
    </div>
{/if}

{include file="./help.tpl"}
{include file="./bulk.tpl"}

<div class="panel" id="filters-header" style="padding-bottom:0px">
	{* F I L T E R S *}
	<script type="text/javascript">
		var msg_required = '{l s='Please select at least one product/combination!' js=1 mod='wkwarehouses'}';
    </script>
	<div class="col-lg-12">
	<form method="post" action="{$action|escape:'htmlall':'UTF-8'}" class="form-horizontal clearfix">
		<div class="panel-heading">
        	<i class="icon-search"></i> {l s='Filter by' mod='wkwarehouses'} <input type="checkbox" id="filter-by-providers" name="filter-by-providers" style="vertical-align: text-top"/>
        </div>
		<div class="row" id="block_supplier_tree">
            <div class="col-lg-6">
				{* S U P P L I E R S *}
                <div class="col-lg-6">
                    <select name="product{$filter_supplier|escape:'htmlall':'UTF-8'}[]" multiple="multiple" size="4" id="product{$filter_supplier|escape:'htmlall':'UTF-8'}">
                        <option value="" class="empty-option">--- {l s='Supplier(s)' mod='wkwarehouses'} ---</option>
                    {if $providers|@count && !empty($providers)}
                        {foreach from=$providers item=supplier}
                        <option value="{$supplier['id_supplier']|intval}" {if $supplier['is_selected']}selected{/if}>{$supplier['name']|escape:'html':'UTF-8'}</option>
                        {/foreach}
                    {/if}
                    </select>
                </div>
				{* W A R E H O U S E S *}
                <div class="col-lg-6">
                    <select name="product{$filter_warehouse|escape:'htmlall':'UTF-8'}[]" multiple="multiple" size="4" id="product{$filter_warehouse|escape:'htmlall':'UTF-8'}">
                        <option value="" class="empty-option">--- {l s='Warehouse(s)' mod='wkwarehouses'} ---</option>
                    {if $warehouses|@count && !empty($warehouses)}
                        {foreach from=$warehouses item=warehouse}
                        <option value="{$warehouse['id_warehouse']|intval}" {if $warehouse['is_selected']}selected{/if}>{$warehouse['name']|escape:'html':'UTF-8'}</option>
                        {/foreach}
                    {/if}
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-12" style="margin-top:3px;">
                    <div class="form-group">
                        <label class="control-label col-lg-3">{l s='Look for products' mod='wkwarehouses'}</label>
                        <div class="col-lg-9">
                            <select name="product{$filter_outofstock|escape:'html':'UTF-8'}" size="1" id="product{$filter_outofstock|escape:'htmlall':'UTF-8'}">
                                <option value="" {if !$is_outstock_filter || !isset($is_outstock_filter)}selected{/if}>--- {l s='All' mod='wkwarehouses'} ---</option>
                                <option value="1" {if $is_outstock_filter == 1}selected{/if}>{l s='which warehouses quantities sum don\'t match the physical quantity' mod='wkwarehouses'}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
			{* BUTTONS ACTIONS IF FILTERS ARE USED *}
            <div class="col-lg-4">
                <span class="pull-left">
                    {if $is_supplier_filter || $is_warehouse_filter || $is_outstock_filter}
                    <button type="submit" name="submitReset{$list_id|escape:'html':'UTF-8'}" class="btn btn-warning">
                        <i class="icon-eraser"></i> {l s='Reset' mod='wkwarehouses'}
                    </button>
                    {/if}
                    {* Search must be before reset for default form submit *}
                    <button type="submit" name="submitFilter" class="btn btn-default" data-list-id="{$list_id|escape:'html':'UTF-8'}">
                        <i class="icon-search"></i> {l s='Search' mod='wkwarehouses'}
                    </button>
                </span>
            </div>
		</div>
	</form>
	</div>
	<div class="clearfix"></div>
</div>
<audio id="alarmAudio" src="{$this_path|escape:'html':'UTF-8'}/views/media/sound.mp3" preload="none">{l s='Browser not support the audio' mod='wkwarehouses'}</audio>
<div class="clearfix"></div>
{/block}
