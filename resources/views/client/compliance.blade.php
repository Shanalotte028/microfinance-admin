<x-client.layout>
  <x-client.header/>
  <main class="main">
    <x-client.page-title>Compliance</x-client.page-title>

    <!-- Starter Section Section -->
    <x-client.section>
      <x-slot:id>compliance</x-slot:id>
      <x-slot:title>Compliance Records</x-slot:title>
        <div class="d-flex justify-content-end">
          <div class="col-sm-2">
            <a class="btn btn-success" href="{{ route('client.compliance.create') }}">Apply</a>
          </div>
        </div>
      </x-client.section>
    <!-- /Starter Section Section -->
  </main>
</x-client.layout>