<x-admin.auth-layout>
    <x-slot:back><a href="{{ route('admin.legal.show', $case->id) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:header>Edit Legal Case</x-slot:header>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.legal.update', $case->id) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            @if($case->client_id)
                                <input class="form-control" name="client_name" id="client_name" type="text" 
                                       value="{{ $case->client->first_name . ' ' . $case->client->last_name }}" required readonly/>
                                <label for="client_name">Client Name</label>
                                <input type="hidden" name="client_id" value="{{ $case->client->id }}">
                                <input type="hidden" name="recipient_type" value="client">
                            @elseif($case->employee_id)
                                <input class="form-control" name="employee_name" id="employee_name" type="text" 
                                       value="{{ $case->employee->first_name . ' ' . $case->employee->last_name }}" required readonly/>
                                <label for="employee_name">Employee Name</label>
                                <input type="hidden" name="recipient_type" value="employee">
                                <input type="hidden" name="employee_id" value="{{ $case->employee->id }}">
                            @endif
                            <x-admin.form-error name="client_name"></x-admin.form-error>
                            <x-admin.form-error name="employee_name"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="assigned_to" id="assigned_to" value="{{ old('assigned_to') }}" required>
                                <option value="" disabled selected class="text-dark">Assigned Lawyer</option>
                                @foreach ($lawyers as $lawyer)
                                <option value="{{ $lawyer->id }}" {{ $case->assigned_to == $lawyer->id ? 'selected' : '' }}>{{ $lawyer->first_name . ' ' . $lawyer->last_name }}</option>
                                @endforeach
                            </select>
                            <x-admin.form-error name="assigned_to"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" name="case_number" id="case_number" type="text" value="{{ $case->case_number }}" required/>
                            <label for="case_number">Case Number</label>
                            <x-admin.form-error name="case_number"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="title" name="title" type="text" value="{{ $case->title }}" required/>
                            <label for="title">Title</label>
                            <x-admin.form-error name="title"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="description" name="description" rows="5" style="padding-top: 2.5rem; min-height: 100px; resize: vertical;" required>
                        {{ trim($case->description) }}
                    </textarea>
                    <label for="description">Description</label>
                    <x-admin.form-error name="description"></x-admin.form-error>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="status" id="status" value="{{ old('status') }}" required>
                                <option value="open" {{ $case->status == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $case->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="closed" {{ $case->status == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            <x-admin.form-error name="status"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="filing_date" name="filing_date" value="{{ $case->filing_date }}"required />
                            <label for="filing_date">Filing Date</label>
                            <x-admin.form-error name="filing_date"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="closing_date" name="closing_date" value="{{ $case->closing_date }}"required />
                            <label for="closing_date">Closing Date</label>
                            <x-admin.form-error name="closing_date"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><button class="btn btn-success btn-block" type="submit">Update Case</button></div>
                </div>
            </form>
        </div>
</x-admin.auth-layout>                     