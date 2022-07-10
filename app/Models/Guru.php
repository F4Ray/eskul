<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mapel;

class Guru extends Model
{
    protected $table = 'guru';
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'foto',
        'id_mata_pelajaran'

    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_profile');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mata_pelajaran', 'id');
    }
    /**
     * Get the user that owns the Guru
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'nip', 'id_profile');
    // }
}