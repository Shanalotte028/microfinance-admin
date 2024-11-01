<x-client.layout>
  <x-client.header/>
  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img id="financialImg" alt="" data-aos="fade-in" class="">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <h2>Company Name</h2>
        <p><span class="typed" data-typed-items="Hi there!, {{ Auth::guard('client')->user()->first_name }} {{ Auth::guard('client')->user()->last_name }}, Welcome to, Company name">User Name</span><span class="typed-cursor typed-cursor--blink" aria-hidden="true"></span><span class="typed-cursor typed-cursor--blink" aria-hidden="true"></span></p>
      </div>

    </section><!-- /Hero Section -->

    <!-- overview Section -->
  <x-client.section>
    <x-slot:id>overview</x-slot:id>
    <x-slot:title>Overview</x-slot:title>
          <div class="row justify-content-between">
              <div class="col-md-4 col-xl-3">
                <a href="starter-page.html" class="text-decoration-none">
                <div class="card bg-c-black order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Balance</h6>
                        <h2 class="text-right"><i class="fa-solid fa-wallet f-left"></i><span>0</span></h2>
                    </div>
                </div>
              </a>
              </div> 
              <div class="col-md-4 col-xl-3">
                <a href="starter-page.html" class="text-decoration-none">
                <div class="card bg-c-black order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Financial Activities</h6>
                        <h2 class="text-right"><i class="fa-solid fa-chart-simple f-left"></i><span>0</span></h2>
                    </div>
                </div>
              </a>
              </div> 
              <div class="col-md-4 col-xl-3">
                <a href="starter-page.html" class="text-decoration-none">
                <div class="card bg-c-black order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Loan Records</h6>
                        <h2 class="text-right"><i class="fa-solid fa-scale-unbalanced-flip f-left"></i><span>0</span></h2>
                    </div>
                </div>
                </a>
              </div>
              <div class="col-md-4 col-xl-3">
                <a href="starter-page.html" class="text-decoration-none">
                <div class="card bg-c-black order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Compliance Records</h6>
                        <h2 class="text-right"><i class="fa-solid fa-folder f-left"></i><span>0</span></h2>
                    </div>
                </div>
                </a>
              </div>   
          </div>
  </x-client.section>
  </main>
</x-client.layout>