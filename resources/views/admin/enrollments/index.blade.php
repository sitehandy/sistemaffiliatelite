@extends('layouts.app')
@section('title', 'Enrollments')
@section('page-title', 'Affiliate Enrollments')

@section('content')
    <div class="mb-6">
        <form method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search affiliates..." class="px-4 py-2 border border-gray-300 rounded-lg">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Affiliate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td class="px-6 py-4"><div class="text-sm font-medium text-gray-900">{{ $enrollment->user->name }}</div><div class="text-sm text-gray-500">{{ $enrollment->user->email }}</div></td>
                        <td class="px-6 py-4 text-sm">{{ $enrollment->program->name }}</td>
                        <td class="px-6 py-4 text-sm">{{ $enrollment->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full @if($enrollment->status==='pending')bg-yellow-100 text-yellow-800 @elseif($enrollment->status==='approved')bg-green-100 text-green-800 @elseif($enrollment->status==='suspended')bg-orange-100 text-orange-800 @else bg-red-100 text-red-800 @endif">{{ ucfirst($enrollment->status) }}</span></td>
                        <td class="px-6 py-4 text-right text-sm">
                            <div class="flex items-center justify-end space-x-2">
                                @if($enrollment->status === 'pending')
                                    <form method="POST" action="{{ route('admin.enrollments.approve', $enrollment) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs rounded-md hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.enrollments.reject', $enrollment) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs rounded-md hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                @elseif($enrollment->status === 'approved')
                                    <form method="POST" action="{{ route('admin.enrollments.suspend', $enrollment) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs rounded-md hover:bg-yellow-600">
                                            Suspend
                                        </button>
                                    </form>
                                @elseif($enrollment->status === 'suspended')
                                    <form method="POST" action="{{ route('admin.enrollments.reactivate', $enrollment) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs rounded-md hover:bg-green-700">
                                            Reactivate
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No enrollments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $enrollments->links() }}</div>
@endsection
