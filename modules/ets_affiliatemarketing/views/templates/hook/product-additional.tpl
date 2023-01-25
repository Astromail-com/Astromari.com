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
{if isset($eam_css_link)}
    <link rel="stylesheet" href="{$eam_css_link nofilter}" />
{/if}
{if isset($eam_display_aff_promo_code) && $eam_display_aff_promo_code}
    <div id="ets_affiliatemarketing_product_message">
        <div class="alert alert-info">
            {$eam_aff_promo_code_message nofilter}
        </div>
    </div>
    
{/if}
{if $eam_product_addition_aff_message != 'wating_confirm' && $eam_product_addition_aff_message != 'ban'}
    {if (isset($affiliate_suspended) && !$affiliate_suspended && isset($eam_product_addition_aff_message))  || (isset($link_share) && $link_share)}
    <div class="ets_affiliatemarketing_product_message s2">
        {if isset($affiliate_suspended) && !$affiliate_suspended}
            {if isset($eam_product_addition_aff_message)}
                <div class="alert alert-info">
                    {$eam_product_addition_aff_message nofilter}
                </div>
            {/if}
        {/if}
        {if isset($link_share) && $link_share}
            <div class="aff-product-share-list product-page" style="">
                <label>{l s='Share this product' mod='ets_affiliatemarketing'}&nbsp;</label>
                <a class="aff-product-share-fb" href="https://www.facebook.com/sharer/sharer.php?u={$link_share|urlencode nofilter}" target="_blank" title="{l s='Share on facebook' mod='ets_affiliatemarketing'}"><i class="fa fa-facebook-f"></i></a>
                <a class="aff-product-share-tw" href="https://twitter.com/intent/tweet?text={$product->name|urlencode nofilter}&url={$link_share|urlencode nofilter}" target="_blank" title="{l s='Share on twitter' mod='ets_affiliatemarketing'}"><i class="fa fa-twitter"></i></a>
                <a href="{$link_share|urlencode nofilter}" data-product-name="{$product->name|escape:'html':'UTF-8'}" title="{l s='Share via email' mod='ets_affiliatemarketing'}" class="aff-product-share-email"><i class="fa fa-envelope"></i></a>
            </div>
        {/if}
    </div>
    {/if}
{/if}
{if $eam_product_addition_loy_message != 'wating_confirm' && $eam_product_addition_loy_message != 'ban'}
    {if isset($loyalty_suspended) && !$loyalty_suspended}
        {if isset($eam_product_addition_loy_message)}
            <div id="ets_affiliatemarketing_product_message">
                <div class="alert alert-info">
                    {$eam_product_addition_loy_message nofilter}
                </div>
            </div>
        {/if}
    {/if}
{/if}
<div class="aff-product-popup-share-mail">
    <span class="aff-close">{l s='Close' mod='ets_affiliatemarketing'}</span>
    <div class="popup-content">
        <form action="" method="post">
            <div class="form-wrapper">
                <input name="aff-product-share-link" type="hidden" id="aff-product-share-link" value="" />
                <input name="aff-product-share-name" type="hidden" id="aff-product-share-name" value="" />
                <div class="form-group">
                    <label class="col-lg-2">{l s='Name' mod='ets_affiliatemarketing'}</label>
                    <div class="col-lg-9">
                        <input name="aff-name" id="aff-name" type="text" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 required">{l s='Email' mod='ets_affiliatemarketing'}</label>
                    <div class="col-lg-9">
                        <input type="text" name="aff-emails" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2">{l s='Message' mod='ets_affiliatemarketing'}</label>
                    <div class="col-lg-9">
                        <textarea name="aff-messages" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-footer">
                <button char="btn btn-default" name="affSubmitSharEmail" data-link="{$link->getModuleLink('ets_affiliatemarketing','aff_products') nofilter}">{l s='Send mail' mod='ets_affiliatemarketing'}</button>
            </div>
        </form>
    </div>
</div>
