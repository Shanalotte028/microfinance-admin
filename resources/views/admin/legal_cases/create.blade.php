<x-admin.auth-layout>
    <x-slot:header>Create New Legal Case</x-slot:header>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.legal.store') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-control" name="client_id" id="client_id" value="{{ old('client_id') }}" required>
                                <option value="" disabled selected class="text-dark">Clients</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }} </option>
                                @endforeach
                            </select>
                            <x-admin.form-error name="client_id"></x-admin.form-error>
                        </div>
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
</x-admin.auth-layout>                     