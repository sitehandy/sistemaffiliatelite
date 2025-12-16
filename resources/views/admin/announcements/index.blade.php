@extends('layouts.app')
@section('title', 'Announcements')
@section('page-title', 'Announcements')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <form method="GET" class="flex items-center space-x-2">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Filter</button>
        </form>
        <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ New Announcement</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Announcement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Published</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($announcements as $announcement)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($announcement->is_pinned)
                                    <svg class="w-4 h-4 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2H7a2 2 0 01-2-2V5zm2 0v2h6V5H7zm-4 9a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm5 4a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                                    </svg>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $announcement->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($announcement->content, 60) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($announcement->type === 'info') bg-blue-100 text-blue-800
                                @elseif($announcement->type === 'success') bg-green-100 text-green-800
                                @elseif($announcement->type === 'warning') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($announcement->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $announcement->published_at ? $announcement->published_at->format('M d, Y') : 'Not set' }}
                            @if($announcement->expires_at)
                                <br><span class="text-xs">Expires: {{ $announcement->expires_at->format('M d, Y') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($announcement->isPublished())
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Published</span>
                            @elseif($announcement->isExpired())
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Expired</span>
                            @elseif(!$announcement->is_active)
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactive</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Scheduled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs rounded-md hover:bg-blue-700">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.announcements.toggle-status', $announcement) }}" class="inline">
                                    @csrf
                                    @if($announcement->is_active)
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white text-xs rounded-md hover:bg-yellow-600">
                                            Deactivate
                                        </button>
                                    @else
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs rounded-md hover:bg-green-700">
                                            Activate
                                        </button>
                                    @endif
                                </form>
                                <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement?')">
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
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No announcements found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $announcements->links() }}</div>
@endsection
