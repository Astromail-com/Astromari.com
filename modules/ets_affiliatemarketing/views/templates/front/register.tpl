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
    <div class="ets-am-content">
    <div class="eam-page-header">
        <h1 id="ets-am-customer-reward-heading">
        {$title|escape:'html':'UTF-8'}
        </h1> 
    </div>
    <div class="ets-am-register-program pt-0">
        
        <div class="page-body">
            {if $alert_type && $alert_type !== 'error'}
                <div class="mt-20">
                    {if $alert_type == 'account_banned'}
                        <div class="alert alert-warning">
                            {l s='Your account has been banned.' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'program_banned'}
                        <div class="alert alert-warning">
                            {l s='This program is unavailable for you' mod='ets_affiliatemarketing'}
                        </div>
                        {elseif $alert_type == 'program_decline'}
                        <div class="alert alert-warning">
                            {l s='You has been declined' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'not_required'}
                        <div class="alert alert-info">
                            {l s='Not required to register' mod='ets_affiliatemarketing'}
                        </div>
                    {elseif $alert_type == 'register_success'}
                    <div class="alert alert-info">
                        {l s='We are reviewing your application. Once it is approved you will be able to enter the program. Please come back to this program later' mod='ets_affiliatemarketing'}
                    </div>
                    {elseif $alert_type == 'need_condition'}
                        {if isset($message) && $message}
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
                            {l s='This program is not available' mod='ets_affiliatemarketing'}
                        </div>
                    {/if}
                </div>
            {else}
                {if $errors}
                    <div class="alert alert-danger">
                        <ul>
                        {foreach $errors as $error}
                            <li>{$error|escape:'html':'UTF-8'}</li>
                        {/foreach}
                        </ul>  
                    </div>
                {/if}
                <div class="intro-program">
                    {$intro_program nofilter}
                </div>
                <div class="data-register">
                    <form action="" method="post" accept-charset="utf-8" id="eamFormRegisterPrrogram">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>{l s='First name' mod='ets_affiliatemarketing'}</label>
                                    <input type="text" class="form-control" name="firstname" disabled="disabled" value="{$register_customer->firstname|escape:'html':'UTF-8'}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>{l s='Last name' mod='ets_affiliatemarketing'}</label>
                                    <input type="text" class="form-control" name="lastname" disabled="disabled" value="{$register_customer->lastname|escape:'html':'UTF-8'}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>{l s='Email' mod='ets_affiliatemarketing'}</label>
                                    <input type="text" class="form-control" name="email" disabled="disabled" value="{$register_customer->email|escape:'html':'UTF-8'}" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>{l s='Introduction about you' mod='ets_affiliatemarketing'} <small>{if $intro_required}({l s='required' mod='ets_affiliatemarketing'}){else}({l s='optional' mod='ets_affiliatemarketing'}){/if}</small></label>
                                    <textarea class="form-control" name="intro_yourself" rows="6">{if isset($query.intro_yourself)}{$query.intro_yourself|escape:'html':'UTF-8'}{elseif isset($intro)}{$intro|escape:'html':'UTF-8'}{/if}</textarea>
                                </div>
                            </div>
                        </div>
                        {if $term_required}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="agree_term" value="1" {if isset($query.agree_term) && $query.agree_term}checked="checked"{/if} class="{if $term_required}term_required{/if}">
                                            {l s='I agree with' mod='ets_affiliatemarketing'} <a href="{$link_term nofilter}" title="">{l s='Terms and conditions of use' mod='ets_affiliatemarketing'}</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {/if}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="hidden" name="program" value="{$program|escape:'html':'UTF-8'}">
                                    <button type="submit" name="submitEamRegisterProgram" class="btn btn-primary" {if (!isset($query.agree_term) || !$query.agree_term) && $term_required}disabled="disabled"{/if}>{l s='Submit application' mod='ets_affiliatemarketing'}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            
            {/if}
            
        </div>
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
