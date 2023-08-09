<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;
    protected $table = "pinjaman";
    protected $fillable = ['no_pinjam','tgl_pengajuan','jum_pinjaman','status','tgl_terima','besar_angsuran','id_anggota','id_jenis'];

    public function user() {
		return $this->belongsTo(User::class, 'id_anggota');
	}

    public function jenis() {
		return $this->belongsTo(JenisPinjaman::class, 'id_jenis');
	}

    public function angsur() {
        return $this->hasOne(Angsuran::class, 'id_pinjaman');
    }
}
