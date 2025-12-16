@extends('layouts.app')
@section('title', $program->name)
@section('page-title', 'Program Details')

@section('content')
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800">
            &larr; Back
        </a>
    </div>

    <!-- Program Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $program->name }}</h1>
                    <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($program->program_type) }}
                    </span>
                </div>
                @if($program->description)
                    <p class="text-gray-600 mb-4">{{ $program->description }}</p>
                @endif
            </div>
            <div class="mt-4 md:mt-0 md:ml-6">
                @if($enrollment)
                    <div class="text-center">
                        <span class="inline-block px-4 py-2 rounded-lg text-sm font-medium
                            @if($enrollment->status === 'approved') bg-green-100 text-green-800
                            @elseif($enrollment->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                        @if($enrollment->status === 'approved')
                            <a href="{{ route('affiliate.links.create') }}" class="block mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Create Tracking Link
                            </a>
                        @endif
                    </div>
                @else
                    <form method="POST" action="{{ route('affiliate.programs.enroll', $program) }}">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Apply to Join Program
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Program Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Program Type</p>
            <p class="text-xl font-semibold text-gray-900">
                @if($program->program_type === 'sale') Pay Per Sale
                @elseif($program->program_type === 'lead') Pay Per Lead
                @else Pay Per View
                @endif
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Commission</p>
            <p class="text-xl font-semibold text-green-600">
                @if($program->commission_type === 'percentage')
                    {{ $program->commission_amount }}%
                @else
                    ${{ number_format($program->commission_amount, 2) }}
                @endif
            </p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Commission Type</p>
            <p class="text-xl font-semibold text-gray-900">{{ ucfirst($program->commission_type) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Products</p>
            <p class="text-xl font-semibold text-gray-900">{{ $program->products->count() }}</p>
        </div>
    </div>

    <!-- Products Section -->
    @if($program->products->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Products in This Program</h2>
                <p class="text-sm text-gray-500">These are the products you can promote with this program</p>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($program->products as $product)
                    <div class="p-6 flex items-start space-x-4">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                            @if($product->description)
                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($product->description, 150) }}</p>
                            @endif
                            <div class="mt-2 flex items-center space-x-4 text-sm">
                                @if($product->price)
                                    <span class="text-gray-600">
                                        <span class="font-medium">Price:</span> ${{ number_format($product->price, 2) }}
                                    </span>
                                @endif
                                @if($product->website_url)
                                    <a href="{{ $product->website_url }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        View Product &rarr;
                                    </a>
                                @endif
                            </div>
                        </div>
                        @if($enrollment && $enrollment->status === 'approved')
                            <div class="flex-shrink-0">
                                <a href="{{ route('affiliate.links.create', ['program_id' => $program->id, 'product_id' => $product->id]) }}"
                                   class="inline-flex items-center px-3 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    Create Link
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No Specific Products</h3>
                <p class="mt-2 text-sm text-gray-500">This program uses a default landing page for all promotions.</p>
                @if($program->default_url)
                    <a href="{{ $program->default_url }}" target="_blank" class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                        View Landing Page &rarr;
                    </a>
                @endif
            </div>
        </div>
    @endif

    <!-- Leave Program -->
    @if($enrollment && $enrollment->status !== 'rejected')
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Want to leave this program?</p>
                    <p class="text-xs text-gray-400">You cannot leave if you have pending or approved commissions.</p>
                </div>
                <form method="POST" action="{{ route('affiliate.programs.leave', $program) }}" onsubmit="return confirm('Are you sure you want to leave this program?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 text-sm">
                        Leave Program
                    </button>
                </form>
            </div>
        </div>
    @endif
@endsection
