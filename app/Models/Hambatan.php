<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hambatan extends Model
{
    protected $fillable = ['produksi_harian_id', 'jenis_hambatan', 'durasi', 'keterangan'];

    public function produksiHarian()
    {
        return $this->belongsTo(ProduksiHarian::class);
    }
}
