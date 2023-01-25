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
* needs please, contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <contact@etssoft.net>
*  @copyright  2007-2023 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{if $customers}
    {foreach from=$customers item='customer'}
        <li>{$customer.firstname|escape:'html':'UTF-8'}&nbsp;{$customer.lastname|escape:'html':'UTF-8'} ({$customer.email|escape:'html':'UTF-8'})
            {if !$customer.friend}<span class="add_friend_customer btn btn-default" data-id="{$customer.id_customer|intval}">
                <i class="icon-plus-circle"></i>{l s='Add' mod='ets_affiliatemarketing'}</span>
            {else}
                {if $customer.friend==1}
                    <span class="atf_added">{l s='Already in friends list' mod='ets_affiliatemarketing'}</span>
                {elseif $customer.friend==2}
                    <span class="atf_added atf_added_another">{l s='Already in friends list of another sponsor' mod='ets_affiliatemarketing'}</span>
                {else}
                    <span class="atf_added atf_added_another">{l s='Already is a referral/sponsor' mod='ets_affiliatemarketing'}</span>
                {/if}
            {/if}
        </li>
    {/foreach}
{else}
    <li class="aff_no_customer">{l s='No customer was found' mod='ets_affiliatemarketing'}</li>
{/if}