@if(session('success'))
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content custom-dark-modal"> <!-- Add custom class here -->
        <div class="modal-header no-divider"> <!-- Remove divider class -->
          <h5 class="modal-title text-light" id="successModalLabel">Success</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!-- Red close button -->
        </div>
        <div class="modal-body no-divider">
          {{ session('success') }}
        </div>
        <div class="modal-footer no-divider">
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

  <style>
      /* Custom styles for the dark background */
      .modal-backdrop.show {
          background-color: rgba(0, 0, 0, 0.8); /* Dark overlay */
      }

      /* Custom styles for modal content */
      .custom-dark-modal {
          background-color: #343a40; /* Dark background for modal */
          color: white; /* Text color */
      }

      /* Remove divider between modal header and body */
      .no-divider {
          border-bottom: none;
          border-top: none; /* Remove bottom border in header */
      }
  </style>
@endif
