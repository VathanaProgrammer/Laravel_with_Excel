<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Sidebar Without Flowbite</title>
</head>

<body class="bg-gray-100">
    <main class="min-h-screen w-full max-w-7xl mx-auto">
        <!-- Mobile toggle button -->
        <button id="sidebarToggle" type="button"
            class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path clip-rule="evenodd" fill-rule="evenodd"
                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                </path>
            </svg>
        </button>

        <!-- Overlay (hidden by default) -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden sm:hidden"></div>

        <!-- Sidebar -->
        <aside id="default-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen bg-[#8501D8] transform -translate-x-full transition-transform sm:translate-x-0 rounded-r-xl"
            aria-label="Sidebar">
            <div class="h-full flex flex-col px-3 pr-0 py-12 overflow-y-auto">
                <ul class="space-y-2 font-medium" id="menuLinks">
                    <!-- Profile -->
                    <li>
                        <a href="#" class="flex items-center flex-col">
                            <div class="p-1 bg-white rounded-full">
                                <img class="rounded-full border-2 border-[#8501D8] w-[100px] h-[100px] object-cover md:w-[154px] md:h-[154px]"
                                    src="{{ Auth::user()->image_url ? asset('storage/' . Auth::user()->image_url) : Vite::asset('resources\images\2.jpg') }}"
                                    alt="">
                            </div>
                        </a>
                        <h1 class="text-white md:text-[20px] text-center md:mt-6">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Someone' }}
                        </h1>

                        <p class="text-white md:text-[13px] text-center md:mt-2">
                            {{ Auth::user()->email ?? 'someone@gmail.com' }}
                        </p>

                    </li>

                    <!-- Menu items -->
                    <li>
                        <a href="{{ route('inventory') }}"
                            class="menu-link flex items-center p-2 rounded-l-lg 
                            {{ request()->routeIs('inventory') ? 'bg-white text-black' : 'text-white' }}
                            hover:bg-white hover:text-black transition-colors duration-300">
                            <span
                                class="iconify {{ request()->routeIs('inventory') ? 'text-black' : 'text-white' }} transition-colors duration-300"
                                data-icon="si:inventory-fill" data-width="24" data-height="24"></span>
                            <span
                                class="ms-3 {{ request()->routeIs('inventory') ? 'text-black' : 'text-white' }} transition-colors duration-300">Inventory</span>
                        </a>
                    </li>
                    </li>
                    <li>
                        <a href="{{ route('sale') }}"
                            class="menu-link flex items-center p-2 rounded-l-lg 
                            {{ request()->routeIs('sale') ? 'bg-white text-black' : 'text-white' }}
                            hover:bg-white hover:text-black transition-colors duration-300">
                            <span
                                class="iconify {{ request()->routeIs('sale') ? 'text-black' : 'text-white' }} transition-colors duration-300"
                                data-icon="mdi:sale" data-width="24" data-height="24"></span>
                            <span
                                class="ms-3 {{ request()->routeIs('sale') ? 'text-black' : 'text-white' }} transition-colors duration-300">Sale</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('report') }}"
                            class="menu-link flex items-center p-2 rounded-l-lg text-white hover:bg-white hover:text-black">
                            <span class="iconify text-white" data-icon="line-md:document-report-twotone" data-width="24"
                                data-height="24"></span>
                            <span class="ms-3">Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile') }}"
                            class="menu-link flex items-center p-2 rounded-l-lg text-white hover:bg-white hover:text-black">
                            <span class="iconify text-white" data-icon="gg:profile" data-width="24"
                                data-height="24"></span>
                            <span class="ms-3">Profile</span>
                            {{-- @if(session('success'))
                                <span class="ms-3">Profile</span>
                            @endif --}}
                        </a>
                    </li>
                </ul>
                <!-- Logout button at the bottom -->
                <div class="mt-auto pb-1 me-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center p-2 rounded-lg  bg-red-600 text-white hover:bg-red-700 transition-colors">
                            <span class="iconify mr-2" data-icon="mdi:logout" data-width="24" data-height="24"></span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Page content -->
        <div class="p-4 sm:ml-64 {{ request()->routeIs('sale') ? 'mr-[350px]' : '' }}">
            <!-- Notice the `mr-[350px]` → gives space for the right panel -->
            <main>
                @yield('notification')
                @yield('content')
            </main>
        </div>


        <!-- Right Panel -->
        @hasSection('right-panel')
            <aside id="right-panel"
                class="fixed top-0 right-0 z-40 w-[350px] h-screen bg-[#8501D8] rounded-l-xl shadow-md p-1
               transform translate-x-full transition-transform duration-500 ease-in-out">
                @yield('right-panel')
            </aside>

            <script>
                window.addEventListener("DOMContentLoaded", () => {
                    // trigger animation after page loads
                    requestAnimationFrame(() => {
                        document.getElementById("right-panel").classList.remove("translate-x-full");
                    });
                });
            </script>
        @endif
    </main>
    <script>
        const sidebar = document.getElementById("default-sidebar");
        const sidebarToggle = document.getElementById("sidebarToggle");
        const sidebarOverlay = document.getElementById("sidebarOverlay");

        // Open/close sidebar
        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
            sidebarOverlay.classList.toggle("hidden");
        });

        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
            sidebarOverlay.classList.add("hidden");
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}", "Success");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}", "Error");
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}", "Info");
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}", "Warning");
            @endif
        });
    </script>
</body>

</html>
