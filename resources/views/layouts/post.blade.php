<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devs Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-800 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home.index') }}" class="text-white text-lg font-semibold">Devs Blog</a>
            <div class="flex">
                @auth
                    <a href="{{ route('filament.admin.auth.login') }}"
                        class="text-gray-200 hover:bg-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>

                    <form action="{{ route('filament.admin.auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-gray-200 hover:bg-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('filament.admin.auth.login') }}"
                        class="text-gray-200 hover:bg-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="{{ route('filament.admin.auth.register') }}"
                        class="text-gray-200 hover:bg-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')


    <footer class="bg-gray-800 text-white py-4 px-6 text-center mt-20">
        <p>&copy; 2023 Devs Blog. All rights reserved.</p>
    </footer>

</body>

</html>
