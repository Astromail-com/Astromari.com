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
	<section id="tfmain">
		<header class="page-header" style="border: 1px solid #ddd; background: #fff;padding: 10px;border-radius: 5px;box-shadow: 5px 5px #ddd;">
            <div class="clearfix">
                <div class="col-md-9">
                    <h1 style="padding-top:7px;">{l s='Prime Membership Plans' mod='tfprimemembershippro'}</h1>
                </div>
                <div class="col-md-3">
                    <a href="{url entity='module' name='tfprimemembershippro' controller='myprime'}" style="color:#fff; float:right;" class="btn btn-primary">
                        {l s='My Membership' mod='tfprimemembershippro'}
                    </a>
                </div>
            </div>
		</header>
        <hr>
		<section class="page-content">
            <div class="row">
                {if isset($plans) && $plans}
                    {foreach $plans as $plan}
                        <div class="col-xs-12 col-sm-4">
                            <div class="price-box">
                                <a {if Configuration::get('TF_PRIME_PRO_MEMBERSHIP_PLAN_AS_PROD')}href="{$plan.link|escape:'html':'UTF-8'}"{else}href="javascript:void(0);"{/if} >
                                    <div class="price-header">
                                        <div class="price-icon">
                                            <span class="lnr lnr-rocket">
                                                <img src="{$plan.img_name|escape:'html':'UTF-8'}" width="150" height="159" />
                                            </span>
                                        </div>
                                        <h4 class="upper">{$plan.name|escape:'html':'UTF-8'}</h4>
                                        {if !Configuration::get('TF_PRIME_PRO_MEMBERSHIP_PLAN_DESCRIPTION')}
                                            <div class="presta-desc">
                                                {$plan.description|escape:'html':'UTF-8'}
                                            </div>
                                        {/if}
                                    </div>
                                </a>
                                {if !Configuration::get('TF_PRIME_PRO_MEMBERSHIP_PLAN_DESC')}
                                    {* {assign var="features" value=","|explode:$plan.features} *}
                                    <div class="price-body">
                                        <button
                                            type="button"
                                            class="btn btn-outline-primary"
                                            id="presta_features"
                                            data-plan-img="{$plan.img_name|escape:'html':'UTF-8'}"
                                            data-name="{$plan.name|escape:'html':'UTF-8'}"
                                            data-features="{$plan.features|escape:'html':'UTF-8'}"
                                            data-duration="{$plan.duration|escape:'html':'UTF-8'}"
                                            data-plan-type="{$plan.type|escape:'html':'UTF-8'}"
                                            data-plan-price="{$plan.price|escape:'html':'UTF-8'}"
                                            data-purchase-url="{url entity='module' name='tfprimemembershippro' controller='primeprocess' params=['id' => $plan.id_tf_prime_membership_plan|escape:'html':'UTF-8']}">
                                            {l s='View Features' mod='tfprimemembershippro'}
                                        </button>
                                    </div>
                                {/if}
                                {if !Configuration::get('TF_PRIME_PRO_MEMBERSHIP_PLAN_PRICE')}
                                    <div class="price-rate">
                                        <span class="rate">{$plan.price|escape:'html':'UTF-8'}</span><br><br>
                                        <div>

                                                <small>
                                                    {if $plan.duration == 1}
                                                        {l s='Duration : ' mod='tfprimemembershippro'}
                                                        {$plan.duration|escape:'html':'UTF-8'}
                                                        {$plan.type|escape:'html':'UTF-8'}
                                                    {else}
                                                        {l s='Duration : ' mod='tfprimemembershippro'}
                                                        {$plan.duration|escape:'html':'UTF-8'}
                                                        {$plan.type|escape:'html':'UTF-8'}{l s='(s)' mod='tfprimemembershippro'}
                                                    {/if}
                                                </small>

                                        </div>
                                    </div>
                                {/if}
                                {if !Configuration::get('TF_PRIME_PRO_MEMBERSHIP_BUY_BUTTON')}
                                    <div class="price-footer">
                                        <a
                                            href="{url entity='module' name='tfprimemembershippro' controller='primeprocess' params=['id' => $plan.id_tf_prime_membership_plan|escape:'html':'UTF-8']}"
                                            class="bttn-white">{l s='Purchase' mod='tfprimemembershippro'}
                                        </a>
                                    </div>
                                {/if}
                            </div>
                            <div class="tfbottom space-30 hidden visible-xs"></div>
                        </div>
                    {/foreach}
                {else}
                    <p class="presta-no-plan">{l s='No plan found!' mod='tfprimemembershippro'}</p>
                {/if}
		</section>
        <p></p>
	</section>
    {if isset($plans) && $plans}
        <div
            class="modal fade"
            id="prestaModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="prestaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <div class="modal-body presta-modal-body clearfix">
                        <div class="col-md-5">
                            <span class="lnr lnr-rocket presta-modal-plan-img">
                                <img src=""/>
                            </span>
                        </div>
                        <div class="col-md-7">
                            <div class="h4 presta-plan-name"></div>
                            <div class="presta-duration">
                                {l s='Duration : ' mod='tfprimemembershippro'}
                                <span id="presta_duration"></span>
                            </div>
                            <div class="presta-price">
                                {l s='Price : ' mod='tfprimemembershippro'}
                                <strong><span id="presta_price"></span></strong>
                            </div>
                            <div class="presta-card">
                                <h5>
                                    <span>{l s='This plan has' mod='tfprimemembershippro'}</span>
                                    <span class="presta-features-count"></span>
                                    <span>{l s='features' mod='tfprimemembershippro'}</span>
                                </h5>
                            </div>
                            <ul class="presta-prime-features"></ul>
                        </div>
                        <div class="col-md-12 presta-modal-footer">
                            <button
                                type="button"
                                class="presta-modal-close btn btn-secondary"
                                data-dismiss="modal"
                                aria-label="Close">
                                {l s='close' mod='tfprimemembershippro'}
                            </button>
                            <a
                                href="{url entity='module' name='tfprimemembershippro' controller='primeprocess' params=['id' => $plan.id_tf_prime_membership_plan|escape:'html':'UTF-8']}"
                                class="btn btn-primary presta-modal-purchase-btn">
                                {l s='Purchase' mod='tfprimemembershippro'}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
{/block}
