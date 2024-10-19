<section id="{{ $id ?? '' }}" class="about section dark-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ $title ?? '' }}</h2>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        {{ $slot }}
    </div>
  </section><!-- /overview Section -->