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

class WidgetProductSaleCountdown extends WidgetCountdown
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'product-sale-countdown';
    }

    public function getTitle()
    {
        return __('Sale Countdown');
    }

    public function getIcon()
    {
        return 'eicon-countdown';
    }

    public function getCategories()
    {
        return ['product-elements'];
    }

    public function getKeywords()
    {
        return ['shop', 'store', 'countdown', 'timer', 'date', 'sale', 'discount', 'product'];
    }

    protected function _registerControls()
    {
        parent::_registerControls();

        $this->updateControl(
            'due_date',
            [
                'type' => ControlsManager::HIDDEN,
                'default' => '',
            ]
        );
    }

    protected function getHtmlWrapperClass()
    {
        return parent::getHtmlWrapperClass() . ' elementor-widget-' . parent::getName();
    }

    protected function render()
    {
        $product = &\Context::getContext()->smarty->tpl_vars['product']->value;

        if (!empty($product['specific_prices']['to']) && '0000-00-00 00:00:00' !== $product['specific_prices']['to']) {
            $this->setSettings('due_date', $product['specific_prices']['to']);

            parent::render();
        }
    }

    protected function renderSmarty()
    {
        $settings = $this->getSettingsForDisplay();
        ?>
        {if !empty($product.specific_prices.to) && '0000-00-00 00:00:00' !== $product.specific_prices.to}
            <div class="elementor-countdown-wrapper"
                data-date="{strtotime($product.specific_prices.to)}"
                data-expire-actions='<?= str_replace('{"', '{ "', json_encode($this->getActions($settings))) ?>'>
                <?= $this->getStrftime($settings) ?>
            </div>
        <?php if (in_array('message', $settings['expire_actions'])) : ?>
            <div class="elementor-countdown-expire--message"><?= $settings['message_after_expire'] ?></div>
        <?php endif ?>
        {/if}
        <?php
    }
}
