@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Daftar Pembayaran Menunggu Konfirmasi</h4>

    <div class="card mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Tagihan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($tagihan as $row)
                <tr>
                    <td>{{ $row->nama }}</td>
                    <td>Rp {{ number_format($row->total,0,',','.') }}</td>
                    <td>{{ $row->status }}</td>

                    <td>
                        <form method="POST"
                              action="{{ route('admin.tagihan.setStatus', [$row->id, 'Lunas']) }}"
                              style="display:inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Setujui</button>
                        </form>

                        <form method="POST"
                              action="{{ route('admin.tagihan.setStatus', [$row->id, 'Ditolak']) }}"
                              style="display:inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada pembayaran masuk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
