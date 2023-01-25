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
    <table class="table table-striped eam-table-data eam_no_border table-label-custom">
        <thead>
        <tr>
            <th>{l s='Reward ID' mod='ets_affiliatemarketing'}</th>
            <th>{l s='Reward value' mod='ets_affiliatemarketing'}</th>
            <th>{l s='Products' mod='ets_affiliatemarketing'}</th>
            <th class="text-center">{l s='Status' mod='ets_affiliatemarketing'}</th>
            <th>{l s='Note' mod='ets_affiliatemarketing'}</th>
            <th>{l s='Date' mod='ets_affiliatemarketing'}</th>
        </tr>
        </thead>
        <tbody>
        {if $reward_history.results}
            {foreach $reward_history.results as $reward}
                <tr>
                    <td>{$reward.id_ets_am_reward nofilter}</td>
                    <td>{$reward.amount nofilter}</td>
                    <td>{$reward.products nofilter}</td>
                    <td class="text-center">{$reward.status nofilter}</td>
                    <td>{$reward.note nofilter}</td>
                    <td>{$reward.datetime_added nofilter}</td>
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
    {if $reward_history.total_page > 1}
        <div class="eam-pagination">
            <ul>
                {if $reward_history.current_page > 1}
                    <li class="{if $reward_history.current_page == 1} active {/if}">
                        <a href="javascript:void(0)" data-page="{$reward_history.current_page - 1 nofilter}" class="js-eam-page-item">{l s='Previous' mod='ets_affiliatemarketing'}</a>
                    </li>
                {/if}
                {assign 'minRange' 1}
                {assign 'maxRange' $reward_history.total_page}
                {if $reward_history.total_page > 10}
                    {if $reward_history.current_page < ($reward_history.total_page - 3)}
                        {assign 'maxRange' $reward_history.current_page + 2}
                    {/if}
                    {if $reward_history.current_page > 3}
                        {assign 'minRange' $reward_history.current_page - 2}
                    {/if}
                {/if}
                {if $minRange > 1}
                    <li><span class="eam-page-3dot">...</span></li>
                {/if}
                {for $page=$minRange to $maxRange}
                    <li class="{if $page == $reward_history.current_page} active {/if}">
                        <a href="javascript:void(0)" data-page="{$page|escape:'html':'UTF-8'}"
                           class="js-eam-page-item">{$page|escape:'html':'UTF-8'}</a>
                    </li>
                {/for}
                {if $maxRange < $reward_history.total_page}
                    <li><span class="eam-page-3dot">...</span></li>
                {/if}
                {if $reward_history.current_page < $reward_history.total_page}
                    <li>
                        <a href="javascript:void(0)" data-page="{$reward_history.current_page + 1|escape:'html':'UTF-8'}"
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
            <div class="col-lg-4 col-xs-12">
                <label>{l s='Reward status' mod='ets_affiliatemarketing'}</label>
                <select name="status" class="form-control">
                    <option value="all"
                            {if isset($query.status) && $query.status === 'all'}selected="selected"{/if}>{l s='All' mod='ets_affiliatemarketing'}</option>
                    <option value="1"
                            {if isset($query.status) && $query.status === 1}selected="selected"{/if}>{l s='Approved' mod='ets_affiliatemarketing'}</option>
                    <option value="0"
                            {if isset($query.status) && $query.status === 0}selected="selected"{/if}>{l s='Pending' mod='ets_affiliatemarketing'}</option>
                    <option value="-1"
                            {if isset($query.status) && $query.status === -1}selected="selected"{/if}>{l s='Canceled' mod='ets_affiliatemarketing'}</option>
                    <option value="-2"
                            {if isset($query.status) && $query.status === -2}selected="selected"{/if}>{l s='Expired' mod='ets_affiliatemarketing'}</option>
                </select>
            </div>
            <div class="col-lg-6 col-xs-12">
                <div>
                    <label>{l s='Time range' mod='ets_affiliatemarketing'}</label>
                    <select name="type_date_filter" class="form-control field-inline">
                        <option value="this_month"
                                {if isset($query.type_date_filter) && $query.type_date_filter == 'this_month'}selected="selected"{/if}>{l s="This month" mod='ets_affiliatemarketing'} - {date('m/Y') nofilter}</option>
                        <option value="this_year"
                                {if isset($query.type_date_filter) && $query.type_date_filter == 'this_year'}selected="selected"{/if}>{l s="This year" mod='ets_affiliatemarketing'} - {date('Y') nofilter}</option>
                        <option value="all_times"
                                {if isset($query.type_date_filter) && $query.type_date_filter == 'all_times'}selected="selected"{/if}>{l s='All the time' mod='ets_affiliatemarketing'}</option>
                        <option value="time_ranger"
                                {if isset($query.type_date_filter) && $query.type_date_filter == 'time_ranger'}selected="selected"{/if}>{l s='Time range' mod='ets_affiliatemarketing'}</option>
                    </select>
                    <div class="box-date-ranger"
                         {if isset($query.type_date_filter) && $query.type_date_filter == 'time_ranger'}style="display-block;"{/if}>
                        <input type="text" name="date_ranger" value=""
                               class="form-control eam_date_ranger_filter">
                        <input type="hidden" name="date_from_reward"
                               class="date_from_reward"
                               value="{date('Y-m-01') nofilter}">
                        <input type="hidden" name="date_to_reward"
                               class="date_to_reward"
                               value="{date('Y-m-t') nofilter}">
                        <input type="hidden" name="type_stats" value="reward">
                    </div>
                </div>
            </div>

            <div class="eam_action">
                <div class="form-group">
                    <button type="submit"
                            class="btn btn-default btn-block js-btn-submit-filter"><i
                                class="fa fa-search"></i> {l s='Filter' mod='ets_affiliatemarketing'}
                    </button>
                    <button type="button"
                            class="btn btn-default btn-block js-btn-reset-filter"><i
                                class="fa fa-undo"></i> {l s='Reset' mod='ets_affiliatemarketing'}
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>


