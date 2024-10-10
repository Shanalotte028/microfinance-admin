<x-admin.auth-layout>
<x-slot:column_size>5</x-slot:column_size>
    <x-slot:header>Reset Password</x-slot:header>
        <div class="card-body">
            <form method="post" action="{{ route('client.password.email') }}">
                @csrf
                <p class="text-center">Please type here your email to reset your password.</p>
                <div class="form-floating mb-3">
                    <input class="form-control text-dark" id="inputEmail" name="email" type="email" name="email" required/>
                    <label for="inputEmail">Email address</label>
                    <x-admin.form-error name="email"></x-admin.form-error>
                </div>
                <div class="mt-4 mb-0 text-center">
                    <button class="btn btn-success w-50 d-block mx-auto mb-2" type="submit">Enter</button>
                </div>   
            </form>
        </div>
        <x-client.success-popup/>
</x-admin.auth-layout>