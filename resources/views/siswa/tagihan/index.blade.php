@extends('layouts.app')

@section('content')
<div style="padding:20px">

    {{-- PESAN SUKSES SETELAH BAYAR --}}
    @if (session('success'))
        <div style="
            background:#d4edda;
            padding:10px;
            margin-bottom:15px;
            color:#155724;
            border-radius:4px;
        ">
            {{ session('success') }}
        </div>
    @endif

    <h2>Daftar Tagihan Saya</h2>
    <p>Berikut adalah daftar tagihan Anda.</p>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tagihan</th>
                <th>Jatuh Tempo</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($tagihan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_tagihan }}</td>
                    <td>{{ $item->jatuh_tempo }}</td>
                    <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>
                        @if ($item->status == 'belum')
                            <span style="color:red;">Belum Dibayar</span>
                        @else
                            <span style="color:green;">Lunas</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->status == 'belum')
                            <a href="{{ route('siswa.tagihan.bayar', $item->id) }}">
                                <button>Bayar</button>
                            </a>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">
                        Belum ada tagihan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
