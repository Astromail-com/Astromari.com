{*
* 2007-2022 ETS-Soft
*
* NOTICE OF LICENSE
*
* This file is not open source! Each license that you purchased is only available for 1 wesite only.
* If you want to use this file on more websites (or projects), you need to purchase additional licenses.
* You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please, contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2022 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
<script type="text/javascript">
    {if isset($linkRewriteRules)}
    var ETS_AWU_LINK_REWRITE_RULES = {$linkRewriteRules|@json_encode nofilter};
    var ETS_AWU_IS_SF = {if $isSf}1{else}0{/if};
    {/if}
    var ETS_AWU_LANG_ID_ACTIVE = {$current_lang_selected|escape:'html':'UTF-8'};
    var ETS_AWU_IS_CMS_CATEGORY = "";
    var ETS_AWU_CONTROLLER = "{$controller|escape:'html':'UTF-8'}";
    var ETS_AWU_DEFINED = {$ets_awu_defined|@json_encode nofilter};
    var ETS_AWU_LANGUAGES = {$ets_languages|@json_encode nofilter};
    var IS16 = {if $is16}1{else}0{/if};
</script>
<script src="{$linkAdminJs|escape:'quotes':'UTF-8'}" defer="defer"></script>
<script src="{$link_analysis_js|escape:'quotes':'UTF-8'}" defer="defer"></script>
<script src="{$link_select2_js|escape:'quotes':'UTF-8'}" defer="defer"></script>