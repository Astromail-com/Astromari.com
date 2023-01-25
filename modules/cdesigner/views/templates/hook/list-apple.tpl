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
<div class="panel">
    <h3><i class="icon-list-alt"></i> {l s='Manage your device' mod='cdesigner'}</h3>
	<div class="col-md-4">
		<div class="panel">
		    <h3>{l s='apple' mod='cdesigner'}
			<span class="panel-heading-action">
				<a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=cdesigner&addItem=1&category={$category|escape:'htmlall':'UTF-8'}">
					<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new device" data-html="true">
						<i class="process-icon-new "></i>
					</span>
				</a>
			</span>
			</h3>
			<div id="itemsContent">
				<div id="items" class="cls-apple">
					{foreach from=$items item=item}
						<div id="items_{$item.id_cdesigner|escape:'htmlall':'UTF-8'}" class="panel">
							<div class="row">
								<div class="col-lg-1">
									<span><i class="icon-arrows "></i></span>
								</div>
								<div class="col-md-12">
									<h4 class="pull-left" style="margin-bottom:0px;">{$item.title|escape:'htmlall':'UTF-8'}</h4>
									<div class="btn-group-action pull-right">
										<span class="helper-me">{$item.status|escape:'htmlall':'UTF-8'}</span>
										<a class="btn btn-default" title="Edit"
											href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=cdesigner&id_cdesigner={$item.id_cdesigner|escape:'htmlall':'UTF-8'}&category={$item.category|escape:'htmlall':'UTF-8'}">
											<i class="icon-edit"></i>
										</a>
										<a class="btn btn-default" title="Delete"
											href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=cdesigner&delete_id_cdesigner={$item.id_cdesigner|escape:'htmlall':'UTF-8'}">
											<i class="icon-trash"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					{/foreach}
				</div>
			</div>
			<div class="panel-footer">
				<a class="btn btn-default pull-right" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=cdesigner&addItem=1&category={$category|escape:'htmlall':'UTF-8'}"><i class="process-icon-new"></i> New apple device</a>
			</div>
		</div>
	</div>
{literal}
<script language='javascript'>
	$('.cls-apple>div').each(function(index, el) {
		var chaine = $(this).find('.helper-me').text();
		$(this).find('.helper-me').html(chaine);
	});
</script>
{/literal}
	<div class="col-md-4">