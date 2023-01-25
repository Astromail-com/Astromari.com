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
                    <h1><i class="fa fa-sitemap"></i> {l s='Referral program' mod='ets_affiliatemarketing'}</h1>
                </li>
                {if !isset($alert_type)|| !$alert_type || $alert_type == 'registered'}
                <li role="presentation">
                    <a href="{$link_tab.ref_friends nofilter}" class="{if $tab_active == 'how-to-refer-friends'}active{/if}">{l s='How to refer friends?' mod='ets_affiliatemarketing'}</a>
                </li>
                <li role="presentation">
                    <a href="{$link_tab.my_friends nofilter}"  class="{if $tab_active == 'my-friends'}active{/if}">{l s='My friends' mod='ets_affiliatemarketing'}</a>
                </li>
                {/if}
            </ul>
        </div>
    	<div class="ets-am-content" style="padding-top: 0;">
            {if isset($alert_type) && $alert_type && $alert_type != 'registered'}
                <div class="mt-20">
                    {if $alert_type == 'account_banned'}
                        <div class="alert alert-warning">
                            {l s='You has been banned.' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'program_declined'}
                        <div class="alert alert-warning">
                            {l s='You has been declined to join this program' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'program_suspened'}
                        <div class="alert alert-warning">
                            {l s='You has been suspended this program' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'not_required'}
                        <div class="alert alert-info">
                            {l s='Not required to register' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'register_success'}
                        <div class="alert alert-info">
                            {l s='We are reviewing your application. Once it is approved you will be able to join the program. Please come back to this this program later' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'need_condition'}
                        {if $message}
                            <div class="alert alert-info">
                                {$message|escape:'html':'UTF-8'}
                            </div>
                        {else}
                        <div class="alert alert-info">
                            {l s='You need to complete conditions to register to use this program' mod='ets_affiliatemarketing'}
                        </div>
                        {/if}
                    {elseif $alert_type == 'disabled'}
                        <div class="alert alert-info">
                            {l s='This program is disabled' mod='ets_affiliatemarketing'}
                        </div>
                    {/if}
                </div>
            {else}
            <div class="content">
                {if $template=='sponsorship_reward_history.tpl'}
                    {include 'modules/ets_affiliatemarketing/views/templates/front/sponsorship_reward_history.tpl'}
                {/if}
                {if $template=='sponsorship_customer.tpl'}
                    {include 'modules/ets_affiliatemarketing/views/templates/front/sponsorship_customer.tpl'}
                {/if}
                {if $template=='sponsorship_myfriend.tpl'}
                    {include 'modules/ets_affiliatemarketing/views/templates/front/sponsorship_myfriend.tpl'}
                {/if}
                {if $template=='my_friends.tpl'}
                    {include 'modules/ets_affiliatemarketing/views/templates/front/my_friends.tpl'}
                {/if}
                
                {if $template=='sponsorship_refer_friend.tpl'}
                    {include 'modules/ets_affiliatemarketing/views/templates/front/sponsorship_refer_friend.tpl'}
                {/if}
                
            </div>
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
{block name="right_column"}{/block}