<script type="text/javascript">
    /**
     * 2017 Leone MusicReader B.V.
     *
     * NOTICE OF LICENSE
     *
     * Source file is copyrighted by Leone MusicReader B.V.
     * Only licensed users may install, use and alter it.
     * Original and altered files may not be (re)distributed without permission.
     */

    var fields=["ShippingAddress",
        "shipping_method",
        "order_reference",
        "order_id",
        "invoice_number",
        "tracking_number",
        "first_order",
        "telephone_invoice",
        "telephone_delivery",
        "mobile_invoice",
        "mobile_delivery",
        "vat_number",
        "customer_email",
        "address_shipping_company",
        "address_shipping_name",
        "address_shipping_address1",
        "address_shipping_address2",
        "address_shipping_postcode",
        "address_shipping_city",
        "address_shipping_state",
        "address_shipping_other",
        "address_shipping_country",
        "address_billing_company",
        "address_billing_name",
        "address_billing_address1",
        "address_billing_address2",
        "address_billing_postcode",
        "address_billing_city",
        "address_billing_state",
        "address_billing_other",
        "address_billing_country"];

    var printertyperror="{$printertypeerror|escape:'html':'UTF-8'}";
    var printertypedymo={$printertype|escape:'html':'UTF-8'};
    var dymoPrinterIndex_dlpa={$dymoPrinterIndex|escape:'html':'UTF-8'};
    var selectedDymoIndex_dlpa={$selectedDymoIndex|escape:'html':'UTF-8'};//SDI
    var changeorderstatus={$changeorderstatus|escape:'html':'UTF-8'};
    var dlp_auto_order_status={$dlp_auto_order_status|escape:'html':'UTF-8'};

    function adjustDisplay(){
        var menuButtons=$("#generalSettingsButton,#manageTemplatesButton, #advancedSettingsButton,#helpButton,#recommendedModulesButton");

        menuButtons.on("click",function(ev){
            menuButtons.removeClass("selected_button");
            $( ev.delegateTarget).addClass("selected_button");
            $(".generalSettingsArea,.advancedSettingsArea, .manageTemplatesArea, .helpArea, .recommendedModulesArea").hide();
            $("."+ev.delegateTarget.id.replace("Button","Area")).show();
            $(".informationMessage").hide();
        });

        var openArea="{$openSettingsArea|escape:'html':'UTF-8'}";
        if(openArea.length>0){
            $("#"+openArea+"Button").trigger("click");
            $(".informationMessage").show();
        }


        if(printertyperror.length>4){
            //CHECK IF DYMO LABEL
            var printers = dymo.label.framework.getPrinters();
            if (printers.length >0) {
                document.getElementById('printertype_on').checked=true;
            }
            $("#dymoSettings").remove();
            $("#dymoSoftwareType").hide();
        }
        else if(printertypedymo){
            $(".otherPrinterArea").remove();
            var printers = dymo.label.framework.getPrinters();
            if (printers.length >0) {
                menuButtons.show();

                //Add Row List
                var columns=$("#row_list ul");
                var items_per_column=Math.round(fields.length/columns.length);
                for(var i=0;i<columns.length;i++){
                    for(var j=0;(i*items_per_column+j)<fields.length && j<items_per_column;j++){
                        $(columns[i]).append("<li>"+fields[(i*items_per_column)+j]+"</li>");
                    }
                }

                //Dymo Printers Lists //SDI
                var printers = dymo.label.framework.getPrinters();

                var j=0;
                var optionsCode="";
                for (var i = 0; i < printers.length; ++i) {
                    var printer = printers[i];
                    if (printer.printerType == "LabelWriterPrinter") {
                        $("#dymo_select select").append($('<option>', {
                            value: j,
                            text: printer.name,
                            selected: (j==selectedDymoIndex_dlpa)
                        }));
                        j++;
                    }
                }
            }else{
                $("#noDymoFoundError").show();
            }

            if("{$dymosoftwaretype|escape:'html':'UTF-8'}"=="true"){
                $(".dymoLabelInstructions").remove();
            }else{
                $(".dymoConnectInstructions").remove();
            }

            $("#downloadDymoTemplate").on("click",function() {
                var url=dlpa_controller_url + "&action=getCurrentTemplate&cache="+Math.round(Math.random()*1000);
                window.open(url, "_blank");
            });

        }
        else{
            $(".dymoPrinterArea").remove();
            $("#dymoSoftwareType").hide();
            menuButtons.show();
            generateConfigurationScreen();

            for(var i=0;i<fields.length;i++){
                $("#summernote_fields_insert").append("<option value=\""+fields[i]+"\">[["+fields[i]+"]]</option>");
                if(document.getElementById("summernote_barcode_insert"))
                    $("#summernote_barcode_insert").append("<option value=\""+fields[i]+"\">[["+fields[i]+"]]</option>");
                if(document.getElementById("summernote_qrcode_insert"))
                    $("#summernote_qrcode_insert").append("<option value=\""+fields[i]+"\">[["+fields[i]+"]]</option>");
            }
        }

        if(changeorderstatus){
            $.get(dsu_controller_url+"&action=getInfo&function=statuses_list&language="+dsu_language,undefined,function(status_list){
                var select_status=$("#auto_order_status select");
                status_list.forEach(function (s) {
                    select_status.append($('<option>', {
                        value: s.id_order_state,
                        text: s.name,
                        style: "color:white;background-color:" + s.color
                    }));
                });
                select_status.val(dlp_auto_order_status);
            }, "json");
        }else{
            $("#auto_order_status").hide();
        }

        $(".module_directlabelprint").hide();
    }



    if(window.attachEvent) {
        window.attachEvent('onload', adjustDisplay);
    } else {
        if(window.onload) {
            var curronload = window.onload;
            var newonload = function(curronload,evt) {
                curronload(evt);
                adjustDisplay(evt);
            }.bind(this,curronload);
            window.onload = newonload;
        } else {
            window.onload = adjustDisplay;
        }
    }

    var barcode_sample_url = "{$barcode_sample_url|escape:'html':'UTF-8'}";
    var qrcode_sample_url="{$qrcode_sample_url|escape:'html':'UTF-8'}";
