/**
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
 */

function tinySetup(config)
{
    if(!config)
        config = {};

    if (typeof config['editor_selector'] != 'undefined')
        config['selector'] = '.'+config['editor_selector'];

    default_config = {
        selector: ".rte" ,
        plugins : "colorpicker link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor",
        toolbar1 : "code,|,bold,italic,underline,strikethrough,|,alignleft,aligncenter,alignright,alignfull,formatselect,|,blockquote,colorpicker,pasteword,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,cleanup,|,media,image",
        toolbar2: "",
        external_filemanager_path: ad+"/filemanager/",
        filemanager_title: "File manager" ,
        external_plugins: { "filemanager" : ad+"/filemanager/plugin.min.js"},
        language: iso,
        skin: "prestashop",
        statusbar: false,
        relative_urls : false,
        convert_urls: false,
        extended_valid_elements : "em[class|name|id]",
        menu: {
            edit: {title: 'Edit', items: 'undo redo | cut copy paste | selectall'},
            insert: {title: 'Insert', items: 'media image link | pagebreak'},
            view: {title: 'View', items: 'visualaid'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            tools: {title: 'Tools', items: 'code'}
        }

    }

    $.each(default_config, function(index, el)
    {
        if (config[index] === undefined )
            config[index] = el;
    });

    tinyMCE.init(config);

};