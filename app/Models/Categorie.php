<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function cars() : HasMany
    {
        return $this->hasMany(Car::class);
    }
}
