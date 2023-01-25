
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
{if $explaination}
<div class="explaination">
	<div class="text-explaination">
		{$explaination nofilter}
	</div>
</div>
{/if}

<div class="eam-ref-friend">
	<div class="eam-alert-box">
		
	</div>
	<section class="eam-section">
		<h3>{l s='Share your sponsor info to your friends' mod='ets_affiliatemarketing'}</h3>
		<div class="eam-section-content">
			<div class="eam-box-field clearfix display-flex">
				<div class="eam-box-label">
					<a href="javascript:void(0)" class="eam-tooltip" data-eam-tooltip="{l s='Share this URL via social networks such as Facebook, Twitter, Linked In, etc. to invite your friends' mod='ets_affiliatemarketing'}" ><i class="fa fa-question-circle"></i></a>
					<label>{l s='Sponsor URL: ' mod='ets_affiliatemarketing'}</label>
				</div>	
                {if $file_qr_image}
                    <img class="qr_image" src="{$file_qr_image|escape:'html':'UTF-8'}" alt="QR code" />
                {/if}
			    <div class="input-group eam-box-link" style="position: relative;">
			    	<span class="eam-txt-tooltip" style="display: none;">{l s='Copied' mod='ets_affiliatemarketing'}</span>
				  <input type="text" class="form-control eam-ref-banner-code" value="{$url_ref nofilter}" readonly title="{l s='Click to copy sponsor URL' mod='ets_affiliatemarketing'}">
				  <span class="input-group-addon btn-copy-link js-eam-btn-copylink eam-tooltip" data-eam-tooltip="{l s='Click to copy sponsor URL' mod='ets_affiliatemarketing'}" data-eam-copy="Copied to clipboard"><i class="fa fa-copy"></i>
				  	</span>
				</div>
				<div class="eam-box-action">
					<div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{$url_ref  nofilter}">
					    <a class="ref-share-fb" href="https://www.facebook.com/sharer/sharer.php?u={$url_ref nofilter}" target="_blank" title="Share on facebook">
                            <i class="fa fa-facebook-f"></i>
                        </a>
					    <a class="aff-product-share-tw" href="https://twitter.com/intent/tweet?url={$url_ref nofilter}" target="_blank" title="Share on twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
					</div>
				</div>
			</div>
			<div class="eam-box-field clearfix">
				<div class="eam-box-label">
					<a href="javascript:void(0)"class="eam-tooltip" data-eam-tooltip="{l s='Share this email to your friends. They can enter the email address when registering a new account on this website and you will earn reward' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
					<label>{l s='Sponsor Email: ' mod='ets_affiliatemarketing'}</label>
				</div>				
				 <span>{$ets_customer->email  nofilter}</span>
			</div>
			<div class="eam-box-field clearfix">
				<div class="eam-box-label">
					<a href="javascript:void(0)" class="eam-tooltip" data-eam-tooltip="{l s='Share this ID to your friends. They can enter the ID when registering a new account on this website and you will earn reward' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
					<label>{l s='Sponsor ID: ' mod='ets_affiliatemarketing'}</label>
				</div>
				<div class="eam-box-input">
				    <span>{$ets_customer->id  nofilter}</span>
				</div>
			</div>
			{if $allow_upload_banner || $banner}
			<div class="eam-box-field clearfix">
				<div class="eam-box-label">
					<a href="javascript:void(0)"  class="eam-tooltip" data-eam-tooltip="{l s='Embed this banner on blog, forum, website, etc.' mod='ets_affiliatemarketing'}" ><i class="fa fa-question-circle"></i></a>
					<label>{l s='Sponsor banner: ' mod='ets_affiliatemarketing'}</label>
				</div>
				<div class="eam-box-input">
				    <form id="eamFormBanner">
						<div class="content-eamFormBanner">
							<div class="form-group mb-0">
								<div class="preview-banner">
									{if $banner}
									<img src="{$banner  nofilter}" alt="Banner" class="img-preview">
										{if $allow_upload_banner}
										  <span class="delete-banner" title="{l s='Delete' mod='ets_affiliatemarketing'}" {if $banner_is_default} style="display:none;"{/if}><i class="fas fa fa-trash"></i></span>
										{/if}
									{/if}
								</div>
							</div>
							{if $allow_upload_banner}
								<div class="form-group eam-input-file-container">
									<p class="eam-file-return"><label>{l s='Upload my banner' mod='ets_affiliatemarketing'}</label></p>
									<input type="file" name="ref_banner" id="eam_ref_banner" value="" class="eam-input-file">
									<label tabindex="0" class="eam-input-file-trigger">{l s='Select' mod='ets_affiliatemarketing'}</label>
								</div>
							{/if}
							<div class="eam-embed-code-banner">
								<div class="embed-code">
									<span class="eam-txt-tooltip">{l s='Copied to clipboard' mod='ets_affiliatemarketing'}</span>
									<textarea class="eam-ref-banner-code banner-code eam-tooltip" id="eam-ref-banner-code" readonly title="{l s='Copy to clipboard' mod='ets_affiliatemarketing'}" placeholder="{l s='No content found' mod='ets_affiliatemarketing'}">{$embed_code|escape:'html':'UTF-8'}</textarea>
								</div>
							</div>
						</div>
                        <div class="clearfix" style="clear:both;"></div>
						{if $allow_upload_banner}
							{if $allow_upload_banner && $resize_width && $resize_height}
								<p class="mb-0 fs-12 fw-500">{l s='Recommended size:' mod='ets_affiliatemarketing'} {$resize_width  nofilter} x {$resize_height  nofilter} px. {l s='Accepted formats: jpg, jpe, png, gif. Limit:' mod='ets_affiliatemarketing'} {Configuration::get('PS_ATTACHMENT_MAXIMUM_SIZE')|escape:'html':'UTF-8'}Mb</p>
							{/if}
						<div class="form-group mt-20">
							<button type="button" class="b-radius-3 text-uppercase fs-12 btn btn-primary js-upload-your-banner">{l s='Save' mod='ets_affiliatemarketing'}</button>
						</div>
						{/if}
					</form>
					
				</div>
			</div>
			{/if}
		</div>
	</section>
    {if $ETS_AM_SELL_OFFER_VOUCHER}
        <section class="eam-section eam-send-invitation ">
            <h3>{l s='Sponsor voucher code' mod='ets_affiliatemarketing'}</h3>
            <div class="eam-section-content">
                <label>{l s='Your sponsor voucher code' mod='ets_affiliatemarketing'}</label>
                <div class="eam-box-field clearfix display-flex mb-5">
                    <div class="input-group eam-box-link" style="position: relative;">
                        <span class="eam-txt-tooltip" style="display: none;">{l s='Copied' mod='ets_affiliatemarketing'}</span>
                        <input class="form-control eam-ref-banner-code voucher_code_sell" title="{l s='Click to copy sponsor voucher code' mod='ets_affiliatemarketing'}" type="text" value="{if $voucher_code}{$voucher_code|escape:'html':'UTF-8'}{/if}" class="voucher_code_sell" readonly="true"{if !$voucher_code} style="display:none"{/if}/>
                        <span class="input-group-addon btn-copy-link js-eam-btn-copylink eam-tooltip" data-eam-tooltip="{l s='Click to copy sponsor voucher code' mod='ets_affiliatemarketing'}" data-eam-copy="{l s='Copied to clipboard' mod='ets_affiliatemarketing'}" {if !$voucher_code} style="display:none;"{/if}>
                            <i class="fa fa-copy"></i>
                        </span>
                    </div>
                    <div class="eam-box-action">
                        <button type="button" class="create_voucher_code_sell{if $voucher_code} created{/if}" {if $voucher_code} disabled="disabled"{/if} > <i class="icon-loading"></i>{l s='Get my voucher code' mod='ets_affiliatemarketing'}</button>
                    </div>
                </div>
                <p class="mb-0 fs-12 fw-500">{if $ETS_AM_REF_VOUCHER_CODE_DESC}{$ETS_AM_REF_VOUCHER_CODE_DESC nofilter}{/if}</p>
            </div>
        </section>
    {/if}
	{if $enable_invitation}
	<section class="eam-section eam-send-invitation ">
		<h3>{l s='Send invitation to your friends' mod='ets_affiliatemarketing'}</h3>
		<div class="eam-section-content">
		<div class="eam-box-field clearfix">
			<div class="mail-inviting-item">
				<form class="eam-form-email-inviting">
					<div class="row">
	    				<div class="col-xs-12 col-sm-4 col-lg-4">
	    					<div class="form-group mb-5">
	    						<label>{l s='Name' mod='ets_affiliatemarketing'}<span class="eam-required"></span></label>
		    					<input type="text" name="name" value="" class="form-control" placeholder="{l s ='Enter your friend\'s name' mod='ets_affiliatemarketing'}">
		    				</div>
	    				</div>
	    				<div class="col-xs-12 col-sm-4 col-lg-4">
							<div class="form-group mb-5">
								<label>{l s='Email' mod='ets_affiliatemarketing'}<span class="eam-required"></span></label>
		    					<input type="text" name="email" value="" class="form-control" placeholder="{l s ='Enter your friend\'s email' mod='ets_affiliatemarketing'}">
		    				</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-lg-4">
							<div class="form-group mb-5">
								<label style="display: block;" class="hidden_mobile">&nbsp;</label>
								<button type="button" class=" btn btn-primary b-radius-3 text-uppercase fs-12 js-send-email-inviting">{l s='Send invitation' mod='ets_affiliatemarketing'}</button>
							</div>
						</div>
					</div>
				</form>
				<p class="mb-0 fs-12 fw-500">
					<span class="eam-required">{l s='Note: ' mod='ets_affiliatemarketing'}</span>
					{if $max_invitation !== 'unlimited'}
                        {l s='You can invite maximum number of ' mod='ets_affiliatemarketing'}
                        {$max_invitation nofilter}
                        {l s=' friends via their email. ' mod='ets_affiliatemarketing'}
					{/if}
					{l s=' You have sent ' mod='ets_affiliatemarketing'}

					
					{$total_email_sent|intval} 
                    {l s=' email(s) ' mod='ets_affiliatemarketing'}
					{if $max_invitation !== 'unlimited'}
						({if $invitation_left >0}{$invitation_left|intval}{else}0{/if} {l s=' left' mod='ets_affiliatemarketing'})
					{/if}

				</p>
			</div>
			<div class="eam-alert-sent-mail"></div>
			</div>
		</div>
	</section>
	<section class="eam-section">
		<h3>{l s='Invitations' mod='ets_affiliatemarketing'}</h3>
		<div class="table-responsive">
			<table class="table eam-table-flat">
				<thead>
					<tr>
						<th class="text-left">{l s='Email' mod='ets_affiliatemarketing'}</th>
						<th class="text-left">{l s='Name' mod='ets_affiliatemarketing'}</th>
						<th class="text-left">{l s='Date of invitation' mod='ets_affiliatemarketing'}</th>
						<th class="text-center">{l s='Status' mod='ets_affiliatemarketing'}</th>
					</tr>
				</thead>
				<tbody class="list-refer-friends">					
					{if $invitations.result}
						{foreach $invitations.result as $result}
							<tr>
								<td class="text-left">{$result.email nofilter}</td>
								<td class="text-left">{$result.username nofilter}</td>
								<td class="text-left">{date('d/m/Y', strtotime($result.datetime_sent)) nofilter}</td>
								<td  class="text-center">
									{if $result.status}
										<i class="fa fa-check eam-text-green eam-mr-8"></i> {l s='Registered' mod='ets_affiliatemarketing'}
									{else}
										<i class="fa fa-clock-o eam-text-orange  eam-mr-8"></i> {l s='Pending' mod='ets_affiliatemarketing'}
									{/if}
								</td>
							</tr>
						{/foreach}
                        {if $invitations.total_page > $invitations.current_page}
                            <tr class="refer-friends">
                                <td colspan="100%" style="text-align: center;"><a class="button-refer-friends" href="{$link->getModuleLink('ets_affiliatemarketing','refer_friends',['page'=>$invitations.current_page|intval+1,'load_more'=>true,'ajax'=>true])}">{l s='Load more' mod='ets_affiliatemarketing'}</a></td>
                            </tr>
                        {/if}
					{else}
						<tr class="text-center">
							<td colspan="100%">{l s='No data found' mod='ets_affiliatemarketing'}</td>
						</tr>
					{/if}
				</tbody>
			</table>
		</div>
	</section>
	{/if}
</div>
<script type="text/javascript">
	var eam_trans = [];
	eam_trans['delete'] = "{l s='Delete' mod='ets_affiliatemarketing'}";
	eam_trans['confirm_delete_banner'] = "{l s='Do you want to delete this image?' mod='ets_affiliatemarketing'}";
</script>
