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

{if $is_aff}
{$message|replace:'[commission_value]':$commission|replace:'[affiliate_link]':'' nofilter}
<div class="input-group input-group-sm eam-form-group mt-10">
	<input type="text" class="eam-input-link form-control" class="eam-input-link disabled eam-tooltip" value="{$link nofilter}" aria-describedby="eam-affiliate-link-add-on">
	<span class="input-group-addon eam-tooltip" data-eam-tooltip="{l s='Click to copy affiliate link' mod='ets_affiliatemarketing'}" data-eam-copy="{l s='Copied to clipboard' mod='ets_affiliatemarketing'}" id="eam-affiliate-link-add-on"><i class="fa fa-copy"></i></span>
</div>
{else}
{$message|replace:'[commission_value]':$commission|replace:'[join_button]':'' nofilter}
<div class="btn-group-join-aff">
	<a href="{$link nofilter}" class="btn btn-info eam-button">{l s='Join Affiliate Program' mod='ets_affiliatemarketing'}</a>
</div>
{/if}