{{-- sale.blade.php --}}
@extends('layout')

@section('content')
    <header class="flex justify-between items-center mb-6">
        <p id="match-count" class=" text-gray-600 font-medium"></p>
        <div id="searchWrapper" class="relative min-w-[250px] max-w-[350px]">
            <input type="text" id="search-input" placeholder="Search products"
                class="w-full border text-gray-800 text-md pr-10 font-semibold focus:border-[#fff] border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#8501D8]">
            <span class="iconify text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2"
                data-icon="ic:round-search" data-width="20" data-height="20"></span>
        </div>
    </header>

    <section id="product-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2">
        @include('partials.product-sale-card')
    </section>
    <div id="overlay-loader" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center hidden">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
@endsection

@section('right-panel')
    <form action="" class="h-full flex flex-col">
        <h2 class="text-xl font-bold mb-4 text-center text-white">Order Panel</h2>

        <!-- Table for order items -->
        <div class="flex-1 overflow-y-auto mb-4">
            <table class="w-full table-auto">
                <thead class="bg-white sticky top-0">
                    <tr>
                        <th class="border px-3 py-2 text-left">Name</th>
                        <th class="border px-3 py-2 text-center">Qty</th>
                        <th class="border px-3 py-2 text-right">Price</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @for ($i = 0; $i < 31; $i++)
                        @php
                            $displayEn = "Chilli Red Hot Small (Bird Eye) $i";
                            $nameKh = "ក្រូចពោធិសាត់​ (បាត់តំបង) $i";
                            $maxLength = 15;
                            $displayEn =
                                strlen($nameEn) > $maxLength ? substr($nameEn, 0, $maxLength) . '...' : $nameEn;
                            $displayKh =
                                mb_strlen($nameKh, 'UTF-8') > $maxLength
                                    ? mb_substr($nameKh, 0, $maxLength, 'UTF-8') . '...'
                                    : $nameKh;

                            $quantity = 12;
                        @endphp

                        <tr class="hover:bg-gray-500 text-white">
                            <!-- Name column -->
                            <td class="border-b px-3 py-2 text-[16px] font-medium">
                                <div class="flex flex-col">
                                    <span title="{{ $nameEn }}"
                                        class="font-semibold truncate">{{ $displayEn }}</span>
                                    <span title="{{ $nameKh }}"
                                        class="text-sm text-gray-200 truncate">{{ $displayKh }}</span>
                                </div>
                            </td>

                            <!-- Quantity column with + / - buttons and input -->
                            <td class="border-b px-1 py-1 text-center">
                                <div class="flex items-center justify-center">
                                    <!-- Minus button -->
                                    <button type="button"
                                        class="shrink-0 bg-gray-700 hover:bg-gray-600 inline-flex items-center justify-center rounded-md h-6 w-6 focus:outline-none"
                                        onclick="this.nextElementSibling.stepDown(); this.nextElementSibling.dispatchEvent(new Event('input'))">
                                        -
                                    </button>

                                    <!-- Number input -->
                                    <input type="text" min="0" value="{{ $quantity }}" data-input-counter
                                        class="quantity-input shrink-0 w-12 text-center bg-transparent text-white border-0 focus:outline-none focus:ring-0"
                                        data-price="12.00">

                                    <!-- Plus button -->
                                    <button type="button"
                                        class="shrink-0 bg-gray-700 hover:bg-gray-600 inline-flex items-center justify-center rounded-md h-6 w-6 focus:outline-none"
                                        onclick="this.previousElementSibling.stepUp(); this.previousElementSibling.dispatchEvent(new Event('input'))">
                                        +
                                    </button>
                                </div>
                            </td>
                            <td class="border-b px-1 py-2 text-right break-all">
                                $<span>1237.00</span>
                            </td>
                        </tr>
                    @endfor --}}
                </tbody>

            </table>
        </div>

        <!-- Total and Submit -->
        <div class="mt-auto">
            <div class="flex justify-between items-center mb-4 px-2">
                <span class="font-bold text-white">Total:</span>
                <span class="font-bold text-green-400 text-lg" id="total">$1200.00</span>
            </div>
            <div class="flex justify-center w-full mb-2">
                <button id="preview-btn"
                    class="min-w-[150px] w-[250px] bg-[#fff] text-gray-800 py-2 rounded-lg font-bold hover:bg-gray-400 transition">
                    Continue
                </button>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('product-container');
            const overlayLoader = document.getElementById('overlay-loader');
            const searchInput = document.getElementById('search-input');
            const matchCount = document.getElementById('match-count');

            function fetchProducts(search = '') {
                overlayLoader.classList.remove('hidden');

                fetch(`/sale?search=${encodeURIComponent(search)}`, {
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

            const wrapper = document.getElementById('searchWrapper');
            const offsetTop = wrapper.offsetTop;
            const originalWidth = wrapper.offsetWidth + 'px';
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > offsetTop) {
                    wrapper.style.position = 'fixed';
                    wrapper.style.top = '10px';
                    wrapper.style.width = originalWidth;
                    wrapper.style.zIndex = '50';
                    wrapper.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
                } else {
                    wrapper.style.position = 'relative';
                    wrapper.style.width = '';
                    wrapper.style.top = '';
                    wrapper.style.zIndex = '';
                    wrapper.style.boxShadow = '';
                }
            });

            const orderTableBody = document.querySelector("table tbody");
            const totalDisplay = document.getElementById("total");

            function updateTotal() {
                let total = 0;
                orderTableBody.querySelectorAll("tr").forEach(row => {
                    const price = parseFloat(row.querySelector(".price").textContent) || 0;
                    const qty = parseInt(row.querySelector(".quantity-input").value) || 0;
                    total += price * qty;
                });
                totalDisplay.textContent = `$${total.toFixed(2)}`;
            }

            // 🔹 Helper function to truncate text (English + Khmer)
            function truncateText(selector, maxLength) {
                document.querySelectorAll(selector).forEach(el => {
                    const text = el.textContent.trim();
                    if (text.length > maxLength) {
                        el.textContent = text.substring(0, maxLength) + '...';
                    }
                });
            }

            // When product is clicked
            container.addEventListener("click", e => {
                const card = e.target.closest(".product-card");
                if (!card) return;

                const id = card.dataset.id;
                const nameEn = card.dataset.name_en;
                const nameKh = card.dataset.name_kh;
                const price = parseFloat(card.dataset.price.replace("$", "").trim());

                // Shorten product names before inserting into table
                const displayEn = nameEn.length > 15 ? nameEn.substring(0, 15) + '...' : nameEn;
                const displayKh = nameKh.length > 15 ? nameKh.substring(0, 15) + '...' : nameKh;

                // Check if already exists in order
                let existingRow = orderTableBody.querySelector(`tr[data-id='${id}']`);
                if (existingRow) {
                    let qtyInput = existingRow.querySelector(".quantity-input");
                    qtyInput.value = parseInt(qtyInput.value) + 1;
                    updateTotal();
                    return;
                }

                // Create new row
                const tr = document.createElement("tr");
                tr.dataset.id = id;
                tr.dataset.name_en = nameEn; // full text
                tr.dataset.name_kh = nameKh; // full text
                tr.className = "hover:bg-gray-500 text-white";
                tr.innerHTML = `
                                <td class="border-b px-3 py-2 text-[16px] font-medium">
                                    <div class="flex flex-col">
                                        <span data-name_en class="en_lang font-semibold truncate" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">${displayEn}</span>
                                        <span data-name_kh class="kh_lang text-sm khmer font-bold text-gray-200 truncate">${displayKh}</span>
                                    </div>
                                </td>
                                <td class="border-b px-1 py-1 text-center">
                                    <div class="flex items-center justify-center">
                                        <button type="button" class="decrease bg-gray-700 hover:bg-gray-600 rounded-md h-6 w-6">-</button>
                                        <input type="text" value="1" class="quantity-input shrink-0 w-12 text-center bg-transparent text-white border-0">
                                        <button type="button" class="increase bg-gray-700 hover:bg-gray-600 rounded-md h-6 w-6">+</button>
                                    </div>
                                </td>
                                <td class="border-b px-1 py-2 text-right break-all">
                                    $<span class="price">${price.toFixed(2)}</span>
                                </td>
                            `;
                orderTableBody.appendChild(tr);
                updateTotal();
            });

            // Handle + / - buttons
            orderTableBody.addEventListener("click", e => {
                const row = e.target.closest("tr");
                if (!row) return;
                const qtyInput = row.querySelector(".quantity-input");

                if (e.target.classList.contains("increase")) {
                    qtyInput.value = parseInt(qtyInput.value) + 1;
                } else if (e.target.classList.contains("decrease")) {
                    if (qtyInput.value == 1) {
                        row.remove();
                    } else {
                        qtyInput.value = Math.max(1, parseInt(qtyInput.value) - 1);
                    }

                }
                updateTotal();
            });

            // Detect when user types directly into the quantity input
            orderTableBody.addEventListener("input", e => {
                if (e.target.classList.contains("quantity-input")) {
                    let val = parseInt(e.target.value);

                    // Prevent invalid values (like 0 or negative or NaN)
                    if (isNaN(val) || val < 1) val = 1;

                    e.target.value = val;
                    updateTotal();
                }
            });


            // Order button to preview Area

            const previewButton = document.getElementById("preview-btn");

            previewButton.addEventListener('click', function(e) {
                e.preventDefault();

                const rows = orderTableBody.querySelectorAll("tr");
                const items = [];

                rows.forEach(row => {
                    const code = row.dataset.id;
                    const nameEn = row.dataset.name_en;
                    const nameKh = row.dataset.name_kh;
                    const qty = parseInt(row.querySelector(".quantity-input").value) || 0;
                    const price = parseFloat(row.querySelector(".price").textContent) || 0;

                    if (qty > 0) {
                        items.push({
                            code,
                            nameEn,
                            nameKh,
                            qty,
                            price
                        });
                    }
                });

                if (items.length === 0) {
                    toastr.error("Please select at least one product.");
                    return;
                }

                fetch("{{ route('invoice-preview') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items
                        })
                    })
                    .then(res => {
                        if (res.ok) window.location.href = "{{ route('invoice-preview') }}";
                    })
                    .catch(err => console.error(err));
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
