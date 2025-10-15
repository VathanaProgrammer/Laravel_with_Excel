<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelService;

class ProductController extends Controller
{

    private $excel;

    public function __construct()
    {
        $this->excel = new ExcelService();
    }
    //

    // 🔹 Show edit form
    public function edit($code)
    {
        $products = $this->excel->read();
        $product = collect($products)->firstWhere('code', $code);

        if (!$product) {
            abort(404, 'Product not found');
        }

        return view('edit_product', compact('product'));
    }
    public function update(Request $request, $code){
        $request->validate([
            'code' => 'required|numeric', // must be a number
            'productNameEn' => 'required|string|max:255',
            'productNameKh' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'last_price' => 'required|numeric|min:0',
            'new_price' => 'required|numeric|min:0',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ], [
            'code.required' => 'Product code is required',
            'code.numeric' => 'Product code must be a number',
            'productNameEn.required' => 'Product Name (EN) is required',
            'productNameKh.required' => 'Product Name (KH) is required',
            'unit.required' => 'Unit is required',
            'last_price.required' => 'Last price is required',
            'last_price.numeric' => 'Last price must be a number',
            'last_price.min' => 'Last price must be at least 0',
            'new_price.required' => 'New price is required',
            'new_price.numeric' => 'New price must be a number',
            'new_price.min' => 'New price must be at least 0',
            'image_url.image' => 'File must be an image',
            'image_url.mimes' => 'Image must be jpeg, png, jpg, gif or webp',
            'image_url.max' => 'Image size must be less than 2MB'
        ]);

        // Find the row in Excel by product code
        $result = $this->excel->findRowByCode($code); 
        if (!$result) {
            return redirect()->route('inventory')->with('error', 'Product not found');
        }

        $rowNumber = $result['rowNumber'];
        $oldRow = $result['data'];
        $oldImageUrl = $oldRow[7] ?? null; // column H = image

        // Handle new image upload
        $imageUrl = null;
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $path = $image->store('products', 'public');
            $imageUrl =  $path;
        }

        // Keep old image if no new one
        if (!$imageUrl) {
            $imageUrl = $oldImageUrl;
        }

        // Prepare updated row (columns A→H)
        $updatedRow = [
            $code,
            $request->productNameEn,
            '', // extra
            $request->productNameKh,
            $request->unit,
            $request->old_price,
            $request->new_price,
            $imageUrl // keep old image if no new
        ];

        // Update Excel
        $this->excel->updateRow($rowNumber, $updatedRow);
        return redirect()->route('inventory')->with('success', 'Product updated successfully!');
    }

    public function index(){
        $nextCode = $this->excel->getNextProductCode();

        return view('add_product', compact('nextCode'));
    }

    public function store(Request $request){
        $request->validate([
            'code' => 'required|numeric', // must be a number
            'productNameEn' => 'required|string|max:255',
            'productNameKh' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'last_price' => 'required|numeric|min:0',
            'new_price' => 'required|numeric|min:0',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ], [
            'code.required' => 'Product code is required',
            'code.numeric' => 'Product code must be a number',
            'productNameEn.required' => 'Product Name (EN) is required',
            'productNameKh.required' => 'Product Name (KH) is required',
            'unit.required' => 'Unit is required',
            'last_price.required' => 'Last price is required',
            'last_price.numeric' => 'Last price must be a number',
            'last_price.min' => 'Last price must be at least 0',
            'new_price.required' => 'New price is required',
            'new_price.numeric' => 'New price must be a number',
            'new_price.min' => 'New price must be at least 0',
            'image_url.image' => 'File must be an image',
            'image_url.mimes' => 'Image must be jpeg, png, jpg, gif or webp',
            'image_url.max' => 'Image size must be less than 2MB'
        ]);

        $imageUrl = null;
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('products', 'public');
            $imageUrl = $path;
        }

        $row = [
            $request->code,
            $request->productNameEn,
            '', // extra column
            $request->productNameKh,
            $request->unit,
            $request->last_price,
            $request->new_price,
            $imageUrl,
        ];


        $this->excel->addRow($row);

        return redirect()->route('inventory')->with('success', 'Product added successfully!');
    }

    public function test() {
        return back()->with('success', 'This is a test notification!');
    }
}
