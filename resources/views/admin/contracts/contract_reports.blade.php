<x-admin.dashboard-layout>
    <x-slot:back>
        <a href="{{ route('admin.contracts.index') }}" class="text-white">
            <i class="bi bi-arrow-left larger-icon"></i>
        </a>
    </x-slot:back>

    <x-slot name="heading">{{ $title }}</x-slot>

    <x-admin.table-data>
        <x-slot:heading>
            Contract Reports
        </x-slot:heading>

        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>User</th>
                <th>Title</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Signed At</th>
            </tr>
        </thead>

        <tbody>
            @foreach($records as $contract)
                <tr>
                    <td>{{ $contract->id }}</td>
                    <td>{{ $contract->client->name ?? 'N/A' }}</td>
                    <td>{{ $contract->user->name ?? 'N/A' }}</td>
                    <td>{{ $contract->title }}</td>
                    <td>
                        @php
                            $status = $contract->status ?? 'n/a';
                            $badgeClass = match($status) {
                                'active' => 'bg-success',
                                'draft' => 'bg-secondary',
                                'pending_signature' => 'bg-warning text-dark',
                                'expired' => 'bg-dark',
                                'terminated' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                    </td>
                    <td>{{ $contract->created_at->format('Y-m-d') }}</td>
                    <td>{{ $contract->party_signed_at ? \Carbon\Carbon::parse($contract->party_signed_at)->format('Y-m-d') : 'Pending' }}</td>
                </tr>
            @endforeach
        </tbody>
    </x-admin.table-data>
</x-admin.dashboard-layout>
