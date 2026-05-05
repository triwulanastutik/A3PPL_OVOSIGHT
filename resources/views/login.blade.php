<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - OvoSight</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-slate-900 text-white">

<div class="w-full max-w-md">

    <!-- LOGO -->
    <div class="text-center mb-8">
        <div class="flex items-center justify-center gap-2 mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-600 flex items-center justify-center text-lg font-bold">
                🥚
            </div>
            <h1 class="text-2xl font-bold">OvoSight</h1>
        </div>

        <p class="text-slate-400 text-sm">
            Smart Egg Monitoring System
        </p>
    </div>

    <!-- CARD -->
    <div class="bg-slate-800 p-8 rounded-2xl shadow-xl border border-slate-700">

        <div class="mb-6">
            <h2 class="text-lg font-semibold">Login</h2>
            <p class="text-sm text-slate-400">Masuk ke sistem monitoring</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/20 text-red-400 p-3 rounded-lg mb-4 text-sm border border-red-500">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- EMAIL -->
            <div>
                <label class="text-sm text-slate-400">Email</label>
                <div class="mt-1 relative">
                    <span class="absolute left-3 top-2.5 text-slate-500">✉️</span>
                    <input type="email" name="email" required
                        class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-700 focus:ring-2 focus:ring-green-500 outline-none"
                        placeholder="email">
                </div>
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="text-sm text-slate-400">Password</label>
                <div class="mt-1 relative">
                    <span class="absolute left-3 top-2.5 text-slate-500">🔒</span>
                    <input type="password" name="password" required
                        class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-700 focus:ring-2 focus:ring-green-500 outline-none"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- LOGIN BUTTON -->
            <button type="submit"
                class="w-full bg-green-600 py-2 rounded-xl font-semibold hover:bg-green-700 transition">
                Login
            </button>

        </form>

    </div>

    <!-- FOOTER -->
    <p class="text-center text-xs text-slate-500 mt-6">
        © {{ date('Y') }} OvoSight
    </p>

</div>

</body>
</html>