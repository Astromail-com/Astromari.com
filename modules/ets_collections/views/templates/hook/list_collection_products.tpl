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
<div class="panel-heading">
    {l s='List of products' mod='ets_collections'} <span class="badge">{$total_products|intval}</span>
</div>
<div class="row">
    <div class="no-products ets_col_no_product" {if !$total_products} style="display:block"{else} style="display:none;" {/if}>
        <div class="no-products_content">
            <span class="no-products_content_icon">
                <svg class="svg-icon" viewBox="0 0 20 20">
					<path d="M17.701,3.919H2.299c-0.223,0-0.405,0.183-0.405,0.405v11.349c0,0.223,0.183,0.406,0.405,0.406h15.402c0.224,0,0.405-0.184,0.405-0.406V4.325C18.106,4.102,17.925,3.919,17.701,3.919 M17.296,15.268H2.704V7.162h14.592V15.268zM17.296,6.352H2.704V4.73h14.592V6.352z M5.947,5.541c0,0.223-0.183,0.405-0.405,0.405H3.515c-0.223,0-0.405-0.182-0.405-0.405c0-0.223,0.183-0.405,0.405-0.405h2.027C5.764,5.135,5.947,5.318,5.947,5.541"></path>
				</svg>
            </span>
            <div class="no-products_note_title">{l s='Select products' mod='ets_collections'}</div>
            <div class="no-products_note">{l s='Please select products to add to your collection' mod='ets_collections'}</div>
        </div>
        <button class="btn btn-default btn_add_product_to_collection"><i class="process-icon-new"></i> {l s='Add' mod='ets_collections'}</button>
    </div>
    <div class="has-products" {if $total_products} style="display:block"{else} style="display:none;" {/if}>
         <div>
            <button class="btn btn-default btn_add_product_to_collection"><i class="process-icon-new"></i> {l s='Add product' mod='ets_collections'}</button>
        </div>
        <div class="list-collection-products">
            {if $products}
                {foreach from=$products item='product'}
                    <div id="products-{$product.id_product|intval}" class="product-item" data-id="{$product.id_product|intval}">
                        <input type="hidden" name="selected_products[]" value="{$product.id_product|intval}" />
                        <div class="product-content">
                            <div class="col-product-sortable" title="{l s='Move' mod='ets_collections'}">{l s='Move' mod='ets_collections'}</div>
                            <div class="image sa">
                                <img src="{$product.image|escape:'html':'UTF-8'}" />
                            </div>
                            <div class="">
                                <div class="product-name"><a href="{$product.link|escape:'html':'UTF-8'}" target="_blank">{$product.name|escape:'html':'UTF-8'}</a></div>
                                <div class="product-ref">{$product.reference|escape:'html':'UTF-8'}</div>
                                <div class="product-price">{$product.price|escape:'html':'UTF-8'}</div>
                            </div>
                        </div>
                        <button class="btn btn-default action btn-action-delete-product" data-id="{$product.id_product|escape:'html':'UTF-8'}" title="{l s='Delete product' mod='ets_collections'}">{l s='Delete' mod='ets_collections'}</button>
                    </div>
                {/foreach}
            {/if}
        </div>   
    </div>
</div>
