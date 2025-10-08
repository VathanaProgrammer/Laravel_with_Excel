<?php
namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelService
{
    private $file;

    public function __construct($filename = 'products_cleaned.xlsx')
    {
        $this->file = storage_path('app/' . $filename);

        // Create file if it doesn't exist
        if(!file_exists($this->file)) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->fromArray([['Name', 'Price']], NULL, 'A1');
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($this->file);
        }
    }
    /**
     * Read Excel data with pagination and associative keys
     *
     * @param string|null $sheetName
     * @param int $startRow 1-based
     * @param int $startColumn 0-based
     * @param int|null $endColumn 0-based
     * @param int|null $expectedColumns Total columns per row (auto-detect if null)
     * @param int $limit Number of rows per request
     * @return array
     */
    public function read($sheetName = null, $startRow = 1, $startColumn = 0, $endColumn = null, $expectedColumns = null, $limit = 100)
    {
        ini_set('memory_limit', '1024M'); // prevent memory crash

        $spreadsheet = IOFactory::load($this->file);

        // Choose sheet
        $sheet = ($sheetName && $spreadsheet->sheetNameExists($sheetName))
            ? $spreadsheet->getSheetByName($sheetName)
            : $spreadsheet->getActiveSheet();

        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        // Compute last row for pagination
        $lastRow = min($highestRow, $startRow + $limit - 1);

        $range = "A{$startRow}:{$highestColumn}{$lastRow}";
        $rows = $sheet->rangeToArray($range, null, true, true, false); // numeric keys

        if (empty($rows)) return [];

        // Define keys for associative array (adjust based on your Excel columns)
        $keys = [
            'code',        // column A
            'name_en',     // column B
            'extra',       // column C (maybe null)
            'name_kh',     // column D
            'unit',        // column E
            'old_price',       // column F
            'new_price',  // column G
            'image_url',   // column H
        ];

        // Auto-detect expected columns if not provided
        if ($expectedColumns === null) {
            $expectedColumns = count($keys);
        }

        $data = [];
        foreach ($rows as $row) {
            // Slice columns if endColumn specified
            $rowData = array_slice($row, $startColumn, $endColumn !== null ? $endColumn - $startColumn + 1 : null);

            // Trim strings and clean invisible characters
            $rowData = array_map(function ($v) {
                if (is_string($v)) {
                    $v = trim($v);
                    $v = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $v);
                }
                return $v;
            }, $rowData);

            // Pad row to expected columns
            $rowData = array_pad($rowData, $expectedColumns, null);

            // Skip fully empty rows
            if (count(array_filter($rowData)) === 0) continue;

            // Map row to associative array
            $data[] = array_combine($keys, $rowData);
        }

        return $data;
    }

public function addRow($row, $startColumn = 'M')
{
    $spreadsheet = IOFactory::load($this->file);
    $sheet = $spreadsheet->getActiveSheet();

    // Always find the last row and add after it
    $lastRow = $sheet->getHighestRow() + 1;

    // Get the highest column in the sheet (to know range)
    $highestColumn = $sheet->getHighestColumn();
    $allColumns = range('A', $highestColumn);

    // Find starting index for the column
    $startIndex = array_search(strtoupper($startColumn), $allColumns);
    if ($startIndex === false) $startIndex = 0;

    // Use only as many columns as we have data for
    $columns = array_slice($allColumns, $startIndex, count($row));

    // Insert row data at the end
    foreach ($columns as $i => $col) {
        $sheet->setCellValue($col . $lastRow, $row[$i] ?? null);
    }

    // Save back
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($this->file);
}


    public function updateRow($rowNumber, $row)
    {
        $spreadsheet = IOFactory::load($this->file);
        $sheet = $spreadsheet->getActiveSheet();
        $col = 'A';
        foreach($row as $value) {
            $sheet->setCellValue($col . $rowNumber, $value);
            $col++;
        }
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($this->file);
    }

    public function deleteRow($rowNumber)
    {
        $spreadsheet = IOFactory::load($this->file);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->removeRow($rowNumber);
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($this->file);
    }
}
