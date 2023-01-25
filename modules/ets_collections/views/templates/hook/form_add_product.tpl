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
<div id="fieldset_1" class="panel">
    <div class="panel-heading">
        <i class="process-icon-new"></i>
        {l s='Add product' mod='ets_collections'}
    </div>
    <div class="form-wrapper">
        <div class="block_search">
            <input type="text" placeholder="{l s='Product name' mod='ets_collections'}" name="name_product" id="name_product"/>
            <input type="text" placeholder="{l s='Reference' mod='ets_collections'}" name="reference_product" id="reference_product"/>
            <input type="text" placeholder="{l s='Minimum price' mod='ets_collections'}" name="price_product_min"  id="price_product_min"/>
            <input type="text" placeholder="{l s='Maximum price' mod='ets_collections'}" name="price_product_max"  id="price_product_max"/>
            <div class="product_filter_product_tree">
                <div id="product_catalog_category_tree_filter" class="d-inline-block dropdown dropdown-clickable mr-2">
                    <button class="btn btn-outline-secondary" type="button">{l s='Filter by categories' mod='ets_collections'} </button>
                    <div id="tree-categories" class="dropdown-menu" style="">
                        <div class="categories-tree-actions">
                            <a id="product_catalog_category_tree_filter_expand" href="#">
                                <i class="material-icons">expand_more</i>
                                {l s='Expand' mod='ets_collections'}
                            </a>
                            <a id="product_catalog_category_tree_filter_collapse" href="#">
                                <i class="material-icons">expand_less</i>
                                {l s='Collapse' mod='ets_collections'}
                            </a>
                            <label id="product_catalog_category_tree_filter_reset" href="#">
                                <input name="id_category" type="radio" value="0" class="category" /> {l s='Unselect' mod='ets_collections'}
                            </label>
                        </div>
                        <ul class="category-tree">
                            {$categories_tree nofilter}
                        </ul>
                    </div>
                </div>
            </div>
            <button class="btn btn-default btn-clear-filter">
                <i class="icon-eraser"></i>
                {l s='Clear all filter' mod='ets_collections'}
            </button>
        </div>
        <div class="block_products row">
            <div class="block_product_no_selected">
                <div class="block_product_form_content">
                    <div class="panel-heading">
                        {l s='List of products' mod='ets_collections'} <span class="badge">{count($products)|intval} {if count($products) >1}{l s='products' mod='ets_collections'}{else}{l s='product' mod='ets_collections'}{/if}</span>
                        <span class="heading-action"><a href="#" class="add_all_product_collection">{l s='Add all' mod='ets_collections'}</a></span>
                    </div>
                    <div class="product-wrapper">
                        {if $products}
                            {foreach from=$products item='product'}
                                <div class="product-item">
                                    <div class="product-content">
                                        <div class="image">
                                            <img src="{$product.image|escape:'html':'UTF-8'}" />
                                        </div>
                                        <div class="">
                                            <div class="product-name"><a href="{$product.link|escape:'html':'UTF-8'}" target="_blank">{$product.name|escape:'html':'UTF-8'}</a></div>
                                            <div class="product-ref">{$product.reference|escape:'html':'UTF-8'}</div>
                                            <div class="product-price">{$product.price|escape:'html':'UTF-8'}</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-default action btn-action-add-product" data-id="{$product.id_product|intval}" title="{l s='Add' mod='ets_collections'}">{l s='Add' mod='ets_collections'}</button>
                                </div>
                            {/foreach}
                        {/if}
                        {if $total_pages>1}
                            <div class="load_more hide" data-page="1">{l s='Load more' mod='ets_collections'}</div>
                        {/if}
                    </div>
                    <div class="alert alert-warning no_product" {if $products} style="display:none"{/if}>{l s='No products available' mod='ets_collections'}</div>
                </div>
            </div>
            <div class="block_product_selected">
                <div class="block_product_form_content">
                    <div class="panel-heading">
                        {l s='List of selected products' mod='ets_collections'}<span class="badge">{count($selected_products)|intval} {if count($selected_products) >1}{l s='products' mod='ets_collections'}{else}{l s='product' mod='ets_collections'}{/if}</span>
                        <span class="heading-action"><a href="#" class="delete_all_product_collection">{l s='Delete all' mod='ets_collections'}</a></span>
                    </div>
                    <div class="product-wrapper" id="list_selected_products">
                        {if $selected_products}
                            {foreach from=$selected_products item='product'}
                                <div id="products-{$product.id_product|intval}" class="product-item" data-id="{$product.id_product|intval}">
                                    <input type="hidden" name="selected_products[]" value="{$product.id_product|intval}" />
                                    <div class="product-content">
                                        <div class="col-product-sortable" title="{l s='Move' mod='ets_collections'}">{l s='Move' mod='ets_collections'}</div>
                                        <div class="image">
                                            <img src="{$product.image|escape:'html':'UTF-8'}" />
                                        </div>
                                        <div class="">
                                            <div class="product-name"><a href="{$product.link|escape:'html':'UTF-8'}" target="_blank">{$product.name|escape:'html':'UTF-8'}</a></div>
                                            <div class="product-ref">{$product.reference|escape:'html':'UTF-8'}</div>
                                            <div class="product-price">{$product.price|escape:'html':'UTF-8'}</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-default action btn-action-delete-product" data-id="{$product.id_product|intval}" title="{l s='Delete product' mod='ets_collections'}">{l s='Delete' mod='ets_collections'}</button>
                                </div>
                            {/foreach}
                        {/if}
                        <p class="no_selected_product" {if $selected_products} style="display:none"{/if}>
                            <span class="icon_no_product"></span><br />
                            <span class="no_product_note">{l s='No product' mod='ets_collections'}.</span><br />
                            <span class="no_product_note_add">{l s='Select the product on the left to add to the list' mod='ets_collections'}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <button id="btn_module_form_cancel" class="btn btn-default pull-left" value="1" name="btnCancelProductConllection">
            <i class="process-icon-cancel"></i>
            {l s='Cancel' mod='ets_collections'}
        </button>
        <button id="btn_module_form_submit" class="btn btn-default pull-right" type="submit" value="1" name="btnSubmitSaveProductConllection">
            <i class="process-icon-new"></i>
            {l s='Add' mod='ets_collections'}
        </button>
    </div>
</div>