<!DOCTYPE html>
<html>
<head>
    <title>Add New Job</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { max-width: 500px; margin: auto; }
        label { display: block; margin-top: 15px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        .button { background: #007bff; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; margin-top: 20px; cursor: pointer; }
        .button:hover { background: #0056b3; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Add New Job</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>First Name:
            <input type="text" name="first_name" value="{{ old('first_name') }}" required>
        </label>
        <label>Last Name:
            <input type="text" name="last_name" value="{{ old('last_name') }}" required>
        </label>
        <label>Phone:
            <input type="text" name="phone" value="{{ old('phone') }}" required>
        </label>
        <label>Email:
            <input type="email" name="email" value="{{ old('email') }}" required>
        </label>
        <label>Gender:
            <input type="radio" name="gender" value="male" required> Male
            <input type="radio" name="gender" value="female" required> Female
            <input type="radio" name="gender" value="other" required> Other
        </label>
        <label>Skills (hold Ctrl to select multiple):
            <select name="skills[]" multiple required>
                <option value="Java">Java</option>
                <option value="PHP">PHP</option>
                <option value="C++">C++</option>
                <option value="C#">C#</option>
            </select>
        </label>
        <label>City:
            <select name="city" required>
                <option value="">Select City</option>
                <option value="Lahore">Lahore</option>
                <option value="Karachi">Karachi</option>
                <option value="Islamabad">Islamabad</option>
                <option value="Other">Other</option>
            </select>
        </label>
        <label>CV/Image:
            <input type="file" name="cv" accept=".pdf,.jpg,.jpeg,.png" required>
        </label>
        <button type="submit" class="button">Post Job</button>
    </form>
</body>
</html>