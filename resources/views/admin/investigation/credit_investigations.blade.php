<x-admin.dashboard-layout>
    <x-slot:heading>
        Credit Investigations Record
    </x-slot:heading>
            <x-admin.table-data>
                <x-slot:heading>
                    Credit Investigations
                </x-slot:heading>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client ID</th>
                        <th>Officer ID</th>
                        <th>Verified</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>                              
                    @foreach ($investigations as $investigation)
                        <tr>
                            <td>{{ $investigation->id ?? 'n/a' }}</td>
                            <td>{{ $investigation->client_id ?? 'n/a' }}</td>
                            <td>{{ $investigation->officer_id ?? 'n/a' }}</td>
                            <td>{{ $investigation->verified ? 'Yes' : 'No' }}</td>
                            <td>{{ $investigation->created_at ?? 'n/a' }}</td>
                            <td>{{ $investigation->uploaded_at ?? 'n/a' }}</td>
                            <td>
                                <a href="{{ route('admin.investigation.show', ['client'=> $investigation->client->client_id, 'investigation'=>$investigation->id]) }}" class="btn btn-success">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>
            <x-client.success-popup/>
</x-admin.dashboard-layout>