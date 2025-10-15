<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex justify-center items-center min-h-screen">

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-gray-500 p-8 rounded shadow-md min-w-[350px]">
        @csrf
        <h1 class="text-2xl font-bold mb-6">Create User</h1>

        <label class="block mb-2">First Name:</label>
        <input type="text" name="firstname" class="w-full mb-4 p-2 border rounded" required>
        @error('firstname')
            {{ $message }}
        @enderror
        <label class="block mb-2">Last Name:</label>
        <input type="text" name="lastname" class="w-full mb-4 p-2 border rounded" required>
        @error('lastname')
            {{ $message }}
        @enderror
        <label class="block mb-2">Email:</label>
        <input type="email" name="email" class="w-full mb-4 p-2 border rounded" required>
        @error('email')
            {{ $message }}
        @enderror
        <label class="block mb-2">Password:</label>
        <input type="password" name="password" class="w-full mb-4 p-2 border rounded" required>
        @error('password')
            {{ $message }}
        @enderror
        <label class="block mb-2">Profile Image (optional):</label>
        <input type="file" name="image" class="w-full mb-4 p-2 border rounded" accept="image/*">
        @error('image')
            {{ $message }}
        @enderror
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <button type="submit"
            class="w-full bg-purple-600 text-gray-500 p-2 rounded font-bold hover:bg-purple-700">Create</button>
    </form>

</body>

</html>
