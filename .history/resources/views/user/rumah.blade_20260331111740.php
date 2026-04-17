<div class="card mt-4">
    <div class="card-header bg-success text-white">
        Pilih Rumah
    </div>

    <div class="card-body">
        <div class="row">
            @foreach($rumahKosong as $r)
                <div class="col-md-2 mb-2">
                    <a href="{{ route('user.pilih.rumah', $r->id) }}"
                       class="btn btn-success w-100">
                        {{ $r->no_rumah }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
