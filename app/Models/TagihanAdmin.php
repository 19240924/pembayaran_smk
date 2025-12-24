<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagihanAdmin extends Model
{
    protected $table = 'tagihan_admins';

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'jurusan',
        'bulan',
        'tahun',
        'jenis_pembayaran',
        'nominal',
        'keterangan',
        'status',
    ];
}
