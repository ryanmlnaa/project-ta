@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Buat Tagihan Kas ke Penghuni</h4>

    <form action="{{ route('bendahara.kas.tagihan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Penghuni</label>
            <select name="penghuni_id" class="form-control" required>
                <option value="">-- Pilih Penghuni --</option>
                @foreach($penghunis as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->no_rumah ?? '-' }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <input type="text" name="keterangan" class="form-control" placeholder="Misal: Kas sumbangan acara" required>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Tagihan</button>
        <a href="{{ route('bendahara.kas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
