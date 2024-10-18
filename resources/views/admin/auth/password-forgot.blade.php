<x-admin.auth-layout>
<x-slot:column_size>5</x-slot:column_size>
    <x-slot:header>Reset Password</x-slot:header>
        <div class="card-body">
            <form method="post" action="{{ route('password.email') }}">
                @csrf
                <p class="text-center">Please type here your email to reset your password.</p>
                <div class="form-floating mb-3">
                    <input class="form-control text-dark" id="inputEmail" name="email" type="email" name="email" required/>
                    <label for="inputEmail">Email address</label>
                    <x-admin.form-error name="email"></x-admin.form-error>
                </div>
                <div class="row mt-4 mb-0">
                    <div class="col-12 text-end">
                        <a class="btn btn-secondary me-2" href="{{ route('login') }}">Cancel</a>
                        <button class="btn btn-success" type="submit">Enter</button>
                    </div>
                </div>  
            </form>
        </div>
        <x-client.success-popup/>
</x-admin.auth-layout>