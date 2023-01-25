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
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
<script type="text/javascript">
    var ets_snw_link_ajax = "{$link_tab nofilter}";
    var ets_snw_msg_tagged = "{l s='has been tagged' mod='ets_affiliatemarketing' js='1'}";
    var ets_snw_suffix_level = "{l s='% of remaining sponsor cost after paying for higher levels' mod='ets_affiliatemarketing'}";
    var ets_snw_dumplicate_msg = "{l s='Duplicate item' mod='ets_affiliatemarketing'}";
    var ets_snw_date_msg = "{l s='To date must be greater than From date' mod='ets_affiliatemarketing'}";
    var ets_swn_currency_code = "{$currency->iso_code|escape:'html':'UTF-8'}";
    var ets_swn_chart_day = "{l s='Day' mod='ets_affiliatemarketing'}";
    var ets_swn_chart_month = "{l s='Month' mod='ets_affiliatemarketing'}";
    var ets_swn_chart_year = "{l s='Year' mod='ets_affiliatemarketing'}";
    var ets_snw_sub_level_desc = "{l s='Leave blank to not give reward to this level when new order is created' mod='ets_affiliatemarketing'}";
    var ets_swn_trans = [];
        ets_swn_trans['add_payment_method'] = "{l s='Add payment method' mod='ets_affiliatemarketing'}";
        ets_swn_trans['add_payment_method_field'] = "{l s='Add payment method field' mod='ets_affiliatemarketing'}";
        ets_swn_trans['method_field_title'] = "{l s='Method field title' mod='ets_affiliatemarketing'}";
        ets_swn_trans['method_field_type'] = "{l s='Method field type' mod='ets_affiliatemarketing'}";
        ets_swn_trans['method_name'] = "{l s='Method name' mod='ets_affiliatemarketing'}";
        ets_swn_trans['delete'] = "{l s='Delete' mod='ets_affiliatemarketing'}";
        ets_swn_trans['fee_type'] = "{l s='Fee type' mod='ets_affiliatemarketing'}";
        ets_swn_trans['fee_fixed'] = "{l s='Fee amount (fixed value)' mod='ets_affiliatemarketing'}";
        ets_swn_trans['fee_percent'] = "{l s='Fee amount (percentage)' mod='ets_affiliatemarketing'}";
        ets_swn_trans['enable'] = "{l s='Enabled' mod='ets_affiliatemarketing'}";
        ets_swn_trans['yes'] = "{l s='Yes' mod='ets_affiliatemarketing'}";
        ets_swn_trans['no'] = "{l s='No' mod='ets_affiliatemarketing'}";
        ets_swn_trans['percent'] = "{l s='Percentage' mod='ets_affiliatemarketing'}";
        ets_swn_trans['fixed'] = "{l s='Fixed' mod='ets_affiliatemarketing'}";
        ets_swn_trans['times'] = "{l s='Time' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_delete'] = "{l s='Do you want to delete this item?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['loading'] = "{l s='Loading...' mod='ets_affiliatemarketing'}";
        ets_swn_trans['description'] = "{l s='Description' mod='ets_affiliatemarketing'}";
        ets_swn_trans['required'] = "{l s='Required' mod='ets_affiliatemarketing'}";
        ets_swn_trans['day'] = "{l s='Day' mod='ets_affiliatemarketing'}";
        ets_swn_trans['month'] = "{l s='Month' mod='ets_affiliatemarketing'}";
        ets_swn_trans['year'] = "{l s='Year' mod='ets_affiliatemarketing'}";
        ets_swn_trans['filter'] = "{l s='Filter' mod='ets_affiliatemarketing'}";
        ets_swn_trans['pm_fee_fixed_required'] = "{l s='Fixed fee of payment method is required' mod='ets_affiliatemarketing'}";
        ets_swn_trans['pm_fee_percent_required'] = "{l s='Fee percentage of payment method is required' mod='ets_affiliatemarketing'}";
        ets_swn_trans['pmf_title_required'] = "{l s='Title of payment method field is required' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_delete_reward'] = "{l s='Do you want to delete this reward?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_cancel_reward'] = "{l s='Do you want to cancel this reward?' mod='ets_affiliatemarketing'}";
         ets_swn_trans['confirm_refund_reward'] = "{l s='Do you want to refund this reward?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_suspend_user'] = "{l s='Do you want to suspend this user from using any marketing program?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_delete_withdrawal'] = "{l s='Do you want to delete this withdrawal?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_approve_withdrawal'] = "{l s='Do you want to approve this withdrawal?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_decline_return_withdrawal'] = "{l s='Do you want to decline with return reward this withdrawal?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_decline_deduct_withdrawal'] = "{l s='Do you want to decline with deduct reward this withdrawal?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_delete_application'] = "{l s='Do you want to delete this application?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_delete_photo'] = "{l s='Do you want to delete this photo?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_approve_app'] = "{l s='Do you want to approve this application?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_suspend_app'] = "{l s='Do you want to suspend this application?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_decline_app'] = "{l s='Do you want to decline this application?' mod='ets_affiliatemarketing'}";
        ets_swn_trans['no_data'] = "{l s='No data found' mod='ets_affiliatemarketing'}";
        ets_swn_trans['clearing'] = "{l s='Clearing...' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_approve_program'] = "{l s='Do you want to approve this user from' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_suspend_program'] = "{l s='Do you want to suspend this user from' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_decline_program'] = "{l s='Do you want to decline this user from' mod='ets_affiliatemarketing'}";
        ets_swn_trans['affiliate_program'] = "{l s='Affliate program' mod='ets_affiliatemarketing'}";
        ets_swn_trans['referral_program'] = "{l s='Referral program' mod='ets_affiliatemarketing'}";
        ets_swn_trans['loyalty_program'] = "{l s='Loyalty program' mod='ets_affiliatemarketing'}";
        ets_swn_trans['confirm_clear_qrcode'] = '{l s='Do you want clear QR code cache?' mod='ets_affiliatemarketing' js=1}';
    var eam_cookie_filter = {$cookie_filter|json_encode};
    var eam_submit_error = {$submit_errors nofilter};
    var idRewardUser = "{if $idRewardUser}{$idRewardUser|escape:'html':'UTF-8'}{else}{/if}";

</script>
<style type="text/css">
.bootstrap > .module_confirmation.alert-success {
    display: none;
}
</style>
<div class="ets-sn-admin clearfix">
    <div class="ets-sn-admin__tabs">
        <ul class="tab-list nav">
            {assign 'desc_tab' ''}
            {foreach $setting_tabs as $key=>$tab}
                <li class="li_{$key|escape:'html':'UTF-8'}{if $key == $activetab || $menuActive == $key} active{/if}{if isset($tab.sub) && $tab.sub} has_sub{/if}" data-key="{$key|escape:'html':'UTF-8'}">
                    {if isset($tab.sub) && $tab.sub}
                        <a href="#">
                            {if isset($tab.img) && isset($linkImg) && $linkImg}
                                <img src="{$linkImg|escape:'html':'UTF-8'}{$tab.img|escape:'html':'UTF-8'}" alt="{$tab.img|escape:'html':'UTF-8'}">
                            {/if}
                            <span class="tab-title">{$tab.title|escape:'html':'UTF-8'}</span>
                            {if isset($tab.subtitle) && $tab.subtitle}<span class="tab-sub-title">{$tab.subtitle|escape:'html':'UTF-8'}</span>{/if}
                        </a>

                        <ul class="sub-nav-tab">
                            {foreach $tab.sub as $k=> $sub}
                                {assign 'tab_id' $k}
                                <li class="{$k|escape:'html':'UTF-8'} {if $k == $activetab} active{/if}" data-active="{$activetab|escape:'html':'UTF-8'}" data-key="{$k|escape:'html':'UTF-8'}">
                                    {if isset($sub.subtabs) && $sub.subtabs}
                                        {foreach $sub.subtabs as $sk=>$sv}
                                            {assign 'tab_id' $sk}
                                            {break}
                                        {/foreach}
                                        {foreach $sub.subtabs as $sk=>$sv}
                                            {if $sk == $activetab}
                                                {assign 'desc_tab' $sub.description}
                                                {break}
                                            {/if}
                                        {/foreach}
                                    {else}
                                        {if $k == $activetab && isset($sub.description)}
                                            {assign 'desc_tab' $sub.description}
                                        {/if}
                                    {/if}
                                    <a href="{$link_tab|escape:'html':'UTF-8'}&tabActive={$tab_id|escape:'html':'UTF-8'}">
                                        <span class="img-wrapper">
                                            <img src="{$linkImg|escape:'html':'UTF-8'}{$sub.img|escape:'html':'UTF-8'}" alt="{$sub.img|escape:'html':'UTF-8'}">
                                        </span>
                                        <span class="tab-info-wrapper">
                                            <span class="tab-title">{$sub.title|escape:'html':'UTF-8'}</span>
                                            <span class="tab-desc">{$sub.desc|escape:'html':'UTF-8'}</span>
                                        </span>
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    {else}
                        {assign 'tab_id' $key}
                        {if isset($tab.subtabs) && $tab.subtabs}

                            {foreach $tab.subtabs as $sk=>$sv}
                                {assign 'tab_id' $sk}
                                {break}
                            {/foreach}
                            {foreach $tab.subtabs as $sk=>$sv}
                                {if $sk == $activetab && isset($tab.description)}
                                    {assign 'desc_tab' $tab.description}
                                    {break}
                                {/if}
                            {/foreach}
                        {else}
                            {if $key == $activetab && isset($tab.description)}
                                {assign 'desc_tab' $tab.description}
                            {/if}

                        {/if}
                        <a href="{if isset($tab.link)}{$tab.link|escape:'html':'UTF-8'}{else}{$link_tab|escape:'html':'UTF-8'}&tabActive={$tab_id|escape:'html':'UTF-8'}{/if}"
                           {if isset($tab.target)}target="{$tab.target|escape:'html':'UTF-8'}" {/if}
                           class="{if isset($tab.class)}{$tab.class|escape:'html':'UTF-8'}{else}link_{$tab_id|escape:'html':'UTF-8'}{/if}">
                            {if isset($tab.img) && isset($linkImg) && $linkImg}
                                <img src="{$linkImg|escape:'html':'UTF-8'}{$tab.img|escape:'html':'UTF-8'}" alt="{$tab.img|escape:'html':'UTF-8'}" />
                            {/if}
                            <span class="tab-title">{$tab.title|escape:'html':'UTF-8'}</span>
                            {if isset($tab.subtitle) && $tab.subtitle}<span class="tab-sub-title">{$tab.subtitle|escape:'html':'UTF-8'}</span>{/if}
                        </a>
                    {/if}
                </li>
            {/foreach}
        </ul>
    </div>
    <div class="ets-sn-admin__tabs_height"></div>
    {* ========== BREAD CRUMB====== *}
    {foreach $breadcrumb_admin as $b}
        {if isset($b.subtabs)}
            {foreach $b.subtabs as $k => $t}
                {if isset($t.subtabs)}
                    {foreach $t.subtabs as $sk => $st}
                        {if $sk == $activetab}
                            <div class="eam-breadcrumb">
                                <a href="{$link_tab|escape:'html':'UTF-8'}&tabActive=dashboard" title="" class="eam-breadcrumb-item"><i class="fa fa-home"></i></a>
                                <span class="eam-breadcrumb-item"> {$b.title|escape:'html':'UTF-8'}</span>
                                <span class="eam-breadcrumb-item"> {$t.title|escape:'html':'UTF-8'}</span>
                            </div>
                            {break}
                        {/if}
                    {/foreach}
                {else}
                    {if $k == $activetab}
                        <div class="eam-breadcrumb">
                            <a href="{$link_tab|escape:'html':'UTF-8'}&tabActive=dashboard" title="" class="eam-breadcrumb-item"><i class="fa fa-home"></i></a>
                            <span class="eam-breadcrumb-item"> {$b.title|escape:'html':'UTF-8'}</span>
                            <span class="eam-breadcrumb-item"> {$t.title|escape:'html':'UTF-8'}</span>
                        </div>
                        {break}
                    {/if}
                {/if}
            {/foreach}
        {/if}
    {/foreach}
    {* ========== END BREAD CRUMB====== *}
    <div class="ets-sn-admin__content {if $activetab == 'applications' || $activetab == 'reward_history' || $activetab == 'reward_users' || $activetab == 'import_export' || $activetab == 'withdraw_list' } eam-no-tab {elseif  $activetab == 'dashboard'} eam-dashboard-page {/if}">
        {if $activetab !== 'dashboard'}
        <div class="title-content">
            <h1><i class="fa fa-{$caption.icon|escape:'html':'UTF-8'}"></i> {$caption.title|escape:'html':'UTF-8'} {if isset($id_data) && $id_data}#{$id_data|escape:'html':'UTF-8'}{/if}<span class="eam-sub-title">{$desc_tab|escape:'html':'UTF-8'}</span></h1>
        </div>
        {/if}

        {assign 'subtabs' []}
        {if !isset($config_tabs[$activetab])}
            {foreach $config_tabs as $key=>$tab}
                {if isset($tab.subtabs) && $tab.subtabs && in_array($activetab, array_keys($tab.subtabs))}

                    {assign 'subtabs' $tab.subtabs}
                    {break}
                {/if}
            {/foreach}
        {/if}
        {if $subtabs}
            <div class="ets-sn-admin__subtabs">
                <ul class="subtab-list">
                    {foreach $subtabs as $key=>$tab}
                        <li class="{if $activetab == $key} active {/if}">
                            <a href="{$link_tab|escape:'html':'UTF-8'}&tabActive={$key|escape:'html':'UTF-8'}" title="">
                                {if isset($tab.icon) && $tab.icon}
                                    <i class="fa fa-{$tab.icon|escape:'html':'UTF-8'}"></i>
                                {/if}
                                {$tab.title nofilter}
                                {if $key == $activetab}
                                <span class="eam-subtab-count-data"></span>
                                {/if}
                            </a>
                        </li>
                    {/foreach}
                </ul>
            </div>
        {/if}
        <div class="ets-sn-admin__body" {if $activetab == 'dashboard'}style="padding-top: 25px;"{/if}>

            {$html nofilter}
        </div>

    </div>
</div>
<script type="text/javascript" src="{$linkJs|escape:'html':'UTF-8'}"></script>