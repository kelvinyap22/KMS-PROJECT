<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\User;

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
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

}
