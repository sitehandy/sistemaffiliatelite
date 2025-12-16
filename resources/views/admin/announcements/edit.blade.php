@extends('layouts.app')
@section('title', 'Edit Announcement')
@section('page-title', 'Edit Announcement')

@section('content')
    <div class="max-w-3xl">
        <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <div id="editor" class="bg-white"></div>
                <textarea name="content" id="content" class="hidden">{{ old('content', $announcement->content) }}</textarea>
                @error('content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="info" {{ old('type', $announcement->type) === 'info' ? 'selected' : '' }}>Info (Blue)</option>
                    <option value="success" {{ old('type', $announcement->type) === 'success' ? 'selected' : '' }}>Success (Green)</option>
                    <option value="warning" {{ old('type', $announcement->type) === 'warning' ? 'selected' : '' }}>Warning (Yellow)</option>
                    <option value="danger" {{ old('type', $announcement->type) === 'danger' ? 'selected' : '' }}>Danger (Red)</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Publish Date</label>
                    <input type="datetime-local" name="published_at" id="published_at"
                        value="{{ old('published_at', $announcement->published_at?->format('Y-m-d\TH:i')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                    <input type="datetime-local" name="expires_at" id="expires_at"
                        value="{{ old('expires_at', $announcement->expires_at?->format('Y-m-d\TH:i')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mb-6 space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600"
                        {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="is_pinned" value="1" class="rounded border-gray-300 text-blue-600"
                        {{ old('is_pinned', $announcement->is_pinned) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Pin to top</span>
                </label>
            </div>

            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Created by:</span> {{ $announcement->author->name ?? 'Unknown' }}<br>
                    <span class="font-medium">Created:</span> {{ $announcement->created_at->format('M d, Y H:i') }}
                </p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Announcement
                </button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar { border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
    .ql-container { border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; font-size: 14px; }
    .ql-editor { min-height: 200px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link'],
                ['clean']
            ]
        }
    });

    // Set initial content
    quill.root.innerHTML = document.getElementById('content').value;

    // Sync content to hidden textarea on form submit
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('content').value = quill.root.innerHTML;
    });
</script>
@endpush
