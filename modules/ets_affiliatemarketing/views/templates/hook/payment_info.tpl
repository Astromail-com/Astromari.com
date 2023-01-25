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
<section>
    <p>
    	{if $show_point}                
    		{l s='You have' mod='ets_affiliatemarketing'} {$eam_reward_total_balance|escape:'html':'UTF-8'} ({$eam_reward_point|escape:'html':'UTF-8'}) {l s='in your reward balance that can be used to pay for this order.' mod='ets_affiliatemarketing'}
    	{else}
        	{l s='You have' mod='ets_affiliatemarketing'} {$eam_reward_total_balance|escape:'html':'UTF-8'} {l s='in your reward balance that can be used to pay for this order.' mod='ets_affiliatemarketing'}
        {/if}
    </p>
</section>