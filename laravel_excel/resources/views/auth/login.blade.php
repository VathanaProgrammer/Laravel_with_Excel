<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login</title>
</head>

<body class="bg-[linear-gradient(135deg,#9333ea,#ffffff,#9333ea,#C3C0FF)]">
    <main class="min-h-screen w-full flex justify-center items-center max-w-7xl mx-auto ">
        <div
            class="bg-white/25 border-4 h-full md:h-[700px] rounded-[10px] border-white w-full p-4 flex flex-col md:flex-row justify-between">
            <div class="bg-[#B143F5] rounded-l-[10px] w-full md:px-24 md:py-20 text-white">
                <header>
                    <h1 class="text-4xl text-center text-white font-bold">KPV Supplier</h1>
                </header>

                <div class="mt-12">
                    <h2 class="text-3xl font-bold my-4">Manage your product the best way</h2>
                    <p class="text-md font-medium">Awesome, we've created the perfect place for you to store all your
                        products</p>
                </div>
                <div class="w-full md:mt-6 flex justify-center items-center">
                    <img class="md:w-[262px] md:h-[262px]" src="{{ Vite::asset('resources/images/1.png') }}"
                        alt="Logo">
                </div>
            </div>
            <form action="{{ route('login') }}" method="POST"
                class="w-full h-full rounded-r-[10px] md:py-20 md:px-16 bg-white">
                @csrf
                <header>
                    <h1 class="text-3xl font-bold text-center text-gray-700 my-4">Login</h1>
                </header>
                <div class="mb-6 mt-14">
                    <label for="email" class="block text-gray-600 text-md font-semibold mb-2">Email:</label>
                    <input type="email" id="email" name="email" value="{{ old('email')}}" placeholder="example@gmail.com"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="mb-6 relative">
                    <label for="password" class="block text-gray-600 text-md font-semibold mb-2">Password:</label>
                    <input type="password" id="password" name="password" value="{{ old('password')}}" placeholder="enter your password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>

                    <button type="button" id="togglePassword"
                        class="absolute right-2 top-[55%] transform  text-gray-500 hover:text-gray-700">
                        <span id="passwordIcon" class="iconify" data-icon="heroicons-solid:eye" data-width="24"
                            data-height="24"></span>
                    </button>

                    @error('password')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}  class="mr-2">
                    <label for="remember" class="text-gray-600 font-medium">Remember me</label>
                </div>

                @error('email')
                    <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                @enderror

                <button class="w-full bg-[#9333ea] text-white text-lg font-bold py-2 rounded mt-4"
                    type="submit">Login</button>
            </form>

        </div>
    </main>
    <script>
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');

        toggleButton.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            // Remove old icon span
            const oldIcon = document.getElementById('passwordIcon');
            oldIcon.remove();

            // Create new icon span
            const newIcon = document.createElement('span');
            newIcon.id = 'passwordIcon';
            newIcon.className = 'iconify';
            newIcon.setAttribute('data-icon', isPassword ? 'heroicons-solid:eye-off' : 'heroicons-solid:eye');
            newIcon.setAttribute('data-width', '24');
            newIcon.setAttribute('data-height', '24');

            toggleButton.appendChild(newIcon);

            // Force Iconify to render new icon
            Iconify.scan(newIcon);
        });
    </script>
</body>

</html>
