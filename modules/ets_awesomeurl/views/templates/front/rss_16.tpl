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

<div class="ets_awu_rss_feed">
    <h1 class="head-title">{l s='RSS' mod='ets_awesomeurl'}</h1>
    <div class="content">
        {if isset($ets_awu_rss_enable) && $ets_awu_rss_enable}
            {if count($featured_product_options)}
                <div class="rss-box">
                    <h2>{l s='Featured products list' mod='ets_awesomeurl'}</h2>
                    <ul class="rss-list">
                        {foreach $featured_product_options as $item}
                            <li>
                                <a href="{$item.link|escape:'html':'UTF-8'}.xml">
                                    {$item.name|escape:'html':'UTF-8'}
                                    <i class="ets_svg_icon">
                                        <svg class="w_14 h_14" width="14" height="14" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M576 1344q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm512 123q2 28-17 48-18 21-47 21h-135q-25 0-43-16.5t-20-41.5q-22-229-184.5-391.5t-391.5-184.5q-25-2-41.5-20t-16.5-43v-135q0-29 21-47 17-17 43-17h5q160 13 306 80.5t259 181.5q114 113 181.5 259t80.5 306zm512 2q2 27-18 47-18 20-46 20h-143q-26 0-44.5-17.5t-19.5-42.5q-12-215-101-408.5t-231.5-336-336-231.5-408.5-102q-25-1-42.5-19.5t-17.5-43.5v-143q0-28 20-46 18-18 44-18h3q262 13 501.5 120t425.5 294q187 186 294 425.5t120 501.5z"/></svg>
                                    </i>
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            {/if}
            {if !empty($ets_awu_categories)}
                <div class="rss-box">
                    <h2>{l s='Product categories' mod='ets_awesomeurl'}</h2>
                    <ul class="rss-list">
                        {foreach $ets_awu_categories as $category}
                            <li>
                                <a href="{$ets_awu_base_url|escape:'quotes':'UTF-8'}rss/category/{$category.id_category|escape:'html':'UTF-8'}.xml">
                                    {$category.name|escape:'html':'UTF-8'}
                                    <i class="ets_svg_icon">
                                        <svg class="w_14 h_14" width="14" height="14" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M576 1344q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm512 123q2 28-17 48-18 21-47 21h-135q-25 0-43-16.5t-20-41.5q-22-229-184.5-391.5t-391.5-184.5q-25-2-41.5-20t-16.5-43v-135q0-29 21-47 17-17 43-17h5q160 13 306 80.5t259 181.5q114 113 181.5 259t80.5 306zm512 2q2 27-18 47-18 20-46 20h-143q-26 0-44.5-17.5t-19.5-42.5q-12-215-101-408.5t-231.5-336-336-231.5-408.5-102q-25-1-42.5-19.5t-17.5-43.5v-143q0-28 20-46 18-18 44-18h3q262 13 501.5 120t425.5 294q187 186 294 425.5t120 501.5z"/></svg>
                                    </i>
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            {/if}
            {if !empty($ets_awu_cms)}
                <div class="rss-box">
                    <h2>{l s='Pages' mod='ets_awesomeurl'}</h2>
                    <ul class="rss-list">
                        {foreach $ets_awu_cms  as $cms}
                            <li>
                                <a href="{$ets_awu_base_url|escape:'quotes':'UTF-8'}rss/page/{$cms.id_cms|escape:'html':'UTF-8'}.xml">
                                    {$cms.meta_title|escape:'html':'UTF-8'}
                                    <i class="ets_svg_icon">
                                        <svg class="w_14 h_14" width="14" height="14" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M576 1344q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm512 123q2 28-17 48-18 21-47 21h-135q-25 0-43-16.5t-20-41.5q-22-229-184.5-391.5t-391.5-184.5q-25-2-41.5-20t-16.5-43v-135q0-29 21-47 17-17 43-17h5q160 13 306 80.5t259 181.5q114 113 181.5 259t80.5 306zm512 2q2 27-18 47-18 20-46 20h-143q-26 0-44.5-17.5t-19.5-42.5q-12-215-101-408.5t-231.5-336-336-231.5-408.5-102q-25-1-42.5-19.5t-17.5-43.5v-143q0-28 20-46 18-18 44-18h3q262 13 501.5 120t425.5 294q187 186 294 425.5t120 501.5z"/></svg>
                                    </i>
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            {/if}
            {if !empty($ets_awu_blog)}
                <div class="rss-box">
                    <h2>{l s='Blog' mod='ets_awesomeurl'}</h2>
                    <ul class="rss-list">
                        {foreach $ets_awu_blog  as $blog}
                            <li>
                                <a href="{$blog.link|escape:'html':'UTF-8'}">
                                    {l s='Blog' mod='ets_awesomeurl'}
                                    <i class="ets_svg_icon">
                                        <svg class="w_14 h_14" width="14" height="14" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M576 1344q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm512 123q2 28-17 48-18 21-47 21h-135q-25 0-43-16.5t-20-41.5q-22-229-184.5-391.5t-391.5-184.5q-25-2-41.5-20t-16.5-43v-135q0-29 21-47 17-17 43-17h5q160 13 306 80.5t259 181.5q114 113 181.5 259t80.5 306zm512 2q2 27-18 47-18 20-46 20h-143q-26 0-44.5-17.5t-19.5-42.5q-12-215-101-408.5t-231.5-336-336-231.5-408.5-102q-25-1-42.5-19.5t-17.5-43.5v-143q0-28 20-46 18-18 44-18h3q262 13 501.5 120t425.5 294q187 186 294 425.5t120 501.5z"/></svg>
                                    </i>
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            {/if}
        {else}
            {l s='Rss not available' mod='ets_awesomeurl'}
        {/if}
    
    </div>
</div>