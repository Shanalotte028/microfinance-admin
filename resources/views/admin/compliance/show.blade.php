<x-admin.dashboard-layout>
    <x-slot:heading>
        Compliance Record
    </x-slot:heading>
        <div class="row justify-content-center">
            <div class="col-md-8 pt-3 px-5">
                <x-admin.card-table-info>
                    <x-slot:heading>{{ $compliance->document_type }}</x-slot:heading>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Compliance Record ID</x-slot:heading>
                        {{ $compliance->id }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Client ID</x-slot:heading>
                        {{ $compliance->client_id }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Client Email</x-slot:heading>
                        {{ $compliance->client->email }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Document Type</x-slot:heading>
                        {{ $compliance->document_type }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Document Status</x-slot:heading>
                        {{ $compliance->document_status }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Submission Date</x-slot:heading>
                        {{ $compliance->submission_date }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Approval Date</x-slot:heading>
                        {{ $compliance->approval_date ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Remarks</x-slot:heading>
                        {{ $compliance->remarks ?? 'n/a'}}
                    </x-admin.card-table-info-tr>
                    <x-slot:button>
                        <a href="" class="btn btn-success">Approve</a>
                    </x-slot:button>
                </x-admin.card-table-info>          
            </div>
        </div>
</x-admin.dashboard-layout>