<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //
    public function index(Request $request){
        
        $items = session('invoice_items', []);

        $grandTotal = collect($items)->sum(fn($item) => $item['qty'] * $item['price']);
        return view('invoice-preview', compact('items', 'grandTotal'));
    }

        // Store selected items in session
    public function storeSession(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
        ]);

        session(['invoice_items' => $request->items]);

        return response()->json(['status' => 'success']);
    }
}
