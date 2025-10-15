@extends('layout')

@section('content')
    <header class="flex justify-between items-center mb-6">
        <a href="{{ route('inventory') }}"
            class="bg-[#8501D8] text-md font-medium text-white max-w-[250px] px-2 py-2 rounded flex justify-center items-center">
            <span class="iconify text-white mr-1" data-icon="ion:chevron-back-outline" data-width="24" data-height="24"></span>
        </a>
        <h1 class="text-2xl font-bold text-gray-700">Edit Product</h1>
    </header>

    <form action="{{ route('update_product', ['code' => $product['code']]) }}" method="POST" enctype="multipart/form-data"
        class="w-full h-full flex flex-col md:flex-row justify-between md:mt-16 flex-1">
        @csrf
        @method('PUT')

        <!-- Left Side -->
        <div class="w-full md:w-1/2">
            <!-- CODE -->
            <div class="mb-6">
                <label for="code" class="block text-gray-600 text-md font-semibold mb-2">CODE:</label>
                <input type="text" id="code" name="code" value="{{ old('code', $product['code']) }}" readonly
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8] bg-gray-100">
            </div>

            <!-- Product Name EN -->
            <div class="mb-6">
                <label for="productNameEn" class="block text-gray-600 text-md font-semibold mb-2">Product Name (EN):</label>
                <input type="text" id="productNameEn" name="productNameEn"
                    value="{{ old('productNameEn', $product['name_en']) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('productNameEn')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Name KH -->
            <div class="mb-6">
                <label for="productNameKh" class="block text-gray-600 text-md font-semibold mb-2">Product Name (KH):</label>
                <input type="text" id="productNameKh" name="productNameKh"
                    value="{{ old('productNameKh', $product['name_kh']) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('productNameKh')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Unit -->
            <div class="mb-6">
                <label for="unit" class="block text-gray-600 text-md font-semibold mb-2">Unit:</label>
                <input type="text" id="unit" name="unit" value="{{ old('unit', $product['unit']) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('unit')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Last Price -->
            <div class="mb-6">
                <label for="old_price" class="block text-gray-600 text-md font-semibold mb-2">Last Price:</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                    <input type="number" id="old_price" name="last_price" step="0.01" min="0"
                        value="{{ old('old_price', str_replace(['$', ' '], '', $product['old_price'])) }}"
                        class="shadow appearance-none border rounded w-full py-2 pl-7 pr-3 text-gray-700 leading-tight
                      focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]">
                </div>
                @error('old_price')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Price -->
            <div class="mb-6">
                <label for="new_price" class="block text-gray-600 text-md font-semibold mb-2">New Price:</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                    <input type="number" id="new_price" name="new_price" step="0.01" min="0"
                        value="{{ old('new_price', str_replace(['$', ' '], '', $product['new_price'])) }}"
                        class="shadow appearance-none border rounded w-full py-2 pl-7 pr-3 text-gray-700 leading-tight
                      focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]">
                </div>
                @error('new_price')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Right Side -->
        <div class="w-full md:w-1/2 flex flex-col justify-between items-center rounded-lg px-4">
            <label for="image_url" class="block text-gray-600 text-md font-semibold mb-2">Product Image:</label>

            <div
                class="flex justify-center items-center border-2 border-dashed border-gray-300 rounded-lg w-full h-[350px] relative">
                <img id="imagePreview"
                    src="{{ old('image_url') ? asset('storage/' . old('image_url')) : ($product['image_url'] ? asset('storage/' . $product['image_url']) : Vite::asset('resources/images/3.jpg')) }}"
                    class="h-[300px] w-[300px] rounded-lg object-cover my-4" alt="Product Image">
                <input type="file" id="image_url" name="image_url" class="absolute inset-0 opacity-0 cursor-pointer"
                    accept="image/*" onchange="previewImage(event)">
            </div>
            @error('image_url')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror

            <button class="w-full bg-[#8501D8] text-white text-lg py-2 mb-6 font-bold rounded hover:bg-[#6c02ad] transition"
                type="submit">
                Save Product
            </button>
        </div>
        <div id="overlay-loader"
            class="fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center hidden">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </form>

   <script>
    // Image preview (already there)
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const img = document.getElementById('imagePreview');
            img.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // Show overlay and disable submit on form submit
    const form = document.querySelector('form'); // your update form
    const overlay = document.getElementById('overlay-loader');

    form.addEventListener('submit', function(e) {
        overlay.classList.remove('hidden'); // show overlay
        form.querySelector('button[type="submit"]').disabled = true; // prevent double click
    });
</script>

    <style>
        .spinner {
            width: 70px;
            text-align: center;
        }

        .spinner>div {
            width: 18px;
            height: 18px;
            background-color: #fff;
            border-radius: 100%;
            display: inline-block;
            animation: sk-bouncedelay 1.4s infinite ease-in-out both;
        }

        .spinner .bounce1 {
            animation-delay: -0.32s;
        }

        .spinner .bounce2 {
            animation-delay: -0.16s;
        }

        @keyframes sk-bouncedelay {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1.0);
            }
        }
    </style>
@endsection
