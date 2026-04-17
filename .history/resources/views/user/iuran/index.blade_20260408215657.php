@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Data Iuran Saya</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($iuran as $i)
            <tr>
                <td>{{ $i->bulan }}</td>

                <td>Rp {{ number_format($i->jumlah,0,',','.') }}</td>

                <td>
                    @if($i->status == 'lunas')
                        <span class="badge bg-success">Lunas</span>
                    @else
                        <span class="badge bg-danger">Belum</span>
                    @endif
                </td>

                <td>
                    @if($i->status == 'lunas')
                        ✔
                    @else
                    
                        <a href="{{ route('user.iuran.upload', $i->id) }}" class="btn btn-primary btn-sm">
                            Bayar
                        </a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">
                    Belum ada data iuran
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>

</div>
<script>
function bayarQris(id) {
    fetch(`/user/iuran/qris/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            let row = document.getElementById("row-" + id);
            row.querySelector(".status").innerHTML =
                '<span class="badge bg-success">Lunas</span>';
        }
    });
}
</script>
@endsection
