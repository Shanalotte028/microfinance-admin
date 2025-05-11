<x-admin.dashboard-layout>
    <x-slot:back>
        <a href="{{ route('admin.contracts.index') }}" class="text-white">
            <i class="bi bi-arrow-left larger-icon"></i>
        </a>
    </x-slot:back>
    <x-slot:heading>
        Contract #{{ $contract->id }}
    </x-slot:heading>

    <div class="row">
        <div class="col-md-6">
            <x-admin.card-table-info>
                <x-slot:heading>
                    {{ $contract->title }} 
                    <a href="{{ route('admin.contracts.edit', $contract->id) }}" 
                       class="btn btn-success d-none d-md-inline-block">
                       Edit Contract
                    </a>
                </x-slot:heading>
                <x-slot:heading_child>
                    <a href="{{ route('admin.contracts.edit', $contract->id) }}" 
                       class="btn btn-success d-md-none">
                       Edit Contract
                    </a>
                </x-slot:heading_child>

                <x-admin.card-table-info-tr>
                    <x-slot:heading>Contract ID</x-slot:heading>
                    {{ $contract->id }}
                </x-admin.card-table-info-tr>

                <x-admin.card-table-info-tr>
                    @php
                        $person = null;
                        $heading = 'Vendor/Government';
                        $route = '';
                        $fullName = $contract->vendor_name ?: $contract->government_agency;
                
                        if ($contract->client) {
                            $person = $contract->client;
                            $heading = 'Client';
                            $route = route('admin.client.show', $person);
                        } elseif ($contract->user) {
                            $person = $contract->user;
                            $heading = 'User';
                            $route = route('admin.user.show', $person);
                        }
                
                        if ($person) {
                            $fullName = $person->first_name . ' ' . $person->last_name;
                        }
                    @endphp
                
                    <x-slot:heading>{{ $heading }}</x-slot:heading>
                    @if($fullName)
                        @if($route)
                            <a href="{{ $route }}" class="text-light">
                                {{ $fullName }}
                            </a>
                        @else
                            <span>{{ $fullName }}</span>
                        @endif
                    @else
                        <span>-</span>
                    @endif
                </x-admin.card-table-info-tr>

                <x-admin.card-table-info-tr>
                    <x-slot:heading>Status</x-slot:heading>
                    @php
                        $statusColor = match($contract->status) {
                            'active' => 'success',
                            'pending_signature' => 'warning',
                            'expired' => 'danger',
                            default => 'secondary',
                        };
                    @endphp
                    <span class="badge bg-{{ $statusColor }}">
                        {{ ucfirst($contract->status) }}
                    </span>
                </x-admin.card-table-info-tr>

                {{-- <x-admin.card-table-info-tr>
                    <x-slot:heading>Start Date</x-slot:heading>
                    {{ $contract->start_date->format('M d, Y') }}
                </x-admin.card-table-info-tr>

                <x-admin.card-table-info-tr>
                    <x-slot:heading>End Date</x-slot:heading>
                    <span class="{{ $contract->isExpired() ? 'text-danger' : '' }}">
                        {{ $contract->end_date->format('M d, Y') }}
                        @if($contract->isExpired())
                            (Expired)
                        @endif
                    </span>
                </x-admin.card-table-info-tr>
 --}}
                <x-admin.card-table-info-tr>
                    <x-slot:heading>Document</x-slot:heading>
                    <a href="{{ route('admin.contracts.download', $contract->id) }}" 
                       class="btn btn-sm btn-primary">
                       <i class="bi bi-download"></i> Download PDF
                    </a>
                </x-admin.card-table-info-tr>

               {{--  <x-admin.card-table-info-tr>
                    <x-slot:heading>Description</x-slot:heading>
                    <div style="white-space: pre-line;">{{ $contract->description }}</div>
                </x-admin.card-table-info-tr> --}}
            </x-admin.card-table-info>
            <div class="card">
                <div class="card-body">
                    <h4 class="text-light mb-4">Signatures</h4>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="border p-3 mb-3 rounded">
                                <h5>Party Signature</h5>
                                @if($contract->party_signed_at)
                                    <p class="text-success">Signed on {{ $contract->party_signed_at->format('M d, Y') }}</p>
                                @else
                                    <p class="text-warning">Pending</p>
                                    {{-- <a href="{{ route('admin.contracts.send', $contract->id) }}" 
                                        class="btn btn-sm btn-warning">
                                        Resend Signature Request
                                    </a> --}}
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="border p-3 mb-3 rounded">
                                <h5>Admin Signature</h5>
                                @if($contract->admin_signed_at)
                                    <p class="text-success">Signed on {{ $contract->admin_signed_at->format('M d, Y') }}</p>
                                @else
                                    <p class="text-muted">Not Required</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Column for Contract Content -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="text-light mb-4">Contract Terms</h4>
                    <div class="border p-3 bg-light-dark rounded">
                        {!! $contract->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-client.success-popup/>
</x-admin.dashboard-layout>