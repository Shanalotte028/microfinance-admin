@if(session('success'))
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark-low text-white"> <!-- Add custom class here -->
        <div class="modal-header border-0"> <!-- Remove divider class -->
          <h5 class="modal-title text-light" id="successModalLabel">Success</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Red close button -->
        </div>
        <div class="modal-body border-0">
          {{ session('success') }}
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
      document.addEventListener('DOMContentLoaded', function () {
          var successModal = new bootstrap.Modal(document.getElementById('successModal'));
          successModal.show();
      });
  </script>
@endif
