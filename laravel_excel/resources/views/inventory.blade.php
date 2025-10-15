@extends('layout')

@section('content')
    <header class="flex z-[9999] justify-between items-center mb-6">
        <a href="{{ route('add_product') }}"
            class="bg-[#8501D8] min-w-[150px] text-md font-medium text-white max-w-[250px] px-4 py-2 rounded flex justify-center items-center">
            <span class="iconify text-white mr-1" data-icon="ic:sharp-plus" data-width="24" data-height="24"></span>
            New Product
        </a>
        <div class="relative min-w-[250px] max-w-[350px]">
            <input id="search-input" type="text" placeholder="Search products"
                class="w-full border text-gray-800 text-md pr-10 font-semibold focus:border-[#fff] border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#8501D8]">
            <span class="iconify text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2"
                data-icon="ic:round-search" data-width="20" data-height="20"></span>
        </div>
    </header>

    <p id="match-count" class="mb-4 text-gray-600 font-medium"></p>

    <section id="product-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @include('partials.product-cards', ['products' => $products])
    </section>

    <div id="overlay-loader" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center hidden">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('product-container');
            const overlayLoader = document.getElementById('overlay-loader');
            const searchInput = document.getElementById('search-input');
            const matchCount = document.getElementById('match-count');

            function fetchProducts(search = '') {
                overlayLoader.classList.remove('hidden');

                fetch(`/inventory?search=${encodeURIComponent(search)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        container.innerHTML = html;
                        matchCount.innerText = `Products found: ${container.children.length}`;
                        overlayLoader.classList.add('hidden');
                    })
                    .catch(() => overlayLoader.classList.add('hidden'));
            }

            function debounceSearch(callback, delay) {
                let timer;
                return function(...args) {
                    clearTimeout(timer);
                    timer = setTimeout(() => callback.apply(this, args), delay);
                };
            }

            searchInput.addEventListener('input', debounceSearch(() => fetchProducts(searchInput.value.trim()),
                500));

            // Initial load
            fetchProducts();

            //header sticky\
            const header = document.querySelector('header');
            const stickyOffset = header.offsetTop;
            
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > stickyOffset) {
                    header.style.position = 'sticky';
                    header.style.top = '0';
                    header.style.width = '100%';
                    header.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
                } else {
                    header.style.position = 'static';
                    header.style.boxShadow = 'none';
                }
            });
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
