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

<table class="table_grid" name="list_table" style="padding-top: 15px;">
    <tbody>
    <tr>
        <td>
            {* PAGINACION *}
            {include './pagination_15.tpl'}
        </td>
    </tr>
    <tr>
        <td style="vertical-align: bottom;">
            <table class="table product" id="tableproduct" style="width: 100%; margin-bottom:10px;" cellspacing="0" cellpadding="0">
                <colgroup>
                    <col width="10px">
                    <col width="20px">
                    <col width="70px">
                    <col>
                    <col width="80px">
                    <col width="230px">
                    <col width="90px">
                    <col width="90px">
                    <col width="90px">
                    <col width="70px">
                    <col width="52px">
                </colgroup>
                <thead>
                    <tr class="nodrag nodrop" style="height: 40px">
                        <th><span class="title_box">{l s='SELECTION' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='ID' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='IMAGE' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='NAME' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='REFERENCE' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='MANUFACTURER' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='DATE' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='PRICE' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='QUANTITY' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='STATUS' mod='lgproductmove'}</span></th>
                        <th><span class="title_box">{l s='ORDER' mod='lgproductmove'}</span></th>
                    </tr>
                    <tr class="nodrag nodrop filter row_hover" style="height: 35px;">
                        <th>
                            <input type="checkbox" id="checkall" value="1" name="4"> {l s='All' mod='lgproductmove'}
                        </th>
                        <th>
                            <input type="text" name="filterid" id="filterid" style="width:50px;"{if isset($filters.id)} value="{$filters.id|escape:'htmlall':'UTF-8'}"{/if}>
                        </th>
                        <th>
                            --
                        </th>
                        <th>
                            <input type="text" name="filtername" id="filtername"{if isset($filters.name)} value="{$filters.name|escape:'htmlall':'UTF-8'}"{/if}>
                        </th>
                        <th>
                            <input type="text" name="filterreference" id="filterreference"{if isset($filters.reference)} value="{$filters.reference|escape:'htmlall':'UTF-8'}"{/if} style="width:100px;">
                        </th>
                        <th>
                            <select name="filtermanufacturer" id="filtermanufacturer">
                                <option value="0">{l s='All' mod='lgproductmove'}</option>
                                {foreach item=marca from=$marcas}
                                    <option value="{$marca['id_manufacturer']|intval}"{if isset($filters.manufacturer) && $filters.manufacturer == $marca['id_manufacturer']} selected{/if}>{$marca['name']|escape:'htmlall':'UTF-8'}</option>
                                {/foreach}
                            </select>
                        </th>
                        <th>
                            <input type="text" name="filterdate" id="filterdate"{if isset($filters.date)} value="{$filters.date|escape:'htmlall':'UTF-8'}"{/if} style="width:100px;" class="datepicker">
                        </th>
                        <th><input type="text" name="filterprice" id="filterprice"{if isset($filters.price)} value="{$filters.price|escape:'htmlall':'UTF-8'}"{/if} style="width:70px;"></th>
                        <th><input type="text" name="filterstock" id="filterstock"{if isset($filters.quantity)} value="{$filters.quantity|escape:'htmlall':'UTF-8'}"{/if} style="width:70px;"></th>
                        <th>
                            <select name="filterstatus" id="filterstatus">
                                <option value="2"{if (isset($filters.status) && $filters.status == 2) || !isset($filters.status)} selected{/if}>{l s='All' mod='lgproductmove'}</option>
                                <option value="1"{if isset($filters.status) && $filters.status == 1} selected{/if}>{l s='Enabled' mod='lgproductmove'}</option>
                                <option value="0"{if isset($filters.status) && $filters.status == 0} selected{/if}>{l s='Disabled' mod='lgproductmove'}</option>
                            </select>
                        </th>
                        <th>--</th>
                    </tr>
                </thead>
                <tbody>
                {include './product_rows.tpl'}
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>
    </tbody>
</table>
