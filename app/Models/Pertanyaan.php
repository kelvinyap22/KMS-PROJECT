<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaans';
    protected $fillable = [
        'kategori_id', 'pertanyaan', 'jawaban', 'status', 
        'created_by', 'reviewed_by', 'reviewed_at', 'catatan_review'
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
