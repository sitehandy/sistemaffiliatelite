<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramEnrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgramEnrollment::with(['user', 'program']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%'));
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function show(ProgramEnrollment $enrollment)
    {
        $enrollment->load(['user', 'program', 'trackingLinks']);
        return view('admin.enrollments.show', compact('enrollment'));
    }

    public function approve(ProgramEnrollment $enrollment)
    {
        if (!$enrollment->isPending()) {
            return back()->with('error', 'Only pending enrollments can be approved.');
        }

        $enrollment->approve();

        return back()->with('success', 'Enrollment approved successfully.');
    }

    public function reject(ProgramEnrollment $enrollment)
    {
        if (!$enrollment->isPending()) {
            return back()->with('error', 'Only pending enrollments can be rejected.');
        }

        $enrollment->reject();

        return back()->with('success', 'Enrollment rejected successfully.');
    }

    public function suspend(ProgramEnrollment $enrollment)
    {
        if (!$enrollment->isApproved()) {
            return back()->with('error', 'Only approved enrollments can be suspended.');
        }

        $enrollment->suspend();

        return back()->with('success', 'Enrollment suspended successfully.');
    }

    public function reactivate(ProgramEnrollment $enrollment)
    {
        if (!$enrollment->isSuspended()) {
            return back()->with('error', 'Only suspended enrollments can be reactivated.');
        }

        $enrollment->reactivate();

        return back()->with('success', 'Enrollment reactivated successfully.');
    }
}
