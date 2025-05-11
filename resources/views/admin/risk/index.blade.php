<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.client.show', $client) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        Risk Assessment List
    </x-slot:heading>
        <div class="row">
            <x-admin.card-table-list>
                <x-slot:heading>Risk Assessment List</x-slot:heading>
                    <x-slot:table_row>
                            <th>ID</th>
                            <th>Client ID</th>
                            <th>Risk Level</th>
                            <th>Confidence Level</th>
                            <th>Assessment Date</th>
                            <th>Action</th>
                    </x-slot:table_row>
                    @foreach ($client->risk_assessments as $risk)
                                <tr>
                                    <td>{{ $risk->id ?? 'n/a'}}</td>
                                    <td>{{ $risk->client_id }}</td>
                                    <td>
                                        @php
                                            $status = $risk->risk_level ?? 'n/a';
                                            $badgeClass = match($status) {
                                                'Low Risk' => 'bg-success',
                                                'High Risk' => 'bg-danger',
                                                'Medium Risk' => 'bg-warning text-dark',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                    
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td>{{ $risk->confidence_level ?? 'n/a'}}</td>
                                    <td>{{ $risk->assessment_date ?? 'n/a'}}</td>
                                    <td>
                                        <a href="{{ route('admin.risk_assessment.show', ['client'=> $client, 'risk' => $risk->id ] ) }}" class="btn btn-success">View</a> <!-- View button -->
                                    </td>
                                </tr>
                            @endforeach
            </x-admin.card-table-list>
        </div>
<x-client.success-popup></x-client.success-popup>
</x-admin.dashboard-layout>