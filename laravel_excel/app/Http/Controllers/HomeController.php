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
    public function index(Request $request){
        $search = request()->query('search');

        // Read all products from Excel — no limit
        $allProducts = $this->excel->read("products", 10, 0, 7, 8, 1000000);

        // If searching, filter
        if ($search) {
            $allProducts = array_filter($allProducts, function($p) use ($search) {
                return str_contains(strtolower($p['name_en']), strtolower($search)) ||
                    str_contains(strtolower($p['name_kh']), strtolower($search)) ||
                    str_contains(strtolower($p['code']), strtolower($search));
            });
        }

    // AJAX request: return only partial
    if ($request->ajax()) {
        return view('partials.product-cards', ['products' => $allProducts])->render();
    }

        // Return all (no pagination, no load more)
        return view('inventory', [
            'products' => $allProducts,
            'page' => 1,
            'isSearch' => false
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
