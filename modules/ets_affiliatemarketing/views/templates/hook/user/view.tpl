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
<script type="text/javascript">
    var no_customer_search = '{l s='No customer was found' mod='ets_affiliatemarketing' js=1}';
</script>
<div class="eam-panel-extra eam-view-info-user ets-am-list-app">
	<div class="">
		<div class="row display-flex-nocenter md-block">
			<div class="{if isset($customerParent)}col-lg-6{else}col-lg-8{/if} eam-col-rp">
				<div class="panel">
					<div class="panel-header">
						<h3 class="panel-title"><i class="fa fa-address-card"></i> {l s='User info' mod='ets_affiliatemarketing'}</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6 col-sm-6  col-xs-6">
								<div class="flat">
									<div class="flat-body">
										<div class="form-horizontal">
											<div class="row">
												<label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Full name' mod='ets_affiliatemarketing'}</em></label>
												<div class="col-lg-8 col-sm-6 col-xs-6">
													<p class="form-control-static"><a href="{$customer_link|escape:'html':'UTF-8'}&id_customer={$user.id_customer|intval}&viewcustomer" title="{l s='View customer' mod='ets_affiliatemarketing'}" target="_blank">{if $user.firstname}{$user.firstname|escape:'html':'UTF-8'} {$user.lastname|escape:'html':'UTF-8'}{else}<span class="warning-deleted">{l s='User deleted' mod='ets_affiliatemarketing'} (ID: {$user.id_customer|escape:'html':'UTF-8'})</span>{/if}</a></p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Email' mod='ets_affiliatemarketing'}</em></label>
												<div class="col-lg-8 col-sm-6 col-xs-6">
													<p class="form-control-static">{$user.email|escape:'html':'UTF-8'}</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Birthday' mod='ets_affiliatemarketing'}</em></label>
												<div class="col-lg-8 col-sm-6 col-xs-6">
													<p class="form-control-static">
														{if $user.birthday !== '0000-00-00'}
															{$user.birthday|escape:'html':'UTF-8'}
														{else}
															{l s='Unknown' mod='ets_affiliatemarketing'}
														{/if}
													</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Registration Date' mod='ets_affiliatemarketing'}</em></label>
												<div class="col-lg-8 col-sm-6 col-xs-6">
													<p class="form-control-static">{if $user.date_add}{dateFormat date=$user.date_add full=0}{/if}</p>
												</div>
											</div>
										
											<div class="row">
												<label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Status' mod='ets_affiliatemarketing'}</em></label>
												<div class="col-lg-8 col-sm-6 col-xs-6">
													<p class="form-control-static js-eam-state-btn-view-user">
														{if $user.firstname}
															{if $user.active != 1}
																<span class="label label-default"><i class="icon-remove"></i> {l s='Suspended' mod='ets_affiliatemarketing'}</span>
																<button type="button" class="btn btn-default btn-sm js-action-user-reward" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-action="active"><i class="fa fa-check"></i> {l s='Activate' mod='ets_affiliatemarketing'}</button>
															{else}
																<span class="label label-success"><i class="icon-check"></i> {l s='Active' mod='ets_affiliatemarketing'}</span>
																<button type="button" class="btn btn-default btn-sm js-action-user-reward" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-action="decline"><i class="fa fa-close"></i> {l s='Suspend' mod='ets_affiliatemarketing'}</button>
															{/if}
														{else}
															<span class="label label-default label-deleted">{l s='User deleted' mod='ets_affiliatemarketing'}</span>
														{/if}
													</p>
												</div>
											</div>
											
											{if isset($user.loy_status)}
												<div class="row">
												<label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Loyalty program' mod='ets_affiliatemarketing'}</em></label>
												<div class="col-lg-8 col-sm-6 col-xs-6 js-eam-view-user-programs">
													{if $user.loy_status === 'pending'}
														<span class="label label-warning {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Pending' mod='ets_affiliatemarketing'}</span>
														{if $user.firstname && $user.active == 1}
														<div class="btn-group btn-group-sm js-eam-view-user-group-state-program">
															  <a href="javascript:void(0)" data-id="{$user.id_customer nofilter}" data-program="loy" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="approve" ><i class="fa fa-check"></i> {l s='Approve' mod='ets_affiliatemarketing'}</a>
															  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															    <span class="caret"></span>
															    <span class="sr-only">Toggle Dropdown</span>
															  </button>
															  <ul class="dropdown-menu">
															    <li>
															    	<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="loy" class="js-eam-update-status-program-user" data-status="decline"><i class="fa fa-close"></i> {l s='Decline' mod='ets_affiliatemarketing'}</a>
															    </li>
															  </ul>
														</div>
														{/if}
													{elseif $user.loy_status == 1}
														<span class="label label-success {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Active' mod='ets_affiliatemarketing'}</span>
														{if $user.firstname && $user.active == 1}
														<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="loy" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="suspend" ><i class="fa fa-close"></i> {l s='Suspend' mod='ets_affiliatemarketing'}</a>
														{/if}
													{elseif $user.loy_status == -1}
														<span class="label label-default {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Suspended' mod='ets_affiliatemarketing'}</span>
														{if $user.firstname && $user.active == 1}
														<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="loy" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="approve" ><i class="fa fa-check"></i> {l s='Activate' mod='ets_affiliatemarketing'}</a>
														{/if}
													{elseif $user.loy_status == -2}
														<span class="label label-grey {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Declined' mod='ets_affiliatemarketing'}</span>
														{if $user.firstname && $user.active == 1}
														<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="loy" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="approve" ><i class="fa fa-check"></i> {l s='Activate' mod='ets_affiliatemarketing'}</a>
														{/if}
													{elseif $user.loy_status == 0}
														<p class="form-control-static"><span>{l s='Do not participate' mod='ets_affiliatemarketing'}</span></p>
													{/if}

												</div>
												
												</div>

											{/if}
											{if isset($user.ref_status)}
												<div class="row mt-5">
													<label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Referral program' mod='ets_affiliatemarketing'}</em></label>
													<div class="col-lg-8 col-sm-6 col-xs-6">
														{if $user.ref_status === 'pending'}
															<span class="label label-warning {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Pending' mod='ets_affiliatemarketing'}</span>
															{if $user.firstname && $user.active == 1}
															<div class="btn-group btn-group-sm">
																  <a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="ref" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="approve" ><i class="fa fa-check"></i> {l s='Approve' mod='ets_affiliatemarketing'}</a>
																  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																    <span class="caret"></span>
																    <span class="sr-only">Toggle Dropdown</span>
																  </button>
																  <ul class="dropdown-menu">
																    
																    <li>
																    	<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="ref" class="js-eam-update-status-program-user" data-status="decline"><i class="fa fa-close"></i> {l s='Decline' mod='ets_affiliatemarketing'}</a>
																    </li>
																  </ul>
															</div>
															{/if}
														{elseif $user.ref_status == 1}
															<span class="label label-success {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Active' mod='ets_affiliatemarketing'}</span>
															{if $user.firstname && $user.active == 1}
															<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="ref" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="suspend" ><i class="fa fa-close"></i> {l s='Suspend' mod='ets_affiliatemarketing'}</a>
															{/if}
														{elseif $user.ref_status == -1}
															<span class="label label-default {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Suspended' mod='ets_affiliatemarketing'}</span>
															{if $user.firstname && $user.active == 1}
															<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="ref" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="approve" ><i class="fa fa-check"></i> {l s='Activate' mod='ets_affiliatemarketing'}</a>
															{/if}
														{elseif $user.ref_status == -2}
															<span class="label label-grey {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Declined' mod='ets_affiliatemarketing'}</span>
															{if $user.firstname && $user.active == 1}
															<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="ref" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="approve" ><i class="fa fa-check"></i> {l s='Activate' mod='ets_affiliatemarketing'}</a>
															{/if}
														{elseif $user.ref_status == 0}
															<p class="form-control-static"><span>{l s='Do not participate' mod='ets_affiliatemarketing'}</span></p>
														{/if}

													</div>
												</div>
											{/if}
											{if isset($user.aff_status)}
												<div class="row mt-5">
												<label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Affiliate program' mod='ets_affiliatemarketing'}</em></label>
												<div class="col-lg-8 col-sm-6 col-xs-6">
													{if $user.aff_status === 'pending'}
														<span class="label label-warning {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Pending' mod='ets_affiliatemarketing'}</span>
														{if $user.firstname && $user.active == 1}
														<div class="btn-group btn-group-sm">
															  <a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="aff" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="approve" ><i class="fa fa-check"></i> {l s='Approve' mod='ets_affiliatemarketing'}</a>
															  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															    <span class="caret"></span>
															    <span class="sr-only">Toggle Dropdown</span>
															  </button>
															  <ul class="dropdown-menu">
															   
															    <li>
															    	<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="aff" class="js-eam-update-status-program-user" data-status="decline"><i class="fa fa-close"></i> {l s='Decline' mod='ets_affiliatemarketing'}</a>
															    </li>
															  </ul>
														</div>
														{/if}
													{elseif $user.aff_status == 1}
														<span class="label label-success {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Active' mod='ets_affiliatemarketing'}</span>
														{if $user.firstname && $user.active == 1}
														<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="aff" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="suspend" ><i class="fa fa-close"></i> {l s='Suspend' mod='ets_affiliatemarketing'}</a>
														{/if}
													{elseif $user.aff_status == -1}
														<span class="label label-default {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Suspended' mod='ets_affiliatemarketing'}</span>
														{if $user.firstname && $user.active == 1}
														<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="aff" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="approve" ><i class="fa fa-check"></i> {l s='Activate' mod='ets_affiliatemarketing'}</a>
														{/if}
														{elseif $user.aff_status == -2}
														<span class="label label-grey {if !$user.firstname || $user.active != 1}label-user-suspended{/if}">{l s='Declined' mod='ets_affiliatemarketing'}</span>
														{if $user.firstname && $user.active == 1}
														<a href="javascript:void(0)" data-id="{$user.id_customer|escape:'html':'UTF-8'}" data-program="aff" class="js-eam-update-status-program-user btn btn-default btn-sm" data-status="approve" ><i class="fa fa-check"></i> {l s='Approve' mod='ets_affiliatemarketing'}</a>
														{/if}
													{elseif $user.aff_status == 0}
														<p class="form-control-static"><span>{l s='Do not participate' mod='ets_affiliatemarketing'}</span></p>
													{/if}

												</div>
												</div>
											{/if}
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6 col-xs-6">
								<div class="flat">
									<div class="flat-body">
										<div class="form-horizontal">
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Total reward balance' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='The remaining amount of reward after converting into voucher, withdrawing or paying for orders' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<p class="form-control-static" id="total_balance">{$user.total_balance|escape:'html':'UTF-8'}</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Loyalty program' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='The remaining amount of reward which this user earned from Loyalty program' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<p class="form-control-static" id="loy_rewards">{$user.loy_rewards|escape:'html':'UTF-8'}</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Referral program' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='The remaining amount of reward which this user earned from Referral program' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<p class="form-control-static" id="ref_rewards">{$user.ref_rewards|escape:'html':'UTF-8'}</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Affiliate program' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='The remaining amount of reward which this user earned from Affiliate program' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<p class="form-control-static" id="aff_rewards">{$user.aff_rewards|escape:'html':'UTF-8'}</p>
												</div>
											</div>
                                            <div class="row">
												<label class="control-label col-lg-6 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Other programs' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='The remaining amount of reward which this user earned from other programs' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<p class="form-control-static" id="mnu_rewards">{$user.mnu_rewards|escape:'html':'UTF-8'}</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Withdrawn' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total reward amount this user successfully withdrew' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<p class="form-control-static" id="withdrawn">{$user.withdrawn|escape:'html':'UTF-8'}</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Paid for orders' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total reward amount this user used to pay for orders' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<p class="form-control-static" id="pay_for_order">{$user.pay_for_order|escape:'html':'UTF-8'}</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Converted to voucher' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total reward amount this user converted to voucher' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<p class="form-control-static" id="convert_to_voucher">{$user.convert_to_voucher|escape:'html':'UTF-8'}</p>
												</div>
											</div>
											<div class="row">
												<label class="control-label col-lg-6 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Total used' mod='ets_affiliatemarketing'}</em>
													<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{l s='Total reward amount this user spent for withdrawal, paying for orders and converting to vouchers' mod='ets_affiliatemarketing'}"><i class="fa fa-question-circle"></i></a>
												</label>
												<div class="col-lg-6 col-sm-6 col-xs-6">
													<p class="form-control-static" id="total_usage">{$user.total_usage|escape:'html':'UTF-8'}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            {if isset($customerParent)}
                <div class="col-lg-3 eam-col-rp md-mt-15">
                    <div class="panel">
    					<div class="panel-header">
    						<h3 class="panel-title"><i class="fa fa-database"></i> {l s='Sponsor info' mod='ets_affiliatemarketing'}</h3>
    					</div>
    					<div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-xs-12">
                                    <div class="flat">
                                        <div class="flat-body">
                                            <div class="form-horizontal">
                                                <div class="row">
                                                    <label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7">
                                                        <em>{l s='Full name' mod='ets_affiliatemarketing'}</em>
                                                    </label>
                                                    <div class="col-lg-8 col-sm-6 col-xs-6">
                                                        <p class="form-control-static">
                                                            <a href="{$linkParent|escape:'html':'UTF-8'}" title="{l s='View customer' mod='ets_affiliatemarketing'}" target="_blank">{$customerParent->firstname|escape:'html':'UTF-8'}&nbsp;{$customerParent->lastname|escape:'html':'UTF-8'}</a>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
    												<label class="control-label col-lg-4 col-sm-6 col-xs-6 text-right pt-7"><em>{l s='Email' mod='ets_affiliatemarketing'}</em></label>
    												<div class="col-lg-8 col-sm-6 col-xs-6">
    													<p class="form-control-static">{$customerParent->email|escape:'html':'UTF-8'}</p>
    												</div>
    											</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
			<div class="{if isset($customerParent)}col-lg-3{else}col-lg-4{/if} eam-col-rp md-mt-15">
				<div class="panel">
					<div class="panel-header">
						<h3 class="panel-title"><i class="fa fa-database"></i> {l s='Modify user balance' mod='ets_affiliatemarketing'}</h3>
					</div>
					<div class="panel-body panel-body-deduct">
						<form id="eamFormActionRewardUser" method="POST" class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-3 control-label">{l s='Action' mod='ets_affiliatemarketing'}</label>
								<div class="col-lg-9">
									<select name="action">
										<option value="deduct">{l s='Deduct' mod='ets_affiliatemarketing'}</option>
										<option value="add">{l s='Add' mod='ets_affiliatemarketing'}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">{l s='Amount' mod='ets_affiliatemarketing'}</label>
								<div class="col-lg-9">
									<div class="input-group ">
										<input type="text" name="amount" value="" placeholder="" class="form-control">
										<span class="input-group-addon">{$currency->iso_code|escape:'html':'UTF-8'}</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">{l s='Program' mod='ets_affiliatemarketing'}</label>
								<div class="col-lg-9">
									<select name="type_program">
										<option value="mnu">{l s='--' mod='ets_affiliatemarketing'}</option>
										<option value="loy">{l s='Loyalty program' mod='ets_affiliatemarketing'}</option>
										<option value="aff">{l s='Affiliate program' mod='ets_affiliatemarketing'}</option>
										<option value="ref">{l s='Referral program' mod='ets_affiliatemarketing'}</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">{l s='Reason' mod='ets_affiliatemarketing'}</label>
								<div class="col-lg-9">
									<textarea name="reason" class="form-control">{l s='Deducted by Shop owner' mod='ets_affiliatemarketing'}</textarea>
								</div>
							</div>
                            <script type="text/javascript">
                                var reason_deducted ='{l s='Deducted by Shop owner' mod='ets_affiliatemarketing' js='1'}';
                                var reason_add ='{l s='Added by Shop owner' mod='ets_affiliatemarketing' js='1'}';
                            </script>
							<div class="form-group text-right">
								<div class="col-lg-12">
									<button type="submit" name="deduct_reward_by_admin" class="btn btn-default"><i class="fa fa-minus-circle"></i> {l s='Deduct' mod='ets_affiliatemarketing'}</button>
									<button type="submit" name="add_reward_by_admin" class="btn btn-default" style="display: none;"><i class="fa fa-plus-circle"></i> {l s='Add' mod='ets_affiliatemarketing'}</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="eam-ox-auto">
			<div class="eam-minwidth-1000">
				<div class="panel">
					<div class="panel-header">
						<h3 class="panel-title"><i class="fa fa-undo"></i> {l s='Reward history' mod='ets_affiliatemarketing'}</h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive" style="overflow: initial;">
							<table class="table" id="table-history-reward" style="min-width: auto;">
								<thead>
									<tr>
										<th>{l s='Reward ID' mod='ets_affiliatemarketing'}</th>
										<th>{l s='Program' mod='ets_affiliatemarketing'}</th>
										<th>{l s='Reward' mod='ets_affiliatemarketing'}</th>
										<th>{l s='Reward status' mod='ets_affiliatemarketing'}</th>
										<th>{l s='Date created' mod='ets_affiliatemarketing'}</th>
										<th>{l s='Note' mod='ets_affiliatemarketing'}</th>
                                        <th>{l s='Product' mod='ets_affiliatemarketing'}</th>
										<th class="text-right">{l s='Action' mod='ets_affiliatemarketing'}</th>
									</tr>
								</thead>
								<tbody class="body-table">
									{if $reward_history.results}
										{foreach $reward_history.results as $result}
											<tr>
												<td>{$result.id_ets_am_reward|escape:'html':'UTF-8'}</td>
												<td>{$result.program|escape:'html':'UTF-8'}</td>
												<td>
													{if $result.amount|strpos:'-' !== false}
			                                            <span class="eam-reward-usage">{$result.amount|escape:'html':'UTF-8'}</span>
			                                        {else}
			                                            {$result.amount|escape:'html':'UTF-8'}
			                                        {/if}
												</td>
												<td>
                                                    {if $result.type=='usage'}
                                                        {if $result.status==0}
                                                            <label class="label label-refunded">{l s='Refunded' mod='ets_affiliatemarketing'}</label>
                                                        {else}
                                                             <label class="label label-deducted">{l s='Deducted' mod='ets_affiliatemarketing'}</label>
                                                        {/if}
                                                    {else}
                                                        {if $result.status == -2}
			                                            <label class="label label-danger">{l s='Expired' mod='ets_affiliatemarketing'}</label>
    			                                        {elseif $result.status == -1}
    			                                            <label class="label label-default">{l s='Canceled' mod='ets_affiliatemarketing'}</label>
    			                                        {elseif $result.status == 0}
    			                                            <label class="label label-warning">{l s='Pending' mod='ets_affiliatemarketing'}</label>
    			                                        {else}
    			                                            <label class="label label-success">{l s='Approved' mod='ets_affiliatemarketing'}</label>
    			                                        {/if}
                                                    {/if}
												</td>
												<td>{$result.datetime_added nofilter}</td>
												<td>{$result.note nofilter}</td>
                                                <td>{$result.product_name nofilter}</td>
												<td class="text-right">
													{if count($result.actions) > 1}
                                                    {if $result.type=='usage'}
                                                        <div class="btn-group">
                                                            {if $result.status==0}
                                                                <button class="btn btn-default js-approve-reward-usage-item" type="button" data-id="{$result.actions[0].id|escape:'html':'UTF-8'}" {if isset($result.actions[0].action)}data-action="{$result.actions[0].action|escape:'html':'UTF-8'}"{/if}>
                                                                    <i class="fa fa-minus"></i>
                                                                    {l s='Deduct' mod='ets_affiliatemarketing'}
                                                                </button>
                                                            {else}
                                                                <button class="btn btn-default js-cancel-reward-usage-item" type="button" data-id="{$result.actions[0].id|escape:'html':'UTF-8'}" {if isset($result.actions[0].action)}data-action="{$result.actions[0].action|escape:'html':'UTF-8'}"{/if}>
                                                                    <i class="fa fa-rotate-right"></i>
                                                                        {l s='Refund' mod='ets_affiliatemarketing'}
                                                                </button>
                                                            {/if}
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        			                                            <span class="caret"></span>
        			                                            <span class="sr-only">Toggle Dropdown</span>
   			                                                  </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="js-delete-reward-usage-item" href="javascript:void(0)" data-id="{$result.actions[0].id|escape:'html':'UTF-8'}">
                                                                        <i class="fa fa-trash"></i>
                                                                        {l s='Delete' mod='ets_affiliatemarketing'}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    {else}
    			                                        <div class="btn-group">
    			                                          <button type="button" class="btn btn-default {$result.actions[0].class|escape:'html':'UTF-8'}" data-id="{$result.actions[0].id|escape:'html':'UTF-8'}" {if isset($result.actions[0].action)}data-action="{$result.actions[0].action|escape:'html':'UTF-8'}"{/if}><i class="fa fa-{$result.actions[0].icon|escape:'html':'UTF-8'}"></i> {$result.actions[0].label|escape:'html':'UTF-8'}</button>
    			                                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    			                                            <span class="caret"></span>
    			                                            <span class="sr-only">Toggle Dropdown</span>
    			                                          </button>
    			                                          <ul class="dropdown-menu">
    			                                            {foreach $result.actions as $k=>$v}
    			                                                {if $k > 0}
    			                                                <li><a href="javascript:void(0)" data-id="{$v.id|escape:'html':'UTF-8'}" class="{$v.class|escape:'html':'UTF-8'}" {if isset($v.action)}data-action="{$v.action|escape:'html':'UTF-8'}"{/if}><i class="fa fa-{$v.icon|escape:'html':'UTF-8'}"></i> {$v.label|escape:'html':'UTF-8'}</a></li>
    			                                                {/if}
    			                                            {/foreach}
    			                                          </ul>
    			                                        </div>
                                                    {/if}
			                                    {elseif count($result.actions) == 1}
			                                        <button href="javascript:void(0)" class="btn btn-default {$result.actions[0].class|escape:'html':'UTF-8'}" {if isset($result.actions[0].action)}data-action="{$result.actions[0].action|escape:'html':'UTF-8'}"{/if} data-id="{$result.actions[0].id|escape:'html':'UTF-8'}"><i class="fa fa-{$result.actions[0].icon|escape:'html':'UTF-8'}"></i> {$result.actions[0].label|escape:'html':'UTF-8'}</button>
			                                    {/if}
												</td>
											</tr>
										{/foreach}
									{else}
										<tr class="text-center">
											<td colspan="100%">{l s='No data found' mod='ets_affiliatemarketing'}</td>
										</tr>
									{/if}
								</tbody>
							</table>
						</div>
						<div class="show-more text-center mt-15">
							{if $reward_history.total_page > 1}
							<button type="button" class="btn btn-default js-btn-show-more-reawrd-history" data-id-customer="{$user.id_customer|escape:'html':'UTF-8'}" data-current-page="{$reward_history.current_page|escape:'html':'UTF-8'}" data-total-page="{$reward_history.total_page|escape:'html':'UTF-8'}">{l s='Show more' mod='ets_affiliatemarketing'}</button>
							{/if}
						</div>
					</div>
				</div>
				<div class="panel">
					<div class="panel-header">
						<h3 class="panel-title">
							<i class="fa fa-user-plus"></i> {l s='Sponsored friends' mod='ets_affiliatemarketing'}
							<span class="panel-heading-action">
								<span class="btn btn-default action_add_friend_user" title="" data-html="true" >
									<i class="icon-plus-circle"></i> {l s='Add friend' mod='ets_affiliatemarketing'}
								</span>
							</span>
						</h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive" style="overflow: initial;">
							<table class="table" id="table-sponsored-friends" style="min-width: auto;">
								<thead>
									<tr>
										<th>{l s='Customer ID' mod='ets_affiliatemarketing'}</th>
										<th>{l s='Name' mod='ets_affiliatemarketing'}</th>
                                        <th>{l s='Email' mod='ets_affiliatemarketing'}</th>
										<th class="text-center">{l s='Level' mod='ets_affiliatemarketing'}</th>
										<th class="text-center">{l s='Total spent' mod='ets_affiliatemarketing'}</th>
										<th class="text-right">{l s='Earning reward approved' mod='ets_affiliatemarketing'}</th>
									</tr>
								</thead>
								<tbody class="body-table">
									{if $sponsors.result}
										{foreach $sponsors.result as $sponsor}
											<tr>
												<td>
													{$sponsor.id_customer|escape:'html':'UTF-8'}
												</td>
												<td>
													<a href="{$customer_link nofilter}&id_customer={$sponsor.id_customer nofilter}&viewcustomer">
														{if $sponsor.firstname}
															{$sponsor.firstname|escape:'html':'UTF-8'} {$sponsor.lastname|escape:'html':'UTF-8'}
														{else}
														<span class="warning-deleted label">{l s='User deleted' mod='ets_affiliatemarketing'}</span>
														{/if}
													</a>
												</td>
                                                <td>{$sponsor.email|escape:'html':'UTF-8'}</td>
												<td class="text-center">{$sponsor.level|escape:'html':'UTF-8'}</td>
												<td class="text-center">{$sponsor.total_order|escape:'html':'UTF-8'}</td>
												<td class="text-right">{$sponsor.total_point|escape:'html':'UTF-8'}</td>
											</tr>
										{/foreach}
									{else}
									<tr>
										<td colspan="100%" class="text-center aff_data_not_found">{l s='No data found' mod='ets_affiliatemarketing'}</td>
									</tr>
									{/if}
								</tbody>
							</table>
						</div>
						<div class="show-more text-center mt-15">
							{if $sponsors.total_page > 1}
							<button type="button" class="btn btn-default js-btn-show-more-sponsored-friends" data-id-customer="{$user.id_customer|escape:'html':'UTF-8'}" data-current-page="{$sponsors.current_page|escape:'html':'UTF-8'}" data-total-page="{$sponsors.total_page|escape:'html':'UTF-8'}">{l s='Show more' mod='ets_affiliatemarketing'}</button>
							{/if}
						</div>
					</div>
				</div>
                <div class="aff_popup_wapper">
					<div class="popup_table">
						<div class="popup_tablecell">
							<div class="aff_popup_content">
								<span class="aff_close_popup">{l s='Close' mod='ets_affiliatemarketing'}</span>
								<div class="form-group no-mg-bottom">
									<label class="control-label col-lg-12"> {l s='Search for customers' mod='ets_affiliatemarketing'} </label>
									<div class="col-lg-12">
										<div class="input-group ">
											<input id="" class="" name="aff_search_customer" value="" type="text" placeholder="{l s='Search for customer by ID, email or name' mod='ets_affiliatemarketing'}" />
											<span class="input-group-addon"> <i class="icon icon-search"></i></span>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<div class="aff-list-customer-search">

									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
			</div>
		</div>
		<div class="footer-view md-mt-15">
			<a class="btn btn-default" href="{$link_admin nofilter}&tabActive=reward_users"><i class="fa fa-close eam-icon-back"></i> {l s='Back' mod='ets_affiliatemarketing'}</a>
		</div>
	</div>