</script>

<style>


</style>

<div id="ConfigTabBar">
    <button class="btn btn-default selected_button" id="generalSettingsButton"><i class="icon-gear" ></i><br/>{l s='General Settings' mod='directlabelprint'}</button>
    <button class="btn btn-default" id="manageTemplatesButton"><i class="icon-edit" ></i><br/>{l s='Manage Template' mod='directlabelprint'}</button>
    <button class="btn btn-default" id="advancedSettingsButton"><i class="icon-gear" ></i><br/>{l s='Advanced Settings' mod='directlabelprint'}</button>
    <button class="btn btn-default" id="helpButton"><i class="icon-question" ></i><br/>{l s='Help & Rating' mod='directlabelprint'}</button>
    <button class="btn btn-default" id="recommendedModulesButton"><i class="icon-puzzle-piece" ></i><br/>{l s='Recommended Modules' mod='directlabelprint'}</button>
</div>

{if isset($error) }
    <ps-alert-error class="informationMessage">{$error|escape:'html':'UTF-8'}</ps-alert-error>
{/if}
{if isset($success) }
    <ps-alert-success class="informationMessage">{$success|escape:'html':'UTF-8'}</ps-alert-success>
{/if}

<ps-alert-error id="noDymoFoundError">{l s='The module can\'t find a DYMO Printer.' mod='directlabelprint'}<br/>
    {l s='Please make sure:' mod='directlabelprint'}<br/>
    <ul>
        <li>{l s='You have a DYMO Printer. If not, then please select "Other" below.' mod='directlabelprint'}</li>
        <li>{l s='The latest DYMO Label or Dymo Connect Software is installed, to be sure we recommend to reinstall from' mod='directlabelprint'} <a href="https://www.dymo.com/on/demandware.store/Sites-dymo-Site/en_US/Support-user-guides" target="_blank">{l s='this website' mod='directlabelprint'}</a>.</li>
        <li>{l s='Still not working? Then click on the Dymo icon in system tray and choose "Diagnose". That should tell what is wrong.' mod='directlabelprint'}</li>
        <li><a href="https://addons.prestashop.com/contact-form.php?id_product=26296" target="_blank">{l s='Contact us if you still have problems getting it working.' mod='directlabelprint'}</a></li>
    </ul>
