<x-admin.auth-layout>
    <x-slot:column_size>5</x-slot:column_size>
    <x-slot:header>Login</x-slot:header>
        <div class="card-body">
            <form method="post" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input class="form-control text-dark" id="inputEmail" name="email" type="email" name="email" value="{{ $email ?? old('email') }}" required/>
                    <label for="inputEmail">Email address</label>
                    <x-admin.form-error name="email"></x-admin.form-error>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control text-dark" id="inputPassword" name="password" type="password" required />
                    <label for="inputPassword">Password</label>
                    <x-admin.form-error name="password"></x-admin.form-error>
                </div>
                <div class="form-check mb-3 text-muted">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="" />
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <div class="mt-4 mb-0 text-center">
                    <button class="btn btn-success w-50 d-block mx-auto mb-2" type="submit">Login</button>
                    <a class="small text-muted d-block mt-2" href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
            </form>
        </div>
        <x-client.success-popup/>
</x-admin.auth-layout>