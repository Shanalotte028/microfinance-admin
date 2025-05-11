<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.legal.index') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        Legal Case Number: {{$case->case_number}}
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>
                    Legal Case Title: {{ $case->title }}
                    <a href="{{ route('admin.legal.edit', $case->id) }}" class="btn btn-success d-none d-md-inline-block">
                        Update Case
                    </a>
                </x-slot:heading>

                <x-slot:heading_child>
                    @if($case->client_id || $case->employee_id)
                        <a href="{{ route('admin.legal.edit', $case->id) }}" class="btn btn-success d-md-none">
                            Update Case
                        </a>
                    @endif
                </x-slot:heading_child>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Case Number</x-slot:heading>
                            {{ $case->case_number }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            @php
                                $recipient = $case->client ?? $case->employee;
                                $isClient = $case->client_id !== null;
                                $route = $isClient 
                                    ? route('admin.client.show', $case->client_id)
                                    : ($case->employee_id ? route('admin.user.show', $case->employee_id) : '#');
                            @endphp
                            
                            <x-slot:heading>{{ $isClient ? 'Client' : 'Employee' }}</x-slot:heading>
                            
                            @if($recipient)
                                <a href="{{ $route }}" class="text-light">
                                    {{ $recipient->first_name }} {{ $recipient->last_name }}
                                </a>
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
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