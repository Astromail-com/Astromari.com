{block name='stylesheets'}
    {include file="_partials/stylesheets.tpl" stylesheets=$stylesheets}
{/block}

<div class="printify-connection-failed printify-connection-status">
    <span>{l s="Connection failed" mod="Printify"}</span>
    <br><br>
    {if isset($message) and $message}
        <span class="failed-message">{$message}</span>
    {/if}
</div>

