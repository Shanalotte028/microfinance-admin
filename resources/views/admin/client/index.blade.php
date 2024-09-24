<x-admin.dashboard-layout>
    <x-slot:heading>
        Client
    </x-slot:heading>
    <x-slot:heading_child>
        Client List
    </x-slot:heading_child>
            <x-admin.table-data>
                <x-slot:heading>
                    Clients
                </x-slot:heading>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>                              
                    @foreach ($clients as $client )
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->first_name }}</td>
                                <td>{{ $client->last_name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone_number }}</td>
                                <td>{{ $client->created_at }}</td>
                                <td>
                                    <a href="{{ url('clients/' . $client->id) }}" class="btn btn-success">View</a> <!-- View button -->
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>
</x-admin.dashboard-layout>