<x-client.layout>
  <x-client.header/>
  <main class="main">
    <x-client.page-title>Compliance</x-client.page-title>

    <!-- Compliance Section Section -->
    <x-client.section>
      <x-slot:id>compliance</x-slot:id>
      <x-slot:title>Compliance Records</x-slot:title>
        <div class="d-flex justify-content-end mb-5">
          <div class="col-sm-2">
            <a class="btn btn-success custom-button" href="{{ route('client.compliance.create') }}">Apply</a>
          </div>
        </div>
        <table class="table table-striped table-borderless">
            <thead>
                <tr>
                  <th>Compliance Type</th>
                  <th>Document Type</th>
                  <th>Submission Date</th>
                  <th>Approval Date</th>
                  <th>Document Status</th>
                </tr>
            </thead>
            <tbody>
              @if($compliances->isEmpty())
              <tr>
                  <td colspan="5" class="text-center">No compliance records found.</td>
              </tr>
            @else
              @foreach ($compliances as $compliance)
                <tr>
                    <td>{{ $compliance->compliance_type ?? 'n/a'}}</td>
                    <td>{{ $compliance->document_type ?? 'n/a' }}</td>
                    <td>{{ $compliance->submission_date ?? 'n/a'}}</td>
                    <td>{{ $compliance->approval_date ?? 'n/a' }}</td>
                    <td>{{ $compliance->document_status ?? 'n/a'}}</td>
                </tr>
              @endforeach
            @endif
            </tbody>
        </table>
       
      </x-client.section>
    <!-- /Compliance Section Section -->
    <!-- Include the success pop-up component -->
    <x-client.success-popup/>
  </main>

 
</x-client.layout>