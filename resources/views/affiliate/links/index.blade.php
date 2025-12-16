@extends('layouts.app')
@section('title', 'Tracking Links')
@section('page-title', 'Tracking Links')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <form method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="px-4 py-2 border border-gray-300 rounded-lg">
            <select name="program_id" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Programs</option>
                @foreach($enrolledPrograms as $program)
                    <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Filter</button>
        </form>
        <a href="{{ route('affiliate.links.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ New Link</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clicks</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conversions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Link</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($links as $link)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $link->product?->name ?? 'All Products (Default URL)' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $link->program->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($link->clicks_count) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($link->conversions_count) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <input type="text" readonly value="{{ url('/track/' . $link->unique_code) }}" class="text-xs px-2 py-1 border border-gray-300 rounded w-48">
                                <button onclick="navigator.clipboard.writeText('{{ url('/track/' . $link->unique_code) }}')" class="text-blue-600 hover:text-blue-800 text-xs">Copy</button>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('affiliate.links.show', $link) }}" class="text-blue-600 hover:text-blue-900">Stats</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No tracking links yet. <a href="{{ route('affiliate.links.create') }}" class="text-blue-600">Create one</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $links->links() }}</div>
@endsection
