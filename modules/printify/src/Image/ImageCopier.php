<?php
/**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace Invertus\Printify\Image;

use Configuration;
use Context;
use Image;
use ImageManager;
use ImageType;
use PrestaShopDatabaseException;
use Tools;

/**
 * Class ImageCopier copies images during import process. It is a simplified copy of
 * PrestaShop\PrestaShop\Adapter\Import\ImageCopier to avoid having dependency issues in 1.6 version
 */
class ImageCopier
{
    /**
     * Copy an image located in $url and save it in a path.
     *
     * @param $entityId
     * @param null $imageId
     * @param string $url
     * @param string $entity
     * @param bool $regenerate
     * @return bool
     * @throws PrestaShopDatabaseException
     */
    public function copyImg($entityId, $imageId = null, $url = '', $entity = 'products', $regenerate = true)
    {
        $tmpDir = Configuration::get('_PS_TMP_IMG_DIR_');
        $tmpFile = tempnam($tmpDir, 'ps_import');

        $image_obj = new Image($imageId);
        $path = $image_obj->getPathForCreation();

        $url = urldecode(trim($url));
        $parsedUrl = parse_url($url);

        if (isset($parsedUrl['path'])) {
            $uri = ltrim($parsedUrl['path'], '/');
            $parts = explode('/', $uri);
            foreach ($parts as &$part) {
                $part = rawurlencode($part);
            }
            unset($part);
            $parsedUrl['path'] = '/' . implode('/', $parts);
        }

        if (isset($parsedUrl['query'])) {
            $query_parts = array();
            parse_str($parsedUrl['query'], $query_parts);
            $parsedUrl['query'] = http_build_query($query_parts);
        }

        if (!function_exists('http_build_url')) {
            require_once Configuration::get('_PS_TOOL_DIR_') . 'http_build_url/http_build_url.php';
        }

        $url = http_build_url('', $parsedUrl);

        $origTmpfile = $tmpFile;

        if ($this->copy($url, $tmpFile)) {
            // Evaluate the memory required to resize the image: if it's too much, you can't resize it.
            if (!ImageManager::checkImageMemoryLimit($tmpFile)) {
                @unlink($tmpFile);

                return false;
            }

            $targetWidth = $targetHeight = 0;
            $sourceWidth = $sourceHeight = 0;
            $error = 0;
            ImageManager::resize(
                $tmpFile,
                $path . '.jpg',
                null,
                null,
                'jpg',
                false,
                $error,
                $targetWidth,
                $targetHeight,
                5,
                $sourceWidth,
                $sourceHeight
            );
            $imagesTypes = ImageType::getImagesTypes($entity, true);

            if ($regenerate) {
                $previous_path = null;
                $pathInfos = [];
                $pathInfos[] = [$targetWidth, $targetHeight, $path . '.jpg'];
                foreach ($imagesTypes as $imageType) {
                    $tmpFile = $this->getBestPath($imageType['width'], $imageType['height'], $pathInfos);

                    if (ImageManager::resize(
                        $tmpFile,
                        $path . '-' . stripslashes($imageType['name']) . '.jpg',
                        $imageType['width'],
                        $imageType['height'],
                        'jpg',
                        false,
                        $error,
                        $targetWidth,
                        $targetHeight,
                        5,
                        $sourceWidth,
                        $sourceHeight
                    )) {
                        // the last image should not be added in the candidate
                        // list if it's bigger than the original image
                        if ($targetWidth <= $sourceWidth && $targetHeight <= $sourceHeight) {
                            $pathInfos[] = array(
                                $targetWidth, $targetHeight,
                                $path . '-' . stripslashes($imageType['name']) . '.jpg'
                            );
                        }
                        if ($entity == 'products') {
                            $file = $tmpDir . 'product_mini_' . (int) $entityId . '.jpg';
                            if (is_file($file)) {
                                unlink($file);
                            }

                            $file = $tmpDir . 'product_mini_' . (int) $entityId
                                . '_' . (int) Context::getContext()->shop->id . '.jpg';
                            if (is_file($file)) {
                                unlink($file);
                            }
                        }
                    }
                }
            }
        } else {
            @unlink($origTmpfile);

            return false;
        }
        unlink($origTmpfile);

        return true;
    }

    /** changing prestashops tools copy for larger timeout */
    public static function copy($source, $destination, $stream_context = null)
    {
        if (null === $stream_context && !preg_match('/^https?:\/\//', $source)) {
            return @copy($source, $destination);
        }

        return @file_put_contents($destination, Tools::file_get_contents($source, false, $stream_context, 10));
    }

    /**
     * Find the best path, compared to given dimensions.
     *
     * @param int $targetWidth
     * @param int $targetHeight
     * @param array $pathInfos
     *
     * @return string
     */
    private function getBestPath($targetWidth, $targetHeight, $pathInfos)
    {
        $pathInfos = array_reverse($pathInfos);
        $path = '';
        foreach ($pathInfos as $pathInfo) {
            list($width, $height, $path) = $pathInfo;
            if ($width >= $targetWidth && $height >= $targetHeight) {
                return $path;
            }
        }

        return $path;
    }
}
