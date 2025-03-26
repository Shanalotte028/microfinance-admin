<x-admin.dashboard-layout>
    <x-slot:heading>
        Risk Assessment List
    </x-slot:heading>
    <x-slot:heading_child>
        Risk Management
    </x-slot:heading_child>

    <div class="mb-4">
        <a href="{{ route('admin.risk_assessment.risks') }}" class="btn btn-secondary">All</a>
        <a href="{{ route('admin.risk_assessment.risks', ['status' => 'Low Risk']) }}" class="btn btn-success">Low Risk</a>
        <a href="{{ route('admin.risk_assessment.risks', ['status' => 'Medium Risk']) }}" class="btn btn-warning">Medium Risk</a>
        <a href="{{ route('admin.risk_assessment.risks', ['status' => 'High Risk']) }}" class="btn btn-danger">High Risk</a>
    </div>
            <x-admin.table-data>
                <x-slot:heading>
                    Risk
                </x-slot:heading>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client ID</th>
                        <th>Client Email</th>
                        <th>Risk Level</th>
                        <th>Confidence Level</th>
                        <th>Assessment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Client ID</th>
                        <th>Client Email</th>
                        <th>Risk Level</th>
                        <th>Confidence Level</th>
                        <th>Assessment Date</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>                             
                    @foreach ($clients as $client)
                        @foreach ($client->risk_assessments as $risk)
                            <tr>
                                <td>{{ $risk->id }}</td>
                                <td>{{ $client->client_id }}</td> 
                                <td>{{ $client->email ?? 'n/a' }}</td>
                                <td>{{ $risk->risk_level }}</td>
                                <td>{{ $risk->confidence_level }}</td>
                                <td>{{ $risk->assessment_date }}</td>
                                <td>
                                    <a href="{{ route('admin.risk_assessment.show', ['client' => $client, 'risk' => $risk->id]) }}" class="btn btn-success">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </x-admin.table-data>
</x-admin.dashboard-layout>