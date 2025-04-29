<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.compliances') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot name="heading">{{ $title }}</x-slot>
    <x-admin.table-data>
        <x-slot:heading>
            Compliances Reports
        </x-slot:heading>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Compliance Type</th>
                <th>Document Type</th>
                <th>Status</th>
                <th>Submission Date</th>
                <th>Approval Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->client->name ?? 'N/A' }}</td>
                    <td>{{ $record->compliance_type }}</td>
                    <td>{{ $record->document_type }}</td>
                    <td>{{ ucfirst($record->document_status) }}</td>
                    <td>{{ $record->submission_date }}</td>
                    <td>{{ $record->approval_date ?? 'Pending' }}</td>
                </tr>
            @endforeach
        </tbody>
    </x-admin.table-data>
</x-admin.dashboard-layout>
