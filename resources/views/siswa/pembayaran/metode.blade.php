@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Pilih Metode Pembayaran</h4>

    <div class="card p-3 mt-3">
        <form action="{{ route('siswa.pembayaran.proses', $tagihan->id) }}" method="POST">
            @csrf

            <p>Simulasi pembayaran — pilih metode lalu klik Bayar.</p>

            <button class="btn btn-primary">Bayar Sekarang</button>
        </form>
    </div>
</div>
@endsection
