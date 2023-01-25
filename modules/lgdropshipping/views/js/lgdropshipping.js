/**
 * Copyright 2022 LÍNEA GRÁFICA E.C.E S.L.
 *
 * @author    Línea Gráfica E.C.E. S.L.
 * @copyright Lineagrafica.es - Línea Gráfica E.C.E. S.L. all rights reserved.
 * @license   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$(document).ready(function(){
    $("#sendemails").show(); $("#configsuppliers").hide(); $("#selectioncarriers").hide();
    $("#configcarriers").hide(); $("#copyemails").hide();
    $("#buttonsendemails").removeClass("btn-default").addClass("btn-primary");
    $("#buttonconfigsuppliers").removeClass("btn-primary").addClass("btn-default");
    $("#buttonselectioncarriers").removeClass("btn-primary").addClass("btn-default");
    $("#buttonconfigcarriers").removeClass("btn-primary").addClass("btn-default");
    $("#buttoncopyemails").removeClass("btn-primary").addClass("btn-default");
    $("#buttonsendemails").click(function(){
        $("#sendemails").show(); $("#configsuppliers").hide(); $("#selectioncarriers").hide();
        $("#configcarriers").hide(); $("#copyemails").hide();
        $("#buttonsendemails").removeClass("btn-default").addClass("btn-primary");
        $("#buttonconfigsuppliers").removeClass("btn-primary").addClass("btn-default");
        $("#buttonselectioncarriers").removeClass("btn-primary").addClass("btn-default");
        $("#buttonconfigcarriers").removeClass("btn-primary").addClass("btn-default");
        $("#buttoncopyemails").removeClass("btn-primary").addClass("btn-default");
    });
    $("#buttonconfigsuppliers").click(function(){
        $("#sendemails").hide(); $("#configsuppliers").show(); $("#selectioncarriers").hide();
        $("#configcarriers").hide(); $("#copyemails").hide();
        $("#buttonsendemails").removeClass("btn-primary").addClass("btn-default");
        $("#buttonconfigsuppliers").removeClass("btn-default").addClass("btn-primary");
        $("#buttonselectioncarriers").removeClass("btn-primary").addClass("btn-default");
        $("#buttonconfigcarriers").removeClass("btn-primary").addClass("btn-default");
        $("#buttoncopyemails").removeClass("btn-primary").addClass("btn-default");
    });
    $("#buttonselectioncarriers").click(function(){
        $("#sendemails").hide(); $("#configsuppliers").hide(); $("#selectioncarriers").show();
        $("#configcarriers").hide(); $("#copyemails").hide();
        $("#buttonsendemails").removeClass("btn-primary").addClass("btn-default");
        $("#buttonconfigsuppliers").removeClass("btn-primary").addClass("btn-default");
        $("#buttonselectioncarriers").removeClass("btn-default").addClass("btn-primary");
        $("#buttonconfigcarriers").removeClass("btn-primary").addClass("btn-default");
        $("#buttoncopyemails").removeClass("btn-primary").addClass("btn-default");
    });
    $("#buttonconfigcarriers").click(function(){
        $("#sendemails").hide(); $("#configsuppliers").hide(); $("#selectioncarriers").hide();
        $("#configcarriers").show(); $("#copyemails").hide();
        $("#buttonsendemails").removeClass("btn-primary").addClass("btn-default");
        $("#buttonconfigsuppliers").removeClass("btn-primary").addClass("btn-default");
        $("#buttonselectioncarriers").removeClass("btn-primary").addClass("btn-default");
        $("#buttonconfigcarriers").removeClass("btn-default").addClass("btn-primary");
        $("#buttoncopyemails").removeClass("btn-primary").addClass("btn-default");
    });
    $("#buttoncopyemails").click(function(){
        $("#sendemails").hide(); $("#configsuppliers").hide(); $("#selectioncarriers").hide();
        $("#configcarriers").hide(); $("#copyemails").show();
        $("#buttonsendemails").removeClass("btn-primary").addClass("btn-default");
        $("#buttonconfigsuppliers").removeClass("btn-primary").addClass("btn-default");
        $("#buttonselectioncarriers").removeClass("btn-primary").addClass("btn-default");
        $("#buttonconfigcarriers").removeClass("btn-primary").addClass("btn-default");
        $("#buttoncopyemails").removeClass("btn-default").addClass("btn-primary");
    });
    if($("#lgdropshipping_association_on").prop("checked") == true) {
        $("#carriersupplier").hide();
    }
    if($("#lgdropshipping_association_off").prop("checked") == true) {
        $("#carriersupplier").show();
    }
    $("#lgdropshipping_association_on").click(function(){
        $("#carriersupplier").hide();
    });
    $("#lgdropshipping_association_off").click(function(){
        $("#carriersupplier").show();
    });
});
