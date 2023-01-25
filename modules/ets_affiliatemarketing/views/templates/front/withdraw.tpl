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

{extends file='page.tpl'}
{block name="page_content"}
    <h1 id="ets-am-customer-reward-heading">
        {l s='My rewards' mod='ets_affiliatemarketing'}
    </h1>
    <div class="ets-am-content">
        <ul class="ets-am-content-links">
            <li><a href="">{l s='Dashboard' mod='ets_affiliatemarketing'}</a></li>
            <li><a href="">{l s='Reward History' mod='ets_affiliatemarketing'}</a></li>
            <li><a href="" class="active">{l s='Withdrawals' mod='ets_affiliatemarketing'}</a></li>
            <li><a href="">{l s='Convert to vouchers' mod='ets_affiliatemarketing'}</a></li>
        </ul>
        <div class="content">

        </div>
    </div>
{/block}
{block name='page_footer'}
<div class="eam-back-section">
    <a href="{if isset($my_account_link)}{$my_account_link|escape:'html':'UTF-8'}{/if}" title="{l s='Back to your account' mod='ets_affiliatemarketing'}" class="eam-back-link eam-link-go-myaccount">{l s='Back to your account' mod='ets_affiliatemarketing'}</a>
    <a href="{if isset($home_link)}{$home_link|escape:'html':'UTF-8'}{/if}" title="{l s='Home' mod='ets_affiliatemarketing'}" class="eam-back-link eam-link-go-home">{l s='Home' mod='ets_affiliatemarketing'}</a>
</div>
{/block}
