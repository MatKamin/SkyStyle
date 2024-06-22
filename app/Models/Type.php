<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'Title',
        'Description',
        'Temperature_min',
        'Temperature_max',
        'isRainOkay',
        'ParentTypeID',
        'LayerUnderID'
    ];

    protected $primaryKey = 'TypeID';

    // Define the relationship with BodyPart model
    public function bodyPart()
    {
        return $this->belongsTo(BodyPart::class, 'LayerUnderID');
    }

    // Define the relationship with itself to represent hierarchical types
    public function parentType()
    {
        return $this->belongsTo(Type::class, 'ParentTypeID');
    }

    public function childTypes()
    {
        return $this->hasMany(Type::class, 'ParentTypeID');
    }

    // Define the relationship with Cloth model
    public function clothes()
    {
        return $this->hasMany(Cloth::class, 'TypeID');
    }
}
