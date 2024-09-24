<x-admin.auth-layout>
    <x-slot:column_size>5</x-slot:column_size>
        <x-slot:header>Reset Password</x-slot:header>
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    <p class="text-center">Please type here your email to reset your password.</p>
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-floating mb-3">
                        <input class="form-control text-dark" id="inputEmail" name="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus/>
                        <label for="inputEmail">Email address</label>
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
                    <div class="mt-4 mb-0 text-center">
                        <button class="btn btn-success w-50 d-block mx-auto mb-2" type="submit">Reset Password</button>
                    </div>   
                </form>
            </div>
    </x-admin.auth-layout>