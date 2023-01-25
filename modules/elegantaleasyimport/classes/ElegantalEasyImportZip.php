<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is helper class for importing .zip files
 */
class ElegantalEasyImportZip
{
    public static function convertToCsv($file, $entity, $multiple_value_separator)
    {
        if (!class_exists('ZipArchive')) {
            return;
        }
        $path_parts = pathinfo($file);
        $zip_dir = ElegantalEasyImportTools::getTempDir() . '/' . $path_parts['filename'];
        $zip = new ZipArchive;
        $zip_open = $zip->open($file);
        if ($zip_open === true) {
            $zip->extractTo($zip_dir);
            $zip->close();
            $files = array_diff(scandir($zip_dir), array('.', '..'));
            if ($files) {
                foreach ($files as $zip_file) {
                    $extension = Tools::strtolower(pathinfo($zip_file, PATHINFO_EXTENSION));
                    if (in_array($extension, ElegantalEasyImportClass::$allowed_file_types)) {
                        $mime = ElegantalEasyImportTools::getMimeType($zip_dir . '/' . $zip_file, $extension);
                        if (in_array($mime, ElegantalEasyImportClass::$allowed_mime_types)) {
                            copy($zip_dir . '/' . $zip_file, $file);
                            switch ($extension) {
                                case 'csv':
                                case 'txt':
                                    ElegantalEasyImportCsv::convertToCsv($file, $entity, $multiple_value_separator);
                                    break;
                                case 'xml':
                                case 'rss':
                                    ElegantalEasyImportXml::convertToCsv($file, $entity, $multiple_value_separator);
                                    break;
                                case 'json':
                                    ElegantalEasyImportJson::convertToCsv($file, $entity, $multiple_value_separator);
                                    break;
                                case 'xls':
                                case 'xlsx':
                                case 'ods':
                                    ElegantalEasyImportExcel::convertToCsv($file, $entity, $multiple_value_separator);
                                    break;
                                default:
                                    break;
                            }
                            break;
                        }
                    }
                }
            }
            ElegantalEasyImportTools::deleteFolderRecursively($zip_dir);
        }
        return true;
    }
}
