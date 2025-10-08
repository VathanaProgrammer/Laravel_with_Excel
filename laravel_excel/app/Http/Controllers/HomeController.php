<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelService;

class HomeController extends Controller
{
    private $excel;

    public function __construct()
    {
        $this->excel = new ExcelService();
    }
        
    //
public function index($page = 1)
{
    $perPage = 100;
    $startRow = 10 + ($page - 1) * $perPage;

    $search = request()->query('search');

    if ($search) {
        // Search all rows
        $allProducts = $this->excel->read("products", 10, 0, 7, 8); // read ALL
        $filtered = array_filter($allProducts, function($p) use ($search) {
            return str_contains(strtolower($p['name_en']), strtolower($search)) ||
                   str_contains(strtolower($p['name_kh']), strtolower($search)) ||
                   str_contains(strtolower($p['code']), strtolower($search));
        });
        dd($filtered);
        return view('inventory', [
            'products' => $filtered,
            'page' => 1
        ]);
    }

    // Normal pagination
    $products = $this->excel->read("products", $startRow, 0, 7, 8);

    return view('inventory', [
        'products' => $products,
        'page' => $page
    ]);
}





    public function loadMoreProducts($page)
    {
        $perPage = 100;
        $startRow = 10 + ($page - 1) * $perPage;

        $products = $this->excel->read("products", $startRow, 0, 7, 8);

        // Check if there are more products after this page
        $highestRow = IOFactory::load($this->excel->file)->getSheetByName('products')->getHighestRow();
        $hasMore = ($startRow + $perPage - 1) < $highestRow;

        return response()->json([
            'products' => $products,
            'has_more' => $hasMore,
        ]);
    }

}
