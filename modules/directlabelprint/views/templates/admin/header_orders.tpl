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
    var orderToken="{$token|escape:'html':'UTF-8'}";
    var addProductLabelsToPrint={$addProductLabelsToPrint|escape:'html':'UTF-8'};
    var label_url = '{$url|escape:'htmlall':'UTF-8'}';
    var shop_root = '{$shop_root|escape:'htmlall':'UTF-8'}';

    var dlpa_generic_label_width={$generic_label_width|escape:'html':'UTF-8'};
    var dlpa_generic_label_height={$generic_label_height|escape:'html':'UTF-8'};
    var dlpa_generic_label_rotate={$generic_label_rotate|escape:'html':'UTF-8'};
    var dlpa_generic_label_content='{$generic_label_content|escape:'quotes':'UTF-8'}';
    var printer_type_set={$printertypeset|escape:'html':'UTF-8'};

    var changeorderstatus = {$changeorderstatus|escape:'html':'UTF-8'};
    var dlp_auto_order_status = {$dlp_auto_order_status|escape:'html':'UTF-8'};

    var dymoPrinterIndex_dlpa={$dymoPrinterIndex|escape:'html':'UTF-8'};
    var selectedDymoIndex_dlpa={$selectedDymoIndex|escape:'html':'UTF-8'};//SDI

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

</script>