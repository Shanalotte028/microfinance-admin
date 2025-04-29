<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.risk_assessment.risks') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot name="heading">{{ $title }}</x-slot>

    <x-admin.table-data>
        <x-slot:heading>
            Risk Assessment Report
        </x-slot:heading>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client ID</th>
                        <th>Risk Level</th>
                        <th>Confidence Level</th>
                        <th>Assessment Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($risks as $risk)
                            <tr>
                                <td>{{ $risk->id }}</td>
                                <td>{{ $risk->client_id }}</td> 
                                <td>{{ $risk->risk_level }}</td>
                                <td>{{ $risk->confidence_level }}</td>
                                <td>{{ $risk->assessment_date }}</td>
                            </tr>
                    @endforeach
                </tbody>
    </x-admin.table-data>
    
</x-admin.dashboard-layout>
