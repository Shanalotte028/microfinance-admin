<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('dashboard') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        Contracts List
    </x-slot:heading>
        <div class="row">
            <x-admin.card-table-list>
                <x-slot:heading>Contracts List</x-slot:heading>
                    <x-slot:table_row>
                        <th>Contract ID</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Expiry</th>
                        <th>Actions</th>
                    </x-slot:table_row>
                @foreach ($contracts as $contract)
                    <tr>
                        <td>{{ $contract->id }}</td>
                        <td>{{ $contract->client->first_name }}</td>
                        <td>
                            @php
                                $status = $contract->status ?? 'n/a';
                                $badgeClass = match($status) {
                                    'active' => 'bg-success',
                                    'terminated' => 'bg-danger',
                                    'expired' => 'bg-danger',
                                    'pending_signature' => 'bg-warning text-dark',
                                    'draft' => 'bg-secondary'
                                };
                            @endphp
                        
                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td>{{ $contract->end_date->diffForHumans()}}</td>
                        <td>
                            <a href="{{ route('admin.contracts.show', $contract->id) }}" class="btn btn-success">View</a>
                            {{-- @if($contract->status === 'draft')
                                <a href="{{ route('contracts.send', $contract->id) }}" class="btn btn-primary">Send for Signature</a>
                            @endif --}}
                        </td>
                    </tr>
                @endforeach
            </x-admin.card-table-list>
        </div>
<x-client.success-popup></x-client.success-popup>
</x-admin.dashboard-layout>