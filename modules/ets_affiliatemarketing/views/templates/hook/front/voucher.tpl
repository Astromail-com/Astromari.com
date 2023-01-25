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
<div id="customer-reward-voucher" class="customer-reward-voucher row">
    <div class="col-sm-12 col-md-10 offset-md-1">
        <h3 class="text-center">{l s='Convert reward to promo code' mod='ets_affiliatemarketing'}</h3>
        <div class="form">
            <div class="form-group">
                <div class="input-wrapper">
                    <input name="name" type="text" value="" placeholder="Your promo name">
                </div>
            </div>
            <div class="form-group">
                <select class="btn btn-info float-xs-right" name="currency">
                    {foreach from=$currencies item=currency}
                        <option value="{$currency.id_currency|escape:'html':'UTF-8'}">{$currency.iso_code|escape:'html':'UTF-8'}</option>
                    {/foreach}
                </select>
                <div class="input-wrapper">
                    <input name="amount" type="text" value="" placeholder="{l s='Your promo amount' mod='ets_affiliatemarketing'}">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="input-group">
                <button class="btn btn-primary submit">{l s='Convert' mod='ets_affiliatemarketing'}</button>
            </div>
        </div>
    </div>
</div>
