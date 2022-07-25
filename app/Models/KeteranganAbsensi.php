<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeteranganAbsensi extends Model
{
    protected $table = 'keterangan_absensi';
    protected $fillable = [
        'keterangan'
    ];
    public $timestamps = false;
    use HasFactory;
}