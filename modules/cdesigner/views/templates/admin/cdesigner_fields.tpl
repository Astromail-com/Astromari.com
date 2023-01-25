{*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    Prestaeg <infos@presta.com>
* @copyright Prestaeg
* @version   1.0.0
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}
<style>
    {foreach from=$allfonts item=item}
        {if $item.woff != ''}
            @font-face {
                font-family: '{$item.title}';
                src: url('{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/upload/{$item.woff2}') format('woff2'),
                     url('{$urls_site|escape:'htmlall':'UTF-8'}modules/cdesigner/views/img/upload/{$item.woff}') format('woff');
                font-weight: normal;
                font-style: normal;
            }
        {else}
            @import url("{$item.url_font|escape:'htmlall':'UTF-8'}");
        {/if}
    {/foreach}
</style>
<div class="col-lg-12">
    <div class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="material-icons">{l s='close' mod='cdesigner'}</i></span>
        </button>
        <p>{l s='» You can get the documentation to configure ' mod='cdesigner'}<b>CUSTOM PRODUCT DESIGNER</b> {l s='module here :' mod='cdesigner'}<a href="https://customizer-17.foruntil.com/documentation/" target="_blank" class="external-link">{l s='English Version' mod='cdesigner'}</a> , <a href="https://customizer-17.foruntil.com/documentation/fr/" target="_blank" class="external-link">{l s='French Version' mod='cdesigner'}</a></p>
    </div>
