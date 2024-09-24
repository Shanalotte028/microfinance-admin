<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        {{ $heading }}
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-striped">
            {{$slot}}
        </table>
    </div>
</div>

