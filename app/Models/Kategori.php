<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $fillable = ['nama', 'deskripsi'];

    public function pertanyaans() {
        return $this->hasMany(Pertanyaan::class, 'kategori_id');
    }
}
