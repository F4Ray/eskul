<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSiswa extends Model
{    
    protected $table = 'nilai_siswa';
    protected $fillable = [
        'id_siswa',
        'id_jadwal',
        'id_guru',
        'semester',
        'tahun_ajaran',
        'kkm',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir'

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
    public function jadwal()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'id_jadwal');
    }
}
