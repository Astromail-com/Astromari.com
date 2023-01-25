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

{if !empty($productos)}
    {foreach item=producto from=$productos}
        <tr id="{$producto.info.id_product|intval}">
            <td>
                <input type="checkbox" name="selected_products[]" value="{$producto.info.id_product|intval}">
            </td>
            <td>
                <span id="id{$producto.info.id_product|intval}">{$producto.info.id_product|intval}</span>
            </td>
            <td>{if isset($producto.imagen)}<img src="{$producto.imagen|escape:'htmlall':'UTF-8'}">{else}IMAGEN NO EXISTE:{/if}</td>
            <td>
                <span id="name{$producto.info.id_product|intval}">{$producto.nombre|escape:'htmlall':'UTF-8'}</span>
            </td>
            <td>
                <span id="reference{$producto.info.id_product|intval}">{$producto.info.reference|escape:'htmlall':'UTF-8'}</span>
            </td>
            <td>
            <span id="name'.$producto['id_product'].'">
                <input
                        type="hidden"
                        name="manufacturer{$producto.info.id_product|intval}"
                        id="manufacturer{$producto.info.id_product|intval}"
                        value="{$producto.producto.id_manufacturer|escape:'htmlall':'UTF-8'}">
                {$producto.producto.manufacturer|escape:'htmlall':'UTF-8'}
            </span>
            </td>
            <td>
            <span id="date{$producto.info.id_product|intval}">
                {$producto.producto.fecha|escape:'htmlall':'UTF-8'}
            </span>
            </td>
            <td>
            <span id="price{$producto.info.id_product|intval}">
                {$producto.producto.precio|escape:'htmlall':'UTF-8'}
            </span>
            </td>
            <td>
                <span id="stock{$producto.info.id_product|intval}">
                {$producto.quantity|escape:'htmlall':'UTF-8'}
                </span>
            </td>
            <td>
                <input
                        type="hidden"
                        name="status{$producto.info.id_product|intval}"
                        id="status{$producto.info.id_product|intval}}" '
                value="{$producto.prodActive|intval}">
                <img src="{$producto.imgProdActive|escape:'htmlall':'UTF-8'}">
            </td>
            <td>
                <input
                        type="hidden"
                        type="text"
                        name="prod{$producto.info.id_product|intval}"
                        value="{$producto.position|intval}">
                {$producto.position|intval}
            </td>
        </tr>
    {/foreach}
{/if}
