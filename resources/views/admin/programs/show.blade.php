@extends('layouts.app')

@section('title', $program->name)
@section('page-title', $program->name)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Program Details</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-500">Type</dt><dd class="font-medium">{{ ucfirst($program->program_type) }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Visibility</dt><dd class="font-medium">{{ ucfirst($program->visibility) }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Commission</dt><dd class="font-medium">{{ $program->commission_type === 'percentage' ? $program->commission_amount.'%' : '$'.number_format($program->commission_amount, 2) }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2 py-1 text-xs rounded-full {{ $program->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $program->is_active ? 'Active' : 'Inactive' }}</span></dd></div>
                </dl>
                @if($program->description)<p class="mt-4 text-gray-600">{{ $program->description }}</p>@endif
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Enrollments ({{ $program->enrollments->count() }})</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead><tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Affiliate</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Enrolled</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($program->enrollments as $enrollment)
                            <tr>
                                <td class="px-4 py-3">{{ $enrollment->user->name }}<br><span class="text-xs text-gray-500">{{ $enrollment->user->email }}</span></td>
                                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded-full @if($enrollment->status==='approved')bg-green-100 text-green-800 @elseif($enrollment->status==='pending')bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">{{ ucfirst($enrollment->status) }}</span></td>
                                <td class="px-4 py-3 text-sm">{{ $enrollment->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-4 text-center text-gray-500">No enrollments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Products ({{ $program->products->count() }})</h3>
                <ul class="space-y-2">
                    @forelse($program->products as $product)
                        <li class="text-sm"><a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:underline">{{ $product->name }}</a></li>
                    @empty
                        <li class="text-sm text-gray-500">No products assigned.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.programs.edit', $program) }}" class="block w-full px-4 py-2 text-center bg-blue-600 text-white rounded-lg hover:bg-blue-700">Edit Program</a>
                    <form method="POST" action="{{ route('admin.programs.toggle-status', $program) }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 {{ $program->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg">
                            {{ $program->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
