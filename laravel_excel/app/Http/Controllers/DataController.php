<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Services\ExcelService;

class DataController extends Controller
{

     private $excel;

    public function __construct()
    {
        $this->excel = new ExcelService();
    }
        // Add a new row
    public function store(Request $request)
    {
        $rowData = [
            $request->name,
            $request->price,
            $request->qty
        ];

        // Add row starting at next empty row, column B, ending at column D
        $this->excel->addRow($rowData);

        return redirect()->back()->with('success', 'Row added!');
    }
}