</div>
<input type="hidden" name="submitted_tabs[]" value="Cdesigner" />
<h3>{l s='Enable customization' mod='cdesigner'}</h3>
<div class="separation"></div>
<fieldset style="border:none;"> 
    <div class="col-lg-12">
        <div style="margin-bottom:30px">
            <span class="switch prestashop-switch fixed-width-lg ps-switch ps-switch-sm">
                <input type="radio" class="radiobtn" value="0" id="active_item_off" {if !isset($extra_active) || $extra_active == 0} checked="checked" {/if} name="active_item">
                <label for="active_item_off" id="id-0" class="selector-in">{l s='No' mod='cdesigner'}</label>
                <input type="radio" class="radiobtn" {if isset($extra_active) && $extra_active == 1} checked="checked" {/if} value="1" id="active_item_on" name="active_item">
                <label for="active_item_on" id="id-1" class="selector-in">{l s='Yes' mod='cdesigner'}</label>
                <span class="slide-button"></span>
            </span>
        </div>
        <input type="hidden" id="extra_active" name="extra_active" value="{if isset($extra_active)}{$extra_active|escape:'htmlall':'UTF-8'}{/if}" />
        <input type="hidden" id="enabled_clicked" name="enabled_clicked" value="0" />
        <div id="show-block" {if !isset($extra_active) || $extra_active == 0} style="display:none" {elseif isset($extra_active) && $extra_active == 1} style="display:block" {/if}>
            <ul class="list-tab">
                <li>
                    <a href="#tab-1" class="toolbar_btn btn-tab active">
                        {l s='Settings' mod="cdesigner"}
                    </a>
                </li>
                <li>
                    <a href="#tab-2" class="toolbar_btn btn-tab">
                        {l s='Images Product' mod="cdesigner"}
                    </a>
                </li>
                <li>
                    <a href="#tab-3" class="toolbar_btn btn-tab">
                        {l s='Predefined Design' mod="cdesigner"}
                    </a>
                </li>
            </ul>
            <div id="tab-1" class="tabs-sm clear">
                <h2 class="section-head">{l s='Global Configuration' mod="cdesigner"}</h2>
                <div style="overflow:hidden;">
                    <h3 class="col-lg-12" style="position:relative; top:5px;"> {l s='Customization Allowed:' mod='cdesigner'} (<span class="txt-intro">
                    {l s='You can choose here wich features(Image Or Text) customization will be enable on this product' mod='cdesigner'}</span>)</h3>
                    <div class="col-lg-4 form-select">
                        <select name="type_perso" id="tperso" class="form-control custom-select">
                            <option value="0" {if $type_perso == 0 || $type_perso == ''}selected="true"{/if}>{l s='Allow Images & Text Customization' mod='cdesigner'} </option>
                            <option value="1" {if $type_perso == 1}selected="true"{/if}>{l s='Allow only Images Customization' mod='cdesigner'} </option>
                            <option value="2" {if $type_perso == 2}selected="true"{/if}>{l s='Allow only Text Customization' mod='cdesigner'} </option>
                        </select>
                    </div>
                </div>
                <div class="switchers">
                    <label for="switch2">
                        <input data-toggle="switch" class="switch-input" id="switch2" data-inverse="true" type="checkbox" name="allow_help[]" {if $allow_help == 1 || $allow_help == ''} checked="checked" {/if}> {l s='Show Demonstration Link to your customers ( Please add the ID Youtube demonstration video in the configuration page of the module )' mod='cdesigner'}
                    </label>
                </div>
                <div class="switchers">
                    <label for="switch3">
                        <input data-toggle="switch" class="switch-input" id="switch3" data-inverse="true" type="checkbox" name="required_field[]" {if $required_field == 1} checked="checked" {/if}> {l s='Make Customization fields mandatory before adding to cart' mod='cdesigner'}
                    </label>
                </div>
                <div class="switchers">
                    <label for="switch6">
                        <input data-toggle="switch" class="switch-input" id="switch6" data-inverse="true" type="checkbox" name="allow_comb[]" {if $allow_comb == 1} checked="checked" {/if}> {l s='Allow the customers to update a combinations in the customization page.' mod='cdesigner'}
                    </label>
                </div>
                <div style="clear:both;margin-bottom:30px;"></div>
                <h2 class="section-head">{l s='Images Configuration' mod="cdesigner"}</h2>
                <div style="overflow:hidden;" id="lay">
                    <h3 class="col-lg-12" style="position:relative; top:5px;"> {l s='Layouts :' mod='cdesigner'} (<span class="txt-intro">
                    {l s='You can choose here wich Layouts will be enable on this product' mod='cdesigner'}</span>)</h3>
                    <div class="col-lg-12">
                        <label style="display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                            <input type="checkbox" name="layouts[]" value="all" {if 'all'|in_array:$type_layout} checked="checked" {/if}><i class="md-checkbox-control"></i>  <span>{l s='All Layouts ' mod='cdesigner'}</span>
                        </label>
                        {foreach from=$alllayouts item=item}
                            {if $item|in_array:$type_layout}
                                {if $item == 'free'}
                                    <label style="display:block; margin-bottom: 5px;" class="font-wa  md-checkbox">
                                        <input type="checkbox" name="layouts[]" value="free" checked="checked"><i class="md-checkbox-control"></i> <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}../free.png">
                                    </label>
                                {else}
                                    <label style="display:block; margin-bottom: 5px;" class="font-wa  md-checkbox">
                                        <input type="checkbox" name="layouts[]" value="{$item}" checked="checked"><i class="md-checkbox-control"></i> <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}../config/layout/{$item|escape:'htmlall':'UTF-8'}/grid.png">
                                    </label>
                                {/if}
                            {else}
                                {if $item == 'free'}
                                        <label style="display:block; margin-bottom: 5px;" class="font-wa  md-checkbox">
                                            <input type="checkbox" name="layouts[]" value="free"><i class="md-checkbox-control"></i> <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}../free.png">
                                        </label>
                                {else}
                                        <label style="display:block; margin-bottom: 5px;" class="font-wa  md-checkbox">
                                            <input type="checkbox" name="layouts[]" value="{$item}"><i class="md-checkbox-control"></i> <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}../config/layout/{$item|escape:'htmlall':'UTF-8'}/grid.png">
                                        </label>
                                {/if}
                            {/if}
                            {assign var=val value=$val+1}
                        {/foreach}
                    </div>
                </div>
                <div style="clear:both;margin-bottom:30px;"></div>
                <div style="overflow:hidden;" id="timages">
                    <h3 class="col-lg-12" style="position:relative; top:5px;"> {l s='Images from gallery :' mod='cdesigner'} (<span class="txt-intro">
                    {l s='You can choose here wich images from the gallery you want to enable on this product.' mod='cdesigner'}</span>)</h3>
                    {l s='Filter By Category :' mod='cdesigner'}
                    {foreach from=$allTags item=item}
                        <a href="javascript:void(0)" class="categorizeme btn btn-outline-secondary" id="{$item[1]}">{$item[1]}</a>
                    {/foreach}
                    <br />
                    <br />
                    <div class="col-lg-12">
                        <label style="display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                            <input type="checkbox" name="images[]" value="all" {if 'all'|in_array:$type_image} checked="checked" {/if}><i class="md-checkbox-control"></i>  {l s='All Images ' mod='cdesigner'}
                        </label>
                        {foreach from=$allimages item=item}
                            {if $item.id_img|in_array:$type_image}
                                <label style="display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                                    <input type="checkbox" name="images[]" value="{$item.id_img}" checked="checked" class="check-thumbn"><i class="md-checkbox-control"></i> <span class="bg-thumbnail" style="background-image: url('{$image_folder_baseurl|escape:'htmlall':'UTF-8'}upload/{$item.image}')"></span>
                                </label>
                            {else}
                                <label style="display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                                    <input type="checkbox" name="images[]" value="{$item.id_img}" class="check-thumbn"><i class="md-checkbox-control"></i> <span class="bg-thumbnail" style="background-image: url('{$image_folder_baseurl|escape:'htmlall':'UTF-8'}upload/{$item.image}')"></span>
                                </label>
                            {/if}
                            {assign var=val value=$val+1}
                        {/foreach}
                    </div>
                </div>
                <div class="switchers">
                    <label for="switch1">
                        <input data-toggle="switch" class="switch-input" id="switch1" data-inverse="true" type="checkbox" name="allow_upload[]" {if $allow_upload == 1 || $allow_upload == ''} checked="checked" {/if}> {l s='Allow Customers to Upload their Own Photos' mod='cdesigner'}
                    </label>
                </div>
                <div style="clear:both;margin-bottom:30px;"></div>
                <h2 class="section-head">{l s='Text Configuration' mod="cdesigner"}</h2>
                <div style="overflow:hidden;">
                    <h3 class="col-lg-12" style="position:relative; top:5px;"> {l s='Fonts :' mod='cdesigner'} (<span class="txt-intro">
                    {l s='You can choose here wich typography you want to enable on this product.' mod='cdesigner'}</span>)</h3>
                    <div class="col-lg-12">
                        <label style="display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                            <input type="checkbox" name="fonts[]" value="all" {if 'all'|in_array:$fonts} checked="checked" {/if}><i class="md-checkbox-control"></i>  {l s='All Fonts' mod='cdesigner'}
                        </label>
                        {foreach from=$allfonts item=item}
                            {if $item.id_font|in_array:$fonts}
                            <label style="font-family:{$item.title|escape:'htmlall':'UTF-8'};display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                                <input type="checkbox" name="fonts[]" value="{$item.id_font}" checked="checked"><i class="md-checkbox-control"></i> {$item.title|escape:'htmlall':'UTF-8'}
                            </label>
                            {else}
                                <label style="font-family:{$item.title|escape:'htmlall':'UTF-8'};display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                                    <input type="checkbox" name="fonts[]" value="{$item.id_font}"><i class="md-checkbox-control"></i> {$item.title|escape:'htmlall':'UTF-8'}
                                </label>
                            {/if}
                            {assign var=val value=$val+1}
                        {/foreach}
                    </div>
                </div>
                <div style="clear:both;margin-bottom:30px;"></div>

                <div style="overflow:hidden;">
                    <h3 class="col-lg-12" style="position:relative; top:5px;"> {l s='Color Fonts :' mod='cdesigner'} (<span class="txt-intro">
                    {l s='You can choose here wich color typography you want to enable on this product.' mod='cdesigner'}</span>)</h3>
                    <div class="col-lg-12">
                        <label style="display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                            <input type="checkbox" name="colors_data[]" value="all" {if 'all'|in_array:$type_color} checked="checked" {/if}><i class="md-checkbox-control"></i>  {l s='All Colors' mod='cdesigner'}
                        </label>
                        {foreach from=$colors item=item}
                            {if $item.id_color|in_array:$type_color}
                                <label style="display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                                    <input type="checkbox" name="colors_data[]" value="{$item.id_color}" checked="checked" style="float:left;"><i class="md-checkbox-control"></i><span style="margin-left:5px; float:left; background: #{$item.color|escape:'htmlall':'UTF-8'}; border: 3px solid #464646;display:block; height:30px;width: 30px;border-radius:100%;margin-left:-5px"></span>
                                </label>
                            {else}
                                <label style="display:block; margin-bottom: 5px;" class="font-wa md-checkbox">
                                    <input type="checkbox" name="colors_data[]" value="{$item.id_color}" style="float:left;"><i class="md-checkbox-control"></i><span style="margin-left:5px; float:left; background: #{$item.color|escape:'htmlall':'UTF-8'}; border: 3px solid #464646;display:block; height:30px;width: 30px;border-radius:100%;margin-left:-5px"></span>
                                </label>
                            {/if}
                            {assign var=val value=$val+1}
                        {/foreach}
                    </div>
                </div>

                <div style="clear:both;margin-bottom:30px;"></div>
                <h2 class="section-head">{l s='Additional Price Configuration' mod="cdesigner"}</h2>
                <div class="form-group">
                    <div class="col-lg-7" style="margin-bottom: 20px;">
                        <label class="form-control-label">{l s='Additional Price Per Side (HT)' mod='cdesigner'}</label>
                        <div class="input-group money-type">
                            <span class="input-group-text input-group-addon">{$currency} +</span>
                            <input type="text" id="price_per_side" name="price_per_side" data-display-price-precision="6" class="form-control additional-price" value="{$price_per_side|escape:'htmlall':'UTF-8'}" />
                        </div>
                    </div>
                    <div class="col-lg-7" style="margin-bottom: 20px;">
                        <label class="form-control-label">{l s='Additional Price Per Image (HT)' mod='cdesigner'}</label>
                        <div class="input-group money-type">
                            <span class="input-group-text input-group-addon">{$currency} +</span>
                            <input type="text" id="price_per_image" name="price_per_image" data-display-price-precision="6" class="form-control additional-price" value="{$price_per_image|escape:'htmlall':'UTF-8'}" />
                        </div>
                    </div>
                    <div class="col-lg-7" style="margin-bottom: 20px;">
                        <label class="form-control-label">{l s='Additional Price Per Letter (HT)' mod='cdesigner'}</label>
                        <div class="input-group money-type">
                            <span class="input-group-text input-group-addon">{$currency} +</span>
                            <input type="text" id="price_per_text" name="price_per_text" data-display-price-precision="6" class="form-control additional-price" value="{$price_per_text|escape:'htmlall':'UTF-8'}" />
                        </div>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>

            <div id="tab-2"  class="tabs-sm clear" style="display: none;">
                <div>
                    <h4>{l s='Background Custom Image' mod='cdesigner'}</h4>
                    <input id="fileupload" type="file" name="files">
                    <div class="js-spinner spinner hide btn-primary-reverse onclick pull-left m-r-1" id="spin_1" style="display:none"></div>
                    <p id="upload_process"></p>
                    <div id="upload_image">
                        {if isset($extra_image) && $extra_image !=''}
                            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image|escape:'htmlall':'UTF-8'}" style="height:80px; margin-bottom:5px;border: 1px solid #bbcdd2;padding:5px;" />
                        {/if}
                    </div>
                    <input type="hidden" name="extra_image" id="upload_url" val="">
                </div>
                <p class="help-block subtitle" style="text-align:center">
                    <a href="{$image_folder_baseurl|escape:'htmlall':'UTF-8'}examples/bg_phone.png" target="blank">{l s='Download an example of background Image here' mod='cdesigner'}</a>
                </p>
  
                <div class="spacer">
                    <h4>{l s='Use Combination Background Instead of background Field' mod='cdesigner'}</h4>
                    <span class="switch prestashop-switch fixed-width-lg">
                        <input type="radio" class="radiobtn-30" {if isset($active_bg) && $active_bg == 1} checked="checked" {/if} value="1" id="active_bg_on" name="active_bg">
                        <label for="active_bg_on" id="des-31" class="selector-in-3">{l s='Yes' mod='cdesigner'}</label>
                        <input type="radio" class="radiobtn-30" value="0" id="active_bg_off" {if !isset($active_bg) || $active_bg == 0} checked="checked" {/if} name="active_bg">
                        <label for="active_bg_off" id="des-30" class="selector-in-3">{l s='No' mod='cdesigner'}</label>
                        <input type="hidden" name="active_bg" id="active_bg" value="{$active_bg}">
                    </span>
                    <p style="clear:both;"><sub>{l s='(Turn this field to "yes" only if you hope to use a combination images Instead of background field, useful if you hope choose background per color for example)' mod='cdesigner'}</sub></p>
                </div>

                <div class="separation" style="margin-bottom: 20px;"></div> 
                <div>
                    <h4>{l s='Mask Custom Image' mod='cdesigner'}(<sub>{l s='Required for the best rendering, the Mask must be PNG With Transparent Designed Zone, and with the same size like the background, If you dont want to use it, please insert a blank transparent image instead' mod='cdesigner'}</sub>)</h4>
                    <input id="fileupload_1" type="file" name="files">
                    <p id="upload_process_1"></p>
                    <div class="js-spinner spinner hide btn-primary-reverse onclick pull-left m-r-1" id="spin_2" style="display:none"></div>
                    <div id="upload_image_1">
                        {if isset($extra_mask) && $extra_mask !=''}
                        <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_mask|escape:'htmlall':'UTF-8'}" style="height:80px; margin-bottom:5px;border: 1px solid #bbcdd2;padding:5px;" />
                        {/if}
                    </div>
                    <input type="hidden" name="extra_mask" id="upload_url_1" val="">
                </div>
                <p class="help-block subtitle" style="text-align:center">
                    <a href="{$image_folder_baseurl|escape:'htmlall':'UTF-8'}examples/m_phone.png" target="blank">{l s='Download an example of mask here' mod='cdesigner'}</a>
                </p>

                <div class="clear">&nbsp;</div>
                <input type="hidden" value="" name="helper-id" id="helper-id" />
                <input type="hidden" value="{$top_1|escape:'htmlall':'UTF-8'};{$left_1|escape:'htmlall':'UTF-8'};{$right_1|escape:'htmlall':'UTF-8'};{$bottom_1|escape:'htmlall':'UTF-8'}" name="zone-1" id="zone-1" />
                <input type="hidden" value="{$top_2|escape:'htmlall':'UTF-8'};{$left_2|escape:'htmlall':'UTF-8'};{$right_2|escape:'htmlall':'UTF-8'};{$bottom_2|escape:'htmlall':'UTF-8'}" name="zone-2" id="zone-2" />

                <div id="zone-upload-1" style="{if isset($extra_mask) && $extra_mask !=''} display:block; {else} display:none;{/if}">
                    <p style="clear:both;font-size:11px;text-align:left">(*){l s='Select the design zone area for this side' mod='cdesigner'}</p>
                    <div class="form-group" style="float:left;max-width: 300px">
                        <div class="col-lg-12">
                            <label class="control-label col-lg-12">
                                <span class="label-tooltip">{l s='Top' mod='cdesigner'}</span>
                            </label>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-text input-group-addon">%</span>
                                    <input id="z_top_1" maxlength="27" type="text" value="{$top_1|escape:'htmlall':'UTF-8'}" class="zone-area-1 form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label class="control-label col-lg-12">
                                <span class="label-tooltip">{l s='Left' mod='cdesigner'}</span>
                            </label>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-text input-group-addon">%</span>
                                    <input id="z_left_1" maxlength="27" type="text" value="{$left_1|escape:'htmlall':'UTF-8'}" class="zone-area-1 form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label class="control-label col-lg-12">
                                <span class="label-tooltip">{l s='Width' mod='cdesigner'}</span>
                            </label>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-text input-group-addon">%</span>
                                    <input id="z_right_1" maxlength="27" type="text" value="{$right_1|escape:'htmlall':'UTF-8'}" class="zone-area-1 form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label class="control-label col-lg-12">
                                <span class="label-tooltip">{l s='Height' mod='cdesigner'}</span>
                            </label>
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-text input-group-addon">%</span>
                                    <input id="z_bottom_1" maxlength="27" type="text" value="{$bottom_1|escape:'htmlall':'UTF-8'}" class="zone-area-1 form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="preview-area" style="position:relative; max-width:500px; float:left;">
                        <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image|escape:'htmlall':'UTF-8'}" class="bg-preview-1" style="max-width:500px; height:auto; position: absolute;left: 0;top:0;z-index:0;" />
                        <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_mask|escape:'htmlall':'UTF-8'}" class="mas-over mask-preview-1" style="display:block; max-width:500px; height:auto; margin-bottom:5px;position:relative;z-index:1;" />
                        <div class="zone-select-1 case" id="preview-1" style="position:absolute;z-index:4;background:rgba(255,0,0,.4);left:{$left_1|escape:'htmlall':'UTF-8'}%;top:{$top_1|escape:'htmlall':'UTF-8'}%;height:{$bottom_1|escape:'htmlall':'UTF-8'}%;width:{$right_1|escape:'htmlall':'UTF-8'}%;"></div>
                    </div>
                </div>
                
                <!-- Enable Side 2 -->
                <div style="margin-bottom:30px; clear: both;">
                    <span>{l s='Enable Side 2' mod='cdesigner'}</span>
                    <span class="switch prestashop-switch fixed-width-lg">
                        <input type="radio" class="selector-in-1"  {if isset($extra_active_2) && $extra_active_2 == 1} checked="checked" {/if} value="1" id="active_item_on_1" name="active_item_1">
                        <label for="active_item_on_1" id="cd-1" class="selector-in-1">{l s='Yes' mod='cdesigner'}</label>
                        <input type="radio" class="selector-in-1" value="0" id="active_item_off_1" {if !isset($extra_active_2) || $extra_active_2 == 0} checked="checked" {/if} name="active_item_1">
                        <label for="active_item_off_1" id="cd-0" class="selector-in-1">{l s='No' mod='cdesigner'}</label>
                        <a class="slide-button btn"></a>
                    </span>
                </div>
                <input type="hidden" id="extra_active_2" name="extra_active_2" value="{if isset($extra_active_2)}{$extra_active_2|escape:'htmlall':'UTF-8'}{/if}" />
                <div id="show-block-2" {if !isset($extra_active_2) || $extra_active_2 == 0} style="display:none" {elseif isset($extra_active_2) && $extra_active_2 == 1} style="display:block" {/if}>
                    <div style="clear:both;margin-bottom:30px;"></div>
                    <div>
                        <h4>{l s='Background Custom Image Side 2' mod='cdesigner'}</h4>
                        <input id="fileupload_s2" type="file" name="files">
                        <div class="js-spinner spinner hide btn-primary-reverse onclick pull-left m-r-1" id="spin_1_s2" style="display:none"></div>
                        <p id="upload_process_s2"></p>
                        <div id="upload_image_s2">
                            {if isset($extra_image_2) && $extra_image_2 !=''}
                            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image_2|escape:'htmlall':'UTF-8'}" style="height:80px; margin-bottom:5px;border: 1px solid #bbcdd2;padding:5px;" />
                            {/if}
                        </div>
                        <input type="hidden" name="extra_image_2" id="upload_url_s2" val="">
                    </div>

                    <div class="separation" style="margin-bottom:30px"></div> 
                    <div>
                        <h4>{l s='Mask Custom Image Side 2' mod='cdesigner'}</h4>
                        <input id="fileupload_1_s2" type="file" name="files">
                        <p id="upload_process_1_s2"></p>
                        <div class="js-spinner spinner hide btn-primary-reverse onclick pull-left m-r-1" id="spin_2_s2" style="display:none"></div>
                        <div id="upload_image_1_s2">
                            {if isset($extra_mask_2) && $extra_mask_2 !=''}
                            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_mask_2|escape:'htmlall':'UTF-8'}" style="height:80px; margin-bottom:5px;border: 1px solid #bbcdd2;padding:5px;" />
                            {/if}
                        </div>
                        <input type="hidden" name="extra_mask_2" id="upload_url_1_s2" val="">
                    </div>

                    <div id="zone-upload-2" style="{if isset($extra_mask_2) && $extra_mask_2 !=''} display:block; {else} display:none;{/if}">
                        <div class="separation" style="margin-bottom:30px"></div> 
                        <p style="clear:both;font-size:11px;text-align:left">(*){l s='Select the design zone area for this side' mod='cdesigner'}</p>
                        <div class="form-group" style="float:left;max-width: 300px">
                            <div class="col-lg-12">
                                <label class="control-label col-lg-12">
                                    <span class="form-control-label">{l s='Top' mod='cdesigner'}</span>
                                </label>  
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-addon"">%</span>
                                        <input id="z_top_2" maxlength="27" type="text" value="{$top_2|escape:'htmlall':'UTF-8'}" class="zone-area-2 form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="control-label col-lg-12">
                                    <span class="form-control-label">{l s='Left' mod='cdesigner'}</span>
                                </label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-addon"">%</span>
                                        <input id="z_left_2" maxlength="27" type="text" value="{$left_2|escape:'htmlall':'UTF-8'}" class="zone-area-2 form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="control-label col-lg-6">
                                    <span class="form-control-label">{l s='Width' mod='cdesigner'}</span>
                                </label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-addon"">%</span>
                                        <input id="z_right_2" maxlength="27" type="text" value="{$right_2|escape:'htmlall':'UTF-8'}" class="zone-area-2 form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="control-label col-lg-6">
                                    <span class="form-control-label">{l s='Height' mod='cdesigner'}</span>
                                </label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-addon"">%</span>
                                        <input id="z_bottom_2" maxlength="27" type="text" value="{$bottom_2|escape:'htmlall':'UTF-8'}" class="zone-area-2 form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="preview-area" style="position:relative; max-width:500px; margin: 0 0 0 30px;float: left;">
                            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image_2|escape:'htmlall':'UTF-8'}" style="max-width:500px; height:auto; position: absolute;left: 0;top:0;z-index:0;" class="bg-preview-2"/>
                            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_mask_2|escape:'htmlall':'UTF-8'}" class="mas-over mask-preview-2" style="display:block; max-width:500px; height:auto; margin-bottom:5px;position:relative;z-index:1;" />
                            <div class="zone-select-2 case" id="preview-2" style="position:absolute;z-index:4;background:rgba(255,0,0,.4);left:{$left_2|escape:'htmlall':'UTF-8'}%;top:{$top_2|escape:'htmlall':'UTF-8'}%;height:{$bottom_2|escape:'htmlall':'UTF-8'}%;width:{$right_2|escape:'htmlall':'UTF-8'}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-3"  class="tabs-sm clear" style="display: none;">
                <div class="spacer">
                    <h4>{l s='Enable predefined design for this product' mod='cdesigner'}</h4>
                    <span class="switch prestashop-switch fixed-width-lg">
                        <input type="radio" class="radiobtn-1" {if isset($extra_design) && $extra_design == 1} checked="checked" {/if} value="1" id="active_design_on" name="active_design">
                        <label for="active_design_on" id="des-1" class="selector-in-3">{l s='Yes' mod='cdesigner'}</label>
                        <input type="radio" class="radiobtn-1" value="0" id="active_design_off" {if !isset($extra_design) || $extra_design == 0} checked="checked" {/if} name="active_design">
                        <label for="active_design_off" id="des-0" class="selector-in-3">{l s='No' mod='cdesigner'}</label>
                        <input type="hidden" name="extra_design" id="extra_design" value="{$extra_design}">
                    </span>
                </div>
                <p class="alert-text" data-title="Read more">
                    {l s='You can create a predefined design and authorize your customers to only modify the text/image.' mod='cdesigner'}
                </p>
                <input type="hidden" name="design_pre" id="design_pre" value="{$design_pre}">
                <input type="hidden" name="design_pre_2" id="design_pre_2" value="{$design_pre_2}"> 
                <div class="space-work" {if !isset($extra_design) || $extra_design == 0} style="display:none" {elseif isset($extra_design) && $extra_design == 1} style="display:block" {/if}>
                    <div class="mask-worker-1">
                        <div class="zone-mask-work">
                            <div class="switcher-mode" {if $extra_active_2 ==1 } style="display:block;" {else} style="display:none;" {/if}>
                                <a href="zone-mask-work-down" class="active">{l s='Side 1' mod='cdesigner'}</a>
                                <a href="zone-mask-work-down-2">{l s='Side 2' mod='cdesigner'}</a>
                            </div>
                            <div style="position:relative">
                                <div class="zone-mask-work-down">
                                    {if isset($extra_image) && $extra_image !=''}
                                        <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image|escape:'htmlall':'UTF-8'}" style="max-width:100%" class="img-over"/>
                                         {if isset($extra_mask) && $extra_mask !=''}
                                            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_mask|escape:'htmlall':'UTF-8'}" style="max-width:100%"  class="mask-over"/>
                                         {/if}
                                    {else}
                                        <h4 class="no-background">{l s='Please choose the background image on the Image Product tab' mod='cdesigner'}</h4>
                                    {/if}
                                </div>

                                <div class="zone-mask-work-down-2" style="visibility: hidden; z-index: -1;">
                                    {if isset($extra_image_2) && $extra_image_2 !=''}
                                        <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_image_2|escape:'htmlall':'UTF-8'}" style="max-width:100%" class="img-over-2"/>
                                         {if isset($extra_mask_2) && $extra_mask_2 !=''}
                                            <img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$extra_mask_2|escape:'htmlall':'UTF-8'}" style="max-width:100%"  class="mask-over-2"/>
                                         {/if}
                                    {else}
                                        <h4 class="no-background">{l s='Please choose the background image for side 2 on the Image Product tab' mod='cdesigner'}</h4>
                                    {/if}
                                </div>
                            </div>
                        </div>
                        <div class="zone-link-work">
                            <a href="javascript:void(0);" class="btn-tertiary-outline" id="new-photos">{l s='New Image Area' mod='cdesigner'}</a>
                            <a href="javascript:void(0);" class="btn-tertiary-outline" id="new-text">{l s='New Text Area' mod='cdesigner'}</a>
                            <a href="javascript:void(0);" class="btn-tertiary-outline" id="clear-design">{l s='Clear Design' mod='cdesigner'}</a>

                            <div class="panel-txt-img" style="padding-top:50px">
                                <div id="cp-tags">
                                    <label class="col-lg-12" style="position:relative;"> {l s='Associate Categories to this Zone Image :' mod='cdesigner'} </label>
                                    <div class="col-lg-8">
                                        <label style="display:block; margin-bottom: 5px; text-transform: capitalize; padding-left: 30px; cursor: pointer;" class="md-checkbox" data-tag="0">
                                            <input type="checkbox" name="tags_predefined" value="0"><i class="md-checkbox-control"></i> {l s='All Categories' mod='cdesigner'}
                                        </label>
                                        {foreach from=$allTags item=item}
                                            <label style="display:block; margin-bottom: 5px; text-transform: capitalize; padding-left: 30px; cursor: pointer;" class="md-checkbox" data-tag="{$item[0]|escape:'htmlall':'UTF-8'}">
                                                <input type="checkbox" name="tags_predefined" value="{$item[0]}"><i class="md-checkbox-control"></i> {$item[1]|escape:'htmlall':'UTF-8'}
                                            </label>
                                        {/foreach}
                                    </div>
                                </div>
                            </div>

                            <div class="panel-txt">
                                <div id="cp-textarea">
                                    <label class="col-lg-3" style="position:relative; top:5px;"> {l s='Fonts :' mod='cdesigner'} </label>
                                    <div class="col-lg-8">
                                        {foreach from=$allfonts item=item}
                                            <label style="font-family:{$item.title|escape:'htmlall':'UTF-8'};display:block; margin-bottom: 5px;">
                                                <input type="radio" name="fonts_predefined" value="{$item.id_font}"> {$item.title|escape:'htmlall':'UTF-8'}
                                            </label>
                                        {/foreach}
                                    </div>
                                </div>
                                <textarea class="cp-input-txt" placeholder="{l s='Your Text Here' mod='cdesigner'}" name="text_predefined"></textarea>
                                <div class="form-group">
                                    <div class="col-lg-7" style="margin-bottom: 20px;">
                                        <label class="form-control-label">{l s='Size Text : ' mod='cdesigner'}</label>
                                        <div class="input-group">
                                            <span class="input-group-text input-group-addon"">PX</span>
                                            <input type="text" name="size_predefined" class="form-control" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-7" style="margin-bottom: 20px;">
                                        <label class="form-control-label">{l s='Maximum number of letter : ' mod='cdesigner'}</label>
                                        <div class="input-group">
                                            <input type="text" name="letter_predefined" class="form-control" value="0" />
                                        </div>
                                        <p class="alert-text" style="clear: both">{l s='Number Limit Of letters, 0 for no limit' mod='cdesigner'}</p>
                                    </div>  
                                    <!--div class="col-lg-7" style="margin-bottom: 20px;">
                                        <label class="form-control-label">{l s='Line height (space between line) : ' mod='cdesigner'}</label>
                                        <div class="input-group money-type">
                                            <span class="input-group-text input-group-addon"">PX</span>
                                            <input type="text" name="lheight_predefined" class="form-control additional-price" value="" />
                                        </div>
                                    </div-->
                                    <div class="col-lg-7" style="margin-bottom: 20px;">
                                        <label class="form-control-label">{l s='Color Text :' mod='cdesigner'}</label>
                                        <div class="input-group">
                                            <input type="color"
                                                 data-hex="true"
                                                 class="color mColorPickerInput"
                                                 name="color_predefined"
                                                value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 align-link" style="margin-bottom: 20px;">
                                        <label class="col-lg-8" style="position:relative; top:5px;padding:0;text-align: left;"> {l s='Allow Customers to update color Text :' mod='cdesigner'} </label>
                                        <div class="col-lg-4">
                                            <label class="font-wa">
                                                <input type="radio" name="acolor_predefined" value="yes"> {l s='Yes' mod='cdesigner'}
                                            </label>
                                            <label class="font-wa">
                                                <input type="radio" name="acolor_predefined" value="no"> {l s='No' mod='cdesigner'}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 align-link" style="margin-bottom: 20px;">
                                        <label class="col-lg-8" style="position:relative; top:5px;padding:0;text-align: left;"> {l s='Allow Customers to update The font Family :' mod='cdesigner'} </label>
                                        <div class="col-lg-4">
                                            <label class="font-wa">
                                                <input type="radio" name="afont_predefined" value="yes"> {l s='Yes' mod='cdesigner'}
                                            </label>
                                            <label class="font-wa">
                                                <input type="radio" name="afont_predefined" value="no"> {l s='No' mod='cdesigner'}
                                            </label>
                                        </div>
                                        <p class="alert-text" style="clear: both">{l s='Please select wich font you want to enable to your customers on the settings tab' mod='cdesigner'}</p>
                                    </div>
                                    <div class="col-lg-12 align-link" style="margin-bottom: 20px;">
                                        <label class="col-lg-4" style="position:relative; top:5px;padding:0;text-align: left;"> {l s='Horizontal Align :' mod='cdesigner'} </label>
                                        <div class="col-lg-8">
                                            <label class="font-wa">
                                                <input type="radio" name="align_predefined" value="left"> {l s='Left' mod='cdesigner'}
                                            </label>
                                            <label class="font-wa">
                                                <input type="radio" name="align_predefined" value="center"> {l s='Center' mod='cdesigner'}
                                            </label>
                                            <label class="font-wa">
                                                <input type="radio" name="align_predefined" value="right"> {l s='Right' mod='cdesigner'}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 vlign-link" style="margin-bottom: 20px;">
                                        <label class="col-lg-4" style="position:relative; top:5px;padding:0;text-align: left;"> {l s='Vertical Align :' mod='cdesigner'} </label>
                                        <div class="col-lg-8">
                                            <label class="font-wa">
                                                <input type="radio" name="valign_predefined" value="top"> {l s='Top' mod='cdesigner'}
                                            </label>
                                            <label class="font-wa">
                                                <input type="radio" name="valign_predefined" value="center"> {l s='Center' mod='cdesigner'}
                                            </label>
                                            <label class="font-wa">
                                                <input type="radio" name="valign_predefined" value="bottom"> {l s='Bottom' mod='cdesigner'}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 align-link" style="margin-bottom: 20px;">
                                        <label class="col-lg-8" style="position:relative; top:5px;padding:0;text-align: left;"> {l s='Allow Word Break :' mod='cdesigner'} </label>
                                        <div class="col-lg-4">
                                            <label class="font-wa">
                                                <input type="radio" name="abreak_predefined" value="yes"> {l s='Yes' mod='cdesigner'}
                                            </label>
                                            <label class="font-wa">
                                                <input type="radio" name="abreak_predefined" value="no"> {l s='No' mod='cdesigner'}
                                            </label>
                                        </div>
                                        <p class="alert-text" style="clear: both">{l s='Automatic line break if the text exceeds the zone area' mod='cdesigner'}</p>
                                    </div>

                                    <div class="col-lg-12 align-link" style="margin-bottom: 20px;">
                                        <label class="col-lg-8" style="position:relative; top:5px;padding:0;text-align: left;"> {l s='Allow Customers to update the font size :' mod='cdesigner'} </label>
                                        <div class="col-lg-4">
                                            <label class="font-wa">
                                                <input type="radio" name="afontsize_predefined" value="yes"> {l s='Yes' mod='cdesigner'}
                                            </label>
                                            <label class="font-wa">
                                                <input type="radio" name="afontsize_predefined" value="no"> {l s='No' mod='cdesigner'}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 align-link" style="margin-bottom: 20px;">
                                        <label class="col-lg-8" style="position:relative; top:5px;padding:0;text-align: left;"> {l s='Allow Customers to update the font alignement :' mod='cdesigner'} </label>
                                        <div class="col-lg-4">
                                            <label class="font-wa">
                                                <input type="radio" name="afontalignement_predefined" value="yes"> {l s='Yes' mod='cdesigner'}
                                            </label>
                                            <label class="font-wa">
                                                <input type="radio" name="afontalignement_predefined" value="no"> {l s='No' mod='cdesigner'}
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="switchers auto-upload">
                        <label for="switch5">
                            <input data-toggle="switch" class="switch-input" id="switch5" data-inverse="true" type="checkbox" name="allow_zone[]" {if $allow_zone == 1} checked="checked" {/if}> {l s='Force Auto Placement Image to specific design Zone' mod='cdesigner'}
                        </label>   
                        <p class="alert-text" data-title="Read more">
                            {l s='By Enabling this feature, The upload images from the user will be disabled, and the auto placement mode will be enabled ( When you click on the image from the gallery, it will automatically placed into associeted zone ), this mode require that you associate only one category per zone area image' mod='cdesigner'}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!--div class="panel-footer" style="overflow:hidden">
            <button class="btn btn-default pull-right click-helper" name="submitAddproduct" type="submit" style="margin-left:5px"><i class="process-icon-save"></i> {l s='Save' mod='cdesigner'}</button>
            <button class="btn btn-default pull-right click-helper" name="submitAddproductAndStay" type="submit"><i class="process-icon-save"></i> {l s='Save and stay' mod='cdesigner'}</button>
        </div-->
    </div>
