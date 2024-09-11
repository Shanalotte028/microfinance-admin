<div class="card mb-4 border-dark text-light bg-dark">
    <div class="card-header bg-dark">
        <i class="fas fa-table me-1"></i>
        {{ $heading }}
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="text-light border-dark table table-striped">
            {{$slot}}
        </table>
    </div>
</div>

