{*
* 2007-2022 ETS-Soft
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
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2022 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{if $ets_errors}
    {$ets_errors nofilter}
{/if}
{if $ets_success}
    <article class="alert alert-success" role="alert" data-alert="success">
        <ul>
            <li>{$ets_success|escape:'html':'UTF-8'}</li>
        </ul>
    </article>
{/if}
<div class="row">
<div class="ets_mp_content_left col-lg-3" >
    {hook h='displayMPLeftContent'}
</div>
<div class="ets_mp_content_left col-lg-9" >
    {if in_array('standard_product',$product_types) && $ETS_MP_SELLER_CREATE_PRODUCT_ATTRIBUTE &&($ETS_MP_SELLER_CREATE_ATTRIBUTE || $ETS_MP_SELLER_USER_GLOBAL_ATTRIBUTE)}
        <div class="page-head-tabs" id="head_tabs">
            <ul class="nav">
                <li >
                    <a href="{$link->getModuleLink('ets_marketplace','attributes')|escape:'html':'UTF-8'}" id="subtab-AdminAttributesGroups" class="current">
                        {l s='Attributes' mod='ets_marketplace'}
                        <span class="notification-container">
                            <span class="notification-counter"></span>
                        </span>
                    </a>
                </li>
                <li class="active">
                    <a href="{$link->getModuleLink('ets_marketplace','features')|escape:'html':'UTF-8'}" id="subtab-AdminFeatures">
                        {l s='Features' mod='ets_marketplace'}
                        <span class="notification-container">
                            <span class="notification-counter"></span>
                        </span>
                    </a>
                </li> 
            </ul>
        </div>
    {/if}
    {if (isset($display_form) && $display_form) || !($ETS_MP_SELLER_CREATE_FEATURE && $ETS_MP_SELLER_USER_GLOBAL_FEATURE)}
        {$html_content nofilter}
    {else}
        <div class="panel ets_mp-panel">
            <div class="ets_mp_feature_type">
                <div class="panel-heading">{l s='Features' mod='ets_marketplace'}</div>
                <div class="form-group row">
                    <label class="control-label col-md-3">{l s='Using features' mod='ets_marketplace'}</label>
                    <div class="col-md-9">
                        <ul class="radio-inputs">
                            <li><label for="user_feature_1"><input type="radio" name="user_feature" value="1" id="user_feature_1"{if $ets_seller->user_feature==1} checked="checked"{/if} /> {l s='Use the store\'s global features' mod='ets_marketplace'}</label></li>
                            <li><label for="user_feature_2"><input type="radio" name="user_feature" value="2" id="user_feature_2"{if $ets_seller->user_feature==2} checked="checked"{/if}/> {l s='Create your own features' mod='ets_marketplace'}</label></li>
                            <li><label for="user_feature_3"><input type="radio" name="user_feature" value="3" id="user_feature_3"{if $ets_seller->user_feature==3} checked="checked"{/if}/> {l s='Use both store\'s global features and your own features' mod='ets_marketplace'}</label></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="ets_mp_feature_content">
                {$html_content nofilter}
            </div>
        </div>
    {/if}
</div>
</div>