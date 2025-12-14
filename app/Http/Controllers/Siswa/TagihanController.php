<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TagihanAdmin;

class TagihanController extends Controller
{
    /**
     * Tampilkan daftar tagihan siswa (AMBIL DARI DATABASE)
     */
    public function index()
    {
        // Ambil semua tagihan (nanti bisa difilter per siswa)
        $tagihan = TagihanAdmin::orderBy('created_at', 'desc')->get();

        return view('siswa.tagihan.index', compact('tagihan'));
    }

    /**
     * Halaman bayar tagihan
     */
    public function bayar($id)
    {
        $tagihan = TagihanAdmin::findOrFail($id);

        return view('siswa.tagihan.bayar', compact('tagihan'));
    }

    /**
     * PROSES KONFIRMASI BAYAR
     */
    public function prosesBayar($id)
    {
        $tagihan = TagihanAdmin::findOrFail($id);

        // Update status jadi LUNAS
        $tagihan->update([
            'status' => 'lunas'
        ]);

        return redirect()
            ->route('siswa.tagihan.index')
            ->with('success', 'Pembayaran berhasil dilakukan');
    }
}