</ps-alert-error>

<ps-panel header="{l s='Printer Type' mod='directlabelprint'}" img="{$iconurl|escape:'html':'UTF-8'}" class="generalSettingsArea">
    {if isset($printertypeerror) }
        <ps-alert-error>{$printertypeerror|escape:'html':'UTF-8'}</ps-alert-error>
    {/if}
    <form class="form-horizontal" action="{$formactionurl|escape:'html':'UTF-8'}" method="POST" enctype="multipart/form-data" >
        <ps-switch name="printertype" label="{l s='Printer Type' mod='directlabelprint'}" yes="DYMO" no="{l s='Other' mod='directlabelprint'}" active="{$printertype|escape:'html':'UTF-8'}" help="{l s='DYMO LabelWriter or Other (Label) Printer.' mod='directlabelprint'}"></ps-switch>
        <ps-switch id="dymoSoftwareType" name="dymosoftwaretype" label="{l s='Dymo Software' mod='directlabelprint'}" yes="Connect" no="Label" active="{$dymosoftwaretype|escape:'html':'UTF-8'}" help="{l s='Are you using Dymo Connect or Dymo Label Software?' mod='directlabelprint'}"></ps-switch>

        <input type="hidden" name="printertype_submit" value="printertype_submit"/>

        <ps-panel-footer>
            <ps-panel-footer-submit title="{l s='Save' mod='directlabelprint'}" icon="process-icon-save" direction="right" name="submitPanel"></ps-panel-footer-submit>
        </ps-panel-footer>
    </form>
</ps-panel>

