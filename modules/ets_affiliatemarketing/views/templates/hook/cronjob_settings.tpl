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
<div class="eam-cronjob">
	<div class="row mt-15">
		<div class="col-lg-12">
			<p class="ets-am-text-strong mb-10"><span style="color: red;">*</span> {l s='Some important notes before setting Cronjob' mod='ets_affiliatemarketing'}:</p>
			<ul>
				<li>{l s='Cronjob frequency should be at least twice per day, the recommended frequency is once per minute' mod='ets_affiliatemarketing'}</li>
				<li>{l s='How to setup a cronjob is different depending on your server. If you\'re using a Cpanel hosting, watch this video for more reference' mod='ets_affiliatemarketing'}:
					<a href="https://www.youtube.com/watch?v=bmBjg1nD5yA" target="_blank" rel="noreferrer noopener">https://www.youtube.com/watch?v=bmBjg1nD5yA</a> <br>
					{l s='You can also contact your hosting provider to ask them for support on setting up the cronjob' mod='ets_affiliatemarketing'}
				</li>
				
			</ul>
			<p class="ets-am-text-strong eam-block mb-15"><span style="color: red;">*</span> {l s='Setup a cronjob as below on your server to automatically change loyalty reward status to "expired"  when it is expired and send emails to customers when their loyalty reward is going to be expired.' mod='ets_affiliatemarketing'}</p>
			<p> {l s='If you set up a value for' mod='ets_affiliatemarketing'} <strong>{l s='"Only validate reward if an order has been changed to statuses above"' mod='ets_affiliatemarketing'}</strong> {l s='option on' mod='ets_affiliatemarketing'} <strong>{l s='"General settings"' mod='ets_affiliatemarketing'}</strong> {l s='tab' mod='ets_affiliatemarketing'}, {l s='please run the cronjob so that when the condition is satisfied, cronjob will reset the status of reward back to' mod='ets_affiliatemarketing'} <strong>{l s='"Approved"' mod='ets_affiliatemarketing'}</strong>.</p>
			<br>
			<p class="mb-15 eam-block"><span class="ets-am-text-bg-light-gray">* * * * * {$php_path|escape:'html':'UTF-8'} {$cronjob_dir|escape:'html':'UTF-8'} secure=<span class="eam-cronjob-secure-value">{$cronjob_token|escape:'html':'UTF-8'}</span></span></p>
			<p class="ets-am-text-strong mb-10"><span style="color: red;">*</span> {l s='Execute the cronjob manually by clicking on the button below' mod='ets_affiliatemarketing'}</p>
			<a href="{$cronjob_link|escape:'html':'UTF-8'}" data-secure="{$cronjob_token|escape:'html':'UTF-8'}" class="btn btn-default btn-sm mb-10 js-eam-test-cronjob">{l s='Execute cronjob manually' mod='ets_affiliatemarketing'}</a>
		</div>
	</div>
	<div class="mb-15 eam-block form-horizontal">
		<div class="form-group">
			<label class="control-label col-lg-3">
				{l s='Cronjob secure token' mod='ets_affiliatemarketing'}:
			</label>
			<div class="col-lg-3 flex">
				<input type="text" name="ETS_AM_CRONJOB_TOKEN" id="ETS_AM_CRONJOB_TOKEN" value="{$cronjob_token|escape:'html':'UTF-8'}">
                <div class="update_button">
				    <input type="button" name="ETS_AM_CRONJOB_TOKEN_SAVE" class="btn btn-default" value="{l s='Update' mod='ets_affiliatemarketing'}"/>
                    <span class="ETS_AM_CRONJOB_TOKEN_loading"></span>
                </div>
			</div>
		</div>
	</div>
    {if $cronjob_last}
        <div class="alert alert-info cronjob">
            {l s='Last time cronjob run: ' mod='ets_affiliatemarketing'}{$cronjob_last|escape:'html':'UTF-8'}
        </div>
    {/if}
</div>
{if !$run_cronjob}
    <div class="alert alert-warning cronjob">{l s='Cronjob didn\'t run in last 12 hours. Please check again cronjob configuration to make sure Cronjob run correctly' mod='ets_affiliatemarketing'}</div>
{/if}