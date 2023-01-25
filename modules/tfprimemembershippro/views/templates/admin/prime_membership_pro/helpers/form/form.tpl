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

<div class="panel">
    <div class="panel-heading">
        {if isset($tfPrimeMembershipPlan)}
            <i class="icon-pencil"></i>
            {l s='Edit Membership Plan' mod='tfprimemembershippro'}
        {else}
            <i class="icon-plus"></i>
            {l s='Create New Membership' mod='tfprimemembershippro'}
        {/if}
    </div>
    <div class="alert alert-info">
        {if isset($tfPrimeMembershipPlan)}
            {l s='Do not delete Product ID ([1]) and Customer Group ID ([/1]). It is associated with this membership plan.'
                sprintf=[
                '[1]' => $tfPrimeMembershipPlan->id_product,
                '[/1]' => $tfPrimeMembershipPlan->id_customer_group
                ]
                mod='tfprimemembershippro'
            }
        {else}
            {l s='Membership plan will create a product and customer group same as membership plan name. You should not delete that product and customer group' mod='tfprimemembershippro'}
        {/if}
    </div>
    <form
        method="post"
        class="defaultForm form-horizontal"
        action="{$current|escape:'html':'UTF-8'}&token={$token|escape:'html':'UTF-8'}"
        enctype="multipart/form-data">
        <div class="panel-body">
        {if isset($tfPrimeMembershipPlan)}
            <input type="hidden" name="id" value="{$tfPrimeMembershipPlan->id|escape:'html':'UTF-8'}" />
        {/if}
        <div class="clearfix form-group">
            <label class="col-lg-3 control-label required">
                <span
                    class="label-tooltip"
                    data-toggle="tooltip"
                    title="{l s='Name your membership plan. Not more than 32 characters' mod='tfprimemembershippro'}">
                    {l s='Membership Name' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-6">
                <div class="col-lg-8">
                    {foreach from=$languages item=language}
                        {assign var="presta_current_div" value="presta_current_div_`$language.id_lang`"}
                        {assign var="name" value="name_`$language.id_lang`"}
                        <div
                            class="presta_main_div {$presta_current_div|escape:'html':'UTF-8'}"
                            {if $current_lang.id != $language.id_lang}style="display:none;"{/if}>
                            <input
                                type="text"
                                id="name_{$language.id_lang|escape:'html':'UTF-8'}"
                                name="{$name|escape:'html':'UTF-8'}"
                                class="form-control"
                                value="{if isset($smarty.post.{$name|escape:'html':'UTF-8'})}{$smarty.post.{$name|escape:'html':'UTF-8'}|escape:'html':'UTF-8'}{else if isset($tfPrimeMembershipPlan->name[$language.id_lang]) && $tfPrimeMembershipPlan->name[$language.id_lang]}{$tfPrimeMembershipPlan->name[$language.id_lang]|escape:'html':'UTF-8'}{/if}" />
                        </div>
                    {/foreach}
                    <div class="help-block">
                        {l s='A Product & Customer group will be created with same name' mod='tfprimemembershippro'}
                    </div>
                </div>
                {if count($languages) > 1}
                    <div class="col-sm-1">
                        <button
                            type="button"
                            class="btn btn-default dropdown-toggle presta_caret"
                            data-toggle="dropdown">
                            {$current_lang.iso_code|escape:'html':'UTF-8'}
                            <span class="caret" style="margin-left:5px;"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=language}
                                <li>
                                    <a
                                        href="javascript:void(0)"
                                        onclick="showLangField('{$language.iso_code|escape:'html':'UTF-8'}', {$language.id_lang|escape:'html':'UTF-8'});">{$language.name|escape:'html':'UTF-8'}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="col-lg-3 control-label required">
                <span
                    class="label-tooltip"
                    data-toggle="tooltip"
                    title="{l s='You can define a short description of the membership here.' mod='tfprimemembershippro'}">
                    {l s='Description' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-9">
                <div class="col-lg-8">
                    {foreach from=$languages item=language}
                        {assign var="presta_current_div" value="presta_current_div_`$language.id_lang`"}
                        {assign var="presta_description" value="presta_description_`$language.id_lang`"}
                        <div class="presta_main_div {$presta_current_div|escape:'html':'UTF-8'}" {if $current_lang.id != $language.id_lang}style="display:none;"{/if}>
                            <textarea
                                col="15"
                                rows="15"
                                name="{$presta_description|escape:'html':'UTF-8'}"
                                data-lang-name="{$language.name|escape:'html':'UTF-8'}"
                                class="form-control autoload_rte">{if isset($smarty.post.{$presta_description})}{$smarty.post.{$presta_description} nofilter}{else if isset($tfPrimeMembershipPlan->description[$language.id_lang|escape:'html':'UTF-8']) && $tfPrimeMembershipPlan->description[$language.id_lang|escape:'html':'UTF-8']}{$tfPrimeMembershipPlan->description[$language.id_lang|escape:'html':'UTF-8'] nofilter}{/if}</textarea>
                        </div>
                    {/foreach}
                    <div class="help-block">
                        {l s='Description will be added to product description.' mod='tfprimemembershippro'}
                    </div>
                </div>
                {if count($languages) > 1}
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-default dropdown-toggle presta_caret" data-toggle="dropdown">
                            {$current_lang.iso_code|escape:'html':'UTF-8'}
                            <span class="caret" style="margin-left:5px;"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=language}
                                <li>
                                    <a
                                        href="javascript:void(0)"
                                        onclick="showLangField('{$language.iso_code|escape:'html':'UTF-8'}', {$language.id_lang|escape:'html':'UTF-8'});">{$language.name|escape:'html':'UTF-8'}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="col-lg-3 control-label required">
                <span
                    class="label-tooltip"
                    data-toggle="tooltip"
                    title="{l s='Choose membership plan type.' mod='tfprimemembershippro'}">
                    {l s='Membership Type' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-2">
                <select name="type">
                    <option
                        {if isset($smarty.post.type) && $smarty.post.type == 'days'}
                            selected="selected"
                        {else if isset($tfPrimeMembershipPlan) && $tfPrimeMembershipPlan->type == 'days'}
                            selected="selected"
                        {/if}
                        value="days"
                        selected="selected">
                        {l s='Day(s)' mod='tfprimemembershippro'}
                    </option>
                    <option
                    {if isset($smarty.post.type) && $smarty.post.type == 'months'}
                            selected="selected"
                        {else if isset($tfPrimeMembershipPlan) && $tfPrimeMembershipPlan->type == 'months'}
                            selected="selected"
                        {/if}
                        value="months">
                        {l s='Month(s)' mod='tfprimemembershippro'}
                    </option>
                    <option
                        {if isset($smarty.post.type) && $smarty.post.type == 'years'}
                            selected="selected"
                        {else if isset($tfPrimeMembershipPlan) && $tfPrimeMembershipPlan->type == 'years'}
                            selected="selected"
                        {/if}
                        value="years">
                        {l s='Year(s)' mod='tfprimemembershippro'}
                    </option>
                </select>
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="col-lg-3 control-label required">
                <span
                    class="label-tooltip"
                    data-toggle="tooltip"
                    title="{l s='Duration will be based on membership type' mod='tfprimemembershippro'}">
                    {l s='Duration' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-2">
                <input
                    type="text"
                    name="duration"
                    class="form-control"
                    {if isset($smarty.post.duration)}
                    value="{$smarty.post.duration|escape:'html':'UTF-8'}" {elseif isset($tfPrimeMembershipPlan)}
                    value="{$tfPrimeMembershipPlan->duration|escape:'html':'UTF-8'}"
                    {/if}/>
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="col-lg-3 control-label required">
                <span
                    class="label-tooltip"
                    data-toggle="tooltip"
                    title="{l s='Set price for your membership plan.' mod='tfprimemembershippro'}">
                    {l s='Membership Price' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-2">
                <div class="input-group">
                    <input
                        type="text"
                        name="price"
                        class="form-control"
                        {if isset($smarty.post.price)}
                        value="{$smarty.post.price|escape:'html':'UTF-8'}" {elseif isset($tfPrimeMembershipPlan)}
                        value="{Tools::ps_round($tfPrimeMembershipPlan->price, 2)|escape:'html':'UTF-8'}"
                        {/if}/>
                    <span class="input-group-addon" style="width: 35px;background: #25b9d7;color:#fff;">
                        {$sign|escape:'html':'UTF-8'}
                    </span>
                </div>
                <div class="help-block">{l s='Price will be in default currency' mod='tfprimemembershippro'}</div>
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="col-lg-3 control-label required">
                <span
                    class="label-tooltip"
                    data-toggle="tooltip">
                    {l s='Tax Rule' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-2">
                <select name="tax_rule" class="presta_tax_rule">
                    <option value="0">{l s='No Tax' mod='tfprimemembershippro'}</option>
                    {if isset($tax_rules) && $tax_rules}
                        {foreach $tax_rules as $tax_rule}
                            <option
                                {if isset($tfPrimeMembershipPlan)}
                                    {if $tfPrimeMembershipPlan->id_tax_rules_group == $tax_rule.id_tax_rules_group}
                                        selected="selected"
                                    {/if}
                                {/if}
                                value="{$tax_rule.id_tax_rules_group|intval}">
                                {$tax_rule.name|escape:'html':'UTF-8'}
                            </option>
                        {/foreach}
                    {/if}
                </select>
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="col-lg-3 control-label required">
                <span
                    class="label-tooltip"
                    data-toggle="tooltip"
                    title="{l s='You can define all the features of the membership here, it will be shown to product with membership detail.' mod='tfprimemembershippro'}">
                    {l s='Membership Features' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-9">
                <div class="col-lg-8">
                    {foreach from=$languages item=language}
                        {assign var="presta_current_div" value="presta_current_div_`$language.id_lang`"}
                        {assign var="features" value="features_`$language.id_lang`"}
                        <div
                            class="presta_main_div {$presta_current_div|escape:'html':'UTF-8'}"
                            {if $current_lang.id != $language.id_lang}style="display:none;"{/if}>
                            <textarea
                                col="15"
                                rows="15"
                                name="{$features|escape:'html':'UTF-8'}"
                                data-lang-name="{$language.name|escape:'html':'UTF-8'}"
                                class="form-control">{if isset($smarty.post.{$features|escape:'html':'UTF-8'})}{$smarty.post.{$features|escape:'html':'UTF-8'} nofilter}{else if isset($tfPrimeMembershipPlan->features[$language.id_lang|escape:'html':'UTF-8']) && $tfPrimeMembershipPlan->features[$language.id_lang|escape:'html':'UTF-8']}{$tfPrimeMembershipPlan->features[$language.id_lang|escape:'html':'UTF-8'] nofilter}{/if}</textarea>
                        </div>
                    {/foreach}
                    <div class="help-block">
                        {l s='Use comma (,) to separate features. After each comma (,) Module will list feature in next line' mod='tfprimemembershippro'}
                    </div>
                </div>
                {if count($languages) > 1}
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-default dropdown-toggle presta_caret" data-toggle="dropdown">
                            {$current_lang.iso_code|escape:'html':'UTF-8'}
                            <span class="caret" style="margin-left:5px;"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=language}
                                <li>
                                    <a
                                        href="javascript:void(0)"
                                        onclick="showLangField('{$language.iso_code|escape:'html':'UTF-8'}', {$language.id_lang|escape:'html':'UTF-8'});">{$language.name|escape:'html':'UTF-8'}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>
        </div>
        <div class="clearfix form-group">
            <label for="file" class="control-label col-lg-3">
                <span
                    class="label-tooltip"
                    data-toggle="tooltip"
                    title="{l s='Upload membership image, else default image will be shown' mod='tfprimemembershippro'}">
                    {l s='Membership Image:' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-sm-9">
                <input type="file" name="tf_prime_img" id="tf_prime_img" />
                <div class="tf_img_preview" style="display:none; margin: 20px 0;">
                    <img src="#" alt="your image" width="250" height="250" />
                </div>
                {if isset($img)}
                    <br />
                    <div class="tf_prime_img_list clearfix">
                        <img
                            style="position:relative;"
                            width="250"
                            height="250"
                            class="img-thumbnail"
                            style="margin-bottom:5px;"
                            src="{$img|escape:'html':'UTF-8'}"/>
                        <div class="btn btn-primary" style="position:absolute; bottom:0; margin: 0 10px;">
                            <a href="{$deleteLink|escape:'html':'UTF-8'}" id="tf_delete_img">
                                <i class="icon-trash"></i>
                            </a>
                        </div>
                    </div>
                {/if}
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="control-label col-lg-3 required">
                <span
                    title=""
                    data-html="true"
                    data-toggle="tooltip"
                    class="label-tooltip"
                    data-original-title="{l s='If Enabled, Customer can extend this plan before it get expired' mod='tfprimemembershippro'}">
                    {l s='Allow Customer(s) To Extend Plan : ' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-9">
                <span class="switch prestashop-switch fixed-width-lg">
                    <input
                        type="radio"
                        name="allow_extend"
                        id="allow_extend_on"
                        value="1"
                        {if isset($smarty.post.allow_extend) && $smarty.post.allow_extend == 1}checked="checked"
                        {else if isset($tfPrimeMembershipPlan) && $tfPrimeMembershipPlan->allow_extend == 1}checked="checked"
                        {else if !isset($smarty.post.allow_extend)}checked="checked"{/if}>
                        <label for="allow_extend_on">{l s='Yes' mod='tfprimemembershippro'}</label>
                    <input
                        type="radio"
                        name="allow_extend"
                        id="allow_extend_off"
                        value="0"
                        {if isset($tfPrimeMembershipPlan) && $tfPrimeMembershipPlan->allow_extend == '0'}checked="checked"{else if isset($smarty.post.allow_extend) && $smarty.post.allow_extend == '0'}checked="checked"{/if}>
                    <label for="allow_extend_off">{l s='No' mod='tfprimemembershippro'}</label>
                    <a class="slide-button btn"></a>
                </span>
            </div>
        </div>
        <div class="clearfix form-group">
            <label class="control-label col-lg-3 required">
                <span
                    title=""
                    data-html="true"
                    data-toggle="tooltip"
                    class="label-tooltip"
                    data-original-title="{l s='If Enabled, Customer can renew this plan after it get expired' mod='tfprimemembershippro'}">
                    {l s='Allow Customer(s) To Renew Plan : ' mod='tfprimemembershippro'}
                </span>
            </label>
            <div class="col-lg-9">
                <span class="switch prestashop-switch fixed-width-lg">
                    <input
                        type="radio"
                        name="allow_renew"
                        id="allow_renew_on"
                        value="1"
                        {if isset($smarty.post.allow_renew) && $smarty.post.allow_renew == 1}checked="checked"
                        {else if isset($tfPrimeMembershipPlan) && $tfPrimeMembershipPlan->allow_renew == '1'}checked="checked"
                        {else if !isset($smarty.post.allow_renew)}checked="checked"{/if}>
                        <label for="allow_renew_on">{l s='Yes' mod='tfprimemembershippro'}</label>
                    <input
                        type="radio"
                        name="allow_renew"
                        id="allow_renew_off"
                        value="0"
                        {if isset($smarty.post.allow_renew) && $smarty.post.allow_renew == '0'}checked="checked"{else if isset($smarty.post.allow_renew) && $smarty.post.allow_renew == '0'}checked="checked"{/if}>
                    <label for="allow_renew_off">{l s='No' mod='tfprimemembershippro'}</label>
                    <a class="slide-button btn"></a>
                </span>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <a
            class="btn btn-default pull-left"
            href="{$link->getAdminLink('AdminPrimeMembershipPro')|escape:'html':'UTF-8'}">
            <i class="process-icon-cancel"></i>{l s='Cancel' mod='tfprimemembershippro'}
        </a>
        <button
            type="submit"
            name="submitAdd{$table|escape:'html':'UTF-8'}"
            class="btn btn-default pull-right">
            <i class="process-icon-save"></i>{l s='Save' mod='tfprimemembershippro'}
        </button>
    </div>
    </form>
</div>