<ps-panel id="dymoPanel" header="{l s='Dymo - Upload Label Template' mod='directlabelprint'}" img="{$iconurl|escape:'html':'UTF-8'}" class="manageTemplatesArea dymoPrinterArea">



    <form class="form-horizontal" action="{$formactionurl|escape:'html':'UTF-8'}" method="POST" enctype="multipart/form-data" >
        <ps-input-upload id="upload_file" name="filelabel" label="{l s='Label Template' mod='directlabelprint'}" size="20" required-input="true" hint="{l s='Upload Template File' mod='directlabelprint'}" fixed-width="300"></ps-input-upload>
        <input type="hidden" name="upload" value="upload"/>
        <input type="hidden" name="settingsArea" value="manageTemplates"/>

        <button class="btn btn-default" type="submit" style="margin-left:25%">
            <i class="icon-upload-alt" ></i>
            {l s='Upload new template' mod='directlabelprint'}
        </button>
    </form>

    <button id="downloadDymoTemplate"><i class="icon-download"></i>{l s='Download Current Template' mod='directlabelprint'}</button>

    <ps-panel-divider></ps-panel-divider>

    <div class="dymoLabelInstructions">
        <p>
        {l s='Upload a file from the DYMO Label Software as template.' mod='directlabelprint'}<br/>
        {l s='This template will determine size and layout of printed labels.' mod='directlabelprint'}<br/>
        {l s='There is an default template inside module (Shipping label - 4" x 2 1/8 ").' mod='directlabelprint'}<br/>
        {l s='You only need to change template is you need another size or need another layout.' mod='directlabelprint'}
        </p>

        <ps-alert-warn>
            <b>{l s='Are you using Dymo Connect?' mod='directlabelprint'}</b><br/>
            {l s='Then go to "General Settings" and change "Dymo Software" to "Connect".' mod='directlabelprint'} "Connect".
        </ps-alert-warn>
        <p>
            <a href="{$imgfolder|escape:'html':'UTF-8'}DymoLabelSoftwareConfig.png" target="_blank"> <img src="{$imgfolder|escape:'html':'UTF-8'}DymoLabelSoftwareConfig.png" height="220" style="float:right"/></a>
            <b>{l s='TEMPLATE INSTRUCTIONS' mod='directlabelprint'}</b><br/>
            {l s='This Dymo file needs to contain text/barcode objects with a correct "reference name" in "properties".' mod='directlabelprint'}<br/>
            {l s='This "reference name" will determine which data will be put inside the object.' mod='directlabelprint'}<br/>
            {l s='You can edit this reference name inside the Dymo Label software.' mod='directlabelprint'}<br/>
        </p>
        <p>
            {l s='Normally the module erases the object text in the template and replaces completely with product data.' mod='directlabelprint'}<br/>
            {l s='So for example "Reference:" with reference name "order_reference" will become "OrderReference".' mod='directlabelprint'}<br/>
            {l s='However, if you add (*) to the sample data it will add product data on that location.' mod='directlabelprint'}<br/>
            {l s='So for example "Reference: (*)" with reference name "order_reference" will become "Reference: OrderReference".' mod='directlabelprint'}<br/>
        </p>
        <p><a href="http://somup.com/cbVZ2aMsL" target="_blank"><i class="icon-youtube-play"></i> <b>{l s='Video Tutorial' mod='directlabelprint'}</b></a></p>
        <p><a href="{$sampletemplateurl_label|escape:'html':'UTF-8'}" download target="_blank"><i class="icon-download"></i> <b>{l s='Sample Template (Shipping label - 4" x 2 1/8 ")' mod='directlabelprint'}</b></a></p>
        &nbsp;<br/><p>
            {l s='The following reference names are supported:' mod='directlabelprint'}
        </p>
    </div>

    <div class="dymoConnectInstructions">

        <ps-alert-warn>
            <b>{l s='Are you using Dymo Label Software?' mod='directlabelprint'}</b><br/>
            {l s='Then go to "General Settings" and change "Dymo Software" to "Label".' mod='directlabelprint'} "Label".
        </ps-alert-warn>

        <a href="{$imgfolder|escape:'html':'UTF-8'}DymoConnectSoftwareConfig.png" target="_blank"> <img src="{$imgfolder|escape:'html':'UTF-8'}DymoConnectSoftwareConfig.png" height="220" style="float:right"/></a>

        <p>
            {l s='Upload a file from the DYMO Connect Software as template.' mod='directlabelprint'}<br/>
            {l s='This template will determine size and layout of printed labels.' mod='directlabelprint'}<br/>
            {l s='There is an default template inside module (Shipping label - 4" x 2 1/8 ").' mod='directlabelprint'}<br/>
            {l s='You only need to change template is you need another size or need another layout.' mod='directlabelprint'}
        </p>

        <p>
            <b>{l s='TEMPLATE INSTRUCTIONS' mod='directlabelprint'}</b><br/>
            {l s='This Dymo file needs to contain text/barcode objects containing [[field_name]].' mod='directlabelprint'}<br/>
            {l s='Location where you put [[field_name]] content will be replaced with fields\' content.' mod='directlabelprint'}<br/>
            {l s='You can edit this reference name inside the Dymo Label software.' mod='directlabelprint'}<br/>
        </p>

        <!--<p><a href="" target="_blank"><i class="icon-youtube-play"></i> <b>Video Tutorial</b></a></p>-->
        <p><a href="{$sampletemplateurl_connect|escape:'html':'UTF-8'}" download target="_blank"><i class="icon-download"></i> <b>{l s='Sample Template (Shipping label - 4" x 2 1/8 ")' mod='directlabelprint'}</b></a></p>
        &nbsp;<br/><p>
             {l s='The following reference names are supported:' mod='directlabelprint'}
        </p>

    </div>

    <ul>
        <li><b>ShippingAddress</b> - {l s='complete address with format adapted to country recommended format.' mod='directlabelprint'}</li>
    </ul>
    <ul>
        <li><b>order_reference</b> - {l s='order reference' mod='directlabelprint'}</li>
        <li><b>order_id</b> - {l s='order id' mod='directlabelprint'}</li>
        <li><b>invoice_number</b> - {l s='invoice number' mod='directlabelprint'}<br/></li>
    </ul><ul>
        <li><b>shipping_method</b> - {l s='name of shipping method' mod='directlabelprint'}.</li>
        <li><b>tracking_number</b> - {l s='tracking number of order' mod='directlabelprint'}<br/></li>
    </ul><ul>
        <li><b>first_order</b> - {l s='is this first order of customer (yes/no)?' mod='directlabelprint'}<br/></li>
        <li><b>vat_number</b> - {l s='VAT Number of customer.' mod='directlabelprint'}</li>
    </ul><ul>
        <li><b>telephone_invoice</b> - {l s='Telephone' mod='directlabelprint'} {l s='from invoice address' mod='directlabelprint'}.</li>
        <li><b>telephone_delivery</b> - {l s='Telephone' mod='directlabelprint'} {l s='from deliver address' mod='directlabelprint'}.</li>
        <li><b>mobile_invoice</b> - {l s='Mobile' mod='directlabelprint'} {l s='from invoice address' mod='directlabelprint'}.</li>
        <li><b>mobile_delivery</b> - {l s='Mobile' mod='directlabelprint'} {l s='from delivery address' mod='directlabelprint'}.</li>
    </ul><ul>
        <li><b>address_shipping_company</b> - {l s='company name' mod='directlabelprint'} {l s='in shipping address' mod='directlabelprint'}.</li>
        <li><b>address_shipping_name</b> - {l s='name' mod='directlabelprint'} {l s='in shipping address' mod='directlabelprint'}.</li>
        <li><b>address_shipping_address1</b> - {l s='Address line' mod='directlabelprint'} 1 {l s='of shipping address' mod='directlabelprint'}.</li>
        <li><b>address_shipping_address2</b> - {l s='Address line' mod='directlabelprint'} 2 {l s='of shipping address' mod='directlabelprint'}.</li>
        <li><b>address_shipping_postcode</b> - {l s='Postcode' mod='directlabelprint'} {l s='of shipping address' mod='directlabelprint'}.</li>
        <li><b>address_shipping_city</b> - {l s='City' mod='directlabelprint'} {l s='of shipping address' mod='directlabelprint'}.</li>
        <li><b>address_shipping_state</b> - {l s='State' mod='directlabelprint'} {l s='of shipping address' mod='directlabelprint'}.</li>
        <li><b>address_shipping_other</b> - {l s='Other field' mod='directlabelprint'} {l s='of shipping address' mod='directlabelprint'}.</li>
        <li><b>address_shipping_country</b> - {l s='Country' mod='directlabelprint'} {l s='of shipping address' mod='directlabelprint'}.</li>
    </ul>
    <ul>
        <li><b>address_billing_company</b> - {l s='company name' mod='directlabelprint'} {l s='in billing address' mod='directlabelprint'}.</li>
        <li><b>address_billing_name</b> - {l s='name' mod='directlabelprint'} {l s='in billing address' mod='directlabelprint'}.</li>
        <li><b>address_billing_address1</b> - {l s='Address line' mod='directlabelprint'} 1 {l s='of billing address' mod='directlabelprint'}.</li>
        <li><b>address_billing_address2</b> - {l s='Address line' mod='directlabelprint'} 2 {l s='of billing address' mod='directlabelprint'}.</li>
        <li><b>address_billing_postcode</b> - {l s='Postcode' mod='directlabelprint'} {l s='of billing address' mod='directlabelprint'}.</li>
        <li><b>address_billing_city</b> - {l s='City' mod='directlabelprint'} {l s='of billing address' mod='directlabelprint'}.</li>
        <li><b>address_billing_state</b> - {l s='State' mod='directlabelprint'} {l s='of billing address' mod='directlabelprint'}.</li>
        <li><b>address_billing_other</b> - {l s='Other field' mod='directlabelprint'} {l s='of billing address' mod='directlabelprint'}.</li>
        <li><b>address_billing_country</b> - {l s='Country' mod='directlabelprint'} {l s='of billing address' mod='directlabelprint'}.</li>
    </ul>

    &nbsp;<br>&nbsp;<br>


    &nbsp;<br>
    </ps-panel>

    <ps-panel id="otherPrinterPanel" header="{l s='Change Label Template' mod='directlabelprint'}" img="{$iconurl|escape:'html':'UTF-8'}" class="manageTemplatesArea otherPrinterArea">
        <form class="form-horizontal" action="{$formactionurl|escape:'html':'UTF-8'}" method="POST" enctype="multipart/form-data" OnSubmit="copyLabelContent()">

            <ps-input-text id="width_input" name="width_input" label="{l s='Label Width' mod='directlabelprint'}" size="20" hint="{l s='Enter width of label used.' mod='directlabelprint'}" help="{l s='Please enter whole numbers only (no dots, commas or text). The unit doesn\'t matter, the printer settings decides the actual size.' mod='directlabelprint'}" fixed-width="50" value="{$width_input|escape:'html':'UTF-8'}"></ps-input-text>
            <ps-input-text id="height_input" name="height_input" label="{l s='Label Height' mod='directlabelprint'}" size="20" hint="{l s='Enter height of label used.' mod='directlabelprint'}" help="{l s='Please enter whole numbers only (no dots, commas or text). The unit doesn\'t matter, the printer settings decides the actual size.' mod='directlabelprint'}" fixed-width="50" value="{$height_input|escape:'html':'UTF-8'}"></ps-input-text>

            <ps-alert-warn><b>{l s='Important! Please make sure "Paper Size" in your printer settings / preferences is set correctly.' mod='directlabelprint'}</b></ps-alert-warn>

            <ps-switch id="rotate_image" name="rotate_image" label="{l s='Rotate Label' mod='directlabelprint'}"  hint="{l s='This allows to change orientation of print. If YES then label is rotated 90 degrees.' mod='directlabelprint'}" yes="{l s='Yes' mod='directlabelprint'}" no="{l s='No' mod='directlabelprint'}" active="{$rotate_image|escape:'html':'UTF-8'}"></ps-switch>

            &nbsp;<br/>
            <ps-form-group label="{l s='Label Template' mod='directlabelprint'}"  hint="{l s='Design your label and decide what to show.' mod='directlabelprint'}">
                <div id="editer_header_buttons">
                    <select id="summernote_fields_insert" style="display:inline-block;width:150px" onChange="insertTextField()">
                        <option value="header">{l s='Add Field' mod='directlabelprint'}</option>
                    </select>
                    <select id="summernote_barcode_insert" style="display:inline-block;width:150px" onChange="insertBarcodeField()">
                        <option value="header">{l s='Add Barcode' mod='directlabelprint'}</option>
                        <option value="">{l s='Custom Text' mod='directlabelprint'}</option>
                    </select>
                    <select id="summernote_qrcode_insert" style="display:inline-block;width:150px" onChange="insertQRField()">
                        <option value="header">{l s='Add QR-code' mod='directlabelprint'}</option>
                        <option value="">{l s='Custom Text' mod='directlabelprint'}</option>
                    </select>
                    <a href="javascript:void(0)" class="editor_print" onclick="printTemplate()"><img src="{$printicon|escape:'html':'UTF-8'}"/></a>
                </div>

                <!-- PLEASE READ - field "label_content" below is HTML-based template - can't be escape or it won't work -->
                <div id="summernote">{$label_content}</div>

            </ps-form-group>

            <input type="hidden" id="label_content" name="label_content" value="{$label_content|escape:'html':'UTF-8'}"/>
            <input type="hidden" name="generic_label_submit" value="generic_label_submit"/>
            <input type="hidden" name="settingsArea" value="manageTemplates"/>

            <ps-panel-footer>
                <ps-panel-footer-submit title="{l s='Save' mod='directlabelprint'}" icon="process-icon-save" direction="right" name="submitPanel"></ps-panel-footer-submit>
            </ps-panel-footer>

        </form>
    </ps-panel>


