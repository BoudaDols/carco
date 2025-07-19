<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achat extends Model
{
    use HasFactory;

    public function cars(): BelongsTo{
        return $this->belongsTo(Car::class);
    }

    public function clients(): BelongsTo{
        return $this->belongsTo(Client::class);
    }
}
