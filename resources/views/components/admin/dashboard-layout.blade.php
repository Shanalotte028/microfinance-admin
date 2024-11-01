<x-admin.header/>
    <x-admin.nav-bar/>
    <x-admin.nav-side/>
        <div id="layoutSidenav_content"  class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="me-2" style="position: relative; top: 13px;">
                            {{ $back ?? '' }}
                        </div>
                        <h1 class="mt-4 text-light mb-0">{{ $heading ?? 'Default Heading' }}</h1>
                    </div>
                    <ol class="breadcrumb mb-4 ms-5">
                         <!-- Added ms-5 to align breadcrumb with the heading -->
                        <li class="breadcrumb-item active">{{ $heading_child ?? ''}}</li>
                    </ol>
                    {{ $slot }}
                </div>
            </main>
            <x-admin.footer/>
        </div>
    </div>
<x-admin.foot/>