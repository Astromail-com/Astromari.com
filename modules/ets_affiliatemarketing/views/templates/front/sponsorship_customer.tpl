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

<div class="row">
    <div class="col-lg-8">
        <div class="product_info">
            {if Configuration::get('ETS_AM_REF_DISPLAY_NAME_SPONSOR')}
                <p class="mb-5">
                    <strong>{l s='Customer' mod='ets_affiliatemarketing'}: </strong>
                    {$customer_info.firstname|escape:'html':'UTF-8'} {$customer_info.lastname|escape:'html':'UTF-8'}
                </p>
            {/if}
            {if Configuration::get('ETS_AM_REF_DISPLAY_EMAIL_SPONSOR')}
                <p class="mb-5">
                    <strong>{l s='Email' mod='ets_affiliatemarketing'}: </strong>
                    {$customer_info.email|escape:'html':'UTF-8'}
                </p>
            {/if}
            <p class="mb-5">
                <strong>{l s='Level' mod='ets_affiliatemarketing'}: </strong>
                {$customer_info.level|intval}{if isset($customer_info.price_register) && $customer_info.price_register} ({l s='You got' mod='ets_affiliatemarketing'} {$customer_info.price_register|escape:'html':'UTF-8'} {l s='on registration' mod='ets_affiliatemarketing'}){/if}
            </p>
            <p class="mb-5">
                <strong>{l s='Orders' mod='ets_affiliatemarketing'}: </strong>
                {$customer_info.orders|intval}
            </p>
            <p class="mb-5">
                <strong>{l s='Friend(s) (All levels)' mod='ets_affiliatemarketing'}: </strong>
                {$customer_info.friends|intval}
            </p>
            <p class="mb-5">
                <strong>{l s='Date of registration' mod='ets_affiliatemarketing'}: </strong>
                {$customer_info.date_add|escape:'html':'UTF-8'}
            </p>
        </div>
    </div>
</div>
<div class="content mt-15 clearfix">
    <div class="eam-dashboard ">
        <h4 class="text-uppercase fs-14 mb-15">{l s='Order history' mod='ets_affiliatemarketing'}</h4>
        <div class="table-responsive">
            <table class="table eam-table-flat">
                <thead>
                <tr>
                    {if $ETS_AM_DISPLAY_ID_ORDER}
                        <td>{l s='Order ID' mod='ets_affiliatemarketing'}</td>
                    {/if}
                    <td>{l s='Reference' mod='ets_affiliatemarketing'}</td>
                    <td>{l s='Order date' mod='ets_affiliatemarketing'}</td>
                    <td>{l s='Total spent' mod='ets_affiliatemarketing'}</td>
                    <td>{l s='Earning rewards' mod='ets_affiliatemarketing'}</td>
                    <td>{l s='Reward status' mod='ets_affiliatemarketing'}</td>
                </tr>
                </thead>
                <tbody>
                {if $customer_info.list_orders}
                    {foreach from=$customer_info.list_orders item='order'}
                        <tr>
                            {if $ETS_AM_DISPLAY_ID_ORDER}
                                <td>{$order.id_order|intval}</td>
                            {/if}
                            <td>{$order.reference|escape:'html':'UTF-8'}</td>
                            <td>{$order.date_add|escape:'html':'UTF-8'}</td>
                            <td>{$order.total_paid_tax_incl|escape:'html':'UTF-8'}</td>
                            <td>{$order.amount|escape:'html':'UTF-8'}</td>
                            <td>
                                {if $order.status == 1}
                                    <span class="label label-success">{l s='Approved' mod='ets_affiliatemarketing'}</span>
                                {elseif  $order.status == 0}
                                    <span class="label label-warning">{l s='Pending' mod='ets_affiliatemarketing'}</span>
                                {elseif  $order.status == -1}
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
        <div class="row action-back">
            <div class="col-lg-4">
                <a href="{$link_back|escape:'html':'UTF-8'}" title="" class="btn btn-default eam-btn-back-link mb-15"><i
                            class="fa fa-arrow-circle-left"></i> {l s='Back' mod='ets_affiliatemarketing'}</a>
            </div>
            <div class="col-lg-8"></div>
        </div>
        <div class="stat-filter eam-box-filter">
            <form class="form-inline" action="" method="post">
                <div class="row">
                    <div class="eam_select_filter">
                        <label>{l s='Status' mod='ets_affiliatemarketing'}</label>
                        <select name="order_sale_status" class="form-control">
                            <option value=""
                                    {if isset($query.order_sale_status) && $query.order_sale_status ===''} selected="selected"{/if}>{l s='All' mod='ets_affiliatemarketing'}</option>
                            <option value="1"
                                    {if isset($query.order_sale_status) && $query.order_sale_status == 1} selected="selected" {/if}>{l s='Approved' mod='ets_affiliatemarketing'}</option>
                            <option value="0"
                                    {if isset($query.order_sale_status) && $query.order_sale_status ==='0'} selected="selected" {/if}>{l s='Pending' mod='ets_affiliatemarketing'}</option>
                            <option value="-1"
                                    {if isset($query.order_sale_status) && $query.order_sale_status == -1} selected="selected" {/if}>{l s='Canceled' mod='ets_affiliatemarketing'}</option>
                        </select>
                    </div>
                    <div class="eam_select_filter col-mb-12">
                        <div>
                            <label>{l s='Time range' mod='ets_affiliatemarketing'}</label>
                            <select name="order_sale_filter" class="form-control type_date_filter field-inline">
                                <option value="all_times"
                                        {if isset($query.order_sale_filter) && $query.order_sale_filter == 'all_times'}selected="selected"{/if}>{l s='All the time' mod='ets_affiliatemarketing'}</option>
                                <option value="this_month"
                                        {if isset($query.order_sale_filter) && $query.order_sale_filter == 'this_month'}selected="selected"{/if}>{l s="This month" mod='ets_affiliatemarketing'}
                                    - {date('m/Y') nofilter}</option>
                                <option value="this_year"
                                        {if isset($query.order_sale_filter) && $query.order_sale_filter == 'this_year'}selected="selected"{/if}>{l s="This year" mod='ets_affiliatemarketing'}
                                    - {date('Y') nofilter}</option>
                            </select>
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