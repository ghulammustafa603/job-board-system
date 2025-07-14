<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - JobBoard</title>
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-pattern">
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
        <div class="card" style="max-width: 450px; width: 100%;">
            <div class="card-header" style="text-align: center;">
                <h1 style="margin: 0; color: white; font-size: 1.5rem;">
                    <i class="fas fa-user-plus"></i> Create Account
                </h1>
                <p style="margin: 0.5rem 0 0 0; opacity: 0.9; font-size: 0.875rem;">
                    Join JobBoard and start your journey
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

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i> Full Name
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            class="form-control"
                            placeholder="Enter your full name"
                        >
                    </div>

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
                            placeholder="Create a strong password"
                        >
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i> Confirm Password
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            class="form-control"
                            placeholder="Confirm your password"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                </form>

                <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                    <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                        Already have an account?
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="width: 100%;">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Background decoration -->
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: -1;">
        <div style="position: absolute; top: 15%; right: 10%; width: 180px; height: 180px; background: var(--gradient-secondary); border-radius: 50%; opacity: 0.1; animation: float 7s ease-in-out infinite;"></div>
        <div style="position: absolute; bottom: 15%; left: 10%; width: 120px; height: 120px; background: var(--gradient-primary); border-radius: 50%; opacity: 0.1; animation: float 9s ease-in-out infinite reverse;"></div>
        <div style="position: absolute; top: 70%; right: 5%; width: 80px; height: 80px; background: var(--accent-color); border-radius: 50%; opacity: 0.1; animation: float 11s ease-in-out infinite;"></div>
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

        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword && password !== confirmPassword) {
                confirmPasswordInput.style.borderColor = 'var(--danger-color)';
                confirmPasswordInput.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
            } else {
                confirmPasswordInput.style.borderColor = '';
                confirmPasswordInput.style.boxShadow = '';
            }
        }

        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        // Add loading state to form
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
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