<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.legal.index') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot name="heading">{{ $title }}</x-slot>
    <x-admin.table-data>
        <x-slot:heading>Legal Case Reports</x-slot:heading>
                <thead>
                    <tr>
                        <th>Case Number</th>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Assigned Lawyer</th>
                        <th>Status</th>
                        <th>Filing Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cases as $case)
                        <tr>
                            <td>{{ $case->case_number }}</td>
                            <td>{{ $case->title }}</td>
                            <td>{{ $case->client->first_name }} {{ $case->client->last_name }}</td>
                            <td>{{ $case->assignedLawyer->first_name }} {{ $case->assignedLawyer->last_name }}</td>
                            <td>
                                @php
                                    $status = $case->status ?? 'n/a';
                                    $badgeClass = match($status) {
                                        'open' => 'bg-success',
                                        'closed' => 'bg-danger',
                                        'in_progress' => 'bg-warning text-dark',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                            
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>{{ $case->filing_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
    </x-admin.table-data>

</x-admin.dashboard-layout>
