<?php

namespace App\Http\Controllers\Web\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateProgram;
use App\Models\ProgramEnrollment;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = AffiliateProgram::where('is_active', true)
            ->where('visibility', 'open')
            ->with('products');

        if ($request->filled('type')) {
            $query->where('program_type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $programs = $query->paginate(12);

        // Get user's enrolled programs
        $enrolledProgramIds = auth()->user()->enrollments()
            ->pluck('program_id')
            ->toArray();

        return view('affiliate.programs.index', compact('programs', 'enrolledProgramIds'));
    }

    public function enrolled()
    {
        $enrollments = auth()->user()->enrollments()
            ->with(['program.products'])
            ->paginate(12);

        return view('affiliate.programs.enrolled', compact('enrollments'));
    }

    public function show(AffiliateProgram $program)
    {
        if (!$program->is_active || $program->visibility !== 'open') {
            abort(404);
        }

        $program->load('products');

        $enrollment = auth()->user()->enrollments()
            ->where('program_id', $program->id)
            ->first();

        return view('affiliate.programs.show', compact('program', 'enrollment'));
    }

    public function enroll(AffiliateProgram $program)
    {
        if (!$program->is_active || $program->visibility !== 'open') {
            return back()->with('error', 'This program is not available for enrollment.');
        }

        // Check if already enrolled
        $existing = auth()->user()->enrollments()
            ->where('program_id', $program->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You are already enrolled in this program.');
        }

        // Create enrollment
        $enrollment = ProgramEnrollment::create([
            'user_id' => auth()->id(),
            'program_id' => $program->id,
            'status' => 'pending',
        ]);

        return redirect()->route('affiliate.programs.enrolled')
            ->with('success', 'Enrollment request submitted. Please wait for approval.');
    }

    public function leave(AffiliateProgram $program)
    {
        $enrollment = auth()->user()->enrollments()
            ->where('program_id', $program->id)
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'You are not enrolled in this program.');
        }

        // Can only leave if pending or approved (not if has active commissions)
        $hasActiveCommissions = auth()->user()->commissions()
            ->whereHas('conversion.trackingEvent.trackingLink', fn($q) => $q->where('program_id', $program->id))
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($hasActiveCommissions) {
            return back()->with('error', 'You cannot leave this program while you have pending or approved commissions.');
        }

        $enrollment->delete();

        return redirect()->route('affiliate.programs.enrolled')
            ->with('success', 'You have left the program.');
    }

    public function joinWithCode(Request $request)
    {
        $validated = $request->validate([
            'invitation_code' => ['required', 'string'],
        ]);

        $program = AffiliateProgram::where('invitation_code', $validated['invitation_code'])
            ->where('is_active', true)
            ->first();

        if (!$program) {
            return back()->with('error', 'Invalid invitation code.');
        }

        // Check if already enrolled
        $existing = auth()->user()->enrollments()
            ->where('program_id', $program->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You are already enrolled in this program.');
        }

        // Create enrollment (auto-approve for invitation)
        $enrollment = ProgramEnrollment::create([
            'user_id' => auth()->id(),
            'program_id' => $program->id,
            'status' => 'approved',
            'enrolled_at' => now(),
        ]);

        return redirect()->route('affiliate.programs.enrolled')
            ->with('success', 'You have successfully joined the program.');
    }
}
