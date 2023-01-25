{*
* 2016 Leone MusicReader B.V.
*
* NOTICE OF LICENSE
*
* Source file is copyrighted by Leone MusicReader B.V.
* Only licensed users may install, use and alter it.
* Original and altered files may not be (re)distributed without permission.
*}
<a href="javascript:var callback=function(){ };var isLast=true;{$jscode|escape:'html':'UTF-8'}" class="edit" title="{$action|escape:'htmlall':'UTF-8'}">
	<img src="../modules/directlabelprint/views/img/icon-print.png" style="height:20px" alt="{$action|escape:'htmlall':'UTF-8'}" />
</a>
<script>
	printShippingLabelFunctions[printShippingLabelFunctions.length]=function(js,isLast,callback){
		var js=js.replace(new RegExp("&#039;", 'g'),"'");
		console.log(js);
		eval(js);
		/*if(callback)
			callback();*/
	}.bind(this, "{$jscode|escape:'html':'UTF-8'}");
</script>