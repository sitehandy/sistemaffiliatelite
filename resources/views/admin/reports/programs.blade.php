@extends('layouts.app')
@section('title', 'Programs Report')
@section('page-title', 'Programs Report')

@section('content')
    <div class="mb-6">
        <form method="GET" class="flex items-center space-x-4">
            <div>
                <label class="block text-sm text-gray-600 mb-1">From</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">To</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="pt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Apply</button>
            </div>
            <div class="pt-6">
                <a href="{{ route('admin.reports.export', ['type' => 'programs', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Export CSV</a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commission</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrollments</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conversions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($programs as $program)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $program->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $program->program_type === 'cpa' ? 'bg-blue-100 text-blue-800' : ($program->program_type === 'cps' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                {{ strtoupper($program->program_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if($program->commission_type === 'percentage')
                                {{ $program->commission_amount }}%
                            @else
                                ${{ number_format($program->commission_amount, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $program->enrollments_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $program->conversions_count }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-green-600">${{ number_format($program->total_revenue ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.programs.show', $program) }}" class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No programs found for this period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
