@extends('layouts.app')

@section('title', 'Detail Tagihan')

@section('content')
<div class="container mt-4">

    <a href="{{ route('siswa.tagihan.index') }}" class="btn btn-secondary mb-3">
        ← Kembali
    </a>

    <div class="card">
        <div class="card-header">
            <strong>Detail Tagihan</strong>
        </div>

        <div class="card-body">

            <h5 class="mb-3">{{ $tagihan->nama }}</h5>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Periode Tagihan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tagihan->rincian as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->label }}</td>
                        <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td>
                            @if ($item->status === 'Belum Dibayar')
                                <span class="badge bg-warning text-dark">Belum Dibayar</span>
                            @else
                                <span class="badge bg-success">Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="alert alert-info mt-3">
                <strong>Total Tagihan:</strong>
                Rp {{ number_format($tagihan->total, 0, ',', '.') }}
            </div>

            <a href="{{ route('siswa.tagihan.metode', $tagihan->id) }}"
               class="btn btn-primary">
                Bayar Sekarang
            </a>

            <small class="text-muted d-block mt-3">
                *Fitur pembayaran online masih tahap simulasi
            </small>

        </div>
    </div>

</div>
@endsection
