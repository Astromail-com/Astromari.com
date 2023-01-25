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

<div id="configcarriers">
    <fieldset>
        <form method="post">
            <legend>
                {l s='Configuration of carriers' mod='lgdropshipping'}&nbsp;
                <a href="../modules/lgdropshipping/readme/readme_{$lgdropshipping_lang_iso|escape:'htmlall':'UTF-8'}.pdf#page=9" target="_blank">
                    <img src="../modules/lgdropshipping/views/img/info.png">
                </a>
            </legend>
            <table class="table lgtable" width="100%">
                {foreach $carriers as $carrier}
                <tr>
                    <td rowspan="5" width="2%">
                        <span class="lgbold lgid">{$carrier['carrierid']|escape:'htmlall':'UTF-8'}</span>
                    </td>
                    <td rowspan="5" width="10%">
                        <span class="lgbold lgname">
                            {$carrier['name']|escape:'htmlall':'UTF-8'}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td width="33%">
                        <span class="lgbold">{l s='Variable {CARRIER_NAME}:' mod='lgdropshipping'}</span>&nbsp;
                        <input type="text" name="ccontact{$carrier['carrierid']|escape:'htmlall':'UTF-8'}"
                               value="{$carrier['contact_carrier']|escape:'htmlall':'UTF-8'}" class="lgemail">
                    </td>
                    <td width="55%">
                        <span class="lgbold">{l s='Email subject' mod='lgdropshipping'} : </span>
                        <input type="text" name="carrier_subject{$carrier['carrierid']|escape:'htmlall':'UTF-8'}" class="lgsubject"
                               value="{$carrier['subject']|escape:'htmlall':'UTF-8'}">
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="lgbold">{l s='Email 1 (required)' mod='lgdropshipping'} : </span>&nbsp;
                        <input type="text" name="cemail{$carrier['carrierid']|escape:'htmlall':'UTF-8'}" value="{$carrier['email_carrier']|escape:'htmlall':'UTF-8'}"
                               class="lginput">
                    </td>
                    <td rowspan="2"><span class="lgbold">{l s='Email content' mod='lgdropshipping'} : </span>
                        <textarea name="carrier_template{$carrier['carrierid']|escape:'htmlall':'UTF-8'}" class="rte autoload_rte lgtext">
                            {html_entity_decode(strip_tags($carrier['template'])|escape:'htmlall':'UTF-8')}
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="lgbold">{l s='Email 2 (optional)' mod='lgdropshipping'} : </span>
                        <input type="text" name="cemailb{$carrier['carrierid']|escape:'htmlall':'UTF-8'}"
                               value="{$carrier['email_carrier2']|escape:'htmlall':'UTF-8'}" class="lgemail">
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="lgbold">{l s='Attachments' mod='lgdropshipping'} : </span>
                        <input type="checkbox" id="invoice_carrier" name="invoice{$carrier['carrierid']|escape:'htmlall':'UTF-8'}" value="1"
                        {if $carrier['invoice']|escape:'htmlall':'UTF-8'}
                            checked="checked"
                        {/if}
                        &nbsp;
                        <img src="../modules/lgdropshipping/views/img/icon3.png" width="15px" alt="invoice"/>
                        &nbsp;
                        <b>{l s='Invoice' mod='lgdropshipping'}</b>
                        <input type="checkbox" id="albaran_carrier" name="delivery_slip{$carrier['carrierid']|escape:'htmlall':'UTF-8'}"
                               value="1"
                        {if $carrier['slip']}
                            checked="checked"
                        {/if}
                        >&nbsp;
                        <img src="../modules/lgdropshipping/views/img/icon2.png" width="15px" alt="delivery slip"/>
                        <b>{l s='Delivery slip' mod='lgdropshipping'}</b>
                    </td>
                    <td>
                        <table class="table lgvariables">
                            <tr>
                                <th>{l s='Available variables' mod='lgdropshipping'} :</th>
                                <th>
                                    <span class="toolTip"><a href="#variableInfo">{ldelim}CARRIER_NAME{rdelim}</a>
                                        <p class="tooltipDesc">{l s='Carrier contact name' mod='lgdropshipping'}<br>
                                        ({l s='can be used in the email title' mod='lgdropshipping'})</p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip"><a href="#variableInfo">{ldelim}CUSTOMER_ADDRESS{rdelim}</a>
                                        <p class="tooltipDesc">
                                        {l s='Delivery address' mod='lgdropshipping'}&nbsp;
                                        {l s='(name, street, zip code, city, region, country)' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}CUSTOMER_EMAIL{rdelim}</a>
                                        <p class="tooltipDesc">
                                            {l s='Customer email address' mod='lgdropshipping'}
                                        </p>
                                    </span>
                                </th>
                                <th>
                                    <span class="toolTip">
                                        <a href="#variableInfo">{ldelim}CUSTOMER_NAME{rdelim}</a>
                                        <p class="tooltipDesc">{l s='Customer name' mod='lgdropshipping'}<br>
                                            ({l s='can be used in the email title' mod='lgdropshipping'})
                                        </p>
                                    </span>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <span class="toolTip"><a href="#variableInfo">{ldelim}CUSTOMER_PHONE{rdelim}</a>
                                        <p class="tooltipDesc">{l s='Customer phone number(s)' mod='lgdropshipping'}</p>
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
                                    <span class="toolTip"><a href="#variableInfo">{ldelim}ORDER_DATE{rdelim} </a>
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
                                            ({l s='can be used in the email title' mod='lgdropshipping'})
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
                        <button class="button btn btn-default" type="submit" name="updateCarrier" >
                            <i class="process-icon-save"></i>{l s='Save' mod='lgdropshipping'}
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
