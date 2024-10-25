<x-admin.dashboard-layout>
    <x-slot:heading>Dashboard</x-slot:heading>
    <div class="row">
        {{-- Accounts Card --}}
            <x-admin.cards>
                <x-slot:icon>
                    bi bi-person-circle
                </x-slot:icon>
                <x-slot:value>
                    {{ $totalUsers }}
                </x-slot:value>
                <x-slot:heading>
                    Registered Accounts
                </x-slot:heading>
            </x-admin.cards>
            {{-- loans card --}}
            <x-admin.cards>
                <x-slot:icon>
                    bi bi-bank2
                </x-slot:icon>
                <x-slot:value>
                    {{ $pendingLoans }}
                </x-slot:value>
                <x-slot:heading>
                    Pending Loans
                </x-slot:heading>
            </x-admin.cards>
            {{-- Compliance Card --}}
            <x-admin.cards>
                <x-slot:icon>
                    bi bi-journal
                </x-slot:icon>
                <x-slot:value>
                    {{ $pendingCompliance }}
                </x-slot:value>
                <x-slot:heading>
                    Pending Compliance
                </x-slot:heading>
            </x-admin.cards>

            <x-admin.charts/>
    </div>
</x-admin.dashboard-layout>