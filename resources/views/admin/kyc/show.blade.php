<x-admin.dashboard-layout>
    <x-slot:heading>
        {{ $kyc->document_type }}
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Document Type</x-slot:heading>
                        {{ $kyc->document_type }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Verification Status</x-slot:heading>
                        {{ $kyc->verification_status }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Verified At</x-slot:heading>
                        {{ $kyc->verified_at ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Verified By</x-slot:heading>
                        {{ $kyc->verified_by ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
            </div>
            <div class="col-md-6">
                <x-admin.card-table-info>
                    {{ $kyc->document_path }}
                </x-admin.card-table-info>
            </div>
        </div>
</x-admin.dashboard-layout>