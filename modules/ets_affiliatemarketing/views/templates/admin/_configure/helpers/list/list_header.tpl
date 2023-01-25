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
{extends file="helpers/list/list_header.tpl"}
{block name="preTable"}
    <script type="text/javascript">
    var aff_link_search_customer = '{$aff_link_search_customer nofilter}';
    </script>
    <div class="aff_popup_wapper aff_add_user">
		<div class="popup_table">
			<div class="popup_tablecell">
				<div class="aff_popup_content">
					<span class="aff_close_popup">{l s='Close' mod='ets_affiliatemarketing'}</span>
					<div class="form-group">
						<label class="control-label col-lg-3" for="aff_search_customer_user"> {l s='Search for customers' mod='ets_affiliatemarketing'} </label>
						<div class="col-lg-9">
							<div class="input-group ">
								<input type="hidden" id="aff_id_search_customer_user" value="" />
                                <input id="aff_search_customer_user" class="" name="aff_search_customer_user" value="" placeholder="{l s='Search for customer by ID, email or name' mod='ets_affiliatemarketing'}" type="text" />
								<span class="input-group-addon"> <i class="icon icon-search"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
					    <label class="control-label col-lg-3">{l s='Join program' mod='ets_affiliatemarketing'}</label>
                        <div class="col-lg-9">
                            <div class="checkbox_group">
                                <label for="aff_customer_loyalty"><input type="checkbox" id="aff_customer_loyalty" name="aff_customer_loyalty" /> {l s='Loyalty program' mod='ets_affiliatemarketing'}</label><br />
                                <label for="aff_customer_referral"><input type="checkbox" id="aff_customer_referral" name="aff_customer_referral" /> {l s='Referral / Sponsorship program' mod='ets_affiliatemarketing'}</label><br />
                                <label for="aff_customer_affiliate"><input type="checkbox" id="aff_customer_affiliate" name="aff_customer_affiliate" /> {l s='Affiliate program' mod='ets_affiliatemarketing'}</label><br />
                            </div>
                        </div>   
					</div>
					<div class="form-group">
						<div class="col-lg-3"></div>
						<div class="col-lg-9">
                   	  		<button class="btn btn-default full-right" name="submitAddUserReward"><i class="icon-plus-circle"></i> {l s='Add' mod='ets_affiliatemarketing'}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <button class="btn btn-default full-right" name="btnAddNewUserReward"><i class="icon-plus-circle"></i> {l s='Add user' mod='ets_affiliatemarketing'}</button>
{/block}