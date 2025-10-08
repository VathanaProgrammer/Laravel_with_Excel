@extends('layout')
@section('content')
    <header class="flex justify-between items-center mb-6">
        <a href="{{ route('inventory') }}"
            class="bg-[#8501D8] text-md font-medium text-white max-w-[250px] px-2 py-2 rounded flex justify-center items-center">
            <span class="iconify text-white mr-1" data-icon="ion:chevron-back-outline" data-width="24" data-height="24"></span>
        </a>
        <h1 class="text-2xl font-bold text-gray-700">Add New Product</h1>
    </header>

    <form action="" class="w-full h-full flex flex-col md:flex-row justify-between md:mt-16 flex-1">
        <div class="w-full">
            <!-- CODE -->
            <div class="mb-6">
                <label for="code" class="block text-gray-600 text-md font-semibold mb-2">CODE:</label>
                <input type="number" id="code" name="code" placeholder="Auto Generated"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                           focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    disabled>
            </div>

            <!-- Product Name EN -->
            <div class="mb-6">
                <label for="productNameEn" class="block text-gray-600 text-md font-semibold mb-2">Product Name (EN):</label>
                <input type="text" id="productNameEn" name="productNameEn" placeholder="Enter product name in English"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                           focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
            </div>

            <!-- Product Name KH -->
            <div class="mb-6">
                <label for="productNameKh" class="block text-gray-600 text-md font-semibold mb-2">Product Name (KH):</label>
                <input type="text" id="productNameKh" name="productNameKh" placeholder="Enter product name in Khmer"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                           focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
            </div>

            <!-- Unit -->
            <div class="mb-6">
                <label for="unit" class="block text-gray-600 text-md font-semibold mb-2">Unit: </label>
                <input type="text" id="unit" name="unit" placeholder="Enter product unit (e.g., Piece, Kg)"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                           focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
            </div>

            <!-- Last Price -->
            <div class="mb-6">
                <label for="last_price" class="block text-gray-600 text-md font-semibold mb-2">Last Price: </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                    <input type="number" id="last_price" name="last_price" placeholder="Enter product last price"
                        class="shadow appearance-none border rounded w-full py-2 pl-7 pr-3 text-gray-700 leading-tight
                               focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                        required step="0.01" min="0">
                </div>
            </div>

            <!-- New Price -->
            <div class="mb-6">
                <label for="new_price" class="block text-gray-600 text-md font-semibold mb-2">New Price: </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                    <input type="number" id="new_price" name="new_price" placeholder="Enter product new price"
                        class="shadow appearance-none border rounded w-full py-2 pl-7 pr-3 text-gray-700 leading-tight
                               focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                        required step="0.01" min="0">
                </div>
            </div>
        </div>

        <!-- Right Side (Image + Save Button) -->
        <div class="w-full flex flex-col justify-between items-center rounded-lg px-4">
            <!-- Label -->
            <label for="product_image" class="block text-gray-600 text-md font-semibold mb-2">
                Product Image:
            </label>

            <!-- Image Preview -->
            <div class="flex justify-center items-center border-2 border-dashed border-gray-300 rounded-lg w-full h-[350px]">
                <img src="{{ Vite::asset('resources/images/2.jpg') }}"
                    class="h-[300px] w-[300px] rounded-lg object-cover my-4" alt="Product Image">
            </div>

            <!-- Button -->
            <button class="w-full bg-[#8501D8] text-white text-lg py-2 font-bold rounded hover:bg-[#6c02ad] transition"
                type="submit">
                Save Product
            </button>
        </div>
    </form>
@endsection
