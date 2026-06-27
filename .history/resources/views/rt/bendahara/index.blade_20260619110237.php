@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Kelola Bendahara</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->has('bendahara'))
        <div class="alert alert-danger">{{ $errors->first('bendahara') }}</div>
    @endif

    {{-- Form tambah bendahara (hanya muncul kalau belum ada yang aktif) --}}
    @if(!$bendaharaAktif)
    <div class="card mb-4">
        <div class="card-header">Tambah Akun Bendahara</div>
        <div class="card-body">
            <form action="{{ route('rt.bendahara.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="alert alert-info">
                    Password default akan otomatis dibuat: <strong>12345678</strong>. Bendahara wajib menggantinya saat login pertama kali.
                </div>
                <button type="submit" class="btn btn-primary">Buat Akun Bendahara</button>
            </form>
        </div>
    </div>
    @endif

    {{-- Daftar bendahara --}}
    <div class="card">
        <div class="card-header">Riwayat Akun Bendahara</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bendaharas as $b)
                    <tr>
                        <td>{{ $b->name }}</td>
                        <td>{{ $b->username }}</td>
                        <td>{{ $b->email }}</td>
                        <td>
                            @if($b->status_akun === 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            @if($b->status_akun === 'aktif')
                            <form action="{{ route('rt.bendahara.nonaktifkan', $b->id) }}" method="POST"
                                  onsubmit="return confirm('Nonaktifkan bendahara ini?')">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-warning">Nonaktifkan</button>
                            </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada akun bendahara.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
