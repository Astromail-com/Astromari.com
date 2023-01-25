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

<div id="copyemails">
    <div class="panel">
        <form method="post">
            <legend>
                {l s='Receive copies of the emails' mod='lgdropshipping'}&nbsp;
                <a href="../modules/lgdropshipping/readme/readme_{$lgdropshipping_lang_iso|escape:'htmlall':'UTF-8'}.pdf#page=4" target="_blank">
                    <img src="../modules/lgdropshipping/views/img/info.png">
                </a>
            </legend>
            <label for="emailcp">{l s='Your email address:' mod='lgdropshipping'}</label>
            <span class="lginput">
                <input type="text" name="emailcp" value="{$lgdropshipping_email|escape:'htmlall':'UTF-8'}"
                       class="lginput">
                </span>
            <br><br>
            <button class="button btn btn-default" type="submit" name="updateEmail">
                <i class="process-icon-save"></i>{l s='Save' mod='lgdropshipping'}
            </button>
        </form>
    </div>
</div>
