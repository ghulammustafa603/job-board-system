<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Storage; // Added for file deletion

class JobController extends Controller
{
    // Show all jobs (limit 10)
    public function index()
    {
        $jobs = Job::latest()->take(10)->get();
        return view('jobs.index', compact('jobs'));
    }

    // Show the form to create a new job
    public function create()
    {
        return view('jobs.create');
    }

    // Store a new job
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'skills' => 'required',
            'city' => 'required',
            'cv' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // CV is now required
        ]);

        if ($request->hasFile('cv')) {
            $validated['cv'] = $request->file('cv')->store('cvs', 'public');
        }

        $validated['skills'] = is_array($validated['skills']) ? implode(',', $validated['skills']) : $validated['skills'];

        $validated['status'] = 'Open'; // Set default status

        Job::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
    }

    // Show the form to edit an existing job
    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    // Update an existing job
    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'skills' => 'required',
            'city' => 'required',
            'cv' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // CV is nullable for update
        ]);

        if ($request->hasFile('cv')) {
            // Delete old CV if exists
            if ($job->cv) {
                Storage::disk('public')->delete($job->cv);
            }
            $validated['cv'] = $request->file('cv')->store('cvs', 'public');
        }

        $validated['skills'] = is_array($validated['skills']) ? implode(',', $validated['skills']) : $validated['skills'];

        $job->update($validated);

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully!');
    }

    // Delete a job
    public function destroy(Job $job)
    {
        // Delete CV file from storage if it exists
        if ($job->cv) {
            Storage::disk('public')->delete($job->cv);
        }
        $job->delete();

        // For AJAX requests, return a JSON response
        if (request()->ajax()) {
            return response()->json(['success' => 'Job deleted successfully.']);
        }

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }
}