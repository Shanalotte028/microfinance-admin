<!-- Page Title -->
<div class="page-title dark-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">{{ $slot }}</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('client.index') }}">Home</a></li>
          <li class="current">{{ $slot }}</li>
        </ol>
      </nav>
    </div>
</div><!-- End Page Title -->