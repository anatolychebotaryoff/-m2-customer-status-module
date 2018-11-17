<?php
/**
 * StoreFront CyberSource Tokenized Payment Extension for Magento
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of StoreFront Consulting, Inc.
 *
 * @category  SFC
 * @package   SFC_CyberSource
 * @author    Garth Brantley <garth@storefrontconsulting.com>
 * @copyright 2009-2013 StoreFront Consulting, Inc. All Rights Reserved.
 * @license   http://www.storefrontconsulting.com/media/downloads/ExtensionLicense.pdf StoreFront Consulting Commercial License
 * @link      http://www.storefrontconsulting.com/cybersource-saved-credit-cards-extension-for-magento/
 *
 */

class SFC_CyberSource_Helper_Tsvfile extends Mage_Core_Helper_Abstract
{

    /**
     * Variables
     */
    private $_filename;
    private $_handle;
    private $_path;
    private $_errorMessage;
    private $_columnHeaders;

    public function __construct()
    {
        $this->_filename = null;
        $this->_handle = null;
        $this->_path = null;
        $this->_errorMessage = null;
    }

    /**
     * Open file
     *
     * @param array $columnHeaders An array of column header names, one for each column
     * @param string $filename fully qualified filename + path. (directory must be writable)
     * @return boolean
     */
    public function open($filename, array $columnHeaders)
    {
        $this->_columnHeaders = $columnHeaders;
        $this->_filename = $filename;

        try {
            // Open file, truncate for writing
            $this->_handle = fopen($this->_filename, 'w');
            // Build header row string with delimiters & termination
            $rowString = implode("\t", $this->encodeFields($columnHeaders)) . "\r\n";
            // Write row to file, including delimiters and termination
            $result = fwrite($this->_handle, $rowString);
        }
        catch (Exception $e) {
            Mage::logException($e);

            return false;
        }

        return true;
    }

    /**
     * Re Open existing file
     *
     * @param string $filename fully qualified filename + path. (directory must be writable)
     * @param array $columnHeaders
     * @return boolean
     */
    public function reopen($filename, array $columnHeaders)
    {
        $this->_columnHeaders = $columnHeaders;
        $this->_filename = $filename;

        try {
            // Reopen file, append for writing
            $this->_handle = fopen($this->_filename, 'a');
        }
        catch (Exception $e) {
            Mage::logException($e);

            return false;
        }

        return true;
    }

    /**
     * Close file
     */
    public function close()
    {
        try {
            fclose($this->_handle);
        }
        catch (Exception $e) {
            Mage::logException($e);

            return false;
        }

        return true;
    }

    /**
     * Write row to file
     *
     * @param array $rowValues An associative array of columns => values, cells for columns not included in this row are left empty
     * @return boolean
     */
    public function writeRow(array $rowValues)
    {
        try {
            // Filter and order rowValues based on column headers
            $selectedRowValues = array();
            foreach ($this->_columnHeaders as $columnHeader) {
                $selectedRowValues[] = $rowValues[$columnHeader];
            }

            // Convert values to utf8
            $convertedRowValues = $this->encodeFields($selectedRowValues);
            // Build row string with delimiters & termination
            $rowString = implode("\t", $convertedRowValues) . "\r\n";
            // Write row to file, including delimiters and termination
            $result = fwrite($this->_handle, $rowString);
            // Check result
            if ($result != strlen($rowString)) {
                return false;
            }
        }
        catch (Exception $e) {
            Mage::logException($e);

            return false;
        }

        return true;
    }

    /**
     * Parse TSV file and call callback for each row of data
     *
     * @param string $filename Name of the file to parse
     * @param string $processRowFunction Function to be called back for each row of data
     * @return bool
     */
    public function parseTSVFile($filename, $processRowFunction)
    {
        // Log
        Mage::log('Parsing TSV file: ' . $filename, Zend_Log::INFO, SFC_CyberSource_Helper_Data::LOG_FILE);

        $fh = false;
        try {
            $fh = fopen($filename, 'r');
            if ($fh === false) {
                Mage::throwException('Failed to open order status file: ' . $filename);
            }

            // Read header row
            $headers = fgetcsv($fh, 0, "\t");
            if ($headers === false) {
                Mage::throwException('Failed to read header line from order status file: ' . $filename);
            }

            // Iterate lines in file
            $rowCount = 0;
            while (($rowValues = fgetcsv($fh, 0, "\t")) !== false) {
                // Increment row count
                $rowCount++;

                // Build row assoc array
                $rowData = array_combine($headers, $rowValues);

                try {
                    // Process this row
                    call_user_func($processRowFunction, $rowData);
                }
                catch (Exception $e) {
                    Mage::log($e->getMessage(), Zend_Log::ERR, SFC_CyberSource_Helper_Data::LOG_FILE);
                    Mage::log('Failed to process row.  Continuing processing additional rows.', Zend_Log::ERR,
                        SFC_CyberSource_Helper_Data::LOG_FILE);
                }
            }

            // Close file
            fclose($fh);
            $fh = false;

            // Return success
            return true;

        }
        catch (Exception $e) {
            // Log
            Mage::log($e->getMessage(), Zend_Log::ERR, SFC_CyberSource_Helper_Data::LOG_FILE);
            Mage::log('Failed to parse TSV file: ' . $filename, Zend_Log::ERR, SFC_CyberSource_Helper_Data::LOG_FILE);

            // close file if still open
            if ($fh != false) {
                fclose($fh);
                $fh = false;
            }

            // Return failure
            return false;
        }

    }

    /**
     * Convert strings in array to Utf8 and encode for CSV file usage
     *
     * @param array $values
     * @return array $converted
     */
    private function encodeFields(array $values)
    {
        $converted = array();
        foreach ($values as $value) {
            // Encode in utf8
            $newVal = utf8_encode($value);
            // Encode delimiters inside field
            $newVal = str_replace('"', '""', $newVal);
            // Add delimiter
            $newVal = '"' . $newVal . '"';
            // Add to converted array
            array_push($converted, $newVal);
        }

        return $converted;
    }
}
