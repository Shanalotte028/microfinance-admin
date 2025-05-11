<x-admin.auth-layout>
    <x-slot:back><a href="{{ route('admin.legal.index') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:header>Create New Legal Case</x-slot:header>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.legal.store') }}">
                @csrf
                <div class="row mb-3">
                   <!-- Dropdown to select type (Client or User) -->
                    <div class="form-group mb-3">
                        <select class="form-control" name="recipient_type" id="recipient_type" required>
                            <option value="" disabled selected class="text-dark">Select Recipient Type</option>
                            <option value="client">Client</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>

                    <!-- Dynamic Dropdown (Clients or Users) -->
                    <div class="form-group mb-3">
                        <!-- Clients Dropdown (hidden by default) -->
                        <select class="form-control" name="client_id" id="client_id" style="display: none;" value="{{ old('client_id') }}">
                            <option value="" disabled selected class="text-dark">Select Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
                            @endforeach
                        </select>

                        <!-- Users Dropdown (hidden by default) -->
                        <select class="form-control" name="employee_id" id="employee_id" style="display: none;" value="{{ old('employee_id') }}">
                            <option value="" disabled selected class="text-dark">Select User</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                            @endforeach
                        </select>

                        <x-admin.form-error name="client_id"></x-admin.form-error>
                        <x-admin.form-error name="employee_id"></x-admin.form-error>
                    </div>
                
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="assigned_to" id="assigned_to" value="{{ old('assigned_to') }}" required>
                                <option value="" disabled selected class="text-dark">Assigned Lawyer</option>
                                @foreach ($lawyers as $lawyer)
                                <option value="{{ $lawyer->id }}">{{ $lawyer->first_name }} {{ $lawyer->last_name }} </option>
                                @endforeach
                            </select>
                            <x-admin.form-error name="assigned_to"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" name="case_number" id="case_number" type="text" value="{{ old('case_number') }}" required/>
                            <label for="case_number">Case Number</label>
                            <x-admin.form-error name="case_number"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="title" name="title" type="text" value="{{ old('title') }}" required/>
                            <label for="title">Title</label>
                            <x-admin.form-error name="title"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="description" name="description" rows="5" style="padding-top: 2.5rem; min-height: 100px; resize: vertical;" required>
                        {{old('description')}}
                    </textarea>
                    <label for="description">Description</label>
                    <x-admin.form-error name="description"></x-admin.form-error>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="status" id="status" value="{{ old('status') }}" required>
                                <option value="" disabled selected class="text-dark">Status</option>
                                <option value="open">Open</option>
                                <option value="in_progress">In Progress</option>
                                <option value="closed">Closed</option>
                            </select>
                            <x-admin.form-error name="status"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="filing_date" name="filing_date" value="{{ old('filing_date') }}"required />
                            <label for="filing_date">Filing Date</label>
                            <x-admin.form-error name="filing_date"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="closing_date" name="closing_date" value="{{ old('closing_date') }}"required />
                            <label for="closing_date">Closing Date</label>
                            <x-admin.form-error name="closing_date"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><button class="btn btn-success btn-block" type="submit">Create Case</button></div>
                </div>
            </form>
        </div>

        <!-- JavaScript to toggle dropdowns -->
<script>
    document.getElementById('recipient_type').addEventListener('change', function() {
        const recipientType = this.value;
        
        // Hide both dropdowns first
        document.getElementById('client_id').style.display = 'none';
        document.getElementById('employee_id').style.display = 'none';
        
        // Show the selected dropdown
        if (recipientType === 'client') {
            document.getElementById('client_id').style.display = 'block';
            document.getElementById('client_id').required = true;
            document.getElementById('employee_id').required = false;
        } else if (recipientType === 'employee') {
            document.getElementById('employee_id').style.display = 'block';
            document.getElementById('employee_id').required = true;
            document.getElementById('client_id').required = false;
        }
    });
</script>
</x-admin.auth-layout>                     