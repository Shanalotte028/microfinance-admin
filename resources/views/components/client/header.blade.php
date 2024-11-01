<header id="header" class="header dark-background d-flex flex-column">
    <i class="header-toggle bi bi-list"></i>
    <div class="profile-img">
      <img id="profilePic" alt="" class="img-fluid rounded-circle">
    </div>
    <a href="{{ route('client.dashboard') }}" class="logo d-flex align-items-center justify-content-center">
      <!-- Uncomment the line below if you also wish to use an image logo -->
      <!-- <img src="assets/img/logo.png" alt=""> -->
      <h1 class="sitename">
        {{ Auth::guard('client')->user()->first_name }} {{ Auth::guard('client')->user()->last_name }}
      </h1>
    </a>
    <nav id="navmenu" class="navmenu d-flex flex-column">
      <ul class="flex-grow-1">
        <li><a href="{{ route('client.dashboard') }}"><i class="bi bi-house navicon"></i>Home</a></li>
        <li><a href="{{ route('client.profile') }}"><i class="bi bi-person navicon"></i>Profile</a></li>
        <li><a href="#overview"><i class="bi bi-view-list navicon"></i>Overview</a></li>
        <li><a href='{{ route('client.compliance.compliance_records') }}'><i class="bi bi-folder navicon"></i>Compliance</a></li>
        <form action='{{ route('client.logout') }}' method="POST">
          @csrf
        <li><button type='submit' class="btn btn-success custom-button"><i class="bi bi-box-arrow-left navicon"></i>Log-Out</button></li>
        </form>
      </ul>
    </nav>
</header>