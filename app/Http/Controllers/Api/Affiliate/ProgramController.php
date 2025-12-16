<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProgram;
use App\Models\ProgramEnrollment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AffiliateProgram::where('is_active', true)
            ->with('products');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $programs = $query->orderBy('name')
            ->paginate($request->get('per_page', 15));

        return response()->json($programs);
    }

    public function show(AffiliateProgram $program): JsonResponse
    {
        if (!$program->is_active) {
            return response()->json([
                'message' => 'Program not found.',
            ], 404);
        }

        $program->load('products');

        $enrollment = ProgramEnrollment::where('user_id', auth()->id())
            ->where('affiliate_program_id', $program->id)
            ->first();

        return response()->json([
            'program' => $program,
            'enrollment' => $enrollment,
        ]);
    }

    public function enroll(Request $request, AffiliateProgram $program): JsonResponse
    {
        if (!$program->is_active) {
            return response()->json([
                'message' => 'This program is not available for enrollment.',
            ], 422);
        }

        $existingEnrollment = ProgramEnrollment::where('user_id', auth()->id())
            ->where('affiliate_program_id', $program->id)
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'message' => 'You are already enrolled in this program.',
                'enrollment' => $existingEnrollment,
            ], 422);
        }

        $enrollment = ProgramEnrollment::create([
            'user_id' => auth()->id(),
            'affiliate_program_id' => $program->id,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Enrollment request submitted successfully.',
            'enrollment' => $enrollment->load('program'),
        ], 201);
    }

    public function myEnrollments(Request $request): JsonResponse
    {
        $query = ProgramEnrollment::where('user_id', auth()->id())
            ->with('program');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($enrollments);
    }

    public function cancelEnrollment(ProgramEnrollment $enrollment): JsonResponse
    {
        if ($enrollment->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        if (!$enrollment->isPending()) {
            return response()->json([
                'message' => 'Only pending enrollments can be cancelled.',
            ], 422);
        }

        $enrollment->delete();

        return response()->json([
            'message' => 'Enrollment cancelled successfully.',
        ]);
    }
}
