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

<div class="content mt-15 clearfix">
    <div class="eam-dashboard ">
        <h4 class="text-uppercase fs-14 mb-15">{l s='Product sales' mod='ets_affiliatemarketing'}</h4>
        <div class="table-responsive">
            <table class="table eam-table-flat">
                <thead>
                <tr>
                {if $ETS_AM_DISPLAY_ID_ORDER}
                    <th>{l s='Order ID' mod='ets_affiliatemarketing'}</th>
                {/if}
                <th>{l s='Reference' mod='ets_affiliatemarketing'}</th>
                    {if Configuration::get('ETS_AM_REF_DISPLAY_NAME_SPONSOR')}
                        <th class="text-center">{l s='Customer name' mod='ets_affiliatemarketing'}</th>
                    {/if}
                    {if Configuration::get('ETS_AM_REF_DISPLAY_EMAIL_SPONSOR')}
                        <th class="text-center">{l s='Customer email' mod='ets_affiliatemarketing'}</th>
                    {/if}
                    <th class="text-center">{l s='Order date' mod='ets_affiliatemarketing'}</th>
                    <th class="text-center">{l s='Sales' mod='ets_affiliatemarketing'}</th>
                    <th class="text-center">{l s='Earning rewards' mod='ets_affiliatemarketing'}</th>
                    <th class="text-center">{l s='Reward status' mod='ets_affiliatemarketing'}</th>
                </tr>
                </thead>
                <tbody>
                {if count($ets_am_customer_orders.results)}
                    {foreach from=$ets_am_customer_orders.results item=sale}
                        <tr>
                            {if $ETS_AM_DISPLAY_ID_ORDER}
                                <td>{$sale.id_order|intval}</td>
                            {/if}
                            <td>{$sale.reference|escape:'html':'UTF-8'}</td>
                            {if Configuration::get('ETS_AM_REF_DISPLAY_NAME_SPONSOR')}
                                <td class="text-center">{$sale.customer_name nofilter}</td>
                            {/if}
                            {if Configuration::get('ETS_AM_REF_DISPLAY_EMAIL_SPONSOR')}
                                <td class="text-center">{$sale.customer_email nofilter}</td>
                            {/if}
                            <td class="text-center">{$sale.datetime_added nofilter}</td>
                            <td class="text-center">{$sale.quantity|intval}</td>
                            <td class="text-center">{$sale.earning_reward nofilter}</td>
                            <td class="text-center">
                                {if $sale.reward_status == 1}
                                    <span class="label label-success">{l s='Approved' mod='ets_affiliatemarketing'}</span>
                                {elseif  $sale.reward_status == 0}
                                    <span class="label label-warning">{l s='Pending' mod='ets_affiliatemarketing'}</span>
                                {elseif  $sale.reward_status == -1}
                                    <span class="label label-default">{l s='Canceled' mod='ets_affiliatemarketing'}</span>
                                {else}
                                    <span class="label label-danger">{l s='Deleted' mod='ets_affiliatemarketing'}</span>
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
            </table>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <a href="{$my_sale_url nofilter}" title="" class="btn btn-default eam-btn-back-link mb-15"><i class="fa fa-arrow-circle-left"></i> {l s='Back' mod='ets_affiliatemarketing'}</a>
            </div>
            <div class="col-lg-8">
                {if $ets_am_customer_orders.total_page > 1}
                    <div class="eam-pagination">
                        <ul>
                            {if $ets_am_customer_orders.current_page > 1}
                                <li class="{if $ets_am_customer_orders.current_page == 1} active {/if}">
                                    <a href="javascript:void(0)" data-page="{$ets_am_customer_orders.current_page + 1 nofilter}" class="js-eam-page-item">{l s='Previous' mod='ets_affiliatemarketing'}</a>
                                </li>
                            {/if}
                            {assign 'minRange' 1}
                            {assign 'maxRange' $ets_am_customer_orders.total_page}
                            {if $ets_am_customer_orders.total_page > 10}
                                {if $ets_am_customer_orders.current_page < ($ets_am_customer_orders.total_page - 3)}
                                    {assign 'maxRange' $ets_am_customer_orders.current_page + 2}
                                {/if}
                                {if $ets_am_customer_orders.current_page > 3}
                                    {assign 'minRange' $ets_am_customer_orders.current_page - 2}
                                {/if}
                            {/if}
                            {if $minRange > 1}
                                <li><span class="eam-page-3dot">...</span></li>
                            {/if}
                            {for $page=$minRange to $maxRange}
                                <li class="{if $page == $ets_am_customer_orders.current_page} active {/if}">
                                    <a href="javascript:void(0)" data-page="{$page|escape:'html':'UTF-8'}"
                                       class="js-eam-page-item">{$page|escape:'html':'UTF-8'}</a>
                                </li>
                            {/for}
                            {if $maxRange < $ets_am_customer_orders.total_page}
                                <li><span class="eam-page-3dot">...</span></li>
                            {/if}
                            {if $ets_am_customer_orders.current_page < $ets_am_customer_orders.total_page}
                                <li>
                                    <a href="javascript:void(0)" data-page="{$ets_am_customer_orders.current_page + 1|escape:'html':'UTF-8'}"
                                       class="js-eam-page-item">{l s='Next' mod='ets_affiliatemarketing'} </a>
                                </li>
                            {/if}
                        </ul>
                    </div>
                {/if}
            </div>
        </div>
        <div class="stat-filter eam-box-filter">
            <form class="form-inline" action="" method="post">
                <div class="row">
                    <div class="eam_select_filter">
                        <label>{l s='Status' mod='ets_affiliatemarketing'}</label>
                        <select name="product_sale_status" class="form-control">
                            <option value="all"
                                    {if isset($query.product_sale_status) && $query.product_sale_status == 'all'} selected="selected"{/if}>{l s='All' mod='ets_affiliatemarketing'}</option>
                            <option value="approved"
                                    {if isset($query.product_sale_status) && $query.product_sale_status == 'approved'} selected="selected" {/if}>{l s='Approved' mod='ets_affiliatemarketing'}</option>
                            <option value="pending"
                                    {if isset($query.product_sale_status) && $query.product_sale_status == 'pending'} selected="selected" {/if}>{l s='Pending' mod='ets_affiliatemarketing'}</option>
                            <option value="canceled"
                                    {if isset($query.product_sale_status) && $query.product_sale_status == 'canceled'} selected="selected" {/if}>{l s='Canceled' mod='ets_affiliatemarketing'}</option>
                        </select>
                    </div>
                    <div class="eam_select_filter col-mb-12">
                        <div>
                            <label>{l s='Time range' mod='ets_affiliatemarketing'}</label>
                            <select name="product_sale_filter" class="form-control type_date_filter field-inline">
                                <option value="this_month"
                                        {if isset($query.product_sale_filter) && $query.product_sale_filter == 'this_month'}selected="selected"{/if}>{l s="This month" mod='ets_affiliatemarketing'} - {date('m/Y') nofilter}</option>
                                <option value="this_year"
                                        {if isset($query.product_sale_filter) && $query.product_sale_filter == 'this_year'}selected="selected"{/if}>{l s="This year" mod='ets_affiliatemarketing'} - {date('Y') nofilter}</option>
                                <option value="all_times"
                                        {if isset($query.product_sale_filter) && $query.product_sale_filter == 'all_times'}selected="selected"{/if}>{l s='All the time' mod='ets_affiliatemarketing'}</option>
                                <option value="time_ranger"
                                        {if isset($query.product_sale_filter) && $query.product_sale_filter == 'time_ranger'}selected="selected"{/if}>{l s='Time range' mod='ets_affiliatemarketing'}</option>
                            </select>
                            <div class="box-date-ranger ">
                                <input type="text" name="product_sale_ranger"
                                       value="{if isset($query.product_sale_from) && $query.product_sale_from && isset($query.product_sale_from) && $query.product_sale_from}{date('Y/m/d', strtotime($query.product_sale_from)) nofilter} - {date('Y/m/d', strtotime($query.product_sale_to)) nofilter}{/if}"
                                       class="form-control eam_date_ranger_filter">
                                <input type="hidden" name="product_sale_from" class="date_from_reward"
                                       value="{if isset($query.product_sale_from) && $query.product_sale_from}{date('Y-m-d', strtotime($query.date_from_reward)) nofilter}{else}{date('Y-m-01') nofilter}{/if}">
                                <input type="hidden" name="product_sale_to" class="date_to_reward"
                                       value="{if isset($query.product_sale_to) && $query.product_sale_to}{date('Y-m-d', strtotime($query.product_sale_to)) nofilter}{else}{date('Y-m-t') nofilter}{/if}">
                            </div>
                        </div>
                    </div>
                    <div class="eam_action">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default js-btn-submit-filter"><i
                                        class="fa fa-search"></i> {l s='Filter' mod='ets_affiliatemarketing'}</button>
                            <button type="button" class="btn btn-default js-btn-reset-filter"><i
                                        class="fa fa-undo"></i> {l s='Reset' mod='ets_affiliatemarketing'}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
