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

<div class="form-group row">
    <label class="form-control-label">
        {l s='Remove ID in URL' mod='ets_awesomeurl'}
    </label>
    <div class="col-sm">
        <div class="input-group">
            <span class="ps-switch">
                <input id="ETS_AWU_ENABLE_REMOVE_ID_IN_URL_0" class="ps-switch"
                       name="ETS_AWU_ENABLE_REMOVE_ID_IN_URL" value="0" type="radio"
                       {if isset($ETS_AWU_ENABLE_REMOVE_ID_IN_URL) && $ETS_AWU_ENABLE_REMOVE_ID_IN_URL == 0}checked="checked"{/if}>
                <label for="ETS_AWU_ENABLE_REMOVE_ID_IN_URL_0">{l s= 'No' mod='ets_awesomeurl'}</label>
                <input id="ETS_AWU_ENABLE_REMOVE_ID_IN_URL_1" class="ps-switch"
                       name="ETS_AWU_ENABLE_REMOVE_ID_IN_URL" value="1" type="radio"
                       {if isset($ETS_AWU_ENABLE_REMOVE_ID_IN_URL) && $ETS_AWU_ENABLE_REMOVE_ID_IN_URL == 1}checked="checked"{/if}>
                <label for="ETS_AWU_ENABLE_REMOVE_ID_IN_URL_1">{l s= 'Yes' mod='ets_awesomeurl'}</label>
                <span class="slide-button"></span>
            </span>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="form-control-label">
        {l s='Remove ISO code in URL for default language' mod='ets_awesomeurl'}
    </label>
    <div class="col-sm">
        <div class="input-group">
            <span class="ps-switch">
                <input id="ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL_0" class="ps-switch"
                       name="ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL" value="0" type="radio"
                       {if isset($ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL) && $ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL == 0}checked="checked"{/if}>
                <label for="ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL_0">{l s= 'No' mod='ets_awesomeurl'}</label>
                <input id="ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL_1" class="ps-switch"
                       name="ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL" value="1" type="radio"
                       {if isset($ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL) && $ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL == 1}checked="checked"{/if}>
                <label for="ETS_AWU_ENABLE_REMOVE_LANG_CODE_IN_URL_1">{l s= 'Yes' mod='ets_awesomeurl'}</label>
                <span class="slide-button"></span>
            </span>
        </div>
    </div>
</div>
<div class="form-group row">
    <label class="form-control-label">
        {l s='Remove attribute alias in URL' mod='ets_awesomeurl'}
    </label>
    <div class="col-sm">
        <div class="input-group">
            <span class="ps-switch">
                <input id="ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS_0" class="ps-switch"
                       name="ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS" value="0" type="radio"
                       {if isset($ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS) && $ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS == 0}checked="checked"{/if}>
                <label for="ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS_0">{l s= 'No' mod='ets_awesomeurl'}</label>
                <input id="ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS_1" class="ps-switch"
                       name="ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS" value="1" type="radio"
                       {if isset($ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS) && $ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS == 1}checked="checked"{/if}>
                <label for="ETS_AWU_ENABLE_REMOVE_ATTR_ALIAS_1">{l s= 'Yes' mod='ets_awesomeurl'}</label>
                <span class="slide-button"></span>
            </span>
        </div>
    </div>
</div>