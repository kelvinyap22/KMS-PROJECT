<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    
    protected $fillable = [
        'nama',
    ];

    /**
     * Relasi balik ke model User (One to Many)
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}