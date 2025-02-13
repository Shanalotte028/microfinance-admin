<x-admin.auth-layout>
        <div class="card-body">
            <div class="text-center mt-4">
                <h1 class="display-1 text-light">429</h1>
                <p class="lead text-light">You’ve made too many requests in a short time. Please slow down and try again later..</p>
                <a href="{{route('login')}}" class="text-muted">
                    <i class="fas fa-arrow-left me-1"></i>
                    Login
                </a>
            </div>
        </div>
</x-admin.auth-layout>