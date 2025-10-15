<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelService;

class SaleController extends Controller
{
    private $excel;

    public function __construct()
    {
        $this->excel = new ExcelService();
    }
    //
    public function index(Request $request)
    {
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
            return view('partials.product-sale-card', ['products' => $allProducts])->render();
        }

        // Return all (no pagination, no load more)
        return view('sale', [
            'products' => $allProducts,
            'page' => 1,
            'isSearch' => false
        ]);
    }
}
