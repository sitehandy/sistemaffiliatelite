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
            <aside x-cloak
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 w-64 bg-slate-800 text-white z-50 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:flex-shrink-0 overflow-y-auto">

                <!-- Sidebar Header -->
                <div class="p-4 border-b border-slate-700 flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-white hover:text-blue-400 truncate">
                        {{ config('app.name', 'Affiliate System') }}
                    </a>
                    <!-- Close button for mobile -->
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <nav class="p-4">
                    @if(auth()->user()->role?->name === 'admin')
                        <!-- Admin Navigation -->
                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Dashboard</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Program Management</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('admin.programs.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.programs.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <span>Programs</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.products.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.products.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span>Products</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Affiliates</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('admin.affiliates.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.affiliates.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <span>Manage Affiliates</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.enrollments.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.enrollments.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>Enrollments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.commissions.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.commissions.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Commissions</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.payouts.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.payouts.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>Payouts</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Reports</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('admin.reports.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.reports.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <span>Reports</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Communication</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('admin.announcements.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.announcements.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                        </svg>
                                        <span>Announcements</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Settings</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('admin.settings.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.settings.index') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>General Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.settings.app') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.settings.app*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>App Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.settings.mail') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.settings.mail*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Mail Setup</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.integration-guide.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('admin.integration-guide.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                        </svg>
                                        <span>Integration Guide</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Affiliate Navigation -->
                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Dashboard</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('affiliate.dashboard') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('affiliate.dashboard') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Programs</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('affiliate.programs.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('affiliate.programs.index') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <span>Browse Programs</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('affiliate.programs.enrolled') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('affiliate.programs.enrolled') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>My Programs</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Links & Tracking</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('affiliate.links.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('affiliate.links.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        <span>Tracking Links</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="mb-6">
                            <p class="text-xs uppercase text-slate-400 mb-2 font-semibold">Earnings</p>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('affiliate.commissions.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('affiliate.commissions.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Commissions</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('affiliate.payouts.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('affiliate.payouts.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>Payouts</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('affiliate.payment-methods.index') }}" @click="sidebarOpen = false" class="flex items-center px-3 py-2 rounded hover:bg-slate-700 {{ request()->routeIs('affiliate.payment-methods.*') ? 'bg-slate-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        <span>Payment Methods</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </nav>
            </aside>

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
