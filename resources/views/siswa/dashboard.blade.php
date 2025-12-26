@extends('layouts.app')

@section('title','Dashboard Siswa')

@section('content')

<style>
/* ====== STYLE DASHBOARD ====== */

body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.header-welcome h1{font-size:32px;margin-bottom:5px;color:#fff}
.header-welcome p{opacity:.9;color:#fff}

/* Cards */
.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:18px;
    margin:20px 0 25px;
}

.stat-card{
    padding:22px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
    color:white;
}

.yellow{background:linear-gradient(135deg,#fbc531,#f39c12)}
.green{background:linear-gradient(135deg,#4cd137,#27ae60)}
.red{background:linear-gradient(135deg,#ee5a6f,#e74c3c)}

.content-card{
    background:white;
    border-radius:15px;
    padding:25px;
    color:#333;
}

/* Table */
.table-tagihan td,.table-tagihan th{padding:12px}
.table-tagihan th{background:#f8f9fa;text-transform:uppercase;font-size:12px}
.empty-state{text-align:center;padding:35px;color:#999}
</style>

{{-- ========== MAIN CONTENT (NO SIDEBAR DI SINI) ========== --}}

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px">

    <div class="header-welcome">
        <h1>Selamat datang! 👋</h1>
        <p>Tanggal: {{ now()->format('d-m-Y') }}</p>
    </div>

    <div class="user-info" 
         style="background:rgba(255,255,255,.25); padding:10px 18px; border-radius:40px;
                display:flex; align-items:center; gap:10px; color:#fff; font-weight:600">

        <div class="user-avatar"
             style="width:36px;height:36px;background:#fff;border-radius:50%;
                    display:flex;align-items:center;justify-content:center;
                    color:#667eea;font-weight:bold">
            {{ strtoupper(substr(Auth::user()->name,0,2)) }}
        </div>

        <div style="line-height:1.1">
            <div style="font-size:14px">{{ Auth::user()->name }}</div>
            <div style="font-size:11px;opacity:.8">Siswa</div>
        </div>

    </div>

</div>

{{-- STATISTICS --}}
<div class="stats-grid">

    <div class="stat-card yellow">
        <div>Total Tagihan</div>
        <h2>Rp {{ number_format($tagihans->sum('jumlah'),0,',','.') }}</h2>
        <small>Semua tagihan</small>
    </div>

    <div class="stat-card green">
        <div>Lunas</div>
        <h2>{{ $tagihans->where('status','Lunas')->count() }} Tagihan</h2>
        <small>Sudah dibayar</small>
    </div>

    <div class="stat-card red">
        <div>Belum Lunas</div>
        <h2>{{ $tagihans->where('status','!=','Lunas')->count() }} Tagihan</h2>
        <small>Menunggu pembayaran</small>
    </div>
</div>

{{-- CARD TAGIHAN --}}
<div class="content-card">

    {{-- HEADER CARD + BADGE --}}
    <div class="card-header">
        <h2 class="card-title">📋 Daftar Tagihan Saya</h2>

        @if(!$tagihans->count())
            <div class="info-badge">⚠️ Belum ada tagihan</div>
        @endif
    </div>

    {{-- JIKA ADA DATA --}}
    @if ($tagihans->count())

        <table class="table-tagihan" width="100%">
            <thead>
                <tr>
                    <th>Nama Tagihan</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($tagihans as $t)
                <tr>
                    <td>{{ $t->nama_tagihan }}</td>
                    <td>Rp {{ number_format($t->jumlah,0,',','.') }}</td>
                    <td>{{ $t->status }}</td>

                    <td>
                        @if($t->status != 'Lunas')
                            <a href="{{ route('siswa.pembayaran.metode',$t->id) }}"
                               class="btn btn-primary btn-sm">
                               Bayar
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    {{-- JIKA KOSONG --}}
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <h3>Belum Ada Tagihan</h3>
            <p>Saat ini Anda tidak memiliki tagihan yang perlu dibayar</p>
        </div>
    @endif

</div>

<div style="margin-top: 20px; background: #fff3cd; padding: 15px; border-radius: 10px; color: #856404; border-left: 4px solid #ffc107;">
    <strong>⚠️ Informasi:</strong> Sesi Anda akan berakhir setelah 2 jam tidak ada aktivitas. Silakan login kembali untuk melanjutkan.
</div>

@endsection
