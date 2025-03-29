@props(['id', 'heading', 'label', 'route', 'icon'])

@php
    $isActive = request()->url() == $route; // Checks if the current URL matches the route
@endphp

<a class="nav-link collapsed {{ $isActive ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#{{ $id }}" aria-expanded="false" aria-controls="{{ $id }}">
    <div class="sb-nav-link-icon"><i class="{{ $icon }}"></i></div>
    {{ $heading }}
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse {{ $isActive ? 'show' : '' }}" id="{{ $id }}" aria-labelledby="heading{{ $id }}" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav">
        <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ $route }}">{{ $label }}</a>
    </nav>
</div>
