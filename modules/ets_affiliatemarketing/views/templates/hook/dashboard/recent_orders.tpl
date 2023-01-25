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
			<th class="text-left">{l s='Customer Name' mod='ets_affiliatemarketing'}</th>
			<th class="text-center">{l s='Products' mod='ets_affiliatemarketing'}
				<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{l s='The number of products in each order' mod='ets_affiliatemarketing'}"></i>
			</th>
			<th class="text-center">{l s='Total orders' mod='ets_affiliatemarketing'}
				<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{l s='Total order value of a customer' mod='ets_affiliatemarketing'}"></i>
			</th>
			<th class="text-center">{l s='Date' mod='ets_affiliatemarketing'}</th>
			<th class="text-center">{l s='Status' mod='ets_affiliatemarketing'}</th>
			<th class="text-center">{l s='Action' mod='ets_affiliatemarketing'}</th>
		</tr>
	</thead>
	<tbody>
		{if $data && $data.results}
		{foreach $data.results as $ord}
		<tr>
			<td class="text-left">
				{if $ord.username}
                    <a href="{$customer_link|escape:'html':'UTF-8'}&id_customer={$ord.id_customer|escape:'html':'UTF-8'}&viewreward_users" title="{l s='View user' mod='ets_affiliatemarketing'}">{$ord.username|escape:'html':'UTF-8'}</a>
                {else}
                    <a href="{$customer_link|escape:'html':'UTF-8'}&id_customer={$ord.id_customer|escape:'html':'UTF-8'}&viewreward_users" title="{l s='View user' mod='ets_affiliatemarketing'}"><span class="warning-deleted">{l s='User deleted' mod='ets_affiliatemarketing'} ID: ({$ord.id_customer|escape:'html':'UTF-8'})</span></a>
                {/if}
			</td>
			<td class="text-center">{$ord.total_product|escape:'html':'UTF-8'}</td>
			<td class="text-center">{$ord.total_turnover|escape:'html':'UTF-8'}</td>
			<td class="text-center">{$ord.datetime_added|escape:'html':'UTF-8'}</td>
			<td class="text-center">
                {if $ord.state_template == 'cheque'}
                    <span class="amb-recent-orders-status amb-awaiting-check-payment">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'payment'}
                    <span class="amb-recent-orders-status amb-payment-accepted">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'preparation'}
                    <span class="amb-recent-orders-status amb-processing-in-progress">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'shipped'}
                    <span class="amb-recent-orders-status amb-shipped">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'order_canceled'}
                    <span class="amb-recent-orders-status amb-canceled">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'refund'}
                    <span class="amb-recent-orders-status amb-refunded">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'payment_error'}
                    <span class="amb-recent-orders-status amb-payment-error">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'outofstock'}
                    <span class="amb-recent-orders-status amb-on-backorder-paid">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'bankwire'}
                    <span class="amb-recent-orders-status amb-awaiting-bank-wire-payment">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'payment'}
                    <span class="amb-recent-orders-status amb-remote-payment-accepted">{$ord.status|escape:'html':'UTF-8'}</span>
                {elseif $ord.state_template == 'cashondelivery'}
                    <span class="amb-recent-orders-status amb-awaiting-cash-on-delivery-validation">{$ord.status|escape:'html':'UTF-8'}</span>
                {else}
                    <span class="amb-recent-orders-status amb-delivered">{$ord.status|escape:'html':'UTF-8'}</span>
                {/if}                
                                             
            </td>
			<td class="text-center">
				<a href="{$customer_link|escape:'html':'UTF-8'}&id_customer={$ord.id_customer|escape:'html':'UTF-8'}&viewreward_users"  class="btn btn-default" data-toggle="tooltip" data-placement="top" title="{l s='View user' mod='ets_affiliatemarketing'}"><i class="fa fa-search"></i></a>
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

