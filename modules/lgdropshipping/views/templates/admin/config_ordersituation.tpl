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

<div id="sendemails">
    <fieldset>
        <form method="post">
            <legend>
                {l s='Send dropshipping emails' mod='lgdropshipping'}&nbsp;
                <a href="../modules/lgdropshipping/readme/readme_{$lgdropshipping_lang_iso|escape:'htmlall':'UTF-8'}.pdf#page=5" target="_blank">
                    <img src="../modules/lgdropshipping/views/img/info.png">
                </a>
            </legend>

            <table class="table" width="100%">
                <tr>
                    <td colspan="3">
                        <div class="lginstructions">
                            {l s='To send orders to suppliers and carriers, you must go to the menu "Orders >' mod='lgdropshipping'}
                            {l s='Orders", change the order status and choose the same status as below.' mod='lgdropshipping'}
                            {l s='When the order status changes and is the same as below, the module will' mod='lgdropshipping'}
                            {l s='automatically send the emails to the corresponding suppliers and carriers.' mod='lgdropshipping'}
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>{l s='Send supplier emails when the order status changes to:' mod='lgdropshipping'}</th>
                    <th></th>
                    <th>{l s='Send carrier emails when the order status changes to:' mod='lgdropshipping'}</th>
                </tr>
                <tr>
                    <td>
                        <table class="table" id="supplier_Status">
                            {foreach $order_states as $order_state}
                            <tr>
                                <td>
                                    <input type="checkbox" name="supplierState{$order_state['id_order_state']|escape:'htmlall':'UTF-8'}" value="1"
                                    {if $order_state['supplier_selected']}
                                        checked="checked"
                                    {/if}
                                    >
                                </td>
                                <td>
                                    <span style="background-color:{$order_state['color']|escape:'htmlall':'UTF-8'};" class="lgstate">
                                        {$order_state['name']|escape:'htmlall':'UTF-8'}
                                    </span>
                                </td>
                            </tr>
                            {/foreach}
                        </table>
                    </td>
                    <td>
                    </td>
                    <td>
                        <table class="table" name="order_state_supplier">
                            {foreach $order_states as $order_state}
                            <tr>
                                <td>
                                    <input type="checkbox" name="carrierState{$order_state['id_order_state']|escape:'htmlall':'UTF-8'}"
                                           value="1"
                                    {if $order_state['carrier_selected']}
                                        checked="checked"
                                    {/if}
                                    >
                                </td>
                                <td>
                                        <span style="background-color:{$order_state['color']|escape:'htmlall':'UTF-8'};" class="lgstate">
                                            {$order_state['name']|escape:'htmlall':'UTF-8'}
                                        </span>
                                </td>
                            </tr>
                            {/foreach}
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            <button class="button btn btn-default" type="submit" name="updateOrderState" >
                <i class="process-icon-save"></i>{l s='Save' mod='lgdropshipping'}
            </button>
        </form>
    </fieldset>
</div>
