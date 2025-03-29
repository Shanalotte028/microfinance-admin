<x-admin.auth-layout>
    <x-slot:back><a href="{{ route('admin.investigation.show', ['client'=> $client, 'investigation' => $investigation->id]) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:header>Edit Credit Investigation Record</x-slot:header>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.investigation.update', ['client'=> $client, 'investigation' => $investigation->id]) }}">
                @csrf
                @method('PATCH')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" name="client_name" id="client_name" type="text" value="{{ $investigation->client->first_name . ' ' . $investigation->client->last_name }}" required/>
                            <label for="client_name">Client Name</label>
                            <x-admin.form-error name="client_name"></x-admin.form-error>
                            <input type="hidden" name="client_id" value="{{ $investigation->client->id }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" name="officer_name" id="officer_name" type="text" value="{{ $investigation->officer->first_name . ' ' . $investigation->officer->last_name }}" required/>
                            <label for="officer_name">Officer Name</label>
                            <x-admin.form-error name="officer_name"></x-admin.form-error>
                            <input type="hidden" name="officer_id" value="{{ $investigation->officer->id }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="verified" id="verified" required>
                                <option value="1" {{ $investigation->verified ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$investigation->verified ? 'selected' : '' }}>No</option>
                            </select>
                            <x-admin.form-error name="verified"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-floating mb-3">
                        <textarea class="form-control" id="observations" name="observations" rows="5" style="padding-top: 2.5rem; min-height: 100px; resize: vertical;" required>
                            {{ trim($investigation->observations) }}
                        </textarea>
                        <label for="observations" style="margin-left: 15px">Observations</label>
                        <x-admin.form-error name="observations"></x-admin.form-error>
                    </div>
                </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><button class="btn btn-success btn-block" type="submit">Update Investigation</button></div>
                </div>
            </form>
        </div>
</x-admin.auth-layout>                     