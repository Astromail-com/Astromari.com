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
<tr>
    <td class=" id center"> {$id_customer|intval} </td>
    <td class=" left">
        <a href="{$link->getAdminLink('AdminModules')|escape:'html':'UTF-8'}&configure=ets_affiliatemarketing&tabActive=reward_users&id_customer={$id_customer|intval}&viewreward_users"> {$aff_customer->firstname|escape:'html':'UTF-8'}&nbsp;{$aff_customer->lastname|escape:'html':'UTF-8'} </a>
    </td>
    <td class="center">{$price_program|escape:'html':'UTF-8'}</td>
    <td class="center">{$price_program|escape:'html':'UTF-8'}</td>
    <td class="fixed-width-xs center">{$price_program|escape:'html':'UTF-8'}</td>
    <td class="center">{$price_program|escape:'html':'UTF-8'}</td>
    <td class="center">{$price_widthraw|escape:'html':'UTF-8'}</td>
    <td class=" left"> -- </td>
    <td class=" center">
        <span class="label label-success">{l s='Active' mod='ets_affiliatemarketing'}</span>
    </td>
    <td class=" center"> {l s='No' mod='ets_affiliatemarketing'} </td>
    <td class="text-right">																																																																							
        <div class="btn-group-action">				
            <div class="btn-group pull-right">
                <a href="{$link->getAdminLink('AdminModules')|escape:'html':'UTF-8'}configure=ets_affiliatemarketing&tabActive=reward_users&id_customer={$id_customer|intval}&viewreward_users" class="btn btn-default" title="{l s='View' mod='ets_affiliatemarketing'}">
        	       <i class="icon-search-plus"></i> {l s='View' mod='ets_affiliatemarketing'}
                </a>
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-caret-down"></i>&nbsp;
                </button>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)" data-id="{$id_customer|intval}" class="js-action-user-reward" data-action="decline"><i class="fa fa-close"></i> {l s='Suspend' mod='ets_affiliatemarketing'}</a></li>
                </ul>
            </div>
        </div>
    </td>
</tr>