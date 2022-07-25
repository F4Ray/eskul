<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiGuru extends Model
{
    protected $table = 'absensi_guru';
    protected $fillable = [
        'id_guru',
        'tanggal',
        'semester',
        'id_keterangan_absensi'
    ];

    /**
     * Get the keterangan associated with the AbsensiGuru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function keterangan()
    {
        return $this->belongsTo(KeteranganAbsensi::class, 'id_keterangan_absensi');
    }

    /**
     * Get the guru that owns the AbsensiGuru
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
    use HasFactory;
}
