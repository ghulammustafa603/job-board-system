<!DOCTYPE html>
<html>
<head>
    <title>Job Listings</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .navbar .user-info {
            font-weight: bold;
        }
        .container { margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .success { color: green; margin-bottom: 10px; }
        .error { color: red; margin-bottom: 10px; }
        a.button { background: #007bff; color: #fff; padding: 6px 12px; text-decoration: none; border-radius: 4px; display: inline-block; margin-bottom: 15px; }
        a.button:hover { background: #0056b3; }
        .action-buttons button, .action-buttons a {
            margin-right: 5px;
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .action-buttons .edit-btn { background-color: #28a745; }
        .action-buttons .edit-btn:hover { background-color: #218838; }
        .action-buttons .delete-btn { background-color: #dc3545; }
        .action-buttons .delete-btn:hover { background-color: #c82333; }
        .logout-form button {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            text-decoration: none;
            padding: 0;
            font-size: 1em;
            margin-left: 20px;
            font-family: Arial, sans-serif;
        }
        .logout-form button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="{{ route('jobs.index') }}">Job Board</a>
        </div>
        <div>
            @auth {{-- Checks if a user is logged in --}}
                <span class="user-info">Welcome, {{ Auth::user()->name }}!</span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;" class="logout-form">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else {{-- If no user is logged in --}}
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>

    <div class="container">
        <h1>Job Listings</h1>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        <div id="ajax-message" class="success" style="display:none;"></div>

        {{-- Show "Add New Job" button only if logged in --}}
        @auth
            <a href="{{ route('jobs.create') }}" class="button">Add New Job</a>
        @endauth

        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Skills</th>
                    <th>City</th>
                    <th>CV/Image</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    @auth <th>Actions</th> @endauth {{-- Show Actions only if logged in --}}
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr id="job-{{ $job->id }}">
                        <td>{{ $job->first_name }}</td>
                        <td>{{ $job->last_name }}</td>
                        <td>{{ $job->phone }}</td>
                        <td>{{ $job->email }}</td>
                        <td>{{ ucfirst($job->gender) }}</td>
                        <td>{{ $job->skills }}</td>
                        <td>{{ $job->city }}</td>
                        <td>
                            @if($job->cv)
                                <a href="{{ asset('storage/' . $job->cv) }}" target="_blank">View</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $job->status }}</td>
                        <td>{{ $job->updated_at }}</td>
                        @auth {{-- Show Edit/Delete only if logged in --}}
                            <td class="action-buttons">
                                <a href="{{ route('jobs.edit', $job->id) }}" class="edit-btn">Edit</a>
                                <button class="delete-btn" onclick="deleteJob({{ $job->id }})">Delete</button>
                            </td>
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ Auth::check() ? '11' : '10' }}">No jobs found.</td> {{-- Adjust colspan based on auth --}}
                    </tr>
                @endforelse
            </tbody>
        </table>

        <script>
            function deleteJob(jobId) {
                if (confirm('Are you sure you want to delete this job?')) {
                    fetch('/jobs/' + jobId, {
                        method: 'POST', // Use POST for DELETE in Laravel with _method
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF token
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest' // Identify as AJAX request
                        },
                        body: JSON.stringify({
                            _method: 'DELETE' // Method spoofing for DELETE request
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('job-' + jobId).remove(); // Remove row from table
                            const messageDiv = document.getElementById('ajax-message');
                            messageDiv.textContent = data.success;
                            messageDiv.style.display = 'block';
                            setTimeout(() => messageDiv.style.display = 'none', 3000); // Hide after 3 seconds
                        } else {
                            alert('Error: ' + (data.message || 'Could not delete job.'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the job.');
                    });
                }
            }
        </script>
    </div>
</body>
</html>