<style>
    .pdfPrintWait{
        border: solid 1px black;
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        height: 50px;
        width: 400px;
        background-color: black;
        z-index: 100;
        font-size: 20px;
        color:white;
        text-align: center;
        line-height: 50px;
    }
</style>
<script type="text/javascript">
    /**
     * 2016 Leone MusicReader B.V.
     *
     * NOTICE OF LICENSE
     *
     * Source file is copyrighted by Leone MusicReader B.V.
     * Only licensed users may install, use and alter it.
     * Original and altered files may not be (re)distributed without permission.
     */
    var deliver = "{$stringdeliver|escape:'html':'UTF-8'}";
    var invoice = "{$stringinvoice|escape:'html':'UTF-8'}";
    var url = '{$url|escape:'htmlall':'UTF-8'}';
    var shop_root = '{$shop_root|escape:'htmlall':'UTF-8'}';

    var id="{$id|escape:'html':'UTF-8'}";
    var id_order= {$id|escape:'html':'UTF-8'};
    var reference="{$reference|escape:'html':'UTF-8'}"
    var orderToken="{$token|escape:'html':'UTF-8'}";
    var addProductLabelsToPrint={$addProductLabelsToPrint|escape:'html':'UTF-8'};
    var changeorderstatus = {$changeorderstatus|escape:'html':'UTF-8'};
    var dlp_auto_order_status = {$dlp_auto_order_status|escape:'html':'UTF-8'};
    var selectedDymoIndex_dlpa={$selectedDymoIndex|escape:'html':'UTF-8'};//SDI
    var dymoPrinterIndex_dlpa={$dymoPrinterIndex|escape:'html':'UTF-8'};

    var printproductlabels_count={$printproductlabels_count|escape:'html':'UTF-8'};
    var printproductlabels_hideaddress={$printproductlabels_hideaddress|escape:'html':'UTF-8'};

    var dlpa_controller_url="{$dlpa_controller_url|escape:'quotes':'UTF-8'}";
    var dlpp_controller_url="{$dlpp_controller_url|escape:'quotes':'UTF-8'}";

    var message_setup_before_use="{l s='Module requires setup before use, please go to Module Settings.' mod='directlabelprint'}";
    var enter_label_count="{l s='Please enter number of labels.' mod='directlabelprint'}";
    var no_dymo_found="{l s='Can\'t find DYMO label printers. Please go to module settings for details.' mod='directlabelprint'}";
    var incorrect_dymo_selected="{l s='Incorrect printer set in settings. Please set available Dymo printer.' mod='directlabelprint'}";
    var error_saving_status="{l s='Error saving status change for order' mod='directlabelprint'}";
    var order_data_load_problem="Direct Label Print - {l s='couldn\'t load order data.' mod='directlabelprint'}";
    var product_data_load_problem="Direct Label Print - {l s='couldn\'t load product data.' mod='directlabelprint'}";
    var address_data_load_problem="Direct Label Print - {l s='couldn\'t load address data.' mod='directlabelprint'}";
    var print_shipping_labels="{l s='Print Shipping Labels' mod='directlabelprint'}";

     var documentReadyDLPOD=function () {
        //Order Details
            //1.5
            var x = ".container-command-top-spacing div:first-child form p";
            var y = ".container-command-top-spacing div:nth-child(2) form p";
            $(x).append('<div id="printLabel" onclick="printLabeldeliver();" title="DYMO printer"></div>');
            $(y).append('<div id="printLabel" title="DYMO printer" onclick="printLabelinvoice();"></div>');
            //1.6
            var x = "#addressShipping .row";
            var y = "#addressInvoice .row";
            $(x).append('&nbsp;<br><div id="printLabel" onclick="printLabeldeliver();" title="DYMO printer"></div>');
            $(y).append('&nbsp;<br><div id="printLabel" title="DYMO printer" onclick="printLabelinvoice();"></div>');

            if(dlpp_controller_url && dlpp_controller_url.length>0) {

                var lines=$(".product-line-row");
                if(lines.length==0){
                    lines=$(".cellProductActions");
                }
                if(lines.length==0) {
                    lines = $(".cellProductName");
                }
                //Get Products From Order
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var products = JSON.parse(this.responseText);

                        allproducts=[];
                        for(i in products){
                            allproducts[allproducts.length]=products[i];
                        }

                        console.log("Count comparison:"+allproducts.length+"-"+lines.length);

                        for(i in allproducts){
                            $(lines[i]).append("<td><a href=\"javascript:void(0)\" onclick=\"printProductFromOrder("+allproducts[i].product_id+","+ allproducts[i].product_attribute_id+","+allproducts[i].product_quantity+","+(parseInt(i)+1)+",undefined,true);\"><img src=\""+shop_root+"/modules/directlabelprint/views/img/icon-print.png\" style=\"height:25px\"/></a></td>");
                        }
                    }else if(this.readyState == 4){
                        alert("{l s='Direct Label Print couldn\'t load product data.' mod='directlabelprint'}");
                    }
                };
                xhttp.open("GET", dlpa_controller_url+"&action=getOrderedProducts&id="+id_order, true);
                xhttp.send();

            }
    };

    if(window.attachEvent) {
        window.attachEvent('onload', documentReadyDLPOD);
    } else {
        if(window.onload) {
            var curronload = window.onload;
            var newonload = function(curronload,evt) {
                curronload(evt);
                documentReadyDLPOD(evt);
            }.bind(this,curronload);
            window.onload = newonload;
        } else {
            window.onload = documentReadyDLPOD;
        }
    }

    {literal}
    function printLabeldeliver() {
        var text = convertAddressLines(deliver);
        var addProductsPrint=dlpp_controller_url && dlpp_controller_url.length>0 && addProductLabelsToPrint;
        var isLastOrder=true;
        var myCallback=function(){
            changeOrderStatusOfOrder(id);
            if(addProductsPrint) {
                console.log("getting products");
                //Get Products From Order

                var processNext=function(i) {
                    var isLast=undefined;
                    if(typeof isLastOrder!="undefined")
                        isLast=isLastOrder&&(allproducts.length-1==i);
                    printProductFromOrder(allproducts[i].id_product,allproducts[i].product_attribute_id,allproducts[i].product_quantity,i+1,function(){
                        if (i >= allproducts.length-1) {
                            if (callback)
                                callback();
                        }else{
                            processNext(i+1);
                        }
                    },isLast);
                };

                processNext(0);
            }
        };
        if(addProductsPrint && printproductlabels_hideaddress) {
            myCallback();
        }else{
            printLabel(url, text, myCallback, !addProductsPrint);
        }
    }
    function printLabelinvoice() {
        var text = convertAddressLines(invoice);
        printLabel(url,text);
    }

    {/literal}

    var dlpa_generic_label_width={$generic_label_width|escape:'html':'UTF-8'};
    var dlpa_generic_label_height={$generic_label_height|escape:'html':'UTF-8'};
    var dlpa_generic_label_rotate={$generic_label_rotate|escape:'html':'UTF-8'};
    var dlpa_generic_label_content='{$generic_label_content|escape:'quotes':'UTF-8'}';
    var printer_type_set={$printertypeset|escape:'html':'UTF-8'};
</script>