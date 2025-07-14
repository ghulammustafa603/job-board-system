<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job Application - JobBoard</title>
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
                <a href="{{ route('jobs.index') }}" class="nav-link">
                    <i class="fas fa-list"></i> View Applications
                </a>
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
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div style="max-width: 800px; margin: 2rem auto;">
            <div class="card">
                <div class="card-header">
                    <h1 style="margin: 0; color: white; font-size: 1.5rem;">
                        <i class="fas fa-edit"></i> Edit Job Application
                    </h1>
                    <p style="margin: 0.5rem 0 0 0; opacity: 0.9; font-size: 0.875rem;">
                        Update the job application details below
                    </p>
                </div>
                
                <div class="card-body">
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

                    <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <div class="form-group">
                                <label for="first_name" class="form-label">
                                    <i class="fas fa-user"></i> First Name
                                </label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    value="{{ old('first_name', $job->first_name) }}" 
                                    required
                                    class="form-control"
                                    placeholder="Enter first name"
                                >
                            </div>

                            <div class="form-group">
                                <label for="last_name" class="form-label">
                                    <i class="fas fa-user"></i> Last Name
                                </label>
                                <input 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name" 
                                    value="{{ old('last_name', $job->last_name) }}" 
                                    required
                                    class="form-control"
                                    placeholder="Enter last name"
                                >
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <div class="form-group">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone"></i> Phone Number
                                </label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    value="{{ old('phone', $job->phone) }}" 
                                    required
                                    class="form-control"
                                    placeholder="Enter phone number"
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
                                    value="{{ old('email', $job->email) }}" 
                                    required
                                    class="form-control"
                                    placeholder="Enter email address"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-venus-mars"></i> Gender
                            </label>
                            <div style="display: flex; gap: 2rem; margin-top: 0.5rem;">
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                    <input type="radio" name="gender" value="male" required {{ old('gender', $job->gender) == 'male' ? 'checked' : '' }}>
                                    <i class="fas fa-mars"></i> Male
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                    <input type="radio" name="gender" value="female" required {{ old('gender', $job->gender) == 'female' ? 'checked' : '' }}>
                                    <i class="fas fa-venus"></i> Female
                                </label>
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                    <input type="radio" name="gender" value="other" required {{ old('gender', $job->gender) == 'other' ? 'checked' : '' }}>
                                    <i class="fas fa-genderless"></i> Other
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="skills" class="form-label">
                                <i class="fas fa-tools"></i> Skills (Hold Ctrl/Cmd to select multiple)
                            </label>
                            @php
                                $selectedSkills = explode(',', old('skills', $job->skills));
                            @endphp
                            <select 
                                id="skills" 
                                name="skills[]" 
                                multiple 
                                required
                                class="form-control"
                                style="min-height: 120px;"
                            >
                                <option value="Java" {{ in_array('Java', $selectedSkills) ? 'selected' : '' }}>Java</option>
                                <option value="PHP" {{ in_array('PHP', $selectedSkills) ? 'selected' : '' }}>PHP</option>
                                <option value="C++" {{ in_array('C++', $selectedSkills) ? 'selected' : '' }}>C++</option>
                                <option value="C#" {{ in_array('C#', $selectedSkills) ? 'selected' : '' }}>C#</option>
                                <option value="Python" {{ in_array('Python', $selectedSkills) ? 'selected' : '' }}>Python</option>
                                <option value="JavaScript" {{ in_array('JavaScript', $selectedSkills) ? 'selected' : '' }}>JavaScript</option>
                                <option value="React" {{ in_array('React', $selectedSkills) ? 'selected' : '' }}>React</option>
                                <option value="Vue.js" {{ in_array('Vue.js', $selectedSkills) ? 'selected' : '' }}>Vue.js</option>
                                <option value="Laravel" {{ in_array('Laravel', $selectedSkills) ? 'selected' : '' }}>Laravel</option>
                                <option value="Node.js" {{ in_array('Node.js', $selectedSkills) ? 'selected' : '' }}>Node.js</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="city" class="form-label">
                                <i class="fas fa-map-marker-alt"></i> City
                            </label>
                            <select 
                                id="city" 
                                name="city" 
                                required
                                class="form-control"
                            >
                                <option value="">Select City</option>
                                <option value="Karachi" {{ old('city', $job->city) == 'Karachi' ? 'selected' : '' }}>Karachi</option>
                                <option value="Lahore" {{ old('city', $job->city) == 'Lahore' ? 'selected' : '' }}>Lahore</option>
                                <option value="Islamabad" {{ old('city', $job->city) == 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
                                <option value="Hyderabad" {{ old('city', $job->city) == 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
                                <option value="Daharki" {{ old('city', $job->city) == 'Daharki' ? 'selected' : '' }}>Daharki</option>
                                <option value="Shikarpur" {{ old('city', $job->city) == 'Shikarpur' ? 'selected' : '' }}>Shikarpur</option>
                                <option value="Other" {{ old('city', $job->city) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cv" class="form-label">
                                <i class="fas fa-file-upload"></i> CV/Resume (PDF, JPG, PNG)
                            </label>
                            @if($job->cv)
                                <div style="margin-bottom: 1rem; padding: 1rem; background: var(--bg-secondary); border-radius: 0.5rem; border: 1px solid var(--border-color);">
                                    <p style="margin: 0 0 0.5rem 0; color: var(--text-secondary);">
                                        <i class="fas fa-file"></i> Current CV:
                                    </p>
                                    <a href="{{ asset('storage/' . $job->cv) }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-eye"></i> View Current CV
                                    </a>
                                </div>
                            @endif
                            <input 
                                type="file" 
                                id="cv" 
                                name="cv" 
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="form-control"
                                style="padding: 0.5rem;"
                            >
                            <small style="color: var(--text-secondary); margin-top: 0.25rem; display: block;">
                                Leave blank to keep current CV. Maximum file size: 5MB. Supported formats: PDF, JPG, JPEG, PNG
                            </small>
                        </div>

                        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Application
                            </button>
                            <a href="{{ route('jobs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

        // File upload preview
        const fileInput = document.getElementById('cv');
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSize = file.size / 1024 / 1024; // Convert to MB
                if (fileSize > 5) {
                    alert('File size must be less than 5MB');
                    this.value = '';
                    return;
                }
                
                // Show selected file name
                const label = this.parentElement.querySelector('.form-label');
                const fileName = file.name;
                label.innerHTML = `<i class="fas fa-file-upload"></i> CV/Resume - ${fileName}`;
            }
        });

        // Add loading state to form
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            button.disabled = true;
            
            // Re-enable after 10 seconds if form doesn't submit
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 10000);
        });

        // Skills selection counter
        const skillsSelect = document.getElementById('skills');
        skillsSelect.addEventListener('change', function() {
            const selectedCount = this.selectedOptions.length;
            const label = this.parentElement.querySelector('.form-label');
            label.innerHTML = `<i class="fas fa-tools"></i> Skills (${selectedCount} selected)`;
        });

        // Initialize skills counter on page load
        window.addEventListener('load', function() {
            const selectedCount = skillsSelect.selectedOptions.length;
            const label = skillsSelect.parentElement.querySelector('.form-label');
            label.innerHTML = `<i class="fas fa-tools"></i> Skills (${selectedCount} selected)`;
        });
    </script>
</body>
</html>