<x-admin.dashboard-layout>
    <x-slot name="heading">{{ $title }}</x-slot>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
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
            </table>

            <a href="{{ route('admin.risk_assessment.risks') }}" class="btn btn-primary mt-3">Back</a>
        </div>
    </div>
</x-admin.dashboard-layout>