</div>
{if $enable_email_approve_app == 1}
<div class="modal fade" id="modalReasonDeclineApp" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{l s='Send an message to customer via email?' mod='ets_affiliatemarketing'}</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <textarea name="reason" class="form-control" rows="5" placeholder="{l s='Messages' mod='ets_affiliatemarketing'}"></textarea>
        </div>
        <p><em>{l s='Give customer a reason why their application is declined. Leave this blank if you just want to decline the application without giving any reason' mod='ets_affiliatemarketing'}</em></p>
        <div class="form-group">
            <button type="button" id="submit_reason_decline" class="btn btn-default">{l s='Decline' mod='ets_affiliatemarketing'}</button>
        </div>
        </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{/if}
{if $enable_email_decline_app == 1}
<div class="modal fade" id="modalReasonAproveApp" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{l s='Send an message to customer via email?' mod='ets_affiliatemarketing'}</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <textarea name="reason" class="form-control" rows="5" placeholder="{l s='Messages' mod='ets_affiliatemarketing'}"></textarea>
        </div>
            <p><em>{l s='Give customer a reason why their application is approved. Leave this blank if you just want to approve the application without giving any reason' mod='ets_affiliatemarketing'}</em></p>
            <div class="form-group">
                <button type="button" id="submit_reason_approve" class="btn btn-default">{l s='Approve' mod='ets_affiliatemarketing'}</button>
            </div>
        </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{/if}