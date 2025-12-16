<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AffiliateProgramController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AffiliateProgram::with('products');

        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $programs = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($programs);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'program_type' => ['required', 'in:sale,view,lead'],
            'commission_type' => ['required', 'in:flat,percentage'],
            'commission_amount' => ['required', 'numeric', 'min:0'],
            'visibility' => ['sometimes', 'in:open,hidden'],
            'is_active' => ['boolean'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['exists:products,id'],
        ]);

        $program = AffiliateProgram::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'program_type' => $validated['program_type'],
            'commission_type' => $validated['commission_type'],
            'commission_amount' => $validated['commission_amount'],
            'visibility' => $validated['visibility'] ?? 'open',
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if (!empty($validated['product_ids'])) {
            $program->products()->attach($validated['product_ids']);
        }

        $program->load('products');

        return response()->json([
            'message' => 'Affiliate program created successfully.',
            'program' => $program,
        ], 201);
    }

    public function show(AffiliateProgram $program): JsonResponse
    {
        $program->load(['products', 'enrollments.user']);

        return response()->json($program);
    }

    public function update(Request $request, AffiliateProgram $program): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'program_type' => ['sometimes', 'in:sale,view,lead'],
            'commission_type' => ['sometimes', 'in:flat,percentage'],
            'commission_amount' => ['sometimes', 'numeric', 'min:0'],
            'visibility' => ['sometimes', 'in:open,hidden'],
            'is_active' => ['sometimes', 'boolean'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['exists:products,id'],
        ]);

        $program->update(collect($validated)->except('product_ids')->toArray());

        if (array_key_exists('product_ids', $validated)) {
            $program->products()->sync($validated['product_ids'] ?? []);
        }

        $program->load('products');

        return response()->json([
            'message' => 'Affiliate program updated successfully.',
            'program' => $program,
        ]);
    }

    public function destroy(AffiliateProgram $program): JsonResponse
    {
        if ($program->enrollments()->exists()) {
            return response()->json([
                'message' => 'Cannot delete program with existing enrollments.',
            ], 422);
        }

        $program->products()->detach();
        $program->delete();

        return response()->json([
            'message' => 'Affiliate program deleted successfully.',
        ]);
    }

    public function toggleStatus(AffiliateProgram $program): JsonResponse
    {
        $program->update(['is_active' => !$program->is_active]);

        return response()->json([
            'message' => 'Program status updated successfully.',
            'is_active' => $program->is_active,
        ]);
    }
}
