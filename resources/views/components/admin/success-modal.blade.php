<!-- success-modal.blade.php -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark-low text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title text-light" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0">
                <p id="successMessage">{{ session('success') }}</p> <!-- ✅ This will be updated dynamically -->
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
