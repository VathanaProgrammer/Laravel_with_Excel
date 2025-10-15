@extends('layout')

@section('content')
<header class="flex justify-between items-center mb-6">
    <a href="{{ route('inventory') }}"
        class="bg-[#8501D8] text-md font-medium text-white max-w-[250px] px-2 py-2 rounded flex justify-center items-center">
        <span class="iconify text-white mr-1" data-icon="ion:chevron-back-outline"></span>
    </a>
    <h1 class="text-2xl font-bold text-gray-700">Add New Product</h1>
</header>

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
    class="w-full h-full flex flex-col md:flex-row justify-between md:mt-16 flex-1">
    @csrf

    <div class="w-full">
        <!-- CODE -->
        <div class="mb-6">
            <label for="code" class="block text-gray-600 text-md font-semibold mb-2">CODE:</label>
            <input type="text" id="code" name="code" value="{{ old('code', $nextCode) }}" readonly
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                      focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]" required>
            @error('code')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Product Name EN -->
        <div class="mb-6">
            <label for="productNameEn" class="block text-gray-600 text-md font-semibold mb-2">Product Name (EN):</label>
            <input type="text" id="productNameEn" name="productNameEn" value="{{ old('productNameEn') }}"
                class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:ring-2 focus:ring-[#8501D8]" required>
            @error('productNameEn')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Product Name KH -->
        <div class="mb-6">
            <label for="productNameKh" class="block text-gray-600 text-md font-semibold mb-2">Product Name (KH):</label>
            <input type="text" id="productNameKh" name="productNameKh" value="{{ old('productNameKh') }}"
                class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:ring-2 focus:ring-[#8501D8]" required>
            @error('productNameKh')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Unit -->
        <div class="mb-6">
            <label for="unit" class="block text-gray-600 text-md font-semibold mb-2">Unit:</label>
            <input type="text" id="unit" name="unit" value="{{ old('unit') }}"
                class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:ring-2 focus:ring-[#8501D8]" required>
            @error('unit')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Last Price -->
        <div class="mb-6">
            <label for="last_price" class="block text-gray-600 text-md font-semibold mb-2">Last Price:</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                <input type="number" id="last_price" name="last_price" step="0.01" min="0" 
                    value="{{ old('last_price') }}"
                    class="shadow border rounded w-full py-2 pl-7 pr-3 text-gray-700 focus:ring-2 focus:ring-[#8501D8]">
            </div>
            @error('last_price')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Price -->
        <div class="mb-6">
            <label for="new_price" class="block text-gray-600 text-md font-semibold mb-2">New Price:</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                <input type="number" id="new_price" name="new_price" step="0.01" min="0" 
                    value="{{ old('new_price') }}"
                    class="shadow border rounded w-full py-2 pl-7 pr-3 text-gray-700 focus:ring-2 focus:ring-[#8501D8]">
            </div>
            @error('new_price')
                <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Right Side -->
    <div class="w-full flex flex-col justify-between items-center rounded-lg px-4">
        <label class="block text-gray-600 text-md font-semibold mb-2">Product Image:</label>
        <input type="file" name="image_url" id="image_url" accept="image/*" class="hidden">
        <div
            class="flex justify-center items-center border-2 border-dashed border-gray-300 rounded-lg w-full h-[300px] mb-4 cursor-pointer">
            <img id="imagePreview" 
                src="{{ old('image_url') ? asset('storage/' . old('image_url')) : Vite::asset('resources/images/3.jpg') }}" 
                class="h-full object-contain" alt="Product Image" title="Click to choose image">
        </div>
        @error('image_url')
            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
        @enderror

        <button class="w-full bg-[#8501D8] mb-6 text-white text-lg py-2 font-bold rounded hover:bg-[#6c02ad] transition"
            type="submit">
            Save Product
        </button>
    </div>
</form>

<script>
    const imageInput = document.getElementById('image_url');
    const imagePreview = document.getElementById('imagePreview');

    // Trigger file input when image clicked
    imagePreview.addEventListener('click', () => {
        imageInput.click();
    });

    // Update preview when file selected
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "{{ Vite::asset('resources/images/3.jpg') }}";
        }
    });
</script>
@endsection
