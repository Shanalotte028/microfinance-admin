<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <!-- Home -->
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="bi bi-house-door"></i></div>
                        Home
                    </a>

                    <!-- Client Management -->
                    @can('clients.index')
                        <div class="sb-sidenav-menu-heading">Client Management</div>
                        <a class="nav-link {{ request()->routeIs('admin.client.*') ? 'active' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#collapseClients"
                            aria-expanded="{{ request()->routeIs('admin.client.*') ? 'true' : 'false' }}"
                            aria-controls="collapseClients">
                            <div class="sb-nav-link-icon"><i class="bi bi-people"></i></div>
                            Clients
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.client.*') ? 'show' : '' }}" id="collapseClients"
                            aria-labelledby="headingClients" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ request()->routeIs('admin.client.index') ? 'active' : '' }}"
                                    href="{{ route('admin.client.index') }}">
                                    List Clients
                                </a>
                            </nav>
                        </div>
                    @endcan

                    <!-- Compliance Management -->
                    @can('compliances.index')
                        <div class="sb-sidenav-menu-heading">Compliance Management</div>
                        <a class="nav-link {{ request()->routeIs('admin.compliances') ? 'active' : '' }}"
                            href="{{ route('admin.compliances') }}">
                            <div class="sb-nav-link-icon"><i class="bi bi-file-earmark-check"></i></div>
                            Compliance Records
                        </a>
                    @endcan

                    <!-- Risk Management -->
                    <div class="sb-sidenav-menu-heading">Risk Management</div>
                    <a class="nav-link {{ request()->routeIs('admin.risk_assessment.risks') ? 'active' : '' }}"
                        href="{{ route('admin.risk_assessment.risks') }}">
                        <div class="sb-nav-link-icon"><i class="bi bi-people"></i></div>
                        List Risks
                    </a>

                    <!-- User Management -->
                    @can('users.index')
                        <div class="sb-sidenav-menu-heading">User Management</div>
                        <a class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : 'collapsed' }}" href="#"
                            data-bs-toggle="collapse" data-bs-target="#collapseAccount"
                            aria-expanded="{{ request()->routeIs('admin.user.*') ? 'true' : 'false' }}"
                            aria-controls="collapseAccount">
                            <div class="sb-nav-link-icon"><i class="bi bi-person-gear"></i></div>
                            User Management
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.user.*') ? 'show' : '' }}" id="collapseAccount"
                            aria-labelledby="headingAccount" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                @can('users.index')
                                    <a class="nav-link {{ request()->routeIs('admin.user.index') ? 'active' : '' }}"
                                        href="{{ route('admin.user.index') }}">
                                        List Users
                                    </a>
                                @endcan
                                @can('users.create')
                                    <a class="nav-link {{ request()->routeIs('admin.accountCreate') ? 'active' : '' }}"
                                        href="{{ route('admin.accountCreate') }}">
                                        Create User
                                    </a>
                                @endcan
                            </nav>
                        </div>
                    @endcan

                    <!-- Legal Management -->
                    @can('legal.index')
                        <div class="sb-sidenav-menu-heading">Legal Management</div>
                        <a class="nav-link {{ request()->routeIs('admin.legal.*') ? 'active' : 'collapsed' }}"
                            href="#" data-bs-toggle="collapse" data-bs-target="#collapseLegal"
                            aria-expanded="{{ request()->routeIs('admin.legal.*') ? 'true' : 'false' }}"
                            aria-controls="collapseLegal">
                            <div class="sb-nav-link-icon"><i class="bi bi-file-earmark-text"></i></div>
                            Legal Management
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.legal.*') ? 'show' : '' }}" id="collapseLegal"
                            aria-labelledby="headingLegal" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                @can('legal.index')
                                    @if (Auth::user()->role === 'Lawyer')
                                        <a class="nav-link {{ request()->routeIs('admin.legal.index') ? 'active' : '' }}"
                                            href="{{ route('admin.legal.index') }}">
                                            Assigned Cases
                                        </a>
                                    @else
                                        <a class="nav-link {{ request()->routeIs('admin.legal.index') ? 'active' : '' }}"
                                            href="{{ route('admin.legal.index') }}">
                                            List Cases
                                        </a>
                                    @endif
                                @endcan
                                @can('legal.create')
                                    <a class="nav-link {{ request()->routeIs('admin.legal.create') ? 'active' : '' }}"
                                        href="{{ route('admin.legal.create') }}">
                                        Create Cases
                                    </a>
                                @endcan
                            </nav>
                        </div>
                    @endcan

                </div>
            </div>
        </nav>
    </div>

