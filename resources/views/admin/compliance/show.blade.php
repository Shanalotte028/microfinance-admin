<x-admin.dashboard-layout>
    <x-slot:heading>
        Compliance Record
    </x-slot:heading>
        <div class="row">
            <div class="col-md-4"> {{-- left column --}}
                <x-admin.card-table-info>
                    <x-slot:heading>{{ $compliance->document_type }}</x-slot:heading>
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
                </x-admin.card-table-info>
            </div>
            <div class="col-md-8"> {{-- right column --}}
                <x-admin.card-table-list>
                    <x-slot:heading>KYC Records</x-slot:heading>
                        <x-slot:table_row>
                            <th>Document Type</th>
                            <th>Verification Status</th>
                            <th>Uploaded At</th>
                            <th>Verified At</th>
                            <th>Verified By</th>
                            <th>Action</th>
                        </x-slot:table_row>
                            @foreach ($compliance->kyc_records as $kyc)
                            <tr>
                            <td>{{ $kyc->document_type }}</td>
                            <td>{{ $kyc->verification_status }}</td>
                            <td>{{ $kyc->uploaded_at }}</td>
                            <td>{{ $kyc->verified_at ?? 'n/a' }}</td>
                            <td>{{ $kyc->verified_by ?? 'n/a' }}</td>
                            <td><a href="{{ url('admin/clients/'.$client->id.'/compliance-records/'.$compliance->id.'/kyc-records/'.$kyc->id) }}" class="btn btn-success">View</a></td>
                            </tr>
                            @endforeach
                </x-admin.card-table-list>
            </div>
        </div>
</x-admin.dashboard-layout>