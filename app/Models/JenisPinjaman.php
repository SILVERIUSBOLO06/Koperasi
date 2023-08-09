<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPinjaman extends Model
{
    use HasFactory;
    protected $table = "jenis_pinjaman";
    protected $fillable = ['jenis_pinjaman','max','bunga','lama'];

    public function jenis() {
        return $this->hasOne(Pinjaman::class, 'id_jenis');
    }
}
