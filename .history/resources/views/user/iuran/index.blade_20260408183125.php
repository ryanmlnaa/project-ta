@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Iuran Saya</h3>

    <table class="table table-bordered">
        <tr>
            <th>Bulan</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        @foreach($iuran as $i)
        <tr id="row-{{ $i->id }}">
            <td>{{ $i->bulan }}</td>
            <td>Rp {{ number_format($i->jumlah,0,',','.') }}</td>

            <td class="status">
                @if($i->status == 'lunas')
                    <span class="badge bg-success">Lunas</span>
                @else
                    <span class="badge bg-danger">Belum</span>
                @endif
            </td>

            <td>
                @if($i->status == 'belum')

                    <img src="{{ asset('qris/qris.png') }}" width="100"><br>

                    <button onclick="bayarQris({{ $i->id }})" class="btn btn-primary btn-sm mt-2">
                        Saya Sudah Bayar
                    </button>

                @else
                    ✔
                @endif
            </td>
        </tr>
        @endforeach

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
