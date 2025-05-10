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
                        <th>Party</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </x-slot:table_row>
                @foreach ($contracts as $contract)
                    <tr>
                        <td>{{ $contract->id }}</td>
                        @if(isset($contract->client))
                            <td>{{ $contract->client->first_name }} {{ $contract->client->last_name }} (Client)</td>
                        @elseif(isset($contract->user))
                            <td>{{ $contract->user->first_name }} {{ $contract->user->last_name }} (Employee)</td>
                        @elseif($contract->template->id === 3)
                            <td>{{$contract->vendor_name}}</td>
                        @else
                            <td>{{ $contract->government_agency ?? '-'}} </td>
                        @endif
                        <td>
                            @php
                                $status = $contract->status ?? '-';
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
                        <td>
                            <a href="{{ route('admin.contracts.show', $contract) }}" class="btn btn-success">View</a>
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