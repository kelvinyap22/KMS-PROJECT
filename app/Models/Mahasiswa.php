<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas';
    protected $fillable = ['nrp'];

    public function saranPertanyaan() {
        return $this->hasMany(SaranPertanyaan::class, 'mahasiswa_id');
        }
}