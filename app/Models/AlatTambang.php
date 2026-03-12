<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatTambang extends Model
{
    protected $fillable = ['nama_alat', 'tipe_alat', 'kapasitas'];

    public function produksiHarians()
    {
        return $this->hasMany(ProduksiHarian::class);
    }
}
