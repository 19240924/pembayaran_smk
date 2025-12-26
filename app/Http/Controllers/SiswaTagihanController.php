<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan; // pastikan model ini ada

class SiswaTagihanController extends Controller
{
    /**
     * HALAMAN LIST TAGIHAN SISWA
     */
    public function index()
    {
        $tagihan = [
            [
                'id' => 1,
                'nama' => 'SPP',
                'jenis' => 'spp',
                'total' => 600000,
                'status' => 'Belum Lunas',
            ],
            [
                'id' => 2,
                'nama' => 'Uang Buku & Modul',
                'jenis' => 'modul',
                'total' => 500000,
                'status' => 'Belum Lunas',
            ],
            [
                'id' => 3,
                'nama' => 'Uang Bangunan',
                'jenis' => 'bangunan',
                'total' => 1250000,
                'status' => 'Belum Lunas',
            ],
        ];

        return view('siswa.tagihan.index', compact('tagihan'));
    }

    /**
     * HALAMAN DETAIL TAGIHAN
     */
    public function show($id)
    {
        $data = [
            1 => [
                'id' => 1,
                'nama' => 'SPP',
                'jenis' => 'spp',
                'total' => 600000,
                'rincian' => [
                    ['label' => 'Januari 2025', 'nominal' => 120000, 'status' => 'Belum Bayar'],
                    ['label' => 'Februari 2025', 'nominal' => 120000, 'status' => 'Belum Bayar'],
                    ['label' => 'Maret 2025', 'nominal' => 120000, 'status' => 'Belum Bayar'],
                    ['label' => 'April 2025', 'nominal' => 120000, 'status' => 'Belum Bayar'],
                    ['label' => 'Mei 2025', 'nominal' => 120000, 'status' => 'Belum Bayar'],
                ],
            ],

            2 => [
                'id' => 2,
                'nama' => 'Uang Buku & Modul',
                'jenis' => 'modul',
                'total' => 500000,
                'rincian' => [
                    [
                        'label' => 'Pembayaran Modul Pembelajaran Tahun 2025',
                        'nominal' => 500000,
                        'status' => 'Belum Bayar',
                    ],
                ],
            ],

            3 => [
                'id' => 3,
                'nama' => 'Uang Bangunan',
                'jenis' => 'bangunan',
                'total' => 1250000,
                'rincian' => [
                    [
                        'label' => 'Juni 2025',
                        'nominal' => 1250000,
                        'status' => 'Belum Bayar',
                    ],
                ],
            ],
        ];

        if (!isset($data[$id])) {
            abort(404);
        }

        $tagihan = $data[$id];

        return view('siswa.tagihan.show', compact('tagihan'));
    }

    /**
     * PILIH METODE PEMBAYARAN
     */
    public function pilihMetode($id)
    {
        $tagihan = collect([
            1 => ['id' => 1, 'nama' => 'SPP', 'total' => 600000],
            2 => ['id' => 2, 'nama' => 'Uang Buku & Modul', 'total' => 500000],
            3 => ['id' => 3, 'nama' => 'Uang Bangunan', 'total' => 1250000],
        ])->get($id);

        if (!$tagihan) {
            abort(404);
        }

        return view('siswa.pembayaran.metode', compact('tagihan'));
    }

    /**
     * ⬅️ UPDATED — PROSES PEMBAYARAN → MENUNGGU KONFIRMASI ADMIN
     */
    public function prosesPembayaran($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        // setelah siswa menekan bayar → masuk antrean admin
        $tagihan->status = 'Menunggu Konfirmasi';
        $tagihan->save();

        return redirect()
            ->route('siswa.tagihan.index')
            ->with('success', 'Pembayaran dikirim. Menunggu konfirmasi admin.');
    }

    /**
     * HALAMAN METODE (VERSI DATABASE)
     */
    public function metode($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        return view('siswa.pembayaran.metode', compact('tagihan'));
    }

    /**
     * PROSES MANUAL (OPSIONAL — MASIH BOLEH ADA)
     */
    public function proses($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        $tagihan->status = 'Menunggu Konfirmasi';
        $tagihan->save();

        return redirect()
            ->route('siswa.tagihan.show', $id)
            ->with('success', 'Pembayaran berhasil dikirim, menunggu konfirmasi admin.');
    }
}
