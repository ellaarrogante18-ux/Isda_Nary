<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'Fish Inventory System') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="font-sans antialiased">
    <div class="auth-gradient">
        <div class="auth-container">
            <div class="auth-card">
                <!-- Logo -->
                <a href="{{ route('welcome') }}" class="auth-logo">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2l3 3" />
                    </svg>
                    <span class="auth-logo-text">FishInventory</span>
                </a>

                <div class="auth-header">
                    <h2 class="auth-title">Create Account</h2>
                    <p class="auth-subtitle">Start managing your fish business today</p>
                </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-error mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                </div>

                <!-- Business Name -->
                <div class="mb-4">
                    <label for="business_name" class="form-label">Business Name (Optional)</label>
                    <input id="business_name" class="form-input" type="text" name="business_name" value="{{ old('business_name') }}" autocomplete="organization" />
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                    <input id="phone" class="form-input" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <div class="flex items-center justify-between mb-4">
                    <a class="text-sm text-ocean-600 hover:text-ocean-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ocean-500" href="{{ route('login') }}">
                        Already have an account?
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                </div>
            </form>

                <div class="text-center">
                    <a href="{{ route('welcome') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        ← Back to home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
