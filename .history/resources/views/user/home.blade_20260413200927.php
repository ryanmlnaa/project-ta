@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4 fw-bold text-primary">Beranda Penghuni</h3>

    {{-- 🔔 NOTIF --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    {{-- ========================= --}}
    {{-- DATA PENGHUNI --}}
    {{-- ========================= --}}
    @if(isset($penghuni))
        <div class="card modern-card mb-3">
            <div class="card-body">
                <h5 class="fw-bold">👤 Data Anda</h5>
                <p><b>Nama:</b> {{ $penghuni->nama }}</p>
                <p><b>Email:</b> {{ $penghuni->email }}</p>

                <p><b>Status Huni:</b>
                    <span class="badge
                        {{ $penghuni->status_huni == 'Tetap' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ $penghuni->status_huni }}
                    </span>
                </p>
            </div>
        </div>
    @endif

    {{-- ========================= --}}
    {{-- DATA IURAN --}}
    {{-- ========================= --}}
    <h4 class="mt-4 fw-bold">💰 Data Iuran Saya</h4>

    @forelse($iuran as $i)
    <div class="card modern-card mb-3">
        <div class="card-body">

            <h5>Iuran {{ $i->bulan }} {{ $i->tahun }}</h5>

            <p><b>Jumlah:</b> Rp {{ number_format($i->jumlah,0,',','.') }}</p>

            <p><b>Status:</b>
                <span class="badge
                    {{ $i->status=='lunas' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ ucfirst($i->status) }}
                </span>
            </p>

            {{-- PROGRESS --}}
            <div class="timeline">
                <div class="timeline-step {{ $i->bukti_pembayaran ? 'active':'' }}">📤</div>
                <div class="timeline-step {{ $i->status=='lunas' ? 'active':'' }}">✔</div>
                <div class="timeline-line"></div>
            </div>

        </div>
    </div>

    {{-- 🔥 TOMBOL HAPUS DI SINI --}}
    <div class="mt-3">
        @if($i->status == 'lunas')
            <form action="{{ route('user.iuran.delete', $i->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm">
                    🗑️ Hapus
                </button>
            </form>
        @else
            <button class="btn btn-secondary btn-sm" disabled>
                ❌ Tidak bisa dihapus
            </button>
        @endif
    </div>
    @empty
    <div class="alert alert-warning">Belum ada data iuran</div>
    @endforelse

    {{-- ========================= --}}
    {{-- STATUS PENGADUAN --}}
    {{-- ========================= --}}
    <h4 class="mt-4 fw-bold">📢 Status Pengaduan Saya</h4>

    @php
        $pengaduan = \App\Models\Layanan::where('penghuni_id', $penghuni->id ?? 0)->latest()->get();
    @endphp

    @forelse($pengaduan as $p)
    <div class="card modern-card mb-3">
        <div class="card-body">

            <div class="d-flex justify-content-between">
                <h5>#P-{{ str_pad($p->id,3,'0',STR_PAD_LEFT) }}</h5>

                <span class="badge
                    {{ $p->status=='selesai' ? 'bg-success' : ($p->status=='diproses' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                    {{ ucfirst($p->status) }}
                </span>
            </div>

            <p class="text-muted">
                {{ \Illuminate\Support\Str::limit($p->deskripsi,80) }}
            </p>

            {{-- TIMELINE --}}
            <div class="timeline">
                <div class="timeline-step active">📩</div>
                <div class="timeline-step {{ $p->status!='diajukan' ? 'active':'' }}">⚙️</div>
                <div class="timeline-step {{ $p->status=='selesai' ? 'active':'' }}">✅</div>
                <div class="timeline-line"></div>
            </div>

            <small class="text-muted">
                {{ \Carbon\Carbon::parse($p->tanggal_pengaduan)->translatedFormat('d M Y H:i') }}
            </small>

            @if($p->tanggapan_admin)
            <div class="alert alert-success mt-2">
                <b>Tanggapan:</b> {{ $p->tanggapan_admin }}
            </div>
            @endif

        </div>
    </div>
    @empty
    <div class="alert alert-info">Belum ada pengaduan</div>
    @endforelse

</div>
@endsection

{{-- 🔥 STYLE + SCRIPT DIGABUNG --}}
@section('scripts')
<style>

/* 🔥 CARD MODERN */
.modern-card {
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.modern-card:hover {
    transform: translateY(-3px);
}

/* 🔥 TIMELINE */
.timeline {
    position: relative;
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.timeline-step {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background:#e5e7eb;
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:2;
    transition:0.3s;
}

.timeline-step.active {
    background: linear-gradient(135deg,#4f46e5,#6366f1);
    color:white;
    transform: scale(1.1);
}

.timeline-line {
    position:absolute;
    top:20px;
    left:10%;
    right:10%;
    height:5px;
    background:#e5e7eb;
    z-index:1;
    border-radius:10px;
}

/* ANIMASI */
.modern-card {
    animation: fadeUp 0.4s ease;
}

@keyframes fadeUp {
    from {opacity:0; transform:translateY(20px);}
    to {opacity:1; transform:translateY(0);}
}

</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const statusHuni = document.getElementById('statusHuni');
    const tanggalKeluarField = document.getElementById('tanggalKeluarField');
    const tanggalKeluarInput = document.getElementById('tanggalKeluarInput');

    if (statusHuni) {
        statusHuni.addEventListener('change', function () {
            if (this.value === 'Kontrak') {
                tanggalKeluarField.classList.remove('d-none');
                tanggalKeluarInput.required = true;
            } else {
                tanggalKeluarField.classList.add('d-none');
                tanggalKeluarInput.required = false;
                tanggalKeluarInput.value = '';
            }
        });
    }

});
</script>
@endsection
