<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.risk_assessment.index', $client) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        {{ $client->first_name }} {{ $client->last_name }}
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>Risk Assement</x-slot:heading>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>ID</x-slot:heading>
                        {{ $risk->id }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Client ID</x-slot:heading>
                        {{ $risk->client_id  }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Risk Level</x-slot:heading>
                        {{ $risk->risk_level  }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Confidence Level</x-slot:heading>
                        {{ $risk->confidence_level  }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Recommendation</x-slot:heading>
                        {{ $risk->recommendation ?? 'n/a'}}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Assessment Date</x-slot:heading>
                        {{ $risk->assessment_date  }}
                    </x-admin.card-table-info-tr>
                </x-admin.card-table-info>         
            </div>
            <div class="col-md-4">
                <form action="{{ route('admin.risk_assessment.recommendation', ['client' => $client, 'risk'=> $risk]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <h4 class="text-light">Recommendation</h4>
                        <textarea name="recommendation" class="form-control bg-dark text-white border-0" rows="6" placeholder="Enter recommendation..."></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>  
        </div>
        <x-client.success-popup/>
</x-admin.dashboard-layout>