<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranPertanyaan extends Model
{
    protected $table = 'saran_pertanyaans';
    protected $fillable = ['pertanyaan', 'mahasiswa_id', 'ditangani_oleh', 'status'];

    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
