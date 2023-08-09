<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;
    protected $table = "angsuran";
    protected $fillable = ['jatuh_tempo','id_pinjaman','status_angsur','lama'];

    public function angsur() {
		return $this->belongsTo(Pinjaman::class, 'id_pinjaman');
	}
}
