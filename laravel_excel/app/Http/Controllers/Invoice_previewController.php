<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Invoice_previewController extends Controller
{
    //
    public function index(Request $request){
        return view("invoice-preview");
    }
}