</fieldset>
<link rel="stylesheet" href="{$urls_site|escape:'htmlall':'UTF-8'}/modules/cdesigner/views/css/stylesheets/jquery-ui.css" type="text/css" media="all">
<link rel="stylesheet" href="{$urls_site|escape:'htmlall':'UTF-8'}/modules/cdesigner/views/css/stylesheets/bo-traitement.css" type="text/css" media="all">
<script type="text/javascript" src="{$urls_site|escape:'htmlall':'UTF-8'}/modules/cdesigner/views/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="{$urls_site|escape:'htmlall':'UTF-8'}/modules/cdesigner/views/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$urls_site|escape:'htmlall':'UTF-8'}/js/jquery/plugins/jquery.colorpicker.js"></script>
<script type="text/javascript" src="{$urls_site|escape:'htmlall':'UTF-8'}/modules/cdesigner/views/js/rotate.js"></script>
<script type="text/javascript">
    $.fn.mColorPicker.defaults.imageFolder = baseDir + 'img/admin/';
    var url = '{$urls_site|escape:'htmlall':'UTF-8'}/index.php?fc=module&module=cdesigner&controller=upload'; //url to upload image
    var img_txt = '{l s="Image Area" mod="cdesigner"}';
</script>
<script type="text/javascript" src="{$urls_site|escape:'htmlall':'UTF-8'}/modules/cdesigner/views/js/bo-traitement.js"></script>

