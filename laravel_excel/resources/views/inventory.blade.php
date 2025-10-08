@extends('layout')
@section('content')
<header class="flex justify-between items-center mb-6">
    <a href="{{ route('add_product') }}"
       class="bg-[#8501D8] min-w-[150px] text-md font-medium text-white max-w-[250px] px-4 py-2 rounded flex justify-center items-center">
        <span class="iconify text-white mr-1" data-icon="ic:sharp-plus" data-width="24" data-height="24"></span>
        New Product
    </a>
    <div class="relative min-w-[250px] max-w-[350px]">
        <input type="text" placeholder="Search products"
               class="w-full border text-gray-800 text-md pr-10 font-semibold focus:border-[#fff] border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#8501D8]">
        <span class="iconify text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2"
              data-icon="ic:round-search" data-width="20" data-height="20"></span>
    </div>
</header>

<section id="product-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach ($products as $product)
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-1 overflow-hidden hover:shadow-md transition-shadow">
            <div class="relative w-full h-40 flex items-center justify-center">
                <img src="{{ $product['image_url'] ?? Vite::asset('resources/images/3.jpg') }}" alt="Product Image"
                     class="object-cover h-full w-full rounded-2xl">
            </div>
            <div class="p-4 space-y-2">
                <p class="text-md text-gray-500 font-medium">Code: <span class="text-yellow-600">{{ $product['code'] }}</span></p>
                <h2 class="text-lg font-semibold text-gray-900 overflow-hidden text-ellipsis"
                    style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"
                    title="{{ $product['name_en'] }}">
                    {{ $product['name_en'] }}
                </h2>
                <h3 class="text-md text-gray-600 overflow-hidden text-ellipsis"
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
                    <a href="#" class="w-full inline-flex justify-center items-center px-3 py-2 rounded-lg bg-[#8501D8] text-white text-sm font-medium hover:bg-[#6c02ad] transition">
                        <span class="iconify mr-2" data-icon="mdi:edit" data-width="18" data-height="18"></span>
                        Edit
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</section>

<!-- Loader -->
<div id="overlay-loader" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center hidden">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<!-- Load More -->
@if(count($products) === 100)
<div class="flex justify-center mt-6">
    <button id="load-more" class="bg-[#8501D8] text-white px-6 py-2 rounded-lg hover:bg-[#6c02ad] transition" data-page="{{ $page }}">
        Load More
    </button>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more');
    const overlayLoader = document.getElementById('overlay-loader');
    const container = document.getElementById('product-container');
    const searchInput = document.querySelector('input[placeholder="Search products"]');
    let currentSearch = '';

    function fetchProducts(page = 1, search = '') {
        overlayLoader.classList.remove('hidden');
        const url = `/inventory/${page}${search ? '?search=' + encodeURIComponent(search) : ''}`;

        fetch(url)
            .then(res => res.text())  // GET HTML from Blade
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newProducts = doc.querySelector('#product-container').innerHTML;

                if(page === 1) container.innerHTML = ''; // clear first page or search
                container.innerHTML += newProducts;

                // Hide Load More when searching or less than 100 items
                if(search || doc.querySelectorAll('#product-container > div').length < 100) {
                    if(loadMoreBtn) loadMoreBtn.style.display = 'none';
                } else if(loadMoreBtn) {
                    loadMoreBtn.dataset.page = page;
                    loadMoreBtn.style.display = 'block';
                }

                overlayLoader.classList.add('hidden');
            })
            .catch(err => {
                console.error('Fetch error:', err);
                overlayLoader.classList.add('hidden');
            });
    }

    // Search
    searchInput.addEventListener('input', function() {
        currentSearch = this.value.trim();
        fetchProducts(1, currentSearch);
    });

    // Load More
    if(loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            let page = parseInt(this.dataset.page) + 1;
            fetchProducts(page, currentSearch);
        });
    }
});
</script>

<style>
.spinner {
  width: 70px;
  text-align: center;
}
.spinner > div {
  width: 18px;
  height: 18px;
  background-color: #fff;
  border-radius: 100%;
  display: inline-block;
  animation: sk-bouncedelay 1.4s infinite ease-in-out both;
}
.spinner .bounce1 { animation-delay: -0.32s; }
.spinner .bounce2 { animation-delay: -0.16s; }
@keyframes sk-bouncedelay { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1.0); } }
</style>
@endsection
