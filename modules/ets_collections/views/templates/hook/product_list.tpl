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
<div class="ets_col_list_blocks clearfix">
    {if $name_page!='collection_page'}
        <h4 class="ets_col_title"><a href="{$collection_link|escape:'html':'UTF-8'}">{$collection_name|escape:'html':'UTF-8'}</a></h4>
    {/if}
    <div class="ets_col_product_list">
        {if $ets_col_per_row_desktop}
            {assign var='nbItemsPerLine' value=$ets_col_per_row_desktop}
        	{assign var='nbItemsPerLineTablet' value=$ets_col_per_row_tablet}
        	{assign var='nbItemsPerLineMobile' value=$ets_col_per_row_mobile}
        {else}
            {if $page_name !='index' && $page_name !='product' && $page_name != 'order-confirmation' && $page_name!='orderconfirmation' && $page_name!='cms' && $page_name!='cart'}
            	{assign var='nbItemsPerLine' value=3}
            	{assign var='nbItemsPerLineTablet' value=2}
            	{assign var='nbItemsPerLineMobile' value=3}
            {else}
            	{assign var='nbItemsPerLine' value=4}
            	{assign var='nbItemsPerLineTablet' value=3}
            	{assign var='nbItemsPerLineMobile' value=2}
            {/if}
        {/if}
        {if isset($products) && $products}
            <div data-row-desktop="{$nbItemsPerLine|intval}" data-row-tablet="{$nbItemsPerLineTablet|intval}" data-row-mobile="{$nbItemsPerLineMobile|intval}" id="{$name_page|escape:'html':'UTF-8'}-{$tab|escape:'html':'UTF-8'}" class="{$name_page|escape:'html':'UTF-8'} product_list_16 product_list products row ets_col_product_list_wrapper{if isset($tab) && $tab}  ets-col-wrapper-{$tab|escape:'html':'UTF-8'}{/if} layout-{$layout_mode|escape:'html':'utf-8'} ets_col_desktop_{$nbItemsPerLine|intval} ets_col_tablet_{$nbItemsPerLineTablet|intval} ets_col_mobile_{$nbItemsPerLineMobile|intval}">
                {include file="$tpl_dir./product-list.tpl" class="product_list grid row" id="{if isset($id) && $id} {$id|escape:'html':'UTF-8'}{/if}"}
        	</div>
        {else}
        	<div data-row-desktop="{$nbItemsPerLine|intval}" data-row-tablet="{$nbItemsPerLineTablet|intval}" data-row-mobile="{$nbItemsPerLineMobile|intval}" id="{$name_page|escape:'html':'UTF-8'}-{$tab|escape:'html':'UTF-8'}" class="no-product {$name_page|escape:'html':'UTF-8'} ets_col_product_list_wrapper{if isset($tab) && $tab}  ets-col-wrapper-{$tab|escape:'html':'UTF-8'}{/if} layout-{$layout_mode|escape:'html':'utf-8'} ets_col_desktop_{$nbItemsPerLine|intval} ets_col_tablet_{$nbItemsPerLineTablet|intval} ets_col_mobile_{$nbItemsPerLineMobile|intval}">
                <div class="col-sm-12 col-xs-12"><div class="clearfix"></div><span class="alert alert-warning">{l s='No products available' mod='ets_collections'}</span></div>
            </div>
        {/if}
    </div>
</div>