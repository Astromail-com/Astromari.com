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
<table class="table table-bordered">
	<thead>
		<tr>
			<th class="text-left">{l s='Product image' mod='ets_affiliatemarketing'}</th>
			<th class="text-left">{l s='Product name' mod='ets_affiliatemarketing'}</th>
			<th class="text-center">{l s='Sales' mod='ets_affiliatemarketing'}
				<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{l s='The number of sold products' mod='ets_affiliatemarketing'}"></i>
			</th>
			<th class="text-center">{l s='Total cost' mod='ets_affiliatemarketing'}
				<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{l s='The total earning from a product' mod='ets_affiliatemarketing'}"></i>
			</th>
			<th class="text-center">{l s='Action' mod='ets_affiliatemarketing'}</th>
		</tr>
	</thead>
	<tbody>
		{if $data && $data.results}
		{foreach $data.results as $ord}
			<tr>
				<td class="text-left">
                    <a href="{$ord.link_product nofilter}" title="{l s='View product' mod='ets_affiliatemarketing'}" target="_blank" >
					   <img src="{$ord.product_image|escape:'html':'UTF-8'}" alt="{$ord.product_name|escape:'html':'UTF-8'}" style="height: 50px;" />
                    </a>
				</td>
				<td lass="text-left">
					<a href="{$ord.link_product nofilter}" title="{l s='View product' mod='ets_affiliatemarketing'}" target="_blank" >
						{$ord.product_name|escape:'html':'UTF-8'}
					</a>
				</td>
				<td class="text-center">
					{$ord.total_sold|escape:'html':'UTF-8'}
				</td>
				<td class="text-center">
					{$ord.sales|escape:'html':'UTF-8'}
				</td>
				<td class="text-right">
					<a target="_blank" href="{$ord.link_product|escape:'html':'UTF-8'}"  data-toggle="tooltip" data-placement="top" title="{l s='View product' mod='ets_affiliatemarketing'}" class="btn btn-default"><i class="fa fa-search"></i></a>
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
