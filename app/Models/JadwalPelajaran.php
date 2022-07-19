<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    protected $table = 'jadwal_pelajaran';
    protected $fillable = [
        'id_kelas',
        'semester',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'id_mata_pelajaran',
        'tahun_ajaran',
        'id_guru'
    ];
    use HasFactory;

    /**
     * Get the user that owns the JadwalPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    /**
     * Get the user that owns the JadwalPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mata_pelajaran');
    }
    /**
     * Get the guru that owns the JadwalPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}