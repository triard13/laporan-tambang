<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validasi extends Model
{
    protected $fillable = ['produksi_harian_id', 'user_id', 'tanggal_validasi', 'status_validasi', 'catatan'];

    public function produksiHarian()
    {
        return $this->belongsTo(ProduksiHarian::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // User yang bertindak sebagai Supervisor
    }
}
