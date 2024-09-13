<x-header/>
    <x-nav-bar/>
    <x-nav-side/>
        <div id="layoutSidenav_content"  class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light">Clients</h1>
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">List Client</li>
                    </ol>
                        <x-table-data>
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
                        </x-table-data>
                </div>
            </main>
            <x-footer/>
        </div>
    </div>
<x-foot/>