@extends('layout')
@section('content')
    <header>
        <h1 class="text-4xl text-gray-900 font-bold w-full text-center">Profile Account</h1>
    </header>

    <section class="flex flex-row md:mt-10 justify-between w-full h-full">
        <div class="flex flex-col w-full justify-center items-center">
            <form id="update_profile_image_form" action="{{ route('change_user_image_url') }}" enctype="multipart/form-data" method="POST"
                class="relative w-[150px] h-[150px] md:w-[254px] md:h-[254px]">
                @csrf
                @method('PUT')
                <!-- Profile image -->
                <img id="profileImage" src="{{ asset('storage/' . Auth::user()->image_url) }}" alt="Profile image"
                    class="w-full h-full object-cover rounded-full border-4 border-[#8501D8]">

                <!-- Hidden file input -->
                <input type="file" id="image_url" name="image_url" accept="image/*" class="hidden">

                <!-- Pen icon overlay -->
                <button type="button" id="editImageBtn"
                    class="absolute bottom-2 right-5 bg-[#ffffff] text-white p-2 rounded-full shadow-md hover:bg-[#6a00b0] transition">
                    <!-- Pen SVG -->
                    <span class="iconify hover:text-white text-gray-800" data-icon="iconamoon:edit-light" data-width="24"
                        data-height="24"></span>
                </button>
            </form>


            @error("image_url")
                {{ $message }}
            @enderror


            <div class="mt-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name ?? 'Someone' }}
                </h1>
                <p class="text-gray-600">{{ Auth::user()->email ?? 'Someone@gmail.com' }}</p>
            </div>
        </div>

        <div class="flex flex-col w-full">
            <form id="update_info_form" action="{{ route('update_user') }}" method="POST" class="w-full">
                @csrf
                @method('PUT')
                <h3 class="text-xl font-semibold">Basic info</h3>
                <hr class="border-gray-700 h-[2px] pb-4">
                <div class="mb-6">
                    <label for="first_name" class="block text-gray-600 text-md font-semibold mb-2">First Name:</label>
                    <input type="text" id="code" name="first_name"
                        value="{{ Auth::user()->first_name ?? 'unknow' }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                      focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                        required>
                    @error('first_name')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="last_name" class="block text-gray-600 text-md font-semibold mb-2">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="{{ Auth::user()->last_name ?? 'unknow' }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                      focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                        required>
                    @error('last_name')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-gray-600 text-md font-semibold mb-2">Email:</label>
                    <input type="text" id="email" name="email" value="{{ Auth::user()->email ?? 'unknow' }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                      focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                        required>
                    @error('email')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full mb-6">
                    <button type="submit"
                        class="w-full bg-[#8501D8] text-white text-md font-medium rounded-md px-4 py-2">Save
                        info</button>
                </div>
            </form>

            <form id="update_password_form" action="{{ route('update_password') }}" method="POST">
                @csrf
                @method('PUT')
                <h3 class="text-xl font-semibold">Security</h3>
                <hr class="border-gray-700 h-[2px] pb-4">

                <div class="mb-6">
                    <label for="current_password" class="block text-gray-600 text-md font-semibold mb-2">Current
                        Password:</label>
                    <input type="password" id="current_password" name="current_password" value=""
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                      focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                        required>
                    <p id="current_password_err" class="text-red-600 mt-1 text-sm hidden"></p>

                    @error('current_password')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="new_password" class="block text-gray-600 text-md font-semibold mb-2">New Password:</label>
                    <input type="password" id="new_password" name="new_password" value=""
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight
                      focus:outline-none focus:ring-2 focus:ring-[#8501D8] focus:border-[#8501D8]"
                        required>
                    <p id="pass_err" class="text-red-600 mt-1 text-md hidden"></p>
                    @error('new_password')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full mb-6">
                    <button type="submit"
                        class="w-full bg-[#8501D8] text-white text-md font-medium rounded-md px-4 py-2">Save
                        Password</button>
                </div>
            </form>
        </div>
    </section>

    <div id="overlay-loader" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center hidden">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const profileImage = document.getElementById("profileImage");
            const fileInput = document.getElementById("image_url");
            const editBtn = document.getElementById("editImageBtn");
            const form = document.getElementById("update_profile_image_form");

            // When clicking the pen icon, open the file selector
            editBtn.addEventListener("click", (e) => {
                e.preventDefault();
                fileInput.click();
            });

            // When a new image is selected, show preview
            fileInput.addEventListener("change", (event) => {
                event.preventDefault();
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        profileImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }

                form.submit();
            });

            const current_pass_err_log = document.getElementById("current_password_err").value;

            const overlay = document.getElementById('overlay-loader');
            const infoForm = document.getElementById('update_info_form');

            infoForm.addEventListener('submit', async function(e) {
                e.preventDefault(); // prevent normal form submission
                overlay.classList.remove('hidden'); // show loader

                const formData = new FormData(infoForm);

                try {
                    const response = await fetch(infoForm.action, {
                        method: 'POST', // Laravel route expects POST with _method=PUT
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json(); // return JSON from server
                    overlay.classList.add('hidden');
                    if (!result.success) {
                        console.error("error while update info!")
                    }
                    // hide loader
                    toastr.success("User info update successfully!");
                } catch (err) {
                    overlay.classList.add('hidden'); // hide loader on error

                    console.error(err);
                }
            });

            const update_password_form = document.getElementById("update_password_form");
            update_password_form.addEventListener("submit", async function(e) {
                e.preventDefault();

                // show loader
                overlay.classList.remove("hidden");

                // clear previous errors
                document.querySelectorAll("#update_password_form .text-red-600").forEach(el => {
                    el.classList.add("hidden");
                    el.textContent = "";
                });

                const formData = new FormData(update_password_form);

                try {
                    const response = await fetch(update_password_form.action, {
                        method: "POST", // Laravel expects POST + _method=PUT
                        headers: {
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: formData
                    });

                    const result = await response.json();
                    overlay.classList.add("hidden");
                    if (result.success) {
                        toastr.success(result.message || "Password updated successfully!");
                        update_password_form.reset();
                    } else {
                        const passErr = document.getElementById("pass_err");
                        passErr.textContent = result.message || "Failed to update password.";
                        passErr.classList.remove("hidden");
                        toastr.error(result.message || "Failed to update password.", "Error");
                    }

                } catch (err) {
                    overlay.classList.add("hidden");
                    console.error("Error while updating password:", err);
                    toastr.error("An unexpected error occurred. Try again later.");
                }
            });
            // your code here
        })
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
