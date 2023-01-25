{*
* 2007-2020 Weblir
*
*  @author    weblir <contact@weblir.com>
*  @copyright 2012-2020 weblir
*  @license   weblir.com
*  You are allowed to modify this copy for your own use only. You must not redistribute it. License
*  is permitted for one Prestashop instance only but you can install it on your test instances.
*}

{literal}
<script type="text/javascript">

	$(document).ready( function() {

		$('#CATEGORYTREE_PRODUCT_on').parent().parent().parent().parent().append("<div class='the-overlay'><p>{/literal}{l s='Regenerating...'  mod='categorytree'}{literal}</p><div>");
        $('#CATEGORYTREE_PRODUCT_REVERT_on').parent().parent().parent().parent().append("<div class='the-overlay-second'><p>{/literal}{l s='Loading...'  mod='categorytree'}{literal}</p><div>");

		$( "#configuration_form_submit_btn" ).click(function( event ) {
          $('.the-overlay').show();
          //event.preventDefault();
        });

        $( "#configuration_form_submit_btn_1" ).click(function( event ) {
		  $('.the-overlay-second').show();
		  //event.preventDefault();
		});

	});

</script>
{/literal}

<style type="text/css">

.the-overlay,
.the-overlay-second {
	display: none;
	background-image: url('{$path|escape:'htmlall':'UTF-8'}views/img/loader.gif');
	background-size: 100px 100px;
    background-position: center center;
    position: absolute;
    width: 100%;
    background-color: rgba(0,0,0,0.3);
    height: 100%;
    background-repeat: no-repeat;
    top: 0;
    left: 0;
    text-align: center;
    font-size: 17px;
    padding: 15px;
    font-weight: bold;
    color: #fff;
}


</style>