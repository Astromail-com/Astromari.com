/**
 * 2016-2021 Leone MusicReader B.V.
 *
 * NOTICE OF LICENSE
 *
 * Source file is copyrighted by Leone MusicReader B.V.
 * Only licensed users may install, use and alter it.
 * Original and altered files may not be (re)distributed without permission.
 *
 * @author    Leone MusicReader B.V.
 *
 * @copyright 2016-2021 Leone MusicReader B.V.
 *
 * @license   custom see above
 */

var printShippingLabelFunctions=[];

function convertAddressLines(address){

    var lines = address.replace(/`/,"'").replace(/&amp;/g,"&").replace(/&#039;/g,"'").split("||");
    var text = "\r" +lines[0];

    for (var i = 1; i < lines.length; i++) {
        text += "\r" + lines[i];
    }
    return text;
}

function printLabel(url,text,callback,isLast) {
    console.log("printLabel:"+url+"-"+text+"-"+callback+"-"+isLast);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var label_xml=this.responseText;
            printLabelXML(label_xml,text,callback,isLast);
        }
    }.bind(xhttp);
    xhttp.open("GET", url+"?cache="+Math.round(Math.random()*1000), true);
    xhttp.send();
}

function changeOrderStatusOfOrder(id){
    if(changeorderstatus && dlp_auto_order_status!=-1){
        saveOrderStatusChange(id,dlp_auto_order_status, function(){}, function(){
            alert(error_saving_status+" "+id);
        });
    }
}


function printLabelXML(label_xml,text,callback,isLast) {

    if (!printer_type_set) {
        if (typeof isLast == "undefined" || isLast)
            alert(message_setup_before_use);
        return;
    }

    var printers = dymo.label.framework.getPrinters();
    if (printers.length == 0) {
        if (typeof isLast == "undefined" || isLast)
            alert(no_dymo_found);
        return;
    }

    console.log("PRINTERS1:" + JSON.stringify(printers));

    var printerNames = [];
    var printerInfos = [];
    for (var i = 0; i < printers.length; ++i) {
        var printer = printers[i];
        if (printer.printerType == "LabelWriterPrinter") {
            printerNames[printerNames.length] = printer.name;
            printerInfos[printerInfos.length] = printer;
        }
    }

    console.log("PRINTERS2:" + JSON.stringify(printerNames));

    console.log("Printer COUNT:" + printerNames.length);

    var printerName = printerNames[0];
    var printerInfo = printerInfos[0];
    if (selectedDymoIndex_dlpa < printerNames.length) { //SDI
        printerName = printerNames[selectedDymoIndex_dlpa];
        printerInfo = printerInfos[selectedDymoIndex_dlpa];
    } else if (typeof printMultipleHTML == "undefined") {
        alert(incorrect_dymo_selected);
        return;
    }

    var label = dymo.label.framework.openLabelXml(label_xml);

    //DYMO LABEL SOFTWARE
        try {
            label.setObjectText("ShippingAddress", text);
            console.log("Shipping Address set:"+text);
        }
        catch (err) {
        }
    //DYMO CONNECT
        var names = label.getObjectNames();
        for (var i in names) {
                var name = names[i];
                var currentText=label.getObjectText(name);
                var replaceText="\\[\\[ShippingAddress\\]\\]";
                var re = new RegExp(replaceText, 'gi');
                var newText=currentText.replace(re,text);
                if(newText!=currentText) {
                    console.log(currentText+" to "+newText);
                    label.setObjectText(name, newText);
                }
        }

    if(id_order){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                xhttp.onreadystatechange = function () {};
                console.log("Order Info:"+this.responseText);
                var info = JSON.parse(this.responseText);

                //DYMO LABEL SOFTWARE && Other Printers
                    for (var key in info) {
                        try {
                            label.setObjectText(key, info[key]);
                            console.log("Set:"+key+"-"+info[key]);
                        } catch (err) {
                            //DYMO CONNECT
                                var names = label.getObjectNames();
                                var found=false;
                                for (var i in names) {
                                    var name = names[i];
                                    var currentText = label.getObjectText(name);
                                    if (typeof currentText != "undefined" && currentText != "found") {
                                        var replaceText="\\[\\[" + key + "\\]\\]";
                                        var re = new RegExp(replaceText, 'gi');

                                        var newText = currentText.replace(re, info[key]);
                                        if (newText != currentText) {
                                            console.log(currentText + " to " + newText);
                                            label.setObjectText(name, newText);
                                            console.log("Set2:" + key + "-" + info[key]);
                                            found = true;
                                        }
                                    }
                                }
                                if(!found)
                                    console.log("Not Found:"+key);
                        }
                    }


                if(typeof dymo.label.framework.createLabelWriterPrintParamsXml!="undefined" && typeof printerInfo.isTwinTurbo!= "undefined" && printerInfo.isTwinTurbo){
                    var printParams = {printQuality:dymo.label.framework.LabelWriterPrintQuality.Text};
                    console.log("Twin Detected Address:"+dymoPrinterIndex_dlpa);
                    if(dymoPrinterIndex_dlpa==0)
                        printParams.twinTurboRoll = dymo.label.framework.TwinTurboRoll.Left;
                    else
                        printParams.twinTurboRoll = dymo.label.framework.TwinTurboRoll.Right;
                    label.print(printerName, dymo.label.framework.createLabelWriterPrintParamsXml(printParams));
                    if(callback)
                        callback();
                }else{
                    console.log("NO TWIN detected");
                    if(typeof printMultipleHTML !="undefined") {
                        label.print(printerName, undefined, undefined, isLast, callback);
                    }else {
                        label.print(printerName, undefined, undefined, isLast);
                        if (callback)
                            callback();
                    }
                    return;
                }
            }else if(this.readyState == 4){
                alert(order_data_load_problem);
            }
        }.bind(xhttp);
        xhttp.open("GET", dlpa_controller_url+"&action=getOrderInfo&order_id=" + id_order, true);
        xhttp.send();
    }else{
        if(typeof dymo.label.framework.createLabelWriterPrintParamsXml!="undefined" && typeof printerInfo.isTwinTurbo!= "undefined" && printerInfo.isTwinTurbo) {
            var printParams = {printQuality:dymo.label.framework.LabelWriterPrintQuality.Text};
            console.log("Twin Detected Address:"+dymoPrinterIndex_dlpa);
            if(dymoPrinterIndex_dlpa==0)
                printParams.twinTurboRoll = dymo.label.framework.TwinTurboRoll.Left;
            else
                printParams.twinTurboRoll = dymo.label.framework.TwinTurboRoll.Right;
            label.print(printerName, dymo.label.framework.createLabelWriterPrintParamsXml(printParams));
        }else{
            label.print(printerName, undefined, undefined, isLast);
        }
        if(callback)
            callback();
    }
}

function printProducts(orderid,orderreference,callback,isLastOrder){
    console.log("getting products");
    //Get Products From Order
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //var label=location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+"/modules/directlabelprintproduct/MyText.label";
            var products=JSON.parse(this.responseText);
            var nr=0;
            var count = 0;
            for (var k in products) {
                if (products.hasOwnProperty(k)) {
                    ++count;
                }
            }

            var allinfo=[];

            console.log("start printing products:"+count);

            //Loop to print products
            var allproducts=[];
            for(i in products){
                allproducts[allproducts.length]=products[i];
            }

            var processNext=function(allproducts,i) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function (product_quantity, line_count) {
                    if (this.readyState == 4 && this.status == 200) {
                        xhttp.onreadystatechange = function () {
                        };
                        //location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '') + "/modules/directlabelprintproduct/MyText.label";
                        var info = JSON.parse(this.responseText);
                        info.order_id = orderid;
                        if(typeof orderreference != "undefined")
                            info.order_reference = orderreference;
                        nr++;
                        info.order_line_nr = nr;
                        info.order_line_count = line_count;
                        info.ordered_quantity = product_quantity;
                        var weight=parseFloat(info.weight);
                        if(weight>0)
                            info.order_line_total_weight=""+(weight*parseInt(product_quantity));
                        else
                            info.order_line_total_weight="n/a";
                        var isLast=undefined;
                        if(typeof isLastOrder!="undefined")
                            isLast=isLastOrder&&(allproducts.length-1==i);
                        var label_url = getProductLabelTemplateURL(allproducts[i].id_product);
                        if(printproductlabels_count){
                            printProductLabel(label_url,info, product_quantity, isLast);
                        }else{
                            printProductLabel(label_url,info, 1, isLast);
                        }
                        console.log("added:" + nr);
                        if (nr == line_count) {
                            if (callback)
                                callback();
                        }else{
                            processNext(allproducts,i+1);
                        }
                    }else if(this.readyState == 4){
                        alert(product_data_load_problem);
                    }
                }.bind(xhttp, allproducts[i].product_quantity, count);
                xhttp.open("GET",dlpp_controller_url+"&action=getProductInfo&cache="+Math.round(Math.random()*1000)+"&orderid="+orderid+"&id=" + allproducts[i].id_product + "&combination_id=" + allproducts[i].product_attribute_id, true);
                xhttp.send();
            };

            processNext(allproducts,0);

        }else if(this.readyState == 4){
            alert(product_data_load_problem);
        }
    };
    xhttp.open("GET", dlpa_controller_url+"&action=getOrderedProducts&id="+orderid, true);
    xhttp.send();

}

function printProductFromOrder(id_product,product_attribute_id,product_quantity,nr,callback,isLast){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            xhttp.onreadystatechange = function () {
            };
            //location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '') + "/modules/directlabelprintproduct/MyText.label";
            var info = JSON.parse(this.responseText);
            info.order_id = id_order;
            info.order_reference = reference;
            info.order_line_nr = nr;
            info.order_line_count = allproducts.length;
            info.ordered_quantity = product_quantity;
            var weight=parseFloat(info.weight);
            if(weight>0)
                info.order_line_total_weight=""+(weight*parseInt(product_quantity));
            else
                info.order_line_total_weight="n/a";
            var label_url_products = getProductLabelTemplateURL(id_product);
            if(printproductlabels_count){
                printProductLabel(label_url_products,info, product_quantity, isLast);
            }else{
                printProductLabel(label_url_products,info, 1, isLast);
            }

            console.log("added:" + nr);

            if(callback){
                callback();
            }
        }else if(this.readyState == 4){
            alert(product_data_load_problem);
        }
    };
    xhttp.open("GET",dlpp_controller_url+"&action=getProductInfo&cache="+Math.round(Math.random()*1000)+"&orderid="+id_order+"&id=" + id_product + "&combination_id=" + product_attribute_id , true);
    xhttp.send();
}

function printLabelSelectedOrders(pForm, boxName) {
    window.scrollTo(0, 0);

    var index=0;
    var selectedFunctions=[];

    if(typeof boxName!="undefined"){
        for (var i = 0; i < pForm.elements.length; i++){
            if (pForm.elements[i].name == boxName) {
                if(pForm.elements[i].checked){
                    selectedFunctions[selectedFunctions.length]=printShippingLabelFunctions[index];
                }
                index++;
            }
        }
    }
    else{
        //Prestashop 1.7.7+
        for (var i = 0; i < pForm.length; i++){
                if(pForm[i].checked){
                    selectedFunctions[selectedFunctions.length]=printLabelWithOrderId.bind(this,pForm[i].value);
                }
                index++;
        }
    }

    console.log("Selected Orders:"+selectedFunctions.length);

    var processNext=function(functions,i){
        callback=processNext.bind(this,functions,i+1);
        if(i<functions.length){
            var isLast=(i==functions.length-1);
            console.log("Selected Orders:"+i+"-"+isLast);
            var f=functions[i].bind(this,isLast,callback);
            f();
        }
    };

    processNext(selectedFunctions,0);
}

function printOrderLabelFromElement(el,isLast,callback){
    var id=el.parentNode.parentNode.parentNode.parentNode.firstElementChild.firstElementChild.getAttribute("value");
    if(id==null){

    }
    console.log("printOrderLabelFromElement:"+id);
    printLabelWithOrderId(id,isLast,callback);
}

function printLabelWithOrderId(id,isLast,callback){

    if(typeof isLast == "function"){
        var cb=isLast;
        isLast=callback;
        callback=cb;
    }

    id_order=id;
    console.log("Print with ID:"+id_order);
    //Get Address
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var text = convertAddressLines(xhttp.responseText);
            var shouldPrintProducts=typeof dlpp_controller_url != "undefined" && dlpp_controller_url.length>0 && addProductLabelsToPrint;
            var callback2 = function(){
                    changeOrderStatusOfOrder(id);
                    if(shouldPrintProducts) {
                        var orderreference=undefined;
                        if(typeof el!="undefined")
                            orderreference=el.parentNode.parentNode.parentNode.parentNode.firstElementChild.nextElementSibling.nextElementSibling.innerHTML.trim();
                        printProducts(id_order,orderreference,callback,isLast);
                    }else{
                        if(callback)
                            callback();
                    }
            };
            if(/*shouldPrintProducts && */!printproductlabels_hideaddress){
                printLabel(label_url,text,callback2,isLast&&!shouldPrintProducts);
            }else{
                callback2();
            }

        }else if(this.readyState == 4){
            alert(address_data_load_problem)
        }
    };
    xhttp.open("GET", dlpa_controller_url+"&action=getAddress&id="+id_order, true);
    xhttp.send();
}


var documentReadyDLP=function () {
    //Add Bulk
    var bulk = ".adminorders .bulk-actions .dropdown-menu";
    var bulk_obj=$(bulk);
    bulk_obj.append("<li>"+
        "<div onclick=\"javascript:printLabelSelectedOrders($(this).closest('form').get(0), 'orderBox[]');return false;\">"+
        "<img src=\""+shop_root+"modules/directlabelprint/views/img/icon-print.png\" style=\"height:20px\"/>&nbsp;"+print_shipping_labels+
        "</div>"+
        "</li>");

    if(bulk_obj.length==0 && document.getElementById("order_grid_bulk_action_change_order_status")){
        console.log("Bulk 1.7.7")
        //Prestashop 1.7.7+
        $("#order_grid_bulk_action_change_order_status").parent().append(("<button class=\"dropdown-item js-bulk-modal-form-submit-btn\" type=\"button\">"+
        "<div onclick=\"javascript:printLabelSelectedOrders($('.js-bulk-action-checkbox'));return false;\">"+
        "<img src=\""+shop_root+"modules/directlabelprint/views/img/icon-print.png\" style=\"height:20px\"/>&nbsp;"+print_shipping_labels+
        "</div>"+
        "</button>"));


        //Add list actions
        var action_button_groups=$(".btn-group-action .btn-group");
        for(var i=0;i<action_button_groups.length;i++) {
            $(action_button_groups[i]).append("<a href=\"javascript:void(0);\" onclick=\"javascript:printLabelWithOrderId($('.js-bulk-action-checkbox')[" + i + "].value);return false;\">" +
                "<img src=\"" + shop_root + "modules/directlabelprint/views/img/icon-print.png\" style=\"height:20px\"/>" +
                "</a>");
        }

    }

    /* Gives problems when added products to order.
    $(".order .btn-group-action .btn-group").append("" +
            "<a class=\"btn btn-default\" href=\"#\" onclick=\"printOrderFromElement(this);\">"+
            "<img src=\"/modules/directlabelprint/views/img/icon-print.png\" style=\"height:16px\"/>"+
            "</a>");*/

    if(typeof printShippingLabelFunctions == 'undefined' || printShippingLabelFunctions.length==0){
        printShippingLabelFunctions=[];
        var list=$(".btn-group-action .btn-group");
        console.log("Found Elements:"+list.length);
        for(var i=0;i<list.length;i++){
            printShippingLabelFunctions[i]=printOrderLabelFromElement.bind(this,list[i].lastElementChild);
        }
    }
};

if(window.attachEvent) {
    window.attachEvent('onload', documentReadyDLP);
} else {
    if(window.onload) {
        var curronload = window.onload;
        var newonload = function(unloadfunc,evt) {
            unloadfunc(evt);
            documentReadyDLP(evt);
        }.bind(this,curronload);
        window.onload = newonload;
    } else {
        window.onload = documentReadyDLP;
    }
}