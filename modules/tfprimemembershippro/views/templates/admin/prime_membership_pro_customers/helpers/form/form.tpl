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

<div class="panel" id="tf_main">
	<div class="panel-heading">
        {l s='Prime Customers' mod='tfprimemembershippro'}
	</div>
    <form
        method="POST"
        action="{$current|escape:'html':'UTF-8'}&{if !empty($submit_action)}{$submit_action|escape:'html':'UTF-8'}{/if}&token={$token|escape:'html':'UTF-8'}"
        name="tfprimeform"
        enctype="multipart/form-data"
        class="defaultForm form-horizontal">
        <div class="clearfix form-group">
            <label class="control-label required col-lg-3">
                <span
                    title=""
                    data-toggle="tooltip"
                    class="label-tooltip"
                    data-original-title="{l s='Search customers which you want to subscribe mailerlite newsletter' mod='tfprimemembershippro'}">
                    {l s='Search Customers' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-md-4">
                <input type="hidden" name="presta_customer_last_count" value="{if isset($customer_count)}{$customer_count|escape:'html':'UTF-8'}{/if}"/>
                <select name="tf_presta_customer[]" multiple="multiple" id="tf_presta_customer">
                {if isset($customers)}

                    {foreach $customers as $customer}
                        <option
                            value="{$customer.id_customer|escape:'html':'UTF-8'}">
                            ({$customer.id_customer|escape:'html':'UTF-8'}) {$customer.firstname|escape:'html':'UTF-8'} {$customer.lastname|escape:'html':'UTF-8'} ({$customer.email|escape:'html':'UTF-8'})
                        </option>
                    {/foreach}
                {else}
                    <option value="0">{l s='No Customer Found' mod='tfprimemembershippro'}</option>
                {/if}
                </select>
            </div>
            <div class="col-lg-2 presta_img_container">
                <img width="32" src="{$modules_dir|escape:'html':'UTF-8'}tfprimemembershippro/views/img/loader.gif"/>
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="control-label col-lg-3 required">
                <span
                    title=""
                    data-toggle="tooltip"
                    class="label-tooltip"
                    data-original-title="{l s='Select Plan' mod='tfprimemembershippro'}">
                    {l s='Select Plan:' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-4">
                <select name="tf_prime_plan" class="form-control">
                    <option value="0">{l s='Choose plan' mod='tfprimemembershippro'}</option>
                    {if isset($primePlans)}
                        {foreach $primePlans as $plan}
                            <option value="{$plan.id_tf_prime_membership_plan|escape:'html':'UTF-8'}">{$plan.name|escape:'html':'UTF-8'}</option>
                        {/foreach}
                    {/if}
                </select>
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="control-label col-lg-3 required">
                <span
                    title=""
                    data-toggle="tooltip"
                    class="label-tooltip"
                    data-original-title="{l s='Choose start date' mod='tfprimemembershippro'}">
                    {l s='Start Date' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-3 input-group" style="left:6px;">
                <input
                    type="text"
                    name="tf_start_date"
                    class="form-control"
                    id="presta-datetimepicker1"
                    value="{if isset($currentDate)}{$currentDate|escape:'html':'UTF-8'}{/if}"
                    placeholder="YYYY-MM-DD">
                <span class="input-group-addon"><i style="font-size:16px;" class="material-icons">date_range</i></span>
            </div>
        </div>
        <div class="form-group clearfix">
            <a
                class="btn btn-default pull-left"
                href="{$link->getAdminLink('AdminMailerLite')|escape:'html':'UTF-8'}">
                <i class="process-icon-save"> </i>{l s='Cancel' mod='tfprimemembershippro'}
            </a>
            <button
                type="submit"
                name="tfsubmit"
                class="btn btn-primary pull-right">
                <i class="process-icon-save"> </i>{l s='Save' mod='tfprimemembershippro'}
            </button>
        </div>
    </form>
</div>
