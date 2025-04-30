<x-admin.dashboard-layout>
    <x-slot:heading>
        User List
    </x-slot:heading>
            <x-admin.table-data>
                <x-slot:heading>
                    Users
                </x-slot:heading>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>                              
                    @foreach ($users as $user )
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role}}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    <a href="{{route('admin.user.show', $user)}}" class="btn btn-success">View</a>
                                    @can('users.deactivate')
                                    <form action="{{ route('admin.user.deactivate', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" 
                                            class="btn btn-{{ $user->status === 'inactive' ? 'danger' : 'primary' }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="{{ $user->status === 'inactive' ? '#confirmModal' : '#deactivateReasonModal' }}" 
                                            data-message="Are you sure you want to {{ $user->status === 'inactive' ? 'Activate' : 'Deactivate' }} this user?"
                                            data-form-action="{{ route('admin.user.deactivate', $user->id) }}">
                                            {{ $user->status === 'inactive' ? 'Activate' : 'Deactivate' }}
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>

            <div class="modal fade" id="deactivateReasonModal" tabindex="-1" aria-labelledby="deactivateReasonModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="deactivateReasonModalLabel">Reason for Deactivation</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('admin.user.deactivate', $user->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="modal-body">
                                <p>Please provide a reason for deactivating this user:</p>
                                <textarea name="deactivation_reason" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Submit Reason</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <x-client.success-popup/>
</x-admin.dashboard-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deactivateButtons = document.querySelectorAll('[data-form-action]');
        const deactivateForm = document.getElementById('deactivateForm');
    
        deactivateButtons.forEach(button => {
            button.addEventListener('click', () => {
                const action = button.getAttribute('data-form-action');
                const target = button.getAttribute('data-bs-target');
    
                if (target === '#deactivateReasonModal') {
                    deactivateForm.setAttribute('action', action);
                }
            });
        });
    });
</script>
    