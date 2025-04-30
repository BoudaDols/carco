<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public $model;
    public $year;
    public $color;
    public $price;
    public $description;

    public function __construct($model, $year, $color, $price, $description)
    {
        $this->model = $model;
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
            'model' => $this->model,
            'year' => $this->year,
            'color' => $this->color,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }

    /**
     * Set the car details.
     *
     * @param string $model
     * @param int $year
     * @param string $color
     * @param float $price
     * @param string $description
     */
    public function setDetails($model, $year, $color, $price, $description)
    {
        $this->model = $model;
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
        $this->model = $details['model'] ?? $this->model;
        $this->year = $details['year'] ?? $this->year;
        $this->color = $details['color'] ?? $this->color;
        $this->price = $details['price'] ?? $this->price;
        $this->description = $details['description'] ?? $this->description;
    }

    
    public function categorie(): BelongsTo{
        return $this->belongsTo(Categorie::class);
    }
}
