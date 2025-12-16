@extends('layouts.app')
@section('title', 'Affiliates')
@section('page-title', 'Manage Affiliates')

@section('content')
    <div class="mb-6">
        <form method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." class="px-4 py-2 border border-gray-300 rounded-lg">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Affiliate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Programs</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commissions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($affiliates as $affiliate)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $affiliate->name }}</div>
                            <div class="text-sm text-gray-500">{{ $affiliate->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $affiliate->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $affiliate->enrollments->where('status', 'approved')->count() }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            ${{ number_format($affiliate->commissions->sum('amount'), 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $affiliate->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $affiliate->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.affiliates.show', $affiliate) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-500 text-white text-xs rounded-md hover:bg-gray-600">
                                    View
                                </a>
                                <a href="{{ route('admin.affiliates.edit', $affiliate) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs rounded-md hover:bg-blue-700">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.affiliates.toggle-status', $affiliate) }}" class="inline">
                                    @csrf
                                    @if($affiliate->is_active)
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs rounded-md hover:bg-yellow-600">
                                            Deactivate
                                        </button>
                                    @else
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs rounded-md hover:bg-green-700">
                                            Activate
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No affiliates found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $affiliates->links() }}</div>
@endsection
