<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'aksi', 'modul', 'detail'];

    // Relasi ke tabel pengguna
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}