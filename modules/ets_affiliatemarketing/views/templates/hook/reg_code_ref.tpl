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
{if $is17}
	{if !$email_sponsor}
	<div class="form-group row aff_sponsor_box">
	    <label class="col-md-3 form-control-label">{l s='Sponsor' mod='ets_affiliatemarketing'}</label>
	    <div class="col-md-6">
	    	<input type="text" name="eam_code_ref" value="{if $email_sponsor}{$email_sponsor|escape:'html':'UTF-8'}{elseif isset($query.eam_code_ref)}{$query.eam_code_ref|escape:'html':'UTF-8'}{/if}" {if $email_sponsor}disabled="disabled"{/if} class="form-control" placeholder="{l s='ID or email' mod='ets_affiliatemarketing'}">
	    	<div class="help-block" style="display: none;">{l s='ID or email is invalid' mod='ets_affiliatemarketing'}</div>
	    	<p><em>{l s='You are sponsored by another users? Enter their email or ID into the field.' mod='ets_affiliatemarketing'}</em></p>
	    </div>
	    <div class="col-md-3 form-control-comment">{l s='Optional' mod='ets_affiliatemarketing'}</div>
	</div>
	{/if}
{else}
	{if !$email_sponsor}
	<div class="required form-group">
		<label for="customer_firstname">{l s='Sponsor' mod='ets_affiliatemarketing'}</label>
		<input type="text" name="eam_code_ref" value="{if $email_sponsor}{$email_sponsor|escape:'html':'UTF-8'}{elseif isset($query.eam_code_ref)}{$query.eam_code_ref|escape:'html':'UTF-8'}{/if}" {if $email_sponsor}disabled="disabled"{/if} class="form-control" placeholder="{l s='ID or email' mod='ets_affiliatemarketing'}">
	    	<div class="help-block" style="display: none;">{l s='ID or email is invalid' mod='ets_affiliatemarketing'}</div>
	    	<p><em>{l s='You are sponsored by another users? Enter their email or ID into the field.' mod='ets_affiliatemarketing'}</em></p>
	</div>
	{/if}
{/if}