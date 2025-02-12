<x-admin.auth-layout>
        <div class="card-body">
            <div class="text-center mt-4">
                <h1 class="display-1 text-light">403</h1>
                <p class="lead text-light">You are not allowed to access this page.</p>
                <a href="{{route('dashboard')}}" class="text-muted">
                    <i class="fas fa-arrow-left me-1"></i>
                    Return to Dashboard
                </a>
            </div>
        </div>
</x-admin.auth-layout>