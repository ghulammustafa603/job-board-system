<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminJobController extends Controller
{
    public function dashboard()
    {
        $totalJobs = \App\Models\Job::count();
        $pendingJobs = \App\Models\Job::where('status', 'pending')->count();
        $approvedJobs = \App\Models\Job::where('status', 'approved')->count();
        $rejectedJobs = \App\Models\Job::where('status', 'rejected')->count();
        $recentJobs = \App\Models\Job::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalJobs', 'pendingJobs', 'approvedJobs', 'rejectedJobs', 'recentJobs'));
    }

    public function index()
    {
        $jobs = \App\Models\Job::with('user')->latest()->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    public function approve($id)
    {
        $job = \App\Models\Job::findOrFail($id);
        $job->status = 'approved';
        $job->save();
        return back()->with('success', 'Job approved successfully.');
    }

    public function reject($id)
    {
        $job = \App\Models\Job::findOrFail($id);
        $job->status = 'rejected';
        $job->save();
        return back()->with('success', 'Job rejected successfully.');
    }

    public function destroy($id)
    {
        $job = \App\Models\Job::findOrFail($id);
        $job->delete();
        return back()->with('success', 'Job deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('selected_jobs', []);
        if (empty($ids)) {
            return back()->with('error', 'No jobs selected.');
        }
        if ($action === 'approve') {
            \App\Models\Job::whereIn('id', $ids)->update(['status' => 'approved']);
            return back()->with('success', 'Selected jobs approved.');
        } elseif ($action === 'reject') {
            \App\Models\Job::whereIn('id', $ids)->update(['status' => 'rejected']);
            return back()->with('success', 'Selected jobs rejected.');
        } elseif ($action === 'delete') {
            \App\Models\Job::whereIn('id', $ids)->delete();
            return back()->with('success', 'Selected jobs deleted.');
        }
        return back()->with('error', 'Invalid action.');
    }
}
