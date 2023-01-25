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
{extends file="helpers/form/form.tpl"}

{block name="script"}
var warehouse_required = '{l s='Please select warehouse from the list' js=1 mod='wkwarehouses'}.';
{/block}

{block name="description"}
    {if isset($input.desc) && !empty($input.desc)}
        <p class="help-block">
            {if is_array($input.desc)}
                {foreach $input.desc as $p}
                    {if is_array($p)}
                        <span id="{$p.id|escape:'html':'UTF-8'}">{$p.text|escape:'html':'UTF-8'}</span><br />
                    {else}
                        {$p}{* HTML CONTENT *}<br />
                    {/if}
                {/foreach}
            {else}
                {if $input.name == 'WKWAREHOUSE_STOCKPRIORITY_INC' || $input.name == 'WKWAREHOUSE_STOCKPRIORITY_DEC'}
                <div class="alert alert-info">
                    {$input.desc|escape:'html':'UTF-8'}
                </div>          
                {else}
                	{$input.desc}{* HTML CONTENT *}
                {/if}
            {/if}
        </p>
    {/if}
{/block}

{block name="label"}
    {if $input.type == 'free'}
    	{if $input.name == 'option_settings'}
			<div class="left-free-block">{$input.label|escape:'html':'UTF-8'}</div>
    	{else if $input.name == 'option_warnings'}
            <div class="alert alert-warning warn">
        		{$input.label|escape:'html':'UTF-8'|replace:'\n':'<br>'}
        	</div>
    	{else if $input.name == 'separator'}
            <hr />
    	{/if}
    {else}
		{$smarty.block.parent}
    {/if}
{/block}

{block name='input'}
    {************************************ HANDLE PRIORITY IN CASE OF INCREASE **************************************}
    {if $input.type == 'priority_increase'}
    	{if $warehouses_increase|@count}
	    <div class="row" id="{$input.type|escape:'html':'UTF-8'}">
	    	<div class="col-lg-1">
	    		<h4>{l s='Position' mod='wkwarehouses'}</h4> 
                <a href="#" class="btn btn-default menuOrderUp"><i class="icon-chevron-up"></i></a><br />
                <a href="#" class="btn btn-default menuOrderDown"><i class="icon-chevron-down"></i></a><br />
	    	</div>
	    	<div class="col-lg-5">
	    		<h4>{l s='Selected warehouses' mod='wkwarehouses'}</h4>
                <select multiple="multiple" name="warehouseBox[]" class="warehouseList pages-select">
        		{assign var=k value=1}
                {foreach from=$warehouses_increase item=wh}
                    <option value="{$wh.id_warehouse|intval}" selected="selected">{$k|intval} - {$wh.name|escape:'html':'UTF-8'}</option>
            		{assign var=k value=$k+1}
                {/foreach}
                </select>
	    	</div>
	    </div>
	    <br />
        {else}
            <div class="alert alert-warning">
            	{l s='You have to create warehouse(s) before to be able to define priorities' mod='wkwarehouses'}.<br />
                <a class="btn btn-default" href="{$link->getAdminLink('AdminManageWarehouses')|escape:'html':'UTF-8'}&addwarehouse" target="_blank"><i class="icon-plus-sign"></i> {l s='Create a new warehouse' mod='wkwarehouses'}?</a>
            </div>
        {/if}
        <div class="alert alert-info">
            {l s='The Warehouses Priority is used to determine which one has priority to be updated' mod='wkwarehouses'}.
        </div>
    {************************************ HANDLE PRIORITY IN CASE OF DECREASE **************************************}
    {else if $input.type == 'priority_decrease'}
    	{if $warehouses_decrease|@count}
	    <div class="row" id="{$input.type|escape:'html':'UTF-8'}">
	    	<div class="col-lg-1">
	    		<h4>{l s='Position' mod='wkwarehouses'}</h4>
                <a href="#" class="btn btn-default menuOrderUp"><i class="icon-chevron-up"></i></a><br />
                <a href="#" class="btn btn-default menuOrderDown"><i class="icon-chevron-down"></i></a><br />
	    	</div>
	    	<div class="col-lg-5">
	    		<h4>{l s='Selected warehouses' mod='wkwarehouses'}</h4>
                <select multiple="multiple" name="warehouseDecreaseBox[]" class="warehouseList pages-select">
        		{assign var=k value=1}
                {foreach from=$warehouses_decrease item=wh}
                    <option value="{$wh.id_warehouse|intval}" selected="selected">{$k|intval} - {$wh.name|escape:'html':'UTF-8'}</option>
            		{assign var=k value=$k+1}
                {/foreach}
                </select>
	    	</div>
	    </div>
	    <br/>
        {else}
            <div class="alert alert-warning">
            	{l s='You have to create warehouse(s) before to be able to define priorities' mod='wkwarehouses'}.<br />
                <a class="btn btn-default" href="{$link->getAdminLink('AdminManageWarehouses')|escape:'html':'UTF-8'}&addwarehouse" target="_blank"><i class="icon-plus-sign"></i> {l s='Create a new warehouse' mod='wkwarehouses'}?</a>
            </div>
        {/if}
        <div class="alert alert-info">
            {l s='The Warehouses Priority is used to determine which one has priority to be updated' mod='wkwarehouses'}.
        </div>
	{else}
		{$smarty.block.parent}
    {/if}
{/block}
