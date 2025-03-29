<x-admin.auth-layout>
    <x-slot:back><a href="{{ route('admin.user.show', $user->id) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:header>User Update</x-slot:header>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.user.update', $user) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" name="first_name" id="first_name" type="text" value="{{$user->first_name}}" required/>
                            <label for="first_name">First name</label>
                            <x-admin.form-error name="first_name"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="last_name" name="last_name" type="text" value="{{$user->last_name}}" required/>
                            <label for="last_name">Last name</label>
                            <x-admin.form-error name="last_name"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="email" name="email" type="email" value="{{$user->email}}" required/>
                    <label for="email">Email address</label>
                    <x-admin.form-error name="email"></x-admin.form-error>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="role" id="role" required>
                                <option value="" disabled>Role</option>
                                <option value="Staff" {{ old('role', $user->role) == 'Staff' ? 'selected' : '' }}>Staff</option>
                                <option value="Manager" {{ old('role', $user->role) == 'Manager' ? 'selected' : '' }}>Manager</option>
                                <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <x-admin.form-error name="role"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><button class="btn btn-success btn-block" type="submit">Update</button></div>
                </div>
            </form>
        </div>
</x-admin.auth-layout>                     