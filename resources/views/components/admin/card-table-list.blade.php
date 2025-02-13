<div class="card mb-4">
    <div class="card-body table-responsive">
        <h4 class="mb-4">{{ $heading }}</h4>
        <table class="table table-striped table-borderless">
            <thead>
                <tr>
                    {{ $table_row }}
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
        <div class="mt-4 pe-4">
             {{ $button ?? '' }}<!-- Show all button -->
        </div> 
    </div>
</div>