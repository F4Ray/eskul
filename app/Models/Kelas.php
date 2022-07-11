<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = [
        'kode',
        'kelas',
        'rombel',
        'max_jumlah',
        'tahun_ajaran',
        'wali_kelas'
    ];
    use HasFactory;


    public function walikelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas', 'id');
    }
}