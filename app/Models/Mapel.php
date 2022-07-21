<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $fillable = [
        'kode',
        'nama',
        'kelas',
        'kkm'

    ];
    use HasFactory;

    /**
     * The guru that belong to the Mapel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_mapel', 'mapel_id', 'guru_id');
    }
}