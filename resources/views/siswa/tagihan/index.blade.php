@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Daftar Tagihan Saya</h4>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tagihan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tagihan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $item['nama'] }} <br>

                            {{-- PERIODE (opsional, tidak bikin error) --}}
                            @if (!empty($item['periode']))
                                <small class="text-muted">
                                    Periode: {{ $item['periode'] }}
                                </small>
                            @endif
                        </td>

                        <td>
                            Rp {{ number_format($item['total'], 0, ',', '.') }}
                        </td>

                        <td>
                            <span class="badge bg-danger">
                                {{ $item['status'] }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('siswa.tagihan.show', $item['id']) }}"
                               class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
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
