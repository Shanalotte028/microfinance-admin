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
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseClients" aria-expanded="false" aria-controls="collapseClients">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Clients
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseClients" aria-labelledby="headingClients" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('admin.client.index') }}">List Clients</a>
                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Compliance Management</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCompliances" aria-expanded="false" aria-controls="collapseCompliances">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Compliances
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseCompliances" aria-labelledby="headingCompliances" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('admin.compliances') }}">Compliance Records</a>
                        </nav>
                    </div>
                    @can('admin')
                    <div class="sb-sidenav-menu-heading">Account Management</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="false" aria-controls="collapseAccount">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Account Management
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseAccount" aria-labelledby="headingAccount" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('admin.accountCreate') }}">Create Account</a>
                        </nav>
                    </div>
                    @endcan
                </div>
            </div>
        </nav>
    </div>