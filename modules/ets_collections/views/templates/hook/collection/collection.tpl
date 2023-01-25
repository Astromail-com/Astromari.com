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
<section id="main" class="ets_col_collection_main_detail">
    <section class="wrapper">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="row">
                    {if $list_collections}
                        <div id="block-collections" class="col-xs-12 col-sm-3">
                            {if $collection->thumb}
                                <div class="card card-block block-collection-thumb">
                                    <div class="collection-thumb">
                                        <img src="{$link->getMediaLink("`$smarty.const.__PS_BASE_URI__`img/col_collection/`$collection->thumb|escape:'htmlall':'UTF-8'`")}" alt="{$collection->name|escape:'html':'UTF-8'}" />
                                    </div>
                                </div>
                            {/if}
                            <div class="block-collections_left">
                                <h4 class="title-block">{l s='Collections' mod='ets_collections'}</h4>
                                <ul class="collection-top-menu">
                                    {$list_collections nofilter}
                                </ul>
                            </div>
                        </div>
                    {/if}
                    <div id="ets_col_block-products" class="block-collection-banner{if $list_collections} col-xs-12 col-sm-9{else} col-xs-12 col-sm-8{/if} ets_col_list_blocks">
                        <h1 class="h1">{$collection->name|escape:'html':'UTF-8'} ({$collection->getTotalProduct()|intval})</h1>
                        {if $collection->description}
                            <div class="desc">
                                {$collection->description|nl2br nofilter}
                            </div>
                        {/if}
                        {if $collection->image}
                            <div class="card card-block block-collection-banner">
                                <div class="collection-image">
                                    <img src="{$link->getMediaLink("`$smarty.const.__PS_BASE_URI__`img/col_collection/`$collection->image|escape:'htmlall':'UTF-8'`")}" alt="{$collection->name|escape:'html':'UTF-8'}" />
                                </div>
                            </div>
                        {/if}
                        {$block_product_list nofilter}
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
