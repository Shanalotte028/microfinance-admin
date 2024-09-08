<x-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4 text-light">Create Account</h3></div>
                    <div class="card-body">
                        <form method="POST" action="/register">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" name="first_name" id="first_name" type="text" placeholder="Enter your first name" />
                                        <label for="first_name">First name</label>
                                        <x-form-error name="first_name"></x-form-error>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="last_name" name="last_name" type="text" placeholder="Enter your last name" />
                                        <label for="last_name">Last name</label>
                                        <x-form-error name="last_name"></x-form-error>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com" />
                                <label for="email">Email address</label>
                                <x-form-error name="email"></x-form-error>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="password" name="password" type="password" placeholder="Create a password" />
                                        <label for="password">Password</label>
                                        <x-form-error name="password"></x-form-error>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm password" />
                                        <label for="password_confirmation">Confirm Password</label>
                                        <x-form-error name="password_confirmation"></x-form-error>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid"><button class="btn btn-success btn-block" type="submit">Create Account</button></div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="/login" class="text-muted">Have an account? Go to login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>