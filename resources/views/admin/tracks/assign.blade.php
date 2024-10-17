@extends('layouts.master')
@section('title', 'Assign Users to Track')

@section('content')
<div class="container">
    <h2 class="mb-4">Assign Users to Track: {{ $track->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.tracks.assign', $track->id) }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by email" value="{{ request()->get('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </div>
        </div>
    </form>

    <!-- Users Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th> <!-- Status Column -->
                <th class="text-right">Action</th> <!-- Action Column (Checkbox) -->
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <!-- Status Column with Badge -->
                    <td>
                        <span class="status-label badge {{ in_array($user->id, $assignedUsers) ? 'badge-success' : 'badge-danger' }}" id="status-{{ $user->id }}">
                            {{ in_array($user->id, $assignedUsers) ? 'Assigned' : 'Not Assigned' }}
                        </span>
                    </td>

                    <!-- Action Column: Checkbox for assigning/unassigning -->
                    <td class="text-right">
                        <div class="form-check form-switch">
                            <input class="form-check-input assign-checkbox"
                                   type="checkbox"
                                   data-user-id="{{ $user->id }}"
                                   {{ in_array($user->id, $assignedUsers) ? 'checked' : '' }}>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a>
            </li>

            @for ($i = 1; $i <= $users->lastPage(); $i++)
                <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </nav>
</div>

<script>
    // Handle the checkbox toggle for assigning/unassigning users
    document.querySelectorAll('.assign-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const userId = this.getAttribute('data-user-id');
            const trackId = {{ $track->id }};
            const isChecked = this.checked;
            const statusLabel = document.getElementById(`status-${userId}`); // Reference to the status label

            fetch(`/admin/tracks/${trackId}/assign`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'assigned') {
                    checkbox.checked = true;
                    statusLabel.textContent = 'Assigned';
                    statusLabel.classList.remove('badge-danger');
                    statusLabel.classList.add('badge-success');
                } else if (data.status === 'unassigned') {
                    checkbox.checked = false;
                    statusLabel.textContent = 'Not Assigned';
                    statusLabel.classList.remove('badge-success');
                    statusLabel.classList.add('badge-danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reset the checkbox state in case of error
                checkbox.checked = !isChecked;
            });
        });
    });
</script>
@endsection
