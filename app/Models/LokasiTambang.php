<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiTambang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lokasi',
        'koordinat',
        'luas_area',
        'koordinator',
    ];
}