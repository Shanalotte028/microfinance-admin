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
                                        <button type="button" class="btn btn-{{ $user->status === 'inactive' ? 'danger' : 'primary' }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#confirmModal" 
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
            <x-client.success-popup/>
</x-admin.dashboard-layout>