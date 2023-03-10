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
{if isset($type) && $type == 'label'}
	<span class="label {if isset($class)}{$class|escape:'html':'UTF-8'}{/if}">{if isset($text)}{$text|escape:'html':'UTF-8'}{/if}</span>
{elseif isset($type) && $type == 'link' && isset($link)}
	<a href="{$link|escape:'html':'UTF-8'}">
		{if isset($user_deleted) && $user_deleted}
			<span class="warning-deleted">{l s='User deleted' mod='ets_affiliatemarketing'} (ID: {if isset($id)}{$id|escape:'html':'UTF-8'}{/if})</span>
		{else}
			{if isset($text)}{$text|escape:'html':'UTF-8'}{/if}
		{/if}
	</a>
{elseif isset($type) && $type == 'br'}
	<br>
{else}
{/if}