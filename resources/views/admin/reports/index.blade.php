@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('admin.reports.overview') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="text-blue-600 mb-2"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
            <h3 class="text-lg font-semibold text-gray-800">Overview</h3>
            <p class="text-sm text-gray-500">General statistics and performance</p>
        </a>
        <a href="{{ route('admin.reports.affiliates') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="text-green-600 mb-2"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
            <h3 class="text-lg font-semibold text-gray-800">Affiliates</h3>
            <p class="text-sm text-gray-500">Affiliate performance report</p>
        </a>
        <a href="{{ route('admin.reports.programs') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="text-purple-600 mb-2"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></div>
            <h3 class="text-lg font-semibold text-gray-800">Programs</h3>
            <p class="text-sm text-gray-500">Program performance report</p>
        </a>
        <a href="{{ route('admin.reports.products') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <div class="text-yellow-600 mb-2"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></div>
            <h3 class="text-lg font-semibold text-gray-800">Products</h3>
            <p class="text-sm text-gray-500">Product performance report</p>
        </a>
    </div>
@endsection
