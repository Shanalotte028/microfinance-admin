<x-header/>
    <x-nav-bar/>
    <x-nav-side/>
        <div id="layoutSidenav_content"  class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light">{{ $heading ?? 'Default Heading' }}</h1>
                        <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">{{ $heading_child ?? ''}}</li>
                        </ol>
                    {{ $slot }}
                </div>
            </main>
            <x-footer/>
        </div>
    </div>
<x-foot/>