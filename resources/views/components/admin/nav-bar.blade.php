<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Brand and toggle grouped together -->
        <div class="d-flex align-items-center">
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-2 me-lg-2" id="sidebarToggle" href="#!">
                <i class="fas fa-bars"></i>
            </button>
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-1" href="{{ route('dashboard') }}">
                Ascenders Business Services
            </a>
        </div>

        <!-- Navbar Right Side -->
        <div class="d-flex">
            <!-- Navbar Search (empty but kept for structure) -->
            <div class="input-group"></div>
            
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user fa-fw"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end bg-dark" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                        @can('audit')
                        <li><a class="dropdown-item" href="{{ route('admin.activity-log') }}">Activity Log</a></li>
                        @endcan
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>