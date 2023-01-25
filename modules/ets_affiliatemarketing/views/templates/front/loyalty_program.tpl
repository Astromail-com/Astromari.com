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

{extends file='page.tpl'}
{block name='breadcrumb'}
    {$smarty.block.parent}
{/block}

{block name="page_content"}
    <div class="ets-am-program ets-am-content">
        <div class="navbar-page">
            <ul class="ets-am-content-links">
                <li class="list-title">
                    <h1 class="only-title"><i
                                class="fa fa-heart"></i> {l s='Loyalty program' mod='ets_affiliatemarketing'}</h1>
                </li>
            </ul>
        </div>
        <div class="ets-am-content">

            {if isset($alert_type) && $alert_type && $alert_type != 'REGISTERED'}
                <div class="mt-20">
                    {if $alert_type == 'ACCOUNT_BANNED'}
                        <div class="alert alert-warning">
                            {l s='Your account has been banned.' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'PROGRAM_DECLINED'}
                        <div class="alert alert-warning">
                            {l s='Your application was declined' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'PROGRAM_SUSPENDED'}
                        <div class="alert alert-warning">
                            {l s='You has been suspended from using this program.' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'NOT_REQUIRED'}
                        <div class="alert alert-info">
                            {l s='Not required to register' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'REGISTER_SUCCESS'}
                        <div class="alert alert-info">
                            {l s='We are reviewing your application. Once it is approved you will be able to enter the program. Please come back to this this program later' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'NEED_CONDITION'}
                        {if $message}
                            <div class="alert alert-info">
                                {$message|escape:'html':'UTF-8'}
                            </div>
                        {else}
                            <div class="alert alert-info">
                                {l s='You need to complete conditions to register to use this program' mod='ets_affiliatemarketing'}
                            </div>
                        {/if}
                    {elseif $alert_type == 'DISABLED'}
                        <div class="alert alert-info">
                            {l s='This program is disabled' mod='ets_affiliatemarketing'}
                        </div>
                    {/if}
                </div>
            {/if}
            {if isset($valid) && $valid}
                <p>
                    {l s='You have ' mod='ets_affiliatemarketing'}<strong>{$eam_loyalty_reward|escape:'html':'UTF-8'}</strong>{l s=' in your loyalty rewards. The loyalty reward can be used to pay for your order on our website or convert into voucher code. Refer to ' mod='ets_affiliatemarketing'} <a href="{$eam_reward_link|escape:'html':'UTF-8'}" title="" class="eam-rewards-link">{l s='Rewards' mod='ets_affiliatemarketing'}</a>{l s=' for more details about the loyalty rewards you got' mod='ets_affiliatemarketing'}
                </p>
            {/if}
        </div>
    </div>
   
{/block}
{block name='page_footer'}
<div class="eam-back-section">
    <a href="{if isset($my_account_link)}{$my_account_link|escape:'html':'UTF-8'}{/if}" title="{l s='Back to your account' mod='ets_affiliatemarketing'}" class="eam-back-link eam-link-go-myaccount">{l s='Back to your account' mod='ets_affiliatemarketing'}</a>
    <a href="{if isset($home_link)}{$home_link|escape:'html':'UTF-8'}{/if}" title="{l s='Home' mod='ets_affiliatemarketing'}" class="eam-back-link eam-link-go-home">{l s='Home' mod='ets_affiliatemarketing'}</a>
</div>
{/block}