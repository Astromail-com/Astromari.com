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

include_once dirname(__FILE__) . '/product-rating.php';

class WidgetProductMiniatureRating extends WidgetProductRating
{
    public function getName()
    {
        return 'product-miniature-rating';
    }

    protected function _registerControls()
    {
        parent::_registerControls();

        $this->updateControl('comments_number_icon', [
            'default' => '',
        ]);

        $this->updateControl('comments_number_before', [
            'placeholder' => '',
            'default' => '(',
        ]);

        $this->updateControl('comments_number_after', [
            'default' => ')',
        ]);
    }

    protected function renderStars($icon)
    {
        if (!is_admin()) {
            return parent::renderStars($icon);
        }
        ob_start();
        ?>
        {$floored_rating = $average_grade|intval}
        {for $stars=1 to 5}
            {if $stars <= $floored_rating}
                <i class="elementor-star-full"><?= $icon ?></i>
            {elseif $floored_rating + 1 === $stars}
                <i class="elementor-star-{10*($average_grade - $floored_rating)}"><?= $icon ?></i>
            {else}
                <i class="elementor-star-empty"><?= $icon ?></i>
            {/if}
        {/for}
        <?php
        return ob_get_clean();
    }

    protected function renderSmarty()
    {
        $settings = $this->getSettingsForDisplay();
        ?>
        {$cb = Context::getContext()->controller->getContainer()}
        {if $cb->has('product_comment_repository')}
            {$pcr = $cb->get('product_comment_repository')}
            {$pcm = Configuration::get('PRODUCT_COMMENTS_MODERATE')}
            {$nb_comments = _q_c_($pcr, $pcr->getCommentsNumber($product.id, $pcm)|intval, 0)}
            <?= $settings['hide_empty']
                ? '{if $nb_comments}'
                : '{if $pcr}'
            ?>
            {$average_grade = Tools::ps_round($pcr->getAverageGrade($product.id, $pcm), 1)}
            <div class="ce-product-rating"
                {if $nb_comments}itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope{/if}>
                <?php WidgetStarRating::render() ?>
            {if $nb_comments}
                <meta itemprop="ratingValue" content="{$average_grade}">

            <?php if ($settings['show_average_grade']) : ?>
                <span class="ce-product-rating__average-grade">{$average_grade}</span>
            <?php endif ?>

            <?php if ($settings['show_comments_number']) : ?>
                <meta itemprop="reviewCount" content="{$nb_comments}">
                <span class="elementor-icon-list-item">
                <?php if ($settings['comments_number_icon']) : ?>
                    <span class="elementor-icon-list-icon">
                        <i class="<?= esc_attr($settings['comments_number_icon']) ?>" aria-hidden="true"></i>
                    </span>
                <?php endif ?>
                    <span class="elementor-icon-list-text">
                        <?= "$settings[comments_number_before]{\$nb_comments}$settings[comments_number_after]" ?>
                    </span>
                </span>
            <?php endif ?>
            {/if}
            </div>
            <?= '{/if}' ?>
        {/if}
        <?php
    }
}
