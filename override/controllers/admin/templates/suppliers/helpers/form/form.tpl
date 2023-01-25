{**
 * overried_by_hinh_ets
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

{extends file="helpers/form/form.tpl"}
{block name="fieldset"}
	<div class="tab-content ets_seo_categories">
		<ul class="nav nav-tabs ets_seo_extra_tabs" role="tablist">
			<li role="presentation" class="active">
				<a href="#ets_seo_content_tabs" class="js-ets-seo-tab-customize" data-tab="js-ets-seo-tab-content"  role="tab" data-toggle="tab">{l s='Content' mod='ets_awesomeurl'}</a>
			</li>
			<li role="presentation">
				<a href="#ets_seo_setting_tabs" class="js-ets-seo-tab-customize" data-tab="js-ets-seo-tab-setting" role="tab" data-toggle="tab">{l s='Seo settings' mod='ets_awesomeurl'}</a>
			</li>
			{*<li role="presentation">
				<a href="#ets_seo_analysis_tabs" class="js-ets-seo-tab-customize" data-tab="js-ets-seo-tab-analysis" role="tab" data-toggle="tab">{l s='Seo analysis' mod='ets_awesomeurl'}</a>
			</li>*}
		</ul>
		{$smarty.block.parent}
		<div class="ets-seo-right-column col-lg-3">
			{if isset($ets_seo_preview_analysis)}
				{$ets_seo_preview_analysis nofilter}
			{/if}
		</div>
	</div>
{/block}
{block name="legend"}
	<div class="panel-heading">&nbsp;</div>
{/block}
{block name="input_row"}
	<div class="row">
		<div class="col-lg-9">
			{if $input.name == 'meta_title'}
				<div class="ets-seo-meta-data ets-seo-customize-item js-ets-seo-customize-item js-ets-seo-tab-setting">
					<h3>{l s='Search Engine Optimization' mod='ets_awesomeurl'}</h3>
					<p class="meta-data-desc">{l s='Improve your ranking and how your product page will appear in search engines results.' mod='ets_awesomeurl' }</p>
				</div>
			{/if}
			<div class="ets-seo-customize-item js-ets-seo-customize-item js-ets-seo-tab-{if $input.name == 'meta_title' || $input.name == 'meta_description' || $input.name == 'meta_keywords'}setting{else}content active{/if}">
				{$smarty.block.parent}
			</div>
		</div>
	</div>
{/block}
{* =========== ETS SEO =========*}
{block name='footer'}
	<div class="ets-seo-customize-item js-ets-seo-customize-item js-ets-seo-tab-setting">
		<div class="row">
			<div class="col-lg-9">
				{$ets_supplier_seo_setting_html nofilter}
			</div>
		</div>
	</div>
	{$smarty.block.parent}
{/block}

