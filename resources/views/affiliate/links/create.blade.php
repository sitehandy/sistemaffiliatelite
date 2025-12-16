@extends('layouts.app')
@section('title', 'Create Tracking Link')
@section('page-title', 'Create Tracking Link')

@section('content')
    <div class="max-w-xl">
        @if($enrollments->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500 mb-4">You need to join a program first before creating tracking links.</p>
                <a href="{{ route('affiliate.programs.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Browse Programs</a>
            </div>
        @else
            <form method="POST" action="{{ route('affiliate.links.store') }}" class="bg-white rounded-lg shadow p-6" x-data="{ programId: '' }">
                @csrf
                <div class="mb-6">
                    <label for="program_id" class="block text-sm font-medium text-gray-700 mb-1">Select Program</label>
                    <select name="program_id" id="program_id" required x-model="programId" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Select Program --</option>
                        @foreach($enrollments as $enrollment)
                            <option value="{{ $enrollment->program->id }}">{{ $enrollment->program->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Select Product (Optional)</label>
                    <select name="product_id" id="product_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Use Program Default URL --</option>
                        @foreach($enrollments as $enrollment)
                            @foreach($enrollment->program->products as $product)
                                <option value="{{ $product->id }}" x-show="programId == '{{ $enrollment->program->id }}'">{{ $product->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Leave empty to use the program's default landing page URL.</p>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('affiliate.links.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Link</button>
                </div>
            </form>
        @endif
    </div>
@endsection
