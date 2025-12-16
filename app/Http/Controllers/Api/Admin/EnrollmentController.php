<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramEnrollment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ProgramEnrollment::with(['user', 'program']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('program_id')) {
            $query->where('affiliate_program_id', $request->program_id);
        }

        $enrollments = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($enrollments);
    }

    public function show(ProgramEnrollment $enrollment): JsonResponse
    {
        $enrollment->load(['user', 'program', 'trackingLinks']);

        return response()->json($enrollment);
    }

    public function approve(ProgramEnrollment $enrollment): JsonResponse
    {
        if (!$enrollment->isPending()) {
            return response()->json([
                'message' => 'Only pending enrollments can be approved.',
            ], 422);
        }

        $enrollment->approve();

        return response()->json([
            'message' => 'Enrollment approved successfully.',
            'enrollment' => $enrollment->fresh(['user', 'program']),
        ]);
    }

    public function reject(Request $request, ProgramEnrollment $enrollment): JsonResponse
    {
        if (!$enrollment->isPending()) {
            return response()->json([
                'message' => 'Only pending enrollments can be rejected.',
            ], 422);
        }

        $validated = $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $enrollment->reject($validated['reason'] ?? null);

        return response()->json([
            'message' => 'Enrollment rejected successfully.',
            'enrollment' => $enrollment->fresh(['user', 'program']),
        ]);
    }

    public function suspend(ProgramEnrollment $enrollment): JsonResponse
    {
        if (!$enrollment->isApproved()) {
            return response()->json([
                'message' => 'Only approved enrollments can be suspended.',
            ], 422);
        }

        $enrollment->suspend();

        return response()->json([
            'message' => 'Enrollment suspended successfully.',
            'enrollment' => $enrollment->fresh(['user', 'program']),
        ]);
    }

    public function reactivate(ProgramEnrollment $enrollment): JsonResponse
    {
        if (!$enrollment->isSuspended()) {
            return response()->json([
                'message' => 'Only suspended enrollments can be reactivated.',
            ], 422);
        }

        $enrollment->approve();

        return response()->json([
            'message' => 'Enrollment reactivated successfully.',
            'enrollment' => $enrollment->fresh(['user', 'program']),
        ]);
    }
}
