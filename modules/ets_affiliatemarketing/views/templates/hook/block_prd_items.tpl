{*
* 2007-2023 ETS-Soft
*
* NOTICE OF LICENSE
*
* This file is not open source! Each license that you purchased is only available for 1 website only.
* If you want to use this file on more websites (or projects), you need to purchase additional licenses.
* You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <contact@etssoft.net>
*  @copyright  2007-2023 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{if isset($products) && $products}
    {foreach from=$products item='product'}
        <li class="snw_product_item clearfix" data-id="{$product->id_product|intval}">
            <div class="item-img">
                <img class="snw_product_image" src="{$product->image|escape:'quotes':'UTF-8'}"
                     alt="{$product->name|truncate:20:'...':true|escape:'html':'UTF-8'}"/>
            </div>
            <div class="item-body">
                <div class="snw_product_info">
                    <a class="product_img_link" href="{$product->product_url nofilter}"
                       title="{$product->name|escape:'html':'UTF-8'}" itemprop="url" target="_blank">
                        <span class="product_name">{$product->name|truncate:80:'...':true|escape:'html':'UTF-8'}</span>
                    </a>
                </div>
            </div>
            <div class="content_price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <span itemprop="price" class="price product-price">{convertPrice price=$product->price}</span>
            </div>
            <div class="item-action">
                <a href="javascript:void(0)" class="snw_block_item_close" title="{l s='Delete' mod='ets_megamenu' mod='ets_affiliatemarketing'}">
                    <i class="icon-trash"></i>
                </a>
            </div>
        </li>
    {/foreach}
{/if}