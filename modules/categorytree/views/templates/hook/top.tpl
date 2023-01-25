{*
* 2007-2020 Weblir
*
*  @author    weblir <contact@weblir.com>
*  @copyright 2012-2020 weblir
*  @license   weblir.com
*  You are allowed to modify this copy for your own use only. You must not redistribute it. License
*  is permitted for one Prestashop instance only but you can install it on your test instances.
*}

<div class="alert alert-info">
	<p><i class="icon-star"></i> {l s='Do you need a skilled PrestaShop developer?' mod='categorytree'} {l s='Click' mod='categorytree'} <strong><a href="https://addons.prestashop.com/contact-form.php?id_product=24991" target="_blank">{l s='here' mod='categorytree'}</a></strong> {l s='and get the best one!' mod='categorytree'}</p>
</div>
<div class="panel" id="fieldset_0" style="text-align:center; background-color: #fff;">
	<div class="row">
		<div class="col-lg-12">
			<img src="{$path|escape:'htmlall':'UTF-8'}logo.png" style="max-width: 200px;padding: 0; margin: 10px 10px 0 10px;">
			<h1 style="color: #b2bb1c;margin: 0;font-size: 50px;">
				{l s='Product category parent assign,'  mod='categorytree'}<br>
				{l s='regenerate category tree'  mod='categorytree'}
			</h1>
			<h2 style="margin: 0;color: #60604b;">{l s='Add or remove products from default category parents, regenerate the category tree for products and categories'  mod='categorytree'}</h2>
		</div>
	</div>
</div>
<div class="alert alert-info version-status" style="display: none"></div>
<div class="alert alert-danger">
	<p><i class="icon-exclamation"></i><i class="icon-exclamation"></i><i class="icon-exclamation"></i> {l s='Before you proceed with the category regeneration we advise you to make a backup!' mod='categorytree'}</p>
</div>
<script>
setTimeout(
	function version_status()
	{
	  var api_check = "https://www.weblir.com/version/latest.php?shop={$shop|escape:'html':'UTF-8'}&ref={$ref|escape:'html':'UTF-8'}&module={$modulename|escape:'html':'UTF-8'}&version={$moduleversion|escape:'html':'UTF-8'}";
	  $.getJSON(api_check)
	    .done(function( data ) {
	    	if (typeof data.version_status === 'undefined') {
	    		/* do nothing */
	    	} else {
	    		$( ".version-status").html(data.version_status).show();
	    	}
	    	
	    }).error(function() {});
	},
1000);
</script>