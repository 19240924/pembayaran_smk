@extends('layouts.app')

@section('content')
<div style="padding:20px; max-width:600px; margin:auto;">
    <h2>Halaman Pembayaran</h2>

    <div style="border:1px solid #ddd; padding:15px; margin-top:15px;">
        <p>
            <strong>Nama Tagihan:</strong>
            {{ $tagihan->nama_tagihan }}
        </p>

        <p>
            <strong>Jatuh Tempo:</strong>
            {{ $tagihan->jatuh_tempo }}
        </p>

        <p>
            <strong>Nominal:</strong>
            Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}
        </p>

        <p>
            <strong>Status:</strong>
            <span style="color:red;">Belum Dibayar</span>
        </p>
    </div>

    <div style="margin-top:20px;">
        <form method="POST" action="{{ route('siswa.tagihan.proses', $tagihan->id) }}">
            @csrf

            <button type="submit" style="padding:10px 20px;">
                Konfirmasi Bayar
            </button>

            <a href="{{ route('siswa.tagihan.index') }}" style="margin-left:10px;">
                Kembali
            </a>
        </form>
    </div>
</div>
@endsection
