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
	<form action="{$link_pm|escape:'html':'UTF-8'}&payment_method={$payment_method.id_ets_am_payment_method|escape:'html':'UTF-8'}&edit_pm=1" method="POST" id="eamFormEditPaymentMethod" class="form-horizontal">
		<div class="panel">
			<div class="panel-heading no-border" style="padding-left: 15px; padding-right: 15px;">
				<h3 class="panel-title fs-14"><i class="fa fa-pencil-square-o"></i> {l s='Edit payment method' mod='ets_affiliatemarketing'} #{$payment_method.id_ets_am_payment_method|escape:'html':'UTF-8'}</h3>
			</div>
			<div class="panel-body">
				<div class="form-group payment-method">
				    <div class="form-group row ">
				        <label class="control-label required col-lg-3">{l s='Method name' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            {foreach $languages as $k=>$lang}
				            <div class="form-group row trans_field trans_field_{$lang.id_lang|escape:'html':'UTF-8'} {if $k > 0}hidden{/if}">
				                <div class="col-lg-9">
				                    <input type="text" name="payment_method_name[{$lang.id_lang|escape:'html':'UTF-8'}]" value="{if isset($payment_method['langs'][{$lang.id_lang|escape:'html':'UTF-8'}])} {$payment_method['langs'][{$lang.id_lang|escape:'html':'UTF-8'}].title|escape:'html':'UTF-8'}{/if}" class="form-control {if $currency->id == $lang.id_lang}required{/if}" data-error="{l s='Title of payment method is required' mod='ets_affiliatemarketing'}">
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
				                <option value="FIXED" {if $payment_method.fee_type == 'FIXED'}selected="selected"{/if}>{l s='Fixed amount each withdrawal request' mod='ets_affiliatemarketing'}</option>
				                <option value="PERCENT" {if $payment_method.fee_type == 'PERCENT'}selected="selected"{/if}>{l s='Percentage based on withdrawal amount' mod='ets_affiliatemarketing'}</option>
								<option value="NO_FEE" {if $payment_method.fee_type == 'NO_FEE'}selected="selected"{/if}>{l s='No fee' mod='ets_affiliatemarketing'}</option>
							</select>
				        </div>
				    </div>
				    <div class="form-group row ">
				        <label class="control-label required col-lg-3">{l s='Fee (fixed amount)' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            <div class="input-group ">
				                <input type="text" name="payment_method_fee_fixed" value="{$payment_method.fee_fixed|escape:'html':'UTF-8'}" class="payment_method_fee_fixed"><span class="input-group-addon">{$currency->iso_code|escape:'html':'UTF-8'}</span></div>
				        </div>
				    </div>
				    <div class="form-group row " style="display:none;">
				        <label class="control-label required col-lg-3">{l s='Fee (percentage)' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            <div class="input-group ">
				                <input type="text" name="payment_method_fee_percent" value="{$payment_method.fee_percent|escape:'html':'UTF-8'}" class="payment_method_fee_percent"><span class="input-group-addon">%</span></div>
				        </div>
				    </div>
				    <div class="form-group row ">
				        <label class="control-label col-lg-3">{l s='Description' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-5">
				            {foreach $languages as $k=>$lang}
				            <div class="form-group row trans_field trans_field_{$lang.id_lang|escape:'html':'UTF-8'} {if $k > 0}hidden{/if}">
				                <div class="col-lg-9">
				                    <textarea name="payment_method_desc[{$lang.id_lang|escape:'html':'UTF-8'}]" class="form-control">{if isset($payment_method['langs'][{$lang.id_lang|escape:'html':'UTF-8'}])} {$payment_method['langs'][{$lang.id_lang|intval}].description|escape:'html':'UTF-8'}{/if}</textarea>
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
				                    <textarea name="payment_method_note[{$lang.id_lang|escape:'html':'UTF-8'}]" class="form-control">{if isset($payment_method['langs'][{$lang.id_lang|escape:'html':'UTF-8'}])} {$payment_method['langs'][{$lang.id_lang|escape:'html':'UTF-8'}].note|escape:'html':'UTF-8'}{/if}</textarea>
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
				                <input type="text" name="payment_method_estimated" value="{if $payment_method.estimated_processing_time}{$payment_method.estimated_processing_time|escape:'html':'UTF-8'}{/if}"><span class="input-group-addon">{l s='day(s)' mod='ets_affiliatemarketing'}</span>
				            </div>
				        </div>
				    </div>
				    <div class="form-group row ">
				        <label class="control-label col-lg-3">{l s='Enabled' mod='ets_affiliatemarketing'}</label>
				        <div class="col-lg-9">
				            <span class="switch prestashop-switch fixed-width-lg">
				                <input type="radio" name="payment_method_enabled" id="payment_method_enable_on" value="1" class="payment_method_enable" {if $payment_method.enable == 1}checked="checked"{/if}>
				                <label for="payment_method_enable_on">{l s='Yes' mod='ets_affiliatemarketing'}</label>
				                <input type="radio" name="payment_method_enabled" id="payment_method_enable_off" class="payment_method_enable" value="0" {if $payment_method.enable == 0}checked="checked"{/if}>
				                <label for="payment_method_enable_off">{l s='No' mod='ets_affiliatemarketing'}</label>
				                <a class="slide-button btn"></a>
				            </span>
				        </div>
				    </div>
				</div>
			</div>
			<!-- PAYMENT METHOD FILED -->
			<div class="flat" style="padding-top: 22px;">
				<div class="flat-heading">
					<h3><i class="fa fa-list"></i> {l s='Payment method fields' mod='ets_affiliatemarketing'}</h3>
				</div>
				<div class="flat-body">
					<div class="alert alert-info"><em>{l s='You can add several input fields (Bank account number, Paypal address, etc.) to collect necessary information from customer to process their withdrawal request. Drag/Drop to sort payment method fields' mod='ets_affiliatemarketing'}</em></div>
					<div class="method_fields_append" id="eam_method_fields_append">
						{foreach $payment_method_fields as $key=>$field}
							
							<div class="form-group payment-method-field" data-id="{$field.id|escape:'html':'UTF-8'}">
								<a data-toggle="collapse" href="#payment_method_field_{$key|escape:'html':'UTF-8'}" class="btn-pmf-collapse">{if isset($field['title'][$default_lang])}{$field['title'][$default_lang]|escape:'html':'UTF-8'}{/if} <i class="fa fa-plus-circle pull-right"></i></a>
							    <div class="group-fields collapse" id="payment_method_field_{$key|escape:'html':'UTF-8'}">
							    	<div class="form-group row">
								        <label class="control-label required col-lg-3">{l s='Method field title' mod='ets_affiliatemarketing'}</label>
								        <div class="col-lg-6">
								        	{foreach $languages as $k=>$lang}
								            <div class="form-group row trans_field trans_field_{$lang.id_lang|escape:'html':'UTF-8'} {if $k > 0}hidden{/if}">
								                <div class="col-lg-9">
								                    <input type="text" name="payment_method_field[{$key|escape:'html':'UTF-8'}][title][{$lang.id_lang|escape:'html':'UTF-8'}]" value="{if isset($field['title'][$lang.id_lang])}{$field['title'][$lang.id_lang]|escape:'html':'UTF-8'}{/if}" class="form-control {if $currency->id == $lang.id_lang}required{/if}" data-error="{l s='Title of payment method field is required' mod='ets_affiliatemarketing'}">
								                </div>
								                <div class="col-lg-2">
								                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{$lang.iso_code|escape:'html':'UTF-8'} <span class="caret"></span></button>
								                    <ul class="dropdown-menu">
								                    	{foreach $languages as $lg}
								                        <li><a href="javascript:eamHideOtherLang({$lg.id_lang|escape:'html':'UTF-8'})" title="">{$lg.name|escape:'html':'UTF-8'}</a></li>
								                        {/foreach}
								                    </ul>
								                </div>
								            </div>
								            {/foreach}
								        </div>
								    </div>
								    <div class="form-group row">
								        <label class="control-label col-lg-3">{l s='Method field type' mod='ets_affiliatemarketing'}</label>
								        <div class="col-lg-5">
								            <select name="payment_method_field[{$key|escape:'html':'UTF-8'}][type]" class="form-control">
								                <option value="text" {if $field.type == 'text'}selected{/if}>{l s='Text' mod='ets_affiliatemarketing'}</option>
								                <option value="textarea" {if $field.type == 'textarea'}selected{/if}>{l s='Textarea' mod='ets_affiliatemarketing'}</option>
								            </select>
								        </div>
								    </div>
								    <div class="form-group row">
								        <label class="control-label col-lg-3">{l s='Description' mod='ets_affiliatemarketing'}</label>
								        <div class="col-lg-6">
								        	{foreach $languages as $k=>$lang}
								            <div class="form-group row trans_field trans_field_{$lang.id_lang|escape:'html':'UTF-8'} {if $k > 0}hidden{/if}">
								                <div class="col-lg-9">
								                    <textarea name="payment_method_field[{$key|escape:'html':'UTF-8'}][description][{$lang.id_lang|escape:'html':'UTF-8'}]" class="form-control">{if isset($field['title'][$lang.id_lang])}{$field['description'][$lang.id_lang]|escape:'html':'UTF-8'}{/if}</textarea>
								                </div>
								                <div class="col-lg-2">
								                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{$lang.iso_code|escape:'html':'UTF-8'} <span class="caret"></span></button>
								                    <ul class="dropdown-menu">
								                    	{foreach $languages as $lg}
								                        <li><a href="javascript:eamHideOtherLang({$lg.id_lang|escape:'html':'UTF-8'})" title="">{$lg.name|escape:'html':'UTF-8'}</a></li>
								                        {/foreach}
								                    </ul>
								                </div>
								            </div>
								            {/foreach}
								        </div>
								    </div>
								    
								    <div class="form-group row ">
								        <label class="control-label col-lg-3">{l s='Required' mod='ets_affiliatemarketing'}</label>
								        <div class="col-lg-3">
								        	<select name="payment_method_field[{$key|escape:'html':'UTF-8'}][required]" class="form-control">
								        		<option value="1" {if $field.required == 1}selected="selected"{/if}>{l s='Yes' mod='ets_affiliatemarketing'}</option>
								        		<option value="0" {if $field.required == 0}selected="selected"{/if}>{l s='No' mod='ets_affiliatemarketing'}</option>
								        		
								        	</select>
								        </div>
								    </div>
								    <div class="form-group row ">
								        <label class="control-label col-lg-3">{l s='Enabled' mod='ets_affiliatemarketing'}</label>
								        <div class="col-lg-9">
								            <span class="switch prestashop-switch fixed-width-lg">
								                <input type="radio" name="payment_method_field[{$key|escape:'html':'UTF-8'}][enable]" id="payment_method_field_{$key|escape:'html':'UTF-8'}_enable_on" value="1" class="payment_method_field_enable" {if $field.enable == 1}checked="checked"{/if}>
								                <label for="payment_method_field_{$key|escape:'html':'UTF-8'}_enable_on">{l s='Yes' mod='ets_affiliatemarketing'}</label>
								                <input type="radio" name="payment_method_field[{$key|escape:'html':'UTF-8'}][enable]" id="payment_method_field_{$key|escape:'html':'UTF-8'}_enable_off" class="payment_method_field_enable" value="0" {if $field.enable == 0}checked="checked"{/if}>
								                <label for="payment_method_field_{$key|escape:'html':'UTF-8'}_enable_off">{l s='No' mod='ets_affiliatemarketing'}</label>
								                <a class="slide-button btn"></a>
								            </span>
								        </div>
								    </div>
								    <input type="hidden" name="payment_method_field[{$key|escape:'html':'UTF-8'}][id]" value="{$field.id|escape:'html':'UTF-8'}">
								    <a class="btn btn-default btn-sm btn-delete-field js-btn-delete-field" href="javascript:void(0)"><i class="fa fa-trash"></i> {l s='Delete' mod='ets_affiliatemarketing'}</a>
							    </div>
							</div>
						{/foreach}
						<div class="form-group row">
				            <div class="col-lg-10">
				                <button type="button" class="btn btn-default js-add-payment-method-field"><i class="fa fa-plus"></i> {l s='Add new field' mod='ets_affiliatemarketing'}</button>
				            </div>
				        </div>
					</div>
					
				</div>
				
			</div>
			<div class="panel-footer">
				<button type="submit" value="1" name="update_payment_method" class="btn btn-default pull-right">
					<i class="process-icon-save"></i> {l s='Save' mod='ets_affiliatemarketing'}
				</button>
				<a href="{$link_pm|escape:'html':'UTF-8'}" class="btn btn-default"><i class="fa fa-close eam-icon-back"></i> {l s='Back' mod='ets_affiliatemarketing'}</a>
			</div>
		</div>
		
	</form>
</div>
<script type="text/javascript">
	eam_languages = {json_encode($languages) nofilter};
	eam_currency = {json_encode($currency) nofilter};
</script>