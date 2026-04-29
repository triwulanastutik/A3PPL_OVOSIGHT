<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - OvoSight</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

<div class="w-full max-w-md">

    <!-- LOGO -->
    <div class="text-center mb-6">
        <img src="{{ asset('images/logo.png') }}" class="w-20 mx-auto mb-2">
        <h1 class="text-3xl font-bold text-gray-700">OvoSight</h1>
        <p class="text-gray-500 text-sm">Smart Egg Monitoring System</p>
    </div>

    <!-- CARD -->
    <div class="bg-white p-8 rounded-3xl shadow-[0_10px_30px_rgba(0,0,0,0.1)]">

        <h2 class="text-lg font-semibold text-gray-700 mb-5">
            Login form
        </h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <!-- EMAIL -->
            <div class="mb-4 relative">
                <div class="absolute left-3 top-2.5 text-gray-400">✉️</div>
                <input type="email" name="email"
                    placeholder="Email or Username"
                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            <!-- PASSWORD -->
            <div class="mb-2 relative">
                <div class="absolute left-3 top-2.5 text-gray-400">🔑</div>
                <input type="password" name="password"
                    placeholder="Password"
                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            <!-- FORGOT -->
            <div class="text-right text-sm text-gray-500 mb-4">
                <a href="#" class="hover:underline">Forgot Password?</a>
            </div>

            <!-- GOOGLE -->
            <button type="button"
                class="w-full flex items-center justify-center gap-2 bg-gray-100 py-2 rounded-full shadow mb-4">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5">
                Continue with Google
            </button>

            <!-- LOGIN -->
            <button type="submit"
                class="w-full bg-green-700 text-white py-2 rounded-full shadow-lg hover:bg-green-800 transition">
                LOG IN
            </button>

        </form>

    </div>

</div>

</body>
</html>