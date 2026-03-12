<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduksiHarian extends Model
{
    protected $fillable = [
        'user_id', 'alat_tambang_id', 'tanggal', 'material', 
        'volume', 'jam_operasi', 'lokasi', 'bahan_bakar', 'status_laporan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alatTambang()
    {
        return $this->belongsTo(AlatTambang::class);
    }

    public function hambatans()
    {
        return $this->hasMany(Hambatan::class);
    }

    public function validasis()
    {
        return $this->hasMany(Validasi::class);
    }
}
