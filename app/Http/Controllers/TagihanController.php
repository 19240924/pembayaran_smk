<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TagihanAdmin;

class TagihanController extends Controller
{
    /**
     * Tampilkan daftar tagihan (ADMIN)
     */
    public function index()
    {
        // Ambil data dari tabel tagihan_admins
        $tagihans = TagihanAdmin::latest()->paginate(10);

        return view('admin.tagihan.index', compact('tagihans'));
    }

    /**
     * Form tambah tagihan (ADMIN)
     */
    public function create()
    {
        return view('admin.tagihan.create');
    }

    /**
     * Simpan tagihan ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_siswa' => 'required|string',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
            'bulan' => 'required|string',
            'jenis_pembayaran' => 'required|string',
            'nominal' => 'required|numeric',
        ]);

        // Simpan ke database
        TagihanAdmin::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun ?? date('Y'),
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'status' => 'belum_lunas',
        ]);

        return redirect()
            ->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil dibuat!');
    }
}
