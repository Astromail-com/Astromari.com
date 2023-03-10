{*
* 2007-2023 ETS-Soft
*
* NOTICE OF LICENSE
*
* This file is not open source! Each license that you purchased is only available for 1 website only.
* If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
* You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
* 
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2023 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
<script type="text/javascript">
        var ybc_blog_invalid_file="{l s='Invalid file' mod='ybc_blog'}";
</script>
<h1 class="page-heading">{l s='My blog comments' mod='ybc_blog'}</h1>
<div id="content-wrapper">
    <section id="content">
        <div class="ybc_blog_layout_{$blog_layout|escape:'html':'UTF-8'} ybc-blog-wrapper-form-managament">
            {if isset($errors_html) && $errors_html}
                {$errors_html nofilter}
            {else}
                {hook h='displayRightFormComments'}
            {/if}
            {hook h='displayFooterYourAccount'}
        </div>
        
    </section>
    
</div>