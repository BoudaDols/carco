<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $name;
    public $origin;

    public function __construct($name, $origin)
    {
        $this->name = $name;
        $this->origin = $origin;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getOrigin()
    {
        return $this->origin;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }

    public function getBrandInfo()
    {
        return "Brand: " . $this->name . ", Origin: " . $this->origin;
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
