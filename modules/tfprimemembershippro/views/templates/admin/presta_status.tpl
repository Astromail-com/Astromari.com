{**
* 2008-2022 Prestaworld
*
* NOTICE OF LICENSE
*
* The source code of this module is under a commercial license.
* Each license is unique and can be installed and used on only one website.
* Any reproduction or representation total or partial of the module, one or more of its components,
* by any means whatsoever, without express permission from us is prohibited.
*
* DISCLAIMER
*
* Do not alter or add/update to this file if you wish to upgrade this module to newer
* versions in the future.
*
* @author    prestaworld
* @copyright 2008-2022 Prestaworld
* @license https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
* International Registered Trademark & Property of prestaworld
*}

<a
    class="list-action-enable {if $status == 1}action-enabled{else}action-disabled{/if}"
    href="{$presta_current_url|escape:'html':'UTF-8'}"
    title="{if $status == 1}{l s='Enabled' mod='tfprimemembershippro'}{else}{l s='Disabled' mod='tfprimemembershippro'}{/if}">
    {if $status == 1}<i class="icon-check"></i>{else}<i class="icon-remove"></i>{/if}
</a>
