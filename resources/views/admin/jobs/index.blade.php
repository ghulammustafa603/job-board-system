<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - JobBoard</title>
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-pattern">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('admin.jobs.index') }}" class="navbar-brand">
                <i class="fas fa-shield-alt"></i> Admin Dashboard
            </a>
            <div class="navbar-nav">
                <span class="nav-link">
                    <i class="fas fa-user-shield"></i> Admin Panel
                </span>
                <a href="{{ route('jobs.index') }}" class="nav-link">
                    <i class="fas fa-briefcase"></i> View Jobs
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Header -->
        <div style="margin: 2rem 0;">
            <h1 style="color: var(--text-primary); margin-bottom: 0.5rem;">
                <i class="fas fa-tasks"></i> Job Applications Management
            </h1>
            <p style="color: var(--text-secondary); margin: 0;">
                Review and manage all job applications from the admin panel
            </p>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 2rem 0;">
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-users" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 0.5rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary);">{{ $jobs->count() ?? 0 }}</h3>
                    <p style="margin: 0; color: var(--text-secondary);">Total Applications</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-clock" style="font-size: 2rem; color: var(--warning-color); margin-bottom: 0.5rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary);">{{ $jobs->where('status', 'pending')->count() ?? 0 }}</h3>
                    <p style="margin: 0; color: var(--text-secondary);">Pending Review</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--success-color); margin-bottom: 0.5rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary);">{{ $jobs->where('status', 'approved')->count() ?? 0 }}</h3>
                    <p style="margin: 0; color: var(--text-secondary);">Approved</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-times-circle" style="font-size: 2rem; color: var(--danger-color); margin-bottom: 0.5rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary);">{{ $jobs->where('status', 'rejected')->count() ?? 0 }}</h3>
                    <p style="margin: 0; color: var(--text-secondary);">Rejected</p>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h2 style="margin: 0; color: white; font-size: 1.25rem;">
                    <i class="fas fa-tools"></i> Bulk Actions
                </h2>
            </div>
            <div class="card-body">
                <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                    <button type="submit" form="bulk-action-form" name="bulk_action" value="approve" class="btn btn-success">
                        <i class="fas fa-check"></i> Approve Selected
                    </button>
                    <button type="submit" form="bulk-action-form" name="bulk_action" value="reject" class="btn btn-danger">
                        <i class="fas fa-times"></i> Reject Selected
                    </button>
                    <button type="submit" form="bulk-action-form" name="bulk_action" value="delete" class="btn btn-secondary">
                        <i class="fas fa-trash"></i> Delete Selected
                    </button>
                    <span style="color: var(--text-secondary); font-size: 0.875rem;">
                        <i class="fas fa-info-circle"></i> Select applications using checkboxes below
                    </span>
                </div>
            </div>
        </div>

        <!-- Applications Table -->
        <form id="bulk-action-form" method="POST" action="{{ route('admin.jobs.bulk-action') }}">
            @csrf
            <div class="table-container">
                <div class="card-header">
                    <h2 style="margin: 0; color: white; font-size: 1.25rem;">
                        <i class="fas fa-list"></i> Job Applications
                    </h2>
                </div>
                <div style="overflow-x: auto;">
                    <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">
                                <input type="checkbox" id="select-all" style="transform: scale(1.2);">
                            </th>
                            <th><i class="fas fa-user"></i> Name</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-phone"></i> Phone</th>
                            <th><i class="fas fa-venus-mars"></i> Gender</th>
                            <th><i class="fas fa-tools"></i> Skills</th>
                            <th><i class="fas fa-map-marker-alt"></i> City</th>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <th><i class="fas fa-calendar"></i> Updated</th>
                            <th><i class="fas fa-user-tie"></i> Employer</th>
                            <th><i class="fas fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs ?? [] as $job)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_jobs[]" value="{{ $job->id }}" style="transform: scale(1.2);">
                                </td>
                                <td>
                                    <strong>{{ $job->first_name }} {{ $job->last_name }}</strong>
                                </td>
                                <td>
                                    <a href="mailto:{{ $job->email }}" style="color: var(--primary-color); text-decoration: none;">
                                        {{ $job->email }}
                                    </a>
                                </td>
                                <td>{{ $job->phone }}</td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ ucfirst($job->gender) }}
                                    </span>
                                </td>
                                <td>{{ $job->skills }}</td>
                                <td>{{ $job->city }}</td>
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
                                <td>{{ $job->user->name ?? 'N/A' }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.jobs.reject', $job->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Delete" onclick="return confirm('Are you sure you want to delete this application?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" style="text-align: center; padding: 2rem;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; color: var(--text-light); margin-bottom: 1rem;"></i>
                                    <p style="color: var(--text-secondary); margin: 0;">No job applications found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </form>
    </div>

    <!-- Footer -->
    <footer style="background: var(--bg-primary); border-top: 1px solid var(--border-color); padding: 2rem 0; margin-top: 4rem;">
        <div class="container">
            <div style="text-align: center; color: var(--text-secondary);">
                <p>&copy; {{ date('Y') }} JobBoard Admin Panel. All rights reserved.</p>
                <p>Administrative dashboard for managing job applications</p>
            </div>
        </div>
    </footer>

    <script>
        // Select all functionality
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_jobs[]"]');
            for (const cb of checkboxes) {
                cb.checked = this.checked;
            }
            updateBulkActionButtons();
        });

        // Individual checkbox functionality
        document.querySelectorAll('input[name="selected_jobs[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActionButtons);
        });

        function updateBulkActionButtons() {
            const selectedCount = document.querySelectorAll('input[name="selected_jobs[]"]:checked').length;
            const bulkButtons = document.querySelectorAll('button[form="bulk-action-form"]');
            
            bulkButtons.forEach(button => {
                if (selectedCount > 0) {
                    button.disabled = false;
                    button.style.opacity = '1';
                } else {
                    button.disabled = true;
                    button.style.opacity = '0.5';
                }
            });
        }

        // Initialize on page load
        updateBulkActionButtons();

        // Add loading states to forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const buttons = this.querySelectorAll('button[type="submit"]');
                buttons.forEach(button => {
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    button.disabled = true;
                    
                    // Re-enable after 5 seconds if form doesn't submit
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 5000);
                });
            });
        });

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