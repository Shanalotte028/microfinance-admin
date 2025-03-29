<x-admin.dashboard-layout>
    <x-slot:heading>
        Pending User Approvals
    </x-slot:heading>

    <x-admin.table-data>
        <x-slot:heading>
            Users Awaiting Approval
        </x-slot:heading>
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Microservice</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Microservice</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($pendingUsers as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->employee_id }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->microservice }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <form action="{{ route('admin.approve.users', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form action="{{ route('admin.reject.users', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </x-admin.table-data>

    <x-client.success-popup/>
</x-admin.dashboard-layout>
