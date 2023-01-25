<?php
/**
 * Creative Elements - live PageBuilder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

namespace CE;

defined('_PS_VERSION_') or die;

include_once dirname(__FILE__) . '/product-price.php';

class WidgetProductMiniaturePrice extends WidgetProductPrice
{
    /**
     * Get widget name.
     *
     * @since 2.5.9
     * @access public
     *
     * @return string Widget name.
     */
    public function getName()
    {
        return 'product-miniature-price';
    }

    /**
     * Render product price widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 2.5.9
     * @access protected
     * @codingStandardsIgnoreStart Generic.Files.LineLength
     */
    protected function render()
    {
        $context = \Context::getContext();
        $product = &$context->smarty->tpl_vars['product']->value;

        if (!$product['show_price']) {
            return;
        }
        $currency = &$context->smarty->tpl_vars['currency']->value;

        $settings = $this->getSettingsForDisplay();
        $t = $context->getTranslator();
        ?>
        <div class="ce-product-prices">
        <?php if ($settings['regular'] && $product['has_discount']) : ?>
            <?= \Hook::exec('displayProductPriceBlock', ['product' => $product, 'type' => 'old_price']) ?>
            <div class="ce-product-price-regular"><?= $product['regular_price'] ?></div>
        <?php endif ?>
            <?= \Hook::exec('displayProductPriceBlock', ['product' => $product, 'type' => 'before_price']) ?>
            <div class="ce-product-price <?= $product['has_discount'] ? 'ce-has-discount' : '' ?>" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <meta itemprop="priceCurrency" content="<?= $currency['iso_code'] ?>">
                <span itemprop="price" content="<?= esc_attr(isset($product['rounded_display_price']) ? $product['rounded_display_price'] : $product['price_amount']) ?>">
                    <?= $product['price'] ?>
                </span>
        <?php if ($settings['discount'] && $product['has_discount']) : ?>
            <?php if ('percentage' === $product['discount_type']) : ?>
                <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-percentage">
                    <?= $t->trans('Save %percentage%', ['%percentage%' => $product['discount_percentage_absolute']], 'Shop.Theme.Catalog') ?>
                </span>
            <?php else : ?>
                <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-amount">
                    <?= $t->trans('Save %amount%', ['%amount%' => $product['discount_to_display']], 'Shop.Theme.Catalog') ?>
                </span>
            <?php endif ?>
        <?php endif ?>
            </div>
            <?= \Hook::exec('displayProductPriceBlock', ['product' => $product, 'type' => 'unit_price']) ?>
            <?= \Hook::exec('displayProductPriceBlock', ['product' => $product, 'type' => 'weight']) ?>
        </div>
        <?php
    }

    protected function renderSmarty()
    {
        $settings = $this->getSettingsForDisplay();
        ?>
        {if $product['show_price']}
            <div class="ce-product-prices">
        <?php if ($settings['regular']) : ?>
            {if $product['has_discount']}
                {hook h='displayProductPriceBlock' product=$product type='old_price'}
                <div class="ce-product-price-regular">{$product['regular_price']}</div>
            {/if}
        <?php endif ?>
                {hook h='displayProductPriceBlock' product=$product type='before_price'}
                <div class="ce-product-price{if $product['has_discount']} ce-has-discount{/if}" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                    <meta itemprop="priceCurrency" content="{$currency['iso_code']}">
                    <span itemprop="price" content="{if $product['rounded_display_price']}{$product['rounded_display_price']}{else}{$product['price_amount']}{/if}">
                        {$product['price']}
                    </span>
        <?php if ($settings['discount']) : ?>
            {if $product['has_discount']}
                {if 'percentage' === $product['discount_type']}
                    <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-percentage">
                        {l s='Save %percentage%' sprintf=['%percentage%' => $product['discount_percentage_absolute']] d='Shop.Theme.Catalog'}
                    </span>
                {else}
                    <span class="ce-product-badge ce-product-badge-sale ce-product-badge-sale-amount">
                        {l s='Save %amount%' sprintf=['%amount%' => $product['discount_to_display']] d='Shop.Theme.Catalog'}
                    </span>
                {/if}
            {/if}
        <?php endif ?>
                </div>
                {hook h='displayProductPriceBlock' product=$product type='unit_price'}
                {hook h='displayProductPriceBlock' product=$product type='weight'}
            </div>
        {/if}
        <?php
    }
}
