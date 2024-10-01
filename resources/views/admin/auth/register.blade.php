<x-admin.auth-layout>
    <x-slot:header>Create Account</x-slot:header>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.register.post') }}">
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
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="password" name="password" type="password" required/>
                            <label for="password">Password</label>
                            <x-admin.form-error name="password"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required/>
                            <label for="password_confirmation">Confirm Password</label>
                            <x-admin.form-error name="password_confirmation"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control" name="role" id="role" required>
                                <option value="" disabled selected class="text-dark">Role</option>
                                <option value="Staff">Staff</option>
                                <option value="Manager">Manager</option>
                                <option value="Admin">Admin</option>
                            </select>
                            <x-admin.form-error name="role"></x-admin.form-error>
                        </div>
                    </div>
                <div class="mt-4 mb-0">
                    <div class="d-grid"><button class="btn btn-success btn-block" type="submit">Create Account</button></div>
                </div>
            </form>
        </div>
        <div class="card-footer text-center py-3">
            <div class="small"><a href="{{ route('admin.login') }}" class="text-muted">Have an account? Go to login</a></div>
        </div>
</x-admin.auth-layout>                     