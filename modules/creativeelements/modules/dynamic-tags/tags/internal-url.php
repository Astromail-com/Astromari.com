<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks, Elementor
 * @copyright 2019-2022 WebshopWorks.com & Elementor.com
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CE;

defined('_PS_VERSION_') or die;

use CE\CoreXDynamicTagsXDataTag as DataTag;
use CE\ModulesXDynamicTagsXModule as Module;
use CE\ModulesXCatalogXControlsXSelectCategory as SelectCategory;
use CE\ModulesXCatalogXControlsXSelectManufacturer as SelectManufacturer;
use CE\ModulesXCatalogXControlsXSelectSupplier as SelectSupplier;

class ModulesXDynamicTagsXTagsXInternalURL extends DataTag
{
    public function getName()
    {
        return 'internal-url';
    }

    public function getGroup()
    {
        return Module::SITE_GROUP;
    }

    public function getCategories()
    {
        return [Module::URL_CATEGORY];
    }

    public function getTitle()
    {
        return __('Internal URL');
    }

    public function getPanelTemplateSettingKey()
    {
        return 'type';
    }

    protected function _registerControls()
    {
        $type_options = [
            '' => __('Select...'),
            'product' => __('Product'),
            'category' => __('Category'),
        ];
        $display_suppliers = \Configuration::get('PS_DISPLAY_SUPPLIERS');
        $display_manufacturers = version_compare(_PS_VERSION_, '1.7.7', '<')
            ? $display_suppliers
            : \Configuration::get('PS_DISPLAY_MANUFACTURERS')
        ;
        empty($display_manufacturers) or $type_options['manufacturer'] = __('Brand');
        empty($display_suppliers) or $type_options['supplier'] = __('Supplier');

        $this->addControl(
            'type',
            [
                'label' => __('Type'),
                'type' => ControlsManager::SELECT,
                'options' => &$type_options,
            ]
        );

        $this->addControl(
            'id_product',
            [
                'label' => __('Search & Select'),
                'type' => ControlsManager::SELECT2,
                'label_block' => true,
                'select2options' => [
                    'placeholder' => __('Type Product Name / Ref'),
                    'product' => true,
                    'ajax' => [
                        'url' => Helper::getAjaxProductsListLink(),
                    ],
                ],
                'condition' => [
                    'type' => 'product',
                ],
            ]
        );

        $this->addControl(
            'id_category',
            [
                'label' => __('Search & Select'),
                'label_block' => true,
                'type' => SelectCategory::CONTROL_TYPE,
                'select2options' => [
                    'allowClear' => false,
                ],
                'default' => 2,
                'condition' => [
                    'type' => 'category',
                ],
            ]
        );

        empty($display_manufacturers) or $this->addControl(
            'id_manufacturer',
            [
                'label' => __('Search & Select'),
                'label_block' => true,
                'type' => SelectManufacturer::CONTROL_TYPE,
                'select2options' => [
                    'placeholder' => __('Select...'),
                ],
                'condition' => [
                    'type' => 'manufacturer',
                ],
            ]
        );

        empty($display_suppliers) or $this->addControl(
            'id_supplier',
            [
                'label' => __('Search & Select'),
                'label_block' => true,
                'type' => SelectSupplier::CONTROL_TYPE,
                'select2options' => [
                    'placeholder' => __('Select...'),
                ],
                'condition' => [
                    'type' => 'supplier',
                ],
            ]
        );
    }

    public function getValue(array $options = [])
    {
        $settings = $this->getSettings();
        $type = $settings['type'];
        $context = \Context::getContext();
        $id_lang = (int) $context->language->id;

        if ('product' === $type && !empty($settings['id_product'])) {
            return $context->link->getProductLink(new \Product($settings['id_product'], false, $id_lang));
        }
        if ('category' === $type) {
            return $context->link->getCategoryLink(new \Category($settings['id_category'], $id_lang));
        }
        if ('manufacturer' === $type) {
            return $context->link->getManufacturerLink(new \Manufacturer($settings['id_manufacturer'], $id_lang));
        }
        if ('supplier' === $type) {
            return $context->link->getSupplierLink(new \Supplier($settings['id_supplier'], $id_lang));
        }
    }

    protected function getSmartyValue(array $options = [])
    {
        $settings = $this->getSettings();
        $type = $settings['type'];

        if ('product' === $type && !empty($settings['id_product'])) {
            $id = (int) $settings['id_product'];

            return "{\$link->getProductLink(ce_new(Product, $id, false, \$language.id))}";
        }
        if ('category' === $type) {
            $id = (int) $settings['id_category'];

            return "{\$link->getCategoryLink(ce_new(Category, $id, \$language.id))}";
        }
        if ('manufacturer' === $type) {
            $id = (int) $settings['id_manufacturer'];

            return "{\$link->getManufacturerLink(ce_new(Manufacturer, $id, \$language.id))}";
        }
        if ('supplier' === $type) {
            $id = (int) $settings['id_supplier'];

            return "{\$link->getSupplierLink(ce_new(Supplier, $id, \$language.id))}";
        }
    }
}
