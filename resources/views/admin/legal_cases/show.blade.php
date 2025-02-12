<x-admin.dashboard-layout>
    <x-slot:heading>
        Legal Case Number: {{$case->case_number}}
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>Legal Case Title: {{$case->title}} <a href="{{route('admin.legal.edit', $case->id)}}" class="btn btn-success d-none d-md-inline-block">Update Case</a></x-slot:heading>
                    <x-slot:heading_child> <a href="{{route('admin.legal.edit', $case->id)}}" class="btn btn-success d-md-none">Update Case</a></x-slot:heading>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Case Number</x-slot:heading>
                            {{ $case->case_number }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Client</x-slot:heading>
                            <a href="{{route('admin.client.show', $case->client->id)}}">{{ $case->client->first_name }} {{ $case->client->last_name }}</a>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Assigned Lawyer</x-slot:heading>
                            {{ $case->assignedLawyer->first_name }} {{ $case->assignedLawyer->last_name }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Status</x-slot:heading>
                            {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Filing Date</x-slot:heading>
                            {{ $case->filing_date }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Closing Date</x-slot:heading>
                            {{ $case->closing_date }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr >
                            <x-slot:heading>Description</x-slot:heading>
                        <div>
                            <p>{{ $case->description }}</p>
                        </div>
                        </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
            </div>
        </div>
        <x-client.success-popup/>
</x-admin.dashboard-layout>