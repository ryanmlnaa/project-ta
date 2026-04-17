@extends('layouts.app')

@section('content')
<div class="container">

<div class="card shadow">
<div class="card-header text-white" style="background: linear-gradient(90deg,#4f46e5,#6366f1)">
    <h5>Status Pengaduan Saya</h5>
</div>

<div class="card-body">

<table class="table table-bordered text-center">
<thead>
<tr>
<th>No</th>
<th>Tanggal</th>
<th>Status</th>
<th>Detail</th>
</tr>
</thead>

<tbody>
@foreach($layanan as $item)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $item->tanggal_pengaduan }}</td>

<td>
    @if($item->status == 'diajukan')
        <span class="badge badge-pill badge-secondary">Diajukan</span>
    @elseif($item->status == 'diproses')
        <span class="badge badge-pill badge-warning">Diproses</span>
    @else
        <span class="badge badge-pill badge-success">Selesai</span>
    @endif
</td>

<td>
<button class="btn btn-info btn-sm"
    data-toggle="modal"
    data-target="#detail{{ $item->id }}">
    Detail
</button>
</td>
</tr>
@endforeach
</tbody>

</table>

</div>
</div>

</div>

{{-- 🔥 MODAL DI LUAR TABLE (WAJIB) --}}
@foreach($layanan as $item)
<div class="modal fade" id="detail{{ $item->id }}" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-primary text-white">
<h5>Detail Pengaduan</h5>
<button class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

<p><b>Deskripsi:</b><br>{{ $item->deskripsi }}</p>

<p><b>Tanggapan Admin:</b><br>
{{ $item->tanggapan_admin ?? 'Belum ada tanggapan' }}
</p>

<p><b>Status:</b>
    @if($item->status == 'diajukan')
        <span class="badge badge-secondary">Diajukan</span>
    @elseif($item->status == 'diproses')
        <span class="badge badge-warning">Diproses</span>
    @else
        <span class="badge badge-success">Selesai</span>
    @endif
</p>

@if($item->foto)
<img src="{{ asset('storage/'.$item->foto) }}" class="img-fluid rounded mt-2">
@endif

</div>

</div>
</div>
</div>
@endforeach

@endsection
