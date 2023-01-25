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

<div id="configsuppliers">
    <fieldset>
        <form method="post">
            <legend>
                {l s='Configuration of suppliers' mod='lgdropshipping'}&nbsp;
                <a href="../modules/lgdropshipping/readme/readme_{$lgdropshipping_lang_iso|escape:'htmlall':'UTF-8'}.pdf#page=6" target="_blank">
                    <img src="../modules/lgdropshipping/views/img/info.png">
                </a>
            </legend>
            <table class="table lgtable" width="100%">
                {foreach $suppliers as $supplier}
                <tr>
                    <td rowspan="5" width="2%">
                        <span class="lgbold lgid">
                            {$supplier['supplierid']|escape:'htmlall':'UTF-8'}
                        </span>
                    </td>
                <td rowspan="5" width="10%">
                        <span class="lgbold lgname">
                            {$supplier['name']|escape:'htmlall':'UTF-8'}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td width="33%">
                        <span class="lgbold">{l s='Variable {SUPPLIER_NAME}:' mod='lgdropshipping'}</span>&nbsp;
                        <input type="text" name="scontact{$supplier['supplierid']|escape:'htmlall':'UTF-8'}"
                               value="{$supplier['contact_supplier']|escape:'htmlall':'UTF-8'}" class="lginput">
                    </td>
                    <td width="55%">
                        <span class="lgbold">{l s='Email subject' mod='lgdropshipping'} : </span>
                        <input type="text" name="supplier_subject{$supplier['supplierid']|escape:'htmlall':'UTF-8'}" class="lgsubject"
                               value="{$supplier['subject']|escape:'htmlall':'UTF-8'}">
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="lgbold">{l s='Email 1 (required)' mod='lgdropshipping'}' : </span>&nbsp;
                        <input type="text" name="semail{$supplier['supplierid']|escape:'htmlall':'UTF-8'}"
                               value="{$supplier['email_supplier']|escape:'htmlall':'UTF-8'}" class="lginput">
                    </td>
                    <td rowspan="2">
                        <span class="lgbold">{l s='Email content' mod='lgdropshipping'} : </span>
                        <textarea name="supplier_template{$supplier['supplierid']|escape:'htmlall':'UTF-8'}" class="rte autoload_rte lgtext">
                            {html_entity_decode(strip_tags($supplier['template'])|escape:'htmlall':'UTF-8')}
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="lgbold">{l s='Email 2 (optional)' mod='lgdropshipping'}' : </span>
                        <input type="text" name="semailb{$supplier['supplierid']|escape:'htmlall':'UTF-8'}"
                               value="{$supplier['email_supplier2']|escape:'htmlall':'UTF-8'}" class="lginput">
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="lgbold">{l s='Attachments' mod='lgdropshipping'} : </span>
                        <input type="checkbox" id="invoice_supplier" name="invoice{$supplier['supplierid']|escape:'htmlall':'UTF-8'}"
                               value="1"
                        {if $supplier['invoice']}
                            checked="checked"
                        {/if}
                        >&nbsp;
                        <img src="../modules/lgdropshipping/views/img/icon3.png" width="15px" alt="invoice"/>
                        &nbsp;<b>{l s='Invoice' mod='lgdropshipping'}</b>
                        <input type="checkbox" id="albaran_supplier" name="delivery_slip{$supplier['supplierid']|escape:'htmlall':'UTF-8'}"
                               value="1"
                        {if $supplier['slip']}
                            checked="checked"
                        {/if}
                        >&nbsp;
                        <img src="../modules/lgdropshipping/views/img/icon2.png" width="15px" alt="delivery slip"/>
                        &nbsp;<b>{l s='Delivery slip' mod='lgdropshipping'}</b>
                    </td>
                    <td>
                        <table class="table lgvariables">
                            <tr>
                                <th>
                                    {l s='Available variables' mod='lgdropshipping'} :
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}CARRIER_NAME{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Carrier contact name' mod='lgdropshipping'}<br>
                                            ({l s='can be used in the email title' mod='lgdropshipping'})
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}CUSTOMER_ADDRESS{rdelim}</a>
                                        <p class="tooltipDesc">
                                        {l s='Delivery address' mod='lgdropshipping'}&nbsp;
                                        {l s='(name, street, zip code, city, region, country)' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}CUSTOMER_EMAIL{rdelim}</a>
                                        <p class="tooltipDesc">{l s='Customer email address' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}CUSTOMER_NAME{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Customer name' mod='lgdropshipping'}<br>
                                            ({l s='can be used in the email title' mod='lgdropshipping'})
                                        </p>
                                    </span>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}CUSTOMER_PHONE{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Customer phone number(s)' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}INVOICE_NUMBER{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Invoice number' mod='lgdropshipping'}<br>
                                            ({l s='can be used in the email title' mod='lgdropshipping'})
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}ORDER_DATE{rdelim} </a>
                                        <p class="tooltipDesc">
                                            {l s='Order date' mod='lgdropshipping'}<br>
                                            ({l s='can be used in the email title' mod='lgdropshipping'})
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}ORDER_ID{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Order ID' mod='lgdropshipping'}<br>
                                            ({l s='can be used in the email title' mod='lgdropshipping'})
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}ORDER_INFO{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Note written by the customer during the order process' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}ORDER_REF{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Order reference' mod='lgdropshipping'}<br>
                                            ({l s='can be used in the email title' mod='lgdropshipping'})
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}PRODUCTS{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Products (quantity, name, attributes, reference, link)' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}SUPPLIER_ADDRESS{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Supplier address' mod='lgdropshipping'}&nbsp;
                                            {l s='(name, street, zip code, city, region, country)' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}SUPPLIER_NAME{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Supplier contact name' mod='lgdropshipping'}<br>
                                            {l s='can be used in the email title' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}SUPPLIER_PHONE{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Supplier phone number(s)' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                                <th></th>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="lgbottom"></td>
                </tr>
                {/foreach}
                <tr>
                    <td colspan="4">
                        <br>
                        <button class="button btn btn-default" type="submit" name="updateSupplier">
                            <i class="process-icon-save"></i>{l s='Save' mod='lgdropshipping'}
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
