<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public $name;
    public $year;
    public $color;
    public $price;
    public $description;

    public function __construct($name, $year, $color, $price, $description)
    {
        $this->name = $name;
        $this->year = $year;
        $this->color = $color;
        $this->price = $price;
        $this->description = $description;
    }

    /**
     * Get the car details.
     *
     * @return array
     */
    public function getDetails()
    {
        return [
            'name' => $this->name,
            'year' => $this->year,
            'color' => $this->color,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }

    /**
     * Set the car details.
     *
     * @param string $name
     * @param int $year
     * @param string $color
     * @param float $price
     * @param string $description
     */
    public function setDetails($name, $year, $color, $price, $description)
    {
        $this->name = $name;
        $this->year = $year;
        $this->color = $color;
        $this->price = $price;
        $this->description = $description;
    }

    /**
     * Update the car details.
     *
     * @param array $details
     */
    public function updateDetails($details)
    {
        $this->name = $details['name'] ?? $this->name;
        $this->year = $details['year'] ?? $this->year;
        $this->color = $details['color'] ?? $this->color;
        $this->price = $details['price'] ?? $this->price;
        $this->description = $details['description'] ?? $this->description;
    }

    
    public function categorie(): BelongsTo{
        return $this->belongsTo(Categorie::class);
    }

    public function brand(): BelongsTo{
        return $this->belongsTo(Brand::class);
    }
}
