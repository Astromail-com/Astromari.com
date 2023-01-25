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
<div class="col-md-3">
	<div class="panel">
		<h3></i> {l s='Default Images' mod='cdesigner'}
			<span class="panel-heading-action">
				<a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=cdesigner&addImage=1">
					<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new image" data-html="true">
						<i class="process-icon-new "></i>
					</span>
				</a>
			</span>
		</h3>
		<div class="table-responsive clearfix">
			<table class="table cdesigner_fonts list-ct">
				<thead>
					<tr class="nodrag nodrop">
						<th>
							Image
						</th>
						<th>Category</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$items item=item}
						<tr id="items_{$item.id_img|escape:'htmlall':'UTF-8'}" class="{$item.tags}">
							<td>
								<img src="{$image_baseurl|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}" class="img-thumbnail" style="height:70px" />
							</td>
							<td>{$item.tags}</td>
							<td class="text-right">
								<a class="btn btn-default" title="Edit"
									href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=cdesigner&id_img={$item.id_img|escape:'htmlall':'UTF-8'}">
									<i class="icon-edit"></i>
								</a>
								<a class="btn btn-default" title="Delete"
									href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=cdesigner&delete_id_image={$item.id_img|escape:'htmlall':'UTF-8'}">
									<i class="icon-trash"></i>
								</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
		<div class="panel-footer">
			<a class="btn btn-default pull-right" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=cdesigner&addImage=1"><i class="process-icon-new"></i> New Image</a>
		</div>
	</div>
</div>
<div style="clear:both;"></div>
</div>