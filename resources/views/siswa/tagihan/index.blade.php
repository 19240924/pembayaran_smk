@extends('layouts.app')

@section('content')
<div style="padding:20px">

    {{-- PESAN SUKSES --}}
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
        <thead style="background:#f1f1f1">
            <tr>
                <th>No</th>
                <th>Jenis Pembayaran</th>
                <th>Periode</th>
                <th>Nominal</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($tagihans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    {{-- Jenis Pembayaran --}}
                    <td>{{ $item->jenis_pembayaran }}</td>

                    {{-- Periode --}}
                    <td>{{ $item->bulan }} {{ $item->tahun }}</td>

                    {{-- Nominal --}}
                    <td>
                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </td>

                    {{-- Status --}}
                    <td>
                        @if ($item->status === 'lunas')
                            <span style="color:green; font-weight:bold;">
                                Lunas
                            </span>
                        @else
                            <span style="color:red; font-weight:bold;">
                                Belum Lunas
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:15px;">
                        Belum ada tagihan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
