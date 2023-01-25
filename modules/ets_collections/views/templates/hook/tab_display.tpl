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
* needs please, contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2021 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
<div class="form-display-collections">
    <div class="block-left">
        <ul class="tab-display-pages">
            {foreach from= $collection_pages key='key' item='page'}
                <li class="tab-display{if $key=='home_page'} active{/if}" data-page="{$key|escape:'html':'UTF-8'}">
                    {$page.title|escape:'html':'UTF-8'} 
                    <span class="ets_col_switch_custom">
                        <input type="checkbox" name="hook_displays[{$key|escape:'html':'UTF-8'}]" value="1" {if ($page.displays && isset($page.displays.active) && $page.displays.active) || ($key=='collection_page' && !$id_collection)} checked="checked"{/if}/>
                        <span class="ets_col_switch">
                            <span class="ets_col_slider_label on">{l s='On' mod='ets_collections'}</span>
                            <span class="ets_col_slider_label off">{l s='Off' mod='ets_collections'}</span>
                        </span>
                    </span>
                </li>
            {/foreach}
        </ul>
    </div>
    <div class="block-right">
        <div class="form-display-pages">
            {foreach from= $collection_pages key='key' item='page'}
                <div class="form-display{if $key=='home_page'} active{/if}" data-page="{$key|escape:'html':'UTF-8'}">
                    <div class="panel-heading">{$page.title|escape:'html':'UTF-8'}</div>
                    <div class="row">
                        {if $key=='custom_hook'}
                            <div class="alert alert-warning">{l s='Put "{hook h=\'etsColCustomListProduct\'}" in the tpl file where you want to show the collection' mod='ets_collections'}</div>
                        {/if}
                        <div class="form-group display_list">
                            <label class="control-label col-lg-3"> {l s='Listing mode' mod='ets_collections'}</label>
                            <div class="col-lg-9">
                                <label class="display_list_type">
                                    <img src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`ets_collections/views/img/gird.jpg")|escape:'html':'UTF-8'}"/><br />
                                    <input id="list_layout_gird_{$key|escape:'html':'UTF-8'}" name="list_layouts[{$key|escape:'html':'UTF-8'}]" value="grid"{if (!isset($page.displays.list_layout) && $key!='right_column' && $key!='left_column') || (isset($page.displays.list_layout) && $page.displays.list_layout=='grid')} checked="checked"{/if} type="radio" />{l s='Grid' mod='ets_collections'}
                                </label>
                                <label class="display_list_type">
                                    <img src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`ets_collections/views/img/slide.jpg")|escape:'html':'UTF-8'}"/><br />
                                    <input id="list_layout_slide_{$key|escape:'html':'UTF-8'}" name="list_layouts[{$key|escape:'html':'UTF-8'}]" value="slide"{if (!isset($page.displays.list_layout) && ($key=='right_column' || $key=='left_column')) || (isset($page.displays.list_layout) && $page.displays.list_layout=='slide')} checked="checked"{/if} type="radio" />{l s='Carousel slide' mod='ets_collections'}
                                </label>
                            </div>
                        </div>
                        <div class="form-group display_list">
                            <label class="control-label col-lg-3"> {l s='Number of displayed products per row on desktop' mod='ets_collections'}</label>
                            <div class="col-lg-3">
                                <div class="range_custom">
                                    <input name="per_row_desktops[{$key|escape:'html':'UTF-8'}]" min="1" max="6" value="{if isset($page.displays.per_row_desktop) && $page.displays.per_row_desktop}{$page.displays.per_row_desktop|intval}{else}{if $key=='right_column' || $key=='left_column'}1{else}{if $key=='collection_page'}3{else}4{/if}{/if}{/if}"  forever="1" type="range" />
                                    <div class="range_new">
                                        <span class="range_new_bar"></span>
                                            <span class="range_new_run" style="">
                                            <span class="range_new_button"></span>
                                        </span>
                                    </div>
                                    <span class="input-group-unit">{if isset($page.displays.per_row_desktop) && $page.displays.per_row_desktop}{$page.displays.per_row_desktop|intval}{else}{if $key=='right_column' || $key=='left_column'}1{else}4{/if}{/if}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group display_list">
                            <label class="control-label col-lg-3"> {l s='Number of displayed products per row on tablet' mod='ets_collections'} </label>
                            <div class="col-lg-3">
                                <div class="range_custom">
                                    <input name="per_row_tablets[{$key|escape:'html':'UTF-8'}]" min="1" max="6" value="{if isset($page.displays.per_row_tablet) && $page.displays.per_row_tablet}{$page.displays.per_row_tablet|intval}{else}{if $key=='right_column' || $key=='left_column'}1{else}{if $key=='collection_page'}2{else}3{/if}{/if}{/if}"  forever="1" type="range" />
                                    <div class="range_new">
                                        <span class="range_new_bar"></span>
                                            <span class="range_new_run" style="">
                                            <span class="range_new_button"></span>
                                        </span>
                                    </div>
                                    <span class="input-group-unit">{if isset($page.displays.per_row_tablet) && $page.displays.per_row_tablet}{$page.displays.per_row_tablet|intval}{else}{if $key=='right_column' || $key=='left_column'}1{else}3{/if}{/if}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group display_list">
                            <label class="control-label col-lg-3">{l s='Number of displayed products per row on mobile' mod='ets_collections'} </label>
                            <div class="col-lg-3">
                                <div class="range_custom">
                                    <input name="per_row_mobiles[{$key|escape:'html':'UTF-8'}]" min="1" max="6" value="{if isset($page.displays.per_row_mobile) && $page.displays.per_row_mobile}{$page.displays.per_row_mobile|intval}{else}1{/if}"  forever="1" type="range" />
                                    <div class="range_new">
                                        <span class="range_new_bar"></span>
                                            <span class="range_new_run" style="">
                                            <span class="range_new_button"></span>
                                        </span>
                                    </div>
                                    <span class="input-group-unit">{if isset($page.displays.per_row_tablet) && $page.displays.per_row_tablet}{$page.displays.per_row_tablet|intval}{else}1{/if}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group display_list">
                            <label class="control-label col-lg-3">{l s='Order by' mod='ets_collections'} </label>
                            <div class="col-lg-6">
                                <div class="radio ">
                                    <label>
                                        <input value="default" name="sort_order[{$key|escape:'html':'UTF-8'}]" type="radio"{if !isset($page.displays.sort_order) || (isset($page.displays.sort_order) && $page.displays.sort_order=='default')} checked="checked"{/if} />
                                        {l s='Default' mod='ets_collections'}
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input value="random" name="sort_order[{$key|escape:'html':'UTF-8'}]" type="radio"{if isset($page.displays.sort_order) && $page.displays.sort_order=='random'} checked="checked"{/if} />
                                        {l s='Random' mod='ets_collections'}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>