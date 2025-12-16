@extends('layouts.app')
@section('title', 'Products Report')
@section('page-title', 'Products Report')

@section('content')
    <div class="mb-6">
        <form method="GET" class="flex items-center space-x-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">From</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">To</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="pt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Apply</button>
            </div>
            <div class="pt-6">
                <a href="{{ route('admin.reports.export', ['type' => 'products', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Export CSV</a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tracking Links</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conversions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded object-cover mr-3">
                                @else
                                    <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center mr-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">${{ number_format($product->price ?? 0, 2) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $product->tracking_links_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $product->conversions_count }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-green-600">${{ number_format($product->total_revenue ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No products found for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
