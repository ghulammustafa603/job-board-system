<!DOCTYPE html>
<html>
<head>
    <title>Edit Job</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { max-width: 500px; margin: auto; }
        label { display: block; margin-top: 15px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        .button { background: #007bff; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; margin-top: 20px; cursor: pointer; }
        .button.back { background: #6c757d; margin-left: 10px; }
        .button:hover { background: #0056b3; }
        .button.back:hover { background: #5a6268; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Edit Job</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Method Spoofing for PUT request --}}

        <label>First Name:
            <input type="text" name="first_name" value="{{ old('first_name', $job->first_name) }}" required>
        </label>
        <label>Last Name:
            <input type="text" name="last_name" value="{{ old('last_name', $job->last_name) }}" required>
        </label>
        <label>Phone:
            <input type="text" name="phone" value="{{ old('phone', $job->phone) }}" required>
        </label>
        <label>Email:
            <input type="email" name="email" value="{{ old('email', $job->email) }}" required>
        </label>
        <label>Gender:
            <input type="radio" name="gender" value="male" {{ old('gender', $job->gender) == 'male' ? 'checked' : '' }} required> Male
            <input type="radio" name="gender" value="female" {{ old('gender', $job->gender) == 'female' ? 'checked' : '' }} required> Female
            <input type="radio" name="gender" value="other" {{ old('gender', $job->gender) == 'other' ? 'checked' : '' }} required> Other
        </label>
        <label>Skills (hold Ctrl to select multiple):
            @php
                $selectedSkills = explode(',', old('skills', $job->skills));
            @endphp
            <select name="skills[]" multiple required>
                <option value="Java" {{ in_array('Java', $selectedSkills) ? 'selected' : '' }}>Java</option>
                <option value="PHP" {{ in_array('PHP', $selectedSkills) ? 'selected' : '' }}>PHP</option>
                <option value="C++" {{ in_array('C++', $selectedSkills) ? 'selected' : '' }}>C++</option>
                <option value="C#" {{ in_array('C#', $selectedSkills) ? 'selected' : '' }}>C#</option>
            </select>
        </label>
        <label>City:
            <select name="city" required>
                <option value="">Select City</option>
                <option value="Lahore" {{ old('city', $job->city) == 'Lahore' ? 'selected' : '' }}>Lahore</option>
                <option value="Karachi" {{ old('city', $job->city) == 'Karachi' ? 'selected' : '' }}>Karachi</option>
                <option value="Islamabad" {{ old('city', $job->city) == 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
                <option value="Other" {{ old('city', $job->city) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </label>
        <label>CV/Image (leave blank to keep current):
            @if($job->cv)
                Current CV: <a href="{{ asset('storage/' . $job->cv) }}" target="_blank">View</a>
            @endif
            <input type="file" name="cv" accept=".pdf,.jpg,.jpeg,.png">
        </label>
        <button type="submit" class="button">Update Job</button>
        <a href="{{ route('jobs.index') }}" class="button back">Back to Listings</a>
    </form>
</body>
</html>