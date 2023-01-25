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
<script type="text/javascript">
	var txt_warehouse_required = '{l s='The warehouse selection is required!' js=1 mod='wkwarehouses'}';
</script>
<div class="panel" id="help-header">    
	<div class="panel-heading"><i class="icon-info-circle"></i> {l s='What does this section do' mod='wkwarehouses'} ?</div>
    <div class="help-content">
    	<div class="col-lg-2" style="width:10%">
        	<img src="{$this_path|escape:'html':'UTF-8'}/views/img/assign-order.png" width="105" />
        </div>
        <ul class="col-lg-9">
            <li>{l s='This page allows you to list the products purchased for each customer order made on your shop so that you can quickly assign a warehouse for each one' mod='wkwarehouses'}.</li>
            <li>{l s='A drop-down list containing the associated warehouses list is displayed in front of each product using advanced stock management' mod='wkwarehouses'}.</li>
            <li>{l s='The warehouses list are loaded and filtered according to the [1]assigned order carrier[/1]' tags=['<strong>'] mod='wkwarehouses'}.</li>
            <li>{l s='Use the filter from the panel below to list orders products by warehouse' mod='wkwarehouses'}.</li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>

<div class="panel">
	<form method="post" action="{$action|escape:'htmlall':'UTF-8'}" class="form-horizontal clearfix">
		<div class="panel-heading">
        	<i class="icon-search"></i> {l s='Filter by:' mod='wkwarehouses'}
        </div>
		<div class="row">
            <div class="col-lg-4">
				{******* W A R E H O U S E S *******}
                <div class="col-lg-12">
                    <select name="order{$filter_warehouse|escape:'htmlall':'UTF-8'}" id="order{$filter_warehouse|escape:'htmlall':'UTF-8'}">
                        <option value="">--- {l s='Warehouse' mod='wkwarehouses'} ---</option>
                    	{if !empty($warehouses) && count($warehouses)}
                        	{foreach from=$warehouses item=warehouse}
                        	<option value="{$warehouse['id_warehouse']|intval}" {if $warehouse['is_selected']}selected{/if}>{$warehouse['name']|escape:'html':'UTF-8'}</option>
                        	{/foreach}
                    	{/if}
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
			{* BUTTONS ACTIONS IF FILTER IS USED *}
            <div class="col-lg-4">
                <span class="pull-left">
                    {if $is_warehouse_filter}
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
{/block}
