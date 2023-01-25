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
<div class="import-export-form">
	<form action="" method="POST" accept-charset="utf-8" enctype="multipart/form-data" id="eamFormImportExport">
		<div class="box-import-export clearfix">
			<div class="box-item">
				<div class="eam-panel">
					<div class="eam-panel-heading">
						<h3 class="eam-panel-title">{l s='Create backup' mod='ets_affiliatemarketing'}</h3>
					</div>
					<div class="eam-panel-body">
						<p class="text-gray">{l s='Export all reward data and module\'s configurations for backup purpose. If your website is multishop, It will export data from all shops.' mod='ets_affiliatemarketing'}</p>
						<button type="submit" name="exportAllData" value="1" class="eam-btn-flat mt-15"><i class="fa fa-download"></i> {l s='Create backup' mod='ets_affiliatemarketing'}</button>
					</div>
				</div>
			</div>
			<div class="box-divider"></div>
			<div class="box-item">
				<div class="eam-panel">
					<div class="eam-panel-heading">
						<h3 class="eam-panel-title">{l s='Restore backup' mod='ets_affiliatemarketing'}</h3>
					</div>
					<div class="eam-panel-body">
						<p class="text-gray">{l s='Import reward data and module\'s configurations for restoration. If your website is multishop, It will restore data of all shops.' mod='ets_affiliatemarketing'}</p>
						<div class="form-group mt-15">
							<label for="import_source">{l s='Backup file:' mod='ets_affiliatemarketing'}</label>
							<input type="file" id="import_source" name="import_source" value="" class="eam-input-inline">
						</div>
						<p><strong>{l s='Restoring options:' mod='ets_affiliatemarketing'}</strong></p>
						
						<div class="form-group form-group-thin">
							<div class="checkbox">
								<label for="restore_config" class="eam-label-thin">
									<input type="checkbox" id="restore_config" name="restore_config" value="1" checked="checked" />{l s='Restore configuration' mod='ets_affiliatemarketing'}
								</label>
							</div>
						</div>
						<div class="form-group form-group-thin">
							<div class="checkbox">
								<label for="restore_reward" class="eam-label-thin">
									<input type="checkbox" id="restore_reward" name="restore_reward" value="1" {if isset($restore_reward)}{if $restore_reward}checked="checked"{/if}{else}checked="checked"{/if} />{l s='Restore reward data' mod='ets_affiliatemarketing'}
								</label>
							</div>
						</div>
						<div class="form-group form-group-thin">
							<div class="checkbox">
								<label for="delete_reward" class="eam-label-thin">
									<input type="checkbox" id="delete_reward" name="delete_reward" value="1" {if isset($delete_reward)}{if $delete_reward}checked="checked"{/if}{else}checked="checked"{/if} />{l s='Delete reward before restoring' mod='ets_affiliatemarketing'}
								</label>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" name="importAllData" value="1" class="eam-btn-flat mt-15"><i class="fa fa-compress"></i> {l s='Restore' mod='ets_affiliatemarketing'}</button>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</form>
</div>