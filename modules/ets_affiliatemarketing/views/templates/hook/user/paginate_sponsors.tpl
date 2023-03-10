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
{if $sponsors.result}
	{foreach $sponsors.result as $sponsor}
		<tr>
			<td>
				{$sponsor.id_customer|escape:'html':'UTF-8'}
			</td>
			<td>
				<a href="{$customer_link nofilter}&id_customer={$sponsor.id_customer nofilter}&viewcustomer">
					{if $sponsor.firstname}
						{$sponsor.firstname|escape:'html':'UTF-8'} {$sponsor.lastname|escape:'html':'UTF-8'}
					{else}
					<span class="warning-deleted label">{l s='User deleted' mod='ets_affiliatemarketing'}</span>
					{/if}
				</a>
			</td>
            <td>{$sponsor.email|escape:'html':'UTF-8'}</td>
			<td class="text-center">{$sponsor.level|escape:'html':'UTF-8'}</td>
			<td class="text-center">{$sponsor.total_order|escape:'html':'UTF-8'}</td>
			<td class="text-center">{$sponsor.total_point|escape:'html':'UTF-8'}</td>
		</tr>
	{/foreach}
{/if}