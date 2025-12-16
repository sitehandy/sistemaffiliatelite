@extends('layouts.app')
@section('title', 'Create Product')
@section('page-title', 'Create Product')

@section('content')
    <div class="max-w-3xl">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
            @csrf
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('description') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="website_url" class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                    <input type="url" name="website_url" id="website_url" value="{{ old('website_url') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="mb-6">
                <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Images</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Assign to Programs</label>
                <div class="border border-gray-300 rounded-lg p-4 max-h-60 overflow-y-auto">
                    @foreach($programs as $program)
                        <label class="flex items-center mb-2"><input type="checkbox" name="program_ids[]" value="{{ $program->id }}" class="rounded border-gray-300 text-blue-600"><span class="ml-2 text-sm">{{ $program->name }}</span></label>
                    @endforeach
                </div>
            </div>
            <div class="mb-6"><label class="flex items-center"><input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-blue-600"><span class="ml-2 text-sm">Active</span></label></div>
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Product</button>
            </div>
        </form>
    </div>
@endsection
