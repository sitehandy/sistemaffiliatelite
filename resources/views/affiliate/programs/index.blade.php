@extends('layouts.app')
@section('title', 'Browse Programs')
@section('page-title', 'Browse Programs')

@section('content')
    <div class="mb-6">
        <form method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search programs..." class="px-4 py-2 border border-gray-300 rounded-lg">
            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">All Types</option>
                <option value="sale" {{ request('type') === 'sale' ? 'selected' : '' }}>Pay Per Sale</option>
                <option value="lead" {{ request('type') === 'lead' ? 'selected' : '' }}>Pay Per Lead</option>
                <option value="view" {{ request('type') === 'view' ? 'selected' : '' }}>Pay Per View</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Search</button>
        </form>
    </div>

    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <form method="POST" action="{{ route('affiliate.programs.join-with-code') }}" class="flex items-center space-x-2">
            @csrf
            <input type="text" name="invitation_code" placeholder="Have an invitation code?" class="px-4 py-2 border border-blue-300 rounded-lg flex-1">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Join Program</button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($programs as $program)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <a href="{{ route('affiliate.programs.show', $program) }}" class="block">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 hover:text-blue-600">{{ $program->name }}</h3>
                    </a>
                    <p class="text-sm text-gray-500 mb-4">{{ Str::limit($program->description, 100) }}</p>
                    <div class="flex items-center justify-between text-sm mb-4">
                        <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800">{{ ucfirst($program->program_type) }}</span>
                        <span class="font-semibold text-green-600">
                            @if($program->commission_type === 'percentage'){{ $program->commission_amount }}%@else ${{ number_format($program->commission_amount, 2) }}@endif
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mb-4">{{ $program->products->count() }} products</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('affiliate.programs.show', $program) }}" class="flex-1 text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">View Details</a>
                        @if(in_array($program->id, $enrolledProgramIds))
                            <span class="flex-1 text-center px-4 py-2 bg-gray-100 text-gray-600 rounded-lg">Enrolled</span>
                        @else
                            <form method="POST" action="{{ route('affiliate.programs.enroll', $program) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Join</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-8 text-gray-500">No programs available at the moment.</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $programs->links() }}</div>
@endsection
