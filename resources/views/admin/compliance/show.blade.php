<x-admin.dashboard-layout>
    <x-slot:heading>
        Compliance Record
    </x-slot:heading>
    
    <div class="row">
        {{-- compliance info column --}} 
        <div class="col-md-6 p-4">
            @if(is_null($compliance))
                <p>No KYC documents available.</p>
            @else
                <x-admin.card-table-info>
                    <x-slot:heading>{{ $compliance->compliance_type }}</x-slot:heading>
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
                        <x-slot:heading>Compliance Type</x-slot:heading>
                        {{ $compliance->compliance_type }}
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
            @endif          
        </div>
        {{-- compliance file column --}} 
        <div class="col-md-6 p-4">
            @if(is_null($compliance))
                <p>No KYC documents available.</p>
            @else           
            <x-admin.card-table-info>
                <x-slot:heading>{{ $compliance->document_type }}</x-slot:heading>
                @php
                    $fileExtension = pathinfo($compliance->document_path, PATHINFO_EXTENSION); // Get the file extension
                @endphp
                @if(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                    <img src="{{ Storage::url($compliance->document_path) }}" class="img-fluid">
                @elseif($fileExtension === 'pdf')
                    <embed src="{{ Storage::url($compliance->document_path) }}" type="application/pdf" width="100%" height="600px" />
                @else
                    <a href="{{ Storage::url($compliance->document_path) }}" download>Download {{ ucfirst($compliance->document_type) }}</a>
                @endif
            </x-admin.card-table-info>
            @endif
        </div>
    </div>
</x-admin.dashboard-layout>