<ps-panel id="dymoSettings" header="{l s='Dymo Settings' mod='directlabelprint'}" img="{$iconurl|escape:'html':'UTF-8'}" class="generalSettingsArea dymoPrinterArea">
    <form class="form-horizontal" action="{$formactionurl|escape:'html':'UTF-8'}" method="POST" enctype="multipart/form-data" >
        <!--//SDI-->
        {l s='If you have multiple Dymo printer you can select printer here:' mod='directlabelprint'}

        <div style="width:700px;">
        <ps-select id="dymo_select" label="{l s='Printer Select' mod='directlabelprint'}" name="selectedDymoIndex" chosen='false'>
            <option value="1000">{l s='Please select printer' mod='directlabelprint'}</option>
        </ps-select>
        </div>
        {l s='If you have a duo/twin Dymo or two Dymo printers you can use this setting to choose roll.' mod='directlabelprint'}<br/>&nbsp;<br/>

        <ps-switch name="dymoPrinterIndex" label="{l s='Which Dymo Roll' mod='directlabelprint'}" yes="{l s='Right' mod='directlabelprint'}" no="{l s='Left' mod='directlabelprint'}" active="{$dymoPrinterIndexActive|escape:'html':'UTF-8'}"></ps-switch>
        <input type="hidden" name="dymoSettings" value="dymoSettings"/>&nbsp;<br/>

        <ps-panel-footer>
            <ps-panel-footer-submit title="{l s='Save' mod='directlabelprint'}" icon="process-icon-save" direction="right" name="submitPanel"></ps-panel-footer-submit>
        </ps-panel-footer>

    </form>
