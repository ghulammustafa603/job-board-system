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
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <i class="fas fa-briefcase"></i> JobBoard Admin
            </a>
            <div class="navbar-nav">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="{{ route('admin.jobs.index') }}" class="nav-link">
                    <i class="fas fa-list"></i> Manage Jobs
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
    <div class="container" style="padding-top: 2rem;">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h1 style="margin: 0; color: white;">
                    <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                </h1>
                <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">
                    Welcome back, {{ Auth::user()->name }}! Here's an overview of your job board.
                </p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-users" style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary); font-size: 2rem;">{{ $totalJobs }}</h3>
                    <p style="margin: 0.5rem 0 0 0; color: var(--text-secondary);">Total Applications</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-clock" style="font-size: 2.5rem; color: var(--warning-color); margin-bottom: 1rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary); font-size: 2rem;">{{ $pendingJobs }}</h3>
                    <p style="margin: 0.5rem 0 0 0; color: var(--text-secondary);">Pending Review</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-check-circle" style="font-size: 2.5rem; color: var(--success-color); margin-bottom: 1rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary); font-size: 2rem;">{{ $approvedJobs }}</h3>
                    <p style="margin: 0.5rem 0 0 0; color: var(--text-secondary);">Approved</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-times-circle" style="font-size: 2.5rem; color: var(--danger-color); margin-bottom: 1rem;"></i>
                    <h3 style="margin: 0; color: var(--text-primary); font-size: 2rem;">{{ $rejectedJobs }}</h3>
                    <p style="margin: 0.5rem 0 0 0; color: var(--text-secondary);">Rejected</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h2 style="margin: 0; color: white;">
                    <i class="fas fa-bolt"></i> Quick Actions
                </h2>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-primary" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 1rem;">
                        <i class="fas fa-list"></i>
                        <span>Manage All Jobs</span>
                    </a>
                    
                    <a href="{{ route('admin.jobs.index') }}?status=pending" class="btn btn-warning" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 1rem;">
                        <i class="fas fa-clock"></i>
                        <span>Review Pending</span>
                    </a>
                    
                    <a href="{{ route('home') }}" class="btn btn-secondary" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 1rem;">
                        <i class="fas fa-home"></i>
                        <span>Go to Home</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="card">
            <div class="card-header">
                <h2 style="margin: 0; color: white;">
                    <i class="fas fa-clock"></i> Recent Applications
                </h2>
            </div>
            <div class="card-body">
                @if($recentJobs->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user"></i> Name</th>
                                    <th><i class="fas fa-envelope"></i> Email</th>
                                    <th><i class="fas fa-info-circle"></i> Status</th>
                                    <th><i class="fas fa-calendar"></i> Applied</th>
                                    <th><i class="fas fa-cogs"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentJobs as $job)
                                    <tr>
                                        <td>
                                            <strong>{{ $job->first_name }} {{ $job->last_name }}</strong>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $job->email }}" style="color: var(--primary-color); text-decoration: none;">
                                                {{ $job->email }}
                                            </a>
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
                                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div style="display: flex; gap: 0.5rem;">
                                                <a href="{{ route('admin.jobs.index') }}#job-{{ $job->id }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem;">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: var(--text-light); margin-bottom: 1rem;"></i>
                        <p style="color: var(--text-secondary); margin: 0;">No recent applications found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: var(--bg-primary); border-top: 1px solid var(--border-color); padding: 2rem 0; margin-top: 4rem;">
        <div class="container">
            <div style="text-align: center; color: var(--text-secondary);">
                <p>&copy; {{ date('Y') }} JobBoard Admin. All rights reserved.</p>
                <p>Admin Dashboard - Manage your job board efficiently</p>
            </div>
        </div>
    </footer>
</body>
</html> 