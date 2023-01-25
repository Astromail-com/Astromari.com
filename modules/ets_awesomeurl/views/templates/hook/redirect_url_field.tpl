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
        {l s='Redirect all old URLs to new URLs (keep your page rankings and backlinks)' mod='ets_awesomeurl'}
    </label>
    <div class="col-sm">
        <div class="input-group">
              <span class="ps-switch">
                  <input id="ETS_AWU_ENABLE_REDIRECT_NOTFOUND_0" class="ps-switch"
                         name="ETS_AWU_ENABLE_REDIRECT_NOTFOUND" value="0" type="radio"
                         {if isset($ETS_AWU_ENABLE_REDIRECT_NOTFOUND) && $ETS_AWU_ENABLE_REDIRECT_NOTFOUND == 0}checked="checked"{/if}>
                  <label for="ETS_AWU_ENABLE_REDIRECT_NOTFOUND_0">{l s='No' mod='ets_awesomeurl'}</label>
                  <input id="ETS_AWU_ENABLE_REDIRECT_NOTFOUND_1" class="ps-switch"
                         name="ETS_AWU_ENABLE_REDIRECT_NOTFOUND" value="1" type="radio"
                         {if isset($ETS_AWU_ENABLE_REDIRECT_NOTFOUND) && $ETS_AWU_ENABLE_REDIRECT_NOTFOUND == 1}checked="checked"{/if}>
                  <label for="ETS_AWU_ENABLE_REDIRECT_NOTFOUND_1">{l s='Yes' mod='ets_awesomeurl'}</label>
                  <span class="slide-button"></span>
              </span>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="form-control-label">
        {l s='Redirect type' mod='ets_awesomeurl'}
    </label>
    <div class="col-sm">
        <select class="form-control" name="ETS_AWU_REDIRECT_STATUS_CODE">
            <option value="302"
                    {if isset($ETS_AWU_REDIRECT_STATUS_CODE) && $ETS_AWU_REDIRECT_STATUS_CODE == 302}selected="selected"{/if}>{l s='302 Moved Temporarily (recommended while setting up your store)' mod='ets_awesomeurl'}</option>
            <option value="301"
                    {if isset($ETS_AWU_REDIRECT_STATUS_CODE) && $ETS_AWU_REDIRECT_STATUS_CODE == 301}selected="selected"{/if}>{l s='301 Moved Permanently (recommended once you have gone live)' mod='ets_awesomeurl'}</option>
        </select>
        <small class="form-text">

        </small>
    </div>
</div>