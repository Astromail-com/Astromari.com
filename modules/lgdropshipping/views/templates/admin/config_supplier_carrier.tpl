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

<div id="selectioncarriers">
    <fieldset>
        <form method="post">
            <legend>
                {l s='Selection of carriers' mod='lgdropshipping'}&nbsp;
                <a href="../modules/lgdropshipping/readme/readme_{$lgdropshipping_lang_iso|escape:'htmlall':'UTF-8'}.pdf#page=8" target="_blank">
                    <img src="../modules/lgdropshipping/views/img/info.png">
                </a>
            </legend>
            <br>
            <h3>
                <span class="lgfloat">
                    <label>&nbsp;&nbsp;{l s='Use the carrier selected by customers' mod='lgdropshipping'}</label>
                </span>
                <span class="switch prestashop-switch fixed-width-lg lgfloat lgmarginl">
                    <input type="radio" name="lgdropshipping_association" id="lgdropshipping_association_on" value="1"
                    {if $lgdropshipping_association}checked="checked"{/if} />
                    <label for="lgdropshipping_association_on" class="lgradio">{l s='Yes' mod='lgdropshipping'}</label>
                    <input type="radio" name="lgdropshipping_association" id="lgdropshipping_association_off" value="0"
                    {if !$lgdropshipping_association}checked="checked"{/if} />
                    <label for="lgdropshipping_association_off" class="lgradio">{l s='No' mod='lgdropshipping'}</label>
                    <a class="slide-button btn"></a>
                </span>
            </h3>
            <div class="lgclear"></div>
            <div class="lginstructions">
                {l s='If you choose "No", the module will send the email to the carrier selected below.' mod='lgdropshipping'}
                {l s='for each supplier (carrier assigned to each supplier).' mod='lgdropshipping'}
                <br>
                {l s='If you choose "Yes", the module will send the email to the carrier selected' mod='lgdropshipping'}
                {l s='by customers during the order process (carrier assigned to the order).' mod='lgdropshipping'}
            </div>
            <br>
            <table id="carriersupplier">
                <tr>
                    <th width="20%">
                            <span class="lgbold lgname">
                                {l s='Suppliers' mod='lgdropshipping'}
                            </span>
                    </th>
                    <th width="15%"></th>
                    <th width="20%">
                            <span class="lgbold lgname">
                                {l s='Carriers' mod='lgdropshipping'}
                            </span>
                    </th>
                </tr>
                {foreach $suppliers as $supplier}
                <tr>
                    <td>{$supplier['name']|escape:'htmlall':'UTF-8'}</td>
                    <td><span class="lglarge">&harr;</span></td>
                    <td>
                        <select name="carriersupplier{$supplier['supplierid']|escape:'htmlall':'UTF-8'}">
                            <option value="0">--</option>';
                            {foreach $carriers as $carrier}
                            <option value="{$carrier['carrierid']|escape:'htmlall':'UTF-8'}"
                            {if $carrier['carrierid'] == $supplier['carrierid']}
                                 selected
                            {/if}
                            >{$carrier['name']|escape:'htmlall':'UTF-8'}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                {/foreach}
            </table><br>
            <button class="button btn btn-default" type="submit" name="updateCarrierSupplier" >
                <i class="process-icon-save"></i>{l s='Save' mod='lgdropshipping'}
            </button>
            <span id="lgdropshipping5"></span>
        </form>
    </fieldset>
</div>
