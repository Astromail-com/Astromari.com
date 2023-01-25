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

{foreach $products as $product}
    {if !$product@first}
        <br>
    {/if}

    <a href="{$product['image']|escape:'htmlall':'UTF-8'}" target="_blank">
        <img src="{$product['image']|escape:'htmlall':'UTF-8'}" border="1" height="20" width="20">
    </a>&nbsp;{$product['product_quantity']|escape:'htmlall':'UTF-8'}x&nbsp;
    <a href="{$product['link']|escape:'htmlall':'UTF-8'}" target="_blank">{$product['product_name']|escape:'htmlall':'UTF-8'}</a>&nbsp;
    (ref: {$product['product_reference']|escape:'htmlall':'UTF-8'} {$product['supplier_reference']|escape:'htmlall':'UTF-8'})
    {*{displayPrice price=$product['total_price_tax_incl']}*}
    {if !empty($product['customization'])}
        {foreach $product['customization'] as $cus}
            <br>
            {$cus|escape:'htmlall':'UTF-8'}
        {/foreach}
    {/if}
{/foreach}