<x-admin.dashboard-layout>
    <x-slot:heading>
        Credit Investigation Record
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>Credit Investigation ID: {{$investigation->id}} @can('investigation.edit')<a href="{{route('admin.investigation.edit', ['client'=> $client, 'investigation'=> $investigation->id])}}" class="btn btn-success d-none d-md-inline-block">Update Investigation</a> @endcan</x-slot:heading>
                    <x-slot:heading_child> @can('investigation.edit')<a href="{{route('admin.investigation.edit', ['client'=> $client, 'investigation'=> $investigation->id])}}" class="btn btn-success d-md-none">Update Case</a>@endcan</x-slot:heading> 
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Client</x-slot:heading>
                            <a href="{{route('admin.client.show', $investigation->client->id)}}" class="text-light">{{ $investigation->client->first_name }} {{ $investigation->client->last_name }}</a>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Field Investigator</x-slot:heading>
                            {{ "Officer ID: {$investigation->id}: {$investigation->officer->first_name} {$investigation->officer->last_name}" }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Observations</x-slot:heading>
                            {{ $investigation->observations ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Verified</x-slot:heading>
                            {{ $investigation->verified ? 'Yes' : 'No' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Created At</x-slot:heading>
                            {{ $investigation->created_at }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr >
                            <x-slot:heading>Updated At</x-slot:heading>
                        <div>
                            <p>{{ $investigation->updated_at }}</p>
                        </div>
                        </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
            </div>
        </div>
        <x-client.success-popup/>
</x-admin.dashboard-layout>