@extends('layouts.app')

@section('title', 'Daftar Tagihan Siswa')

@section('content')
<div class="container mt-4">

    <h4 class="mb-3">Daftar Tagihan Siswa</h4>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="mb-3">
                <strong>{{ auth()->user()->name }}</strong><br>
                <small>NIS: {{ auth()->user()->nis ?? '-' }}</small>
            </div>

            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Tagihan</th>
                        <th>Jatuh Tempo</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tagihan as $t)
                    @php
                        // fleksibel: bisa object atau array
                        $nama     = $t['nama_tagihan'] ?? $t->nama_tagihan ?? $t['nama'] ?? $t->nama ?? '-';
                        $tempo    = $t['jatuh_tempo'] ?? $t->jatuh_tempo ?? '-';
                        $nominal  = $t['nominal'] ?? $t->nominal ?? 0;
                        $status   = $t['status'] ?? $t->status ?? 'belum';
                        $id       = $t['id'] ?? $t->id ?? null;
                    @endphp

                    <tr>
                        <td>{{ $nama }}</td>
                        <td>{{ $tempo }}</td>
                        <td>Rp {{ number_format($nominal, 0, ',', '.') }}</td>

                        <td>
                            <span class="badge bg-{{ $status == 'belum' ? 'danger' : 'success' }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        <td>
                            @if ($status == 'belum' && $id)
                                <a href="{{ route('siswa.tagihan.bayar', $id) }}"
                                   class="btn btn-primary btn-sm">
                                    Bayar
                                </a>
                            @else
                                <span class="text-muted">Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Tidak ada tagihan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
