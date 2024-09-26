<x-admin.auth-layout>
    <x-slot:header>Create Account</x-slot:header>
        <div class="card-body">
            <form method="POST" action="{{ route('client.register.post') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="first_name" name="first_name" required/>
                            <label for="first_name">First Name</label>
                            <x-admin.form-error name="first_name"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="last_name" name="last_name" required/>
                            <label for="last_name">Last Name</label>
                            <x-admin.form-error name="last_name"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" required/>
                    <label for="email">Email</label>
                    <x-admin.form-error name="email"></x-admin.form-error>
                </div>
                
                <div class="form-floating mb-3">
                    <input class="form-control" id="phone_number" name="phone_number" required/>
                    <label for="phone_number">Phone Number</label>
                    <x-admin.form-error name="phone_number"></x-admin.form-error>
                </div>
                
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="birthday" name="birthday" required/>
                    <label for="birthday">Birthday</label>
                    <x-admin.form-error name="birthday"></x-admin.form-error>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="gender">Gender</label>
                            <x-admin.form-error name="gender"></x-admin.form-error>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-control" id="client_type" name="client_type" required>
                                <option value="" disabled selected>Client Type</option>
                                <option value="Individual">Individual</option>
                                <option value="Business">Business</option>
                            </select>
                            <label for="client_type">Client Type</label>
                            <x-admin.form-error name="client_type"></x-admin.form-error>
                        </div>
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" required/>
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
                <div class="mt-4 mb-0">
                    <div class="d-grid"><button class="btn btn-success btn-block" type="submit">Create Account</button></div>
                </div>
            </form>
        </div>
        <div class="card-footer text-center py-3">
            <div class="small"><a href='{{ route('client.login') }}' class="text-muted">Have an account? Go to login</a></div>
        </div>
</x-admin.auth-layout>                     