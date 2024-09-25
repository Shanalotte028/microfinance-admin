<header id="header" class="header dark-background d-flex flex-column">
    <i class="header-toggle bi bi-list"></i>
    <div class="profile-img">
      <img id="profilePic" alt="" class="img-fluid rounded-circle">
    </div>
    <a href="index.html" class="logo d-flex align-items-center justify-content-center">
      <!-- Uncomment the line below if you also wish to use an image logo -->
      <!-- <img src="assets/img/logo.png" alt=""> -->
      <h1 class="sitename">John Doe</h1>
    </a>
    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('client.index') }}" class="active"><i class="bi bi-house navicon"></i>Home</a></li>
        <li><a href="#overview"><i class="bi bi-person navicon"></i>Overview</a></li>
        <li><a href='{{ route('client.compliance') }}'><i class="bi bi-folder navicon"></i>Compliance</a></li>
      </ul>
    </nav>
</header>