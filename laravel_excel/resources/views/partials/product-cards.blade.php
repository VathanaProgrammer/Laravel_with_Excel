{{-- resources/views/partials/product-cards.blade.php --}}
@foreach ($products as $product)
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-1 overflow-hidden hover:shadow-md transition-shadow">
            <div class="relative w-full h-40 flex items-center justify-center">
                <img src="{{ $product['image_url'] ? asset('storage/' . $product['image_url']) : Vite::asset('resources/images/3.jpg') }}" alt="Product Image"
                     class="object-cover h-full w-full rounded-2xl">
            </div>
            <div class="p-4 space-y-2">
                <p class="text-md text-gray-500 font-medium">Code: <span class="text-yellow-600">{{ $product['code'] }}</span></p>
                <h2 class="text-lg font-semibold text-gray-900 overflow-hidden text-ellipsis"
                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"
                    title="{{ $product['name_en'] }}">
                    {{ $product['name_en'] }}
                </h2>
                <h3 class="text-md khmer font-bold text-gray-600 overflow-hidden text-ellipsis"
                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"
                    title="{{ $product['name_kh'] }}">
                    {{ $product['name_kh'] }}
                </h3>
                <div class="flex items-center space-x-2">
                    @if ($product['new_price'])
                        <p class="text-sm line-through text-gray-400">{{ $product['old_price'] }}</p>
                        <p class="text-lg font-bold text-[#8501D8]">{{ $product['new_price'] }}</p>
                    @else
                        <p class="text-lg font-bold text-[#8501D8]">{{ $product['old_price'] }}</p>
                    @endif
                </div>
                <p class="text-sm text-gray-500">Unit: <span class="font-medium text-gray-800">{{ $product['unit'] }}</span></p>
                <div class="pt-3">
                    <a href="{{ route('edit_product', [ $product['code']])}}" class="w-full inline-flex justify-center items-center px-3 py-2 rounded-lg bg-[#8501D8] text-white text-sm font-medium hover:bg-[#6c02ad] transition">
                        <span class="iconify mr-2" data-icon="mdi:edit" data-width="18" data-height="18"></span>
                        Edit
                    </a>
                </div>
            </div>
        </div>
@endforeach
