<x-dashboard-layout>
    <x-slot:heading>
        {{ $kyc->document_type }}
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-card-table-info>
                    <x-card-table-info-tr>
                        <x-slot:heading>Document Type</x-slot:heading>
                        {{ $kyc->document_type }}
                    </x-card-table-info-tr>
                    <x-card-table-info-tr>
                        <x-slot:heading>Verification Status</x-slot:heading>
                        {{ $kyc->verification_status }}
                    </x-card-table-info-tr>
                    <x-card-table-info-tr>
                        <x-slot:heading>Verified At</x-slot:heading>
                        {{ $kyc->verified_at ?? 'n/a' }}
                    </x-card-table-info-tr>
                    <x-card-table-info-tr>
                        <x-slot:heading>Verified By</x-slot:heading>
                        {{ $kyc->verified_by ?? 'n/a' }}
                    </x-card-table-info-tr>
                </x-card-table-info>
            </div>
            <div class="col-md-6">
                <x-card-table-info>
                    {{ $kyc->document_path }}
                </x-card-table-info>
            </div>
        </div>
</x-dashboard-layout>