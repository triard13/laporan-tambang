<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduksiHarian extends Model
{
    protected $fillable = [
        'user_id', 'alat_tambang_id', 'tanggal', 'shift', 'material', 
        'volume', 'jarak_angkut', 'jam_operasi', 'lokasi', 'bahan_bakar', 'cuaca', 
        'hambatan_operasional', 'catatan_tambahan', 'status_laporan'
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
