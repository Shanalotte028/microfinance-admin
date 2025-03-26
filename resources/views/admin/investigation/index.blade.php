<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.client.show', $client) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        Compliance Records
    </x-slot:heading>
        <div class="row">
            <x-admin.card-table-list>
                <x-slot:heading>Compliance Record List</x-slot:heading>
                    <x-slot:table_row>
                            <th>ID</th>
                            <th>Client ID</th>
                            <th>Officer ID</th>
                            <th>Verified</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                    </x-slot:table_row>
                    @foreach ($investigation_records as $investigation)
                                <tr>
                                    <td>{{ $investigation->id ?? 'n/a'}}</td>
                                    <td>{{ $investigation->client_id }}</td>
                                    <td>{{ $investigation->officer_id }}</td>
                                    <td>{{ $investigation->verified ?? 'n/a' }}</td>
                                    <td>{{ $investigation->created_at ?? 'n/a'}}</td>
                                    <td>{{ $investigation->updated_at ?? 'n/a'}}</td>
                                    <td>
                                        <a href="{{ route('admin.investigation.show', ['client' => $client, 'investigation'=> $investigation->id]) }}" class="btn btn-success">View</a> <!-- View button -->
                                    </td>
                                </tr>
                            @endforeach
            </x-admin.card-table-list>
        </div>
<x-client.success-popup></x-client.success-popup>
</x-admin.dashboard-layout>