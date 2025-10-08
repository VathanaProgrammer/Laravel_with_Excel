{{-- sale.blade.php --}}
@extends('layout')

@section('content')
    <header class="flex justify-end items-center mb-6">
        <div class="relative min-w-[250px] max-w-[350px]">
            <input type="text" placeholder="Search products"
                class="w-full border text-gray-800 text-md pr-10 font-semibold focus:border-[#fff] border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-[#8501D8]">
            <span class="iconify text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2"
                data-icon="ic:round-search" data-width="20" data-height="20"></span>
        </div>
    </header>

    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2">
        @for ($i = 0; $i < 12; $i++)
            <div class="bg-white rounded-2xl shadow-sm p-2 overflow-hidden hover:shadow-md transition-shadow">
                <!-- Product Image -->
                <div class="relative w-full h-40 flex items-center justify-center">
                    <img src="{{ Vite::asset('resources/images/3.jpg') }}" alt="Product Image"
                        class="object-cover h-full w-full rounded-2xl">
                </div>

                <!-- Product Details -->
                <div class="p-3 space-y-2">
                    <!-- Code -->
                    <p class="text-sm text-gray-500 font-medium">Code: <span
                            class="text-yellow-600">P{{ 1000 + $i }}</span></p>

                    <!-- English Name -->
                    <h2 class="text-lg font-semibold text-gray-900 truncate"
                        title="Orange Green Local (Batdambong) {{ $i + 1 }}">
                        Orange Green Local (Batdambong) {{ $i + 1 }}
                    </h2>

                    <!-- Khmer Name -->
                    <h3 class="text-md text-gray-700 truncate" title="ផលិតផល {{ $i + 1 }}">
                        ផលិតផល {{ $i + 1 }}
                    </h3>

                    <div class="flex items-center justify-between">
                        <!-- Unit -->
                        <p class="text-sm text-gray-500">Unit: <span class="font-medium text-gray-800">Piece</span></p>

                        <!-- Price -->
                        <p class="text-lg font-bold text-[#8501D8]">$19.99</p>
                    </div>
                </div>
            </div>
        @endfor
    </section>
@endsection

@section('right-panel')
    <form action="" method="POST" class="h-full flex flex-col">
        @csrf
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
                    @for ($i = 0; $i < 31; $i++)
                        @php
                            $nameEn = "Chilli Red Hot Small (Bird Eye) $i";
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
                    @endfor
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
                <button type="submit"
                    class="min-w-[150px] w-[250px] bg-[#fff] text-gray-800 py-2 rounded-lg font-bold hover:bg-gray-400 transition">
                    Continue
                </button>
            </div>
        </div>
    </form>

    <script>
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.quantity-input').forEach(input => {
                const price = parseFloat(input.dataset.price);
                const qty = parseInt(input.value) || 0;
                const subtotalElem = input.closest('tr').querySelector('.subtotal span');
                const subtotal = price * qty;
                subtotalElem.textContent = subtotal.toFixed(2);
                total += subtotal;
            });
            document.getElementById('total').textContent = '$' + total.toFixed(2);
        }

        // Handle input change
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', calculateTotal);
        });

        // Handle + / - buttons
        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.closest('td').querySelector('.quantity-input');
                let value = parseInt(input.value) || 0;
                if (btn.dataset.action === 'increase') value++;
                if (btn.dataset.action === 'decrease' && value > 0) value--;
                input.value = value;
                calculateTotal();
            });
        });

        // Initialize total on page load
        calculateTotal();
    </script>
@endsection
