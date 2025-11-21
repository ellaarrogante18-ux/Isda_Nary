<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fish Inventory System') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Landing Page Style CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="antialiased">
    <div class="relative min-h-screen bg-gradient-to-br from-cyan-50 to-teal-100">
        <!-- Navigation -->
        <nav class="nav">
            <div class="nav-container">
                <div class="nav-content">
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="nav-brand">
                        <img src="{{ asset('images/IsdaNary.png') }}" alt="IsdaNary Logo" class="h-8 w-8 object-contain">
                        IsdaNary
                    </a>

                    <!-- Navigation Links -->
                    <div class="nav-links">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('fish.index') }}" class="nav-link {{ request()->routeIs('fish.*') ? 'active' : '' }}">
                            Inventory
                        </a>
                        <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                            Sales
                        </a>
                        <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                            Expenses
                        </a>
                    </div>

                    <!-- User Menu -->
                    <div class="nav-user" x-data="{ open: false }">
                        <button @click="open = !open" class="nav-user-button">
                            <span class="sr-only">Open user menu</span>
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition 
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            <div class="px-4 py-2 text-xs text-gray-400">
                                {{ Auth::user()->name }}
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </nav>

        <!-- Page Content -->
        <main class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
