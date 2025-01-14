@props(['id', 'heading','label', 'route', 'icon'])

<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#{{ $id }}" aria-expanded="false" aria-controls="{{ $id }}">
    <div class="sb-nav-link-icon"><i class="{{ $icon }}"></i></div>
    {{ $heading }}
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="{{ $id }}" aria-labelledby="heading{{ $id }}" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav">
        <a class="nav-link" href="{{ $route }}">{{ $label }}</a>
    </nav>
</div>