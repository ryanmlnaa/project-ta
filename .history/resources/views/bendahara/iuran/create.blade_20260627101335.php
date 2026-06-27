@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f0; }

.ci-wrapper { max-width: 600px; margin: 0 auto; padding: 28px 16px 60px; }

.ci-page-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
}
.ci-header-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #064e3b, #059669);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 19px; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(6,78,59,0.25);
}
.ci-page-header h1 { font-size: 20px; font-weight: 800; color: #1a2e1a; margin: 0; }
.ci-page-header p  { font-size: 12.5px; color: #8a9e8a; margin: 0; }

.ci-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e8f0e8;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    overflow: hidden;
}

.ci-card-header {
    padding: 16px 22px;
    background: #f6fbf7;
    border-bottom: 1px solid #e8f0e8;
    display: flex; align-items: center; gap: 10px;
}
.ci-card-header-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: #d1fae5; color: #064e3b;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; flex-shrink: 0;
}
.ci-card-header h6 { font-size: 13.5px; font-weight: 700; color: #1a2e1a; margin: 0; }

.ci-card-body { padding: 22px; }

.ci-alert-error {
    background: #fdf0f0;
    border: 1px solid #f5a8a8;
    border-left: 4px solid #ef4444;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 13px;
    color: #7a1a1a;
    margin-bottom: 20px;
}

.ci-form-group { margin-bottom: 18px; }
.ci-form-row { display: flex; gap: 14px; margin-bottom: 18px; }
.ci-form-row .ci-form-group { flex: 1; margin-bottom: 0; }

.ci-label {
    display: block;
    font-size: 11.5px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 7px;
}
.ci-label span { color: #ef4444; margin-left: 2px; }

.ci-input, .ci-select, .ci-textarea {
    width: 100%;
    padding: 10px 13px;
    border: 1.5px solid #e0ede0;
    border-radius: 10px;
    font-size: 13.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1f2937;
    outline: none;
    background: #fafafa;
    transition: border-color 0.15s, box-shadow 0.15s;
    appearance: none;
    -webkit-appearance: none;
}
.ci-input:focus, .ci-select:focus, .ci-textarea:focus {
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5,150,105,0.10);
    background: #fff;
}
.ci-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 34px;
}
.ci-textarea { resize: vertical; min-height: 80px; }

.ci-btn-row {
    display: flex;
    gap: 10px;
    margin-top: 6px;
}
.ci-btn {
    flex: 1;
    padding: 12px;
    border: none;
    border-radius: 11px;
    font-size: 13.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    transition: opacity 0.15s, transform 0.1s;
    text-decoration: none;
}
.ci-btn:hover { opacity: 0.88; transform: translateY(-1px); text-decoration: none; }
.ci-btn:active { transform: translateY(0); }
.ci-btn-primary { background: linear-gradient(135deg, #065f46, #059669); color: #fff; }
.ci-btn-secondary { background: #f3f4f6; color: #4b5563; flex: 0 0 auto; padding: 12px 18px; }

@media (max-width: 480px) {
    .ci-wrapper { padding: 20px 12px 48px; }
    .ci-form-row { flex-direction: column; gap: 18px; }
    .ci-card-body { padding: 16px; }
    .ci-btn-row { flex-direction: column; }
    .ci-btn-secondary { flex: 1; }
}
</style>

<div class="ci-wrapper">

    <div class="ci-page-header">
        <div class="ci-header-icon"><i class="fas fa-file-invoice-dollar"></i></div>
        <div>
            <h1>Ajukan Iuran Baru</h1>
            <p>Isi form berikut untuk mengajukan iuran ke RT</p>
        </div>
    </div>

    <div class="ci-card">
        <div class="ci-card-header">
            <div class="ci-card-header-icon"><i class="fas fa-plus-circle"></i></div>
            <h6>Form Pengajuan Iuran</h6>
        </div>

        <div class="ci-card-body">

            @if($errors->any())
                <div class="ci-alert-error">
                    @foreach($errors->all() as $error)
                        <div><i class="fas fa-times-circle me-1"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('bendahara.iuran.store') }}" method="POST">
                @csrf

                <div class="ci-form-group">
                    <label class="ci-label"><i class="fas fa-user me-1"></i> Penghuni <span>*</span></label>
                    <select name="penghuni_id" class="ci-select" required>
                        <option value="">-- Pilih Penghuni --</option>
                        @foreach($penghunis as $p)
                            <option value="{{ $p->id }}" {{ old('penghuni_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }} ({{ $p->no_rumah ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="ci-form-row">
                    <div class="ci-form-group">
                        <label class="ci-label"><i class="fas fa-calendar-alt me-1"></i> Bulan <span>*</span></label>
                        <select name="bulan" class="ci-select" required>
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $b)
                                <option value="{{ $b }}" {{ old('bulan') == $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ci-form-group">
                        <label class="ci-label"><i class="fas fa-calendar me-1"></i> Tahun <span>*</span></label>
                        <input type="number" name="tahun" class="ci-input"
                               value="{{ old('tahun', date('Y')) }}" required min="2020" max="2099">
                    </div>
                </div>

                <div class="ci-form-group">
                    <label class="ci-label"><i class="fas fa-money-bill-wave me-1"></i> Jumlah (Rp) <span>*</span></label>
                    <input type="number" name="jumlah" class="ci-input"
                           value="{{ old('jumlah') }}" placeholder="Contoh: 50000" required min="0">
                </div>

                <div class="ci-form-group">
                    <label class="ci-label"><i class="fas fa-tags me-1"></i> Jenis Iuran <span>*</span></label>
                    <select name="jenis_iuran" class="ci-select" required>
                        <option value="">-- Pilih Jenis Iuran --</option>
                        @foreach(['Kebersihan','Keamanan','Sosial','Operasional','Lainnya'] as $j)
                            <option value="{{ $j }}" {{ old('jenis_iuran') == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ci-form-group">
                    <label class="ci-label"><i class="fas fa-align-left me-1"></i> Keterangan</label>
                    <textarea name="keterangan" class="ci-textarea"
                              placeholder="Tambahkan keterangan jika diperlukan...">{{ old('keterangan') }}</textarea>
                </div>

                <div class="ci-btn-row">
                    <button type="submit" class="ci-btn ci-btn-primary">
                        <i class="fas fa-paper-plane"></i> Ajukan ke RT
                    </button>
                    <a href="{{ route('bendahara.iuran.index') }}" class="ci-btn ci-btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
