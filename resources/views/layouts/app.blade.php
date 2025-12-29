<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Affiliate System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
    <div id="app" x-data="{ sidebarOpen: false }">
        <!-- Mobile Sidebar Overlay -->
        <div x-cloak
             x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 z-40 lg:hidden">
        </div>

        <div class="flex min-h-screen">
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0 lg:ml-0">
                <!-- Header -->
                <header class="bg-white border-b border-gray-200 px-4 md:px-6 py-4 sticky top-0 z-30">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Mobile Menu Button -->
                            <button @click="sidebarOpen = !sidebarOpen" type="button" class="lg:hidden mr-3 text-gray-600 hover:text-gray-900 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <h1 class="text-lg md:text-xl font-semibold text-gray-800 truncate">@yield('page-title', 'Dashboard')</h1>
                        </div>

                        <div class="flex items-center space-x-2 md:space-x-4">
                            <!-- User Menu -->
                            <div class="relative" x-data="{ userMenu: false }">
                                <button @click="userMenu = !userMenu" type="button" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <span class="hidden md:inline truncate max-w-[150px]">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-cloak x-show="userMenu" @click.away="userMenu = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                        <p class="text-xs text-blue-600 mt-1 capitalize">{{ auth()->user()->role?->name ?? 'User' }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Profile Settings
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-4 md:p-6 overflow-x-hidden">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 p-4 text-center text-gray-600 text-sm">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </footer>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