</ps-panel>


    <ps-panel id="printProductLabelsPanel" header="{l s='Print Product Labels' mod='directlabelprint'}" img="{$iconurl|escape:'html':'UTF-8'}" class="advancedSettingsArea">

    {l s='You can also print product labels of ordered products together with the address.' mod='directlabelprint'}<br/>
    {l s='For this feature you need' mod='directlabelprint'} <a href="https://addons.prestashop.com/oo/preparation-shipping/26296-direct-label-print-product-barcode-edition.html" target="_blank">{l s='Direct Label Print Product/Barcode Edition' mod='directlabelprint'}</a> {l s='installed' mod='directlabelprint'}.<br/>
    {l s='After installing that module print icons appears next to products on order page.' mod='directlabelprint'}<br/>&nbsp;<br/>

    {l s='Want to print all product labels with address label?' mod='directlabelprint'}<br/>
    {l s='Then enable the setting below.' mod='directlabelprint'}<br/>&nbsp;<br/>

    <form class="form-horizontal" action="{$formactionurl|escape:'html':'UTF-8'}" method="POST" enctype="multipart/form-data" >
    <ps-switch name="printproductlabels" label="{l s='Print Product Labels with Address Label' mod='directlabelprint'}" yes="{l s='Yes' mod='directlabelprint'}" no="{l s='No' mod='directlabelprint'}" active="{$printproductlabels|escape:'html':'UTF-8'}"></ps-switch>
    <ps-switch name="printproductlabels_count" label="{l s='Count of product Labels' mod='directlabelprint'}" yes="{l s='Ordered' mod='directlabelprint'}" no="{l s='Only One' mod='directlabelprint'}" active="{$printproductlabels_count|escape:'html':'UTF-8'}"></ps-switch>
    <ps-switch name="printproductlabels_hideaddress" label="{l s='Hide address label' mod='directlabelprint'}" yes="{l s='Yes' mod='directlabelprint'}" no="{l s='No' mod='directlabelprint'}" active="{$printproductlabels_hideaddress|escape:'html':'UTF-8'}"></ps-switch>
        <input type="hidden" name="settings" value="settings"/>&nbsp;<br/>
        <input type="hidden" name="settingsArea" value="advancedSettings"/>

        <ps-alert-warn>{l s='PLEASE NOTE:' mod='directlabelprint'} <a href="https://addons.prestashop.com/oo/preparation-shipping/26296-direct-label-print-product-barcode-edition.html" target="_blank">{l s='Direct Label Print Product/Barcode Edition' mod='directlabelprint'}</a> {l s='needs to be installed for this feature.' mod='directlabelprint'}</ps-alert-warn>

    <ps-panel-footer>
        <ps-panel-footer-submit title="{l s='Save' mod='directlabelprint'}" icon="process-icon-save" direction="right" name="submitPanel"></ps-panel-footer-submit>
    </ps-panel-footer>

    </form>


