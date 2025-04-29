<x-admin.dashboard-layout>
    <x-slot name="heading">{{ $title }}</x-slot>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
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
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('admin.legal.index') }}" class="btn btn-primary mt-3">Back</a>
        </div>
    </div>
</x-admin.dashboard-layout>
