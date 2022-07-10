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
}