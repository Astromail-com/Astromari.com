{**
* 2008-2022 Prestaworld
*
* NOTICE OF LICENSE
*
* The source code of this module is under a commercial license.
* Each license is unique and can be installed and used on only one website.
* Any reproduction or representation total or partial of the module, one or more of its components,
* by any means whatsoever, without express permission from us is prohibited.
*
* DISCLAIMER
*
* Do not alter or add/update to this file if you wish to upgrade this module to newer
* versions in the future.
*
* @author    prestaworld
* @copyright 2008-2022 Prestaworld
* @license https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
* International Registered Trademark & Property of prestaworld
*}

{extends file=$layout}

{block name='content'}
	<section id="main">
		<header class="page-header" style="border: 1px solid #ddd; background: #fff;padding: 10px;border-radius: 5px;box-shadow: 5px 5px #ddd;">
            <div class="clearfix">
                <div class="col-md-9">
                    <h1 style="padding-top:7px;">{l s='My Prime Membership' mod='tfprimemembershippro'}</h1>
                </div>
                <div class="col-md-3">
                    <a href="{url entity='module' name='tfprimemembershippro' controller='primelist'}" style="color:#fff; float:right;" class="btn btn-primary">
                        {l s='Membership List' mod='tfprimemembershippro'}
                    </a>
                </div>
            </div>
		</header>
        <hr>
		{if Configuration::get('TF_PRIME_PRO_DISPLAY_WARNING_CUSTOMER') && isset($presta_expire_warning)}
			<div class="alert alert-warning">
                {l s='Your prime membership is about to expire soon! Renew.' mod='tfprimemembershippro'}
            </div>
		{/if}
		<section class="page-content">
			<table class="table table-hover table-labeled prsta-table">
				<thead class="thead-default">
					<tr>
						<th>{l s='Order Reference' mod='tfprimemembershippro'}</th>
						<th>{l s='Plan Name' mod='tfprimemembershippro'}</th>
						<th>{l s='Plan Price' mod='tfprimemembershippro'}</th>
						<th>{l s='Plan Type' mod='tfprimemembershippro'}</th>
						<th>{l s='Activated Date' mod='tfprimemembershippro'}</th>
						<th style="text-align:center;">{l s='Duration' mod='tfprimemembershippro'}</th>
						<th>{l s='Status' mod='tfprimemembershippro'}</th>
						<th>{l s='Action' mod='tfprimemembershippro'}</th>
					</tr>
				</thead>
				<tbody>
					{if isset($plans)}
						{foreach $plans as $detail}
							<tr>
								<td>{if $detail.reference}{$detail.reference|escape:'html':'UTF-8'}{else}{l s='N/A' mod='tfprimemembershippro'}{/if}</td>
								<td>{$detail.name|escape:'html':'UTF-8'}</td>
								<td>{$detail.price|escape:'html':'UTF-8'}</td>
								<td>{$detail.type|escape:'html':'UTF-8'}</td>
								<td>{$detail.activated_date|escape:'html':'UTF-8'}</td>
								<td align="center">{$detail.timeDuration|escape:'html':'UTF-8' nofilter}</td>
								<td>
									{if $detail.planExpired == 1 && $detail.active == 2}
										{l s='Expired' mod='tfprimemembershippro'}
									{else}
										{$detail.plan_status|escape:'html':'UTF-8'}
									{/if}
								</td>
								<td>
									{if
										$detail.active == 1 &&
										$detail.allow_extend == 1 &&
										$detail.planExpired == 0 &&
										$detail.prime_reference == 0 &&
										Configuration::get('TF_PRIME_PRO_PLAN_EXTEND')
									}
										<a
											type="button"
											class="btn btn-primary"
											href="{$detail.link|escape:'html':'UTF-8'}">
											{l s='Extend' mod='tfprimemembershippro'}
										<a/>
									{/if}

									{if
										$detail.planExpired == 1 &&
										$detail.prime_reference == 0 &&
										Configuration::get('TF_PRIME_PRO_PLAN_RENEW')
									}
										<a
											type="button"
											class="btn btn-primary"
											href="{$detail.link|escape:'html':'UTF-8'}">
											{l s='Renew' mod='tfprimemembershippro'}
										<a/>
									{/if}
									{* {if !isset($presta_config)}---{/if} *}
								</td>
							</tr>
						{/foreach}
					{/if}
				</tbody>
			</table>
			{if !isset($plans)}
				<p class="presta-no-plan">{l s='No active plan found!' mod='tfprimemembershippro'}</p>
			{/if}
		</section>
	</section>
{/block}
