@extends('layouts.app')

@section('title', 'Edit Program')
@section('page-title', 'Edit Program: ' . $program->name)

@section('content')
    <div class="max-w-3xl">
        <form method="POST" action="{{ route('admin.programs.update', $program) }}" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Program Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $program->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description', $program->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="program_type" class="block text-sm font-medium text-gray-700 mb-1">Program Type</label>
                    <select name="program_type" id="program_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="sale" {{ old('program_type', $program->program_type) === 'sale' ? 'selected' : '' }}>Pay Per Sale</option>
                        <option value="lead" {{ old('program_type', $program->program_type) === 'lead' ? 'selected' : '' }}>Pay Per Lead</option>
                        <option value="view" {{ old('program_type', $program->program_type) === 'view' ? 'selected' : '' }}>Pay Per View</option>
                    </select>
                </div>
                <div>
                    <label for="visibility" class="block text-sm font-medium text-gray-700 mb-1">Visibility</label>
                    <select name="visibility" id="visibility" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="open" {{ old('visibility', $program->visibility) === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="hidden" {{ old('visibility', $program->visibility) === 'hidden' ? 'selected' : '' }}>Hidden</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="commission_type" class="block text-sm font-medium text-gray-700 mb-1">Commission Type</label>
                    <select name="commission_type" id="commission_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="percentage" {{ old('commission_type', $program->commission_type) === 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="flat" {{ old('commission_type', $program->commission_type) === 'flat' ? 'selected' : '' }}>Flat Rate</option>
                    </select>
                </div>
                <div>
                    <label for="commission_amount" class="block text-sm font-medium text-gray-700 mb-1">Commission Amount</label>
                    <input type="number" name="commission_amount" id="commission_amount" value="{{ old('commission_amount', $program->commission_amount) }}" step="0.01" min="0" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div class="mb-6">
                <label for="default_url" class="block text-sm font-medium text-gray-700 mb-1">Default Landing Page URL</label>
                <input type="url" name="default_url" id="default_url" value="{{ old('default_url', $program->default_url) }}" placeholder="https://your-website.com/landing-page"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('default_url') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">This URL will be used when affiliate creates a tracking link without selecting a specific product.</p>
                @error('default_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Assign Products (Optional)</label>
                <div class="border border-gray-300 rounded-lg p-4 max-h-60 overflow-y-auto">
                    @foreach($products as $product)
                        <label class="flex items-center mb-2">
                            <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="rounded border-gray-300 text-blue-600"
                                {{ in_array($product->id, old('product_ids', $program->products->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">{{ $product->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600"
                        {{ old('is_active', $program->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.programs.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Program</button>
            </div>
        </form>
    </div>
@endsection
