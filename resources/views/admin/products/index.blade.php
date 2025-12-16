@extends('layouts.app')
@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <form method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="px-4 py-2 border border-gray-300 rounded-lg">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Filter</button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ New Product</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Programs</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4"><div class="text-sm font-medium text-gray-900">{{ $product->name }}</div><div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div></td>
                        <td class="px-6 py-4 text-sm">${{ number_format($product->price ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-sm">{{ $product->programs->count() }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td class="px-6 py-4 text-right text-sm">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs rounded-md hover:bg-blue-700">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}" class="inline">
                                    @csrf
                                    @if($product->is_active)
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs rounded-md hover:bg-yellow-600">
                                            Deactivate
                                        </button>
                                    @else
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs rounded-md hover:bg-green-700">
                                            Activate
                                        </button>
                                    @endif
                                </form>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs rounded-md hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
@endsection
