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
<div class="eam-my-friends">
	
	<table class="table eam-table-flat table-hover eam_no_border">
		<thead>
			<tr>
				<th>{l s='ID' mod='ets_affiliatemarketing'}
					<a href="javascript:void(0)" title="" class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'id'}active{/if}" data-order-by="id" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
					<a href="javascript:void(0)" title="" class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'id'}active{/if}" data-order-by="id" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
				</th>
                {if $display_name}
    				<th>{l s='Name' mod='ets_affiliatemarketing'}
    					<a href="javascript:void(0)" title="" class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'firstname'}active{/if}" data-order-by="firstname" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
    					<a href="javascript:void(0)" title="" class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'firstname'}active{/if}" data-order-by="firstname" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
    				</th>
                {/if}
				{if $display_email}
				<th class="text-left">{l s='Email' mod='ets_affiliatemarketing'}
					<a href="javascript:void(0)" title="" class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'email'}active{/if}" data-order-by="email" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
					<a href="javascript:void(0)" title="" class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'email'}active{/if}" data-order-by="email" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
				</th>
				{/if}
				<th class="text-center">{l s='Level' mod='ets_affiliatemarketing'}
					<a href="javascript:void(0)" title="" class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'level'}active{/if}" data-order-by="level" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
					<a href="javascript:void(0)" title="" class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'level'}active{/if}" data-order-by="level" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
				</th>
				<th class="text-center">{l s='Orders' mod='ets_affiliatemarketing'}
					<a href="javascript:void(0)" title="" class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'order'}active{/if}" data-order-by="order" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
					<a href="javascript:void(0)" title="" class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'order'}active{/if}" data-order-by="order" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
				</th>
				<th class="text-center">{l s='Earning reward approved' mod='ets_affiliatemarketing'}
					<a href="javascript:void(0)" title="" class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'reward'}active{/if}" data-order-by="reward" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
					<a href="javascript:void(0)" title="" class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'reward'}active{/if}" data-order-by="reward" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
				</th>
				<th class="text-center">{l s='Friend(s)' mod='ets_affiliatemarketing'}
					<a href="javascript:void(0)" title="" class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'friend'}active{/if}" data-order-by="friend" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
					<a href="javascript:void(0)" title="" class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'friend'}active{/if}" data-order-by="friend" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
				</th>
                <th class="text-center">{l s='Action' mod='ets_affiliatemarketing'}</th>
			</tr>
		</thead>
		<tbody>
			{if $friends.result }
				{foreach $friends.result as $result}
				<tr>
					<td>{$result.id_customer nofilter}</td>
					{if $display_name}
                        <td>
    						{if $result.firstname}
    							{$result.firstname|escape:'html':'UTF-8'} {$result.lastname|escape:'html':'UTF-8'}
    						{else}
    							<span class="warning-deleted label">{l s='User deleted' mod='ets_affiliatemarketing'}</span>
    						{/if}
    					</td>
                    {/if}
					{if $display_email}
					   <td class="text-left">{$result.email nofilter}</td>
					{/if}
					<td class="text-center">{$result.level nofilter}</td>
					<td class="text-center">{$result.total_order nofilter}</td>
					<td class="text-center">{$result.total_point nofilter}</td>
					<td class="text-center">{$result.total_friend nofilter}</td>
                    <td class="text-center">
                        <a class="btn btn-default btn btn-default eam-view-detail-aff-prd" href="{$result.link_view|escape:'html':'UTF-8'}" title="{l s='View details' mod='ets_affiliatemarketing'}">{l s='View details' mod='ets_affiliatemarketing'}</a>
                    </td>
				</tr>
				{/foreach}
			{else}
				<tr class="text-center">
					<td colspan="100%">{l s='No data found' mod='ets_affiliatemarketing'}</td>
				</tr>
			{/if}
		</tbody>
	</table>
    
    <div class="eam-pagination-footer">
    	{if $friends.total_page > 1}
            <div class="eam-pagination">
                <ul>
                    {if $friends.current_page > 1}
    					<li>
    						<a href="javascript:void(0)" data-page="{$friends.current_page - 1|escape:'html':'UTF-8'}" class="js-eam-page-item">{l s='Previous' mod='ets_affiliatemarketing'}</a>
    					</li>
                    {/if}
                    {assign 'minRange' 1}
                    {assign 'maxRange' $friends.total_page}
                    {if $friends.total_page > 10}
                        {if $friends.current_page < ($friends.total_page - 3)}
                        {assign 'maxRange' $friends.current_page + 2}
                        {/if}
                        {if $friends.current_page > 3}
                        {assign 'minRange' $friends.current_page - 2}
                        {/if}
                    {/if}
                    {if $minRange > 1}
                    <li><span class="eam-page-3dot">...</span></li>
                    {/if}
                    {for $page=$minRange to $maxRange}
                        <li class="{if $page == $friends.current_page} active {/if}">
                            <a href="javascript:void(0)" data-page="{$page|escape:'html':'UTF-8'}" class="js-eam-page-item">{$page|escape:'html':'UTF-8'}</a>
                        </li>
                    {/for}
                    {if $maxRange < $friends.total_page}
                    <li><span class="eam-page-3dot">...</span></li>
                    {/if}
                    {if $friends.current_page < $friends.total_page}
    					<li>
    						<a href="javascript:void(0)" data-page="{$friends.current_page + 1|escape:'html':'UTF-8'}" class="js-eam-page-item">{l s='Next' mod='ets_affiliatemarketing'}</a>
    					</li>
                    {/if}
                </ul>
            </div>
         {/if}
         <div class="stat-filter eam-box-filter">
            <form class="form-inline" action="" method="post">
                <div class="row">
                    <div class="eam_select_filter col-mb-12">
                        <div>
                            <label>{l s='Time range' mod='ets_affiliatemarketing'}</label>
                            <select name="customer_sale_filter" class="form-control type_date_filter field-inline">
                                <option value="all_times"
                                        {if isset($query.customer_sale_filter) && $query.customer_sale_filter == 'all_times'}selected="selected"{/if}>{l s='All the time' mod='ets_affiliatemarketing'}</option>
                                <option value="this_month"
                                        {if isset($query.customer_sale_filter) && $query.customer_sale_filter == 'this_month'}selected="selected"{/if}>{l s="This month" mod='ets_affiliatemarketing'} - {date('m/Y') nofilter}</option>
                                <option value="this_year"
                                        {if isset($query.customer_sale_filter) && $query.customer_sale_filter == 'this_year'}selected="selected"{/if}>{l s="This year" mod='ets_affiliatemarketing'} - {date('Y') nofilter}</option>
                            </select>
                        </div>
                    </div>
                    <div class="eam_action">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default js-btn-submit-filter"><i class="fa fa-search"></i> {l s='Filter' mod='ets_affiliatemarketing'}</button>
                            <button type="button" class="btn btn-default js-btn-reset-filter"><i class="fa fa-undo"></i> {l s='Reset' mod='ets_affiliatemarketing'}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>