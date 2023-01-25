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

<div class="eam-view-with-draw ets-am-list-app">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel">
				<div class="panel-body pb-0">
					<div class="info-box">
						<div class="row">
							<div class="col-lg-7 eam-col-rp">
								<div class="row">
									<div class="col-lg-5">
										<div class="eam-title-section">
											<h3 class="h-title">{l s='Reward status' mod='ets_affiliatemarketing'}</h3>
										</div>
										<div class="form-horizontal">
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Customer name' mod='ets_affiliatemarketing'}</em></label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static"><a href="{$user_link|escape:'html':'UTF-8'}&id_reward_users={$user.id_customer|escape:'html':'UTF-8'}&viewreward_users" title="{l s='View customer' mod='ets_affiliatemarketing'}" target="_blank">{$user.firstname|escape:'html':'UTF-8'} {$user.lastname|escape:'html':'UTF-8'}</a></p>
												</div>
											</div>
                                            <div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Total earned reward' mod='ets_affiliatemarketing'}</em> 
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='The total amount of reward this user earned from all marketing programs' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.total_point|escape:'html':'UTF-8'}</p> 
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Total reward balance' mod='ets_affiliatemarketing'}</em> 
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='The remaining amount of reward after converting into voucher, withdrawing or paying for orders' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.total_balance|escape:'html':'UTF-8'}</p>
												</div>
											</div>
                                            {if isset($user.remaining_withdrawable)}
                                                <div class="row">
    												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Remaining withdrawable amount' mod='ets_affiliatemarketing'}</em> 
    													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='This withdrawal included' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
    												</label>
    												<div class="col-lg-6 col-sm-6">
    													<p class="form-control-static">{$user.remaining_withdrawable|escape:'html':'UTF-8'}</p> 
    												</div>
    											</div>
                                            {/if}
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Loyalty program balance' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total remaning reward amount this user earned from loyalty program' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.loy_balance|escape:'html':'UTF-8'}</p> 
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Referral program balance' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total remaning reward amount this user earned from referral program' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.ref_balance|escape:'html':'UTF-8'}</p> 
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Affiliate program balance' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total remaning reward amount this user earned from affiliate program' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.aff_balance|escape:'html':'UTF-8'}</p>  
												</div>
											</div>                                            
                                            <div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Other programs balance' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total remaning reward amount this user earned from other programs' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.mnu_balance|escape:'html':'UTF-8'}</p> 
												</div>
											</div>                                            
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Withdrawn' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total reward amount this user successfully withdrew' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.withdrawn|escape:'html':'UTF-8'}</p> 
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Paid for orders' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total reward amount this user paid for orders' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.pay_for_order|escape:'html':'UTF-8'}</p> 
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Converted to voucher' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total reward amount this user converted to voucher' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.convert_to_voucher|escape:'html':'UTF-8'}</p> 
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Total used reward' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total reward amount this user spent for withdrawal, paying for orders or converting to vouchers' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.total_usage|escape:'html':'UTF-8'}</p>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-7">
										<div class="eam-title-section">
											<h3 class="h-title">{l s='Withdrawal info' mod='ets_affiliatemarketing'} {if isset($user.can_withdraw2)}{if $user.can_withdraw2 == 1}<small class="title-valid" title="{l s='Valid withdrawal request' mod='ets_affiliatemarketing'}">{l s='Valid' mod='ets_affiliatemarketing'}</small>{else}<small class="title-invalid" title="{l s=' Account balance (withdrawable) is not sufficient for the withdrawal request' mod='ets_affiliatemarketing'}">{l s='Invalid' mod='ets_affiliatemarketing'}</small>{/if}{/if}</h3>
										</div>
										<div class="form-horizontal">
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Withdrawal amount' mod='ets_affiliatemarketing'}</em>
													:
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.amount_withdraw|escape:'html':'UTF-8'}{if $user.fee_amount} <em>({l s='Withdrawal fee included' mod='ets_affiliatemarketing'})</em>{/if} </p>
												</div>
											</div>
                                            <div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Amount to pay' mod='ets_affiliatemarketing'}</em>
													:
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.amount_pay|escape:'html':'UTF-8'}</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Payment method' mod='ets_affiliatemarketing'}</em>
													:
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.payment_method_name|escape:'html':'UTF-8'}</p>
												</div>
											</div>
                                            {if $user.fee_type!='NO_FEE'}
    											<div class="row">
    												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Fee type' mod='ets_affiliatemarketing'}</em>
    													:
    												</label>
    												<div class="col-lg-6 col-sm-6">
    													{if $user.fee_type == 'FIXED'}
    														<p class="form-control-static">{l s='Fee fixed' mod='ets_affiliatemarketing'}</p>
    													{else}
    														<p class="form-control-static">{l s='Fee percentage' mod='ets_affiliatemarketing'}</p>
    													{/if}
    												</div>
    											</div>
    											<div class="row">
    												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Fee value' mod='ets_affiliatemarketing'}</em>
    													:
    												</label>
    												<div class="col-lg-6 col-sm-6">
    													{if $user.fee_type == 'FIXED'}
    														<p class="form-control-static">{$user.fee_amount|escape:'html':'UTF-8'}</p>
    													{else}
    														<p class="form-control-static">{$user.fee|escape:'html':'UTF-8'} %({$user.fee_amount|escape:'html':'UTF-8'})</p>
    													{/if}
    												</div>
    											</div>
                                            {/if}
											{foreach $user.payment_method_field as $pmf}
												<div class="row">
													<label class="control-label col-lg-6 col-sm-6"><em>{$pmf.title|escape:'html':'UTF-8'}</em>
														:
													</label>
													<div class="col-lg-6">
														<p class="form-control-static">{$pmf.value|escape:'html':'UTF-8'}</p>
													</div>
												</div>
											{/foreach}
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Date of withdrawal' mod='ets_affiliatemarketing'}</em>
													:
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">{$user.datetime_added|escape:'html':'UTF-8'}</p>
												</div>
											</div>
                                            {if $user.invoice}
                                                <div class="row">
                                                    <label class="control-label col-lg-6 col-sm-6"><em>{l s='Invoice' mod='ets_affiliatemarketing'}</em>
    													:
    												</label>
    												<div class="col-lg-6 col-sm-6">
    													<p class="form-control-static"><a href="{$link->getAdminLink('AdminEtsAmWithdrawals')|escape:'html':'UTF-8'}&downloadInvoice=1&id_withdraw={$user.id_withdraw|intval}" title="{l s='Download' mod='ets_affiliatemarketing'}" target="_blank">{$user.invoice|escape:'html':'UTF-8'}</a></p>
    												</div>
                                                </div>
                                            {/if}
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6"><em>{l s='Status' mod='ets_affiliatemarketing'}</em>
													:
												</label>
												<div class="col-lg-6 col-sm-6">
													<p class="form-control-static">
														{if $user.withdraw_status == 0}
															<label class="label label-warning">{l s='Pending' mod='ets_affiliatemarketing'}</label>
														{elseif $user.withdraw_status == 1}
															<label class="label label-success">{l s='Approved' mod='ets_affiliatemarketing'}</label>
														{elseif $user.withdraw_status == -1}
															<label class="label label-default">{l s='Decline' mod='ets_affiliatemarketing'}</label>
														{/if}
													</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-5 eam-col-rp pl-15">
								<div class="form-group">
									<form action="" method="POST" accept-charset="utf-8">
										<input type="hidden" name="id_usage" value="{$user.id_usage|escape:'html':'UTF-8'}">
										{if $user.withdraw_status == 0}
											<button type="submit" name="submitApproveWithdrawItem" class="btn btn-default js-confirm-approve-withdraw mb-5"><i class="fa fa-check"></i> {l s='Approve' mod='ets_affiliatemarketing'}</button>
											<button type="submit" name="submitDeclineReturnWithdrawItem" class="btn btn-default js-confirm-decline-return-withdraw mb-5"><i class="fa fa-undo"></i> {l s='Decline - Return reward' mod='ets_affiliatemarketing'}</button>
											<button type="submit" name="submitDeclineDeductWithdrawItem" class="btn btn-default js-confirm-decline-deduct-withdraw mb-5"><i class="fa fa-close"></i> {l s='Decline - Deduct reward' mod='ets_affiliatemarketing'}</button>
										{/if}
										<button type="submit" name="submitDeleteWithdrawItem" class="btn btn-default js-confirm-delete-withdraw mb-5"><i class="fa fa-trash"></i> {l s='Delete' mod='ets_affiliatemarketing'}</button>
										
									</form>
								</div>
								<div class="divider-horizontal"></div>	
								<div class="form-group">
									<form action="" method="POST" accept-charset="utf-8">
										<div class="form-group">
											<label><em>{l s='Note' mod='ets_affiliatemarketing'}</em>
											</label>
											<textarea name="note" rows="3">{$user.note|escape:'html':'UTF-8'}</textarea>
										</div>
										<input type="hidden" name="id_usage" value="{$user.id_usage|escape:'html':'UTF-8'}">
										<div class="form-group">
											<button type="submit" name="submitSaveNoteWithdrawal" class="btn btn-default"><i class="fa fa-save"></i> {l s='Save note' mod='ets_affiliatemarketing'}</button>
										</div>
									</form>
								</div>
							</div>						
						</div>
					</div>
					<div class="divider-horizontal"></div>	
					<div class="row">
						<div class="col-lg-12">
							<a href="{$link_withdraw|escape:'html':'UTF-8'}" title="" class="btn btn-default"><i class="fa fa-close eam-icon-back"></i> {l s='Back' mod='ets_affiliatemarketing'}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>