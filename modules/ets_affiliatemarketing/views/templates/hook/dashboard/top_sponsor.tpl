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
<table class="table">
	<thead>
		<tr>
			<th class="text-left">{l s='Sponsor' mod='ets_affiliatemarketing'}
				<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{l s='Existing customers referred your website & products to their friends to get reward' mod='ets_affiliatemarketing'}"></i>
			</th>
			<th class="text-center">{l s='Friends' mod='ets_affiliatemarketing'}
				<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{l s="The number of sponsor's friend registered new account on your website" mod='ets_affiliatemarketing'}"></i>
			</th>
			<th class="text-center">{l s='Orders' mod='ets_affiliatemarketing'}
				<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{l s="The number of orders which sponsor's friend purchased" mod='ets_affiliatemarketing'}"></i>
			</th>
			<th class="text-center">{l s='Total order cost' mod='ets_affiliatemarketing'}
				<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{l s="Total earning from orders of sponsor's friend" mod='ets_affiliatemarketing'}"></i>
			</th>
			<th class="text-center">{l s='Sponsor rewards' mod='ets_affiliatemarketing'}
				<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{l s='The amount of rewards a sponsor earned' mod='ets_affiliatemarketing'}"></i>
			</th>
			<th class="text-right">{l s='Action' mod='ets_affiliatemarketing'}</th>
		</tr>
	</thead>
	<tbody>
		{if $data && $data.results}
		{foreach $data.results as $ord}
		<tr>
			<td class="text-left">
				{if $ord.username}
                    <a href="{$customer_link|escape:'html':'UTF-8'}&id_reward_users={$ord.id_customer|escape:'html':'UTF-8'}&viewreward_users" title="{l s='View user' mod='ets_affiliatemarketing'}">{$ord.username|escape:'html':'UTF-8'}</a>
                {else}
                    <a href="{$customer_link|escape:'html':'UTF-8'}&id_reward_users={$ord.id_customer|escape:'html':'UTF-8'}&viewreward_users" title="{l s='View user' mod='ets_affiliatemarketing'}"><span class="warning-deleted">{l s='User deleted' mod='ets_affiliatemarketing'} ID: ({$ord.id_customer|escape:'html':'UTF-8'})</span></a>
                {/if}
			</td>
			<td class="text-center">{if $ord.total_friend}{$ord.total_friend nofilter}{else}--{/if}</td>
			<td class="text-center">{if $ord.total_order}{$ord.total_order nofilter}{else}--{/if}</td>
			<td class="text-center">{if $ord.total_sale}{$ord.total_sale nofilter}{else}--{/if}</td>
			<td class="text-center">{if $ord.total_point}{$ord.total_point nofilter}{else}--{/if}</td>
			<td class="text-right">
				<a href="{$customer_link nofilter}&id_reward_users={$ord.id_customer|escape:'html':'UTF-8'}&viewreward_users"  class="btn btn-default" data-toggle="tooltip" data-placement="top" title="{l s='View user' mod='ets_affiliatemarketing'}"><i class="fa fa-search"></i></a>
			</td>
		</tr>
		{/foreach}
		{else}
			<tr>
				<td colspan="100%" class="text-center">{l s='No data found' mod='ets_affiliatemarketing'}</td>
			</tr>
		{/if}
	</tbody>
</table>
