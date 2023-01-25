<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

namespace CE;

defined('_PS_VERSION_') or die;

class WidgetProductMiniatureBox extends WidgetProductBox
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'product-miniature-box';
    }

    public function getTitle()
    {
        return __('Product Box');
    }

    public function getIcon()
    {
        return 'eicon-info-box';
    }

    public function getCategories()
    {
        return ['product-elements'];
    }

    public function getKeywords()
    {
        return ['shop', 'store', 'product', 'box'];
    }

    protected function getSkinOptions()
    {
        return [
            'custom' => __('Custom'),
        ];
    }

    protected function getDefaultProductId()
    {
        return '';
    }

    protected function _registerControls()
    {
        parent::_registerControls();

        $this->updateControl(
            'skin',
            [
                'type' => ControlsManager::HIDDEN,
                'default' => 'custom',
            ]
        );

        $this->updateControl(
            'product_id',
            [
                'type' => ControlsManager::TEXT,
                'placeholder' => __('Current Product'),
                'classes' => 'ce-disabled',
                'separator' => '',
            ]
        );

        $this->removeControl('description_length');
    }

    protected function render()
    {
        $settings = $this->getSettingsForDisplay();
        $product = &$this->context->smarty->tpl_vars['product']->value;

        echo '<div class="elementor-product-box">' . $this->fetchMiniature($settings, $product) . '</div>';
    }

    protected function renderSmarty()
    {
        static $flags = [
            'sale' => 'discount',
            'new' => 'new',
            'pack' => 'pack',
            'out' => 'out_of_stock',
        ];
        $settings = $this->getSettingsForDisplay();

        $image_size = !empty($settings['image_size']) ? $settings['image_size'] : $this->imageSize;
        $image_size_tablet = !empty($settings['image_size_tablet']) &&
            $settings['image_size_tablet'] !== $image_size ? $settings['image_size_tablet'] : '';
        $image_size_mobile = !empty($settings['image_size_mobile']) &&
            $settings['image_size_mobile'] !== $image_size_tablet ? $settings['image_size_mobile'] : '';

        $title_tag = $settings['title_tag'];
        $show_atc = $this->show_prices && !empty($settings['show_atc']);

        $this->setRenderAttribute('cover', [
            'src' => "{\$cover.bySize.$image_size.url}",
            'alt' => '{if !empty($cover.legend)}{$cover.legend}{else}{$product.name}{/if}',
            'width' => "{\$cover.bySize.$image_size.width}",
            'height' => "{\$cover.bySize.$image_size.height}",
        ]);
        empty($settings['show_second_image']) or $this->setRenderAttribute('image', [
            'src' => "{\$image.bySize.$image_size.url}",
            'alt' => '{$image.legend}',
            'width' => "{\$image.bySize.$image_size.width}",
            'height' => "{\$image.bySize.$image_size.height}",
        ]);
        ?>
        {if empty($urls.no_picture_image)}
            {$urls.no_picture_image = call_user_func('CE\Helper::getNoImage')}
        {/if}
        {$cover = _q_c_($product.cover, $product.cover, $urls.no_picture_image)}
        <div class="elementor-product-box elementor-product-miniature">
            <a class="elementor-product-link" href="{$product.url}">
                <div class="elementor-image">
                    <picture class="elementor-cover-image">
                    <?php if ($image_size_mobile) : ?>
                        <source media="(max-width: 767px)" srcset="{$cover.bySize.<?= $image_size_mobile ?>.url}">
                    <?php endif ?>
                    <?php if ($image_size_tablet) : ?>
                        <source media="(max-width: 991px)" srcset="{$cover.bySize.<?= $image_size_tablet ?>.url}">
                    <?php endif ?>
                        <img <?= $this->getRenderAttributeString('cover') ?> loading="lazy">
                    </picture>
            <?php if (!empty($settings['show_second_image'])) : ?>
                {$index = _q_c_(!empty($cover.position) && 1 < $cover.position, 0, 1)}
                {if !empty($product.images[$index])}
                    {$image = $product.images[$index]}
                    <picture class="elementor-second-image">
                    <?php if ($image_size_mobile) : ?>
                        <source media="(max-width: 767px)" srcset="{$image.bySize.<?= $image_size_mobile ?>.url}">
                    <?php endif ?>
                    <?php if ($image_size_tablet) : ?>
                        <source media="(max-width: 991px)" srcset="{$image.bySize.<?= $image_size_tablet ?>.url}">
                    <?php endif ?>
                        <img <?= $this->getRenderAttributeString('image') ?> loading="lazy">
                    </picture>
                {/if}
            <?php endif ?>
                <?php if (!empty($settings['show_qv'])) : ?>
                    <div class="elementor-button elementor-quick-view" data-link-action="quickview">
                        <span class="elementor-button-content-wrapper">
                        <?php if ($settings['qv_icon']) : ?>
                            <?php $qv_icon_align = "elementor-align-icon-{$settings['qv_icon_align']}" ?>
                            <span class="elementor-button-icon <?= esc_attr($qv_icon_align) ?>">
                                <i class="<?= esc_attr($settings['qv_icon']) ?>"></i>
                            </span>
                        <?php endif ?>
                            <span class="elementor-button-text"><?= $settings['qv_text'] ?></span>
                        </span>
                    </div>
                <?php endif ?>
                </div>
            <?php foreach (['left', 'right'] as $position) : ?>
                <div class="elementor-badges-<?= $position ?>">
                <?php foreach ($settings['show_badges'] as $badge) : ?>
                    <?php if ($position === $settings["badge_{$badge}_position"]) : ?>
                        {if !empty($product.flags.<?= $flags[$badge] ?>)}
                            <div class="elementor-badge elementor-badge-<?= $badge ?>">
                                <?= $settings["badge_{$badge}_text"] ?: "{\$product.flags.$flags[$badge].label}" ?>
                            </div>
                        {/if}
                    <?php endif ?>
                <?php endforeach ?>
                </div>
            <?php endforeach ?>
                <div class="elementor-content">
                <?php if (!empty($settings['show_category'])) : ?>
                    <h4 class="elementor-category">{$product.category_name}</h4>
                <?php endif ?>
                    <<?= $title_tag ?> class="elementor-title">{$product.name}</<?= $title_tag ?>>
                <?php if ($settings['show_description']) : ?>
                    <div class="elementor-description">{$product.description_short|strip_tags:0}</div>
                <?php endif ?>
                <?php if ($this->show_prices) : ?>
                    {if $product.show_price}
                        <div class="elementor-price-wrapper">
                    <?php if ($settings['show_regular_price']) : ?>
                        {if $product.has_discount}
                            <span class="elementor-price-regular">{$product.regular_price}</span>
                        {/if}
                    <?php endif ?>
                            <span class="elementor-price">{$product.price}</span>
                        </div>
                    {/if}
                <?php endif ?>
                </div>
            </a>
        <?php if ($settings['show_atc'] && $this->show_prices) : ?>
            {if $product.show_price}
                {if $product.add_to_cart_url}
                    {$atc_url = $product.add_to_cart_url}
                {else}
                    {$atc_url = {url entity='cart' ssl=true params=[
                        'add' => 1,
                        'id_product' => $product.id_product|intval,
                        'ipa' => $product.id_product_attribute|intval,
                        'token' => Tools::getToken(false)
                    ]}}
                {/if}
                <form class="elementor-atc" action="{$atc_url}">
                    <input type="hidden" name="qty" value="{max(1, $product[_q_c_(
                        !empty($product.product_attribute_minimal_quantity),
                        'product_attribute_minimal_quantity',
                        'minimal_quantity'
                    )])}">
                    <button type="submit" class="elementor-button elementor-size-<?= $settings['atc_size'] ?>"
                        data-button-action="add-to-cart" {if isset($product.flags.out_of_stock)}disabled{/if}>
                        <span class="elementor-button-content-wrapper">
                        <?php if (!empty($settings['atc_icon'])) : ?>
                            <span class="elementor-atc-icon elementor-align-icon-<?= $settings['atc_icon_align'] ?>">
                                <i class="<?= $settings['atc_icon'] ?>"></i>
                            </span>
                        <?php endif ?>
                            <span class="elementor-button-text"><?= $settings['atc_text'] ?></span>
                        </span>
                    </button>
                </form>
            {/if}
        <?php endif ?>
        </div>
        <?php
    }
}
