<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

defined('_PS_VERSION_') or die;

function upgrade_module_2_5_10($module)
{
    Shop::isFeatureActive() && Shop::setContext(Shop::CONTEXT_ALL);

    require_once _CE_PATH_ . 'classes/CEDatabase.php';

    $result = CEDatabase::updateTabs();
    $result &= $module->registerHook('actionFrontControllerInitAfter', null, 1);

    CEDatabase::initConfigs();

    CE\Plugin::instance()->files_manager->clearCache();
    Media::clearCache();

    return $result;
}
