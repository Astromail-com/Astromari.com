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
{if ($customer && $customer->id)}
    {if $user}
        {if $user['status'] == 0 || $user['status'] == -1}
            <a href="javascript:void(0)" data-id="{$item_id|escape:'html':'UTF-8'}" class="js-action-user-reward" data-action="active"><i class="fa fa-check"></i> {l s='Activate' mod='ets_affiliatemarketing'} </a>
        {else}
            <a href="javascript:void(0)" data-id="{$item_id|escape:'html':'UTF-8'}" class="js-action-user-reward" data-action="decline"><i class="fa fa-close"></i> {l s='Suspend' mod='ets_affiliatemarketing'}</a>
        {/if}
    {else}
        <a href="javascript:void(0)" data-id="{$item_id|escape:'html':'UTF-8'}" class="js-action-user-reward" data-action="decline"><i class="fa fa-close"></i> {l s='Suspend' mod='ets_affiliatemarketing'}</a>
    {/if}
{else}
    <a href="javascript:viod(0)" class="eam-link-no-action">&nbsp;</a
{/if}