<script type="text/javascript">
    $(document).on('click','.categorizeme', function(){
        $('.categorizeme').removeClass('active');
        var $txt = $.trim( $(this).attr('id') );
        $('#timages .font-wa').hide();
        $('#timages .font-wa').eq(0).show();
        $('#timages .font-wa').each(function(){

            if( $.trim( $(this).attr('data-cat') ).toLowerCase() == $.trim($txt).toLowerCase() ) {
                $(this).fadeIn('pretty');
            }
        });

        $(this).addClass('active');
    });
</script>

<style type="text/css">
    .ui-resizable-se:before{
      content: "";
      background: url({$image_folder_baseurl|escape:'htmlall':'UTF-8'}003-resize.png) no-repeat;
      left: 5px;
      opacity: 1;
      position: absolute;
      top: -1px;
      z-index: 2;
      background-color: #fff;
      background-position: center;
  }
  .ui-rotatable-handle:before{
      content: "";
      background: url({$image_folder_baseurl|escape:'htmlall':'UTF-8'}001-refresh.png) no-repeat;
      left:4px;
      position:absolute;
      top:0;
      background-color: #fff;
      background-position: center;
  }
  .btn-delete-zone:before{
      content: "";
      left:4px;
      position:absolute;
      top:1px;
      background: url({$image_folder_baseurl|escape:'htmlall':'UTF-8'}002-garbage.png) no-repeat;
      background-color: #fff;
      background-position: center;
  }
  .btn-dup-zone:before{
      content: "";
      left:4px;
      position:absolute;
      top:1px;
      background: url({$image_folder_baseurl|escape:'htmlall':'UTF-8'}duplicate.png) no-repeat;
      background-color: #fff;
      background-position: center;
  }
</style>