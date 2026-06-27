@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f0; }

.ei-wrapper { max-width: 600px; margin: 0 auto; padding: 28px 16px 60px; }

.ei-page-header {
    display: flex; align-items: center; gap: 14px; margin-bottom: 24px;
}
.ei-header-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #92400e, #d97706);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 19px; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(146,64,14,0.25);
}
.ei-page-header h1 { font-size: 20px; font-weight: 800; color: #1a2e1a; margin: 0; }
.ei-page-header p  { font-size: 12.5px; color: #8a9e8a; margin: 0; }

.ei-alert-tolak {
    background: #fdf0f0;
    border: 1px solid #f5a8a8;
    border-left: 4px solid #ef4444;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 20px;
    display: flex; gap: 12px; align-items: flex-start;
}
.ei-alert-tolak-icon {
    width: 34px; height: 34px; flex-shrink: 0;
    background: #fecaca; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: #dc2626; font-size: 15px;
}
.ei-alert-tolak-label {
    font-size: 11px; font-weight: 700; color: #ef4444;
    text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;
}
.ei-alert-tolak-text { font-size: 13px; color: #7a1a1a; line-height: 1.5; }

.ei-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e8f0e8;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    overflow: hidden;
}

.ei-card-header {
    padding: 16px 22px;
    background: #fffbeb;
    border-bottom: 1px solid #fde68a;
    display: flex; align-items: center; gap: 10px;
}
.ei-card-header-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: #fef3c7; color: #d97706;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; flex-shrink: 0;
}
.ei-card-header h6 { font-size: 13.5px; font-weight: 700; color: #1a2e1a; margin: 0; }

.ei-card-body { padding: 22px; }

.ei-alert-error {
    background: #fdf0f0;
    border: 1px solid #f5a8a8;
    border-left: 4px solid #ef4444;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 13px; color: #7a1a1a;
    margin-bottom: 20px;
}

.ei-form-group { margin-bottom: 18px; }
.ei-form-row { display: flex; gap: 14px; margin-bottom: 18px; }
.ei-form-row .ei-form-group { flex: 1; margin-bottom: 0; }

.ei-label {
    display: block; font-size: 11.5px; font-weight: 700;
    color: #374151; text-transform: uppercase;
    letter-spacing: 0.5px; margin-bottom: 7px;
}
.ei-label span { color: #ef4444; margin-left: 2px; }

.ei-input, .ei-select, .ei-textarea {
    width: 100%; padding: 10px 13px;
    border: 1.5px solid #e0ede0; border-radius: 10px;
    font-size: 13.5px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1f2937; outline: none; background: #fafafa;
    transition: border-color 0.15s, box-shadow 0.15s;
    appearance: none; -webkit-appearance: none;
}
.ei-input:focus, .ei-select:focus, .ei-textarea:focus {
    border-color: #d97706;
    box-shadow: 0 0 0 3px rgba(217,119,6,0.10);
    background: #fff;
}
.ei-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 34px;
}
.ei-textarea { resize: vertical; min-height: 80px; }

.ei-btn-row { display: flex; gap: 10px; margin-top: 6px; }
.ei-btn {
    flex: 1; padding: 12px; border: none; border-radius: 11px;
    font-size: 13.5px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    transition: opacity 0.15s, transform 0.1s; text-decoration: none;
}
.ei-btn:hover { opacity: 0.88; transform: translateY(-1px); text-decoration: none; }
.ei-btn:active { transform: translateY(0); }
.ei-btn-warning  { background: linear-gradient(135deg, #92400e, #d97706); color: #fff; }
.ei-btn-secondary { background: #f3f4f6; color: #4b5563; flex: 0 0 auto; padding: 12px 18px; }

@media (max-width: 480px) {
    .ei-wrapper { padding: 20px 12px 48px; }
    .ei-form-row { flex-direction: column; gap: 18px; }
    .ei-card-body { padding: 16px; }
    .ei-btn-row { flex-direction: column; }
    .ei-btn-secondary { flex: 1; }
}
</style>

<div class="ei-wrapper">

    <div class="ei-page-header">
        <div class="ei-header-icon"><i class="fas fa-edit"></i></div>
        <div>
            <h1>Edit & Ajukan Ulang</h1>
            <p>Perbaiki iuran yang ditolak RT</p>
        </div>
    </div>

    {{-- Alasan Ditolak --}}
    <div class="ei-alert-tolak">
        <div class="ei-alert-tolak-icon"><i class="fas fa-times-circle"></i></div>
        <div>
            <div class="ei-alert-tolak-label">Alasan Ditolak RT</div>
            <div class="ei-alert-tolak-text">{{ $iuran->catatan_rt ?? '-' }}</div>
        </div>
    </div>

    <div class="ei-card">
        <div class="ei-card-header">
            <div class="ei-card-header-icon"><i class="fas fa-pencil-alt"></i></div>
            <h6>Form Edit Iuran</h6>
        </div>

        <div class="ei-card-body">

            @if($errors->any())
                <div class="ei-alert-error">
                    @foreach($errors->all() as $error)
                        <div><i class="fas fa-times-circle me-1"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('bendahara.iuran.update', $iuran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="ei-form-group">
                    <label class="ei-label"><i class="fas fa-user me-1"></i> Penghuni <span>*</span></label>
                    <select name="penghuni_id" class="ei-select" required>
                        @foreach($penghunis as $p)
                            <option value="{{ $p->id }}" {{ $iuran->penghuni_id == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }} ({{ $p->no_rumah ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="ei-form-row">
                    <div class="ei-form-group">
                        <label class="ei-label"><i class="fas fa-calendar-alt me-1"></i> Bulan <span>*</span></label>
                        <select name="bulan" class="ei-select" required>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                                <option value="{{ $b }}" {{ $iuran->bulan == $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ei-form-group">
                        <label class="ei-label"><i class="fas fa-calendar me-1"></i> Tahun <span>*</span></label>
                        <input type="number" name="tahun" class="ei-input"
                               value="{{ $iuran->tahun }}" required min="2020" max="2099">
                    </div>
                </div>

                <div class="ei-form-group">
                    <label class="ei-label"><i class="fas fa-money-bill-wave me-1"></i> Jumlah (Rp) <span>*</span></label>
                    <input type="number" name="jumlah" class="ei-input"
                           value="{{ $iuran->jumlah }}" required min="0">
                </div>

                <div class="ei-form-group">
                    <label class="ei-label"><i class="fas fa-tags me-1"></i> Jenis Iuran <span>*</span></label>
                    <select name="jenis_iuran" class="ei-select" required>
                        <option value="">-- Pilih Jenis Iuran --</option>
                        @foreach(['Kebersihan','Keamanan','Sosial','Operasional','Lainnya'] as $j)
                            <option value="{{ $j }}" {{ $iuran->jenis_iuran == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ei-form-group">
                    <label class="ei-label"><i class="fas fa-align-left me-1"></i> Keterangan</label>
                    <textarea name="keterangan" class="ei-textarea"
                              placeholder="Tambahkan keterangan jika diperlukan...">{{ $iuran->keterangan }}</textarea>
                </div>

                <div class="ei-btn-row">
                    <button type="submit" class="ei-btn ei-btn-warning">
                        <i class="fas fa-paper-plane"></i> Ajukan Ulang ke RT
                    </button>
                    <a href="{{ route('bendahara.iuran.index') }}" class="ei-btn ei-btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
