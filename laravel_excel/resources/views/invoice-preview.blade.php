@extends('layout')
@section('content')
    <header class="flex justify-between items-center mb-6">
        <a href="{{ route('sale') }}"
            class="bg-[#8501D8] text-md font-medium text-white max-w-[250px] px-2 py-2 rounded flex justify-center items-center">
            <span class="iconify text-white mr-1" data-icon="ion:chevron-back-outline" data-width="24" data-height="24"></span>
        </a>
        <h1 class="text-2xl font-bold text-gray-700">Invoice Preview</h1>
    </header>

    <section class="flex justify-between md:flex-row flex-col items-center w-full gap-4">
        <div class="w-full ">
            <h2 class="text-gray-800 text-2xl font-bold">
                Customer's infornation
            </h2>
            <div class="mb-2">
                <label for="company_name" class="block text-gray-600 text-md font-semibold mb-2">Company name:</label>
                <input type="text" id="company_name" name="company_name" value=""
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('company_name')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-2">
                <label for="company_location" class="block text-gray-600 text-md font-semibold mb-2">Company
                    location:</label>
                <input type="text" id="company_location" name="company_location" value=""
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('company_location')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="type" class="block text-gray-600 text-md font-semibold mb-2">Type:</label>
                <input type="text" id="type" name="type" value=""
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('type')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="tel" class="block text-gray-600 text-md font-semibold mb-2">Tel:</label>
                <input type="text" id="tel" name="tel" value=""
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('tel')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

        </div>
        <div class="w-full">
            <h2 class="text-gray-800 text-2xl font-bold">
                Invoice Details
            </h2>
            <div class="mb-2">
                <label for="invoice_no" class="block text-gray-600 text-md font-semibold mb-2">Invoice No:</label>
                <input type="text" id="invoice_no" name="invoice_no" value="202508-00030" readonly
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('invoice_no')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-2">
                <label for="invoice_date" class="block text-gray-600 text-md font-semibold mb-2">Invoice Date:</label>
                <input type="text" id="invoice_date" name="invoice_date" value=""
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                   focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('invoice_date')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="PO_no" class="block text-gray-600 text-md font-semibold mb-2">PO No:</label>
                <input type="text" id="PO_no" name="PO_no" value=""
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('PO_no')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="PR_no" class="block text-gray-600 text-md font-semibold mb-2">PR No:</label>
                <input type="text" id="PR_no" name="PR_no" value=""
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                       focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                    required>
                @error('PR_no')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>
    <section>
        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg mt-6 max-h-[600px] overflow-y-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-[#8501D8] text-white uppercase text-md font-medium sticky top-0 z-10">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center gap-2">
                                <input id="checkbox-all-search" type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 bg-white checked:bg-white checked:text-[#8501D8] focus:ring-2 focus:ring-white appearance-none">
                                <span>No</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">Code</th>
                        <th scope="col" class="px-6 py-3">En Name</th>
                        <th scope="col" class="px-6 py-3">Kh Name</th>
                        <th scope="col" class="px-6 py-3">Qty</th>
                        <th scope="col" class="px-6 py-3">Unit</th>
                        <th scope="col" class="px-6 py-3">Price</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                    @endphp
                    @foreach ($items as $index => $item)
                        @php
                            $qty = $item['qty'];
                            $price = $item['price'];
                            $total = $qty * $price;
                            $grandTotal += $total;
                        @endphp
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} border-b text-md hover:bg-gray-100">
                            <td class="p-4 align-middle">
                                <div class="flex items-center justify-center h-full gap-2">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 text-[#8501D8] border-gray-300 rounded focus:ring-[#8501D8] focus:ring-2">
                                    <span>{{ $index + 1 }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 ">{{ $item['code'] ?? 200 + $index }}</td>
                            <!-- English Name Column -->
                            <td class="px-6 py-4 max-w-[200px]">
                                <div class="line-clamp-2">
                                    {{ $item['nameEn'] ?? 'Product EN ' . $index }}
                                </div>
                            </td>

                            <!-- Khmer Name Column -->
                            <td class="px-6 py-4 khmer font-bold max-w-[200px]">
                                <div class="line-clamp-2">
                                    {{ $item['nameKh'] ?? 'ផលិតផល ' . $index }}
                                </div>
                            </td>

                            <td class="px-6 py-4">{{ number_format($qty, 2) }}</td>
                            <td class="px-6 py-4">{{ $item['unit'] ?? 'Kg' }}</td>
                            <td class="px-6 py-4">${{ number_format($price, 2) }}</td>
                            <td class="px-6 py-4">${{ number_format($total, 2) }}</td>
                        </tr>
                    @endforeach

                    <!-- Total Row -->
                    <tr class="bg-[#8501D8] text-white font-semibold">
                        <td colspan="7" class="px-6 py-4 text-right">Total</td>
                        <td class="px-6 py-4">${{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </tbody>

            </table>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#invoice_date", {
                dateFormat: "d.m.Y", // Displays 15.10.2025
                allowInput: true,
                defaultDate: new Date(), // auto-fill with today's date
            });

            const selectAll = document.getElementById("checkbox-all-search");
            const rowCheckBoxes = document.querySelectorAll(".row-checkbox");

            selectAll.addEventListener("change", () => {
                rowCheckBoxes.forEach(cb => cb.checked = selectAll.checked);
            })

            rowCheckBoxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!cb.checked) selectAll.checked = false;
                    else if ([...rowCheckBoxes].every(c => c.checked)) selectAll.checked =
                        true; // if all check box are checked selectAll = true (checked)
                });
            });

        });
    </script>
    <style>

    </style>
@endsection
