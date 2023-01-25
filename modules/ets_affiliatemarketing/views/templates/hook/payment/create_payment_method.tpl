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

<div class="payment-setting">
	<form action="{$link_pm|escape:'html':'UTF-8'}&edit_pm=1" method="POST" class="form-horizontal">
		<div class="panel">
			<div class="panel-heading  no-border" style="padding-left: 15px; padding-right: 15px;">
				<h3 class="panel-title fs-14"><i class="fa fa-pencil-square-o"></i> {l s='Create new payment method' mod='ets_affiliatemarketing'}</h3>
			</div>
			<div class="panel-body">
				<div class="form-group payment-method">
				    <div class="form-group row ">
				        <label class="control-label required col-lg-3">{l s='Method name' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            {foreach $languages as $k=>$lang}
				            <div class="form-group row trans_field trans_field_{$lang.id_lang|escape:'html':'UTF-8'} {if $k > 0}hidden{/if}">
				                <div class="col-lg-9">
				                    <input type="text" name="payment_method_name[{$lang.id_lang|escape:'html':'UTF-8'}]" value="{if isset($query.payment_method_name[$lang.id_lang])}{$query.payment_method_name[$lang.id_lang]|escape:'html':'UTF-8'}{/if}" class="form-control">
				                </div>
				                <div class="col-lg-2">
				                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{$lang.iso_code|escape:'html':'UTF-8'} <span class="caret"></span></button>
				                    <ul class="dropdown-menu">
				                        {foreach $languages as $lg}
				                        <li><a href="javascript:eamHideOtherLang({$lg.id_lang|escape:'html':'UTF-8'})" title="">{$lg.name|escape:'html':'UTF-8'}</a></li>
				                        {/foreach}
				                    </ul>
				                </div>
				                <div class="col-lg-1">&nbsp;</div>
				            </div>
				            {/foreach}
				        </div>
				        <div class="col-lg-4">&nbsp;</div>
				    </div>
				    <div class="form-group row ">
				        <label class="control-label required col-lg-3">{l s='Fee type' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            <select name="payment_method_fee_type" class="form-control payment_method_fee_type">
				                <option value="FIXED" {if isset($query.payment_method_fee_type) && $query.payment_method_fee_type == 'FIXED'}selected{/if}>{l s='Fixed amount each withdrawal request' mod='ets_affiliatemarketing'}</option>
				                <option value="PERCENT" {if isset($query.payment_method_fee_type) && $query.payment_method_fee_type == 'PERCENT'}selected{/if}>{l s='Percentage based on withdrawal amount' mod='ets_affiliatemarketing'}</option>
				                <option value="NO_FEE" {if isset($query.payment_method_fee_type) && $query.payment_method_fee_type == 'NO_FEE'}selected{/if}>{l s='No fee' mod='ets_affiliatemarketing'}</option>
				            </select>
				        </div>
				    </div>
				    <div class="form-group row ">
				        <label class="control-label required col-lg-3">{l s='Fee (fixed amount)' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            <div class="input-group ">
				                <input type="text" name="payment_method_fee_fixed" value="{if isset($query.payment_method_fee_fixed)}{$query.payment_method_fee_fixed|escape:'html':'UTF-8'}{/if}" class="payment_method_fee_fixed"><span class="input-group-addon">{$currency->iso_code|escape:'html':'UTF-8'}</span>
				            </div>
				        </div>
				    </div>
				    <div class="form-group row " style="display:none;">
				        <label class="control-label required col-lg-3">{l s='Fee (percentage)' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            <div class="input-group ">
				                <input type="text" name="payment_method_fee_percent" value="{if isset($query.payment_method_fee_percent)}{$query.payment_method_fee_percent|escape:'html':'UTF-8'}{/if}" class="payment_method_fee_percent"><span class="input-group-addon">%</span>
				            </div>
				        </div>
				    </div>
				    <div class="form-group row ">
				        <label class="control-label col-lg-3">{l s='Description' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            {foreach $languages as $k=>$lang}
				            <div class="form-group row trans_field trans_field_{$lang.id_lang|escape:'html':'UTF-8'} {if $k > 0}hidden{/if}">
				                <div class="col-lg-9">
				                    <textarea name="payment_method_desc[{$lang.id_lang|escape:'html':'UTF-8'}]" class="form-control">{if isset($query.payment_method_desc[$lang.id_lang])}{$query.payment_method_desc[$lang.id_lang]|escape:'html':'UTF-8'}{/if}</textarea>
				                </div>
				                <div class="col-lg-2">
				                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{$lang.iso_code|escape:'html':'UTF-8'} <span class="caret"></span></button>
				                    <ul class="dropdown-menu">
				                        {foreach $languages as $lg}
				                        <li><a href="javascript:eamHideOtherLang({$lg.id_lang|escape:'html':'UTF-8'})" title="">{$lg.name|escape:'html':'UTF-8'}</a></li>
				                        {/foreach}
				                    </ul>
				                </div>
				                <div class="col-lg-1">&nbsp;</div>
				            </div>
				            {/foreach}
				        </div>
				        <div class="col-lg-4">&nbsp;</div>
				    </div>
				    <div class="form-group row ">
				        <label class="control-label col-lg-3">{l s='Note' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            {foreach $languages as $k=>$lang}
				            <div class="form-group row trans_field trans_field_{$lang.id_lang|escape:'html':'UTF-8'} {if $k > 0}hidden{/if}">
				                <div class="col-lg-9">
				                    <textarea name="payment_method_note[{$lang.id_lang|escape:'html':'UTF-8'}]" class="form-control">{if isset($query.payment_method_note[$lang.id_lang])}{$query.payment_method_note[$lang.id_lang]|escape:'html':'UTF-8'}{/if}</textarea>
				                </div>
				                <div class="col-lg-2">
				                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{$lang.iso_code|escape:'html':'UTF-8'} <span class="caret"></span></button>
				                    <ul class="dropdown-menu">
				                        {foreach $languages as $lg}
				                        <li><a href="javascript:eamHideOtherLang({$lg.id_lang|escape:'html':'UTF-8'})" title="">{$lg.name|escape:'html':'UTF-8'}</a></li>
				                        {/foreach}
				                    </ul>
				                </div>
				                <div class="col-lg-1">&nbsp;</div>
				            </div>
				            {/foreach}
				        </div>
				        <div class="col-lg-4">&nbsp;</div>
				    </div>
				    <div class="form-group row ">
				        <label class="control-label col-lg-3">{l s='Estimated processing time' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            <div class="input-group ">
				                <input type="text" name="payment_method_estimated" value="{if isset($query.payment_method_estimated)}{$query.payment_method_estimated|escape:'html':'UTF-8'}{/if}"><span class="input-group-addon">{l s='day(s)' mod='ets_affiliatemarketing'}</span>
				            </div>
				        </div>
				    </div>
				    <div class="form-group row ">
				        <label class="control-label col-lg-3">{l s='Enabled' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-9">
				            <span class="switch prestashop-switch fixed-width-lg">
				                <input type="radio" name="payment_method_enabled" id="payment_method_enable_on" value="1" class="payment_method_enable" checked="checked">
				                <label for="payment_method_enable_on">{l s='Yes' mod='ets_affiliatemarketing'}</label>
				                <input type="radio" name="payment_method_enabled" id="payment_method_enable_off" class="payment_method_enable" value="0" >
				                <label for="payment_method_enable_off">{l s='No' mod='ets_affiliatemarketing'}</label>
				                <a class="slide-button btn"></a>
				            </span>
				        </div>
				    </div>
				</div>
			</div>
			<div class="panel-footer">
				<button type="submit" value="1" name="create_payment_method" class="btn btn-default pull-right">
					<i class="process-icon-save"></i> {l s='Save' mod='ets_affiliatemarketing'}
				</button>
				<a href="{$link_pm nofilter}" class="btn btn-default"><i class="fa fa-close eam-icon-back"></i> {l s='Back' mod='ets_affiliatemarketing'}</a>
			</div>
		</div>
	</form>
</div>