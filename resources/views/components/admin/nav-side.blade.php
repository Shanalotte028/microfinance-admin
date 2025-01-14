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
                    <div class="sb-sidenav-menu-heading">Account Management</div>
                    <x-admin.nav-item id="collapseAccount" heading="Account Management"  label="Create Account" route="{{ route('admin.accountCreate') }}" icon="fas fa-columns" />
                    @endcan
                </div>
            </div>
        </nav>
    </div>