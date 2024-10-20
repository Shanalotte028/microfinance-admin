<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.client.show', ['client'=> $client->id]) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>Edit Client</x-slot:heading>
    <x-slot:heading_child>{{ $client->first_name }} {{ $client->last_name }}</x-slot:heading_child>
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <x-admin.card-table-info> {{-- Client Info Card --}}
                    <form action="{{ route('admin.client.update', $client->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>First Name</x-slot:heading>
                            <div class="col-sm-8">
                           <input type="text" class="form-control" name="first_name" value="{{ $client->first_name ?? '' }}">
                            </div>
                            <x-admin.form-error name="first_name"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Last Name</x-slot:heading>
                            <div class="col-sm-8">
                           <input type="text" class="form-control" name="last_name" value="{{ $client->last_name ?? '' }}">
                            </div>
                            <x-admin.form-error name="first_name"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Email</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="email" value="{{ $client->email ?? ''  }}">
                            </div>
                            <x-admin.form-error name="email"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Phone Number</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="phone_number" value="{{ $client->phone_number ?? ''  }}">
                            </div>
                            <x-admin.form-error name="phone_number"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Birthday</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $client->birthday ?? ''  }}" required/>
                            </div>
                            <x-admin.form-error name="birhtday"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Gender</x-slot:heading>
                            <div class="col-sm-8">
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="{{ $client->gender }}" disabled>{{ $client->gender ?? ''  }}</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <x-admin.form-error name="gender"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Client Type</x-slot:heading>
                            <div class="col-sm-8">
                                <select class="form-control" id="client_type" name="client_type" required>
                                    <option value="{{ $client->client_type }}" disabled>{{ $client->client_type ?? ''  }}</option>
                                    <option value="Individual">Individual</option>
                                    <option value="Business">Business</option>
                                </select>
                            </div>
                            <x-admin.form-error name="client_type"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Client Status</x-slot:heading>
                            <div class="col-sm-8">
                                <select class="form-control" id="client_type" name="client_status" required>
                                    <option value="{{ $client->client_status }}" disabled>{{ $client->client_status ?? ''  }}</option>
                                    <option value="Verified">Verified</option>
                                    <option value="Unverified">Unverified</option>
                                </select>
                            </div>
                            <x-admin.form-error name="client_status"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Created At</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="created_at" value="{{ $client->created_at ?? ''  }}">
                            </div>
                            <x-admin.form-error name="created_at"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Address Line 1</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="address_line_1" value="{{ $client->addresses->first()->address_line_1 ?? ''  }}">
                            </div>
                            <x-admin.form-error name="address_line_1"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Address Line 2</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="address_line_2" value="{{ $client->addresses->first()->address_line_2 ?? ''  }}">
                            </div>
                            <x-admin.form-error name="address_line_2"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>City</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="city" value="{{ $client->addresses->first()->city ?? '' }}">
                            </div>
                            <x-admin.form-error name="city"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Province</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="province" value="{{ $client->addresses->first()->province ?? ''  }}">
                            </div>
                            <x-admin.form-error name="province"></x-admin.form-error>
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Postal Code</x-slot:heading>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="postal_code" value="{{ $client->addresses->first()->postal_code ?? ''  }}">
                            </div>
                            <x-admin.form-error name="postal_code"></x-admin.form-error>
                            @can('update',$client)
                            <div class="text-end mt-4 pe-4">
                                <button class="btn btn-success" type="submit"> Update Client</button>
                            </div>
                            @endcan 
                        </form>
                        @can('delete',$client)
                        <form action="{{ route('admin.client.destroy', $client->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this client?');">
                            @csrf
                            @method('DELETE')
                            <div class="text-end mt-4 pe-4">
                            <button type="submit" class="btn btn-danger">Delete Client</button>
                            </div>
                        </form>
                        @endcan
                        </x-admin.card-table-info-tr>                                   
                </x-admin.card-table-info>        
            </div>
        </div>
</x-admin.dashboard-layout>