<?php
namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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
    /**
     * Read Excel data (reads ALL rows if no limit given)
     */
    public function read($sheetName = null, $startRow = 1, $startColumn = 0, $endColumn = null, $expectedColumns = null, $limit = null)
    {
        ini_set('memory_limit', '2048M'); // prevent memory crash

        $spreadsheet = IOFactory::load($this->file);

        // Choose sheet
        $sheet = ($sheetName && $spreadsheet->sheetNameExists($sheetName))
            ? $spreadsheet->getSheetByName($sheetName)
            : $spreadsheet->getActiveSheet();

        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        // ✅ If limit is not set, read until the last row
        $lastRow = $limit ? min($highestRow, $startRow + $limit - 1) : $highestRow;

        $range = "A{$startRow}:{$highestColumn}{$lastRow}";
        $rows = $sheet->rangeToArray($range, null, true, true, false);

        if (empty($rows)) return [];

        $keys = [
            'code', 'name_en', 'extra', 'name_kh', 'unit',
            'old_price', 'new_price', 'image_url'
        ];

        if ($expectedColumns === null) {
            $expectedColumns = count($keys);
        }

        $data = [];
        foreach ($rows as $row) {
            $rowData = array_slice($row, $startColumn, $endColumn !== null ? $endColumn - $startColumn + 1 : null);

            // Clean invisible or weird characters
            $rowData = array_map(function ($v) {
                if (is_string($v)) {
                    $v = trim($v);
                    $v = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $v);
                }
                return $v;
            }, $rowData);

            // Pad row to match expected columns
            // Trim or pad rowData to match keys length
            $rowData = array_slice($rowData, 0, count($keys));
            $rowData = array_pad($rowData, count($keys), null);

            // Skip empty rows
            if (count(array_filter($rowData)) === 0) continue;

            $data[] = array_combine($keys, $rowData);
        }

        return $data;
    }

    public function findLastProductRowByCode($startRow = 10, $codeColumn = 'A'){
        $spreadsheet = IOFactory::load($this->file);
        $sheet = $spreadsheet->getActiveSheet();

        // PhpSpreadsheet built-in method: last row with actual data in column A
        $highestRow = $sheet->getHighestDataRow($codeColumn);

        for ($r = $highestRow; $r >= $startRow; $r--) {
            $val = trim((string)$sheet->getCell($codeColumn . $r)->getValue());
            if ($val === '') continue;

            if (preg_match('/\d+/', $val, $m)) {
                return $r; // return immediately the first numeric code from bottom
            }
        }

        return $startRow - 1; // no products found
    }

    public function getNextProductCode($startRow = 10, $codeColumn = 'A'){
        $lastRow = $this->findLastProductRowByCode($startRow, $codeColumn);
        if ($lastRow < $startRow) return 1;

        $spreadsheet = IOFactory::load($this->file);
        $sheet = $spreadsheet->getActiveSheet();
        $val = trim((string)$sheet->getCell($codeColumn . $lastRow)->getValue());

        if (preg_match('/\d+/', $val, $m)) {
            return (int)$m[0] + 1;
        }

        return 1;
    }

    /**
     * Remove trailing entirely-empty rows (A-H all empty) — cleans ghost formatting below your data.
     * BE CAREFUL: This actually modifies file.
     */
    public function removeTrailingEmptyRows($startRow = 10, $startCol = 'A', $endCol = 'H')
    {
        $spreadsheet = IOFactory::load($this->file);
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = (int)$sheet->getHighestRow();

        for ($r = $highestRow; $r >= $startRow; $r--) {
            $allEmpty = true;
            foreach (range($startCol, $endCol) as $col) {
                $v = trim((string)$sheet->getCell($col . $r)->getValue());
                if ($v !== '') { $allEmpty = false; break; }
            }
            if ($allEmpty) {
                // remove this row — shift everything up
                $sheet->removeRow($r);
            } else {
                // stop at first non-empty row when scanning from bottom
                break;
            }
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($this->file);
    }

    /**
     * Debug helper — returns row contents from $from to $to for quick inspection
     */
    public function debugRange($from = 970, $to = 1000, $cols = ['A','B','C','D','E','F','G','H'])
    {
        $spreadsheet = IOFactory::load($this->file);
        $sheet = $spreadsheet->getActiveSheet();
        $out = [];
        for ($r = $from; $r <= $to; $r++) {
            $row = [];
            $isEmpty = true;
            foreach ($cols as $c) {
                $v = $sheet->getCell($c . $r)->getValue();
                $row[$c] = $v;
                if (trim((string)$v) !== '') $isEmpty = false;
            }
            $out[$r] = ['empty' => $isEmpty, 'cells' => $row];
        }
        return $out; // call with dd($this->excel->debugRange(...)) in controller
    }

public function addRow(array $row)
{
    $spreadsheet = IOFactory::load($this->file);
    $sheet = $spreadsheet->getActiveSheet();

    $startRow = 10;

    // Find last real product row
    $lastRow = $this->findLastProductRowByCode($startRow, 'A', ['B','D']);
    $rowNumber = $lastRow ? $lastRow + 1 : $startRow;

    $col = 'A';
    foreach ($row as $value) {
        $sheet->setCellValue($col . $rowNumber, $value);

        // Apply Accounting format for F & G (last_price, new_price)
        if ($col === 'F' || $col === 'G') {
            $sheet->getStyle($col . $rowNumber)
                  ->getNumberFormat()
                  ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
        }

        $col++;
    }

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($this->file);
}


   public function updateRow($rowNumber, $row, $ignoreNulls = false){

        $spreadsheet = IOFactory::load($this->file);
        $sheet = $spreadsheet->getActiveSheet();
        $col = 'A';

        foreach ($row as $value) {
            if ($ignoreNulls && $value === null) {
                $col++;
                continue;
            }
            
            if (is_array($value)) {
                $value = implode(', ', $value); // convert array to string
            }

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

    public function findRowByCode($code){
        $spreadsheet = IOFactory::load($this->file);
        $sheet = $spreadsheet->getActiveSheet();

        $startRow = 10; // products start at row 10
        $highestRow = $sheet->getHighestRow();
        $columns = range('A', 'H'); // columns A-H

        for ($row = $startRow; $row <= $highestRow; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue(); // column A = code
            if ($cellValue == $code) {
                // collect data from A-H
                $data = [];
                foreach ($columns as $col) {
                    $data[] = $sheet->getCell($col . $row)->getValue();
                }
                return ['rowNumber' => $row, 'data' => $data];
            }
        }

        return null; // not found
    }
}
