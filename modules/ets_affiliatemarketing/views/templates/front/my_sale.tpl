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

<div class="table-responsive">
    <table class="table table-hover eam-table-flat">
        <thead>
        <tr>
            <th style="white-space: nowrap;">
                {l s='ID' mod='ets_affiliatemarketing'}
                <a href="javascript:void(0)" title=""
                   class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'id_product'}active{/if}"
                   data-order-by="id_product" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
                <a href="javascript:void(0)" title=""
                   class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'id_product'}active{/if}"
                   data-order-by="id_product" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
            </th>
            <th>
                {l s='Product' mod='ets_affiliatemarketing'}
                <a href="javascript:void(0)" title=""
                   class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'product_name'}active{/if}"
                   data-order-by="product_name" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
                <a href="javascript:void(0)" title=""
                   class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'product_name'}active{/if}"
                   data-order-by="product_name" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
            </th>
            <th class="text-center" style="min-width: 120px; max-width: 120px; white-space: normal; ">
                {l s='Sales' mod='ets_affiliatemarketing'}
                <a href="javascript:void(0)" title=""
                   class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'number_sales'}active{/if}"
                   data-order-by="number_sales" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
                <a href="javascript:void(0)" title=""
                   class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'number_sales'}active{/if}"
                   data-order-by="number_sales" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
            </th>
           <th class="text-center" style="min-width: 120px; max-width: 120px; white-space: normal; ">
                {l s='Orders' mod='ets_affiliatemarketing'}
                <a href="javascript:void(0)" title=""
                   class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'number_orders'}active{/if}"
                   data-order-by="number_orders" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
                <a href="javascript:void(0)" title=""
                   class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'number_orders'}active{/if}"
                   data-order-by="number_orders" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
            </th>
            <th class="text-center">
                {l s='Earning rewards' mod='ets_affiliatemarketing'}
                <a href="javascript:void(0)" title=""
                   class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'earning_rewards'}active{/if}"
                   data-order-by="earning_rewards" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
                <a href="javascript:void(0)" title=""
                   class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'earning_rewards'}active{/if}"
                   data-order-by="earning_rewards" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
            </th>
            <th class="text-center">
                {l s='Views' mod='ets_affiliatemarketing'}
                <a href="javascript:void(0)" title=""
                   class="eam-sort-desc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'DESC' && isset($query.orderBy) && $query.orderBy == 'total_views'}active{/if}"
                   data-order-by="total_views" data-order-way="DESC"><i class="fa fa-sort-desc"></i></a>
                <a href="javascript:void(0)" title=""
                   class="eam-sort-asc js-eam-order-data {if isset($query.orderWay) && $query.orderWay == 'ASC' && isset($query.orderBy) && $query.orderBy == 'total_views'}active{/if}"
                   data-order-by="total_views" data-order-way="ASC"><i class="fa fa-sort-asc"></i></a>
            </th>
            <th class="text-center">
                {l s='Conversion Rate' mod='ets_affiliatemarketing'}
            </th>
            <th class="text-center">{l s='Action' mod='ets_affiliatemarketing'}</th>
        </tr>
        </thead>
        <tbody>
        {if count($ets_am_sales.results)}
            {foreach from=$ets_am_sales.results item=sale}
                <tr>
                    <td>{$sale.id_product nofilter}</td>
                    <td>
                        <a target="_blank" href="{$sale.link nofilter}">{$sale.product_name nofilter}</a>
                    </td>
                    <td class="text-center">{$sale.number_sales nofilter}</td>
                    <td class="text-center">{$sale.number_orders nofilter}</td>
                    <td class="text-center">{$sale.display_total_earn nofilter}</td>
                    <td class="text-center">{$sale.view_count nofilter}</td>
                    <td class="text-center">{$sale.c_rate nofilter}</td>
                    <td class="text-center">
                        {if $sale.action|is_array && $sale.action}
                          <a href="{$sale.action.link nofilter}" class="{$sale.action.class|escape:'html':'UTF-8'} btn btn-default eam-view-detail-aff-prd" title="{l s='View details' mod='ets_affiliatemarketing'}">{l s='View details' mod='ets_affiliatemarketing'}</a>
                        {/if}
                    </td>
                </tr>
            {/foreach}
        {else}
            <tr class="text-center">
                <td colspan="100%">
                    {l s='No data was found.' mod='ets_affiliatemarketing'}
                </td>
            </tr>
        {/if}
        </tbody>
        <tfoot>
        <tr>
            <td colspan="8" class="text-right font-weight-bold font-weight-bold">{l s='Total earning rewards: ' mod='ets_affiliatemarketing'}{$ets_am_sales.total_filter nofilter}</td>        
        </tr>
        </tfoot>
    </table>
