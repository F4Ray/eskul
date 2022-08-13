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

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
    public function keterangan()
    {
        return $this->belongsTo(KeteranganAbsensi::class, 'id_keterangan_absensi');
    }
    public function jadwal()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'id_jadwal');
    }
}
