<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlatTambang extends Model
{
    use SoftDeletes;

    protected $fillable = ['gambar',
    'kode_alat',
    'nama_alat',
    'tipe_alat',
    'kapasitas',
    'jam_kerja',
    'status'];

    public function produksiHarians()
    {
        return $this->hasMany(ProduksiHarian::class);
    }
}
