<x-admin.dashboard-layout>
    <x-slot:heading>
        Legal Cases
    </x-slot:heading>

            <!-- Filter Buttons -->
        <div class="mb-4">
            <a href="{{ route('admin.legal.index') }}" class="btn btn-secondary">All</a>
            <a href="{{ route('admin.legal.index', ['status' => 'open']) }}" class="btn btn-primary">Open</a>
            <a href="{{ route('admin.legal.index', ['status' => 'in_progress']) }}" class="btn btn-warning">In Progress</a>
            <a href="{{ route('admin.legal.index', ['status' => 'closed']) }}" class="btn btn-success">Closed</a>
        </div>

            <x-admin.table-data>
                <x-slot:heading>
                    Cases
                </x-slot:heading>
                <thead>
                    <tr>
                        <th>Case Number</th>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Assigned Lawyer</th>
                        <th>Status</th>
                        <th>Filing Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>                              
                    @foreach ($cases as $case)
                        <tr>
                            <td>{{ $case->case_number }}</td>
                            <td>{{ $case->title }}</td>
                            <td>{{ $case->client->first_name }} {{ $case->client->last_name }}</td>
                            <td>{{ $case->assignedLawyer->first_name }} {{ $case->assignedLawyer->last_name }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $case->status)) }}</td>
                            <td>{{ $case->filing_date }}</td>
                            <td>
                                <a href="{{ route('admin.legal.show', $case->id) }}" class="btn btn-success">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>
            <x-client.success-popup/>
</x-admin.dashboard-layout>