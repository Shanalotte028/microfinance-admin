<x-admin.dashboard-layout>
    <x-slot:heading>Dashboard</x-slot:heading>
    <div class="row">
        @can('compliances.index')
        <x-admin.cards 
        icon="bi bi-journal"
        value="{{ $pendingCompliance }}"
        heading="Pending Compliances"
        route="{{ route('admin.compliances', ['status' => 'pending']) }}" 
        />
        @endcan
        @can('legal.index')
        @if(Auth::user()->role === "Lawyer")
        <x-admin.cards 
        icon="bi bi-bank2"
        value="{{ $assignedCases }}"
        heading="Assigned cases"
        route="{{ route('admin.legal.index') }}" 
        />
        @else
        <x-admin.cards 
        icon="bi bi-bank2"
        value="{{ $openCase }}"
        heading="Open Cases"
        route="{{ route('admin.legal.index', ['status' => 'open']) }}" 
        />
        @endif
        @endcan
      
    </div>
    <x-client.success-popup></x-client.success-popup>
</x-admin.dashboard-layout>