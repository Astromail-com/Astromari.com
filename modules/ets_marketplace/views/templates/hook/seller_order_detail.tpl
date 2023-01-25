{*
* 2007-2022 ETS-Soft
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
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2022 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{if $is17}
<ul class="seller_info_in_order_detail" style="display:none">
    <li>
        <strong>{l s='Shop name' mod='ets_marketplace'}</strong> <a href="{$seller->getLink()|escape:'html':'UTF-8'}">{$seller->shop_name|escape:'html':'UTF-8'}</a>
    </li>
</ul>
{else}
    <div class="seller_info_in_order_detail_16" style="display:none">
        <p><strong class="dark">{l s='Shop name' mod='ets_marketplace'}</strong> <a href="{$seller->getLink()|escape:'html':'UTF-8'}">{$seller->shop_name|escape:'html':'UTF-8'}</a>
    </div>
{/if}