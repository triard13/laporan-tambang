<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LokasiTambang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_lokasi',
        'koordinat',
        'luas_area',
        'koordinator',
    ];
}