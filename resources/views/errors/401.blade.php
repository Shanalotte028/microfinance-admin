<x-admin.auth-layout>
        <div class="card-body">
            <div class="text-center mt-4">
                <h1 class="display-1 text-light">401</h1>
                <p class="lead text-light">You must be logged in to access this page. Please log in and try again</p>
                <a href="{{route('login')}}" class="text-muted">
                    <i class="fas fa-arrow-left me-1"></i>
                    Return to Dashboard
                </a>
            </div>
        </div>
</x-admin.auth-layout>