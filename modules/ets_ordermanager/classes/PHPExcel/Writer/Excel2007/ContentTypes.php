<?php
/**
 * 2007-2023 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 * @author ETS-Soft <etssoft.jsc@gmail.com>
 * @copyright  2007-2023 ETS-Soft
 * @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */

class PHPExcel_Writer_Excel2007_ContentTypes extends PHPExcel_Writer_Excel2007_WriterPart
{
    /**
     * Write content types to XML format
     *
     * @param     PHPExcel    $pPHPExcel
     * @param    boolean        $includeCharts    Flag indicating if we should include drawing details for charts
     * @return     string                         XML Output
     * @throws     PHPExcel_Writer_Exception
     */
    public function writeContentTypes(PHPExcel $pPHPExcel = null, $includeCharts = false)
    {
        // Create XML writer
        $objWriter = null;
        if ($this->getParentWriter()->getUseDiskCaching()) {
            $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());
        } else {
            $objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);
        }

        // XML header
        $objWriter->startDocument('1.0', 'UTF-8', 'yes');

        // Types
        $objWriter->startElement('Types');
        $objWriter->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/package/2006/content-types');

        // Theme
        $this->writeOverrideContentType($objWriter, '/xl/theme/theme1.xml', 'application/vnd.openxmlformats-officedocument.theme+xml');

        // Styles
        $this->writeOverrideContentType($objWriter, '/xl/styles.xml', 'application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml');

        // Rels
        $this->writeDefaultContentType($objWriter, 'rels', 'application/vnd.openxmlformats-package.relationships+xml');

        // XML
        $this->writeDefaultContentType($objWriter, 'xml', 'application/xml');

        // VML
        $this->writeDefaultContentType($objWriter, 'vml', 'application/vnd.openxmlformats-officedocument.vmlDrawing');

        // Workbook
        if ($pPHPExcel->hasMacros()) { //Macros in workbook ?
            // Yes : not standard content but "macroEnabled"
            $this->writeOverrideContentType($objWriter, '/xl/workbook.xml', 'application/vnd.ms-excel.sheet.macroEnabled.main+xml');
            //... and define a new type for the VBA project
            $this->writeDefaultContentType($objWriter, 'bin', 'application/vnd.ms-office.vbaProject');
            if ($pPHPExcel->hasMacrosCertificate()) {// signed macros ?
                // Yes : add needed information
                $this->writeOverrideContentType($objWriter, '/xl/vbaProjectSignature.bin', 'application/vnd.ms-office.vbaProjectSignature');
            }
        } else {// no macros in workbook, so standard type
            $this->writeOverrideContentType($objWriter, '/xl/workbook.xml', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml');
        }

        // DocProps
        $this->writeOverrideContentType($objWriter, '/docProps/app.xml', 'application/vnd.openxmlformats-officedocument.extended-properties+xml');

        $this->writeOverrideContentType($objWriter, '/docProps/core.xml', 'application/vnd.openxmlformats-package.core-properties+xml');

        $customPropertyList = $pPHPExcel->getProperties()->getCustomProperties();
        if (!empty($customPropertyList)) {
            $this->writeOverrideContentType($objWriter, '/docProps/custom.xml', 'application/vnd.openxmlformats-officedocument.custom-properties+xml');
        }

        // Worksheets
        $sheetCount = $pPHPExcel->getSheetCount();
        for ($i = 0; $i < $sheetCount; ++$i) {
            $this->writeOverrideContentType($objWriter, '/xl/worksheets/sheet' . ($i + 1) . '.xml', 'application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml');
        }

        // Shared strings
        $this->writeOverrideContentType($objWriter, '/xl/sharedStrings.xml', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml');

        // Add worksheet relationship content types
        $chart = 1;
        for ($i = 0; $i < $sheetCount; ++$i) {
            $drawings = $pPHPExcel->getSheet($i)->getDrawingCollection();
            $drawingCount = count($drawings);
            $chartCount = ($includeCharts) ? $pPHPExcel->getSheet($i)->getChartCount() : 0;

            //    We need a drawing relationship for the worksheet if we have either drawings or charts
            if (($drawingCount > 0) || ($chartCount > 0)) {
                $this->writeOverrideContentType($objWriter, '/xl/drawings/drawing' . ($i + 1) . '.xml', 'application/vnd.openxmlformats-officedocument.drawing+xml');
            }

            //    If we have charts, then we need a chart relationship for every individual chart
            if ($chartCount > 0) {
                for ($c = 0; $c < $chartCount; ++$c) {
                    $this->writeOverrideContentType($objWriter, '/xl/charts/chart' . $chart++ . '.xml', 'application/vnd.openxmlformats-officedocument.drawingml.chart+xml');
                }
            }
        }

        // Comments
        for ($i = 0; $i < $sheetCount; ++$i) {
            if (count($pPHPExcel->getSheet($i)->getComments()) > 0) {
                $this->writeOverrideContentType($objWriter, '/xl/comments' . ($i + 1) . '.xml', 'application/vnd.openxmlformats-officedocument.spreadsheetml.comments+xml');
            }
        }

        // Add media content-types
        $aMediaContentTypes = array();
        $mediaCount = $this->getParentWriter()->getDrawingHashTable()->count();
        for ($i = 0; $i < $mediaCount; ++$i) {
            $extension     = '';
            $mimeType     = '';

            if ($this->getParentWriter()->getDrawingHashTable()->getByIndex($i) instanceof PHPExcel_Worksheet_Drawing) {
                $extension = strtolower($this->getParentWriter()->getDrawingHashTable()->getByIndex($i)->getExtension());
                $mimeType = $this->getImageMimeType($this->getParentWriter()->getDrawingHashTable()->getByIndex($i)->getPath());
            } elseif ($this->getParentWriter()->getDrawingHashTable()->getByIndex($i) instanceof PHPExcel_Worksheet_MemoryDrawing) {
                $extension = strtolower($this->getParentWriter()->getDrawingHashTable()->getByIndex($i)->getMimeType());
                $extension = explode('/', $extension);
                $extension = $extension[1];

                $mimeType = $this->getParentWriter()->getDrawingHashTable()->getByIndex($i)->getMimeType();
            }

            if (!isset( $aMediaContentTypes[$extension])) {
                $aMediaContentTypes[$extension] = $mimeType;

                $this->writeDefaultContentType($objWriter, $extension, $mimeType);
            }
        }
        if ($pPHPExcel->hasRibbonBinObjects()) {
            // Some additional objects in the ribbon ?
            // we need to write "Extension" but not already write for media content
            $tabRibbonTypes=array_diff($pPHPExcel->getRibbonBinObjects('types'), array_keys($aMediaContentTypes));
            foreach ($tabRibbonTypes as $aRibbonType) {
                $mimeType='image/.'.$aRibbonType;//we wrote $mimeType like customUI Editor
                $this->writeDefaultContentType($objWriter, $aRibbonType, $mimeType);
            }
        }
        $sheetCount = $pPHPExcel->getSheetCount();
        for ($i = 0; $i < $sheetCount; ++$i) {
            if (count($pPHPExcel->getSheet()->getHeaderFooter()->getImages()) > 0) {
                foreach ($pPHPExcel->getSheet()->getHeaderFooter()->getImages() as $image) {
                    if (!isset( $aMediaContentTypes[strtolower($image->getExtension())])) {
                        $aMediaContentTypes[strtolower($image->getExtension())] = $this->getImageMimeType($image->getPath());

                        $this->writeDefaultContentType($objWriter, strtolower($image->getExtension()), $aMediaContentTypes[strtolower($image->getExtension())]);
                    }
                }
            }
        }

        $objWriter->endElement();

        // Return
        return $objWriter->getData();
    }

    /**
     * Get image mime type
     *
     * @param     string    $pFile    Filename
     * @return     string    Mime Type
     * @throws     PHPExcel_Writer_Exception
     */
    private function getImageMimeType($pFile = '')
    {
        if (PHPExcel_Shared_File::file_exists($pFile)) {
            $image = getimagesize($pFile);
            return image_type_to_mime_type($image[2]);
        } else {
            throw new PHPExcel_Writer_Exception("File $pFile does not exist");
        }
    }

    /**
     * Write Default content type
     *
     * @param     PHPExcel_Shared_XMLWriter     $objWriter         XML Writer
     * @param     string                         $pPartname         Part name
     * @param     string                         $pContentType     Content type
     * @throws     PHPExcel_Writer_Exception
     */
    private function writeDefaultContentType(PHPExcel_Shared_XMLWriter $objWriter = null, $pPartname = '', $pContentType = '')
    {
        if ($pPartname != '' && $pContentType != '') {
            // Write content type
            $objWriter->startElement('Default');
            $objWriter->writeAttribute('Extension', $pPartname);
            $objWriter->writeAttribute('ContentType', $pContentType);
            $objWriter->endElement();
        } else {
            throw new PHPExcel_Writer_Exception("Invalid parameters passed.");
        }
    }

    /**
     * Write Override content type
     *
     * @param     PHPExcel_Shared_XMLWriter     $objWriter         XML Writer
     * @param     string                         $pPartname         Part name
     * @param     string                         $pContentType     Content type
     * @throws     PHPExcel_Writer_Exception
     */
    private function writeOverrideContentType(PHPExcel_Shared_XMLWriter $objWriter = null, $pPartname = '', $pContentType = '')
    {
        if ($pPartname != '' && $pContentType != '') {
            // Write content type
            $objWriter->startElement('Override');
            $objWriter->writeAttribute('PartName', $pPartname);
            $objWriter->writeAttribute('ContentType', $pContentType);
            $objWriter->endElement();
        } else {
            throw new PHPExcel_Writer_Exception("Invalid parameters passed.");
        }
    }
}
