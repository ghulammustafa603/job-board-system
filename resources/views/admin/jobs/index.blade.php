<!DOCTYPE html>
<html>
<head>
    <title>Admin - Job Listings</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .action-buttons button {
            margin-right: 5px;
            padding: 5px 10px;
            border-radius: 3px;
            border: none;
            cursor: pointer;
        }
        .approve-btn { background-color: #28a745; color: #fff; }
        .reject-btn { background-color: #dc3545; color: #fff; }
        .delete-btn { background-color: #6c757d; color: #fff; }
    </style>
</head>
<body>
    <h1>Admin - Job Listings</h1>
    <form id="bulk-action-form" method="POST" action="{{ route('admin.jobs.bulk-action') }}">
        @csrf
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Skills</th>
                    <th>City</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th>Employer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop through jobs (to be passed from controller) --}}
                @forelse($jobs ?? [] as $job)
                    <tr>
                        <td><input type="checkbox" name="selected_jobs[]" value="{{ $job->id }}"></td>
                        <td>{{ $job->first_name }}</td>
                        <td>{{ $job->last_name }}</td>
                        <td>{{ $job->email }}</td>
                        <td>{{ $job->phone }}</td>
                        <td>{{ ucfirst($job->gender) }}</td>
                        <td>{{ $job->skills }}</td>
                        <td>{{ $job->city }}</td>
                        <td>{{ $job->status }}</td>
                        <td>{{ $job->updated_at }}</td>
                        <td>{{ $job->user->name ?? 'N/A' }}</td>
                        <td class="action-buttons">
                            <form action="{{ route('admin.jobs.approve', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="approve-btn">Approve</button>
                            </form>
                            <form action="{{ route('admin.jobs.reject', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="reject-btn">Reject</button>
                            </form>
                            <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="12">No jobs found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <button type="submit" name="bulk_action" value="approve" class="approve-btn">Approve Selected</button>
        <button type="submit" name="bulk_action" value="reject" class="reject-btn">Reject Selected</button>
        <button type="submit" name="bulk_action" value="delete" class="delete-btn">Delete Selected</button>
    </form>
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_jobs[]"]');
            for (const cb of checkboxes) {
                cb.checked = this.checked;
            }
        });
    </script>
</body>
</html> 