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
    <div class="stats-container eam-dashboard-reward mt-15">
        <div class="panel-body">
            <div class="stats-box-info">
                <div class="row-5-col">
                    <div class="col-lg-2 col-no-padding">
                        <div class="box-info eam-turnover no-br js-type-info-stats" data-type="TURNOVER" data-bg="bg-blue">
                            <div class="box-inner active">
                                <h5 class="box-info-title">{l s='Turnovers' mod='ets_affiliatemarketing'}</h5>
                                <div class="box-info-content">
                                    {$score_counter.turnover nofilter}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-no-padding">
                        <div class="box-info eam-rewards no-br js-type-info-stats" data-type="REWARDS" data-bg="bg-green">
                            <div class="box-inner">
                                <h5 class="box-info-title">{l s='Rewards' mod='ets_affiliatemarketing'}</h5>
                                <div class="box-info-content">
                                    {$score_counter.total_earn nofilter}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-no-padding">
                        <div class="box-info eam-orders no-br js-type-info-stats" data-type="ORDERS" data-bg="bg-red">
                            <div class="box-inner">
                                <h5 class="box-info-title">{l s='Total order' mod='ets_affiliatemarketing'}</h5>
                                <div class="box-info-content">
                                    {$score_counter.total_order nofilter}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-no-padding">
                        <div class="box-info eam-views no-br js-type-info-stats" data-type="VIEWS" data-bg="bg-orange">
                            <div class="box-inner">
                                <h5 class="box-info-title">{l s='Views' mod='ets_affiliatemarketing'}</h5>
                                <div class="box-info-content">
                                    {$score_counter.view_count nofilter}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-no-padding">
                        <div class="box-info eam-conversion-rate no-br js-type-info-stats" data-type="CONVERSION_RATE" data-bg="bg-pink">
                            <div class="box-inner">
                                <h5 class="box-info-title">{l s='Conversion rate' mod='ets_affiliatemarketing'}</h5>
                                <div class="box-info-content">
                                    {$score_counter.conversion_rate nofilter}
                                </div>
                            </div>
                        </div>
                    </div>
                    {if isset($margin_percentage) && $margin_percentage !== false && $margin_percentage !== ''}
                        <div class="col-lg-2 col-no-padding">
                            <div class="box-info eam-net-profit js-type-info-stats" data-type="NET_PROFIT" data-bg="bg-violet">
                                <div class="box-inner">
                                    <h5 class="box-info-title">{l s='Net profit' mod='ets_affiliatemarketing'}</h5>
                                    <div class="box-info-content">
                                        {$score_counter.net_profit nofilter}
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
            <div class="stats-data-reward">
                <div class="stats-container">
                    <div class="stats-body">
                        <div class="stats-loading">
                            <div class="loading-text">
                                {l s='Loading...' mod='ets_affiliatemarketing'}
                            </div>
                        </div>
                        <div id="eam_aff_stats">
                            <svg width="100%" height="500" class="fs-12"></svg>
                        </div>
                    </div>
                    <div class="stat-filter eam-box-filter stats-data-reward eam-product-sale-stats">
                        <form class="form-inline" action="" method="post">
                            <div class="row">
                                <div class="eam_select_filter col-lg-5">
                                    <div>
                                        <label>{l s='Time range' mod='ets_affiliatemarketing'}</label>
                                        <select name="type_date_filter" class="form-control field-inline">
                                            <option value="this_month"
                                                    selected="selected">{l s="This month" mod='ets_affiliatemarketing'} - {date('m/Y') nofilter}</option>
                                            <option value="this_year">{l s="This year" mod='ets_affiliatemarketing'} - {date('Y') nofilter}</option>
                                            <option value="all_times">{l s='All the time' mod='ets_affiliatemarketing'}</option>
                                            <option value="time_ranger">{l s='Time range' mod='ets_affiliatemarketing'}</option>
                                        </select>
                                        <div class="box-date-ranger">
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
                                <div class="eam_action ">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default btn-block product-sales-filter">
                                            <i class="fa fa-search"></i> {l s='Filter' mod='ets_affiliatemarketing'}
                                        </button>
                                        <button type="button" class="btn btn-default btn-block product-sales-reset">
                                            <i class="fa fa-undo"></i> {l s='Reset' mod='ets_affiliatemarketing'}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    var ets_am_product_stats = JSON.parse({$ets_am_product_stats|@json_encode nofilter});
    var ets_am_currency_sign = "{if is_array($currency)}{$currency.sign|escape:'html':'UTF-8'}{else}{$currency->sign|escape:'html':'UTF-8'}{/if}";
    var eam_chart_day = "{l s='Day' mod='ets_affiliatemarketing'}";
    var eam_chart_month = "{l s='Month' mod='ets_affiliatemarketing'}";
    var eam_chart_year = "{l s='Year' mod='ets_affiliatemarketing'}";
    var eam_chart_currency_code = "{$eam_currency_code|escape:'html':'UTF-8'}";
</script>