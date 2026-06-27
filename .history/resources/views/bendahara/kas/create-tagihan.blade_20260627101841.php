@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f0; }

.ct-wrapper { max-width: 600px; margin: 0 auto; padding: 28px 16px 60px; }

.ct-page-header {
    display: flex; align-items: center; gap: 14px; margin-bottom: 24px;
}
.ct-header-icon {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #065f46, #059669);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 19px; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(6,78,59,0.25);
}
.ct-page-header h1 { font-size: 20px; font-weight: 800; color: #1a2e1a; margin: 0; }
.ct-page-header p  { font-size: 12.5px; color: #8a9e8a; margin: 0; }

.ct-card {
    background: #fff; border-radius: 18px;
    border: 1px solid #e8f0e8;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
    overflow: hidden;
}
.ct-card-header {
    padding: 16px 22px; background: #f6fbf7;
    border-bottom: 1px solid #e8f0e8;
    display: flex; align-items: center; gap: 10px;
}
.ct-card-header-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: #d1fae5; color: #064e3b;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; flex-shrink: 0;
}
.ct-card-header h6 { font-size: 13.5px; font-weight: 700; color: #1a2e1a; margin: 0; }

.ct-card-body { padding: 22px; }

.ct-info-box {
    background: #eff6ff; border: 1px solid #bfdbfe;
    border-left: 4px solid #3b82f6;
    border-radius: 10px; padding: 11px 14px;
    font-size: 12.5px; color: #1e40af;
    margin-bottom: 22px; line-height: 1.5;
}

.ct-alert-error {
    background: #fdf0f0; border: 1px solid #f5a8a8;
    border-left: 4px solid #ef4444; border-radius: 10px;
    padding: 11px 14px; font-size: 13px; color: #7a1a1a;
    margin-bottom: 20px;
}

.ct-form-group { margin-bottom: 18px; }

.ct-label {
    display: block; font-size: 11.5px; font-weight: 700;
    color: #374151; text-transform: uppercase;
    letter-spacing: 0.5px; margin-bottom: 7px;
}
.ct-label span { color: #ef4444; margin-left: 2px; }

.ct-input, .ct-select, .ct-textarea {
    width: 100%; padding: 11px 14px;
    border: 1.5px solid #e0ede0; border-radius: 10px;
    font-size: 13.5px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1f2937; outline: none; background: #fafafa;
    transition: border-color 0.15s, box-shadow 0.15s;
    appearance: none; -webkit-appearance: none;
}
.ct-input:focus, .ct-select:focus, .ct-textarea:focus {
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5,150,105,0.10);
    background: #fff;
}
.ct-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 34px;
}

/* Prefix Rp */
.ct-input-group {
    display: flex; align-items: center;
    border: 1.5px solid #e0ede0; border-radius: 10px;
    background: #fafafa; overflow: hidden;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.ct-input-group:focus-within {
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5,150,105,0.10);
    background: #fff;
}
.ct-input-group-prefix {
    padding: 11px 12px; background: #f3f4f6;
    font-size: 13px; font-weight: 700; color: #6b7280;
    border-right: 1.5px solid #e0ede0; white-space: nowrap;
}
.ct-input-group input {
    flex: 1; padding: 11px 13px;
    border: none; outline: none; background: transparent;
    font-size: 13.5px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: #1f2937;
}

.ct-btn-row { display: flex; gap: 10px; margin-top: 6px; }
.ct-btn {
    flex: 1; padding: 12px; border: none; border-radius: 11px;
    font-size: 13.5px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    transition: opacity 0.15s, transform 0.1s; text-decoration: none;
}
.ct-btn:hover { opacity: 0.88; transform: translateY(-1px); text-decoration: none; }
.ct-btn:active { transform: translateY(0); }
.ct-btn-primary   { background: linear-gradient(135deg, #065f46, #059669); color: #fff; }
.ct-btn-secondary { background: #f3f4f6; color: #4b5563; flex: 0 0 auto; padding: 12px 18px; }

@media (max-width: 480px) {
    .ct-wrapper { padding: 20px 12px 48px; }
    .ct-card-body { padding: 16px; }
    .ct-btn-row { flex-direction: column; }
    .ct-btn-secondary { flex: 1; }
}
</style>

<div class="ct-wrapper">

    <div class="ct-page-header">
        <div class="ct-header-icon"><i class="fas fa-file-invoice"></i></div>
        <div>
            <h1>Buat Tagihan Kas</h1>
            <p>Kirim tagihan kas ke penghuni</p>
        </div>
    </div>

    <div class="ct-card">
        <div class="ct-card-header">
            <div class="ct-card-header-icon"><i class="fas fa-paper-plane"></i></div>
            <h6>Form Tagihan Kas ke Penghuni</h6>
        </div>

        <div class="ct-card-body">

            <div class="ct-info-box">
                <i class="fas fa-info-circle me-1"></i>
                Tagihan yang dikirim akan masuk ke dashboard penghuni dan perlu dikonfirmasi setelah dibayar.
            </div>

            @if($errors->any())
                <div class="ct-alert-error">
                    @foreach($errors->all() as $error)
                        <div><i class="fas fa-times-circle me-1"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('bendahara.kas.tagihan.store') }}" method="POST">
                @csrf

                <div class="ct-form-group">
                    <label class="ct-label"><i class="fas fa-user me-1"></i> Penghuni <span>*</span></label>
                    <select name="penghuni_id" class="ct-select" required>
                        <option value="">-- Pilih Penghuni --</option>
                        @foreach($penghunis as $p)
                            <option value="{{ $p->id }}" {{ old('penghuni_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }} ({{ $p->no_rumah ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="ct-form-group">
                    <label class="ct-label"><i class="fas fa-money-bill-wave me-1"></i> Jumlah <span>*</span></label>
                    <div class="ct-input-group">
                        <span class="ct-input-group-prefix">Rp</span>
                        <input type="number" name="jumlah" placeholder="0"
                               value="{{ old('jumlah') }}" required min="0">
                    </div>
                </div>

                <div class="ct-form-group">
                    <label class="ct-label"><i class="fas fa-align-left me-1"></i> Keterangan <span>*</span></label>
                    <input type="text" name="keterangan" class="ct-input"
                           placeholder="Misal: Kas sumbangan acara 17 Agustus"
                           value="{{ old('keterangan') }}" required>
                </div>

                <div class="ct-btn-row">
                    <button type="submit" class="ct-btn ct-btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Tagihan
                    </button>
                    <a href="{{ route('bendahara.kas.index') }}" class="ct-btn ct-btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
