@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Kelola Data User</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    <a href="{{ route('admin.user.edit', $u->id) }}" class="btn btn-warning btn-sm">
                        Edit
                    </a>
                    <form action="{{ route('admin.user.delete', $u->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('Yakin mau hapus user ini?')">
        Hapus
    </button>
</form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
