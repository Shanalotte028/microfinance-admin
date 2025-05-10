<x-admin.dashboard-layout>
    <x-slot:back>
        <a href="{{ route('admin.contracts.index') }}" class="text-white">
            <i class="bi bi-arrow-left larger-icon"></i>
        </a>
    </x-slot:back>
    <x-slot:heading>
        Create New Contract
    </x-slot:heading>
    <x-slot:heading_child>
        Fill out the contract details
    </x-slot:heading_child>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.contracts.store') }}" method="POST" id="contract-form">
                @csrf

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="client_id" class="form-label text-light">Client</label>
                            <select name="client_id" id="client_id" class="form-select" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="template_id" class="form-label text-light">Template</label>
                            <select name="template_id" id="template_id" class="form-select" required>
                                <option value="">Select Template</option>
                                @foreach($templates as $template)
                                <option value="{{ $template->id }}" 
                                    data-fields="{{ json_encode($template->fields) }}"
                                    {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                    {{ $template->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label text-light">Contract Title</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title') ?? 'Loan Agreement' }}" required>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label text-light">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ old('start_date') ?? now()->format('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label text-light">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ old('end_date') ?? now()->addYear()->format('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="auto_renew" name="auto_renew" value="1"
                                   {{ old('auto_renew') ? 'checked' : '' }}>
                            <label class="form-check-label text-light" for="auto_renew">Auto-renew contract</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label text-light">Additional Notes</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>

                <!-- Dynamic Fields Section -->
                <div class="card mb-4 bg-dark-low">
                    <div class="card-header text-light">
                        <h5 class="mb-0">Contract Terms</h5>
                    </div>
                    <div class="card-body" id="dynamic-fields">
                        @if(old('template_id'))
                            <!-- Show fields for preselected template (form validation fail) -->
                            @php
                                $selectedTemplate = $templates->firstWhere('id', old('template_id'));
                            @endphp
                            @foreach($selectedTemplate->fields ?? [] as $field)
                                <div class="mb-3">
                                    <label class="form-label text-light">{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] }}" 
                                           class="form-control" 
                                           name="terms[{{ $field['name'] }}]"
                                           value="{{ old('terms.'.$field['name'], $field['default_value'] ?? '') }}"
                                           {{ $field['required'] ?? false ? 'required' : '' }}>
                                    @error('terms.'.$field['name'])
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        @else
                            <p class="text-light">Select a template to view editable terms</p>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i> Save Contract
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Dynamic Fields -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contract-form');
            const templateSelect = document.getElementById('template_id');
            const dynamicFields = document.getElementById('dynamic-fields');

            templateSelect.addEventListener('change', function() {
                console.log('Form submitted:', Object.fromEntries(new FormData(form)));
                const selectedOption = this.options[this.selectedIndex];
                const fields = JSON.parse(selectedOption.getAttribute('data-fields') || '[]');
                
                let html = '';
                fields.forEach(field => {
                    html += `
                        <div class="mb-3">
                            <label class="form-label text-light">${field.label}</label>
                            <input type="${field.type}" 
                                   class="form-control" 
                                   name="terms[${field.name}]"
                                   value="${field.default_value || ''}"
                                   ${field.required ? 'required' : ''}>
                        </div>
                    `;
                });
                
                dynamicFields.innerHTML = html || '<p class="text-light">No editable terms for this template</p>';
            });

            // Trigger change if template is preselected (form validation fail)
            if(templateSelect.value) {
                templateSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-admin.dashboard-layout>