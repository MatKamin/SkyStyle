<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cloth extends Model
{
    use HasFactory;
    protected $fillable = [
        'Picture', 'Description', 'LinkToBuy', 'Title', 'type_id', 'wardrobe_id'
    ];

    protected $primaryKey = 'ClothID';
    protected $table = 'clothes';

    public function type()
    {
        return $this->belongsTo(Type::class, 'TypeID', 'TypeID');
    }

    public function wardrobe()
    {
        return $this->belongsTo(Wardrobe::class, 'WardrobeID', 'WardrobeID');
    }
}
