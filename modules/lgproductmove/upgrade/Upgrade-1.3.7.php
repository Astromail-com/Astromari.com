<?php
/**
 * Copyright 2022 LÍNEA GRÁFICA E.C.E S.L.
 *
 * @author    Línea Gráfica E.C.E. S.L.
 * @copyright Lineagrafica.es - Línea Gráfica E.C.E. S.L. all rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

function upgrade_module_1_3_7($module)
{
    if (version_compare(_PS_VERSION_, '1.6.0', '<')) {
        $filename = __PS_BASE_URI__.'modules'
            .DIRECTORY_SEPARATOR.'lgproductmove'
            .DIRECTORY_SEPARATOR.'AdminLGProductMove.php';
    } else {
        $filename = _PS_MODULE_DIR_ . 'lgproductmove'
            .DIRECTORY_SEPARATOR.'AdminLGProductMove.php';
    }

    if (file_exists($filename)) {
        unlink($filename);
    }
    return $module;
}
