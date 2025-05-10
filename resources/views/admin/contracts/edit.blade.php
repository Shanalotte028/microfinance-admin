<x-admin.dashboard-layout>
    <x-slot:back>
        <a href="{{ route('admin.contracts.show', $contract->id) }}" class="text-white">
            <i class="bi bi-arrow-left larger-icon"></i>
        </a>
    </x-slot:back>
    <x-slot:heading>
        Edit Contract #{{ $contract->id }}
    </x-slot:heading>

    <form action="{{ route('admin.contracts.update', $contract->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Left Column - Editable Fields -->
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>
                        Contract Details
                    </x-slot:heading>

                    <!-- Title -->
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Title</x-slot:heading>
                        <input type="text" name="title" value="{{ old('title', $contract->title) }}" 
                               class="form-control" 
                               {{ $contract->status !== 'draft' ? 'readonly' : '' }}>
                    </x-admin.card-table-info-tr>

                    <!-- Status Display (Non-editable) -->
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Status</x-slot:heading>
                        @php
                            $statusColor = match($contract->status) {
                                'active' => 'success',
                                'pending' => 'warning',
                                'expired' => 'danger',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $statusColor }}">
                            {{ ucfirst($contract->status) }}
                        </span>
                    </x-admin.card-table-info-tr>

                    <!-- Dates Section -->
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Start Date</x-slot:heading>
                        <input type="date" name="start_date" 
                               value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" 
                               class="form-control  border-dark "
                               {{ !in_array($contract->status, ['draft']) ? 'readonly' : '' }}>
                    </x-admin.card-table-info-tr>

                    <x-admin.card-table-info-tr>
                        <x-slot:heading>End Date</x-slot:heading>
                        <input type="date" name="end_date" 
                               value="{{ old('end_date', $contract->end_date->format('Y-m-d')) }}" 
                               class="form-control  border-dark "
                               {{ !in_array($contract->status, ['draft', 'active']) ? 'readonly' : '' }}>
                    </x-admin.card-table-info-tr>

                    <!-- Auto Renew -->
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Auto Renew</x-slot:heading>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="auto_renew" 
                                   id="auto_renew" {{ $contract->auto_renew ? 'checked' : '' }}
                                   {{ $contract->status === 'expired' ? 'disabled' : '' }}>
                            <label class="form-check-label" for="auto_renew"></label>
                        </div>
                    </x-admin.card-table-info-tr>

                    <!-- Description -->
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Description</x-slot:heading>
                        <textarea name="description" class="form-control  border-dark " 
                                  rows="3">{{ old('description', $contract->description) }}</textarea>
                    </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
            </div>

            <!-- Right Column - Contract Terms -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class=" mb-4">Contract Terms</h4>
                        
                        @if($contract->status === 'draft')
                            <!-- Editable Terms for Drafts -->
                            <div class="mb-3">
                                <label class="form-label ">Custom Terms (JSON)</label>
                                <textarea name="terms" class="form-control border-dark" rows="8">
                                    @if(is_array($contract->terms))
                                        {{ json_encode($contract->terms, JSON_PRETTY_PRINT) }}
                                    @else
                                        {{ $contract->terms }}
                                    @endif
                                </textarea>
                                <small class="text-muted">Modify the JSON structure to update terms</small>
                            </div>
                        @else
                            <!-- Read-only Display for Signed Contracts -->
                            <div class="border p-3 bg-light-dark rounded">
                                {!! $contract->content !!}
                            </div>
                            
                            @if($contract->status === 'active')
                                <!-- Amendment Request Button -->
                                <div class="mt-3">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" 
                                            data-bs-target="#amendmentModal">
                                        Request Amendment
                                    </button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row mt-3 text-end">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ route('admin.contracts.show', $contract->id) }}" 
                        class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <!-- Amendment Modal -->
    @if($contract->status === 'active')
        <div class="modal fade" id="amendmentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Contract Amendment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.contracts.amendments.store', $contract->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Amendment Reason</label>
                                <textarea name="reason" class="form-control bg-darker text-light" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Terms (JSON)</label>
                                <textarea name="new_terms" class="form-control bg-darker text-light" rows="8" required>
                                    {{ json_encode($contract->terms, JSON_PRETTY_PRINT) }}
                                </textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Effective Date</label>
                                <input type="date" name="effective_date" class="form-control bg-darker text-light" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-admin.dashboard-layout>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
    try {
        JSON.parse(document.querySelector('[name="terms"]').value);
    } catch (err) {
        e.preventDefault();
        alert('Invalid JSON format in terms field');
    }
});
</script>