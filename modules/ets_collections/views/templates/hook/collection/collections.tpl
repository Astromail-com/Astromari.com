{*
* 2007-2021 ETS-Soft
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
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2021 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
<div class="block-list-collecions">
    <div id="js-collections-list-top" class="row collection-selection">
        <div class="col-xs-12">
            <h4>{if $ETS_COL_PAGE_TITLE}{$ETS_COL_PAGE_TITLE|escape:'html':'UTF-8'}{else}{l s='Collections' mod='ets_collections'}{/if}</h4>
            {if $ETS_COL_PAGE_DESCRIPTION}
                <div class="desc">{$ETS_COL_PAGE_DESCRIPTION|nl2br nofilter}</div>        
            {/if}                
        </div>
    </div>
    <ul class="ets_col_list_collection">
        {$collection_list nofilter}
    </ul>
    <div class="paggination">
        {$paggination nofilter}
    </div>
</div>