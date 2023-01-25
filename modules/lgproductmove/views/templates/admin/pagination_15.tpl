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

{if !$simple_header}
<div id="lgproductmove_pagination">
    <span style="float: left;">
        <input type="hidden" id="{$list_id|escape:'htmlall':'UTF-8'}-pagination-items-page" name="{$list_id|escape:'htmlall':'UTF-8'}_pagination" value="{$selected_pagination|intval}" />
        <input type="hidden" id="{$list_id|escape:'htmlall':'UTF-8'}-pagination-page" name="{$list_id|escape:'htmlall':'UTF-8'}_page" value="{$page|intval}" />
        {if $page > 1}
            <a href="javascript:void(0);" class="pagination-link" data-page="1"><img src="../img/admin/list-prev2.gif"/></a>&nbsp;
            <a href="javascript:void(0);" class="pagination-link" data-page="{$page - 1|intval}"><img src="../img/admin/list-prev.gif"/></a>
        {/if}
        {l s='Page' mod='lgproductmove'}<b>{$page|intval}</b> / {$total_pages|intval}
        {if $page < $total_pages}
            <a href="javascript:void(0);" class="pagination-link" data-page="{$page + 1|intval}"><img src="../img/admin/list-next.gif"/></a>&nbsp;
            <a href="javascript:void(0);" class="pagination-link" data-page="{$total_pages|intval}"><img src="../img/admin/list-next2.gif"/></a>
        {/if}
        | {l s='Display' mod='lgproductmove'}
        <select name="pagination15">
            {* Choose number of results per page *}
            {foreach $pagination AS $value}
                <option value="{$value|intval}"{if $selected_pagination == $value} selected="selected" {elseif $selected_pagination == NULL && $value == $pagination[1]} selected="selected2"{/if}>{$value|intval}</option>
            {/foreach}
        </select>
        / {$list_total|intval} {l s='result(s)' mod='lgproductmove'}
    </span>
    <span class="clear"></span>
</div>
{/if}