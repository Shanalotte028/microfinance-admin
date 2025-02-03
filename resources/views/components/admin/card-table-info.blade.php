<div class="card mb-4">
    <div class="card-body table-responsive">
        <h4 class="text-light d-flex  flex-column flex-md-row justify-content-between">{{ $heading ?? '' }}</h4>
        <h5 class="text-light mb-4 d-flex justify-content-between">{{ $heading_child ?? ''}}</h5>
        <table class="table table-striped table-borderless">
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
        <div class="text-end mt-4 pe-4">
            {{ $button ?? '' }} <!-- Show all button -->
        </div>
    </div>
</div>