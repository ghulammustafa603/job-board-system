<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JobBoard</title>
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-pattern">
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
        <div class="card" style="max-width: 400px; width: 100%;">
            <div class="card-header" style="text-align: center;">
                <h1 style="margin: 0; color: white; font-size: 1.5rem;">
                    <i class="fas fa-sign-in-alt"></i> Welcome Back
                </h1>
                <p style="margin: 0.5rem 0 0 0; opacity: 0.9; font-size: 0.875rem;">
                    Sign in to your JobBoard account
                </p>
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            class="form-control"
                            placeholder="Enter your email address"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="form-control"
                            placeholder="Enter your password"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                    <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                        Don't have an account?
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-secondary" style="width: 100%;">
                        <i class="fas fa-user-plus"></i> Create Account
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Background decoration -->
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -1;">
        <div style="position: absolute; top: 10%; left: 10%; width: 200px; height: 200px; background: var(--gradient-primary); border-radius: 50%; opacity: 0.1; animation: float 6s ease-in-out infinite;"></div>
        <div style="position: absolute; bottom: 20%; right: 15%; width: 150px; height: 150px; background: var(--gradient-secondary); border-radius: 50%; opacity: 0.1; animation: float 8s ease-in-out infinite reverse;"></div>
        <div style="position: absolute; top: 60%; left: 5%; width: 100px; height: 100px; background: var(--accent-color); border-radius: 50%; opacity: 0.1; animation: float 10s ease-in-out infinite;"></div>
    </div>

    <script>
        // Add focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Add loading state to form
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
            button.disabled = true;
            
            // Re-enable after 5 seconds if form doesn't submit
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 5000);
        });
    </script>
</body>
</html>