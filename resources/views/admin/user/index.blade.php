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
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>                              
                    @foreach ($users as $user )
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>
            <x-client.success-popup/>
</x-admin.dashboard-layout>