</ps-panel>


<ps-panel id="changeOrderStatusPanel" header="{l s='Change Order Status' mod='directlabelprint'}" img="{$iconurl|escape:'html':'UTF-8'}" class="advancedSettingsArea">

    {l s='You can also update order status when printing a label.' mod='directlabelprint'}<br/>
    {l s='For this feature you need' mod='directlabelprint'} <a href="https://addons.prestashop.com/oo/order-management/39930-order-status-carrier-tracking-direct-status-update.html" target="_blank">Direct Status Update</a> {l s='installed' mod='directlabelprint'}.<br/>&nbsp;<br/>

    {l s='Want to update order status when printing?' mod='directlabelprint'}<br/>
    {l s='Then enable the setting below.' mod='directlabelprint'}<br/>&nbsp;<br/>

    <form class="form-horizontal" action="{$formactionurl|escape:'html':'UTF-8'}" method="POST" enctype="multipart/form-data" >
        <ps-switch name="changeorderstatus" label="{l s='Change Order Status' mod='directlabelprint'}" yes="{l s='Yes' mod='directlabelprint'}" no="{l s='No' mod='directlabelprint'}" active="{$changeorderstatus|escape:'html':'UTF-8'}"></ps-switch>

        <ps-select id="auto_order_status" label="{l s='Automatic Status Change' mod='directlabelprint'}" name="auto_order_status" chosen='false' help="{l s='Sets to this status when label is printed.' mod='directlabelprint'}">
            <option value="-1">{l s='Keep current status / no change' mod='directlabelprint'}</option>
        </ps-select>

        <input type="hidden" name="orderStatusSettings" value="orderStatusSettings"/>&nbsp;<br/>
        <input type="hidden" name="settingsArea" value="advancedSettings"/>

        <ps-alert-warn>{l s='PLEASE NOTE:' mod='directlabelprint'} <a href="https://addons.prestashop.com/oo/order-management/39930-order-status-carrier-tracking-direct-status-update.html" target="_blank">Direct Status Update</a> {l s='needs to be installed for this feature.' mod='directlabelprint'}</ps-alert-warn>

        <ps-alert-warn>{l s='PLEASE NOTE:' mod='directlabelprint'} {l s='Status is changed in the background, you need to refresh page to see the latest status.' mod='directlabelprint'}</ps-alert-warn>

        <ps-panel-footer>
            <ps-panel-footer-submit title="{l s='Save' mod='directlabelprint'}" icon="process-icon-save" direction="right" name="submitPanel"></ps-panel-footer-submit>
        </ps-panel-footer>

        </form>
