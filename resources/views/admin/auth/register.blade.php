<x-admin.auth-layout>
    <x-slot:header>Create Account</x-slot:header>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.accountCreate.post') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" name="first_name" id="first_name" type="text" required/>
                            <label for="first_name">First name</label>
                            <x-admin.form-error name="first_name"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="last_name" name="last_name" type="text" required/>
                            <label for="last_name">Last name</label>
                            <x-admin.form-error name="last_name"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="email" name="email" type="email" required/>
                    <label for="email">Email address</label>
                    <x-admin.form-error name="email"></x-admin.form-error>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="role" id="role" required>
                                <option value="" disabled selected class="text-dark">Role</option>
                                <option value="Staff">Staff</option>
                                <option value="Staff Manager">Manager</option>
                                <option value="Admin">Admin</option>
                                <option value="Lawyer">Lawyer</option>
                            </select>
                            <x-admin.form-error name="role"></x-admin.form-error>
                        </div>
                    </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><button class="btn btn-success btn-block" type="submit">Create Account</button></div>
                </div>
            </form>
        </div>
</x-admin.auth-layout>                     