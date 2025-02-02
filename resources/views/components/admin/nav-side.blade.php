<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Home
                    </a>
                    <div class="sb-sidenav-menu-heading">Client Management</div>
                    <x-admin.nav-item id="collapseClients" heading="Clients" label="List Clients" route="{{ route('admin.client.index') }}" icon="fas fa-columns" />
                    <div class="sb-sidenav-menu-heading">Compliance Management</div>
                    <x-admin.nav-item id="collapseCompliances" heading="Compliances"  label="Compliance Records" route="{{ route('admin.compliances') }}" icon="fas fa-columns" />
                    @can('admin')
                    <div class="sb-sidenav-menu-heading">User Management</div>
                    <!-- Dropdown menu for User Management -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="false" aria-controls="collapseAccount">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        User Management
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseAccount" aria-labelledby="headingAccount" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('admin.user.index') }}">List Users</a>
                            <a class="nav-link" href="{{ route('admin.accountCreate') }}">Create User</a>
                        </nav>
                    </div>
                    {{-- Legal Management --}}
                    <div class="sb-sidenav-menu-heading">Legal Management</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLegal" aria-expanded="false" aria-controls="collapseLegal">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Legal Management
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLegal" aria-labelledby="headingAccount" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('admin.legal.index') }}">List Cases</a>
                            <a class="nav-link" href="{{ route('admin.legal.create') }}">Create Cases</a>
                        </nav>
                    </div>
                    @endcan
                </div>
            </div>
        </nav>
    </div>