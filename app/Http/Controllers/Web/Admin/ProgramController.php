<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProgram;
use App\Models\Product;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = AffiliateProgram::with('products')->withCount('enrollments');

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.programs.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'program_type' => ['required', 'in:sale,view,lead'],
            'commission_type' => ['required', 'in:flat,percentage'],
            'commission_amount' => ['required', 'numeric', 'min:0'],
            'visibility' => ['required', 'in:open,hidden'],
            'default_url' => ['nullable', 'url', 'max:500'],
            'is_active' => ['nullable'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['exists:products,id'],
        ]);

        $program = AffiliateProgram::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'program_type' => $validated['program_type'],
            'commission_type' => $validated['commission_type'],
            'commission_amount' => $validated['commission_amount'],
            'visibility' => $validated['visibility'],
            'default_url' => $validated['default_url'] ?? null,
            'is_active' => $request->has('is_active'),
            'created_by' => auth()->id(),
        ]);

        if (!empty($validated['product_ids'])) {
            $program->products()->attach($validated['product_ids']);
        }

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
    }

    public function show(AffiliateProgram $program)
    {
        $program->load(['products', 'enrollments.user']);
        return view('admin.programs.show', compact('program'));
    }

    public function edit(AffiliateProgram $program)
    {
        $products = Product::where('is_active', true)->get();
        $program->load('products');
        return view('admin.programs.edit', compact('program', 'products'));
    }

    public function update(Request $request, AffiliateProgram $program)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'program_type' => ['required', 'in:sale,view,lead'],
            'commission_type' => ['required', 'in:flat,percentage'],
            'commission_amount' => ['required', 'numeric', 'min:0'],
            'visibility' => ['required', 'in:open,hidden'],
            'default_url' => ['nullable', 'url', 'max:500'],
            'is_active' => ['nullable'],
            'product_ids' => ['nullable', 'array'],
            'product_ids.*' => ['exists:products,id'],
        ]);

        $program->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'program_type' => $validated['program_type'],
            'commission_type' => $validated['commission_type'],
            'commission_amount' => $validated['commission_amount'],
            'visibility' => $validated['visibility'],
            'default_url' => $validated['default_url'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        $program->products()->sync($validated['product_ids'] ?? []);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }

    public function destroy(AffiliateProgram $program)
    {
        if ($program->enrollments()->exists()) {
            return back()->with('error', 'Cannot delete program with existing enrollments.');
        }

        $program->products()->detach();
        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }

    public function toggleStatus(AffiliateProgram $program)
    {
        $program->update(['is_active' => !$program->is_active]);

        return back()->with('success', 'Program status updated successfully.');
    }
}
