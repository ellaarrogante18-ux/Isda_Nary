<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'IsdaNary') }} - Get Started</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative min-h-screen bg-gradient-to-br from-cyan-50 to-teal-100">
        <!-- Navigation -->
        <nav class="relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div class="flex items-center">
                        <img src="{{ asset('images/IsdaNary.png') }}" alt="IsdaNary Logo" class="h-12 w-12 object-contain">
                        <span class="ml-3 text-2xl font-bold text-gray-900">IsdaNary</span>
                    </div>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            Go to Dashboard
                        </a>
                    @else
                        <div class="flex space-x-4">
                            <a href="{{ route('login') }}" class="btn btn-secondary">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                Login
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Manage Your Fish Business
                    <span class="text-teal-600">Efficiently</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Complete inventory management system for fish vendors. Track your stock, record sales, manage expenses, and grow your business with detailed insights.
                </p>
                
                @guest
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="btn btn-primary text-lg px-8 py-3">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-secondary text-lg px-8 py-3">
                            Sign In
                        </a>
                    </div>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary text-lg px-8 py-3">
                        Go to Dashboard
                    </a>
                @endguest
            </div>
        </div>

        <!-- Features Section -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Everything You Need</h2>
                <p class="text-lg text-gray-600">Powerful features designed specifically for fish vendors</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Inventory Management -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Inventory Management</h3>
                        <p class="text-gray-600">Track fish types, quantities, and prices. Get alerts for low stock and prevent overselling.</p>
                    </div>
                </div>

                <!-- Sales Tracking -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Sales Tracking</h3>
                        <p class="text-gray-600">Record sales transactions with automatic inventory updates and customer information.</p>
                    </div>
                </div>

                <!-- Expense Management -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Expense Management</h3>
                        <p class="text-gray-600">Track daily expenses, categorize costs, and calculate your actual profit margins.</p>
                    </div>
                </div>

                <!-- Reports & Analytics -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Reports & Analytics</h3>
                        <p class="text-gray-600">Get insights into your best-selling fish, daily profits, and business trends.</p>
                    </div>
                </div>

                <!-- User Management -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Secure Access</h3>
                        <p class="text-gray-600">Each vendor has their own secure account with private data and personalized dashboard.</p>
                    </div>
                </div>

                <!-- Mobile Friendly -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Mobile Friendly</h3>
                        <p class="text-gray-600">Access your inventory and record sales from any device, anywhere, anytime.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        @guest
        <div class="relative z-10 bg-teal-600 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
                <p class="text-xl text-teal-100 mb-8">Join hundreds of fish vendors who trust our system to manage their business.</p>
                <a href="{{ route('register') }}" class="btn bg-white text-teal-600 hover:bg-gray-100 text-lg px-8 py-3">
                    Create Your Account
                </a>
            </div>
        </div>
        @endguest

        <!-- Background decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <svg class="absolute bottom-0 left-0 transform translate-y-1/2 -translate-x-1/2 lg:translate-y-1/4 lg:-translate-x-1/4" width="404" height="784" fill="none" viewBox="0 0 404 784">
                <defs>
                    <pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-cyan-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="784" fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)" />
            </svg>
        </div>
    </div>
</body>
</html>
