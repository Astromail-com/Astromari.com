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
{if $collections}
    <div class="home-collections ets_col_product_list">
        <h4 class="follow-title"><a href="{$link->getModuleLink('ets_collections','collection')|escape:'html':'UTF-8'}">{$collection_title|escape:'html':'UTF-8'}</a></h4>
    	<div id="page_home_collections" class="list-collections collections ets_collections_product_list_wrapper{if $collection_mode=='slide'} slide{else} grid{/if} ets_col_product_list_wrapper product_list" data-row-desktop="{$row_desktop|intval}" data-row-tablet="{$row_tablet|intval}" data-row-mobile="{$row_mobile|intval}">
        	{foreach from=$collections item='collection'}
                  <div class="collection-miniature product-miniature">
                        <div class="thumbnail-container">
                            <a class="colleciton-thumbnail" href="{$collection.link_view|escape:'html':'UTF-8'}" tabindex="0">
                                <span class="collection_img_bg{if !$collection.thumb} no_image{/if}" style="background-image:url({$link->getMediaLink("`$smarty.const.__PS_BASE_URI__`img/col_collection/`$collection.thumb|escape:'html':'UTF-8'`")});">
                                    <img style="display:none" alt="{$collection.name|escape:'html':'UTF-8'}" src="{$link->getMediaLink("`$smarty.const.__PS_BASE_URI__`img/col_collection/`$collection.thumb|escape:'html':'UTF-8'`")}" />
                                </span>
                            </a>
                            <div class="collection-description">
                                <h3 class="h3 collection-name">
                                    <a href="{$collection.link_view|escape:'html':'UTF-8'}">{$collection.name|escape:'html':'UTF-8'}</a>
                                </h3>
                                {if $collection.description}
                                    <div class="colleciton-desc">{$collection.description|nl2br nofilter}</div>
                                {/if}
                                <div class="number-product">{$collection.total_product|intval} {if $collection.total_product>1}{l s='products' mod='ets_collections'}{else}{l s='product' mod='ets_collections'}{/if}</div>
                            </div>
                        </div>
                  </div>
            {/foreach}
        </div>
    </div>
{/if}