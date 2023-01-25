{**
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
 *}

<div id="menubar">
    <fieldset>
        <a id="buttonsendemails" class="button btn btn-default" class="lgbutton">
            <i class="icon-history"></i>&nbsp;{l s='Send dropshipping emails' mod='lgdropshipping'}
        </a>
        <a id="buttonconfigsuppliers" class="button btn btn-default" class="lgbutton">
            <i class="icon-cubes"></i>&nbsp;{l s='Configuration of suppliers' mod='lgdropshipping'}
        </a>
        <a id="buttonselectioncarriers" class="button btn btn-default" class="lgbutton">
            <i class="icon-arrows-h"></i>&nbsp;{l s='Selection of carriers' mod='lgdropshipping'}
        </a>
        <a id="buttonconfigcarriers" class="button btn btn-default" class="lgbutton">
            <i class="icon-truck"></i>&nbsp;{l s='Configuration of carriers' mod='lgdropshipping'}
        </a>
        <a id="buttoncopyemails" class="button btn btn-default" class="lgbutton">
            <i class="icon-envelope"></i>&nbsp;{l s='Receive copies of the emails' mod='lgdropshipping'}
        </a>
    </fieldset>
</div>
{include file="./config_ordersituation.tpl"}
{include file="./config_suppliers.tpl"}
{include file="./config_supplier_carrier.tpl"}
{include file="./config_carriers.tpl"}
{include file="./config_email.tpl"}
