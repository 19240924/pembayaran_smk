<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * DETAIL TAGIHAN (BEDA TIAP JENIS)
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

        // pengaman kalau ID tidak ada
        if (!isset($data[$id])) {
            abort(404);
        }

        $tagihan = $data[$id];

        return view('siswa.tagihan.show', compact('tagihan'));
    }
}
