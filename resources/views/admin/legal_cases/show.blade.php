<x-admin.dashboard-layout>
    <x-slot:heading>
        Legal Case Number: {{$case->case_number}}
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>Legal Case Title: {{$case->title}}</x-slot:heading>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Case Number</x-slot:heading>
                            {{ $case->case_number }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Client</x-slot:heading>
                            {{ $case->client->first_name }} {{ $case->client->last_name }}
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
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Update Status</x-slot:heading>
                            <form action="{{ route('admin.legal.update', $case->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3 col-3">
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="open" {{ $case->status == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in_progress" {{ $case->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="closed" {{ $case->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Update Status</button>
                            </form>
                        </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
            </div>
        </div>
        <x-client.success-popup/>
</x-admin.dashboard-layout>