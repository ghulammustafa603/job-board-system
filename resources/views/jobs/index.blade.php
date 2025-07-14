<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board - Find Your Next Opportunity</title>
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-pattern">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('jobs.index') }}" class="navbar-brand">
                <i class="fas fa-briefcase"></i> JobBoard
            </a>
            <div class="navbar-nav">
                @auth
                    <span class="nav-link">
                        <i class="fas fa-user"></i> Welcome, {{ Auth::user()->name }}!
                    </span>
                    <a href="{{ route('jobs.create') }}" class="nav-link">
                        <i class="fas fa-plus"></i> Post Job
                    </a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="nav-link" style="background: var(--warning-color); color: white;">
                            <i class="fas fa-shield-alt"></i> Admin Panel
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="nav-link">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Find Your Dream Job</h1>
            <p>Discover amazing opportunities and connect with top employers. Your next career move starts here.</p>
            @auth
                <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Post New Job
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Get Started
                </a>
            @endauth
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        <div id="ajax-message" class="alert alert-success" style="display:none;"></div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 2rem 0;">
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-users" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary);">{{ $jobs->count() }}</h3>
                    <p style="margin: 0; color: var(--text-secondary);">Total Applications</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--success-color); margin-bottom: 0.5rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary);">{{ $jobs->where('status', 'approved')->count() }}</h3>
                    <p style="margin: 0; color: var(--text-secondary);">Approved</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-clock" style="font-size: 2rem; color: var(--warning-color); margin-bottom: 0.5rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary);">{{ $jobs->where('status', 'pending')->count() }}</h3>
                    <p style="margin: 0; color: var(--text-secondary);">Pending</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-times-circle" style="font-size: 2rem; color: var(--danger-color); margin-bottom: 0.5rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary);">{{ $jobs->where('status', 'rejected')->count() }}</h3>
                    <p style="margin: 0; color: var(--text-secondary);">Rejected</p>
                </div>
            </div>
        </div>

        <!-- Job Applications Table -->
        <div class="table-container">
            <div class="card-header">
                <h2 style="margin: 0; color: white;">
                    <i class="fas fa-list"></i> Job Applications
                </h2>
            </div>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Name</th>
                            <th><i class="fas fa-phone"></i> Phone</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-venus-mars"></i> Gender</th>
                            <th><i class="fas fa-tools"></i> Skills</th>
                            <th><i class="fas fa-map-marker-alt"></i> City</th>
                            <th><i class="fas fa-file"></i> CV/Image</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-calendar"></i> Updated</th>
                            @auth <th><i class="fas fa-cogs"></i> Actions</th> @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                            <tr id="job-{{ $job->id }}">
                                <td>
                                    <strong>{{ $job->first_name }} {{ $job->last_name }}</strong>
                                </td>
                                <td>{{ $job->phone }}</td>
                                <td>
                                    <a href="mailto:{{ $job->email }}" style="color: var(--primary-color); text-decoration: none;">
                                        {{ $job->email }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ ucfirst($job->gender) }}
                                    </span>
                                </td>
                                <td>{{ $job->skills }}</td>
                                <td>{{ $job->city }}</td>
                                <td>
                                    @if($job->cv)
                                        <a href="{{ asset('storage/' . $job->cv) }}" target="_blank" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    @else
                                        <span style="color: var(--text-light);">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($job->status == 'approved')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Approved
                                        </span>
                                    @elseif($job->status == 'pending')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @elseif($job->status == 'rejected')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times"></i> Rejected
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">{{ $job->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $job->updated_at->format('M d, Y') }}</td>
                                @auth
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-success">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteJob({{ $job->id }})">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                @endauth
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::check() ? '10' : '9' }}" style="text-align: center; padding: 2rem;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; color: var(--text-light); margin-bottom: 1rem;"></i>
                                    <p style="color: var(--text-secondary); margin: 0;">No job applications found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: var(--bg-primary); border-top: 1px solid var(--border-color); padding: 2rem 0; margin-top: 4rem;">
        <div class="container">
            <div style="text-align: center; color: var(--text-secondary);">
                <p>&copy; {{ date('Y') }} JobBoard. All rights reserved.</p>
                <p>Built with <i class="fas fa-heart" style="color: var(--danger-color);"></i> for job seekers</p>
            </div>
        </div>
    </footer>

    <script>
        function deleteJob(jobId) {
            if (confirm('Are you sure you want to delete this job application? This action cannot be undone.')) {
                // Show loading state
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
                button.disabled = true;

                fetch('/jobs/' + jobId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove row with animation
                        const row = document.getElementById('job-' + jobId);
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(-100%)';
                        
                        setTimeout(() => {
                            row.remove();
                        }, 300);

                        // Show success message
                        const messageDiv = document.getElementById('ajax-message');
                        messageDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.success;
                        messageDiv.style.display = 'block';
                        messageDiv.className = 'alert alert-success';
                        
                        setTimeout(() => {
                            messageDiv.style.display = 'none';
                        }, 3000);
                    } else {
                        alert('Error: ' + (data.message || 'Could not delete job application.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the job application.');
                })
                .finally(() => {
                    // Restore button state
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            }
        }

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>