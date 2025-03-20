<x-admin.dashboard-layout>
    <x-slot:heading>
        Clients List
    </x-slot:heading>
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
                                    <a href="{{ route('admin.client.show', $client) }}" class="btn btn-success">View</a> <!-- View button -->
                                    <form action="{{ route('clients.toggleBlock', $client->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        @can('clients.block')
                                        <button type="button" class="btn btn-{{ $client->blocked === 'Yes' ? 'danger' : 'primary' }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#confirmModal" 
                                            data-message="Are you sure you want to {{ $client->blocked === 'Yes' ? 'unblock' : 'block' }} this client?"
                                            data-form-action="{{ route('clients.toggleBlock', $client->id) }}">
                                        {{ $client->blocked === 'Yes' ? 'Unblock' : 'Block' }}
                                        </button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>
            <x-client.success-popup/>
</x-admin.dashboard-layout>