</div>
<div class="row">
  <div class="col-lg-8">
    {if $ets_am_sales.total_page > 1}
      <div class="eam-pagination">
          <ul style="margin-top: 0px;">
              {if $ets_am_sales.current_page > 1}
                  <li class="{if $ets_am_sales.current_page == 1} active {/if}">
                      <a href="javascript:void(0)" data-page="{$ets_am_sales.current_page - 1 nofilter}" class="js-eam-page-item">{l s='Previous' mod='ets_affiliatemarketing'}</a>
                  </li>
              {/if}
              {assign 'minRange' 1}
              {assign 'maxRange' $ets_am_sales.total_page}
              {if $ets_am_sales.total_page > 10}
                  {if $ets_am_sales.current_page < ($ets_am_sales.total_page - 3)}
                      {assign 'maxRange' $ets_am_sales.current_page + 2}
                  {/if}
                  {if $ets_am_sales.current_page > 3}
                      {assign 'minRange' $ets_am_sales.current_page - 2}
                  {/if}
              {/if}
              {if $minRange > 1}
                  <li><span class="eam-page-3dot">...</span></li>
              {/if}
              {for $page=$minRange to $maxRange}
                  <li class="{if $page == $ets_am_sales.current_page} active {/if}">
                      <a href="javascript:void(0)" data-page="{$page nofilter}"
                         class="js-eam-page-item">{$page nofilter}</a>
                  </li>
              {/for}
              {if $maxRange < $ets_am_sales.total_page}
                  <li><span class="eam-page-3dot">...</span></li>
              {/if}
              {if $ets_am_sales.current_page < $ets_am_sales.total_page}
                  <li>
                      <a href="javascript:void(0)" data-page="{$ets_am_sales.current_page + 1 nofilter}"
                         class="js-eam-page-item">{l s='Next' mod='ets_affiliatemarketing'} </a>
                  </li>
              {/if}
          </ul>
      </div>
    {/if}
  </div>
  <div class="stat-filter eam-box-filter">
    <form class="form-inline" action="" method="post">
        <div class="row">
            <div class="eam_select_filter col-mb-12">
                <div>
                    <label>{l s='Time range' mod='ets_affiliatemarketing'}</label>
                    <select class="form-control type_date_filter field-inline" name="type_date_filter">
                        <option value="all_times"
                                {if isset($query.type_date_filter) && $query.type_date_filter == 'all_times'}selected="selected"{/if}>{l s='All the time' mod='ets_affiliatemarketing'}</option>
                        <option value="this_month"
                                {if isset($query.type_date_filter) && $query.type_date_filter == 'this_month'}selected="selected"{/if}>{l s="This month" mod='ets_affiliatemarketing'} - {date('m/Y') nofilter}</option>
                        <option value="this_year"
                                {if isset($query.type_date_filter) && $query.type_date_filter == 'this_year'}selected="selected"{/if}>{l s="This year" mod='ets_affiliatemarketing'} - {date('Y') nofilter}</option>
                    </select>
                </div>
            </div>
            <div class="eam_action">
                <div class="form-group">
                    <button class="btn btn-default js-btn-submit-filter" type="submit">
                        <i class="fa fa-search"></i>
                        {l s='Filter' mod='ets_affiliatemarketing'}
                    </button>
                    <button class="btn btn-default js-btn-reset-filter" type="button">
                        <i class="fa fa-undo"></i>
                        {l s='Reset' mod='ets_affiliatemarketing'}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
