<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wardrobe extends Model
{
    use HasFactory;

    protected $primaryKey = 'WardrobeID';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_wardrobe', 'WardrobeID', 'UserID');
    }

    public function clothes()
    {
        return $this->hasMany(Cloth::class, 'WardrobeID', 'WardrobeID');
    }
}

