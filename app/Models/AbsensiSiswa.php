<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
    protected $table = 'absensi_siswa';
    protected $fillable = [
        'id_siswa',
        'id_guru',
        'id_jadwal',
        'tanggal',
        'tahun_ajaran',
        'id_keterangan_absensi'
    ];
    use HasFactory;
}
