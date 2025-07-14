<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JobBoard - Find Your Dream Job</title>
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-pattern">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <i class="fas fa-briefcase"></i> JobBoard
            </a>
            <div class="navbar-nav">
                @auth
                    <a href="{{ route('jobs.index') }}" class="nav-link">
                        <i class="fas fa-list"></i> View Jobs
                    </a>
                    <a href="{{ route('jobs.create') }}" class="nav-link">
                        <i class="fas fa-plus"></i> Post Job
                    </a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="nav-link" style="background: var(--warning-color); color: white;">
                            <i class="fas fa-shield-alt"></i> Admin Panel
                        </a>
                    @endif
                    <span class="nav-link">
                        <i class="fas fa-user"></i> Welcome, {{ Auth::user()->name }}!
                    </span>
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
            <p>Connect with top employers and discover amazing opportunities. Your next career move starts here with our modern job board platform.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                @auth
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i> Browse Jobs
                    </a>
                    <a href="{{ route('jobs.create') }}" class="btn btn-secondary">
                        <i class="fas fa-plus"></i> Post Job
                    </a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn" style="background: var(--warning-color); color: white; border: 2px solid var(--warning-color);">
                            <i class="fas fa-shield-alt"></i> Admin Panel
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Get Started
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section style="padding: 4rem 0; background: var(--bg-primary);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="color: var(--text-primary); margin-bottom: 1rem; font-size: 2.5rem;">
                    Why Choose JobBoard?
                </h2>
                <p style="color: var(--text-secondary); font-size: 1.125rem; max-width: 600px; margin: 0 auto;">
                    Our platform offers everything you need to find your perfect job or hire the best talent
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <i class="fas fa-search" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                        <h3 style="color: var(--text-primary); margin-bottom: 1rem;">Easy Job Search</h3>
                        <p style="color: var(--text-secondary); margin: 0;">
                            Browse through thousands of job opportunities with our intuitive search and filter system.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <i class="fas fa-upload" style="font-size: 3rem; color: var(--success-color); margin-bottom: 1rem;"></i>
                        <h3 style="color: var(--text-primary); margin-bottom: 1rem;">Simple Application</h3>
                        <p style="color: var(--text-secondary); margin: 0;">
                            Apply to jobs with just a few clicks. Upload your CV and let employers find you.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <i class="fas fa-shield-alt" style="font-size: 3rem; color: var(--warning-color); margin-bottom: 1rem;"></i>
                        <h3 style="color: var(--text-primary); margin-bottom: 1rem;">Secure Platform</h3>
                        <p style="color: var(--text-secondary); margin: 0;">
                            Your data is safe with us. We use industry-standard security measures to protect your information.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <i class="fas fa-mobile-alt" style="font-size: 3rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
                        <h3 style="color: var(--text-primary); margin-bottom: 1rem;">Mobile Friendly</h3>
                        <p style="color: var(--text-secondary); margin: 0;">
                            Access JobBoard from anywhere. Our responsive design works perfectly on all devices.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <i class="fas fa-chart-line" style="font-size: 3rem; color: var(--secondary-color); margin-bottom: 1rem;"></i>
                        <h3 style="color: var(--text-primary); margin-bottom: 1rem;">Track Progress</h3>
                        <p style="color: var(--text-secondary); margin: 0;">
                            Monitor your application status and get real-time updates on your job applications.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body" style="text-align: center;">
                        <i class="fas fa-users" style="font-size: 3rem; color: var(--danger-color); margin-bottom: 1rem;"></i>
                        <h3 style="color: var(--text-primary); margin-bottom: 1rem;">Large Network</h3>
                        <p style="color: var(--text-secondary); margin: 0;">
                            Connect with employers from various industries and find opportunities that match your skills.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section style="padding: 4rem 0; background: var(--gradient-primary); color: white;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="margin-bottom: 1rem; font-size: 2.5rem;">JobBoard by the Numbers</h2>
                <p style="opacity: 0.9; font-size: 1.125rem;">
                    Join thousands of job seekers and employers who trust our platform
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center;">
                <div>
                    <h3 style="font-size: 3rem; margin-bottom: 0.5rem;">1000+</h3>
                    <p style="opacity: 0.9; margin: 0;">Active Job Listings</p>
                </div>
                <div>
                    <h3 style="font-size: 3rem; margin-bottom: 0.5rem;">500+</h3>
                    <p style="opacity: 0.9; margin: 0;">Companies Hiring</p>
                </div>
                <div>
                    <h3 style="font-size: 3rem; margin-bottom: 0.5rem;">5000+</h3>
                    <p style="opacity: 0.9; margin: 0;">Successful Placements</p>
                </div>
                <div>
                    <h3 style="font-size: 3rem; margin-bottom: 0.5rem;">98%</h3>
                    <p style="opacity: 0.9; margin: 0;">User Satisfaction</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="padding: 4rem 0; background: var(--bg-secondary);">
        <div class="container">
            <div style="text-align: center; max-width: 600px; margin: 0 auto;">
                <h2 style="color: var(--text-primary); margin-bottom: 1rem; font-size: 2.5rem;">
                    Ready to Start Your Journey?
                </h2>
                <p style="color: var(--text-secondary); font-size: 1.125rem; margin-bottom: 2rem;">
                    Join thousands of professionals who have found their dream jobs through JobBoard
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    @auth
                        <a href="{{ route('jobs.index') }}" class="btn btn-primary">
                            <i class="fas fa-search"></i> Browse Jobs
                        </a>
                        <a href="{{ route('jobs.create') }}" class="btn btn-secondary">
                            <i class="fas fa-plus"></i> Post a Job
                        </a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn" style="background: var(--warning-color); color: white; border: 2px solid var(--warning-color);">
                                <i class="fas fa-shield-alt"></i> Admin Panel
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Create Account
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-secondary">
                            <i class="fas fa-sign-in-alt"></i> Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: var(--bg-primary); border-top: 1px solid var(--border-color); padding: 3rem 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <h3 style="color: var(--text-primary); margin-bottom: 1rem;">
                        <i class="fas fa-briefcase"></i> JobBoard
                    </h3>
                    <p style="color: var(--text-secondary); margin: 0;">
                        Connecting talented professionals with amazing opportunities. Your career journey starts here.
                    </p>
                </div>
                <div>
                    <h4 style="color: var(--text-primary); margin-bottom: 1rem;">For Job Seekers</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; color: var(--text-secondary);">
                        <li style="margin-bottom: 0.5rem;"><i class="fas fa-search"></i> Browse Jobs</li>
                        <li style="margin-bottom: 0.5rem;"><i class="fas fa-upload"></i> Upload CV</li>
                        <li style="margin-bottom: 0.5rem;"><i class="fas fa-chart-line"></i> Track Applications</li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: var(--text-primary); margin-bottom: 1rem;">For Employers</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; color: var(--text-secondary);">
                        <li style="margin-bottom: 0.5rem;"><i class="fas fa-plus"></i> Post Jobs</li>
                        <li style="margin-bottom: 0.5rem;"><i class="fas fa-users"></i> Find Talent</li>
                        <li style="margin-bottom: 0.5rem;"><i class="fas fa-chart-bar"></i> Analytics</li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: var(--text-primary); margin-bottom: 1rem;">Contact</h4>
                    <ul style="list-style: none; padding: 0; margin: 0; color: var(--text-secondary);">
                        <li style="margin-bottom: 0.5rem;"><i class="fas fa-envelope"></i> support@jobboard.com</li>
                        <li style="margin-bottom: 0.5rem;"><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                        <li style="margin-bottom: 0.5rem;"><i class="fas fa-map-marker-alt"></i> 123 Job Street, City</li>
                    </ul>
                </div>
            </div>
            <div style="text-align: center; padding-top: 2rem; border-top: 1px solid var(--border-color); color: var(--text-secondary);">
                <p>&copy; {{ date('Y') }} JobBoard. All rights reserved. Built with <i class="fas fa-heart" style="color: var(--danger-color);"></i> for job seekers and employers.</p>
            </div>
        </div>
    </footer>

    <script>
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>
