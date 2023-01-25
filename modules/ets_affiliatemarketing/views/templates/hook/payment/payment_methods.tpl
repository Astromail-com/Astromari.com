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

<div class="payment-setting eam-ox-auto">
	<div class="eam-minwidth-900">
		<div class="panel-action">
			<a href="{$link_pm nofilter}&create_pm=1" class="btn btn-default"><i class="fa fa-plus"></i> {l s='Add new method' mod='ets_affiliatemarketing'}</a>
		</div>
		<table class="table table-bordered eam-datatables">
			<thead>
				<tr>
					<th>{l s='ID' mod='ets_affiliatemarketing'}</th>
					<th>{l s='Title' mod='ets_affiliatemarketing'}</th>
					<th>{l s='Fee type' mod='ets_affiliatemarketing'}</th>
					<th>{l s='Fee amount' mod='ets_affiliatemarketing'}</th>
					<th>{l s='Status' mod='ets_affiliatemarketing'}</th>
					<th class="text-center">{l s='Sort order' mod='ets_affiliatemarketing'}</th>
					<th style="width: 150px;">{l s='Action' mod='ets_affiliatemarketing'}</th>
				</tr>
			</thead>
			<tbody class="list-pm">
				{if $payment_methods}
					{foreach $payment_methods as $p}
					<tr data-id="{$p.id_ets_am_payment_method|escape:'html':'UTF-8'}">
						<td>{$p.id_ets_am_payment_method|escape:'html':'UTF-8'}</td>
						<td>{$p.title|escape:'html':'UTF-8'}</td>
						<td>
							{if $p.fee_type == 'PERCENT'}
								{l s='Percentage' mod='ets_affiliatemarketing'}
							{elseif $p.fee_type == 'FIXED'}
								{l s='Fixed' mod='ets_affiliatemarketing'}
							{else}
								{l s='No fee' mod='ets_affiliatemarketing'}
							{/if}
						</td>
						<td>
							{if $p.fee_type == 'PERCENT'}
								{$p.fee_percent|escape:'html':'UTF-8'} %
							{elseif $p.fee_type == 'FIXED'}
								{$p.fee_fixed|escape:'html':'UTF-8'}
							{/if}
						</td>
						<td>
							{if $p.enable == 1}
								<span class="label label-success">{l s='Enabled' mod='ets_affiliatemarketing'}</span>
							{else}
								<span class="label label-default">{l s='Disabled' mod='ets_affiliatemarketing'}</span>
							{/if}
						</td>
						<td class="eam-active-sortable"><div class="box-drag"><i class="fa fa-arrows"></i><span class="sort-order">{$p.sort|escape:'html':'UTF-8'}</span></div></td>
						<td>
							<!-- Split button -->
							<div class="btn-group">
							  <a href="{$link_pm nofilter}&payment_method={$p.id_ets_am_payment_method|escape:'html':'UTF-8'}&edit_pm=1" class="btn btn-default" style="text-transform: inherit;">
								<i class="fa fa-pencil"></i> {l s='Edit' mod='ets_affiliatemarketing'}
								</a>
							  <button type="button" class="btn btn-default dropdown-toggle dropdown-has-form" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <span class="caret"></span>
							    <span class="sr-only">Toggle Dropdown</span>
							  </button>
							  <ul class="dropdown-menu">
							    <li>
							    	<a href="javascript:void(0)">
							    		<form style="display: inline-block;" action="{$link_pm|escape:'html':'UTF-8'}&payment_method={$p.id_ets_am_payment_method|escape:'html':'UTF-8'}&delete_pm=1" method="POST" onsubmit="return eamConfirmDelete()">
											<button type="submit" name="delete_payment_method" class="btn btn-link btn-link-dropdown"><i class="fa fa-trash"></i> {l s='Delete' mod='ets_affiliatemarketing'}</button>
										</form>
							    	</a>
							    </li>
							  </ul>
							</div>
							
							
							
						</td>
					</tr>
					{/foreach}
				{else}
				<tr>
	                <td colspan="100%" style="text-align: center;">
	                    {l s='No data found' mod='ets_affiliatemarketing'}
	                </td>
	            </tr>
				{/if}
			</tbody>
		</table>
	</div>
</div>