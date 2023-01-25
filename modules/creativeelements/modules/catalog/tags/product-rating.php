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

use CE\CoreXDynamicTagsXTag as Tag;
use CE\ModulesXDynamicTagsXModule as Module;

class ModulesXCatalogXTagsXProductRating extends Tag
{
    const REMOTE_RENDER = true;

    public function getName()
    {
        return 'product-rating';
    }

    public function getTitle()
    {
        return __('Product Rating');
    }

    public function getGroup()
    {
        return Module::CATALOG_GROUP;
    }

    public function getCategories()
    {
        return [Module::TEXT_CATEGORY];
    }

    public function getPanelTemplateSettingKey()
    {
        return 'type';
    }

    protected function _registerControls()
    {
        $this->addControl(
            'type',
            [
                'label' => __('Field'),
                'type' => ControlsManager::SELECT,
                'options' => [
                    'average_grade' => __('Average Grade'),
                    'nb_comments' => __('Comments Number'),
                ],
                'default' => 'average_grade',
            ]
        );
    }

    public function render()
    {
        $productcomments = \Module::getInstanceByName('productcomments');

        if (empty($productcomments->active) || $productcomments->author !== 'PrestaShop') {
            return;
        }
        $product = &\Context::getContext()->smarty->tpl_vars['product']->value;
        $vars = $productcomments->getWidgetVariables('displayCE', [
            'id_product' => (int) $product['id_product'],
        ]);
        $type = $this->getSettings('type');

        switch ($type) {
            case 'average_grade':
                echo \Tools::ps_round($vars[$type], 1);
                break;
            case 'nb_comments':
                echo (int) $vars[$type];
                break;
        }
    }

    protected function renderSmarty()
    {
        echo
            '{$cb = Context::getContext()->controller->getContainer()}',
            '{if $cb->has(product_comment_repository)}{$pcr = $cb->get(product_comment_repository)}',
            $this->getSettings('type') === 'average_grade'
            ? '{Tools::ps_round($pcr->getAverageGrade($product.id, Configuration::get("PRODUCT_COMMENTS_MODERATE")),1)}'
            : '{$pcr->getCommentsNumber($product.id, Configuration::get("PRODUCT_COMMENTS_MODERATE"))}',
            '{/if}';
    }
}
