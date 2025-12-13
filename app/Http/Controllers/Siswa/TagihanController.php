<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index()
    {
        // DATA DUMMY
        $tagihan = [
            (object)[
                'id' => 1,
                'nama_tagihan' => 'SPP Bulan Januari',
                'nominal' => 150000,
                'jatuh_tempo' => '2025-01-10',
            ],
            (object)[
                'id' => 2,
                'nama_tagihan' => 'SPP Bulan Februari',
                'nominal' => 150000,
                'jatuh_tempo' => '2025-02-10',
            ],
        ];

        // Ambil ID tagihan yang sudah dibayar dari session
        $sudahDibayar = session('tagihan_lunas', []);

        // Tambahkan status ke masing-masing tagihan
        foreach ($tagihan as $item) {
            $item->status = in_array($item->id, $sudahDibayar)
                ? 'lunas'
                : 'belum';
        }

        return view('siswa.tagihan.index', compact('tagihan'));
    }

    // Halaman bayar
    public function bayar($id)
    {
        $tagihan = (object) [
            'id' => $id,
            'nama_tagihan' => 'SPP Bulan Januari',
            'nominal' => 150000,
            'jatuh_tempo' => '2025-01-10',
            'status' => 'belum',
        ];

        return view('siswa.tagihan.bayar', compact('tagihan'));
    }

    // PROSES BAYAR → STATUS LUNAS
    public function prosesBayar($id)
    {
        // Ambil data lunas sebelumnya
        $lunas = session('tagihan_lunas', []);

        // Tambahkan ID yang baru dibayar
        if (!in_array($id, $lunas)) {
            $lunas[] = $id;
        }

        // Simpan kembali ke session
        session(['tagihan_lunas' => $lunas]);

        return redirect()
            ->route('siswa.tagihan.index')
            ->with('success', 'Pembayaran berhasil. Status tagihan menjadi LUNAS.');
    }
}