</ps-panel>

<ps-panel id="helpPanel" header="{l s='Help & Rating' mod='directlabelprint'}" img="{$iconurl|escape:'html':'UTF-8'}" class="helpArea">

    <table border="0" style="width:100%;height:100px;font-size:15px">
        <tr><td style="width:50%">
                <a href="https://addons.prestashop.com/contact-form.php?id_product=15699" target="_black">
                    <img src="{$imgfolder|escape:'html':'UTF-8'}email.png" width="70"/>
                    <img src="{$imgfolder|escape:'html':'UTF-8'}help.png" width="70"/>
                    <img src="{$imgfolder|escape:'html':'UTF-8'}chat.png" width="70"/><br/>
                    {l s='Need help? Have problem / complaint?' mod='directlabelprint'}<br/> {l s='Any special needs?' mod='directlabelprint'} <br/> <b>{l s='Please contact us, we are here to help.' mod='directlabelprint'}</b>
                </a>
            </td><td>
                <a href="https://addons.prestashop.com/ratings.php" target="_black">
                    <img src="{$imgfolder|escape:'html':'UTF-8'}star.png" width="70"/>
                    <img src="{$imgfolder|escape:'html':'UTF-8'}thumbsup.png" width="70"/><br/>
                    {l s='Do you have everything running? And are you happy?' mod='directlabelprint'}<br/> <b>{l s='Please rate / review this module.' mod='directlabelprint'}</b>
                </a>
            </td>
        </tr>
    </table>

</ps-panel>

<ps-panel id="recommendedModulesPanel" header="{l s='Recommended Modules' mod='directlabelprint'}" img="{$iconurl|escape:'html':'UTF-8'}" class="recommendedModulesArea">

    {include file='./modules.tpl'}

</ps-panel>

<script>

    riot.compile(function() {
        // here tags are compiled and riot.mount works synchronously
        var tags = riot.mount('*')
    })

</script>

