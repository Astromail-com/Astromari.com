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
{if $invitations.result}
	{foreach $invitations.result as $result}
		<tr>
			<td class="text-left">{$result.email nofilter}</td>
			<td class="text-left">{$result.username nofilter}</td>
			<td class="text-left">{date('d/m/Y', strtotime($result.datetime_sent)) nofilter}</td>
			<td  class="text-center">
				{if $result.status}
					<i class="fa fa-check eam-text-green eam-mr-8"></i> {l s='Registered' mod='ets_affiliatemarketing'}
				{else}
					<i class="fa fa-clock-o eam-text-orange  eam-mr-8"></i> {l s='Pending' mod='ets_affiliatemarketing'}
				{/if}
			</td>
		</tr>
	{/foreach}
    {if $invitations.total_page > $invitations.current_page}
        <tr class="refer-friends">
            <td colspan="100%" style="text-align: center;"><a class="button-refer-friends" href="{$link->getModuleLink('ets_affiliatemarketing','refer_friends',['page'=>$invitations.current_page|intval+1,'load_more'=>true,'ajax'=>true])}">{l s='Load more' mod='ets_affiliatemarketing'}</a></td>
        </tr>
    {/if}
{/if}