@extends('layouts.app')
@section('title', 'My Programs')
@section('page-title', 'My Programs')

@section('content')
    @if($enrollments->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No Programs Yet</h3>
            <p class="mt-2 text-sm text-gray-500">Get started by browsing available programs.</p>
            <a href="{{ route('affiliate.programs.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Browse Programs</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($enrollments as $enrollment)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <a href="{{ route('affiliate.programs.show', $enrollment->program) }}" class="block">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600">{{ $enrollment->program->name }}</h3>
                            </a>
                            <span class="px-2 py-1 text-xs rounded-full @if($enrollment->status==='approved')bg-green-100 text-green-800 @elseif($enrollment->status==='pending')bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">{{ ucfirst($enrollment->status) }}</span>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">{{ Str::limit($enrollment->program->description, 80) }}</p>
                        <div class="text-sm text-gray-600 mb-4">
                            <p><span class="font-medium">Type:</span> {{ ucfirst($enrollment->program->program_type) }}</p>
                            <p><span class="font-medium">Commission:</span> @if($enrollment->program->commission_type === 'percentage'){{ $enrollment->program->commission_amount }}%@else ${{ number_format($enrollment->program->commission_amount, 2) }}@endif</p>
                            <p><span class="font-medium">Products:</span> {{ $enrollment->program->products->count() }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('affiliate.programs.show', $enrollment->program) }}" class="flex-1 text-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">View Details</a>
                            @if($enrollment->status === 'approved')
                                <a href="{{ route('affiliate.links.create', ['program_id' => $enrollment->program->id]) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Link</a>
                            @elseif($enrollment->status === 'pending')
                                <span class="flex-1 text-center px-4 py-2 bg-yellow-100 text-yellow-600 rounded-lg">Pending</span>
                            @else
                                <span class="flex-1 text-center px-4 py-2 bg-red-100 text-red-600 rounded-lg">Rejected</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $enrollments->links() }}</div>
    @endif
@endsection
