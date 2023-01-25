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
{if isset($og_url)}
	<meta property="og:url"                content="{$og_url|escape:'html':'UTF-8'}" />
{/if}
{if isset($og_type)}
	<meta property="og:type"               content="{$og_type|escape:'html':'UTF-8'}" />
{/if}
{if isset($og_title)}
	<meta property="og:title"              content="{$og_title|escape:'html':'UTF-8'}" />
{/if}
{if isset($og_description)}
	<meta property="og:description"        content="{$og_description|escape:'html':'UTF-8'}" />
{/if}
{if isset($og_image)}
	<meta property="og:image"              content="{$og_image|escape:'html':'UTF-8'}" />
{/if}

<script type="text/javascript">
    {if isset($link_cart)}
    var link_cart = "{$link_cart nofilter}";
    {/if}
    {if isset($link_reward)}
    var link_reward = "{$link_reward nofilter}";
    {/if}
    {if isset($link_shopping_cart)}
    var link_shopping_cart = "{$link_shopping_cart nofilter}";
    {/if}
    {if isset($ets_am_product_view_link)}
        var ets_am_product_view_link = '{$ets_am_product_view_link nofilter}';
        var eam_id_seller = '{$eam_id_seller nofilter}';
    {/if}
    var eam_sending_email = "{l s='Sending...' mod='ets_affiliatemarketing'}";
    var eam_email_invalid = "{l s='Email is invalid' mod='ets_affiliatemarketing'}";
    var eam_email_sent_limited = "{l s='You have reached the maximum number of invitation' mod='ets_affiliatemarketing'}";
    var eam_token = "{$_token|escape:'html':'UTF-8'}";
    var name_is_blank = '{l s='Name is required' mod='ets_affiliatemarketing' js='1'}';
    var email_is_blank = '{l s='Email is required' mod='ets_affiliatemarketing' js='1'}';
    var email_is_invalid = '{l s='Email is invalid' mod='ets_affiliatemarketing' js='1'}';
</script>
