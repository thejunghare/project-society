<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecretaryDetail extends Model
{
    use HasFactory;
    public function society(): BelongsTo
    {
        return $this->belongsTo(Societies::class, "");
    }
}
