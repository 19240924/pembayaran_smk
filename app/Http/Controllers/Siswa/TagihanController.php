<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TagihanAdmin;

class TagihanController extends Controller
{
    public function index()
    {
        // ambil nama siswa yang sedang login
        $namaSiswa = Auth::user()->name;

        // ambil tagihan milik siswa tersebut
        $tagihans = TagihanAdmin::where('nama_siswa', $namaSiswa)->get();

        return view('siswa.tagihan.index', compact('tagihans'));
    }
}
