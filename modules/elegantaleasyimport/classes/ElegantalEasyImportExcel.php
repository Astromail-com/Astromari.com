<?php
/**
 * @author    ELEGANTAL <info@elegantal.com>
 * @copyright (c) 2023, ELEGANTAL <www.elegantal.com>
 * @license   Proprietary License - It is forbidden to resell or redistribute copies of the module or modified copies of the module.
 */

/**
 * This is helper class for Excel functions
 */
class ElegantalEasyImportExcel
{
    public static function convertToCsv($file, $entity, $multiple_value_separator)
    {
        if (class_exists("\PhpOffice\PhpSpreadsheet\IOFactory")) {
            self::convertToCsvByPhpSpreadsheet($file);
        } elseif (class_exists("PHPExcel_IOFactory")) {
            self::convertToCsvByPhpExcel($file);
        } elseif (file_exists(dirname(__FILE__) . '/../vendors/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php')) {
            require_once dirname(__FILE__) . '/../vendors/autoload.php';
            self::convertToCsvByPhpSpreadsheet($file);
        } elseif (file_exists(dirname(__FILE__) . '/../vendors/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php')) {
            require_once dirname(__FILE__) . '/../vendors/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
            self::convertToCsvByPhpExcel($file);
        } else {
            throw new Exception("PHPExcel library could not be loaded. Please contact module developer.");
        }

        // Process CSV file if needed
        ElegantalEasyImportCsv::convertToCsv($file, $entity, $multiple_value_separator);

        return true;
    }

    /**
     * Convert excel to csv by PHPExcel
     * @param string $file
     * @return bool
     */
    public static function convertToCsvByPhpSpreadsheet($file)
    {
        if (!class_exists("\PhpOffice\PhpSpreadsheet\IOFactory")) {
            return false;
        }
        $reader = call_user_func(array('\PhpOffice\PhpSpreadsheet\IOFactory', 'createReaderForFile'), $file);
        // $reader->setReadDataOnly(true); This should not be used. It caused an issue by changing cell value.
        $phpSpreadsheet = $reader->load($file);
        $writer = call_user_func(array('\PhpOffice\PhpSpreadsheet\IOFactory', 'createWriter'), $phpSpreadsheet, 'Csv');
        call_user_func(array($writer, 'setSheetIndex'), 0);
        call_user_func(array($writer, 'setDelimiter'), ';');
        $writer->save($file);
        unset($writer);
        unset($phpSpreadsheet);
        unset($reader);
        return true;
    }

    /**
     * Convert excel to csv by PHPExcel
     * @param string $file
     * @return bool
     */
    public static function convertToCsvByPhpExcel($file)
    {
        if (!class_exists("PHPExcel_IOFactory")) {
            return false;
        }
        $PHPExcel_IOFactory_Class = "PHPExcel_IOFactory";
        $reader = $PHPExcel_IOFactory_Class::createReaderForFile($file);
        // call_user_func(array($reader, 'setReadDataOnly'), true); This should not be used. It caused an issue by changing cell value.
        $phpExcel = $reader->load($file);
        $writer = $PHPExcel_IOFactory_Class::createWriter($phpExcel, 'CSV');
        call_user_func(array($writer, 'setSheetIndex'), 0);
        call_user_func(array($writer, 'setDelimiter'), ';');
        $writer->save($file);
        unset($writer);
        unset($phpExcel);
        unset($reader);
        return true;
    }
}
