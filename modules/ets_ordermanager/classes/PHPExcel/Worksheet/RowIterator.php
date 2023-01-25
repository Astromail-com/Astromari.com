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

class PHPExcel_Worksheet_RowIterator implements Iterator
{
    /**
     * PHPExcel_Worksheet to iterate
     *
     * @var PHPExcel_Worksheet
     */
    private $subject;

    /**
     * Current iterator position
     *
     * @var int
     */
    private $position = 1;

    /**
     * Start position
     *
     * @var int
     */
    private $startRow = 1;


    /**
     * End position
     *
     * @var int
     */
    private $endRow = 1;


    /**
     * Create a new row iterator
     *
     * @param    PHPExcel_Worksheet    $subject    The worksheet to iterate over
     * @param    integer                $startRow    The row number at which to start iterating
     * @param    integer                $endRow        Optionally, the row number at which to stop iterating
     */
    public function __construct(PHPExcel_Worksheet $subject, $startRow = 1, $endRow = null)
    {
        // Set subject
        $this->subject = $subject;
        $this->resetEnd($endRow);
        $this->resetStart($startRow);
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unset($this->subject);
    }

    /**
     * (Re)Set the start row and the current row pointer
     *
     * @param integer    $startRow    The row number at which to start iterating
     * @return PHPExcel_Worksheet_RowIterator
     * @throws PHPExcel_Exception
     */
    public function resetStart($startRow = 1)
    {
        if ($startRow > $this->subject->getHighestRow()) {
            throw new PHPExcel_Exception("Start row ({$startRow}) is beyond highest row ({$this->subject->getHighestRow()})");
        }

        $this->startRow = $startRow;
        if ($this->endRow < $this->startRow) {
            $this->endRow = $this->startRow;
        }
        $this->seek($startRow);

        return $this;
    }

    /**
     * (Re)Set the end row
     *
     * @param integer    $endRow    The row number at which to stop iterating
     * @return PHPExcel_Worksheet_RowIterator
     */
    public function resetEnd($endRow = null)
    {
        $this->endRow = ($endRow) ? $endRow : $this->subject->getHighestRow();

        return $this;
    }

    /**
     * Set the row pointer to the selected row
     *
     * @param integer    $row    The row number to set the current pointer at
     * @return PHPExcel_Worksheet_RowIterator
     * @throws PHPExcel_Exception
     */
    public function seek($row = 1)
    {
        if (($row < $this->startRow) || ($row > $this->endRow)) {
            throw new PHPExcel_Exception("Row $row is out of range ({$this->startRow} - {$this->endRow})");
        }
        $this->position = $row;

        return $this;
    }

    /**
     * Rewind the iterator to the starting row
     */
    public function rewind()
    {
        $this->position = $this->startRow;
    }

    /**
     * Return the current row in this worksheet
     *
     * @return PHPExcel_Worksheet_Row
     */
    public function current()
    {
        return new PHPExcel_Worksheet_Row($this->subject, $this->position);
    }

    /**
     * Return the current iterator key
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Set the iterator to its next value
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Set the iterator to its previous value
     */
    public function prev()
    {
        if ($this->position <= $this->startRow) {
            throw new PHPExcel_Exception("Row is already at the beginning of range ({$this->startRow} - {$this->endRow})");
        }

        --$this->position;
    }

    /**
     * Indicate if more rows exist in the worksheet range of rows that we're iterating
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->position <= $this->endRow;
    }
}
