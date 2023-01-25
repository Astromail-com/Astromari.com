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

{if !$is17}
    <li class=" eam-box-featured">
{/if}
	<a id="aem-affiliate-link" href="{$refUrl|escape:'html':'UTF-8'}" class="{if isset($is17) && $is17}col-lg-4 col-md-6 col-sm-6 col-xs-12 eam-box-featured{/if}">
	  <span class="link-item">
	    <i class="fa fa-trophy icon-trophy"></i>
	      {l s='My rewards' mod='ets_affiliatemarketing'}
        <p class="desc">{l s='Reward history' mod='ets_affiliatemarketing'}</p>
	  </span>
	</a>
{if !$is17}
    </li>
{/if}