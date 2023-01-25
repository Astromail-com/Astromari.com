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
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2021 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
<input type="hidden" value="{$current_page|intval}" class="ets_col_current_tab"/>
<section id="products">
    <div class="products row">
        {if $products}
            {if $is17}
                {foreach from=$products item="product"}
                      {include file="catalog/_partials/miniatures/product.tpl" product=$product position=""}
                {/foreach}
            {else}
                {include file="$tpl_dir./product-list.tpl" class="product_list grid row products" id="product_page_seller"}
            {/if}
        {else}
            <div class="clearfix"></div>
            <span class="alert alert-warning">{l s='No products available' mod='ets_collections'}</span>
        {/if}
    </div>
    {if $paggination}
        <div class="paggination">
            {$paggination nofilter}
        </div>
    {/if}
</section>