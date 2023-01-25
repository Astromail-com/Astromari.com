<?php
/**
 * Creative Elements - live Theme & Page Builder
 *
 * @author    WebshopWorks
 * @copyright 2019-2022 WebshopWorks.com
 * @license   One domain support license
 */

defined('_PS_VERSION_') or die;

function upgrade_module_2_5_11($module)
{
    Shop::isFeatureActive() && Shop::setContext(Shop::CONTEXT_ALL);

    Media::clearCache();

    copy(_CE_PATH_ . 'views/lib/filemanager/config.php', _PS_IMG_DIR_ . 'cms/config.php');

    return $module->registerHook('actionFrontControllerAfterInit', null, 1);
}
