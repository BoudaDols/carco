<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'year', 'color', 'price', 
        'chassisNumber', 'description', 
        'categorie_id', 'brand_id'
    ];
    
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
